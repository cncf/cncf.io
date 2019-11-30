<?php

namespace Wpai\App\UnsecuredController;


use Wpai\Http\Request;
use Wpai\Scheduling\Import;
use Wpai\Http\JsonResponse;

class SchedulingController
{
    /** Scheduling API Version */
    const VERSION = 1;

    /** @var Import */
    private $scheduledImportService;

    /** @var callable */
    private $logger;

    public function __construct($container)
    {
        $this->scheduledImportService = new Import();
        $this->logger = function($m) {
            printf("<div class='progress-msg'>[%s] $m</div>\n", date("H:i:s"));
        };
    }

    public function triggerAction(Request $request)
    {
        if (!$this->isRequestValid()) {
            return new JsonResponse(array('message' => 'Import hash is invalid'), 401);
        }

        $importId = intval($request->get('import_id'));

        $import = new \PMXI_Import_Record();
        $import->getById($importId);

        if ($import->isEmpty()) {
            return new JsonResponse(array('message' => 'Import not found'), 404);
        }

        if ((int)$import->executing) {
            return new JsonResponse(array("message" => "Import #" . $import->id . " is currently in manually process. Request skipped."), 409);
        }
        if ($import->processing and !$import->triggered) {
            return new JsonResponse(array("message" => "Import #" . $import->id . " currently in process. Request skipped."), 409);

        }
        if (!$import->processing and $import->triggered) {
            return new JsonResponse(array("message" => "Import #" . $import->id . " already triggered. Request skipped."), 409);
        }

        if (!$import->processing and !$import->triggered) {
            $this->scheduledImportService->trigger($import);

            return new JsonResponse(array('message' => "#" . $import->id . " Cron job triggered."));
        }

        return new JsonResponse(array("message" => "Can't process"), 500);
    }

    public function processAction(Request $request)
    {
        if (!$this->isRequestValid()) {
            return new JsonResponse(array('message' => 'Import hash is invalid'), 401);
        }

        $importId = intval($request->get('import_id'));

        $import = new \PMXI_Import_Record();
        $import->getById($importId);

        if ($import->isEmpty()) {
            return new JsonResponse(array('message' => 'Import not found'), 404);
        }

        if ($import->processing == 1 and (time() - strtotime($import->registered_on)) > 120) {
            // it means processor crashed, so it will reset processing to false, and terminate. Then next run it will work normally.
            $import->set(array(
                'processing' => 0
            ))->update();
        }

        // start execution imports that is in the cron process
        if (!(int)$import->triggered) {
            if (!empty($import->parent_id) or empty($queue_exports)) {
                return new JsonResponse(array("message" => 'Import #' . $importId . ' is not triggered. Request skipped.'), 400);
            }
        } elseif ((int)$import->executing) {
            return new JsonResponse(array('message' => 'Import #' . $importId . ' is currently in manually process. Request skipped.'), 409);
        } elseif ((int)$import->triggered and !(int)$import->processing) {

            $response = $this->scheduledImportService->process($import, $this->logger);

            if ( ! empty($response) and is_array($response)){
                if($response == array(
                    'status'     => 200,
                    'message'    => sprintf(__('Import #%s complete', 'wp_all_import_plugin'),$importId)
                )) {
                    return new JsonResponse(array('Import #' . $importId . ' complete'), 201);
                } else {
                    wp_send_json($response);
                }
            }
            elseif ( ! (int) $import->queue_chunk_number ){
                return new JsonResponse(array('Import #' . $importId . ' complete'), 201);
            }
            else{
                return new JsonResponse(array('message' => 'Records Processed ' . (int)$import->imported . '.'));

            }

        } else {
            return new JsonResponse(array('message' => 'Import #' . $importId . ' already processing. Request skipped.'), 409);
        }

        return new JsonResponse(array("message" => "Can't process"), 500);
    }

    public function versionAction()
    {
        return new JsonResponse(array('version' => self::VERSION));
    }

    /**
     * @return bool
     */
    private function isRequestValid()
    {
        $cron_job_key = \PMXI_Plugin::getInstance()->getOption('cron_job_key');

        return
            !empty($cron_job_key) and
            !empty($_GET['import_id']) and
            !empty($_GET['import_key']) and
            $_GET['import_key'] == $cron_job_key;
    }

}