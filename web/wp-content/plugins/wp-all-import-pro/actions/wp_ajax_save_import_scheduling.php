<?php

use Wpai\Scheduling\Scheduling;

/**
 * @throws Exception
 */
function pmxi_wp_ajax_save_import_scheduling()
{

    if ( ! check_ajax_referer( 'wp_all_import_secure', 'security', false )){
        exit( json_encode(array('html' => __('Security check', 'wp_all_import_plugin'))) );
    }

    if ( ! current_user_can( PMXI_Plugin::$capabilities ) ){
        exit( json_encode(array('html' => __('Security check', 'wp_all_import_plugin'))) );
    }

    $elementId = $_POST['element_id'];

    $post = $_POST;

    foreach($post['scheduling_times'] as $schedulingTime) {
        if(!preg_match('/^(0?[1-9]|1[012])(:[0-5]\d)[APap][mM]$/', $schedulingTime) && $schedulingTime != '') {
            header('HTTP/1.1 400 Bad request', true, 400);
            die('Invalid times provided');
        }
    }

    try{
        $scheduling = Scheduling::create();
        $scheduling->handleScheduling($elementId, $post);
    } catch (\Wpai\Scheduling\Exception\SchedulingHttpException $e) {
        header('HTTP/1.1 503 Service unavailable', true, 503);
        echo json_encode(array('success' => false));

        die;
    }

    $import = new PMXI_Import_Record();
    $import->getbyId($elementId);
    $import->set(array('options' => array_merge($import->options, $post)));
    $import->save();

    echo json_encode(array('success' => true));
    die;
}
