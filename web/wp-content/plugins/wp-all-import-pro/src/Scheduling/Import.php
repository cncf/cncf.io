<?php

namespace Wpai\Scheduling;


class Import
{

    /**
     * @param $logger
     * @return mixed
     */
    function process($import, $logger)
    {
        $log_storage = (int)\PMXI_Plugin::getInstance()->getOption('log_storage');

        // unlink previous logs
        if ((int)$import->imported + (int)$import->skipped <= (int)$import->count) {
            // Try to find existing cron processing logs.
            $history_log = FALSE;
            $by = array();
            $by[] = array(array('import_id' => $import->id), 'AND');
            $historyLogs = new \PMXI_History_List();
            $historyLogs->setColumns('id', 'import_id', 'type', 'date')->getBy($by, 'id DESC');
            if ($historyLogs->count()) {
                foreach ($historyLogs as $i => $file) {
                    $history_log = new \PMXI_History_Record();
                    $history_log->getBy('id', $file['id']);
                    if (!$history_log->isEmpty() and $history_log->type !== 'processing') {
                        $history_log = FALSE;
                    }
                    break;
                }
            }

            $by = array();
            $by[] = array(array('import_id' => $import->id), 'AND');
            $historyLogs = new \PMXI_History_List();
            $historyLogs->setColumns('id', 'import_id', 'type', 'date')->getBy($by, 'id ASC');
            if ($historyLogs->count() and $historyLogs->count() >= $log_storage) {
                $logsToRemove = $historyLogs->count() - $log_storage;
                foreach ($historyLogs as $i => $file) {
                    $historyRecord = new \PMXI_History_Record();
                    $historyRecord->getBy('id', $file['id']);
                    if (!$historyRecord->isEmpty()) $historyRecord->delete(); // unlink history file only
                    if ($i == $logsToRemove)
                        break;
                }
            }

            if (!$history_log) {
                $history_log = new \PMXI_History_Record();
                $history_log->set(array(
                    'import_id' => $import->id,
                    'date' => date('Y-m-d H:i:s'),
                    'type' => 'processing',
                    'summary' => __("cron processing", "wp_all_import_plugin")
                ))->save();
            }

            if ($log_storage) {
                $wp_uploads = wp_upload_dir();
                $log_file = wp_all_import_secure_file($wp_uploads['basedir'] . DIRECTORY_SEPARATOR . \PMXI_Plugin::LOGS_DIRECTORY, $history_log->id) . DIRECTORY_SEPARATOR . $history_log->id . '.html';
                //if (@file_exists($log_file)) wp_all_import_remove_source($log_file, false);
            }
        }

        ob_start();

        $response = $import->set(array('canceled' => 0, 'failed' => 0))->execute($logger, true, $history_log->id);

        $log_data = ob_get_clean();

        if ($log_storage) {
            $log = @fopen($log_file, 'a+');
            @fwrite($log, $log_data);
            @fclose($log);
        }
        return $response;
    }

    /**
     * @param $import
     * @return \PMXI_History_Record
     */
    function trigger($import)
    {
        $import->set(array(
            'triggered' => 1,
            'imported' => 0,
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'deleted' => 0,
            'queue_chunk_number' => 0,
            'last_activity' => date('Y-m-d H:i:s')
        ))->update();

        $history_log = new \PMXI_History_Record();
        $history_log->set(array(
            'import_id' => $import->id,
            'date' => date('Y-m-d H:i:s'),
            'type' => 'trigger',
            'summary' => __("triggered by cron", "wp_all_import_plugin")
        ))->save();
        return $history_log;
    }
}