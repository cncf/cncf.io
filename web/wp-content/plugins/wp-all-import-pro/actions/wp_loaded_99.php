<?php

function pmxi_wp_loaded_99() {

	// Automatic Scheduling and other WPAI Public API requests.
	if ( isset( $_GET['action'] ) && $_GET['action'] == 'wpai_public_api' ) {
		$router = new \Wpai\Http\Router();
		$router->route( $_GET['q'], false );
	}

	// Clean up *pmxi_posts database table only when requests are likely intended for WPAI.
	if ( isset( $_GET['import_key'] ) || isset( $_GET['action'] ) || isset( $_GET['check_connection'] ) ) {

		global $wpdb;
		$table   = PMXI_Plugin::getInstance()->getTablePrefix() . 'imports';
		$imports = $wpdb->get_results( "SELECT `id`, `name`, `path` FROM $table WHERE `path` IS NULL", ARRAY_A );

		if ( ! empty( $imports ) ) {

			$importRecord = new PMXI_Import_Record();
			$importRecord->clear();
			foreach ( $imports as $imp ) {
				$importRecord->getById( $imp['id'] );
				if ( ! $importRecord->isEmpty() ) {
					$importRecord->delete( true );
				}
				$importRecord->clear();
			}
		}
	}

	// Check connection
	if ( ! empty( $_GET['check_connection'] ) ) {
		exit( json_encode( array( 'success' => true ) ) );
	}

	// Manual Scheduling/Cron
	if ( ! empty( $_GET['action'] ) && ! empty( $_GET['import_key'] ) && in_array( $_GET['action'], array(
			'processing',
			'trigger',
			'pipe',
			'cancel',
			'cleanup'
		) ) ) {

		/* Confirm cron import key, then execute import */
		$cron_job_key = PMXI_Plugin::getInstance()->getOption( 'cron_job_key' );

		if ( ! empty( $cron_job_key ) && $_GET['import_key'] == $cron_job_key ) {

			$logger = function ( $m ) {
				print( "<p>[" . date( "H:i:s" ) . "] $m</p>\n" );
			};

			if ( empty( $_GET['import_id'] ) ) {
				if ( $_GET['action'] == 'cleanup' ) {
					$settings = new PMXI_Admin_Settings();
					$settings->cleanup( true );
					wp_send_json( array(
						'status'  => 200,
						'message' => __( 'Cleanup completed.', 'wp_all_import_plugin' )
					) );

					return;
				}
				wp_send_json( array(
					'status'  => 403,
					'message' => __( 'Missing import ID.', 'wp_all_import_plugin' )
				) );

				return;
			}

			$import = new PMXI_Import_Record();

			$ids = explode( ',', $_GET['import_id'] );

			if ( ! empty( $ids ) and is_array( $ids ) ) {

				foreach ( $ids as $id ) {
					if ( empty( $id ) ) {
						continue;
					}

					$import->getById( $id );

					if ( ! $import->isEmpty() ) {

						if ( ! empty( $_GET['sync'] ) ) {
							$imports = $wpdb->get_results( "SELECT `id`, `name`, `path` FROM $table WHERE `processing` = 1", ARRAY_A );
							if ( ! empty( $imports ) ) {
								$processing_ids = array();
								foreach ( $imports as $imp ) {
									$processing_ids[] = $imp['id'];
								}
								wp_send_json( array(
									'status'  => 403,
									'message' => sprintf( __( 'Other imports are currently in process [%s].', 'wp_all_import_plugin' ), implode( ",", $processing_ids ) )
								) );
								break;
							}
						}

						if ( ! in_array( $import->type, array( 'url', 'ftp', 'file' ) ) ) {
							wp_send_json( array(
								'status'  => 500,
								'message' => sprintf( __( 'Scheduling update is not working with "upload" import type. Import #%s.', 'wp_all_import_plugin' ), $id )
							) );
						}

						switch ( $_GET['action'] ) {

							case 'trigger':

								if ( (int) $import->executing ) {

									wp_send_json( array(
										'status'  => 403,
										'message' => sprintf( __( 'Import #%s is currently in manually process. Request skipped.', 'wp_all_import_plugin' ), $id )
									) );
								} elseif ( ! $import->processing and ! $import->triggered ) {

									$scheduledImport = new \Wpai\Scheduling\Import();

									$history_log = $scheduledImport->trigger( $import );

									wp_send_json( array(
										'status'  => 200,
										'message' => sprintf( __( '#%s Cron job triggered.', 'wp_all_import_plugin' ), $id )
									) );

								} elseif ( $import->processing and ! $import->triggered ) {
									wp_send_json( array(
										'status'  => 403,
										'message' => sprintf( __( 'Import #%s currently in process. Request skipped.', 'wp_all_import_plugin' ), $id )
									) );
								} elseif ( ! $import->processing and $import->triggered ) {

									wp_send_json( array(
										'status'  => 403,
										'message' => sprintf( __( 'Import #%s already triggered. Request skipped.', 'wp_all_import_plugin' ), $id )
									) );
								}

								break;

							case 'processing':

								// check the maximum amount of time we should wait before assuming the iteration failed
								$max_wait = ini_get( 'max_execution_time' );

								$max_wait = $max_wait > 0 ? $max_wait : 1200; // failsafe max_wait should be high enough to avoid falsely marking as failed

								if ( $import->processing == 1 and ( time() - strtotime( $import->registered_on ) ) > $max_wait ) { // it means processor crashed, so it will reset processing to false, and terminate. Then next run it will work normally.
									$import->set( array(
										'processing' => 0
									) )->update();
								}

								// start execution imports that is in the cron process
								if ( ! (int) $import->triggered ) {
									wp_send_json( array(
										'status'  => 403,
										'message' => sprintf( __( 'Import #%s is not triggered. Request skipped.', 'wp_all_import_plugin' ), $id )
									) );
								} elseif ( (int) $import->executing ) {
									wp_send_json( array(
										'status'  => 403,
										'message' => sprintf( __( 'Import #%s is currently in manually process. Request skipped.', 'wp_all_import_plugin' ), $id )
									) );
								} elseif ( (int) $import->triggered and ! (int) $import->processing ) {

									$scheduledImport = new \Wpai\Scheduling\Import();

									$response = $scheduledImport->process( $import, $logger );

									if ( ! empty( $response ) and is_array( $response ) ) {
										wp_send_json( $response );
									} elseif ( ! (int) $import->queue_chunk_number ) {

										wp_send_json( array(
											'status'  => 200,
											'message' => sprintf( __( 'Import #%s complete', 'wp_all_import_plugin' ), $import->id )
										) );
									} else {
										wp_send_json( array(
											'status'  => 200,
											'message' => sprintf( __( 'Records Processed %s. Records Count %s.', 'wp_all_import_plugin' ), (int) $import->queue_chunk_number, (int) $import->count )
										) );
									}

								} else {
									wp_send_json( array(
										'status'  => 403,
										'message' => sprintf( __( 'Import #%s already processing. Request skipped.', 'wp_all_import_plugin' ), $id )
									) );
								}

								break;
							case 'pipe':

								$import->execute( $logger );

								break;

							case 'cancel':

								$import->set( array(
									'triggered'   => 0,
									'processing'  => 0,
									'executing'   => 0,
									'canceled'    => 1,
									'canceled_on' => date( 'Y-m-d H:i:s' )
								) )->update();

								wp_send_json( array(
									'status'  => 200,
									'message' => sprintf( __( 'Import #%s canceled', 'wp_all_import_plugin' ), $import->id )
								) );

								break;
						}
					}
				}
			}
		}
	}

}