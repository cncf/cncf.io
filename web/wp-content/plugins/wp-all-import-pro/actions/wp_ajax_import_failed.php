<?php
function pmxi_wp_ajax_import_failed(){

	if ( ! check_ajax_referer( 'wp_all_import_secure', 'security', false )){
		exit( json_encode(array('result' => false, 'msg' => __('Security check', 'wp_all_import_plugin'))) );
	}

	if ( ! current_user_can( PMXI_Plugin::$capabilities ) ){
		exit( json_encode(array('result' => false, 'msg' => __('Security check', 'wp_all_import_plugin'))) );
	}

    $result = false;
	if (!empty($_POST['id'])) {
        $import = new PMXI_Import_record();
        $import->getbyId($_POST['id']);
        if ( ! $import->isEmpty()) {
            $import->set(array(
                'executing' => 0,
                'last_activity' => date('Y-m-d H:i:s'),
                'failed' => 1,
                'failed_on' => date('Y-m-d H:i:s')
            ))->save();
            $result = true;
            do_action('pmxi_import_failed', $_POST['id']);
        }
    }
	exit( json_encode( array('result' => $result)));
}