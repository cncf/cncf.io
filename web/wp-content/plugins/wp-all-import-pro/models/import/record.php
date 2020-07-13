<?php

class PMXI_Import_Record extends PMXI_Model_Record {

	public static $cdata = array();

	protected $errors;	
	
	/**
	 * Some pre-processing logic, such as removing control characters from xml to prevent parsing errors
	 * @param string $xml
	 */
	public static function preprocessXml( &$xml ) {
		
		if ( empty(PMXI_Plugin::$session->is_csv) and empty(PMXI_Plugin::$is_csv)){ 
		
			self::$cdata = array();						

			$is_preprocess_enabled = apply_filters('is_xml_preprocess_enabled', true);

			if ($is_preprocess_enabled) {

				$xml = preg_replace_callback('/<!\[CDATA\[.*?\]\]>/s', 'wp_all_import_cdata_filter', $xml );

                $xml = preg_replace_callback('/&(.{2,5};)?/i', 'wp_all_import_amp_filter', $xml );

                if ( ! empty(self::$cdata) ){
                  foreach (self::$cdata as $key => $val) {
                      $xml = str_replace('{{CPLACE_' . ($key + 1) . '}}', $val, $xml);
                  }
				}
			}								
		}		
	}

	/**
	 * Validate XML to be valid for import
	 * @param string $xml
	 * @param WP_Error[optional] $errors
	 * @return bool Validation status
	 */
	public static function validateXml( & $xml, $errors = NULL) {
		if (FALSE === $xml or '' == $xml) {
			$errors and $errors->add('form-validation', __('WP All Import can\'t read your file.<br/><br/>Probably, you are trying to import an invalid XML feed. Try opening the XML feed in a web browser (Google Chrome is recommended for opening XML files) to see if there is an error message.<br/>Alternatively, run the feed through a validator: http://validator.w3.org/<br/>99% of the time, the reason for this error is because your XML feed isn\'t valid.<br/>If you are 100% sure you are importing a valid XML feed, please contact WP All Import support.', 'wp_all_import_plugin'));
		} else {
						
			PMXI_Import_Record::preprocessXml($xml);																						

			if ( function_exists('simplexml_load_string')){
				libxml_use_internal_errors(true);
				libxml_clear_errors();
				$_x = @simplexml_load_string($xml);
				$xml_errors = libxml_get_errors();			
				libxml_clear_errors();
				if ($xml_errors) {								
					$error_msg = '<strong>' . __('Invalid XML', 'wp_all_import_plugin') . '</strong><ul>';
					foreach($xml_errors as $error) {
						$error_msg .= '<li>';
						$error_msg .= __('Line', 'wp_all_import_plugin') . ' ' . $error->line . ', ';
						$error_msg .= __('Column', 'wp_all_import_plugin') . ' ' . $error->column . ', ';
						$error_msg .= __('Code', 'wp_all_import_plugin') . ' ' . $error->code . ': ';
						$error_msg .= '<em>' . trim(esc_html($error->message)) . '</em>';
						$error_msg .= '</li>';
					}
					$error_msg .= '</ul>';
					$errors and $errors->add('form-validation', $error_msg);				
				} else {
					return true;
				}
			}
			else{
				$errors and $errors->add('form-validation', __('Required PHP components are missing.', 'wp_all_import_plugin'));				
				$errors and $errors->add('form-validation', __('WP All Import requires the SimpleXML PHP module to be installed. This is a standard feature of PHP, and is necessary for WP All Import to read the files you are trying to import.<br/>Please contact your web hosting provider and ask them to install and activate the SimpleXML PHP module.', 'wp_all_import_plugin'));				
			}
		}
		return false;
	}

	/**
	 * Initialize model instance
	 * @param array[optional] $data Array of record data to initialize object with
	 */
	public function __construct($data = array()) {
		parent::__construct($data);
		$this->setTable(PMXI_Plugin::getInstance()->getTablePrefix() . 'imports');
		$this->errors = new WP_Error();
	}

	/**
	 * Import all files matched by path
	 * @param callback[optional] $logger Method where progress messages are submmitted
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function execute($logger = NULL, $cron = true, $history_log_id = false) {
				
		$uploads = wp_upload_dir();	

		if ($this->path) {
			
			$files = array($this->path);					
			
			foreach ($files as $ind => $path) {				

				$filePath = '';

				if ( $this->queue_chunk_number == 0 and $this->processing == 0 ) {

					$this->set(array('processing' => 1))->update(); // lock cron requests	

					if ($this->type == 'ftp'){
						
						$this->set(array('processing' => 0))->update();

						return array(
							'status'     => 500,
							'message'    => sprintf(__('This import appears to be using FTP. Unfortunately WP All Import no longer supports the FTP protocol. Please contact <a href="mailto:support@wpallimport.com">%s</a> if you have any questions.', 'wp_all_import_plugin'), 'support@wpallimport.com')
						);												
									
					}
					elseif ($this->type == 'url'){

						$filesXML = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<data><node></node></data>";

						$filePaths = XmlImportParser::factory($filesXML, '/data/node', $this->path, $file)->parse(); $tmp_files[] = $file;	

						foreach ($tmp_files as $tmp_file) { // remove all temporary files created
							@unlink($tmp_file);
						}

						$file_to_import = $this->path;

						if ( ! empty($filePaths) and is_array($filePaths) )
						{
							$file_to_import = array_shift($filePaths);
						}
						
						$uploader = new PMXI_Upload(trim($file_to_import), $this->errors);			
						$upload_result = $uploader->url($this->feed_type, $this->path);						

						if ($upload_result instanceof WP_Error){
							$this->errors = $upload_result;		
						}			
						else {
							$filePath  = $upload_result['filePath'];
						}								
					}
					elseif ( $this->type == 'file'){
						
						$uploader = new PMXI_Upload(trim(wp_all_import_basename($this->path)), $this->errors);			
						$upload_result = $uploader->file();					
						if ($upload_result instanceof WP_Error){
							$this->errors = $upload_result;		
						}			
						else{
							$filePath  = $upload_result['filePath'];
						}
					}
					elseif ( ! in_array($this->type, array('ftp'))){ // retrieve already uploaded file

						$uploader = new PMXI_Upload(trim($this->path), $this->errors, rtrim(str_replace(wp_all_import_basename($this->path), '', $this->path), '/'));			
						$upload_result = $uploader->upload();					
						if ($upload_result instanceof WP_Error){
							$this->errors = $upload_result;		
						}			
						else{
							$filePath  = $upload_result['filePath'];						
						}
					}

					if ( ! $this->errors->get_error_codes() and "" != $filePath ) {

						$this->set(array('queue_chunk_number' => 1))->update();					
						
					}
					elseif ( $this->errors->get_error_codes() ){

						$msgs = $this->errors->get_error_messages();

						if ( ! is_array($msgs)) {
							$msgs = array($msgs);
						}											
												
						$this->set(array('processing' => 0))->update();

						return array(
							'status'     => 500,
							'message'    => $msgs
						);

					}
					
					$this->set(array('processing' => 0))->update(); // unlock cron requests

				}
						
				// if empty file path, than it's mean feed in cron process. Take feed path from history.
				if (empty($filePath)){
					$history = new PMXI_File_List();
					$history->setColumns('id', 'name', 'registered_on', 'path')->getBy(array('import_id' => $this->id), 'id DESC');				
					if ($history->count()){
						$history_file = new PMXI_File_Record();
						$history_file->getBy('id', $history[0]['id']);
						$filePath =	wp_all_import_get_absolute_path($history_file->path);						
					}
				}			
				
				// if feed path found
				if ( ! empty($filePath) and @file_exists($filePath) ) {

                    $functions  = $uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php';
                    $functions = apply_filters( 'import_functions_file_path', $functions );
                    if ( @file_exists($functions) && PMXI_Plugin::$is_php_allowed)
                        require_once $functions;

					if ( $this->queue_chunk_number === 1 and $this->processing == 0 ){ // import first cron request

						$this->set(array('processing' => 1))->update(); // lock cron requests																		
						
						if (empty($this->options['encoding'])){
							$currentOptions = $this->options;
							$currentOptions['encoding'] = 'UTF-8';
							$this->set(array(
								'options' => $currentOptions
							))->update();
						}
						
						set_time_limit(0);													

						// wp_all_import_get_reader_engine( array($filePath), array('root_element' => $this->root_element), $this->id );						

						$file = new PMXI_Chunk($filePath, array('element' => $this->root_element, 'encoding' => $this->options['encoding']));
					    
					    // chunks counting		    
					    $chunks = 0; $history_xml = '';
					    while ($xml = $file->read()) { 
					    	if (!empty($xml)) {									    		
					    		//PMXI_Import_Record::preprocessXml($xml);
					    		$xml = "<?xml version=\"1.0\" encoding=\"". $this->options['encoding'] ."\"?>" . "\n" . $xml;					    		
					      		
						      	$dom = new DOMDocument('1.0', ( ! empty($this->options['encoding']) ) ? $this->options['encoding'] : 'UTF-8');
								$old = libxml_use_internal_errors(true);
								$dom->loadXML($xml);
								libxml_use_internal_errors($old);
								$xpath = new DOMXPath($dom);
								if (($elements = @$xpath->query($this->xpath)) and $elements->length){ 
									$chunks += $elements->length;
									if ("" == $history_xml) $history_xml = $xml;
								}
								unset($dom, $xpath, $elements);
						    }
						}
						unset($file);			
						
						if ( ! $chunks ){							
							
							$this->set(array(
								'queue_chunk_number' => 0,
								'processing' => 0,
								'imported' => 0,
								'created' => 0,
								'updated' => 0,
								'skipped' => 0,
								'deleted' => 0,
								'triggered' => 0	
							))->update();

                            $force_cron_processing = apply_filters('wp_all_import_force_cron_processing_on_empty_feed', false, $this->id);
                            if ( ! $force_cron_processing ){
                                return array(
                                    'status'     => 500,
                                    'message'    => sprintf(__('#%s No matching elements found for Root element and XPath expression specified', 'wp_all_import_plugin'), $this->id)
                                );
                            }
						}

						// unlick previous files
						$history = new PMXI_File_List();
						$history->setColumns('id', 'name', 'registered_on', 'path')->getBy(array('import_id' => $this->id), 'id DESC');				
						if ($history->count()){
							foreach ($history as $file){
								$history_file_path = wp_all_import_get_absolute_path($file['path']);						
								if (@file_exists($history_file_path) and $history_file_path != $filePath){ 
									if (in_array($this->type, array('upload')))
										wp_all_import_remove_source($history_file_path, false);									
									else
										wp_all_import_remove_source($history_file_path);
								}
								$history_file = new PMXI_File_Record();
								$history_file->getBy('id', $file['id']);
								if ( ! $history_file->isEmpty()) $history_file->delete( $history_file_path != $filePath );
							}
						}

						// update history
						$history_file = new PMXI_File_Record();
						$history_file->set(array(
							'name' => $this->name,
							'import_id' => $this->id,
							'path' => wp_all_import_get_relative_path($filePath),
							//'contents' => (isset($history_xml)) ? $history_xml : '',
							'registered_on' => date('Y-m-d H:i:s')
						))->insert();							

						$this->set(array('count' => $chunks, 'processing' => 0))->update(); // set pointer to the first chunk, updates feed elements count and unlock cron process

						do_action( 'pmxi_before_xml_import', $this->id );
						
					}					

					// compose data to look like result of wizard steps									
					if( ($this->queue_chunk_number or !empty($force_cron_processing)) and $this->processing == 0 ) {

                        $records = array();

                        if ($this->options['is_import_specified']) {
                            $import_specified_option = apply_filters('wp_all_import_specified_records', $this->options['import_specified'], $this->id, false);
                            foreach (preg_split('% *, *%', $import_specified_option, -1, PREG_SPLIT_NO_EMPTY) as $chank) {
                                if (preg_match('%^(\d+)-(\d+)$%', $chank, $mtch)) {
                                    $records = array_merge($records, range(intval($mtch[1]), intval($mtch[2])));
                                } else {
                                    $records = array_merge($records, array(intval($chank)));
                                }
                            }
                        }

                        $records_to_import = (int) ((empty($records)) ? $this->count : $records[count($records) -1]);

                        // Lock cron requests.
						$this->set(array(
						    'processing' => 1,
                            'registered_on' => date('Y-m-d H:i:s')
                        ))->update();

						@set_time_limit(0);

                        $processing_time_limit = (PMXI_Plugin::getInstance()->getOption('cron_processing_time_limit')) ? PMXI_Plugin::getInstance()->getOption('cron_processing_time_limit') : 59;
                        // Do not limit process time on command line.
                        if (PMXI_Plugin::getInstance()->isCli()) {
                            $processing_time_limit = time();
                        }
                        $start_processing_time = time();
                        $progress = NULL;
                        if (PMXI_Plugin::getInstance()->isCli() && class_exists('WP_CLI')) {
                            $custom_type = get_post_type_object( $this->options['custom_type'] );
                            $progress = \WP_CLI\Utils\make_progress_bar( 'Importing ' . $custom_type->labels->name, $records_to_import );
                        }
						if ( (int) $this->imported + (int) $this->skipped <= (int) $records_to_import ) {
							$file = new PMXI_Chunk($filePath, array('element' => $this->root_element, 'encoding' => $this->options['encoding'], 'pointer' => $this->queue_chunk_number));
							$feed = "<?xml version=\"1.0\" encoding=\"". $this->options['encoding'] ."\"?>" . "\n" . "<pmxi_records>";
						    $loop = 0;
						    $chunk_number = $this->queue_chunk_number;
						    while ($xml = $file->read() and $this->processing == 1 and (time() - $start_processing_time) <= $processing_time_limit ) {
						    	if (!empty($xml)) {
						    		$chunk_number++;
						    		$xml_chunk = "<?xml version=\"1.0\" encoding=\"". $this->options['encoding'] ."\"?>" . "\n" . $xml;
							      	$dom = new DOMDocument('1.0', ( ! empty($this->options['encoding']) ) ? $this->options['encoding'] : 'UTF-8');															
									$old = libxml_use_internal_errors(true);
									$dom->loadXML($xml_chunk);								
									libxml_use_internal_errors($old);
									$xpath = new DOMXPath($dom);

									if (($elements = @$xpath->query($this->xpath)) && $elements->length && $records_to_import > $loop + (int) $this->imported + (int) $this->skipped){
										$feed .= $xml;																		
										$loop += $elements->length;
									}
									unset($dom, $xpath, $elements);
							    }		

							    if ( $loop > 0 and ( $loop == (int) $this->options['records_per_request'] or $records_to_import == (int) $this->imported + (int) $this->skipped or $records_to_import == $loop + (int) $this->imported + (int) $this->skipped or $records_to_import == $chunk_number) ) { // skipping scheduled imports if any for the next hit
							    	$feed .= "</pmxi_records>";
                                    $this->process($feed, $logger, $chunk_number, $cron, '/pmxi_records', $loop, $progress);

							    	// set last update
							    	$this->set(array(
										'registered_on' => date('Y-m-d H:i:s'),
										'queue_chunk_number' => $chunk_number 
									))->update();	

							    	$loop = 0;
							    	$feed = "<?xml version=\"1.0\" encoding=\"". $this->options['encoding'] ."\"?>" . "\n" . "<pmxi_records>";
							    }

                                if ( $records_to_import < $loop + (int) $this->imported + (int) $this->skipped ){
                                    break;
                                }
							}
							
							unset($file);
						}
						
						// detect, if cron process if finished
						if ( (int) $records_to_import <= (int) $this->imported + (int) $this->skipped or $records_to_import == $this->queue_chunk_number){

							$this->delete_source( $logger );

							// Delete posts that are no longer present in your file
							if (! empty($this->options['is_delete_missing']) and $this->options['duplicate_matching'] == 'auto'){

								$postList = new PMXI_Post_List();												
								$args = array('import_id' => $this->id, 'iteration !=' => $this->iteration);
								if ( ! empty($this->options['is_import_specified']) ) $args['specified'] = 1;
								$missing_ids = array();								
								$missingPosts = $postList->getBy($args);

								if (!$missingPosts->isEmpty()) {
                                    foreach ($missingPosts as $missingPost) {
                                        $missing_ids[] = $missingPost;
                                    }
                                }

								// Delete posts from database.
								if (!empty($missing_ids) && is_array($missing_ids)) {
									$missing_ids_arr = array_chunk($missing_ids, $this->options['records_per_request']);
                                    $count_deleted_missing_records = 0;
									foreach ($missing_ids_arr as $key => $missingPostRecords) {
										if (!empty($missingPostRecords)){
											foreach ( $missingPostRecords as $k => $missingPostRecord ) {
												$to_delete = true;
												// Instead of deletion, set Custom Field.
												if ($this->options['is_update_missing_cf']){
                                                    switch ($this->options['custom_type']){
                                                        case 'import_users':
                                                            update_user_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                                            $logger and call_user_func($logger, sprintf(__('Instead of deletion user with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                                            break;
														case 'shop_customer':
                                                            update_user_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
															$logger and call_user_func($logger, sprintf(__('Instead of deletion customer with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
															break;
                                                        case 'taxonomies':
                                                            update_term_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                                            $logger and call_user_func($logger, sprintf(__('Instead of deletion taxonomy term with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                                            break;
                                                        case 'reviews':
                                                        case 'comments':
                                                            update_comment_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                                            $logger and call_user_func($logger, sprintf(__('Instead of deletion comment with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                                            break;
                                                        default:
                                                            update_post_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                                            $logger and call_user_func($logger, sprintf(__('Instead of deletion post with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                                            break;
                                                    }
													$to_delete = false;
												}

												// Instead of deletion, change post status to Draft
												$final_post_type = get_post_type($missingPostRecord['post_id']);
												if ($this->options['set_missing_to_draft']){
													if ($final_post_type != 'product_variation' and 'draft' != get_post_status($missingPostRecord['post_id'])){
                                                        $this->wpdb->update( $this->wpdb->posts, array('post_status' => 'draft'), array('ID' => $missingPostRecord['post_id']) );
                                                        $this->recount_terms($missingPostRecord['post_id'], $final_post_type);
                                                    }
													$to_delete = false;
												}

												$to_delete = apply_filters('wp_all_import_is_post_to_delete', $to_delete, $missingPostRecord['post_id'], $this);
												
												// Delete posts that are no longer present in your file
												if ($to_delete) {
                                                    if (!in_array($this->options['custom_type'], array("import_users", "taxonomies", "shop_customer"))) {
                                                        // Remove attachments
                                                        empty($this->options['is_keep_attachments']) and wp_delete_attachments($missingPostRecord['post_id'], true, 'files');
                                                        // Remove images
                                                        empty($this->options['is_keep_imgs']) and wp_delete_attachments($missingPostRecord['post_id'], true, 'images');
                                                        // Clear post's relationships
                                                        wp_delete_object_term_relationships($missingPostRecord['post_id'], get_object_taxonomies('' != $this->options['custom_type'] ? $this->options['custom_type'] : 'post'));
                                                    }
												}
												else {
                                                    $postRecord = new PMXI_Post_Record();
                                                    $postRecord->getBy(array(
                                                        'post_id' => $missingPostRecord['post_id'],
                                                        'import_id' => $this->id,
                                                    ));

                                                    if (!$postRecord->isEmpty()) {
                                                        $is_unlink_missing_posts = apply_filters('wp_all_import_is_unlink_missing_posts', false, $this->id, $missingPostRecord['post_id']);
                                                        if ( $is_unlink_missing_posts ){
                                                            $postRecord->delete();
                                                        }
                                                        else {
                                                            $postRecord->set(array(
                                                                'iteration' => $this->iteration
                                                            ))->save();
                                                        }
                                                    }
													do_action('pmxi_missing_post', $missingPostRecord['post_id']);
													unset($missingPostRecords[$k]);
												}
											}

											$ids = array();

											if (!empty( $missingPostRecords)) {
												foreach ($missingPostRecords as $k => $missingPostRecord) {
													$ids[] = $missingPostRecord['post_id'];
												}

                                                switch ($this->options['custom_type']) {
													case 'import_users':
													case 'shop_customer':
                                                        do_action('pmxi_delete_post', $ids, $this);
														// delete_user action
														foreach( $ids as $id) {
															do_action( 'delete_user', $id, $reassign = null );
														}
                                                        $sql = "delete a,b
                                                        FROM ".$this->wpdb->users." a
                                                        LEFT JOIN ".$this->wpdb->usermeta." b ON ( a.ID = b.user_id )										
                                                        WHERE a.ID IN (" . implode(',', $ids) . ");";
														// deleted_user action
														foreach( $ids as $id) {
															do_action( 'deleted_user', $id, $reassign = null );
														}
                                                        $this->wpdb->query( $sql );
														break;
                                                    case 'taxonomies':
                                                        do_action('pmxi_delete_taxonomies', $ids);
                                                        foreach ($ids as $term_id){
                                                            wp_delete_term( $term_id, $this->options['taxonomy_type'] );
                                                        }
                                                        break;
                                                    case 'reviews':
                                                    case 'comments':
                                                        do_action('pmxi_delete_comments', $ids);
                                                        foreach ($ids as $comment_id){
                                                            wp_delete_comment( $comment_id, TRUE );
                                                        }
                                                        break;
                                                    default:
                                                        do_action('pmxi_delete_post', $ids, $this);
                                                        foreach ($ids as $id) {
                                                            wp_delete_post($id, TRUE);
                                                        }
                                                        break;
                                                }

												// Delete record form pmxi_posts
												$sql = "DELETE FROM " . PMXI_Plugin::getInstance()->getTablePrefix() . "posts WHERE post_id IN (".implode(',', $ids).") AND import_id = %d";
												$this->wpdb->query( 
													$this->wpdb->prepare($sql, $this->id)
												);

												$this->set(array('deleted' => $this->deleted + count($ids)))->update();

                                                $logger and call_user_func($logger, sprintf(__('%d Posts deleted from database. IDs (%s)', 'wp_all_import_plugin'), $this->deleted, implode(",", $ids)));
											}

                                            $count_deleted_missing_records += count($ids);

                                            if ( (time() - $start_processing_time) > $processing_time_limit ) {
                                                $this->set(array(
                                                    'processing' => 0
                                                ))->update();

                                                return array(
                                                    'status'     => 200,
                                                    'message'    => sprintf(__('Deleted missing records %s for import #%s', 'wp_all_import_plugin'), $count_deleted_missing_records, $this->id)
                                                );
                                            }
										}										
									}									
								}
							}

							// Set out of stock status for missing records [Woocommerce add-on option]
							if (empty($this->options['is_delete_missing']) and $this->options['custom_type'] == "product" and class_exists('PMWI_Plugin') and !empty($this->options['missing_records_stock_status']) and "manual" != $this->options['duplicate_matching']) {
																
								$postList = new PMXI_Post_List();												
								$args = array('import_id' => $this->id, 'iteration !=' => $this->iteration);
								if ( ! empty($this->options['is_import_specified']) ) $args['specified'] = 1;
								$missing_ids = array();								
								$missingPosts = $postList->getBy($args);

								if (!$missingPosts->isEmpty()) {
                                    foreach ($missingPosts as $missingPost) {
                                        $missing_ids[] = $missingPost;
                                    }
                                }
								// Delete posts from database.
								if (!empty($missing_ids) && is_array($missing_ids)) {
									$missing_ids_arr = array_chunk($missing_ids, 50);
									foreach ($missing_ids_arr as $key => $missingPostRecords) {
										if (!empty($missingPostRecords)) {
											foreach ( $missingPostRecords as $k => $missingPostRecord ) {
												$this->update_meta( $missingPostRecord['post_id'], '_stock_status', 'outofstock' );
												$this->update_meta( $missingPostRecord['post_id'], '_stock', 0 );
                                                $term_ids = wp_get_object_terms($missingPostRecord['post_id'], 'product_visibility', array('fields' => 'ids'));
                                                $outofstock_term = get_term_by( 'name', 'outofstock', 'product_visibility' );
                                                if (!empty($outofstock_term) && !is_wp_error($outofstock_term) && !in_array($outofstock_term->term_taxonomy_id, $term_ids)){
                                                    $term_ids[] = $outofstock_term->term_taxonomy_id;
                                                }
                                                $this->associate_terms( $missingPostRecord['post_id'], $term_ids, 'product_visibility', $logger );
												
												$postRecord = new PMXI_Post_Record();												
												$postRecord->getBy(array(
													'post_id' => $missingPostRecord['post_id'],
													'import_id' => $this->id,
												));
												if (!$postRecord->isEmpty()) {
													$postRecord->set(array(
														'iteration' => $this->iteration
													))->save();									
												}		
												unset($postRecord);										
											}

											$this->set(array(
												'processing' => 0								
											))->update();		

											return array(
												'status'     => 200,
												'message'    => sprintf(__('Updating stock status for missing records %s for import #%s', 'wp_all_import_plugin'), count($missing_ids), $this->id)
											);											
										}										
									}									
								}								
							}							

							$this->set(array(
								'processing' => 0,
								'triggered' => 0,
								'queue_chunk_number' => 0,
								'registered_on' => date('Y-m-d H:i:s'), // update registered_on to indicated that job has been exectured even if no files are going to be imported by the rest of the method
								'iteration' => ++$this->iteration
							))->update();							

							foreach ( get_taxonomies() as $tax ) {				
								delete_option( "{$tax}_children" );
								_get_term_hierarchy( $tax );
							}								

							if ( $history_log_id ){															
								$history_log = new PMXI_History_Record();						
								$history_log->getById( $history_log_id );
								if ( ! $history_log->isEmpty() ){
									$custom_type = get_post_type_object( $this->options['custom_type'] );		
									$history_log->set(array(
										'time_run' => time() - strtotime($history_log->date),
										'summary' => sprintf(__("import finished & cron un-triggered<br>%s %s created %s updated %s deleted %s skipped", "pmxi_plugin"), $this->created, ( ($this->created == 1) ? $custom_type->labels->singular_name : $custom_type->labels->name ), $this->updated, $this->deleted, $this->skipped)
									))->save();																	
								}
							}
							do_action( 'pmxi_after_xml_import', $this->id, $this );
							return array(
								'status'     => 200,
								'message'    => sprintf(__('Import #%s complete', 'wp_all_import_plugin'), $this->id)
							);
						}
						else {
							$this->set(array(
								'processing' => 0								
							))->update();
							if ( $history_log_id ) {
								$history_log = new PMXI_History_Record();						
								$history_log->getById( $history_log_id );
								if ( ! $history_log->isEmpty() ){
									$custom_type = get_post_type_object( $this->options['custom_type'] );		
									$history_log->set(array(
										'time_run' => time() - strtotime($history_log->date),
										'summary' => sprintf(__("%d %s created %d updated %d deleted %d skipped", "pmxi_plugin"), $this->created, ( ($this->created == 1) ? $custom_type->labels->singular_name : $custom_type->labels->name ), $this->updated, $this->deleted, $this->skipped)
									))->save();																	
								}
							}
							return array(
								'status'     => 200,
                                'message'    => sprintf(__('Records Processed %s. Records imported %s of %s.', 'wp_all_import_plugin'), (int) $this->queue_chunk_number, (int) $this->imported, (int) $this->count)
							);													
						}
					}					
				}
				else {
					$this->set(array(
						'processing' => 0,
						'triggered' => 0,
						'queue_chunk_number' => 0,
						'imported' => 0,
						'created' => 0,
						'updated' => 0,
						'skipped' => 0,
						'deleted' => 0										
					))->update();

                    if ( $history_log_id ){
                        $history_log = new PMXI_History_Record();
                        $history_log->getById( $history_log_id );
                        if ( ! $history_log->isEmpty() ){
                            $history_log->delete();
                        }
                    }
					return array(
						'status'     => 500,
						'message'    => sprintf(__('#%s source file not found', 'wp_all_import_plugin'), $this->id)
					);					
				}																				
			}			
		}
		return $this;
	}

	protected function update_meta( $pid, $key, $value ){

		$meta_table = _get_meta_table( 'post' );

		$where = array( 'post_id' => $pid, 'meta_key' => $key );

		$result = $this->wpdb->update( $meta_table, array('meta_value' => $value), $where );

		return $result;
	}
	
	public $post_meta_to_insert = array();

    public function is_parsing_required( $option ){
        return ($this->options['update_all_data'] == 'yes' || $this->options[$option] || $this->options['create_new_records']) ? true : false;
    }

	/**
	 * Perform import operation
	 * @param string $xml XML string to import
	 * @param callback[optional] $logger Method where progress messages are submmitted
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function process($xml, $logger = NULL, $chunk = false, $is_cron = false, $xpath_prefix = '', $loop = 0, $progress = NULL) {

		add_filter('user_has_cap', array($this, '_filter_has_cap_unfiltered_html')); kses_init(); // do not perform special filtering for imported content

		$cxpath = $xpath_prefix . $this->xpath;

		$this->options += PMXI_Plugin::get_default_import_options(); // make sure all options are defined
		
		$avoid_pingbacks = PMXI_Plugin::getInstance()->getOption('pingbacks');

		$cron_sleep = (int) PMXI_Plugin::getInstance()->getOption('cron_sleep');
		
		if ( $avoid_pingbacks and ! defined( 'WP_IMPORTING' ) ) define( 'WP_IMPORTING', true );

		$postRecord = new PMXI_Post_Record();		
		
		$tmp_files = array();
		// compose records to import
		$records = array();

		$is_import_complete = false;

        // Set current import ID
        if (!empty(PMXI_Plugin::$session)) {
            PMXI_Plugin::$session->import_id = $this->id;
            PMXI_Plugin::$session->save_data();
        }
		
		try {

            //$errorHandler = new PMXI_Error();

            //set_error_handler( array($errorHandler, 'parse_data_handler'), E_ALL | E_STRICT | E_WARNING );

            $chunk == 1 and $logger and printf("<div class='progress-msg'>%s</div>\n", date("r")) and flush();

            $chunk == 1 and $logger and call_user_func($logger, __('Composing titles...', 'wp_all_import_plugin'));
			if ( ! empty($this->options['title'])){
				$titles = XmlImportParser::factory($xml, $cxpath, $this->options['title'], $file)->parse($records); $tmp_files[] = $file;							
			}
			else{
				$loop and $titles = array_fill(0, $loop, '');
			}

			if ( in_array($this->options['custom_type'], array('taxonomies')) ){
                // Composing parent terms
                $chunk == 1 and $logger and call_user_func($logger, __('Composing parent terms...', 'wp_all_import_plugin'));
                $taxonomy_parent = array();
                if ( ! empty($this->options['taxonomy_parent']) && $this->is_parsing_required('is_update_parent') ){
                    $taxonomy_parent = XmlImportParser::factory($xml, $cxpath, $this->options['taxonomy_parent'], $file)->parse($records); $tmp_files[] = $file;
                }
                else{
                    count($titles) and $taxonomy_parent = array_fill(0, count($titles), 0);
                }
                // Composing terms slug
                $chunk == 1 and $logger and call_user_func($logger, __('Composing terms slug...', 'wp_all_import_plugin'));
                $taxonomy_slug = array();
                if ( 'xpath' == $this->options['taxonomy_slug'] && ! empty($this->options['taxonomy_slug_xpath']) && $this->is_parsing_required('is_update_slug')){
                    $taxonomy_slug = XmlImportParser::factory($xml, $cxpath, $this->options['taxonomy_slug_xpath'], $file)->parse($records); $tmp_files[] = $file;
                }
                else{
                    count($titles) and $taxonomy_slug = array_fill(0, count($titles), '');
                }
            }

            if ( ! in_array($this->options['custom_type'], array('taxonomies')) ){
                $chunk == 1 and $logger and call_user_func($logger, __('Composing excerpts...', 'wp_all_import_plugin'));
                $post_excerpt = array();
                if ( ! empty($this->options['post_excerpt']) && $this->is_parsing_required('is_update_excerpt')){
                    $post_excerpt = XmlImportParser::factory($xml, $cxpath, $this->options['post_excerpt'], $file)->parse($records); $tmp_files[] = $file;
                }
                else{
                    count($titles) and $post_excerpt = array_fill(0, count($titles), '');
                }
            }

            if ( "xpath" == $this->options['status'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing statuses...', 'wp_all_import_plugin'));			
				$post_status = array();
				if ( ! empty($this->options['status_xpath']) && $this->is_parsing_required('is_update_status') ){
					$post_status = XmlImportParser::factory($xml, $cxpath, $this->options['status_xpath'], $file)->parse($records); $tmp_files[] = $file;					
				}
				else{
					count($titles) and $post_status = array_fill(0, count($titles), 'publish');
				}
			}
			
			if ( "xpath" == $this->options['comment_status'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing comment statuses...', 'wp_all_import_plugin'));			
				$comment_status = array();
				if (!empty($this->options['comment_status_xpath']) && $this->is_parsing_required('is_update_comment_status') ){
					$comment_status = XmlImportParser::factory($xml, $cxpath, $this->options['comment_status_xpath'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $comment_status = array_fill(0, count($titles), 'open');
				}
			}

			if ( "xpath" == $this->options['ping_status'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing ping statuses...', 'wp_all_import_plugin'));			
				$ping_status = array();
				if (!empty($this->options['ping_status_xpath'])){
					$ping_status = XmlImportParser::factory($xml, $cxpath, $this->options['ping_status_xpath'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $ping_status = array_fill(0, count($titles), 'open');
				}
			}

			if ( "xpath" == $this->options['post_format'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing post formats...', 'wp_all_import_plugin'));			
				$post_format = array();
				if (!empty($this->options['post_format_xpath'])){
					$post_format = XmlImportParser::factory($xml, $cxpath, $this->options['post_format_xpath'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $post_format = array_fill(0, count($titles), 'open');
				}
			}

            $duplicate_indicator_values = array();
			if ( in_array($this->options['duplicate_indicator'], array("pid", "title", "slug")) ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing duplicate indicators...', 'wp_all_import_plugin'));
				if (!empty($this->options[$this->options['duplicate_indicator'] . '_xpath'])){
                    $duplicate_indicator_values = XmlImportParser::factory($xml, $cxpath, $this->options[$this->options['duplicate_indicator'] . '_xpath'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $duplicate_indicator_values = array_fill(0, count($titles), '');
				}
			}
			else{
                count($titles) and $duplicate_indicator_values = array_fill(0, count($titles), '');
            }

			if ( "no" == $this->options['is_multiple_page_template'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing page templates...', 'wp_all_import_plugin'));			
				$page_template = array();
				if (!empty($this->options['single_page_template'])){
					$page_template = XmlImportParser::factory($xml, $cxpath, $this->options['single_page_template'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $page_template = array_fill(0, count($titles), 'default');
				}
			}			

            if ( $this->options['is_override_post_type'] and ! empty($this->options['post_type_xpath']) ){
                $chunk == 1 and $logger and call_user_func($logger, __('Composing post types...', 'wp_all_import_plugin'));
                $post_type = array();
                $post_type = XmlImportParser::factory($xml, $cxpath, $this->options['post_type_xpath'], $file)->parse($records); $tmp_files[] = $file;
            }
            else{
                if ('post' == $this->options['type'] and '' != $this->options['custom_type']) {
                    $pType = $this->options['custom_type'];
                } else {
                    $pType = $this->options['type'];
                }
                count($titles) and $post_type = array_fill(0, count($titles), $pType);
            }

			if ( "no" == $this->options['is_multiple_page_parent'] ){
				$chunk == 1 and $logger and call_user_func($logger, __('Composing page parent...', 'wp_all_import_plugin'));			
				$page_parent = array();
				if ( ! empty($this->options['single_page_parent']) && $this->is_parsing_required('is_update_parent') ){
					$page_parent = XmlImportParser::factory($xml, $cxpath, $this->options['single_page_parent'], $file)->parse($records); $tmp_files[] = $file;
				}
				else{
					count($titles) and $page_parent = array_fill(0, count($titles), 0);
				}
			}

			if ( $this->is_parsing_required('is_update_author') ){
                $chunk == 1 and $logger and call_user_func($logger, __('Composing authors...', 'wp_all_import_plugin'));
                $post_author = array();
                $current_user = wp_get_current_user();

                if (!empty($this->options['author'])){
                    $post_author = XmlImportParser::factory($xml, $cxpath, $this->options['author'], $file)->parse($records); $tmp_files[] = $file;
                    foreach ($post_author as $key => $author) {
                        $user = get_user_by('login', $author) or $user = get_user_by('slug', $author) or $user = get_user_by('email', $author) or ctype_digit($author) and $user = get_user_by('id', $author);
                        if (!empty($user)) {
                            $post_author[$key] = $user->ID;
                        } else {
                            if ($current_user->ID){
                                $post_author[$key] = $current_user->ID;
                            } else {
                                $super_admins = get_super_admins();
                                if ( ! empty($super_admins) ) {
                                    $sauthor = array_shift($super_admins);
                                    $user = get_user_by('login', $sauthor) or $user = get_user_by('slug', $sauthor) or $user = get_user_by('email', $sauthor) or ctype_digit($sauthor) and $user = get_user_by('id', $sauthor);
                                    $post_author[$key] = (!empty($user)) ? $user->ID : $current_user->ID;
                                }
                            }
                        }
                    }
                } else {
                    if ($current_user->ID) {
                        count($titles) and $post_author = array_fill(0, count($titles), $current_user->ID);
                    } else {
                        $super_admins = get_super_admins();
                        if ( ! empty($super_admins) ) {
                            $author = array_shift($super_admins);
                            $user = get_user_by('login', $author) or $user = get_user_by('slug', $author) or $user = get_user_by('email', $author) or ctype_digit($author) and $user = get_user_by('id', $author);
                            count($titles) and $post_author = array_fill(0, count($titles), (!empty($user)) ? $user->ID : $current_user->ID);
                        }
                    }
                }
            } else {
                $current_user = wp_get_current_user();
                count($titles) and $post_author = array_fill(0, count($titles), $current_user->ID);
            }

			$chunk == 1 and $logger and call_user_func($logger, __('Composing slugs...', 'wp_all_import_plugin'));			
			$post_slug = array();
			if (!empty($this->options['post_slug']) && $this->is_parsing_required('is_update_slug') ){
				$post_slug = XmlImportParser::factory($xml, $cxpath, $this->options['post_slug'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $post_slug = array_fill(0, count($titles), '');
			}

			$is_image_featured = array();
            if (!empty($this->options['is_featured_xpath'])){
                $is_image_featured = XmlImportParser::factory($xml, $cxpath, $this->options['is_featured_xpath'], $file)->parse($records); $tmp_files[] = $file;
            }
            else{
                count($titles) and $is_image_featured = array_fill(0, count($titles), '');
            }

			$chunk == 1 and $logger and call_user_func($logger, __('Composing menu order...', 'wp_all_import_plugin'));			
			$menu_order = array();
			if (!empty($this->options['order']) && $this->is_parsing_required('is_update_menu_order')){
				$menu_order = XmlImportParser::factory($xml, $cxpath, $this->options['order'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $menu_order = array_fill(0, count($titles), '');
			}

			$chunk == 1 and $logger and call_user_func($logger, __('Composing contents...', 'wp_all_import_plugin'));			 						
			if (!empty($this->options['content']) && $this->is_parsing_required('is_update_content') ){
				$contents = XmlImportParser::factory(
					((!empty($this->options['is_keep_linebreaks']) and intval($this->options['is_keep_linebreaks'])) ? $xml : preg_replace('%\r\n?|\n%', ' ', $xml)),
					$cxpath,
					$this->options['content'],
					$file)->parse($records
				); $tmp_files[] = $file;						
			}
			else{
				count($titles) and $contents = array_fill(0, count($titles), '');
			}
										
			$chunk == 1 and $logger and call_user_func($logger, __('Composing dates...', 'wp_all_import_plugin'));
            if ( $this->is_parsing_required('is_update_dates') ){
                if ('specific' == $this->options['date_type']) {
                    $dates = XmlImportParser::factory($xml, $cxpath, $this->options['date'], $file)->parse($records); $tmp_files[] = $file;
                    $warned = array(); // used to prevent the same notice displaying several times
                    foreach ($dates as $i => $d) {
                        if ($d == 'now') $d = current_time('mysql'); // Replace 'now' with the WordPress local time to account for timezone offsets (WordPress references its local time during publishing rather than the server’s time so it should use that)
                        $time = strtotime($d);
                        if (FALSE === $time) {
                            in_array($d, $warned) or $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: unrecognized date format `%s`, assigning current date', 'wp_all_import_plugin'), $warned[] = $d));
                            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                            $time = time();
                        }
                        $dates[$i] = date('Y-m-d H:i:s', $time);
                    }
                } else {
                    $dates_start = XmlImportParser::factory($xml, $cxpath, $this->options['date_start'], $file)->parse($records); $tmp_files[] = $file;
                    $dates_end = XmlImportParser::factory($xml, $cxpath, $this->options['date_end'], $file)->parse($records); $tmp_files[] = $file;
                    $warned = array(); // used to prevent the same notice displaying several times
                    foreach ($dates_start as $i => $d) {
                        $time_start = strtotime($dates_start[$i]);
                        if (FALSE === $time_start) {
                            in_array($dates_start[$i], $warned) or $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: unrecognized date format `%s`, assigning current date', 'wp_all_import_plugin'), $warned[] = $dates_start[$i]));
                            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                            $time_start = time();
                        }
                        $time_end = strtotime($dates_end[$i]);
                        if (FALSE === $time_end) {
                            in_array($dates_end[$i], $warned) or $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: unrecognized date format `%s`, assigning current date', 'wp_all_import_plugin'), $warned[] = $dates_end[$i]));
                            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                            $time_end = time();
                        }
                        $dates[$i] = date('Y-m-d H:i:s', mt_rand($time_start, $time_end));
                    }
                }
            }
            else{
                count($titles) and $dates = array_fill(0, count($titles), date('Y-m-d H:i:s', strtotime(current_time('mysql'))));
            }
						
			// [custom taxonomies]
			require_once(ABSPATH . 'wp-admin/includes/taxonomy.php');

			$taxonomies = array();						
			$exclude_taxonomies = apply_filters('pmxi_exclude_taxonomies', (class_exists('PMWI_Plugin')) ? array('post_format', 'product_type', 'product_shipping_class', 'product_visibility') : array('post_format'));
			$post_taxonomies = array_diff_key(get_taxonomies_by_object_type(array($this->options['custom_type']), 'object'), array_flip($exclude_taxonomies));
            if ( $this->is_parsing_required('is_update_categories') && ! empty($post_taxonomies) && ! in_array($this->options['custom_type'], array('import_users', 'taxonomies', 'shop_customer', 'comments', 'reviews')) ):
				foreach ($post_taxonomies as $ctx): if ("" == $ctx->labels->name or (class_exists('PMWI_Plugin') and strpos($ctx->name, "pa_") === 0 and $this->options['custom_type'] == "product")) continue;
					$chunk == 1 and $logger and call_user_func($logger, sprintf(__('Composing terms for `%s` taxonomy...', 'wp_all_import_plugin'), $ctx->labels->name));
					$tx_name = $ctx->name;
					$mapping_rules = ( ! empty($this->options['tax_mapping'][$tx_name])) ? json_decode($this->options['tax_mapping'][$tx_name], true) : false;
					$taxonomies[$tx_name] = array();
					if ( ! empty($this->options['tax_logic'][$tx_name]) and ! empty($this->options['tax_assing'][$tx_name]) ){
						switch ($this->options['tax_logic'][$tx_name]){
							case 'single':
								if ( isset($this->options['tax_single_xpath'][$tx_name]) && $this->options['tax_single_xpath'][$tx_name] !== "" ){
									$txes = XmlImportParser::factory($xml, $cxpath, $this->options['tax_single_xpath'][$tx_name], $file)->parse($records); $tmp_files[] = $file;		
									foreach ($txes as $i => $tx) {
										$taxonomies[$tx_name][$i][] = wp_all_import_ctx_mapping(array(
											'name' => $tx,
											'parent' => false,
											'assign' => (isset($this->options['term_assing'][$tx_name])) ? $this->options['term_assing'][$tx_name] : true,
											'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name])),
											'hierarchy_level' => 1,
											'max_hierarchy_level' => 1
										), $mapping_rules, $tx_name);
									}									
								}
								break;
							case 'multiple':
								if ( ! empty($this->options['tax_multiple_xpath'][$tx_name]) ){
									$txes = XmlImportParser::factory($xml, $cxpath, $this->options['tax_multiple_xpath'][$tx_name], $file)->parse($records); $tmp_files[] = $file;											
									foreach ($txes as $i => $tx) {
										$_tx = $tx;
										// apply mapping rules before splitting via separator symbol
										if ( ! empty($this->options['tax_enable_mapping'][$tx_name]) and ! empty($this->options['tax_logic_mapping'][$tx_name]) ){											
											if ( ! empty( $mapping_rules) ){			
												foreach ($mapping_rules as $rule) {
													if ( ! empty($rule[trim($_tx)])){ 
														$_tx = trim($rule[trim($_tx)]);
														break;
													}
												}
											}
										}										
										$delimeted_taxonomies = explode( ! empty($this->options['tax_multiple_delim'][$tx_name]) ? $this->options['tax_multiple_delim'][$tx_name] : ',', $_tx);										
										if ( ! empty($delimeted_taxonomies) ){
											foreach ($delimeted_taxonomies as $cc) {												
												$taxonomies[$tx_name][$i][] = wp_all_import_ctx_mapping(array(
													'name' => $cc,
													'parent' => false,
													'assign' => (isset($this->options['multiple_term_assing'][$tx_name])) ? $this->options['multiple_term_assing'][$tx_name] : true,
													'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]) and empty($this->options['tax_logic_mapping'][$tx_name])),
													'hierarchy_level' => 1,
													'max_hierarchy_level' => 1
												), $mapping_rules, $tx_name);
											}
										}										
									}
								}
								break;
							case 'hierarchical':
								if ( ! empty($this->options['tax_hierarchical_logic_entire'][$tx_name])){									
									if (! empty($this->options['tax_hierarchical_xpath'][$tx_name]) and is_array($this->options['tax_hierarchical_xpath'][$tx_name])){
										count($titles) and $iterator = array_fill(0, count($titles), 0);
										$taxonomies_hierarchy_groups = array_fill(0, count($titles), array());
										
										// separate hierarchy groups via symbol
										if ( ! empty($this->options['is_tax_hierarchical_group_delim'][$tx_name]) and ! empty($this->options['tax_hierarchical_group_delim'][$tx_name])){
											foreach ($this->options['tax_hierarchical_xpath'][$tx_name] as $k => $tx_xpath) { 
												if (empty($tx_xpath)) continue;
												$txes = XmlImportParser::factory($xml, $cxpath, $tx_xpath, $file)->parse($records); $tmp_files[] = $file;					
												foreach ($txes as $i => $tx) {
													$_tx = $tx;
													// apply mapping rules before splitting via separator symbol
													if ( ! empty($this->options['tax_enable_mapping'][$tx_name]) and ! empty($this->options['tax_logic_mapping'][$tx_name]) ){											
														if ( ! empty( $mapping_rules) ){			
															foreach ($mapping_rules as $rule) {
																if ( ! empty($rule[trim($_tx)])){ 
																	$_tx = trim($rule[trim($_tx)]);
																	break;
																}
															}
														}
													}
													$delimeted_groups = explode($this->options['tax_hierarchical_group_delim'][$tx_name], $_tx);
													if ( ! empty($delimeted_groups) and is_array($delimeted_groups)){
														foreach ($delimeted_groups as $group) {
															if ( ! empty($group) ) array_push($taxonomies_hierarchy_groups[$i], $group);
														}
													}
												}												
											}
										}
										else{
											foreach ($this->options['tax_hierarchical_xpath'][$tx_name] as $k => $tx_xpath) {
												if (empty($tx_xpath)) continue;
												$txes = XmlImportParser::factory($xml, $cxpath, $tx_xpath, $file)->parse($records); $tmp_files[] = $file;					
												foreach ($txes as $i => $tx) {													
													array_push($taxonomies_hierarchy_groups[$i], $tx);
												}
											}
										}
										
										foreach ($taxonomies_hierarchy_groups as $i => $groups) { if (empty($groups)) continue;
											foreach ($groups as $kk => $tx) {																																			
												$_tx = $tx;
												// apply mapping rules before splitting via separator symbol
												if ( ! empty($this->options['tax_enable_mapping'][$tx_name]) and ! empty($this->options['tax_logic_mapping'][$tx_name]) ){											
													if ( ! empty( $mapping_rules) ){			
														foreach ($mapping_rules as $rule) {															
															if ( ! empty($rule[trim($_tx)])){ 
																$_tx = trim($rule[trim($_tx)]);
																break;
															}
														}
													}
												}
												$delimeted_taxonomies = array_filter(array_filter(explode( ! empty($this->options['tax_hierarchical_delim'][$tx_name]) ? $this->options['tax_hierarchical_delim'][$tx_name] : ',', $_tx)));
												if ( ! empty($delimeted_taxonomies) ){															
													foreach ($delimeted_taxonomies as $j => $cc) {																												
														$is_assign_term = (isset($this->options['tax_hierarchical_assing'][$tx_name][$k])) ? $this->options['tax_hierarchical_assing'][$tx_name][$k] : true;
														if ( ! empty($this->options['tax_hierarchical_last_level_assign'][$tx_name]) ){
															$is_assign_term = (count($delimeted_taxonomies) == $j + 1) ? 1 : 0;
														}
                                                        $taxonomies[$tx_name][$i][] = wp_all_import_ctx_mapping(array(
                                                            'name' => $cc,
                                                            'parent' => (!empty($taxonomies[$tx_name][$i][$iterator[$i] - 1]) and $j) ? $taxonomies[$tx_name][$i][$iterator[$i] - 1] : false,
                                                            'assign' => $is_assign_term,
                                                            'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]) and empty($this->options['tax_logic_mapping'][$tx_name])),
                                                            'hierarchy_level' => $j + 1,
                                                            'max_hierarchy_level' => count($delimeted_taxonomies)
                                                        ), $mapping_rules, $tx_name);
														$iterator[$i]++;	
													}
												}													
											}
										}										
									}
								}
								if ( ! empty($this->options['tax_hierarchical_logic_manual'][$tx_name])){									
									if ( ! empty($this->options['post_taxonomies'][$tx_name]) ){
										$taxonomies_hierarchy = json_decode($this->options['post_taxonomies'][$tx_name], true);
										
										foreach ($taxonomies_hierarchy as $k => $taxonomy){	if ("" == $taxonomy['xpath']) continue;								
											$txes_raw =  XmlImportParser::factory($xml, $cxpath, $taxonomy['xpath'], $file)->parse($records); $tmp_files[] = $file;						
											$warned = array();
											
											foreach ($txes_raw as $i => $cc) {

												$_tx = $cc;
												// apply mapping rules before splitting via separator symbol
												if ( ! empty($this->options['tax_enable_mapping'][$tx_name]) and ! empty($this->options['tax_logic_mapping'][$tx_name]) ){											
													if ( ! empty( $mapping_rules) ){			
														foreach ($mapping_rules as $rule) {
															if ( ! empty($rule[trim($_tx)])){ 
																$_tx = trim($rule[trim($_tx)]);
																break;
															}
														}
													}
												}
												
												if ( ! empty($this->options['tax_manualhierarchy_delim'][$tx_name])){
													$delimeted_taxonomies = explode($this->options['tax_manualhierarchy_delim'][$tx_name], $_tx);
												}
												
												if ( empty($delimeted_taxonomies) ) continue;

												if (empty($taxonomies_hierarchy[$k]['txn_names'][$i])) $taxonomies_hierarchy[$k]['txn_names'][$i] = array();
												if (empty($taxonomies[$tx_name][$i])) $taxonomies[$tx_name][$i] = array();
												$count_cats = count($taxonomies[$tx_name][$i]);																											
												
												foreach ($delimeted_taxonomies as $j => $dc) {
													
													if (!empty($taxonomy['parent_id'])) {																			
														foreach ($taxonomies_hierarchy as $key => $value){
															if ($value['item_id'] == $taxonomy['parent_id'] and !empty($value['txn_names'][$i])){													
																foreach ($value['txn_names'][$i] as $parent) {																			
																	$taxonomies[$tx_name][$i][] = wp_all_import_ctx_mapping(array(
																		'name' => trim($dc),
																		'parent' => $parent,
																		'assign' => (isset($taxonomy['assign'])) ? $taxonomy['assign'] : true,
																		'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]) and empty($this->options['tax_logic_mapping'][$tx_name])),
																		'hierarchy_level' => 1,
																		'max_hierarchy_level' => 1
																	), $mapping_rules, $tx_name);

                                                                    $taxonomies_hierarchy[$k]['txn_names'][$i][] = $taxonomies[$tx_name][$i][count($taxonomies[$tx_name][$i]) - 1];
																}																												
															}
														}															
													}
													else {																
														$taxonomies[$tx_name][$i][] = wp_all_import_ctx_mapping(array(
															'name' => trim($dc),
															'parent' => false,
															'assign' => (isset($taxonomy['assign'])) ? $taxonomy['assign'] : true,
															'is_mapping' => (!empty($this->options['tax_enable_mapping'][$tx_name]) and empty($this->options['tax_logic_mapping'][$tx_name])),
															'hierarchy_level' => 1,
															'max_hierarchy_level' => 1
														), $mapping_rules, $tx_name);

                                                        $taxonomies_hierarchy[$k]['txn_names'][$i][] = $taxonomies[$tx_name][$i][count($taxonomies[$tx_name][$i]) - 1];
													}
												}																														
											}
										}
									}
								}																											
								break;

							default:
											
								break;
						}
					}
				endforeach;
			endif;			
			// [/custom taxonomies]							

			// [custom fields]
			$chunk == 1 and $logger and call_user_func($logger, __('Composing custom parameters...', 'wp_all_import_plugin'));
			$meta_keys = array(); $meta_values = array();			

            if ( $this->is_parsing_required('is_update_custom_fields') ){
                foreach ($this->options['custom_name'] as $j => $custom_name) {
                    $meta_keys[$j]   = XmlImportParser::factory($xml, $cxpath, $custom_name, $file)->parse($records); $tmp_files[] = $file;
                    if (is_serialized($this->options['custom_value'][$j])){
                        $meta_values[$j] = array_fill(0, count($titles), $this->options['custom_value'][$j]);
                    }
                    else{
                        if ('' != $this->options['custom_value'][$j] and ! is_serialized($this->options['custom_value'][$j])){
                            $meta_values[$j] = XmlImportParser::factory($xml, $cxpath, $this->options['custom_value'][$j], $file)->parse($records); $tmp_files[] = $file;
                            // mapping custom fields

                            if ( ! empty($this->options['custom_mapping_rules'][$j])){
                                $mapping_rules = (!empty($this->options['custom_mapping_rules'][$j])) ? json_decode($this->options['custom_mapping_rules'][$j], true) : false;
                                if ( ! empty($mapping_rules) and is_array($mapping_rules)){
                                    foreach ($meta_values[$j] as $key => $val) {
                                        foreach ($mapping_rules as $rule_number => $rule) {
                                            if ( isset($rule[trim($val)])){
                                                $meta_values[$j][$key] = trim($rule[trim($val)]);
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else{
                            $meta_values[$j] = array_fill(0, count($titles), '');
                        }
                    }
                }
            }

			// serialized custom post fields
			$serialized_meta = array();

			if ( ! empty($meta_keys) ){

				foreach ($meta_keys as $j => $custom_name) {

                    // custom field in serialized format
                    if (!empty($this->options['custom_format']) and $this->options['custom_format'][$j])
                    {
                        $meta_values[$j] = array_fill(0, count($titles), array());

                        $serialized_values = (!empty($this->options['serialized_values'][$j])) ? json_decode($this->options['serialized_values'][$j], true) : false;

                        if (!empty($serialized_values) and is_array($serialized_values)) {

                            $serialized_meta_keys = array(); $serialized_meta_values = array();

                            foreach ( array_filter($serialized_values) as $key => $value) {
                                $k = $key;
                                if (is_array($value)){
                                    $keys = array_keys($value);
                                    $k = $keys[0];
                                }
                                if (empty($k) or is_numeric($k)){
                                    array_push($serialized_meta_keys, array_fill(0, count($titles), $k));
                                }
                                else{
                                    array_push($serialized_meta_keys, XmlImportParser::factory($xml, $cxpath, $k, $file)->parse($records)); $tmp_files[] = $file;
                                }
                                $v = (is_array($value)) ? $value[$k] : $value;
                                if ( "" == $v){
                                    array_push($serialized_meta_values, array_fill(0, count($titles), ""));
                                }
                                elseif ( is_serialized($v) ){
                                    array_push($serialized_meta_values, array_fill(0, count($titles), $v));
                                }
                                else{
                                    array_push($serialized_meta_values, XmlImportParser::factory($xml, $cxpath, $v, $file)->parse($records)); $tmp_files[] = $file;
                                }
                            }

                            if (!empty($serialized_meta_keys)){
                                foreach ($serialized_meta_keys as $skey => $sval) {
                                    foreach ($sval as $ipost => $ival) {
                                        $v = (is_serialized($serialized_meta_values[$skey][$ipost])) ? unserialize($serialized_meta_values[$skey][$ipost]) : $serialized_meta_values[$skey][$ipost];
                                        ( "" == $ival ) ? array_push($meta_values[$j][$ipost], $v) : $meta_values[$j][$ipost][$ival] = $v;
                                    }
                                }
                            }
                        }
                    }

                    $serialized_meta[] = array( 'keys' => $custom_name, 'values' => $meta_values[$j] );

				}
			}	
			// [/custom fields]						

			// Composing featured images
			$image_sections = apply_filters('wp_all_import_image_sections', array( 
				array(
					'slug'  => '',
					'title' => __('Images', 'wp_all_import_plugin'),
					'type'  => 'images'
				)
			));	

			if ( ! (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
				$logger and call_user_func($logger, __('<b>WARNING</b>', 'wp_all_import_plugin') . ': ' . $uploads['error']);
				$logger and call_user_func($logger, __('<b>WARNING</b>: No featured images will be created. Uploads folder is not found.', 'wp_all_import_plugin'));				
				$logger and !$is_cron and PMXI_Plugin::$session->warnings++;				
			} else {
				$images_bundle = array();
				$auto_rename_images_bundle = array();
				$auto_extensions_bundle = array();
				$image_meta_titles_bundle = array();
				$image_meta_captions_bundle = array();
				$image_meta_alts_bundle = array();
				$image_meta_descriptions_bundle = array();

				if ( $this->is_parsing_required('is_update_images') ){
                    foreach ($image_sections as $section) {
                        $chunk == 1 and $logger and call_user_func($logger, __('Composing URLs for ' . strtolower($section['title']) . '...', 'wp_all_import_plugin'));
                        $featured_images = array();
                        if ( "no" == $this->options[$section['slug'] . 'download_images']){
                            if ($this->options[$section['slug'] . 'featured_image']) {
                                $featured_images = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'featured_image'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $featured_images = array_fill(0, count($titles), '');
                            }
                        }
                        elseif ("gallery" == $this->options[$section['slug'] . 'download_images']) {
                            if ($this->options[$section['slug'] . 'gallery_featured_image']) {
                                $featured_images = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'gallery_featured_image'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $featured_images = array_fill(0, count($titles), '');
                            }
                        }
                        else{
                            if ($this->options[$section['slug'] . 'download_featured_image']) {
                                $featured_images = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'download_featured_image'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $featured_images = array_fill(0, count($titles), '');
                            }
                        }

                        $images_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = array(
                            'type'  => $section['type'],
                            'files' => $featured_images
                        );

                        // Composing images meta titles
                        if ( $this->options[$section['slug'] . 'set_image_meta_title'] ){
                            $chunk == 1 and $logger and call_user_func($logger, __('Composing ' . strtolower($section['title']) . ' meta data (titles)...', 'wp_all_import_plugin'));
                            $image_meta_titles = array();
                            if ($this->options[$section['slug'] . 'image_meta_title']) {
                                $image_meta_titles = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'image_meta_title'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $image_meta_titles = array_fill(0, count($titles), '');
                            }
                            $image_meta_titles_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = $image_meta_titles;
                        }

                        // Composing images meta captions
                        if ( $this->options[$section['slug'] . 'set_image_meta_caption'] ){
                            $chunk == 1 and $logger and call_user_func($logger, __('Composing ' . strtolower($section['title']) . ' meta data (captions)...', 'wp_all_import_plugin'));
                            $image_meta_captions = array();
                            if ($this->options[$section['slug'] . 'image_meta_caption']) {
                                $image_meta_captions = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'image_meta_caption'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $image_meta_captions = array_fill(0, count($titles), '');
                            }
                            $image_meta_captions_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = $image_meta_captions;
                        }

                        // Composing images meta alt text
                        if ( $this->options[$section['slug'] . 'set_image_meta_alt'] ){
                            $chunk == 1 and $logger and call_user_func($logger, __('Composing ' . strtolower($section['title']) . ' meta data (alt text)...', 'wp_all_import_plugin'));
                            $image_meta_alts = array();
                            if ($this->options[$section['slug'] . 'image_meta_alt']) {
                                $image_meta_alts = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'image_meta_alt'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $image_meta_alts = array_fill(0, count($titles), '');
                            }
                            $image_meta_alts_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = $image_meta_alts;
                        }

                        // Composing images meta description
                        if ( $this->options[$section['slug'] . 'set_image_meta_description'] ){
                            $chunk == 1 and $logger and call_user_func($logger, __('Composing ' . strtolower($section['title']) . ' meta data (description)...', 'wp_all_import_plugin'));
                            $image_meta_descriptions = array();
                            if ($this->options[$section['slug'] . 'image_meta_description']) {
                                $image_meta_descriptions = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'image_meta_description'], $file)->parse($records); $tmp_files[] = $file;
                            } else {
                                count($titles) and $image_meta_descriptions = array_fill(0, count($titles), '');
                            }
                            $image_meta_descriptions_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = $image_meta_descriptions;
                        }


                        // Composing images suffix
                        $chunk == 1 and $this->options[$section['slug'] . 'auto_rename_images'] and $logger and call_user_func($logger, __('Composing ' . strtolower($section['title']) . ' suffix...', 'wp_all_import_plugin'));
                        $auto_rename_images = array();
                        if ( $this->options[$section['slug'] . 'auto_rename_images'] and ! empty($this->options[$section['slug'] . 'auto_rename_images_suffix'])){
                            $auto_rename_images = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'auto_rename_images_suffix'], $file)->parse($records); $tmp_files[] = $file;
                        }
                        else{
                            count($titles) and $auto_rename_images = array_fill(0, count($titles), '');
                        }
                        $auto_rename_images_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = $auto_rename_images;

                        // Composing images extensions
                        $chunk == 1 and $this->options[$section['slug'] . 'auto_set_extension'] and $logger and call_user_func($logger, __('Composing ' . strtolower($section['title']) . ' extensions...', 'wp_all_import_plugin'));
                        $auto_extensions = array();
                        if ( $this->options[$section['slug'] . 'auto_set_extension'] and ! empty($this->options[$section['slug'] . 'new_extension'])){
                            $auto_extensions = XmlImportParser::factory($xml, $cxpath, $this->options[$section['slug'] . 'new_extension'], $file)->parse($records); $tmp_files[] = $file;
                        }
                        else{
                            count($titles) and $auto_extensions = array_fill(0, count($titles), '');
                        }
                        $auto_extensions_bundle[ empty($section['slug']) ? 'pmxi_gallery_image' : $section['slug']] = $auto_extensions;

                    }
                }
			}

			// Composing attachments
			if ( ! (($uploads = wp_upload_dir()) && false === $uploads['error'])) {
				$logger and call_user_func($logger, __('<b>WARNING</b>', 'wp_all_import_plugin') . ': ' . $uploads['error']);				
				$logger and call_user_func($logger, __('<b>WARNING</b>: No attachments will be created', 'wp_all_import_plugin')); 				
				$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
			} else {
				$chunk == 1 and $logger and call_user_func($logger, __('Composing URLs for attachments files...', 'wp_all_import_plugin'));
				$attachments = array();

				if ($this->options['attachments'] && $this->is_parsing_required('is_update_attachments') ) {
					// Detect if attachments is separated by comma
					$atchs = empty($this->options['atch_delim']) ? explode(',', $this->options['attachments']) : explode($this->options['atch_delim'], $this->options['attachments']);
					if (!empty($atchs)){
						$parse_multiple = true;
						foreach($atchs as $atch) if (!preg_match("/{.*}/", trim($atch))) $parse_multiple = false;
						if ($parse_multiple) {
							foreach($atchs as $atch) {
								$posts_attachments = XmlImportParser::factory($xml, $cxpath, trim($atch), $file)->parse($records); $tmp_files[] = $file;																
								foreach($posts_attachments as $i => $val) $attachments[$i][] = $val;								
							}
						}
						else {
							$attachments = XmlImportParser::factory($xml, $cxpath, $this->options['attachments'], $file)->parse($records); $tmp_files[] = $file;								
						}
					}
				} else {
					count($titles) and $attachments = array_fill(0, count($titles), '');
				}
			}

			// Composing Comments data.
            if ( in_array($this->options['custom_type'], ['comments', 'reviews']) ) {

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment post...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_post'])){
                    $comment_post = XmlImportParser::factory($xml, $cxpath, $this->options['comment_post'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_post = array_fill(0, count($titles), '');
                }

                if ($this->options['custom_type'] == 'reviews') {
                    $chunk == 1 and $logger and call_user_func($logger, __('Composing comment ratings...', 'wp_all_import_plugin'));
                    if (!empty($this->options['comment_rating'])){
                        $comment_rating = XmlImportParser::factory($xml, $cxpath, $this->options['comment_rating'], $file)->parse($records); $tmp_files[] = $file;
                    } else {
                        count($titles) and $comment_rating = array_fill(0, count($titles), '');
                    }
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment author...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_author'])){
                    $comment_author = XmlImportParser::factory($xml, $cxpath, $this->options['comment_author'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_author = array_fill(0, count($titles), '');
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment author email...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_author_email'])){
                    $comment_author_email = XmlImportParser::factory($xml, $cxpath, $this->options['comment_author_email'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_author_email = array_fill(0, count($titles), '');
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment author url...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_author_url'])){
                    $comment_author_url = XmlImportParser::factory($xml, $cxpath, $this->options['comment_author_url'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_author_url = array_fill(0, count($titles), '');
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment author IP...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_author_IP'])){
                    $comment_author_ip = XmlImportParser::factory($xml, $cxpath, $this->options['comment_author_IP'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_author_ip = array_fill(0, count($titles), '');
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment karma...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_karma'])){
                    $comment_karma = XmlImportParser::factory($xml, $cxpath, $this->options['comment_karma'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_karma = array_fill(0, count($titles), '');
                }

                if ( "xpath" == $this->options['comment_approved'] ){
                    $chunk == 1 and $logger and call_user_func($logger, __('Composing comment approved...', 'wp_all_import_plugin'));
                    $comment_approved = array();
                    if (!empty($this->options['comment_approved_xpath'])){
                        $comment_approved = XmlImportParser::factory($xml, $cxpath, $this->options['comment_approved_xpath'], $file)->parse($records); $tmp_files[] = $file;
                    } else {
                        count($titles) and $comment_approved = array_fill(0, count($titles), 1);
                    }
                } else {
                    count($titles) and $comment_approved = array_fill(0, count($titles), 1);
                }

                if ($this->options['custom_type'] == 'reviews') {
                    if ( "xpath" == $this->options['comment_verified'] ){
                        $chunk == 1 and $logger and call_user_func($logger, __('Composing comment verified...', 'wp_all_import_plugin'));
                        $comment_verified = array();
                        if (!empty($this->options['comment_verified_xpath'])){
                            $comment_verified = XmlImportParser::factory($xml, $cxpath, $this->options['comment_verified_xpath'], $file)->parse($records); $tmp_files[] = $file;
                        } else {
                            count($titles) and $comment_verified = array_fill(0, count($titles), 1);
                        }
                    } else {
                        count($titles) and $comment_verified = array_fill(0, count($titles), 1);
                    }
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment agent...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_agent'])){
                    $comment_agent = XmlImportParser::factory($xml, $cxpath, $this->options['comment_agent'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_agent = array_fill(0, count($titles), '');
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment type...', 'wp_all_import_plugin'));
                count($titles) and $comment_type = array_fill(0, count($titles), '');
                if ( "xpath" == $this->options['comment_type'] && !empty($this->options['comment_type_xpath']) ){
                    $comment_type = XmlImportParser::factory($xml, $cxpath, $this->options['comment_type_xpath'], $file)->parse($records); $tmp_files[] = $file;
                }

                $chunk == 1 and $logger and call_user_func($logger, __('Composing comment parent...', 'wp_all_import_plugin'));
                if (!empty($this->options['comment_parent'])) {
                    $comment_parent = XmlImportParser::factory($xml, $cxpath, $this->options['comment_parent'], $file)->parse($records); $tmp_files[] = $file;
                } else {
                    count($titles) and $comment_parent = array_fill(0, count($titles), '');
                }

                $comment_user_id = array();
                if ( $this->is_parsing_required('is_update_comment_user_id') ) {
                    $chunk == 1 and $logger and call_user_func($logger, __('Composing Author User ID...', 'wp_all_import_plugin'));
                    if (!empty($this->options['comment_user_id']) && $this->options['comment_user_id'] !== 'exclude') {
                        switch ($this->options['comment_user_id']) {
                            case 'email':
                                foreach ($comment_author_email as $key => $author) {
                                    $user = get_user_by('email', $author);
                                    $comment_user_id[$key] = $user ? $user->ID : 0;
                                }
                                break;
                            default:
                                if (!empty($this->options['comment_user_id_xpath'])) {
                                    $comment_user_id = XmlImportParser::factory($xml, $cxpath, $this->options['comment_user_id_xpath'], $file)->parse($records); $tmp_files[] = $file;
                                    foreach ($comment_user_id as $key => $author) {
                                        $user = ctype_digit($author) ? get_user_by('id', $author) : FALSE;
                                        $comment_user_id[$key] = $user ? $user->ID : 0;
                                    }
                                } else {
                                    count($titles) and $comment_user_id = array_fill(0, count($titles), 0);
                                }
                                break;
                        }
                    } else {
                        count($titles) and $comment_user_id = array_fill(0, count($titles), 0);
                    }
                } else {
                    count($titles) and $comment_user_id = array_fill(0, count($titles), 0);
                }
            }

            // Parse post comments.
            $chunk == 1 and $logger and call_user_func($logger, __('Composing post comments...', 'wp_all_import_plugin'));
            $comments = [];
            foreach ($this->options['comments'] as $option => $option_xpath) {
                switch ($this->options['comments_repeater_mode']) {
                    case 'xml':
                        if (!empty($this->options['comments_repeater_mode_foreach'])) {
                            for ($k = 0; $k < count($titles); $k++) {
                                $base_xpath = '[' . ($k + 1) . ']/' . ltrim(trim($this->options['comments_repeater_mode_foreach'], '{}!'), '/');
                                $rows = \XmlImportParser::factory($xml, $cxpath . $base_xpath, "{.}", $file)->parse(); $tmp_files[] = $file;
                                if (!empty($option_xpath)) {
                                    $values = \XmlImportParser::factory($xml, $cxpath . $base_xpath, $option_xpath, $file)->parse(); $tmp_files[] = $file;
                                } else {
                                    count($rows) and $values = array_fill(0, count($rows), '');
                                }
                                $comments[$option][] = $values;
                            }
                        }
                        break;
                    default:
                        if (empty($this->options['comments_repeater_mode_separator'])) {
                            break;
                        }
                        if (!empty($option_xpath)){
                            $values = XmlImportParser::factory($xml, $cxpath, $option_xpath, $file)->parse($records); $tmp_files[] = $file;
                            foreach ($values as $key => $value) {
                                $values[$key] = explode($this->options['comments_repeater_mode_separator'], $value);
                            }
                        }
                        else{
                            count($titles) and $values = array_fill(0, count($titles), '');
                        }
                        $comments[$option] = $values;
                        break;
                }
            }

			$chunk == 1 and $logger and call_user_func($logger, __('Composing unique keys...', 'wp_all_import_plugin'));
			if (!empty($this->options['unique_key'])){
				$unique_keys = XmlImportParser::factory($xml, $cxpath, $this->options['unique_key'], $file)->parse($records); $tmp_files[] = $file;
			}
			else{
				count($titles) and $unique_keys = array_fill(0, count($titles), '');
			}

			$chunk == 1 and $logger and call_user_func($logger, __('Processing posts...', 'wp_all_import_plugin'));															

			$addons = array();
			$addons_data = array();

			// data parsing for WP All Import add-ons
			$chunk == 1 and $logger and call_user_func($logger, __('Data parsing via add-ons...', 'wp_all_import_plugin'));
			$parsingData = array(
				'import' => $this,
				'count'  => count($titles),
				'xml'    => $xml,
				'logger' => $logger,
				'chunk'  => $chunk,
				'xpath_prefix' => $xpath_prefix				
			);
			$parse_functions = apply_filters('wp_all_import_addon_parse', array());
			foreach (PMXI_Admin_Addons::get_active_addons() as $class) {							
				$model_class = str_replace("_Plugin", "_Import_Record", $class);	
				if (class_exists($model_class)){						
					$addons[$class] = new $model_class();
					$addons_data[$class] = ( method_exists($addons[$class], 'parse') ) ? $addons[$class]->parse($parsingData) : false;				
				}
				else {
					if ( ! empty($parse_functions[$class]) ){
						if ( is_array($parse_functions[$class]) and is_callable($parse_functions[$class]) or ! is_array($parse_functions[$class]) and function_exists($parse_functions[$class])  ){
							$addons_data[$class] = call_user_func($parse_functions[$class], $parsingData);					
						}
					}
				}
			}

			// save current import state to variables before import			
			$created = $this->created;
			$updated = $this->updated;
			$skipped = $this->skipped;			
			
			$specified_records = array();

			$simpleXml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
    
    		$rootNodes = $simpleXml->xpath($cxpath);

			if ($this->options['is_import_specified']) {
				$chunk == 1 and $logger and call_user_func($logger, __('Calculate specified records to import...', 'wp_all_import_plugin'));
                $import_specified_option = apply_filters('wp_all_import_specified_records', $this->options['import_specified'], $this->id, $rootNodes);
				foreach (preg_split('% *, *%', $import_specified_option, -1, PREG_SPLIT_NO_EMPTY) as $chank) {
					if (preg_match('%^(\d+)-(\d+)$%', $chank, $mtch)) {
						$specified_records = array_merge($specified_records, range(intval($mtch[1]), intval($mtch[2])));
					} else {
						$specified_records = array_merge($specified_records, array(intval($chank)));
					}
				}

			}

            //restore_error_handler();

			foreach ($titles as $i => $void) {

                //$errorHandler = new PMXI_Error($this->imported + $this->skipped + $i + 1);

                //set_error_handler( array($errorHandler, 'import_data_handler'), E_ALL | E_STRICT | E_WARNING );

                // Handle CLI progress bar.
                if ($progress) {
                    $progress->tick();
                }

                switch ($this->options['custom_type']) {
                    case 'taxonomies':
                        $custom_type_details = new stdClass();
                        $custom_type_details->labels = new stdClass();
                        $custom_type_details->labels->singular_name = __('Taxonomy Term', 'wp_all_import_plugin');
                        break;
                    case 'comments':
                        $custom_type_details = new stdClass();
                        $custom_type_details->labels = new stdClass();
                        $custom_type_details->labels->singular_name = __('Comment', 'wp_all_import_plugin');
                        break;
                    case 'reviews':
                        $custom_type_details = new stdClass();
                        $custom_type_details->labels = new stdClass();
                        $custom_type_details->labels->singular_name = __('Review', 'wp_all_import_plugin');
                        break;
                    default:
                        $custom_type_details = get_post_type_object($post_type[$i]);
                        break;
                }

				if ($is_cron and $cron_sleep) sleep($cron_sleep);		

				$logger and call_user_func($logger, __('---', 'wp_all_import_plugin'));
				$logger and call_user_func($logger, sprintf(__('Record #%s', 'wp_all_import_plugin'), $this->imported + $this->skipped + $i + 1));

				if ( "manual" == $this->options['duplicate_matching'] 
						and ! empty($specified_records) 
							and ! in_array($created + $updated + $skipped + 1, $specified_records) )
				{
					$skipped++;											
					$logger and call_user_func($logger, __('<b>SKIPPED</b>: by specified records option', 'wp_all_import_plugin'));
					$logger and !$is_cron and PMXI_Plugin::$session->warnings++;					
					$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
					$logger and !$is_cron and PMXI_Plugin::$session->save_data();								
					continue;																		
				}

                // Check if comment post exist.
                if (in_array($this->options['custom_type'], ['comments', 'reviews']) && ($this->options['update_all_data'] == 'yes' || $this->options['is_update_comment_post_id']) ) {
                    // Trying to find comment post by ID.
                    $comment_post_found = false;
                    if (!empty($comment_post[$i])) {
                        if (ctype_digit($comment_post[$i])) {
                            $comment_post_object = get_post($comment_post[$i]);
                            // Allow import reviews only for products.
                            if ($this->options['custom_type'] == 'reviews' && $comment_post_object && $comment_post_object->post_type !== 'product') {
                                $comment_post_found = false;
                            // Do not allow import comments for products.
                            } elseif ($this->options['custom_type'] == 'comments' && $comment_post_object && $comment_post_object->post_type === 'product') {
                                $comment_post_found = false;
                            } else {
                                $comment_post[$i] = $comment_post_object ? $comment_post_object->ID : FALSE;
                                if (!empty($comment_post[$i])) {
                                    $comment_post_found = true;
                                }
                            }
                        } else {
                            // Trying to find commented post by slug.
                            $args = array(
                                'name' => $comment_post[$i],
                                'post_type' => 'any',
                                'post_status' => 'any',
                                'numberposts' => 1
                            );
                            if ($this->options['custom_type'] == 'reviews') {
                                $args['post_type'] = 'product';
                            }
                            $comment_posts = get_posts($args);
                            if ( $comment_posts && ! is_wp_error($comment_posts)) {
                                // Do not allow import comments for products.
                                if ($this->options['custom_type'] == 'comments' && $comment_posts[0] && $comment_posts[0]->post_type === 'product') {
                                    $comment_post_found = false;
                                } else {
                                    $comment_post[$i] = $comment_posts[0]->ID;
                                    $comment_post_found = true;
                                }
                            }
                        }
                    }
                    if (empty($comment_post_found) || is_wp_error($comment_post[$i])){
                        $skipped++;
                        if($this->options['custom_type'] == 'reviews'){
                            $logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: Review product not found by id `%s`', 'wp_all_import_plugin'), $comment_post[$i]));
                        }else {
                            $logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: Comment post not found by id `%s`', 'wp_all_import_plugin'), $comment_post[$i]));
                        }
                        $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                        $logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
                        $logger and !$is_cron and PMXI_Plugin::$session->save_data();
                        continue;
                    }
                    if($this->options['custom_type'] == 'reviews') {
                        $logger and call_user_func($logger, sprintf(__('Review product was found `%s`', 'wp_all_import_plugin'), $comment_post[$i]));
                    }else {
                        $logger and call_user_func($logger, sprintf(__('Comment post was found `%s`', 'wp_all_import_plugin'), $comment_post[$i]));
                    }
                }
                // Check if comment parent exist.
                if (in_array($this->options['custom_type'], ['comments', 'reviews']) && ($this->options['update_all_data'] == 'yes' || $this->options['is_update_parent']) ) {
                    foreach ($comment_parent as $key => $comment_parent_identifier) {
                        $match_by_date = FALSE;
                        // Check if identifier is not a timestamp.
                        if (is_numeric($comment_parent_identifier) && strtotime(date('d-m-Y H:i:s', $comment_parent_identifier)) === (int) $comment_parent_identifier) {
                            $match_by_date = date('Y-m-d H:i:s', $time);
                        } elseif (!is_numeric($comment_parent_identifier)) {
                            $time = strtotime($comment_parent_identifier);
                            if ($time !== FALSE) {
                                $match_by_date = date('Y-m-d H:i:s', $time);
                            }
                        }
                        if ($match_by_date) {
                            $post_comments = get_comments([
                                'post_id' => $comment_post[$i]
                            ]);
                            if (!empty($post_comments)) {
                                foreach ($post_comments as $post_comment) {
                                    if ($post_comment->comment_date_gmt === get_gmt_from_date($match_by_date)) {
                                        $comment_parent[$key] = $post_comment->comment_ID;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }

				$logger and call_user_func($logger, __('<b>ACTION</b>: pmxi_before_post_import ...', 'wp_all_import_plugin'));
				do_action('pmxi_before_post_import', $this->id);

                // One new action per addon:
                foreach ( $addons_data as $addon => $data ) {
                    do_action( "pmxi_before_post_import_{$addon}", $data, $i, $this->id );
                }

				if ( empty($titles[$i]) && !in_array($this->options['custom_type'], array('shop_order', 'import_users', 'shop_customer', 'comments', 'reviews')) ) {
					if ( ! empty($addons_data['PMWI_Plugin']) and !empty($addons_data['PMWI_Plugin']['single_product_parent_ID'][$i]) ){
						$titles[$i] = $addons_data['PMWI_Plugin']['single_product_parent_ID'][$i] . ' Product Variation';
					}					
					else{
						$logger and call_user_func($logger, __('<b>WARNING</b>: title is empty.', 'wp_all_import_plugin'));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
					}
				}				

				switch ($this->options['custom_type']){
                    case 'import_users':
                        $articleData = apply_filters('wp_all_import_combine_article_data', array(
                            'user_pass' => $addons_data['PMUI_Plugin']['pmui_pass'][$i],
                            'user_login' => $addons_data['PMUI_Plugin']['pmui_logins'][$i],
                            'user_nicename' => $addons_data['PMUI_Plugin']['pmui_nicename'][$i],
                            'user_url' =>  $addons_data['PMUI_Plugin']['pmui_url'][$i],
                            'user_email' =>  $addons_data['PMUI_Plugin']['pmui_email'][$i],
                            'display_name' =>  $addons_data['PMUI_Plugin']['pmui_display_name'][$i],
                            'user_registered' =>  $addons_data['PMUI_Plugin']['pmui_registered'][$i],
                            'first_name' =>  $addons_data['PMUI_Plugin']['pmui_first_name'][$i],
                            'last_name' =>  $addons_data['PMUI_Plugin']['pmui_last_name'][$i],
                            'description' =>  $addons_data['PMUI_Plugin']['pmui_description'][$i],
                            'nickname' => $addons_data['PMUI_Plugin']['pmui_nickname'][$i],
                            'role' => ('' == $addons_data['PMUI_Plugin']['pmui_role'][$i]) ? 'subscriber' : $addons_data['PMUI_Plugin']['pmui_role'][$i],
                        ), $this->options['custom_type'], $this->id, $i);
                        $logger and call_user_func($logger, sprintf(__('Combine all data for user %s...', 'wp_all_import_plugin'), $articleData['user_login']));

						break;
						
					case 'shop_customer':
						
                        $articleData = apply_filters('wp_all_import_combine_article_data', array(
                            'user_pass' => $addons_data['PMUI_Plugin']['pmsci_customer_pass'][$i],
                            'user_login' => $addons_data['PMUI_Plugin']['pmsci_customer_logins'][$i],
                            'user_nicename' => $addons_data['PMUI_Plugin']['pmsci_customer_nicename'][$i],
                            'user_url' =>  $addons_data['PMUI_Plugin']['pmsci_customer_url'][$i],
                            'user_email' =>  $addons_data['PMUI_Plugin']['pmsci_customer_email'][$i],
                            'display_name' =>  $addons_data['PMUI_Plugin']['pmsci_customer_display_name'][$i],
                            'user_registered' =>  $addons_data['PMUI_Plugin']['pmsci_customer_registered'][$i],
                            'first_name' =>  $addons_data['PMUI_Plugin']['pmsci_customer_first_name'][$i],
                            'last_name' =>  $addons_data['PMUI_Plugin']['pmsci_customer_last_name'][$i],
                            'description' =>  $addons_data['PMUI_Plugin']['pmsci_customer_description'][$i],
                            'nickname' => $addons_data['PMUI_Plugin']['pmsci_customer_nickname'][$i],
                            'role' => ( '' == $addons_data['PMUI_Plugin']['pmsci_customer_role'][$i]) ? 'customer' : $addons_data['PMUI_Plugin']['pmsci_customer_role'][$i],

                        ), $this->options['custom_type'], $this->id, $i);
                        $logger and call_user_func($logger, sprintf(__('Combine account data for customer %s...', 'wp_all_import_plugin'), $articleData['user_login']));
						
						$billing_data = array(

							'billing_first_name' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_first_name'][$i],
							'billing_last_name' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_last_name'][$i],
							'billing_company' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_company'][$i],
							'billing_address_1' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_address_1'][$i],
							'billing_address_2' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_address_2'][$i],
							'billing_city' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_city'][$i],
							'billing_postcode' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_postcode'][$i],
							'billing_country' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_country'][$i],
							'billing_state' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_state'][$i],
							'billing_phone' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_phone'][$i],
							'billing_email' => $addons_data['PMUI_Plugin']['pmsci_customer_billing_email'][$i],

                        );
						$logger and call_user_func($logger, sprintf(__('Combine billing data for customer %s...', 'wp_all_import_plugin'), $articleData['user_login']));
						
						$shipping_data = array(

							'shipping_first_name' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_first_name'][$i],
							'shipping_last_name' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_last_name'][$i],
							'shipping_company' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_company'][$i],
							'shipping_address_1' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_address_1'][$i],
							'shipping_address_2' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_address_2'][$i],
							'shipping_city' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_city'][$i],
							'shipping_postcode' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_postcode'][$i],
							'shipping_country' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_country'][$i],
							'shipping_state' => $addons_data['PMUI_Plugin']['pmsci_customer_shipping_state'][$i],

                        );
						$logger and call_user_func($logger, sprintf(__('Combine shipping data for customer %s...', 'wp_all_import_plugin'), $articleData['user_login']));
						
						break;

                    case 'taxonomies':
                        $taxonomy_type = get_taxonomy( $this->options['taxonomy_type'] );
                        $parent_term_id = 0;
                        if ( ! empty($taxonomy_parent[$i]) && $taxonomy_type->hierarchical){
                            $parent_term = get_term_by('slug', $taxonomy_parent[$i], $this->options['taxonomy_type']) or $parent_term = get_term_by('name', $taxonomy_parent[$i], $this->options['taxonomy_type']) or ctype_digit($taxonomy_parent[$i]) and $parent_term = get_term_by('id', $taxonomy_parent[$i], $this->options['taxonomy_type']);
                            if (!empty($parent_term) && !is_wp_error($parent_term)){
                                $parent_term_id = $parent_term->term_id;
                            }
                        }
                        $articleData = apply_filters('wp_all_import_combine_article_data', array(
                            'post_type' => $post_type[$i],
                            'post_title' => (!empty($this->options['is_leave_html'])) ? html_entity_decode($titles[$i]) : $titles[$i],
                            'post_parent' => $parent_term_id,
                            'post_content' => apply_filters('pmxi_the_content', ((!empty($this->options['is_leave_html'])) ? html_entity_decode($contents[$i]) : $contents[$i]), $this->id),
                            'menu_order' => (int) $menu_order[$i],
                            'slug' => $taxonomy_slug[$i],
                            'taxonomy' => $this->options['taxonomy_type']
                        ), $this->options['custom_type'], $this->id, $i);
                        $logger and call_user_func($logger, sprintf(__('Combine all data for term %s...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                        break;
                    case 'reviews':
                    case 'comments':
                        $articleData = apply_filters('wp_all_import_combine_article_data', array(
                            'comment_post_ID' => $comment_post[$i],
                            'comment_author' => $comment_author[$i],
                            'comment_author_email' => $comment_author_email[$i],
                            'comment_author_url' => $comment_author_url[$i],
                            'comment_author_IP' => $comment_author_ip[$i],
                            'comment_date' => $dates[$i],
                            'comment_date_gmt' => get_gmt_from_date($dates[$i]),
                            'comment_content' => apply_filters('pmxi_the_content', ((!empty($this->options['is_leave_html'])) ? html_entity_decode($contents[$i]) : $contents[$i]), $this->id),
                            'comment_karma' => intval($comment_karma[$i]),
                            'comment_approved' => intval($comment_approved[$i]),
                            'comment_agent' => $comment_agent[$i],
                            'comment_type' => $this->options['custom_type'] == 'reviews' ? 'review' : $comment_type[$i],
                            'comment_parent' => $comment_parent[$i],
                            'user_id' => $comment_user_id[$i]
                        ), $this->options['custom_type'], $this->id, $i);
                        $logger and call_user_func($logger, __('Combine all data for comment ...', 'wp_all_import_plugin'));
                        break;
                    default:
                        $articleData = apply_filters('wp_all_import_combine_article_data', array(
                            'post_type' => $post_type[$i],
                            'post_status' => ("xpath" == $this->options['status']) ? $post_status[$i] : $this->options['status'],
                            'comment_status' => ("xpath" == $this->options['comment_status']) ? $comment_status[$i] : $this->options['comment_status'],
                            'ping_status' => ("xpath" == $this->options['ping_status']) ? $ping_status[$i] : $this->options['ping_status'],
                            'post_title' => (!empty($this->options['is_leave_html'])) ? html_entity_decode($titles[$i]) : $titles[$i],
                            'post_excerpt' => apply_filters('pmxi_the_excerpt', ((!empty($this->options['is_leave_html'])) ? html_entity_decode($post_excerpt[$i]) : $post_excerpt[$i]), $this->id),
                            'post_name' => $post_slug[$i],
                            'post_content' => apply_filters('pmxi_the_content', ((!empty($this->options['is_leave_html'])) ? html_entity_decode($contents[$i]) : $contents[$i]), $this->id),
                            'post_date' => $dates[$i],
                            'post_date_gmt' => get_gmt_from_date($dates[$i]),
                            'post_author' => $post_author[$i],
                            'menu_order' => (int) $menu_order[$i],
                            'post_parent' => ("no" == $this->options['is_multiple_page_parent']) ? wp_all_import_get_parent_post($page_parent[$i], $post_type[$i], $this->options['type']) : (int) $this->options['parent'],
                            'page_template' => ("no" == $this->options['is_multiple_page_template']) ? $page_template[$i] : $this->options['page_template']
                        ), $this->options['custom_type'], $this->id, $i);
                        if ( 'shop_coupon' == $post_type[$i] ){
                            $articleData['post_excerpt'] = $articleData['post_content'];
                        }
                        $logger and call_user_func($logger, sprintf(__('Combine all data for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                        // if ( "xpath" == $this->options['status'] )
                        // {
                        // 	$status_object = get_post_status_object($post_status[$i]);

                        // 	if ( empty($status_object) )
                        // 	{
                        // 		$articleData['post_status'] = 'draft';
                        // 		$logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: Post status `%s` is not supported, post `%s` will be saved in draft.', 'wp_all_import_plugin'), $post_status[$i], $articleData['post_title']));
                        // 		$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                        // 	}
                        // }
                        break;
                }
				
				// Re-import Records Matching
				$post_to_update = false; $post_to_update_id = false;

				// An array representation of current XML node
				$current_xml_node = wp_all_import_xml2array($rootNodes[$i]);				

				$check_for_duplicates = apply_filters('wp_all_import_is_check_duplicates', true, $this->id);

				if ( $check_for_duplicates )
				{					
					// if Auto Matching re-import option selected
					if ( "manual" != $this->options['duplicate_matching'] ){
						
						// find corresponding article among previously imported				
						$logger and call_user_func($logger, sprintf(__('Find corresponding article among previously imported for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                        $postList = new PMXI_Post_List();
                        $args = array(
                            'unique_key' => $unique_keys[$i],
                            'import_id' => $this->id,
                        );
                        $postRecord->clear();
                        foreach($postList->getBy($args)->convertRecords() as $postRecord) {
                            if ( ! $postRecord->isEmpty() ) {
                                switch ($this->options['custom_type']){
									case 'import_users':
									case 'shop_customer':
                                        $post_to_update = get_user_by('id', $post_to_update_id = $postRecord->post_id);
                                        break;
                                    case 'taxonomies':
                                        $post_to_update = get_term_by('id', $post_to_update_id = $postRecord->post_id, $this->options['taxonomy_type']);
                                        break;
                                    case 'reviews':
                                    case 'comments':
                                        $post_to_update_id = $postRecord->post_id;
                                        $post_to_update = get_comment($post_to_update_id);
                                        break;
                                    default:
                                        $post_to_update = get_post($post_to_update_id = $postRecord->post_id);
                                        break;
                                }
                            }
                            if ($post_to_update){
                                $logger and call_user_func($logger, sprintf(__('Duplicate post was found for post %s with unique key `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $unique_keys[$i]));
                                break;
                            }
                            else{
                                $postRecord->delete();
                            }
                        }

                        if (empty($post_to_update)) {
                            $logger and call_user_func($logger, sprintf(__('Duplicate post wasn\'t found with unique key `%s`...', 'wp_all_import_plugin'), $unique_keys[$i]));
                        }
																	
					// if Manual Matching re-import option seleted
					} else {
											
						if ('custom field' == $this->options['duplicate_indicator']) {
							$custom_duplicate_value = XmlImportParser::factory($xml, $cxpath, $this->options['custom_duplicate_value'], $file)->parse($records); $tmp_files[] = $file;
							$custom_duplicate_name = XmlImportParser::factory($xml, $cxpath, $this->options['custom_duplicate_name'], $file)->parse($records); $tmp_files[] = $file;
						}
						else{
							count($titles) and $custom_duplicate_name = $custom_duplicate_value = array_fill(0, count($titles), '');
						}
						
						$logger and call_user_func($logger, sprintf(__('Find corresponding article among database for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));

                        $duplicates = array();
						if ('pid' == $this->options['duplicate_indicator']) {
							$duplicate_id = $duplicate_indicator_values[$i];
							if ($duplicate_id && !in_array($this->options['custom_type'], array('import_users', 'shop_customer', 'taxonomies', 'comments', 'reviews'))) {
                                $duplicate_post_type = get_post_type($duplicate_id);
                                if ($articleData['post_type'] == 'product' && $duplicate_post_type == 'product_variation') {
                                    $duplicate_post_type = 'product';
                                }
                                if ($duplicate_post_type !== $articleData['post_type']) {
                                    $duplicate_id = false;
                                }
                            }
						}
						// handle duplicates according to import settings
						else 
						{
							$duplicates = pmxi_findDuplicates($articleData, $custom_duplicate_name[$i], $custom_duplicate_value[$i], $this->options['duplicate_indicator'], $duplicate_indicator_values[$i]);
							$duplicate_id = ( ! empty($duplicates)) ? array_shift($duplicates) : false;							
						}					

						if ( ! empty($duplicate_id)) {
                            $duplicate_id = apply_filters('wp_all_import_manual_matching_duplicate_id', $duplicate_id, $duplicates, $articleData, $this->id);
							$logger and call_user_func($logger, sprintf(__('Duplicate post was found for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                            switch ($this->options['custom_type']){
								case 'import_users':
								case 'shop_customer':
                                    $post_to_update = get_user_by('id', $post_to_update_id = $duplicate_id);
                                    break;
                                case 'reviews':
                                case 'comments':
                                    $post_to_update_id = $duplicate_id;
                                    $post_to_update = get_comment($post_to_update_id);
                                    break;
                                case 'taxonomies':
                                    if (class_exists('WPAI_WPML') && ! empty($this->options['wpml_addon']['lng'])){
                                        // trying to find needed translation for update
                                        $duplicate_id = apply_filters('wpml_object_id', $duplicate_id, $this->options['taxonomy_type'], true, $this->options['wpml_addon']['lng']);
                                    }
                                    $post_to_update = get_term_by('id', $post_to_update_id = $duplicate_id, $this->options['taxonomy_type']);
                                    break;
                                default:
                                    if (class_exists('WPAI_WPML') && ! empty($this->options['wpml_addon']['lng'])){
                                        // trying to find needed translation for update
                                        $duplicate_id = apply_filters('wpml_object_id', $duplicate_id, get_post_type($duplicate_id), true, $this->options['wpml_addon']['lng']);
                                    }
                                    $post_to_update = get_post($post_to_update_id = $duplicate_id);
                                    break;
                            }
						}	
						else{
							$logger and call_user_func($logger, sprintf(__('Duplicate post wasn\'t found for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
						}
					}
				}	

				$is_post_to_skip = apply_filters('wp_all_import_is_post_to_skip', false, $this->id, $current_xml_node, $i, $post_to_update_id, $simpleXml);

				if ( $is_post_to_skip ) {
                    if ( ! $postRecord->isEmpty() ) {
                        $postRecord->set(array('iteration' => $this->iteration))->update();
                    }
					$skipped++;																
					$logger and !$is_cron and PMXI_Plugin::$session->warnings++;					
					$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
					$logger and !$is_cron and PMXI_Plugin::$session->save_data();						
					continue;																		
				}			

				if ( ! empty($specified_records) ) {
					if ( ! in_array($created + $updated + $skipped + 1, $specified_records) ) {
						if ( ! $postRecord->isEmpty() ) {
                            $postRecord->set(array('iteration' => $this->iteration))->update();
                        }
						$skipped++;											
						$logger and call_user_func($logger, __('<b>SKIPPED</b>: by specified records option', 'wp_all_import_plugin'));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;					
						$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
						$logger and !$is_cron and PMXI_Plugin::$session->save_data();						
						continue;
					}										
				}				

				$hash_ignore_options = array(
                    'scheduling_timezone' => '',
                    'scheduling_times' => '',
                    'scheduling_monthly_day' => '',
                    'scheduling_run_on' => '',
                    'scheduling_weekly_days' => '',
                    'scheduling_enable' => '',
                    'enable_import_scheduling' => '',
                    'is_scheduled' => '',
                    'scheduled_period' => '',
                    'do_not_remove_images' => '',
                    'friendly_name' => '',
                    'is_import_specified' => '',
                    'import_specified' => '',
                    'import_processing' => '',
                    'records_per_request' => '',
                    'chuncking' => '',
                    'is_delete_source' => ''
                );

				$missing_images = array();
				// Duplicate record is found
				if ($post_to_update){

					$continue_import = true;
					$hash_matched = false;
                    // allow the hash checks to be disabled via the import option and disable hash checks if images are
                    // set to be imported every time
                    if( $this->options['is_keep_former_posts'] == "no" && !empty($this->options['is_selective_hashing']) && $this->options['do_not_remove_images'] == 1) {
                        // check if hash has changed ( which means either the file record or import options have changed )
                        // if the import options change or the file record data changes the hash is invalidated and the record will be updated
                        // sanitize values in the options array that shouldn't invalidate the cache
                        $options = array_diff_key($this->options, $hash_ignore_options);

                        $hash = md5(serialize($options) . $this->id . $post_to_update_id . json_encode($current_xml_node));

                        if ($this->wpdb->get_row('SELECT `hash` FROM ' . $this->wpdb->prefix . 'pmxi_hash WHERE hash = unhex(\'' . $hash . '\')') !== NULL) {
                            // match found
                            $continue_import = false;
                            $hash_matched = true;
                        }
                        // end hash check
                    }

					$continue_import = apply_filters('wp_all_import_is_post_to_update', $continue_import, $post_to_update_id, $current_xml_node, $this->id, $simpleXml);

					if ( ! $continue_import ){

						if ( ! $postRecord->isEmpty() ) $postRecord->set(array('iteration' => $this->iteration))->update();	

						$skipped++;

						if( ! $hash_matched ) {
                            $logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: By filter wp_all_import_is_post_to_update `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                        } else {
                            if (!$is_cron) {
                                PMXI_Plugin::$session->skipped++;
                            }
                            $logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: Record data unchanged for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                        }

						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;							
						$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;	
						$logger and !$is_cron and PMXI_Plugin::$session->save_data();	
						do_action('wp_all_import_post_skipped', $post_to_update_id, $this->id, $current_xml_node);
						continue;
					}

					//$logger and call_user_func($logger, sprintf(__('Duplicate record is found for `%s`', 'wp_all_import_plugin'), $articleData['post_title']));

					// Do not update already existing records option selected
					if ("yes" == $this->options['is_keep_former_posts']) {	

						if ( ! $postRecord->isEmpty() ) $postRecord->set(array('iteration' => $this->iteration))->update();	

						do_action('pmxi_do_not_update_existing', $post_to_update_id, $this->id, $this->iteration, $xml, $i);

						$skipped++;
						$logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: Previously imported record found for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;							
						$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;	
						$logger and !$is_cron and PMXI_Plugin::$session->save_data();	
						do_action('wp_all_import_post_skipped', $post_to_update_id, $this->id, $current_xml_node);
						continue;
					}

                    // This action fires just before preserving data from previously imported post.
                    do_action('wp_all_import_before_preserve_post_data', $this, $post_to_update_id, $articleData);

					$articleData['ID'] = $post_to_update_id;					
					// Choose which data to update
					if ( $this->options['update_all_data'] == 'no' ){

                        switch ($this->options['custom_type']){
                            case 'import_users':
                                if ( ! $this->options['is_update_first_name'] ) $articleData['first_name'] = $post_to_update->first_name;
                                if ( ! $this->options['is_update_last_name'] ) $articleData['last_name'] = $post_to_update->last_name;
                                if ( ! $this->options['is_update_role'] ) unset($articleData['role']);
                                if ( ! $this->options['is_update_nickname'] ) $articleData['nickname'] = get_user_meta($post_to_update->ID, 'nickname', true);
                                if ( ! $this->options['is_update_description'] ) $articleData['description'] = get_user_meta($post_to_update->ID, 'description', true);
								
								if ( ! $this->options['is_update_login'] ) {
									$articleData['user_login'] = $post_to_update->user_login;
								} elseif( empty($articleData['user_login']) ) {
									$articleData['user_login'] = $post_to_update->user_login;
									$logger and call_user_func($logger, sprintf(__('No username provided for user ID `%s`, preserve existing username for user.', 'wp_all_import_plugin'), $articleData['ID']));
								}
								
								if ( ! $this->options['is_update_password'] ) unset($articleData['user_pass']);
                                if ( ! $this->options['is_update_nicename'] ) $articleData['user_nicename'] = $post_to_update->user_nicename;
								
								if ( ! $this->options['is_update_email'] ) {
									$articleData['user_email'] = $post_to_update->user_email;
								} elseif( empty($articleData['user_email']) ) {
									$articleData['user_email'] = $post_to_update->user_email;
									$logger and call_user_func($logger, sprintf(__('No email provided for user ID `%s`, preserve existing email for user.', 'wp_all_import_plugin'), $articleData['ID']));
								}
								
								if ( ! $this->options['is_update_registered'] ) $articleData['user_registered'] = $post_to_update->user_registered;
                                if ( ! $this->options['is_update_display_name'] ) $articleData['display_name'] = $post_to_update->display_name;
                                if ( ! $this->options['is_update_url'] ) $articleData['user_url'] = $post_to_update->user_url;

								break;
							case 'shop_customer':
                                if ( ! $this->options['is_update_first_name'] ) $articleData['first_name'] = $post_to_update->first_name;
                                if ( ! $this->options['is_update_last_name'] ) $articleData['last_name'] = $post_to_update->last_name;
                                if ( ! $this->options['is_update_role'] ) unset($articleData['role']);
                                if ( ! $this->options['is_update_nickname'] ) $articleData['nickname'] = get_user_meta($post_to_update->ID, 'nickname', true);
                                if ( ! $this->options['is_update_description'] ) $articleData['description'] = get_user_meta($post_to_update->ID, 'description', true);
								
								if ( ! $this->options['is_update_login'] ) {
									$articleData['user_login'] = $post_to_update->user_login;
								} elseif( empty($articleData['user_login']) ) {
									$articleData['user_login'] = $post_to_update->user_login;
									$logger and call_user_func($logger, sprintf(__('No username provided for customer ID `%s`, preserve existing username for customer.', 'wp_all_import_plugin'), $articleData['ID']));
								}
								
								if ( ! $this->options['is_update_password'] ) unset($articleData['user_pass']);
                                if ( ! $this->options['is_update_nicename'] ) $articleData['user_nicename'] = $post_to_update->user_nicename;
								
								if ( ! $this->options['is_update_email'] ) {
									$articleData['user_email'] = $post_to_update->user_email;
								} elseif( empty($articleData['user_email']) ) {
									$articleData['user_email'] = $post_to_update->user_email;
									$logger and call_user_func($logger, sprintf(__('No email provided for customer ID `%s`, preserve existing email for customer.', 'wp_all_import_plugin'), $articleData['ID']));
								}
								
								if ( ! $this->options['is_update_registered'] ) $articleData['user_registered'] = $post_to_update->user_registered;
                                if ( ! $this->options['is_update_display_name'] ) $articleData['display_name'] = $post_to_update->display_name;
                                if ( ! $this->options['is_update_url'] ) $articleData['user_url'] = $post_to_update->user_url;

								break;

                            case 'taxonomies':
                                if ( ! $this->options['is_update_content']){
                                    $articleData['post_content'] = $post_to_update->description;
                                    $logger and call_user_func($logger, sprintf(__('Preserve description of already existing taxonomy term for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_title']){
                                    $articleData['post_title'] = $post_to_update->name;
                                    $logger and call_user_func($logger, sprintf(__('Preserve name of already existing taxonomy term for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_slug']){
                                    $articleData['slug'] = $post_to_update->slug;
                                    $logger and call_user_func($logger, sprintf(__('Preserve slug of already existing taxonomy term for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_parent']){
                                    $articleData['post_parent'] = $post_to_update->parent;
                                    $logger and call_user_func($logger, sprintf(__('Preserve parent of already existing taxonomy term for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                break;
                            case 'reviews':
                            case 'comments':
                                if ( ! $this->options['is_update_comment_post_id']){
                                    $articleData['comment_post_ID'] = $post_to_update->comment_post_ID;
                                    $logger and call_user_func($logger, sprintf(__('Preserve parent post of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_post_ID']));
                                }
                                if ( ! $this->options['is_update_content']){
                                    $articleData['comment_content'] = $post_to_update->comment_content;
                                    $logger and call_user_func($logger, sprintf(__('Preserve content of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_author']){
                                    $articleData['comment_author'] = $post_to_update->comment_author;
                                    $logger and call_user_func($logger, sprintf(__('Preserve author of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_author_email']){
                                    $articleData['comment_author_email'] = $post_to_update->comment_author_email;
                                    $logger and call_user_func($logger, sprintf(__('Preserve author email of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_author_url']){
                                    $articleData['comment_author_url'] = $post_to_update->comment_author_url;
                                    $logger and call_user_func($logger, sprintf(__('Preserve author URL of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_author_IP']){
                                    $articleData['comment_author_IP'] = $post_to_update->comment_author_IP;
                                    $logger and call_user_func($logger, sprintf(__('Preserve author IP of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_dates']){
                                    $articleData['comment_date'] = $post_to_update->comment_date;
                                    $articleData['comment_date_gmt'] = $post_to_update->comment_date_gmt;
                                    $logger and call_user_func($logger, sprintf(__('Preserve date of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_karma']){
                                    $articleData['comment_karma'] = $post_to_update->comment_karma;
                                    $logger and call_user_func($logger, sprintf(__('Preserve karma of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_approved']){
                                    $articleData['comment_approved'] = $post_to_update->comment_approved;
                                    $logger and call_user_func($logger, sprintf(__('Preserve approved of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_agent']){
                                    $articleData['comment_agent'] = $post_to_update->comment_agent;
                                    $logger and call_user_func($logger, sprintf(__('Preserve agent of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_type']){
                                    $articleData['comment_type'] = $post_to_update->comment_type;
                                    $logger and call_user_func($logger, sprintf(__('Preserve type of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_user_id']){
                                    $articleData['user_id'] = $post_to_update->user_id;
                                    $logger and call_user_func($logger, sprintf(__('Preserve Author User ID of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['user_id']));
                                }
                                if ( ! $this->options['is_update_parent']){
                                    $articleData['comment_parent'] = $post_to_update->comment_parent;
                                    $logger and call_user_func($logger, sprintf(__('Preserve parent comment of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_verified']){
                                    $comment_verified[$i] = get_comment_meta($post_to_update_id, 'verified', true);
                                    $logger and call_user_func($logger, sprintf(__('Preserve verified status of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                if ( ! $this->options['is_update_comment_rating']){
                                    $comment_rating[$i] = get_comment_meta($post_to_update_id, 'rating', true);
                                    $logger and call_user_func($logger, sprintf(__('Preserve rating of already existing comment for `%s`', 'wp_all_import_plugin'), $articleData['comment_author']));
                                }
                                break;
                            default:
                                // preserve date of already existing article when duplicate is found
                                if ( ( ! $this->options['is_update_categories'] and ( is_object_in_taxonomy( $post_type[$i], 'category' ) or is_object_in_taxonomy( $post_type[$i], 'post_tag' ) ) ) or ($this->options['is_update_categories'] and $this->options['update_categories_logic'] != "full_update")) {
                                    $logger and call_user_func($logger, sprintf(__('Preserve taxonomies of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                    $existing_taxonomies = array();
                                    foreach (array_keys($taxonomies) as $tx_name) {
                                        $txes_list = get_the_terms($articleData['ID'], $tx_name);
                                        if (is_wp_error($txes_list)) {
                                            $logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: Unable to get current taxonomies for article #%d, updating with those read from XML file', 'wp_all_import_plugin'), $articleData['ID']));
                                            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                        } else {
                                            $txes_new = array();
                                            if (!empty($txes_list)):
                                                foreach ($txes_list as $t) {
                                                    $txes_new[] = $t->term_taxonomy_id;
                                                }
                                            endif;
                                            $existing_taxonomies[$tx_name][$i] = $txes_new;
                                        }
                                    }
                                }

                                if ( ! $this->options['is_update_dates']) { // preserve date of already existing article when duplicate is found
                                    $articleData['post_date'] = $post_to_update->post_date;
                                    $articleData['post_date_gmt'] = $post_to_update->post_date_gmt;
                                    $logger and call_user_func($logger, sprintf(__('Preserve date of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_status']) { // preserve status and trashed flag
                                    $articleData['post_status'] = $post_to_update->post_status;
                                    $logger and call_user_func($logger, sprintf(__('Preserve status of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_content']){
                                    $articleData['post_content'] = $post_to_update->post_content;
                                    $logger and call_user_func($logger, sprintf(__('Preserve content of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_title']){
                                    $articleData['post_title'] = $post_to_update->post_title;
                                    $logger and call_user_func($logger, sprintf(__('Preserve title of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_slug']){
                                    $articleData['post_name'] = $post_to_update->post_name;
                                    $logger and call_user_func($logger, sprintf(__('Preserve slug of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                // Check for changed slugs for published post objects and save the old slug.
                                if( ! empty($articleData['post_name']) and $articleData['post_name'] != $post_to_update->post_name)
                                {
                                    $old_slugs = (array) get_post_meta( $post_to_update_id, '_wp_old_slug' );

                                    // If we haven't added this old slug before, add it now.
                                    if ( ! empty( $post_to_update->post_name ) && ! in_array( $post_to_update->post_name, $old_slugs ) ) {
                                        add_post_meta( $post_to_update_id, '_wp_old_slug', $post_to_update->post_name );
                                    }

                                    // If the new slug was used previously, delete it from the list.
                                    if ( in_array( $articleData['post_name'], $old_slugs ) ) {
                                        delete_post_meta( $post_to_update_id, '_wp_old_slug', $articleData['post_name'] );
                                    }
                                }

                                if ( ! $this->options['is_update_excerpt']){
                                    $articleData['post_excerpt'] = $post_to_update->post_excerpt;
                                    $logger and call_user_func($logger, sprintf(__('Preserve excerpt of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_menu_order']){
                                    $articleData['menu_order'] = $post_to_update->menu_order;
                                    $logger and call_user_func($logger, sprintf(__('Preserve menu order of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_parent']){
                                    $articleData['post_parent'] = $post_to_update->post_parent;
                                    $logger and call_user_func($logger, sprintf(__('Preserve post parent of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_post_type']){
                                    $articleData['post_type'] = $post_to_update->post_type;
                                    $logger and call_user_func($logger, sprintf(__('Preserve post type of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_comment_status']){
                                    $articleData['comment_status'] = $post_to_update->comment_status;
                                    $logger and call_user_func($logger, sprintf(__('Preserve comment status of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_ping_status']){
                                    $articleData['ping_status'] = $post_to_update->ping_status;
                                    $logger and call_user_func($logger, sprintf(__('Preserve ping status of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! $this->options['is_update_author']){
                                    $articleData['post_author'] = $post_to_update->post_author;
                                    $logger and call_user_func($logger, sprintf(__('Preserve post author of already existing article for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                }
                                if ( ! wp_all_import_is_update_cf('_wp_page_template', $this->options) ){
                                    $articleData['page_template'] = get_post_meta($post_to_update_id, '_wp_page_template', true);
                                }
                                break;
                        }
					} else {
						// When "Update all data" is chosen, and the import doesn't contain username or email address data for User & WooCommerce Customer imports
                        switch ($this->options['custom_type']){
                            case 'import_users':
                                if ( empty($articleData['user_login']) ) {
									$articleData['user_login'] = $post_to_update->user_login;
									$logger and call_user_func($logger, sprintf(__('No username provided for user ID `%s`, preserve existing username for user.', 'wp_all_import_plugin'), $articleData['ID']));
								} 
                                if ( empty($articleData['user_email']) ) {
									$articleData['user_email'] = $post_to_update->user_email;
									$logger and call_user_func($logger, sprintf(__('No email provided for user ID `%s`, preserve existing email for user.', 'wp_all_import_plugin'), $articleData['ID']));
								}
								break;
							case 'shop_customer':
								if ( empty($articleData['user_login']) ) {
									$articleData['user_login'] = $post_to_update->user_login;
									$logger and call_user_func($logger, sprintf(__('No username provided for customer ID `%s`, preserve existing username for customer.', 'wp_all_import_plugin'), $articleData['ID']));
								} 
								if ( empty($articleData['user_email']) ) {
									$articleData['user_email'] = $post_to_update->user_email;
									$logger and call_user_func($logger, sprintf(__('No email provided for customer ID `%s`, preserve existing email for customer.', 'wp_all_import_plugin'), $articleData['ID']));
								}
                                break;
                            default:
                                break;
						}
						
					}

                    $is_images_to_delete = apply_filters('pmxi_delete_images', true, $articleData, $current_xml_node);
                    if ( $is_images_to_delete ) {
                        switch ($this->options['custom_type']) {
							case 'import_users':
							case 'shop_customer':
							case 'reviews':
							case 'comments':
                                break;
                            case 'taxonomies':

                                // handle obsolete attachments (i.e. delete or keep) according to import settings
                                if ($this->options['update_all_data'] == 'yes' or ($this->options['update_all_data'] == 'no' and $this->options['is_update_images'] and $this->options['update_images_logic'] == "full_update")) {
                                    $logger and call_user_func($logger, sprintf(__('Deleting images for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                    $term_thumbnail_id = get_term_meta($articleData['ID'], 'thumbnail_id', TRUE);
                                    if (!empty($term_thumbnail_id)) {
                                        delete_term_meta($articleData['ID'], 'thumbnail_id');
                                        $remove_images = ($this->options['download_images'] == 'gallery' or $this->options['do_not_remove_images']) ? FALSE : TRUE;
                                        if ($remove_images){
                                            wp_delete_attachment($term_thumbnail_id, true);
                                        }
                                    }
                                }

                                break;
                            default:
                                if ($this->options['update_all_data'] == 'yes' or ($this->options['update_all_data'] == 'no' and $this->options['is_update_attachments'])) {
                                    $logger and call_user_func($logger, sprintf(__('Deleting attachments for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                    wp_delete_attachments($articleData['ID'], ! $this->options['is_search_existing_attach'], 'files');
                                }
                                // handle obsolete attachments (i.e. delete or keep) according to import settings
                                if ($this->options['update_all_data'] == 'yes' or ($this->options['update_all_data'] == 'no' and $this->options['is_update_images'] and $this->options['update_images_logic'] == "full_update")) {
                                    $logger and call_user_func($logger, sprintf(__('Deleting images for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                    if (!empty($images_bundle)) {
                                        foreach ($images_bundle as $slug => $bundle_data) {
                                            $option_slug = ($slug == 'pmxi_gallery_image') ? '' : $slug;
                                            if (count($images_bundle) > 1 && $slug == 'pmxi_gallery_image') {
                                                continue;
                                            }
                                            $do_not_remove_images = ($this->options[$option_slug . 'download_images'] == 'gallery' or $this->options[$option_slug . 'do_not_remove_images']) ? FALSE : TRUE;
                                            $missing_images = wp_delete_attachments($articleData['ID'], $do_not_remove_images, 'images');
                                        }
                                    }
                                }
                                break;
                        }
                    }
				}
				elseif ( ! $postRecord->isEmpty() ){
					
					// existing post not found though it's track was found... clear the leftover, plugin will continue to treat record as new
					$postRecord->clear();
					
				}				

				$logger and call_user_func($logger, sprintf(__('Applying filter `pmxi_article_data` for `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
				$articleData = apply_filters('pmxi_article_data', $articleData, $this, $post_to_update, $current_xml_node);
				
				// no new records are created. it will only update posts it finds matching duplicates for
				if (  ! $this->options['create_new_records'] and empty($articleData['ID']) ){ 
					
					if ( ! $postRecord->isEmpty() ) $postRecord->set(array('iteration' => $this->iteration))->update();

					$logger and call_user_func($logger, __('<b>SKIPPED</b>: The option \'Create new posts from records newly present in your file\' is disabled in your import settings.', 'wp_all_import_plugin'));
					$logger and !$is_cron and PMXI_Plugin::$session->warnings++;								
					$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
					$skipped++;		
					$logger and !$is_cron and PMXI_Plugin::$session->save_data();	
					do_action('wp_all_import_post_skipped', 0, $this->id, $current_xml_node);
					continue;
				}
				
				// cloak urls with `WP Wizard Cloak` if corresponding option is set
				if ( ! empty($this->options['is_cloak']) and class_exists('PMLC_Plugin')) {
					if (preg_match_all('%<a\s[^>]*href=(?(?=")"([^"]*)"|(?(?=\')\'([^\']*)\'|([^\s>]*)))%is', $articleData['post_content'], $matches, PREG_PATTERN_ORDER)) {
						$hrefs = array_unique(array_merge(array_filter($matches[1]), array_filter($matches[2]), array_filter($matches[3])));
						foreach ($hrefs as $url) {
							if (preg_match('%^\w+://%i', $url)) { // mask only links having protocol
								// try to find matching cloaked link among already registered ones
								$list = new PMLC_Link_List(); $linkTable = $list->getTable();
								$rule = new PMLC_Rule_Record(); $ruleTable = $rule->getTable();
								$dest = new PMLC_Destination_Record(); $destTable = $dest->getTable();
								$list->join($ruleTable, "$ruleTable.link_id = $linkTable.id")
									->join($destTable, "$destTable.rule_id = $ruleTable.id")
									->setColumns("$linkTable.*")
									->getBy(array(
										"$linkTable.destination_type =" => 'ONE_SET',
										"$linkTable.is_trashed =" => 0,
										"$linkTable.preset =" => '',
										"$linkTable.expire_on =" => '0000-00-00',
										"$ruleTable.type =" => 'ONE_SET',
										"$destTable.weight =" => 100,
										"$destTable.url LIKE" => $url,
									), NULL, 1, 1)->convertRecords();
								if ($list->count()) { // matching link found
									$link = $list[0];
								} else { // register new cloaked link
									global $wpdb;
									$slug = max(
										intval($wpdb->get_var("SELECT MAX(CONVERT(name, SIGNED)) FROM $linkTable")),
										intval($wpdb->get_var("SELECT MAX(CONVERT(slug, SIGNED)) FROM $linkTable")),
										0
									);
									$i = 0; do {
										is_int(++$slug) and $slug > 0 or $slug = 1;
										$is_slug_found = ! intval($wpdb->get_var("SELECT COUNT(*) FROM $linkTable WHERE name = '$slug' OR slug = '$slug'"));
									} while( ! $is_slug_found and $i++ < 100000);
									if ($is_slug_found) {
										$link = new PMLC_Link_Record(array(
											'name' => strval($slug),
											'slug' => strval($slug),
											'header_tracking_code' => '',
											'footer_tracking_code' => '',
											'redirect_type' => '301',
											'destination_type' => 'ONE_SET',
											'preset' => '',
											'forward_url_params' => 1,
											'no_global_tracking_code' => 0,
											'expire_on' => '0000-00-00',
											'created_on' => date('Y-m-d H:i:s'),
											'is_trashed' => 0,
										));
										$link->insert();
										$rule = new PMLC_Rule_Record(array(
											'link_id' => $link->id,
											'type' => 'ONE_SET',
											'rule' => '',
										));
										$rule->insert();
										$dest = new PMLC_Destination_Record(array(
											'rule_id' => $rule->id,
											'url' => $url,
											'weight' => 100,
										));
										$dest->insert();
									} else {
										$logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: Unable to create cloaked link for %s', 'wp_all_import_plugin'), $url));
										$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
										$link = NULL;
									}
								}
								if ($link) { // cloaked link is found or created for url
									$articleData['post_content'] = preg_replace('%' . preg_quote($url, '%') . '(?=([\s\'"]|$))%i', $link->getUrl(), $articleData['post_content']);
								}
							}
						}
					}
				}		

				// insert article being imported						
				if ($this->options['is_fast_mode']){
					foreach (array('transition_post_status', 'save_post', 'pre_post_update', 'add_attachment', 'edit_attachment', 'edit_post', 'post_updated', 'wp_insert_post', 'save_post_' . $post_type[$i]) as $act) {
						remove_all_actions($act);
					}
				}

				if ( empty($articleData['ID']) )
				{
					$continue_import = true;
					$continue_import = apply_filters('wp_all_import_is_post_to_create', $continue_import, $current_xml_node, $this->id);

					if ( ! $continue_import ){						
						$skipped++;
						$logger and call_user_func($logger, sprintf(__('<b>SKIPPED</b>: By filter wp_all_import_is_post_to_create `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
						$logger and !$is_cron and PMXI_Plugin::$session->warnings++;							
						$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;	
						$logger and !$is_cron and PMXI_Plugin::$session->save_data();	
						do_action('wp_all_import_post_skipped', 0, $this->id, $current_xml_node);
						continue;
					}
				}

                switch ($this->options['custom_type']){
                    case 'import_users':
                        if (empty($articleData['ID']) && email_exists( $articleData['user_email'] )){
                            $logger and call_user_func($logger, sprintf(__('<b>WARNING</b> Sorry, that email address `%s` is already used!', 'wp_all_import_plugin'), $articleData['user_email']));
                            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                            $logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
                            $logger and !$is_cron and PMXI_Plugin::$session->save_data();
                            $skipped++;
                            continue 2;
                        }
                        $pid = (empty($articleData['ID'])) ? wp_insert_user( $articleData ) : wp_update_user( $articleData );
                        // update user login using direct sql query
                        if (!empty($articleData['ID'])){
                            $this->wpdb->update($this->wpdb->users, array('user_login' => $articleData['user_login']), array('ID' => $articleData['ID']));
                        }
                        $articleData['post_title'] = $articleData['user_login'];

						break;

					case 'shop_customer':
                        if (empty($articleData['ID']) && email_exists( $articleData['user_email'] )){
                            $logger and call_user_func($logger, sprintf(__('<b>WARNING</b> Sorry, that email address `%s` is already used!', 'wp_all_import_plugin'), $articleData['user_email']));
                            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                            $logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
                            $logger and !$is_cron and PMXI_Plugin::$session->save_data();
                            $skipped++;
                            continue 2;
                        }
                        $pid = (empty($articleData['ID'])) ? wp_insert_user( $articleData ) : wp_update_user( $articleData );
                        // update user login using direct sql query
                        if (!empty($articleData['ID'])){
                            $this->wpdb->update($this->wpdb->users, array('user_login' => $articleData['user_login']), array('ID' => $articleData['ID']));
						}
						
						// Update billing details for customer
						if ( empty($articleData['ID']) or $this->options['update_all_data'] == 'yes' or $this->options['pmsci_is_update_billing_fields'] ) {
							$logger and call_user_func($logger, sprintf(__('- Importing billing data...', 'wp_all_import_plugin')));
							if (!empty($billing_data)) {
								foreach($billing_data as $key => $value) {
									if (
										// Update all Billing Fields
										( $this->options['pmsci_update_billing_fields_logic'] == 'full_update' )
										or
										// Update only these Billing Fields, leave the rest alone
										( $this->options['pmsci_update_billing_fields_logic'] == 'only' and in_array( $key, $this->options['pmsci_billing_fields_list'] ) )
										or
										// Leave these fields alone, update all other Billing Fields
										( $this->options['pmsci_update_billing_fields_logic'] == 'all_except' and !in_array( $key, $this->options['pmsci_billing_fields_list'] ) )
									){
										update_user_meta($pid, $key, $value);
										$logger and call_user_func($logger, sprintf(__('- Billing field `%s` has been updated with value `%s` for customer `%s` ...', 'wp_all_import_plugin'), $key, $value, $articleData['user_login']));
									}
								}
							}
						}
						
						// Update shipping details for customer.
						if ( empty($articleData['ID']) or $this->options['update_all_data'] == 'yes' or $this->options['pmsci_is_update_shipping_fields'] ) {
							switch ($this->options['pmsci_customer']['shipping_source']) {
								// Copy from billing.
								case 'copy':
									$logger and call_user_func($logger, sprintf(__('- Copying billing information to shipping fields...', 'wp_all_import_plugin')));
									if ( ! empty( $billing_data )) {
										foreach ($billing_data as $key => $value) {
											$shipping_field = str_replace('billing', 'shipping', $key);
											if ( in_array($shipping_field, array('shipping_phone','shipping_email') ) ) {
                                                continue;
                                            }
											if ( 
												// Update all Shipping Fields
												( $this->options['pmsci_update_shipping_fields_logic'] == 'full_update' )
												or
												// Update only these Shipping Fields, leave the rest alone
												( $this->options['pmsci_update_shipping_fields_logic'] == 'only' and in_array( $shipping_field, $this->options['pmsci_shipping_fields_list'] ) )
												or
												// Leave these fields alone, update all other Shipping Fields

												( $this->options['pmsci_update_shipping_fields_logic'] == 'all_except' and !in_array( $shipping_field, $this->options['pmsci_shipping_fields_list'] ) )
											){
												update_user_meta( $pid, $shipping_field, $value );
												$logger and call_user_func($logger, sprintf(__('- Shipping field `%s` has been updated with value `%s` for customer `%s` ...', 'wp_all_import_plugin'), $shipping_field, $value, $articleData['user_login']));
											}
										}
									}
									break;
								// Import shipping address.
								default:
									$logger and call_user_func($logger, sprintf(__('- Importing shipping data separately...', 'wp_all_import_plugin')));
									foreach ($shipping_data as $key => $value) {
										$shipping_field = $key;
										if ( 
											// Update all Shipping Fields
											( $this->options['pmsci_update_shipping_fields_logic'] == 'full_update' )
											or
											// Update only these Shipping Fields, leave the rest alone
											( $this->options['pmsci_update_shipping_fields_logic'] == 'only' and in_array( $shipping_field, $this->options['pmsci_shipping_fields_list'] ) )
											or
											// Leave these fields alone, update all other Shipping Fields
											( $this->options['pmsci_update_shipping_fields_logic'] == 'all_except' and !in_array( $shipping_field, $this->options['pmsci_shipping_fields_list'] ) )
										){
											update_user_meta( $pid, $key, $value);
											$logger and call_user_func($logger, sprintf(__('- Shipping field `%s` has been updated with value `%s` for customer `%s` ...', 'wp_all_import_plugin'), $key, $value, $articleData['user_login']));
										}
									}
									break;
							}
						}
						$articleData['post_title'] = $articleData['user_login'];
                        break;
                    case 'taxonomies':
                        if (empty($articleData['ID'])){
                            $logger and call_user_func($logger, sprintf(__('<b>CREATING</b> `%s` `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $custom_type_details->labels->singular_name));
                        }
                        else{
                            $logger and call_user_func($logger, sprintf(__('<b>UPDATING</b> `%s` `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $custom_type_details->labels->singular_name));
                        }
                        $term = (empty($articleData['ID'])) ? wp_insert_term($articleData['post_title'], $this->options['taxonomy_type'], array(
                            'parent'      => empty($articleData['post_parent']) ? 0 : $articleData['post_parent'],
                            'slug'        => $articleData['slug'],
                            'description' => $articleData['post_content']
                        )) : wp_update_term($articleData['ID'], $this->options['taxonomy_type'], array(
                            'name'        => $articleData['post_title'],
                            'parent'      => empty($articleData['post_parent']) ? 0 : $articleData['post_parent'],
                            'slug'        => $articleData['slug'],
                            'description' => $articleData['post_content']
                        ));
                        if (is_wp_error($term)){
                            $pid = $term;
                        }
                        else{
                            $pid = $term['term_id'];
                            if (empty($articleData['post_parent']) && !empty($taxonomy_parent[$i])){
                                $parent_terms = get_option('wp_all_import_taxonomies_hierarchy_' . $this->id);
                                if (empty($parent_terms)) $parent_terms = array();
                                $parent_terms[$pid] = $taxonomy_parent[$i];
                                update_option('wp_all_import_taxonomies_hierarchy_' . $this->id, $parent_terms);
                            }
                        }
                        break;
                    case 'reviews':
                    case 'comments':
                        if (empty($articleData['ID'])){
                            $logger and call_user_func($logger, sprintf(__('<b>CREATING</b> comment `%s` for post `%s`', 'wp_all_import_plugin'), $articleData['comment_content'], $comment_post[$i]));
                        } else {
                            $logger and call_user_func($logger, sprintf(__('<b>UPDATING</b> comment `%s` for post `%s`', 'wp_all_import_plugin'), $articleData['comment_content'], $comment_post[$i]));
                            $articleData['comment_ID'] = $articleData['ID'];
                        }
                        if (empty($articleData['ID'])) {
                            $pid = wp_insert_comment($articleData);
                        } else {
                            wp_update_comment($articleData);
                            $pid = $articleData['ID'];
                        }
                        break;
                    default:
                        if (empty($articleData['ID'])){
                            $logger and call_user_func($logger, sprintf(__('<b>CREATING</b> `%s` `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $custom_type_details->labels->singular_name));
                        }
                        else{
                            $logger and call_user_func($logger, sprintf(__('<b>UPDATING</b> `%s` `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $custom_type_details->labels->singular_name));
                        }
                        $pid = (empty($articleData['ID'])) ? wp_insert_post($articleData, true) : wp_update_post($articleData, true);
                        break;
                }
				
				if (empty($pid)) {
					$logger and call_user_func($logger, __('<b>ERROR</b>', 'wp_all_import_plugin') . ': something wrong, ID = 0 was generated.');
					$logger and !$is_cron and PMXI_Plugin::$session->errors++;
					$skipped++;
				}
				elseif (is_wp_error($pid)) {
					$logger and call_user_func($logger, __('<b>ERROR</b>', 'wp_all_import_plugin') . ': ' . $pid->get_error_message());
					$logger and !$is_cron and PMXI_Plugin::$session->errors++;
					$skipped++;
				} else {

                    if (empty($articleData['post_parent']) && !empty($page_parent[$i])){
                        $parent_posts = get_option('wp_all_import_posts_hierarchy_' . $this->id);
                        if (empty($parent_posts)) $parent_posts = array();
                        $parent_posts[$pid] = $page_parent[$i];
                        update_option('wp_all_import_posts_hierarchy_' . $this->id, $parent_posts);
                    }

                    if (!empty($articleData['comment_post_ID'])) {
                        $comment_posts = get_option('wp_all_import_comment_posts_' . $this->id);
                        if (empty($comment_posts)) $comment_posts = array();
                        $comment_posts[] = $articleData['comment_post_ID'];
                        update_option('wp_all_import_comment_posts_' . $this->id, array_unique($comment_posts));
                    }

                    $is_images_to_update = apply_filters('pmxi_is_images_to_update', true, $articleData, $current_xml_node, $pid);

					if ("manual" != $this->options['duplicate_matching'] or empty($articleData['ID'])){
						// associate post with import												
						$product_key = (($post_type[$i] == "product" and PMXI_Admin_Addons::get_addon('PMWI_Plugin')) ? $addons_data['PMWI_Plugin']['single_product_ID'][$i] : '');
                        if ($post_type[$i] == "taxonomies"){
                            $product_key = 'taxonomy_term';
                        }
                        $postRecord->isEmpty() and $postRecord->set(array(
							'post_id' => $pid,
							'import_id' => $this->id,
							'unique_key' => $unique_keys[$i],
							'product_key' => $product_key
						))->insert();

                        $postRecordData = array(
                            'iteration' => $this->iteration,
                            'specified' => empty($specified_records) ? 0 : 1
                        );

                        if ( ! empty($product_key) ){
                            $postRecordData['product_key'] = $product_key;
                        }

						$postRecord->set($postRecordData)->update();

						$logger and call_user_func($logger, sprintf(__('Associate post `%s` with current import ...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
					}

					// [post format]
					if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post_type[$i], 'post-formats' ) ){						
						set_post_format($pid, ("xpath" == $this->options['post_format']) ? $post_format[$i] : $this->options['post_format'] ); 						
						$logger and call_user_func($logger, sprintf(__('Associate post `%s` with post format %s ...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), ("xpath" == $this->options['post_format']) ? $post_format[$i] : $this->options['post_format']));
					}
					// [/post format]
					
					// [custom fields]					

					$existing_meta_keys = array();
					$existing_meta = array();

					if (empty($articleData['ID']) or $this->options['update_all_data'] == 'yes' or ($this->options['update_all_data'] == 'no' and $this->options['is_update_custom_fields']) or ($this->options['update_all_data'] == 'no' and !empty($this->options['is_update_attributes']) and $post_type[$i] == "product" and class_exists('PMWI_Plugin'))) {

						$show_log = ( ! empty($serialized_meta) );

						$show_log and $logger and call_user_func($logger, __('<b>CUSTOM FIELDS:</b>', 'wp_all_import_plugin'));

						// Delete all meta keys 
						if ( ! empty($articleData['ID']) ) {

                            switch ($this->options['custom_type']){
								case 'import_users':
								case 'shop_customer':
	                                $existing_meta_keys = get_user_meta($pid, '');
                                break;
                                case 'taxonomies':
	                                $existing_meta_keys = get_term_meta($pid, '');
                                break;
                                case 'reviews':
                                case 'comments':
                                    $existing_meta_keys = get_comment_meta($pid, '');
                                    break;
                                default:
	                                $existing_meta_keys = get_post_meta($pid, '');
                                break;
                            }

                            $existing_meta = $existing_meta_keys;

                            $exclude_fields = ['_wp_old_slug'];
                            // Do not delete post meta for features image.
                            if (!$is_images_to_update || $this->options['is_keep_former_posts'] == 'yes' || $this->options['update_all_data'] == 'no' && (empty($this->options['is_update_images']) || $this->options['update_images_logic'] != 'full_update')) {
                                $exclude_fields[] = '_thumbnail_id';
                                $exclude_fields[] = '_product_image_gallery';
                            }

							// delete keys which are no longer correspond to import settings																														
							foreach ($existing_meta_keys as $cur_meta_key => $cur_meta_val) {

								if ( in_array($cur_meta_key, $exclude_fields) ) continue;
								
								$user_fields = array(
									'first_name',
									PMXI_Plugin::getInstance()->getWPPrefix() . 'capabilities',
									'nickname',
									'last_name',
									'description',
									'billing_first_name',
									'billing_last_name',
									'billing_company',
									'billing_address_1',
									'billing_address_2',
									'billing_city',
									'billing_postcode',
									'billing_country',
									'billing_state',
									'billing_phone',
									'billing_email',
									'shipping_first_name',
									'shipping_last_name',
									'shipping_company',
									'shipping_address_1',
									'shipping_address_2',
									'shipping_city',
									'shipping_postcode',
									'shipping_country',
									'shipping_state',
									);
								
								if ( in_array($cur_meta_key, $user_fields) and in_array($this->options['custom_type'], array('import_users', 'shop_customer')) ) continue;

								$field_to_delete = true;								

								// apply addons filters
								if ( ! apply_filters('pmxi_custom_field_to_delete', $field_to_delete, $pid, $post_type[$i], $this->options, $cur_meta_key) ) continue;

								// Update all Custom Fields is defined
								if ($this->options['update_all_data'] == 'yes' or ($this->options['update_all_data'] == 'no' and $this->options['is_update_custom_fields'] and $this->options['update_custom_fields_logic'] == "full_update")) {

                                    switch ($this->options['custom_type']){
										case 'import_users':
										case 'shop_customer':
                                            delete_user_meta($pid, $cur_meta_key);
                                            break;
                                        case 'taxonomies':
                                            delete_term_meta($pid, $cur_meta_key);
                                            break;
                                        case 'reviews':
                                        case 'comments':
                                            delete_comment_meta($pid, $cur_meta_key);
                                            break;
                                        default:
                                            delete_post_meta($pid, $cur_meta_key);
                                            break;
                                    }
									$show_log and $logger and call_user_func($logger, sprintf(__('- Custom field %s has been deleted for `%s` attempted to `update all custom fields` setting ...', 'wp_all_import_plugin'), $cur_meta_key, $this->getRecordTitle($articleData)));
								}
                                // Leave these fields alone, update all other Custom Fields
                                elseif ($this->options['update_all_data'] == 'no' and $this->options['is_update_custom_fields'] and $this->options['update_custom_fields_logic'] == "all_except"){
                                    if ( empty($this->options['custom_fields_list']) or ! in_array($cur_meta_key, $this->options['custom_fields_list'])){
                                        switch ($this->options['custom_type']){
											case 'import_users':
											case 'shop_customer':
                                                delete_user_meta($pid, $cur_meta_key);
                                                break;
                                            case 'taxonomies':
                                                delete_term_meta($pid, $cur_meta_key);
                                                break;
                                            case 'reviews':
                                            case 'comments':
                                                delete_comment_meta($pid, $cur_meta_key);
                                                break;
                                            default:
                                                delete_post_meta($pid, $cur_meta_key);
                                                break;
                                        }
										$show_log and $logger and call_user_func($logger, sprintf(__('- Custom field %s has been deleted for `%s` attempted to `leave these fields alone: %s, update all other Custom Fields` setting ...', 'wp_all_import_plugin'), $cur_meta_key, $this->getRecordTitle($articleData), implode(',', $this->options['custom_fields_list'])));
									}									
								}
							}
						}						
					}

					if ($this->options['custom_type'] == 'reviews') {
					    if (is_numeric($comment_rating[$i])) {
                            update_comment_meta($pid, 'rating', $comment_rating[$i]);
                        }
                        if (is_numeric($comment_verified[$i])) {
                            update_comment_meta($pid, 'verified', $comment_verified[$i]);
                        }
                    }

					// [addons import]

					// prepare data for import
					$importData = array(
						'pid' => $pid,
						'i' => $i,
						'import' => $this,
						'articleData' => $articleData,
						'xml' => $xml,
						'is_cron' => $is_cron,
						'logger' => $logger,
						'xpath_prefix' => $xpath_prefix,
						'post_type' => $post_type[$i],
                        'current_xml_node' => $current_xml_node
					);

					$import_functions = apply_filters('wp_all_import_addon_import', array());

					// Deligate import operation to addons.
					foreach (PMXI_Admin_Addons::get_active_addons() as $class) {
						if (class_exists($class)) {
							if ( method_exists($addons[$class], 'import') ) $addons[$class]->import($importData);	
						}
						else {
							if (!empty($import_functions[$class])) {
								if (is_array($import_functions[$class]) and is_callable($import_functions[$class]) or ! is_array($import_functions[$class]) and function_exists($import_functions[$class]) ) {
									call_user_func($import_functions[$class], $importData, $addons_data[$class]);			
								}							
							}
						}
					}

					// [/addons import]

					if (empty($articleData['ID']) or $this->options['update_all_data'] == 'yes' or ($this->options['update_all_data'] == 'no' and $this->options['is_update_custom_fields']) or ($this->options['update_all_data'] == 'no' and !empty($this->options['is_update_attributes']) and $post_type[$i] == "product" and class_exists('PMWI_Plugin'))) {

						$encoded_meta = array();						
						
						if ( ! empty($serialized_meta)){

							$meta_data = array(
								'add'    => array(
									'user' => array(),
									'term' => array(),
									'post' => array(),
									'comment' => array()
								),
								'update' => array(
									'user' => array(),
									'term' => array(),
									'post' => array(),
                                    'comment' => array()
								)
							);

							$meta_fields = array();
                            // get existing keys after add-ons import completed
                            switch ($this->options['custom_type']){
								case 'import_users':
								case 'shop_customer':
                                    $meta_type = 'user';
                                    $existing_meta_keys = get_user_meta($pid, '');
                                    break;
                                case 'taxonomies':
                                    $meta_type = 'term';
                                    $existing_meta_keys = get_term_meta($pid, '');
                                    break;
                                case 'reviews':
                                case 'comments':
                                    $meta_type = 'comment';
                                    $existing_meta_keys = get_comment_meta($pid, '');
                                    break;
                                default:
                                    $meta_type = 'post';
                                    $existing_meta_keys = get_post_meta($pid, '');
                                    break;
                            }

							foreach ($serialized_meta as $m_keys) {

                                $m_key = $m_keys['keys'][$i];

                                $values = $m_keys['values'];

                                if (!empty($articleData['ID'])) {

                                    if ($this->options['update_all_data'] != 'yes') {

                                        $field_to_update = false;

                                        if ($this->options['is_update_custom_fields'] and $this->options['update_custom_fields_logic'] == "only" and ! empty($this->options['custom_fields_list']) and is_array($this->options['custom_fields_list']) and in_array($m_key, $this->options['custom_fields_list']) ) $field_to_update = true;
                                        if ($this->options['is_update_custom_fields'] and $this->options['update_custom_fields_logic'] == "all_except" and ( empty($this->options['custom_fields_list']) or ! in_array($m_key, $this->options['custom_fields_list']) )) $field_to_update = true;
                                        if ( $this->options['update_custom_fields_logic'] == "full_update" ) $field_to_update = true;

                                        // apply addons filters
                                        $field_to_update = apply_filters('pmxi_custom_field_to_update', $field_to_update, $post_type[$i], $this->options, $m_key);

                                        if ( ! $field_to_update ) {
                                            $logger and call_user_func($logger, sprintf(__('- Custom field `%s` is not set to be updated in import settings, skipping ...', 'wp_all_import_plugin'), $m_key));
                                            continue;
                                        }
                                    }
                                }

                                $logger and call_user_func($logger, __('- <b>ACTION</b>: pmxi_custom_field', 'wp_all_import_plugin'));
                                $cf_original_value = isset($existing_meta[$m_key][0]) ? $existing_meta[$m_key][0] : '';
                                $cf_value = apply_filters('pmxi_custom_field', (is_serialized($values[$i])) ? unserialize($values[$i]) : $values[$i], $pid, $m_key, $cf_original_value, $existing_meta_keys, $this->id);

                                $m_key = wp_unslash( $m_key );
                                $cf_value = wp_unslash( $cf_value );

                                if ( isset( $existing_meta_keys[ $m_key ] ) && ! in_array('total_sales', array($m_key))) {
                                    if ( isset( $existing_meta_keys[ $m_key ][0] ) && ( $existing_meta_keys[ $m_key ][0] === maybe_serialize( $cf_value ) ) ) {
                                        $logger and call_user_func($logger, sprintf(__('- Custom field `%s` has been skipped because of duplicate value `%s` for post `%s` ...', 'wp_all_import_plugin'), $m_key, esc_attr(maybe_serialize($cf_value)), $this->getRecordTitle($articleData)));
                                        continue;
                                    }
                                    $meta_data['update'][ $meta_type ][ $m_key ] = maybe_serialize( $cf_value );
                                } else {
                                    $meta_data['add'][ $meta_type ][] = $this->wpdb->prepare( "(%d, %s, %s)", $pid, $m_key, maybe_serialize( $cf_value ) );
                                }

                                $meta_fields[ $m_key ] = maybe_serialize( $cf_value );

                                $logger and call_user_func($logger, sprintf(__('- Custom field `%s` will be updated with value `%s` for post `%s` ...', 'wp_all_import_plugin'), $m_key, esc_attr(maybe_serialize($cf_value)), $this->getRecordTitle($articleData)));
                                $logger and call_user_func($logger, __('- <b>ACTION</b>: pmxi_update_post_meta', 'wp_all_import_plugin'));
							}

							// Skip post if all custom files are unchanged and there is no other data to be updated.
							if ( "no" == $this->options['is_keep_former_posts'] ) {
                                $is_update_attributes = empty($this->options['is_update_attributes']) ? false : true;
 								$data_to_update = array(
									intval( $this->options['is_update_status'] ),
									intval( $this->options['is_update_title'] ),
									intval( $this->options['is_update_author'] ),
									intval( $this->options['is_update_slug'] ),
									intval( $this->options['is_update_content'] ),
									intval( $this->options['is_update_excerpt'] ),
									intval( $this->options['is_update_dates'] ),
									intval( $this->options['is_update_menu_order'] ),
									intval( $this->options['is_update_parent'] ),
									intval( $this->options['is_update_post_type'] ),
									intval( $this->options['is_update_comment_status'] ),
									intval( $this->options['is_update_ping_status'] ),
									intval( $this->options['is_update_attachments'] ),
									intval( $this->options['is_update_images'] ),
									intval( $this->options['is_update_categories'] ),
                                    intval( $is_update_attributes )
								);
								$data_to_update = array_filter( $data_to_update );

								if (
									empty( $data_to_update ) and
									$this->options['is_update_custom_fields'] and
									"only" === $this->options['update_custom_fields_logic'] and
									! empty( $this->options['custom_fields_list'] ) and
									empty( $meta_data['add'][ $meta_type ] ) and
									empty( $meta_data['update'][ $meta_type ] )
								) {
                                    // Skip record only when all fields from 'Update only these ...' list defined in 'Custom Fields' section in import template.
                                    $skipRecord = true;
                                    foreach ($this->options['custom_fields_list'] as $fieldToUpdate) {
                                        if (!in_array($fieldToUpdate, $this->options['custom_name'])){
                                            $skipRecord = false;
                                            break;
                                        }
                                    }
                                    if ($skipRecord){
                                        $skipped++;
                                        $logger and call_user_func( $logger, sprintf( __( '<b>SKIPPED</b>: Custom field data is unchanged, nothing to update for post `%s` ...', 'wp_all_import_plugin' ), $this->getRecordTitle($articleData) ) );
                                        $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                        $logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;
                                        $logger and !$is_cron and PMXI_Plugin::$session->save_data();
                                        continue;
                                    }
                                }
							}

							$add_meta_data    = array_chunk( $meta_data['add'][ $meta_type ], 20 );
							$update_meta_data = $meta_data['update'][ $meta_type ];
							$table            = _get_meta_table( $meta_type );
							$meta_id          = $meta_type . '_id';

                            // Add meta data.
							foreach ( $add_meta_data as $meta ) {
								$this->wpdb->query( "INSERT INTO {$table} ({$meta_id}, meta_key, meta_value) VALUES " . join( ',', $meta ) );
							}

							// Update meta data.
							foreach ( $update_meta_data as $meta_key => $meta_value ) {
								$this->wpdb->query( $this->wpdb->prepare("UPDATE {$table} SET meta_value = %s WHERE meta_key = '{$meta_key}' and {$meta_id} = {$pid}", $meta_value) );
							}

							// Trigger actions for updated meta fields.
							foreach ($meta_fields as $meta_key => $meta_value) {
                                do_action( 'pmxi_update_post_meta', $pid, $meta_key, maybe_unserialize($meta_value)); // hook that was triggered after post meta data updated
                            }

                            wp_cache_delete($pid, $meta_type . '_meta');
							//$this->executeSQL();
						}							
					}
					// [/custom fields]					

					// Page Template
                    global $wp_version;
					if ( ! empty($articleData['post_type']) && !in_array($articleData['post_type'], array('taxonomies', 'comments', 'reviews')) && ('page' == $articleData['post_type'] || version_compare($wp_version, '4.7.0', '>=')) && wp_all_import_is_update_cf('_wp_page_template', $this->options) && ( !empty($this->options['page_template']) || "no" == $this->options['is_multiple_page_template']) ){
						update_post_meta($pid, '_wp_page_template', ("no" == $this->options['is_multiple_page_template']) ? $page_template[$i] : $this->options['page_template']);
					}
					
					// [featured image]

                    $featuredImage = false;

                    $images_uploads = apply_filters('wp_all_import_images_uploads_dir', $uploads, $articleData, $current_xml_node, $this->id, $pid);

                    if (!empty($articleData['post_content']) && (empty($articleData['ID']) || $this->options['is_keep_former_posts'] == "no" && ($this->options['update_all_data'] == "yes" || $this->options['is_update_content'])) && $this->options['import_img_tags'] ){

                        require_once(ABSPATH . 'wp-admin/includes/image.php');

					    $logger and call_user_func($logger, __('<b>CONTENT IMAGES:</b>', 'wp_all_import_plugin'));

					    // search for images in galleries
                        $galleries = array();
                        if (preg_match_all('%\[gallery[^\]]*ids="([^\]^"]*)"[^\]]*\]%is', $articleData['post_content'], $matches, PREG_PATTERN_ORDER)) {
                            $galleries = array_unique(array_filter($matches[1]));
                        }
                        $gallery_images = array();
                        if ( ! empty($galleries) ){
                            foreach ($galleries as $key => $gallery) {
                                $imgs = array_unique(array_filter(explode(",", $gallery)));
                                if (!empty($imgs)){
                                    foreach ($imgs as $img) {
                                        if ( ! is_numeric($img) ){
                                            $gallery_images[] = json_decode(base64_decode($img), true);
                                        }
                                    }
                                }
                            }
                        }
                        // search for images in <img> tags
                        $tag_images = array();
                        if (preg_match_all('%<img\s[^>]*src=(?(?=")"([^"]*)"|(?(?=\')\'([^\']*)\'|([^\s>]*)))%is', $articleData['post_content'], $matches, PREG_PATTERN_ORDER)) {
                            $tag_images = array_unique(array_merge(array_filter($matches[1]), array_filter($matches[2]), array_filter($matches[3])));
                        }

                        if (preg_match_all('%<img\s[^>]*srcset=(?(?=")"([^"]*)"|(?(?=\')\'([^\']*)\'|([^\s>]*)))%is', $articleData['post_content'], $matches, PREG_PATTERN_ORDER)) {
                            $srcset_images = array_unique(array_merge(array_filter($matches[1]), array_filter($matches[2]), array_filter($matches[3])));
                            if (!empty($srcset_images)) {
                                foreach ($srcset_images as $srcset_image) {
                                    $srcset = explode(",", $srcset_image);
                                    $srcset = array_filter($srcset);
                                    foreach($srcset as $srcset_img) {
                                        $srcset_image_parts = explode(" ", $srcset_img);
                                        foreach ($srcset_image_parts as $srcset_image_part) {
                                            if ( !empty(filter_var($srcset_image_part, FILTER_VALIDATE_URL)) ) {
                                                $tag_images[] = trim($srcset_image_part);
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        $content_images_try_go_get_full_size = apply_filters('wp_all_import_content_images_get_full_size', true, $articleData, $this->id);

                        $images_sources = array(
                            'gallery' => $gallery_images,
                            'tag' => $tag_images
                        );

                        $targetDir = $images_uploads['path'];
                        $targetUrl = $images_uploads['url'];
                        foreach ($images_sources as $source_type => $images){

                            if ( empty($images) ) continue;

                            foreach ( $images as $image ){

                                if ($source_type == 'gallery'){
                                    $image_data = $image;
                                    $image = $image_data['url'];
                                    $image_title = $image_data['title'];
                                    $image_caption = $image_data['caption'];
                                    $image_alt = $image_data['alt'];
                                    $image_description = $image_data['description'];
                                }
                                $original_image_url = $image;
                                // Trying to get image full size.
                                if ($content_images_try_go_get_full_size) {
                                    $full_size = preg_replace('%-\d{2,4}x\d{2,4}%', '', $image);
                                    if ($full_size != $image){
                                        // check if full size image exists
                                        $full_size_headers = get_headers($full_size, true);
                                        if (!empty($full_size_headers['Content-Type']) && strpos($full_size_headers['Content-Type'], 'image') !== false){
                                            $image = $full_size;
                                        }
                                    }
                                }

                                if (empty($image) || !preg_match('%^(http|ftp)s?://%i', $image)) continue;

                                $attid = false;

                                if ($this->options['search_existing_images']) {
                                    // trying to find existing image in images table
                                    $logger and call_user_func($logger, sprintf(__('- Searching for existing image `%s` by URL...', 'wp_all_import_plugin'), rawurldecode($image)));
                                    $imageList = new PMXI_Image_List();
                                    $attch = $imageList->getExistingImageByUrl($image);
                                }

                                // exisitng image founded
                                if ($attch) {
                                    $attid = $attch->ID;
                                    $logger and call_user_func($logger, sprintf(__('- Existing image was found for post content `%s`...', 'wp_all_import_plugin'), rawurldecode($image)));
                                }
                                else {

                                    if ($this->options['search_existing_images']) {
                                        $logger and call_user_func($logger, sprintf(__('- Image `%s` was not found...', 'wp_all_import_plugin'), rawurldecode($image)));
                                    }

                                    // Download remote image and save it in images table.
                                    $url = html_entity_decode(trim($image), ENT_QUOTES);

                                    if (empty($url)) continue;

                                    $bn  = wp_all_import_sanitize_filename(urldecode(wp_all_import_basename($url)));

                                    $img_ext = pmxi_getExtensionFromStr($url);
                                    $default_extension = pmxi_getExtension($bn);
                                    if ($img_ext == "") $img_ext = pmxi_get_remote_image_ext($url);

                                    // Generate local file name.
                                    $image_name = urldecode(("" != $img_ext) ? str_replace("." . $default_extension, "", $bn) : $bn) . (("" != $img_ext) ? '.' . $img_ext : '');

                                    $image_filename = wp_unique_filename($targetDir, $image_name);
                                    $image_filepath = $targetDir . '/' . $image_filename;

                                    $image_info = $this->downloadFile($url, $image_filepath, $is_cron, $logger);

                                    if ($image_info) {
                                        // Create an attachment.
                                        $file_mime_type = '';
                                        if (!empty($image_info) && is_array($image_info)) {
                                            $file_mime_type = image_type_to_mime_type($image_info[2]);
                                        }
                                        $file_mime_type = apply_filters('wp_all_import_image_mime_type', $file_mime_type, $image_filepath);
                                        $handle_image = array(
                                            'file' => $image_filepath,
                                            'url'  => $targetUrl . '/' . $image_filename,
                                            'type' => $file_mime_type
                                        );
                                        $attid = $this->createAttachment($pid, $handle_image, $image_name, $post_author[$i], $post_type[$i], $is_cron, $logger, $bundle_data['type']);
                                    }
                                }

                                // attachment founded or successfully created
                                if ($attid){

                                    $imageRecord = new PMXI_Image_Record();
                                    $imageRecord->getBy(array(
                                        'attachment_id' => $attid
                                    ));
                                    if ($imageRecord->isEmpty()){
                                        $imageRecord->set(array(
                                            'attachment_id' => $attid,
                                            'image_url' => $image,
                                            'image_filename' =>  $image_name
                                        ))->insert();
                                    }
                                    elseif (empty($imageRecord->image_url)){
                                        // update image URL if record already exist
                                        $imageRecord->set(array(
                                            'attachment_id' => $attid,
                                            'image_url' => $image
                                        ))->update();
                                    }

                                    if ($source_type == 'gallery') {
                                        $articleData['post_content'] = str_replace(base64_encode(json_encode($image_data)), $attid, $articleData['post_content']);
                                    }
                                    $attachmentURL = wp_get_attachment_url($attid);
                                    if ($attachmentURL){
                                        preg_match('%-\d{2,4}x\d{2,4}%', $original_image_url, $matches);
                                        if (!empty($matches)){
                                            $attachment_thumbnail_url = preg_replace('%\.(\D{2,4})$%', $matches[0] . '.$1', $attachmentURL);
                                            // check is thumbnail exists
                                            $attachment_thumbnail_path = str_replace($targetUrl, $uploads['path'], $attachment_thumbnail_url);
                                            if (file_exists($attachment_thumbnail_path)){
                                                $articleData['post_content'] = str_replace($original_image_url, $attachment_thumbnail_url, $articleData['post_content']);
                                            }
                                            else{
                                                $articleData['post_content'] = str_replace($original_image_url, $attachmentURL, $articleData['post_content']);
                                            }
                                        }
                                        $articleData['post_content'] = str_replace($image, $attachmentURL, $articleData['post_content']);
                                    }

                                    if ($source_type == 'gallery'){
                                        $update_attachment_meta = array();
                                        $update_attachment_meta['post_title'] = trim($image_title);
                                        $update_attachment_meta['post_excerpt'] = trim($image_caption);
                                        $update_attachment_meta['post_content'] =  trim($image_description);
                                        update_post_meta($attid, '_wp_attachment_image_alt', trim($image_alt));
                                        $this->wpdb->update( $this->wpdb->posts, $update_attachment_meta, array('ID' => $attid) );
                                    }
                                    if (empty($featuredImage) && $is_images_to_update) {
                                        $featuredImage = $attid;
                                    }
                                }
                            }
                            // Update post content
                            $this->wpdb->update( $this->wpdb->posts, array('post_content' => $articleData['post_content']), array('ID' => $pid) );
                        }
                    }

					if ( ! in_array($this->options['custom_type'], array('shop_order', 'import_users', 'shop_customer')) ) {
						$logger and call_user_func($logger, __('<b>IMAGES:</b>', 'wp_all_import_plugin'));
					}

					if ( $is_images_to_update and ! empty($images_uploads) and false === $images_uploads['error'] and (empty($articleData['ID']) or $this->options['update_all_data'] == "yes" or ( $this->options['update_all_data'] == "no" and $this->options['is_update_images']))) {

					    if ( ! empty($images_bundle) ){
							
							require_once(ABSPATH . 'wp-admin/includes/image.php');	

							$is_show_add_new_images = apply_filters('wp_all_import_is_show_add_new_images', true, $post_type[$i]);

                            $is_images_section_enabled = apply_filters('wp_all_import_is_images_section_enabled', true, $post_type[$i]);

							foreach ($images_bundle as $slug => $bundle_data) {

							    if ( ! $is_images_section_enabled && $slug == 'pmxi_gallery_image' ) continue;
								
								$featured_images = $bundle_data['files'];

								$option_slug = ($slug == 'pmxi_gallery_image') ? '' : $slug;

								$gallery_attachment_ids = array();	

								if ( ! empty($featured_images[$i]) ){

									$targetDir = $images_uploads['path'];
									$targetUrl = $images_uploads['url'];

									if ( ! @is_writable($targetDir) ){
										$logger and call_user_func($logger, sprintf(__('<b>ERROR</b>: Target directory %s is not writable', 'wp_all_import_plugin'), $targetDir));
									}
									else{															
										
										$success_images = false;	
																											
										$imgs = array();

										switch ($this->options[$option_slug . 'download_images']) {
											case 'no':
												$featured_delim = $this->options[$option_slug . 'featured_delim'];
												break;
											case 'gallery':
												$featured_delim = $this->options[$option_slug . 'gallery_featured_delim'];
												break;											
											default: // yes
												$featured_delim = $this->options[$option_slug . 'download_featured_delim'];
												break;
										}										

										$line_imgs = explode("\n", $featured_images[$i]);
										if ( ! empty($line_imgs) )
											foreach ($line_imgs as $line_img)
												$imgs = array_merge($imgs, ( ! empty($featured_delim) ) ? str_getcsv($line_img, $featured_delim) : array($line_img) );								

										// keep existing and add newest images
										if ( ! empty($articleData['ID']) and $this->options['is_update_images'] and $this->options['update_images_logic'] == "add_new" and $this->options['update_all_data'] == "no" and $is_show_add_new_images){
											
											$logger and call_user_func($logger, __('- Keep existing and add newest images ...', 'wp_all_import_plugin'));

											$attachment_imgs = get_attached_media( 'image', $pid ); 

											if ( $post_type[$i] == "product" ){
                                                $gallery_attachment_ids = array_filter(explode(",", get_post_meta($pid, '_product_image_gallery', true)));
                                            }

											if ( $attachment_imgs ) {	
												foreach ( $attachment_imgs as $attachment_img ) {													
													$post_thumbnail_id = get_post_thumbnail_id( $pid );
													if ( empty($post_thumbnail_id) and $this->options[$option_slug . 'is_featured'] ) {
														set_post_thumbnail($pid, $attachment_img->ID);
													}
													elseif(!in_array($attachment_img->ID, $gallery_attachment_ids) and $post_thumbnail_id != $attachment_img->ID) {
														$gallery_attachment_ids[] = $attachment_img->ID;													
													}																																	
												}		
												$success_images = true;										
											}																

											if ( ! empty($gallery_attachment_ids) ){
												foreach ($gallery_attachment_ids as $aid){
													do_action( $slug, $pid, $aid, wp_get_attachment_url($aid), 'update_images');
												}
											}
										}
																
										if ( ! empty($imgs) ) {

											if ( $this->options[$option_slug . 'set_image_meta_title'] and !empty($image_meta_titles_bundle[$slug])){		
												$img_titles = array();									
												$line_img_titles = explode("\n", $image_meta_titles_bundle[$slug][$i]);
												if ( ! empty($line_img_titles) )
													foreach ($line_img_titles as $line_img_title)
														$img_titles = array_merge($img_titles, ( ! empty($this->options[$option_slug . 'image_meta_title_delim']) ) ? explode($this->options[$option_slug . 'image_meta_title_delim'], $line_img_title) : array($line_img_title) );
					
											}
											if ( $this->options[$option_slug . 'set_image_meta_caption'] and !empty($image_meta_captions_bundle[$slug])){								
												$img_captions = array();									
												$line_img_captions = explode("\n", $image_meta_captions_bundle[$slug][$i]);
												if ( ! empty($line_img_captions) )
													foreach ($line_img_captions as $line_img_caption)
														$img_captions = array_merge($img_captions, ( ! empty($this->options[$option_slug . 'image_meta_caption_delim']) ) ? explode($this->options[$option_slug . 'image_meta_caption_delim'], $line_img_caption) : array($line_img_caption) );

											}
											if ( $this->options[$option_slug . 'set_image_meta_alt'] and !empty($image_meta_alts_bundle[$slug])){								
												$img_alts = array();									
												$line_img_alts = explode("\n", $image_meta_alts_bundle[$slug][$i]);
												if ( ! empty($line_img_alts) )
													foreach ($line_img_alts as $line_img_alt)
														$img_alts = array_merge($img_alts, ( ! empty($this->options[$option_slug . 'image_meta_alt_delim']) ) ? explode($this->options[$option_slug . 'image_meta_alt_delim'], $line_img_alt) : array($line_img_alt) );

											}
											if ( $this->options[$option_slug . 'set_image_meta_description'] and !empty($image_meta_descriptions_bundle[$slug])){								
												$img_descriptions = array();									
												$line_img_descriptions = ($this->options[$option_slug . 'image_meta_description_delim_logic'] == 'line' or empty($this->options[$option_slug . 'image_meta_description_delim'])) ? explode("\n", $image_meta_descriptions_bundle[$slug][$i]) : array($image_meta_descriptions_bundle[$slug][$i]);
												if ( ! empty($line_img_descriptions) )
													foreach ($line_img_descriptions as $line_img_description)
														$img_descriptions = array_merge($img_descriptions, ($this->options[$option_slug . 'image_meta_description_delim_logic'] == 'separate' and ! empty($this->options[$option_slug . 'image_meta_description_delim']) ) ? explode($this->options[$option_slug . 'image_meta_description_delim'], $line_img_description) : array($line_img_description) );

											}					

											$is_keep_existing_images = ( ! empty($articleData['ID']) and $this->options['is_update_images'] and $this->options['update_images_logic'] == "add_new" and $this->options['update_all_data'] == "no" and $is_show_add_new_images);						

											foreach ($imgs as $k => $img_url) { 

												$attid = false;		

												$attch = null;																										

                                                // remove encoded quotes from url (&#34; and &#39;)
												$url = html_entity_decode(trim($img_url), ENT_QUOTES);

												if (empty($url)) continue;										

												$bn  = wp_all_import_sanitize_filename(urldecode(wp_all_import_basename($url)));
                                                $default_extension = pmxi_getExtension($bn);
												
												if ( "yes" == $this->options[$option_slug . 'download_images'] and ! empty($auto_extensions_bundle[$slug][$i]) and preg_match('%^(jpg|jpeg|png|gif|webp)$%i', $auto_extensions_bundle[$slug][$i])){
													$img_ext = $auto_extensions_bundle[$slug][$i];
												}
												else {
													$img_ext = pmxi_getExtensionFromStr($url);

													if ($img_ext == "") $img_ext = pmxi_get_remote_image_ext($url);		
												}

												$logger and call_user_func($logger, sprintf(__('- Importing image `%s` for `%s` ...', 'wp_all_import_plugin'), $img_url, $this->getRecordTitle($articleData)));

												// generate local file name
												$image_name = urldecode(($this->options[$option_slug . 'auto_rename_images'] and !empty($auto_rename_images_bundle[$slug][$i])) ? sanitize_file_name(($img_ext) ? str_replace("." . $default_extension, "", $auto_rename_images_bundle[$slug][$i]) : $auto_rename_images_bundle[$slug][$i]) : (($img_ext) ? str_replace("." . $default_extension, "", $bn) : $bn)) . (("" != $img_ext) ? '.' . $img_ext : '');
												$image_name = apply_filters("wp_all_import_image_filename", $image_name, empty($img_titles[$k]) ? '' : $img_titles[$k], empty($img_captions[$k]) ? '' : $img_captions[$k], empty($img_alts[$k]) ? '' : $img_alts[$k], $articleData, $this->id, $img_url);

												// if wizard store image data to custom field									
												$create_image   = false;
												$download_image = true;
												$wp_filetype    = false;

												$is_base64_images_allowed = apply_filters("wp_all_import_is_base64_images_allowed", true, $url, $this->id);													

												if ( $bundle_data['type'] == 'images' and base64_encode(base64_decode($url)) == $url and $is_base64_images_allowed ){
                                                    $image_name = empty($this->options[$option_slug . 'auto_rename_images']) ? md5($url) . '.jpg' : sanitize_file_name($auto_rename_images_bundle[$slug][$i]) . '.jpg';
                                                    $image_name = apply_filters("wp_all_import_image_filename", $image_name, empty($img_titles[$k]) ? '' : $img_titles[$k], empty($img_captions[$k]) ? '' : $img_captions[$k], empty($img_alts[$k]) ? '' : $img_alts[$k], $articleData, $this->id, $img_url);

                                                    $image_filename = $image_name;

                                                    // search existing attachment
                                                    if ($this->options[$option_slug . 'search_existing_images'] or "gallery" == $this->options[$option_slug . 'download_images']){

                                                        $attch = wp_all_import_get_image_from_gallery($image_name, $targetDir, $bundle_data['type'], $logger);

                                                        if ("gallery" == $this->options[$option_slug . 'download_images']) $download_image = false;

                                                        if (empty($attch)) {
                                                            $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Image %s not found in media gallery.', 'wp_all_import_plugin'), trim($image_name)));
                                                        }
                                                        else {
                                                            $logger and call_user_func($logger, sprintf(__('- Using existing image `%s` for post `%s` ...', 'wp_all_import_plugin'), trim($image_name), $this->getRecordTitle($articleData)));
                                                            $download_image = false;
                                                            $create_image   = false;
                                                            $attid 			= $attch->ID;
                                                        }
                                                    }

                                                    if ($download_image){
                                                        $img = @imagecreatefromstring(base64_decode($url));
                                                        if($img)
                                                        {
                                                            $logger and call_user_func($logger, __('- found base64_encoded image', 'wp_all_import_plugin'));

                                                            $image_filename = wp_unique_filename($targetDir, $image_filename);
                                                            $image_filepath = $targetDir . '/' . $image_filename;
                                                            imagejpeg($img, $image_filepath);
                                                            if( ! ($image_info = apply_filters('pmxi_getimagesize', @getimagesize($image_filepath), $image_filepath)) or ! in_array($image_info[2], wp_all_import_supported_image_types())) {
                                                                $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s is not a valid image and cannot be set as featured one', 'wp_all_import_plugin'), $image_filepath));
                                                                $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                                            } else {
                                                                $create_image = true;
                                                            }
                                                        }
                                                    }
												} 

												if ( ! $create_image ) {
													
													if ($this->options[$option_slug . 'auto_rename_images'] and !empty($auto_rename_images_bundle[$slug][$i])) {
														if ($k) {
															$image_name = str_replace('.' . pmxi_getExtension($image_name), '', $image_name) . '-' . $k . '.' . pmxi_getExtension($image_name);
														}														
													}
													
													$image_filename = wp_unique_filename($targetDir, $image_name);
													$image_filepath = $targetDir . '/' . $image_filename;

													// search existing attachment
													if ($this->options[$option_slug . 'search_existing_images'] or "gallery" == $this->options[$option_slug . 'download_images']){
														
														$image_filename = $image_name;

                                                        // trying to find existing image in images table
                                                        if ($this->options[$option_slug . 'download_images'] === "yes"){
                                                            $imageList = new PMXI_Image_List();
                                                            switch ($this->options[$option_slug . 'search_existing_images_logic']){
                                                                case 'by_url':
                                                                    $attch = $imageList->getExistingImageByUrl($url);
                                                                    $logger and call_user_func($logger, sprintf(__('- Searching for existing image `%s` by URL...', 'wp_all_import_plugin'), rawurldecode($url)));
                                                                    break;
                                                                default:
                                                                    $attch = $imageList->getExistingImageByFilename($image_name);
                                                                    $logger and call_user_func($logger, sprintf(__('- Searching for existing image `%s` by Filename...', 'wp_all_import_plugin'), $image_name));
                                                                    // Search for existing images for new imports only using old logic.
                                                                    if (empty($attch)) {
                                                                        $logger and call_user_func($logger, sprintf(__('- Search for existing image `%s` by `_wp_attached_file` ...', 'wp_all_import_plugin'), rawurldecode($image_name)));
                                                                        $attch = wp_all_import_get_image_from_gallery($image_name, $targetDir, $bundle_data['type'], $logger);
                                                                    }
                                                                    break;
                                                            }
                                                        }

                                                        if ("gallery" == $this->options[$option_slug . 'download_images']) {
                                                            $download_image = false;
                                                        }

                                                        // Search for existing images for new imports only using old logic.
                                                        if ($this->options[$option_slug . 'download_images'] !== "yes" && empty($attch)) {
                                                            $logger and call_user_func($logger, sprintf(__('- Search for existing image `%s` by `_wp_attached_file` ...', 'wp_all_import_plugin'), rawurldecode($image_name)));
                                                            $attch = wp_all_import_get_image_from_gallery($image_name, $targetDir, $bundle_data['type'], $logger);
                                                        }

                                                        if (empty($attch)) {
                                                            $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Image %s not found in media gallery.', 'wp_all_import_plugin'), rawurldecode($image_name)));
                                                        }
                                                        else {
                                                            $logger and call_user_func($logger, sprintf(__('- Using existing image `%s` for post `%s` ...', 'wp_all_import_plugin'), rawurldecode($image_name), $this->getRecordTitle($articleData)));
                                                            $download_image = false;
                                                            $create_image   = false;
                                                            $attid 			= $attch->ID;
                                                            // save image into images table
                                                            if ("yes" === $this->options[$option_slug . 'download_images']){
                                                                $imageRecord = new PMXI_Image_Record();
                                                                $imageRecord->getBy(array(
                                                                    'attachment_id' => $attid
                                                                ));
                                                                if ($imageRecord->isEmpty()){
                                                                    $imageRecord->set(array(
                                                                        'attachment_id' => $attid,
                                                                        'image_url' => (base64_encode(base64_decode($url)) == $url && $is_base64_images_allowed) ? '' : $url,
                                                                        'image_filename' => $image_name
                                                                    ))->insert();
                                                                }
                                                                else{
                                                                    switch ($this->options[$option_slug . 'search_existing_images_logic']){
                                                                        case 'by_url':
                                                                            // update image URL if it was not set
                                                                            if (empty($imageRecord->image_url)){
                                                                                $imageRecord->set(array(
                                                                                    'image_url' => (base64_encode(base64_decode($url)) == $url && $is_base64_images_allowed) ? '' : $url,
                                                                                ))->update();
                                                                            }
                                                                            break;
                                                                        default:
                                                                            // update image Filename if it was not set
                                                                            if (empty($imageRecord->image_filename)){
                                                                                $imageRecord->set(array(
                                                                                    'image_filename' => $image_name
                                                                                ))->update();
                                                                            }
                                                                            break;
                                                                    }
                                                                }
                                                            }
                                                        }
													}

													if ($download_image && "gallery" != $this->options[$option_slug . 'download_images']){

														// do not download images
														if ( "no" == $this->options[$option_slug . 'download_images'] ){													

                                                            $image_filename = wp_unique_filename($targetDir, $image_name);
															$image_filepath = $targetDir . '/' . $image_filename;		
																
															$wpai_uploads = $uploads['basedir'] . DIRECTORY_SEPARATOR . PMXI_Plugin::FILES_DIRECTORY . DIRECTORY_SEPARATOR;
															$wpai_image_path = $wpai_uploads . str_replace('%20', ' ', $url);

															$logger and call_user_func($logger, sprintf(__('- Searching for existing image `%s`', 'wp_all_import_plugin'), $wpai_image_path));

															if ( @file_exists($wpai_image_path) and @copy( $wpai_image_path, $image_filepath )){
																$download_image = false;		
																// validate import attachments
																if ($bundle_data['type'] == 'files'){
																	if( ! $wp_filetype = wp_check_filetype(wp_all_import_basename($image_filepath), null )) {
																		$logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Can\'t detect attachment file type %s', 'wp_all_import_plugin'), trim($image_filepath)));
																		$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
																		@unlink($image_filepath);
																	}
																	else {
																		$create_image = true;											
																		$logger and call_user_func($logger, sprintf(__('- File `%s` has been successfully found', 'wp_all_import_plugin'), $wpai_image_path));
																	}
																}
																// validate import images
																elseif($bundle_data['type'] == 'images'){
																	if( preg_match('%\W(svg)$%i', wp_all_import_basename($image_filepath)) or $image_info = apply_filters('pmxi_getimagesize', @getimagesize($image_filepath), $image_filepath) and in_array($image_info[2], wp_all_import_supported_image_types())) {
																		$create_image = true;											
																		$logger and call_user_func($logger, sprintf(__('- Image `%s` has been successfully found', 'wp_all_import_plugin'), $wpai_image_path));
																	}
																	else
																	{
																		$logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s is not a valid image and cannot be set as featured one', 'wp_all_import_plugin'), $image_filepath));
																		$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
																		@unlink($image_filepath);
																	}																	
																}
															}													
														}	
														else {
                                                            $image_info = $this->downloadFile($url, $image_filepath, $is_cron, $logger, $bundle_data['type']);
                                                            if ( ! $image_info ) {
                                                                if ( $img_url !== pmxi_convert_encoding($img_url) ) {
                                                                    $url = trim(pmxi_convert_encoding($img_url));
                                                                    $image_info = $this->downloadFile($url, $image_filepath, $is_cron, $logger, $bundle_data['type']);
                                                                }
                                                                else{
                                                                    @unlink($image_filepath);
                                                                }
                                                            }
                                                            $create_image = empty($image_info) ? false : true;
														}												
													}
												}

												$handle_image = false;

                                                // existing image not founded, create new attachment
												if ($create_image){

													$file_mime_type = '';

													if ($bundle_data['type'] == 'images') {
														if ( ! empty($image_info) && is_array($image_info) ) {
															$file_mime_type = image_type_to_mime_type($image_info[2]);
														}														
														$file_mime_type = apply_filters('wp_all_import_image_mime_type', $file_mime_type, $image_filepath);
													}
													else {
														$file_mime_type = $image_info['type'];
													}

													$handle_image = apply_filters( 'wp_all_import_handle_upload', array(
														'file' => $image_filepath,
														'url'  => $targetUrl . '/' . $image_filename,
														'type' => $file_mime_type
													));

													$attid = $this->createAttachment($pid, $handle_image, $image_name, $post_author[$i], $post_type[$i], $is_cron, $logger, $bundle_data['type']);

                                                    // save image into images table
                                                    if ( $attid && "yes" === $this->options[$option_slug . 'download_images']){
                                                        $imageRecord = new PMXI_Image_Record();
                                                        $imageRecord->getBy(array(
                                                            'attachment_id' => $attid
                                                        ));
                                                        if ($imageRecord->isEmpty()){
                                                            $imageRecord->set(array(
                                                                'attachment_id' => $attid,
                                                                'image_url' => (base64_encode(base64_decode($url)) == $url && $is_base64_images_allowed) ? '' : $url,
                                                                'image_filename' => $image_name
                                                            ))->insert();
                                                        }
                                                        else{
                                                            // image already in image table, but was not founded, so updating it with new data
                                                            switch ($this->options[$option_slug . 'search_existing_images_logic']){
                                                                case 'by_url':
                                                                    // update image URL if it was not set
                                                                    if (empty($imageRecord->image_url)){
                                                                        $imageRecord->set(array(
                                                                            'image_url' => (base64_encode(base64_decode($url)) == $url && $is_base64_images_allowed) ? '' : $url
                                                                        ))->update();
                                                                    }
                                                                    break;
                                                                default:
                                                                    // update image Filename if it was not set
                                                                    if (empty($imageRecord->image_filename)){
                                                                        $imageRecord->set(array(
                                                                            'image_filename' => $image_name
                                                                        ))->update();
                                                                    }
                                                                    break;
                                                            }
                                                        }
                                                    }
												}

												if ($attid && ! is_wp_error($attid))
												{
													if ($attch != null && empty($attch->post_parent) && ! in_array($post_type[$i], array('taxonomies'))){
														wp_update_post(
														    array(
														        'ID' => $attch->ID, 
														        'post_parent' => $pid
														    )
														);
													}

													$update_attachment_meta = array();
													if ( $this->options[$option_slug . 'set_image_meta_title'] and ! empty($img_titles[$k]) ) $update_attachment_meta['post_title'] = trim($img_titles[$k]);
													if ( $this->options[$option_slug . 'set_image_meta_caption'] and ! empty($img_captions[$k]) ) $update_attachment_meta['post_excerpt'] =  trim($img_captions[$k]);
													if ( $this->options[$option_slug . 'set_image_meta_description'] and ! empty($img_descriptions[$k]) ) $update_attachment_meta['post_content'] =  trim($img_descriptions[$k]);
													if ( $this->options[$option_slug . 'set_image_meta_alt'] and ! empty($img_alts[$k]) ) update_post_meta($attid, '_wp_attachment_image_alt', trim($img_alts[$k]));
													
													if ( !empty($update_attachment_meta)) {
                                                        $update_attachment_meta['ID'] = $attid;
                                                        $gallery_post = wp_update_post( $update_attachment_meta, true );
                                                        if (is_wp_error($gallery_post)) {
                                                            $logger and call_user_func($logger, sprintf(__('- <b>ERROR</b>: %s', 'wp_all_import_plugin'), $gallery_post));
                                                        }
                                                    }

													$logger and call_user_func($logger, __('- <b>ACTION</b>: ' . $slug, 'wp_all_import_plugin'));																							
													do_action( $slug, $pid, $attid, ($handle_image) ? $handle_image['file'] : $image_filepath, $is_keep_existing_images ? 'add_images' : 'update_images'); 

													$success_images = true;

                                                    switch ($post_type[$i]){
                                                        case 'taxonomies':
                                                            $post_thumbnail_id = get_term_meta( $pid, 'thumbnail_id', true );
                                                            if ($bundle_data['type'] == 'images' and empty($post_thumbnail_id) and ($this->options[$option_slug . 'is_featured'] or !empty($is_image_featured[$i])) ) {
                                                                update_term_meta($pid, 'thumbnail_id', $attid);
                                                            }
                                                            elseif(!in_array($attid, $gallery_attachment_ids) and $post_thumbnail_id != $attid){
                                                                $gallery_attachment_ids[] = $attid;
                                                            }
                                                            break;
                                                        default:
                                                            $post_thumbnail_id = get_post_thumbnail_id( $pid );

                                                            if ($bundle_data['type'] == 'images' and empty($post_thumbnail_id) and ($this->options[$option_slug . 'is_featured'] or !empty($is_image_featured[$i])) ) {
                                                                set_post_thumbnail($pid, $attid);
                                                            }
                                                            elseif(!in_array($attid, $gallery_attachment_ids) and $post_thumbnail_id != $attid){
                                                                $gallery_attachment_ids[] = $attid;
                                                            }
                                                            break;
                                                    }

													if ($attch != null and empty($attch->post_parent)) {
														$logger and call_user_func($logger, sprintf(__('- Attachment with ID: `%s` has been successfully updated for image `%s`', 'wp_all_import_plugin'), $attid, ($handle_image) ? $handle_image['url'] : $targetUrl . '/' . $image_filename));
													}																										
													elseif(empty($attch)) {
														$logger and call_user_func($logger, sprintf(__('- Attachment with ID: `%s` has been successfully created for image `%s`', 'wp_all_import_plugin'), $attid, ($handle_image) ? $handle_image['url'] : $targetUrl . '/' . $image_filename));
													}
												}																		
											}									
										}
										
										// Set product gallery images
										if ( $post_type[$i] == "product" ){
                                            update_post_meta($pid, '_product_image_gallery', (!empty($gallery_attachment_ids)) ? implode(',', $gallery_attachment_ids) : '');
                                        }

										// Create entry as Draft if no images are downloaded successfully
										$final_post_type = get_post_type($pid);
										if ( ! $success_images and "yes" == $this->options[$option_slug . 'create_draft'] and $final_post_type != 'product_variation' and ! in_array($post_type[$i], array('taxonomies', 'comments', 'reviews'))) {
											$this->wpdb->update( $this->wpdb->posts, array('post_status' => 'draft'), array('ID' => $pid) );
											$logger and call_user_func($logger, sprintf(__('- Post `%s` saved as Draft, because no images are downloaded successfully', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
										}										
									}
								}
								else{							
									// Create entry as Draft if no images are downloaded successfully
									$final_post_type = get_post_type($pid);									
									if ( "yes" == $this->options[$option_slug . 'create_draft'] and $final_post_type != 'product_variation' and ! in_array($post_type[$i], array('taxonomies', 'comments', 'reviews'))){
										$this->wpdb->update( $this->wpdb->posts, array('post_status' => 'draft'), array('ID' => $pid) );
										$logger and call_user_func($logger, sprintf(__('Post `%s` saved as Draft, because no images are downloaded successfully', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
									}
								}

								if ( $this->options[$option_slug . "do_not_remove_images"] ){
                                    do_action("wpallimport_after_images_import", $pid, $gallery_attachment_ids, $missing_images);
                                }
							}
						}
					}
					else
					{
						if ( ! empty($images_bundle) ){

							foreach ($images_bundle as $slug => $bundle_data) {

								if ( ! empty($bundle_data['images'][$i]) ){

									$imgs = array();

									$featured_delim = ( "yes" == $this->options[$option_slug . 'download_images'] ) ? $this->options[$option_slug . 'download_featured_delim'] : $this->options[$option_slug . 'featured_delim'];

									$line_imgs = explode("\n", $bundle_data['images'][$i]);
									if ( ! empty($line_imgs) ){
                                        foreach ($line_imgs as $line_img){
                                            $imgs = array_merge($imgs, ( ! empty($featured_delim) ) ? str_getcsv($line_img, $featured_delim) : array($line_img) );
                                        }
                                    }

									foreach ($imgs as $img) {
										do_action( $slug, $pid, false, $img, false);
									}
								}
							}
						}
					}

                    // Set first image as featured in case when Images section nor defined in import template.
                    if (!empty($featuredImage)) {
                        $post_thumbnail_id = get_post_thumbnail_id( $pid );
                        if (empty($post_thumbnail_id) and ($this->options['is_featured'] or !empty($is_image_featured[$i])) ) {
                            set_post_thumbnail($pid, $featuredImage);
                        }
                    }

					if ( ! $is_images_to_update )
					{
						$logger and call_user_func($logger, sprintf(__('Images import skipped for post `%s` according to \'pmxi_is_images_to_update\' filter...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
					}
					// [/featured image]					

                    // [attachments]
                    $is_attachments_to_update = apply_filters('pmxi_is_attachments_to_update', true, $articleData, $current_xml_node);

                    $attachments_uploads = apply_filters('wp_all_import_attachments_uploads_dir', $uploads, $articleData, $current_xml_node, $this->id);

                    if ( $is_attachments_to_update and ! empty($attachments_uploads) and false === $attachments_uploads['error'] and !empty($attachments[$i]) and (empty($articleData['ID']) or $this->options['update_all_data'] == "yes" or ($this->options['update_all_data'] == "no" and $this->options['is_update_attachments']))) {

                        $targetDir = $attachments_uploads['path'];
                        $targetUrl = $attachments_uploads['url'];

                        $logger and call_user_func($logger, __('<b>ATTACHMENTS:</b>', 'wp_all_import_plugin'));

                        if ( ! @is_writable($targetDir) ){
                            $logger and call_user_func($logger, sprintf(__('- <b>ERROR</b>: Target directory %s is not writable', 'wp_all_import_plugin'), trim($targetDir)));
                        }
                        else{
                            // you must first include the image.php file
                            // for the function wp_generate_attachment_metadata() to work
                            require_once(ABSPATH . 'wp-admin/includes/image.php');

                            if ( ! is_array($attachments[$i]) ) $attachments[$i] = array($attachments[$i]);

                            $logger and call_user_func($logger, sprintf(__('- Importing attachments for `%s` ...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));

                            foreach ($attachments[$i] as $attachment) { if ("" == $attachment) continue;

                                $atchs = str_getcsv($attachment, $this->options['atch_delim']);

                                if ( ! empty($atchs) ) {

                                    foreach ($atchs as $atch_url) {	if (empty($atch_url)) continue;

                                        $download_file = true;
                                        $create_file = false;
                                        $attach_id = false;

                                        $atch_url = str_replace(" ", "%20", trim($atch_url));

                                        $attachment_filename = urldecode(wp_all_import_basename(parse_url(trim($atch_url), PHP_URL_PATH)));
                                        $attachment_filepath = $targetDir . '/' . sanitize_file_name($attachment_filename);

                                        if ($this->options['is_search_existing_attach']){

                                            // search existing attachment
                                            $attch = wp_all_import_get_image_from_gallery($attachment_filename, $targetDir, 'files', $logger);

                                            if ( $attch != null ){
                                                $download_file = false;
                                                $create_file = false;
                                                $attach_id = $attch->ID;
                                                $logger and call_user_func($logger, sprintf(__('- Using existing file `%s` for post `%s` ...', 'wp_all_import_plugin'), trim($attachment_filename), $this->getRecordTitle($articleData)));
                                            }

                                            // search existing attachment in files folder
                                            if (empty($attach_id)){

                                                $wpai_uploads = $uploads['basedir'] . DIRECTORY_SEPARATOR . PMXI_Plugin::FILES_DIRECTORY . DIRECTORY_SEPARATOR;
                                                $wpai_file_path = $wpai_uploads . str_replace('%20', ' ', $atch_url);

                                                $logger and call_user_func($logger, sprintf(__('- Searching for existing file `%s`', 'wp_all_import_plugin'), $wpai_file_path));

                                                if ( @file_exists($wpai_file_path) and @copy( $wpai_file_path, $attachment_filepath )){
                                                    // validate import attachments
                                                    if( ! $wp_filetype = wp_check_filetype(wp_all_import_basename($attachment_filepath), null )) {
                                                        $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Can\'t detect attachment file type %s', 'wp_all_import_plugin'), trim($attachment_filepath)));
                                                        $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                                        @unlink($attachment_filepath);
                                                    }
                                                    else {
                                                        $create_file = true;
                                                        $download_file = false;
                                                        $logger and call_user_func($logger, sprintf(__('- File `%s` has been successfully found', 'wp_all_import_plugin'), $wpai_file_path));
                                                    }
                                                }
                                            }
                                        }

                                        if ($download_file && preg_match('%^(http|ftp)s?://%i', $atch_url)){

                                            $attachment_filename = wp_unique_filename($targetDir, $attachment_filename);
                                            $attachment_filepath = $targetDir . '/' . sanitize_file_name($attachment_filename);

                                            $logger and call_user_func($logger, sprintf(__('- Filename for attachment was generated as %s', 'wp_all_import_plugin'), $attachment_filename));

                                            $request = get_file_curl(trim($atch_url), $attachment_filepath);

                                            $get_ctx = stream_context_create(array('http' => array('timeout' => 5)));

                                            if ( (is_wp_error($request) or $request === false)  and ! @file_put_contents($attachment_filepath, @file_get_contents(trim($atch_url), false, $get_ctx))) {
                                                $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Attachment file %s cannot be saved locally as %s', 'wp_all_import_plugin'), trim($atch_url), $attachment_filepath));
                                                is_wp_error($request) and $logger and call_user_func($logger, sprintf(__('- <b>WP Error</b>: %s', 'wp_all_import_plugin'), $request->get_error_message()));
                                                $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                                unlink($attachment_filepath); // delete file since failed upload may result in empty file created
                                            } elseif( ! $wp_filetype = wp_check_filetype(wp_all_import_basename($attachment_filename), null )) {
                                                $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: Can\'t detect attachment file type %s', 'wp_all_import_plugin'), trim($atch_url)));
                                                $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                            } else {
                                                $create_file = true;
                                            }
                                        }

                                        if ($create_file){
                                            $handle_attachment = apply_filters( 'wp_all_import_handle_upload', array(
                                                'file' => $attachment_filepath,
                                                'url'  => $targetUrl . '/' . wp_all_import_basename($attachment_filepath),
                                                'type' => $wp_filetype['type']
                                            ));

                                            $logger and call_user_func($logger, sprintf(__('- File %s has been successfully downloaded', 'wp_all_import_plugin'), $atch_url));
                                            $attachment_data = array(
                                                'guid' => $handle_attachment['url'],
                                                'post_mime_type' => $handle_attachment['type'],
                                                'post_title' => preg_replace('/\.[^.]+$/', '', wp_all_import_basename($handle_attachment['file'])),
                                                'post_content' => '',
                                                'post_status' => 'inherit',
                                                'post_author' => $post_author[$i],
                                            );
                                            $attach_id = wp_insert_attachment( $attachment_data, $handle_attachment['file'], $pid );

                                            if (is_wp_error($attach_id)) {
                                                $logger and call_user_func($logger, __('- <b>WARNING</b>', 'wp_all_import_plugin') . ': ' . $pid->get_error_message());
                                                $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                                            } else {
                                                wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $handle_attachment['file']));
                                                $logger and call_user_func($logger, sprintf(__('- Attachment has been successfully created for post `%s`', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                                $logger and call_user_func($logger, __('- <b>ACTION</b>: pmxi_attachment_uploaded', 'wp_all_import_plugin'));
                                                do_action( 'pmxi_attachment_uploaded', $pid, $attach_id, $handle_attachment['file']);
                                            }
                                        }

                                        if ($attach_id && ! is_wp_error($attach_id))
                                        {
                                            if ($attch != null && empty($attch->post_parent) && ! in_array($post_type[$i], array('taxonomies'))){
                                                wp_update_post(
                                                    array(
                                                        'ID' => $attch->ID,
                                                        'post_parent' => $pid
                                                    )
                                                );
                                            }

                                            if ($attch != null and empty($attch->post_parent))
                                            {
                                                $logger and call_user_func($logger, sprintf(__('- Attachment has been successfully updated for file `%s`', 'wp_all_import_plugin'), (isset($handle_attachment)) ? $handle_attachment['url'] : $targetUrl . '/' . wp_all_import_basename($attachment_filepath)));
                                            }
                                            elseif(empty($attch))
                                            {
                                                $logger and call_user_func($logger, sprintf(__('- Attachment has been successfully created for file `%s`', 'wp_all_import_plugin'), (isset($handle_attachment)) ? $handle_attachment['url'] : $targetUrl . '/' . wp_all_import_basename($attachment_filepath)));
                                            }
                                            $logger and call_user_func($logger, __('- <b>ACTION</b>: pmxi_attachment_uploaded', 'wp_all_import_plugin'));
                                            do_action( 'pmxi_attachment_uploaded', $pid, $attach_id, $attachment_filepath);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if ( ! $is_attachments_to_update )
                    {
                        $logger and call_user_func($logger, sprintf(__('Attachments import skipped for post `%s` according to \'pmxi_is_attachments_to_update\' filter...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                    }
                    // [/attachments]

                    // [comments] - Temporary disabled.
                    if ( false && ! empty($comments['content']) && !in_array($this->options['custom_type'], ['comments', 'reviews', 'taxonomies', 'import_users']) ) {
                        $logger and call_user_func($logger, __('<b>COMMENTS:</b>', 'wp_all_import_plugin'));
                        if ( empty($articleData['ID']) or $this->options['update_all_data'] == "yes" or ( $this->options['update_all_data'] == "no" and $this->options['is_update_comments'] )) {
                            // Delete all existing post comments.
                            if ($this->options['update_comments_logic'] == 'full_update') {
                                $logger and call_user_func($logger, sprintf(__('Deleting existing comments for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                                $current_comments = get_comments(['post_id' => $pid]);
                                if (!empty($current_comments)) {
                                    foreach ($current_comments as $comment) {
                                        wp_delete_comment($comment->comment_ID);
                                    }
                                }
                            }
                            // Create new comments for importing post.
                            $logger and call_user_func($logger, sprintf(__('Importing new comments for post `%s`...', 'wp_all_import_plugin'), $this->getRecordTitle($articleData)));
                            $importedComments = 0;
                            if (!empty($comments['content'][$i])) {
                                foreach ($comments['content'][$i] as $comment_i => $comment_value) {
                                    $commentData = [
                                        'comment_post_ID' => $pid,
                                        'user_id' => $post_author[$i]
                                    ];
                                    foreach ($comments as $comment_key => $comment_values) {
                                        $commentData['comment_' . $comment_key] = isset($comment_values[$i][$comment_i]) ? $comment_values[$i][$comment_i] : '';
                                    }
                                    $commentID = wp_insert_comment($commentData);
                                    if (!is_wp_error($commentID)) {
                                        $importedComments++;
                                    }
                                }
                            }
                            $logger and call_user_func($logger, sprintf(__('`%s` comments were imported for post `%s`...', 'wp_all_import_plugin'), $importedComments, $this->getRecordTitle($articleData)));
                        }
                    }

                    // [custom taxonomies]
					if ( ! empty($taxonomies) ){

						$logger and call_user_func($logger, __('<b>TAXONOMIES:</b>', 'wp_all_import_plugin'));							

						foreach ($taxonomies as $tx_name => $txes) {								

							// Skip updating product attributes
							if ( PMXI_Admin_Addons::get_addon('PMWI_Plugin') and strpos($tx_name, "pa_") === 0 ) continue;

							if ( empty($articleData['ID']) or $this->options['update_all_data'] == "yes" or ( $this->options['update_all_data'] == "no" and $this->options['is_update_categories'] )) {
								
								$logger and call_user_func($logger, sprintf(__('- Importing taxonomy `%s` ...', 'wp_all_import_plugin'), $tx_name));	

								if ( ! empty($this->options['tax_logic'][$tx_name]) and $this->options['tax_logic'][$tx_name] == 'hierarchical' and ! empty($this->options['tax_hierarchical_logic'][$tx_name]) and $this->options['tax_hierarchical_logic'][$tx_name] == 'entire'){
									$logger and call_user_func($logger, sprintf(__('- Auto-nest enabled with separator `%s` ...', 'wp_all_import_plugin'), ( ! empty($this->options['tax_hierarchical_delim'][$tx_name]) ? $this->options['tax_hierarchical_delim'][$tx_name] : ',')));
								}

								if (!empty($articleData['ID'])){
									if ($this->options['update_all_data'] == "no" and $this->options['update_categories_logic'] == "all_except" and !empty($this->options['taxonomies_list']) 
										and is_array($this->options['taxonomies_list']) and in_array($tx_name, $this->options['taxonomies_list'])){ 
											$logger and call_user_func($logger, sprintf(__('- %s %s `%s` has been skipped attempted to `Leave these taxonomies alone, update all others`...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name, $single_tax['name']));
											continue;
										}		
									if ($this->options['update_all_data'] == "no" and $this->options['update_categories_logic'] == "only" and ((!empty($this->options['taxonomies_list']) 
										and is_array($this->options['taxonomies_list']) and ! in_array($tx_name, $this->options['taxonomies_list'])) or empty($this->options['taxonomies_list']))){ 
											$logger and call_user_func($logger, sprintf(__('- %s %s `%s` has been skipped attempted to `Update only these taxonomies, leave the rest alone`...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name, $single_tax['name']));
											continue;
										}
								}								

								$assign_taxes = array();

								if ($this->options['update_categories_logic'] == "add_new" and !empty($existing_taxonomies[$tx_name][$i])){
									$assign_taxes = $existing_taxonomies[$tx_name][$i];	
									unset($existing_taxonomies[$tx_name][$i]);
								}
								elseif(!empty($existing_taxonomies[$tx_name][$i])){
									unset($existing_taxonomies[$tx_name][$i]);
								}

								// create term if not exists
								if ( ! empty($txes[$i]) ):
									foreach ($txes[$i] as $key => $single_tax) {
										$is_created_term = false;
										if (is_array($single_tax) and isset($single_tax['name'])){
											$parent_id = ( ! empty($single_tax['parent'])) ? pmxi_recursion_taxes($single_tax['parent'], $tx_name, $txes[$i], $key) : '';
											$term = (empty($this->options['tax_is_full_search_' . $this->options['tax_logic'][$tx_name]][$tx_name])) ? is_exists_term($single_tax['name'], $tx_name, (int)$parent_id) : is_exists_term($single_tax['name'], $tx_name);
											if ( empty($term) and !is_wp_error($term) ){
												$term = (empty($this->options['tax_is_full_search_' . $this->options['tax_logic'][$tx_name]][$tx_name])) ? is_exists_term(htmlspecialchars($single_tax['name']), $tx_name, (int)$parent_id) : is_exists_term(htmlspecialchars($single_tax['name']), $tx_name);
												if ( empty($term) and !is_wp_error($term) ){
												    // search term by slug
                                                    $term_args = array(
                                                        'name' => $single_tax['name'],
                                                        'taxonomy' => $tx_name
                                                    );
                                                    $term_args = sanitize_term($term_args, $tx_name, 'db');
                                                    $term_name = wp_unslash( $term_args['name'] );
                                                    $term_slug = sanitize_title( $term_name );
                                                    $term = (empty($this->options['tax_is_full_search_' . $this->options['tax_logic'][$tx_name]][$tx_name])) ? is_exists_term($term_slug, $tx_name, (int)$parent_id) : is_exists_term($term_slug, $tx_name);
                                                    if ( empty($term) and !is_wp_error($term) ) {
                                                        $term_attr = array('parent' => (!empty($parent_id)) ? $parent_id : 0);
                                                        $term = wp_insert_term(
                                                            $single_tax['name'], // the term
                                                            $tx_name, // the taxonomy
                                                            $term_attr
                                                        );
                                                        if (!is_wp_error($term)) {
                                                            $is_created_term = TRUE;
                                                            if (empty($parent_id)) {
                                                                $logger and call_user_func($logger, sprintf(__('- Creating parent %s %s `%s` ...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name, $single_tax['name']));
                                                            }
                                                            else {
                                                                $logger and call_user_func($logger, sprintf(__('- Creating child %s %s for %s named `%s` ...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name, (is_array($single_tax['parent']) ? $single_tax['parent']['name'] : $single_tax['parent']), $single_tax['name']));
                                                            }
                                                        }
                                                    }
												}
											}											
											
											if ( is_wp_error($term) ){									
												$logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: `%s`', 'wp_all_import_plugin'), $term->get_error_message()));
												$logger and !$is_cron and PMXI_Plugin::$session->warnings++;
											}
											elseif ( ! empty($term)) {
												$cat_id = $term['term_id'];
												if ($cat_id and $single_tax['assign']) {
													$term = get_term_by('id', $cat_id, $tx_name);
													if ( $term->parent != '0' and ! empty($this->options['tax_is_full_search_' . $this->options['tax_logic'][$tx_name]][$tx_name]) and empty($this->options['tax_assign_to_one_term_' . $this->options['tax_logic'][$tx_name]][$tx_name])){
														$parent_ids = wp_all_import_get_parent_terms($cat_id, $tx_name);
														if ( ! empty($parent_ids)){
															foreach ($parent_ids as $p) {
																if (!in_array($p, $assign_taxes)) $assign_taxes[] = $p;
															}
														}
													}													
													if (!in_array($term->term_taxonomy_id, $assign_taxes)) $assign_taxes[] = $term->term_taxonomy_id;		
													if (!$is_created_term){														
														if ( empty($parent_id) ){															
															$logger and call_user_func($logger, sprintf(__('- Attempted to create parent %s %s `%s`, duplicate detected. Importing %s to existing `%s` %s, ID %d, slug `%s` ...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name, $single_tax['name'], $custom_type_details->labels->singular_name, $term->name, $tx_name, $term->term_id, $term->slug));	
														}
														else{															
															$logger and call_user_func($logger, sprintf(__('- Attempted to create child %s %s `%s`, duplicate detected. Importing %s to existing `%s` %s, ID %d, slug `%s` ...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name, $single_tax['name'], $custom_type_details->labels->singular_name, $term->name, $tx_name, $term->term_id, $term->slug));	
														}	
													}
												}									
											}									
										}
									}				
								endif;
                                $assign_taxes = apply_filters('wp_all_import_set_post_terms', $assign_taxes, $tx_name, $pid, $this->id);
								// associate taxes with post								
								$this->associate_terms($pid, ( empty($assign_taxes) ? false : $assign_taxes ), $tx_name, $logger, $is_cron, $articleData['post_status']);
							}
							else {
								$logger and call_user_func($logger, sprintf(__('- %s %s has been skipped attempted to `Do not update Taxonomies (incl. Categories and Tags)`...', 'wp_all_import_plugin'), $custom_type_details->labels->singular_name, $tx_name));
							}
						}
						if ( $this->options['update_all_data'] == "no" and ( ($this->options['is_update_categories'] and $this->options['update_categories_logic'] != 'full_update') or ( ! $this->options['is_update_categories'] and ( is_object_in_taxonomy( $post_type[$i], 'category' ) or is_object_in_taxonomy( $post_type[$i], 'post_tag' ) ) ) ) ) {
							
							if ( ! empty($existing_taxonomies) ){
								foreach ($existing_taxonomies as $tx_name => $txes) {
									// Skip updating product attributes
									if ( PMXI_Admin_Addons::get_addon('PMWI_Plugin') and strpos($tx_name, "pa_") === 0 ) continue;

									if (!empty($txes[$i]))									
										$this->associate_terms($pid, $txes[$i], $tx_name, $logger, $is_cron, $articleData['post_status']);
								}
							}
						}
					}					
					// [/custom taxonomies]										

					if (empty($articleData['ID'])) {																												
						$logger and call_user_func($logger, sprintf(__('<b>CREATED</b> `%s` `%s` (ID: %s)', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $custom_type_details->labels->singular_name, $pid));
					} else {						
						$logger and call_user_func($logger, sprintf(__('<b>UPDATED</b> `%s` `%s` (ID: %s)', 'wp_all_import_plugin'), $this->getRecordTitle($articleData), $custom_type_details->labels->singular_name, $pid));
					}

					$is_update = ! empty($articleData['ID']);

					// fire important hooks after custom fields are added
					if ( ! $this->options['is_fast_mode'] and ! in_array($this->options['custom_type'], array('import_users', 'shop_customer', 'taxonomies', 'comments', 'reviews'))){
                        $_post = $this->wpdb->get_row( $this->wpdb->prepare( "SELECT * FROM {$this->wpdb->posts} WHERE ID = %d LIMIT 1", $pid ) );
                        $_post = sanitize_post( $_post, 'raw' );
                        $post_object = new WP_Post( $_post );
                        do_action( "save_post_" . $articleData['post_type'], $pid, $post_object, $is_update );
						do_action( 'save_post', $pid, $post_object, $is_update );
						do_action( 'wp_insert_post', $pid, $post_object, $is_update );
					}

					// [addons import]

					// prepare data for import
					$importData = array(
						'pid' => $pid,						
						'import' => $this,						
						'logger' => $logger,
						'is_update' => $is_update											
					);

					$saved_functions = apply_filters('wp_all_import_addon_saved_post', array());

					// deligate operation to addons
					foreach (PMXI_Admin_Addons::get_active_addons() as $class){ 
						if (class_exists($class)){
							if ( method_exists($addons[$class], 'saved_post') ) $addons[$class]->saved_post($importData);	
						}
						else
						{							
							if ( ! empty($saved_functions[$class]) ){ 

								if ( is_array($saved_functions[$class]) and is_callable($saved_functions[$class]) or ! is_array($saved_functions[$class]) and function_exists($saved_functions[$class])  ){

									call_user_func($saved_functions[$class], $importData);		
								}								
							}														
						}
					}
					
					// [/addons import]										
					$logger and call_user_func($logger, __('<b>ACTION</b>: pmxi_saved_post', 'wp_all_import_plugin'));
					do_action( 'pmxi_saved_post', $pid, $rootNodes[$i], $is_update ); // hook that was triggered immediately after post saved

                    // Generate and delete hashes as needed.

                    // sanitize values in the options array that shouldn't invalidate the cache
                    $options = array_diff_key($this->options, $hash_ignore_options);

                    // The hash needs the import options, import ID, post ID, and the file record data.
                    $hash = md5(serialize( $options ) . $this->id . $pid . json_encode($current_xml_node));
                    if( $is_update ){
                        // delete the old hash if exists
                        $this->wpdb->query( 'DELETE FROM '.$this->wpdb->prefix.'pmxi_hash WHERE post_id = '.$pid.' AND import_id = '.$this->id );
                    }
                    $hashPostType = 'post';
                    if (in_array($this->options['custom_type'], ['taxonomies'])) {
                        $hashPostType = 'taxonomy';
                    }
                    if (in_array($this->options['custom_type'], ['import_users', 'shop_customer'])) {
                        $hashPostType = 'user';
                    }
                    // don't waste time doing any checks for existing records
                    $this->wpdb->query( 'INSERT IGNORE INTO '.$this->wpdb->prefix.'pmxi_hash ( hash, post_id, import_id, post_type ) VALUES ( unhex( \''.$hash.'\' ), \''.$pid.'\', \''.$this->id.'\', \''.$hashPostType.'\' )' );
                    // end hashing

					if (empty($articleData['ID'])) $created++; else $updated++;						

					if ( ! $is_cron and "default" == $this->options['import_processing'] ){
						$processed_records = $created + $updated + $skipped;
						$logger and call_user_func($logger, sprintf(__('<span class="processing_info"><span class="created_count">%s</span><span class="updated_count">%s</span><span class="percents_count">%s</span></span>', 'wp_all_import_plugin'), $created, $updated, ceil(($processed_records/$this->count) * 100)));
					}
																					
				}				
				$logger and call_user_func($logger, __('<b>ACTION</b>: pmxi_after_post_import', 'wp_all_import_plugin'));
				do_action('pmxi_after_post_import', $this->id);

				$logger and !$is_cron and PMXI_Plugin::$session->chunk_number++;

                //restore_error_handler();
			}

			$this->set(array(		
				'imported' => $created + $updated,	
				'created'  => $created,
				'updated'  => $updated,
				'skipped'  => $skipped,
				'last_activity' => date('Y-m-d H:i:s')				
			))->update();
			
			if ( ! $is_cron ){

				PMXI_Plugin::$session->save_data();	

				$records_count = $this->created + $this->updated + $this->skipped;

				$records_to_import = (empty($specified_records)) ? $this->count : $specified_records[count($specified_records) -1];

				$is_import_complete = ($records_count == $records_to_import);								

				// Set out of stock status for missing records [Woocommerce add-on option]
				if ( $is_import_complete and empty($this->options['is_delete_missing']) and $post_type[$i] == "product" and class_exists('PMWI_Plugin') and !empty($this->options['missing_records_stock_status']) and "manual" != $this->options['duplicate_matching']) {

					$logger and call_user_func($logger, __('Update stock status previously imported posts which are no longer actual...', 'wp_all_import_plugin'));
					$args = array('import_id' => $this->id, 'iteration !=' => $this->iteration);
					if (!empty($this->options['is_import_specified'])) $args['specified'] = 1;
					$postList = new PMXI_Post_List();									
					$missingPosts = $postList->getBy($args);
					if ( ! $missingPosts->isEmpty() ){
						foreach ($missingPosts as $missingPost) {							
							update_post_meta( $missingPost['post_id'], '_stock_status', 'outofstock' );
							update_post_meta( $missingPost['post_id'], '_stock', 0 );

                            $term_ids = wp_get_object_terms($missingPost['post_id'], 'product_visibility', array('fields' => 'ids'));
                            $outofstock_term = get_term_by( 'name', 'outofstock', 'product_visibility' );
                            if (!empty($outofstock_term) && !is_wp_error($outofstock_term) && !in_array($outofstock_term->term_taxonomy_id, $term_ids)){
                                $term_ids[] = $outofstock_term->term_taxonomy_id;
                            }
                            $this->associate_terms( $missingPost['post_id'], $term_ids, 'product_visibility', $logger );

							$missingPostRecord = new PMXI_Post_Record();
							$missingPostRecord->getBy('id', $missingPost['id']);
							if ( ! $missingPostRecord->isEmpty())
								$missingPostRecord->set(array('iteration' => $this->iteration))->update();
							unset($missingPostRecord);								
						}
					}
				}	
			}		
			
		} catch (XmlImportException $e) {
			$logger and call_user_func($logger, __('<b>ERROR</b>', 'wp_all_import_plugin') . ': ' . $e->getMessage());
			$logger and !$is_cron and PMXI_Plugin::$session->errors++;	
		}				
		
		$logger and $is_import_complete and call_user_func($logger, __('Cleaning temporary data...', 'wp_all_import_plugin'));
		foreach ($tmp_files as $file) { // remove all temporary files created
			@unlink($file);
		}			
		
		remove_filter('user_has_cap', array($this, '_filter_has_cap_unfiltered_html')); kses_init(); // return any filtering rules back if they has been disabled for import procedure
		
		return $this;
	}

    private function getRecordTitle($articleData){
        switch ($this->options['custom_type']){
			case 'import_users':
			case 'shop_customer':
                $title = $articleData['user_login'];
                break;
            case 'comments':
            case 'reviews':
                $title = wp_trim_words($articleData['comment_content'], 10);
                break;
            default:
                $title = $articleData['post_title'];
                break;
        }
        return $title;
    }

    public function downloadFile($url, $image_filepath, $is_cron = false, $logger, $type = 'images'){

        $downloaded = false;

        $file_info = false;

        $logger and call_user_func($logger, sprintf(__('- Downloading image from `%s`', 'wp_all_import_plugin'), $url));

        $request = get_file_curl($url, $image_filepath);

        $get_ctx = stream_context_create(array('http' => array('timeout' => 5)));

        if ( (is_wp_error($request) or $request === false) and ! @file_put_contents($image_filepath, @file_get_contents($url, false, $get_ctx))) {
            $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s can not be downloaded, response %s', 'wp_all_import_plugin'), $url, maybe_serialize($request)));
            @unlink($image_filepath); // delete file since failed upload may result in empty file created
        } else{

            if($type == 'images'){
                if( preg_match('%\W(svg)$%i', wp_all_import_basename($image_filepath)) or $file_info = apply_filters('pmxi_getimagesize', @getimagesize($image_filepath), $image_filepath) and in_array($file_info[2], wp_all_import_supported_image_types())) {
                    $downloaded = true;
                    if (preg_match('%\W(svg)$%i', wp_all_import_basename($image_filepath))){
                        $file_info = true;
                    }
                    $logger and call_user_func($logger, sprintf(__('- Image `%s` has been successfully downloaded', 'wp_all_import_plugin'), $url));
                }
                else
                {
                    $logger and call_user_func($logger, sprintf(__('- <b>WARNING</b>: File %s is not a valid image and cannot be set as featured one', 'wp_all_import_plugin'), $url));
                    $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
                }
            }
            elseif($type == 'files'){
                if( $file_info = wp_check_filetype(wp_all_import_basename($image_filepath), null )) {
                    $downloaded = true;
                    $logger and call_user_func($logger, sprintf(__('- File `%s` has been successfully downloaded', 'wp_all_import_plugin'), $url));
                }
            }
        }

        return $downloaded ? $file_info : false;
    }

    public function createAttachment($pid, $handle_image, $image_name, $post_author, $post_type, $is_cron, $logger, $type = 'images'){

        $logger and call_user_func($logger, sprintf(__('- Creating an attachment for image `%s`', 'wp_all_import_plugin'), $handle_image['url']));

        $attachment_title = explode(".", $image_name);
        if (is_array($attachment_title) and count($attachment_title) > 1) array_pop($attachment_title);

        $attachment = array(
            'post_mime_type' => $handle_image['type'],
            'guid' => $handle_image['url'],
            'post_title' => implode(".", $attachment_title),
            'post_content' => '',
            'post_author' => $post_author,
        );
        if ($type == 'images' and ($image_meta = wp_read_image_metadata($handle_image['file']))) {
            if (trim($image_meta['title']) && ! is_numeric(sanitize_title($image_meta['title'])))
                $attachment['post_title'] = $image_meta['title'];
            if (trim($image_meta['caption']))
                $attachment['post_content'] = $image_meta['caption'];
        }

        remove_all_actions('add_attachment');

        if ( in_array($post_type, array('taxonomies', 'comments', 'reviews')) ){
            $attid = wp_insert_attachment($attachment, $handle_image['file'], 0);
        }
        else{
            $attid = wp_insert_attachment($attachment, $handle_image['file'], $pid);
        }

        if (is_wp_error($attid)) {
            $logger and call_user_func($logger, __('- <b>WARNING</b>', 'wp_all_import_plugin') . ': ' . $attid->get_error_message());
            $logger and !$is_cron and PMXI_Plugin::$session->warnings++;
        } else {
            /**
             * Fires once an attachment has been added.
             */
            do_action( 'wp_all_import_add_attachment', $attid );
            wp_update_attachment_metadata($attid, wp_generate_attachment_metadata($attid, $handle_image['file']));
        }

        return ( $attid && ! is_wp_error($attid) ) ? $attid : false;
    }

	public function delete_source($logger = false)
	{
		if ($this->options['is_delete_source']) 
		{
			$uploads = wp_upload_dir();

			$logger and call_user_func($logger, __('Deleting source XML file...', 'wp_all_import_plugin'));			

			// Delete chunks
			foreach (PMXI_Helper::safe_glob($uploads['basedir'] . DIRECTORY_SEPARATOR . PMXI_Plugin::TEMP_DIRECTORY . DIRECTORY_SEPARATOR . 'pmxi_chunk_*', PMXI_Helper::GLOB_RECURSE | PMXI_Helper::GLOB_PATH) as $filePath) {
				$logger and call_user_func($logger, __('Deleting chunks files...', 'wp_all_import_plugin'));
				@file_exists($filePath) and wp_all_import_remove_source($filePath, false);		
			}

			if ($this->type != "ftp"){
				$apath = wp_all_import_get_absolute_path($this->path);
				if ( ! @unlink($apath)) {
					$logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: Unable to remove %s', 'wp_all_import_plugin'), $apath));
				}
			}
			else{
				$file_path_array = PMXI_Helper::safe_glob($this->path, PMXI_Helper::GLOB_NODIR | PMXI_Helper::GLOB_PATH);
				if (!empty($file_path_array)){
					foreach ($file_path_array as $path) {
						$apath = wp_all_import_get_absolute_path($path);
						if ( ! @unlink($apath)) {
							$logger and call_user_func($logger, sprintf(__('<b>WARNING</b>: Unable to remove %s', 'wp_all_import_plugin'), $apath));
						}
					}
				}
			}
		}
	}	

	public function delete_missing_records($logger, $iteration)
	{
		if ( ! empty($this->options['is_delete_missing']) and $this->options['duplicate_matching'] == 'auto') { 

			empty($this->deleted) and $logger and call_user_func($logger, __('Removing previously imported posts which are no longer actual...', 'wp_all_import_plugin'));
			$postList = new PMXI_Post_List();									

			$args = array('import_id' => $this->id, 'iteration !=' => $iteration);			
			if ( ! empty($this->options['is_import_specified']) ) $args['specified'] = 1;			

			$missing_ids = array();
			$missingPosts = $postList->getBy($args);

			if ( ! $missingPosts->isEmpty() ): 
				
				foreach ($missingPosts as $missingPost) {
				
					$missing_ids[] = $missingPost;
													
				}

			endif;							

			// Delete posts from database
			if ( ! empty($missing_ids) && is_array($missing_ids) ){																	
				
				$logger and call_user_func($logger, __('<b>ACTION</b>: pmxi_delete_post', 'wp_all_import_plugin'));													

				$logger and call_user_func($logger, __('Deleting posts from database', 'wp_all_import_plugin'));

				$missing_ids_arr = array_chunk($missing_ids, $this->options['records_per_request']);

                $skipp_from_deletion = array();

				foreach ($missing_ids_arr as $key => $missingPostRecords) {

					if ( ! empty($missingPostRecords) ) {

						foreach ( $missingPostRecords as $k => $missingPostRecord ) {
							
							$to_delete = true;
							
							// Instead of deletion, set Custom Field
							if ($this->options['is_update_missing_cf']){
                                switch ($this->options['custom_type']){
                                    case 'import_users':
                                        update_user_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                        $logger and call_user_func($logger, sprintf(__('Instead of deletion user with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                        break;
									case 'shop_customer':
                                        update_user_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                        $logger and call_user_func($logger, sprintf(__('Instead of deletion customer with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                        break;
                                    case 'taxonomies':
                                        update_term_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                        $logger and call_user_func($logger, sprintf(__('Instead of deletion taxonomy term with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                        break;
                                    case 'reviews':
                                    case 'comments':
                                        update_comment_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                        $logger and call_user_func($logger, sprintf(__('Instead of deletion comment with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                        break;
                                    default:
                                        update_post_meta( $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value'] );
                                        $logger and call_user_func($logger, sprintf(__('Instead of deletion post with ID `%s`, set Custom Field `%s` to value `%s`', 'wp_all_import_plugin'), $missingPostRecord['post_id'], $this->options['update_missing_cf_name'], $this->options['update_missing_cf_value']));
                                        break;
                                }

								$to_delete = false;
							}

							// Instead of deletion, change post status to Draft							
							if ($this->options['set_missing_to_draft']){
								if ($final_post_type = get_post_type($missingPostRecord['post_id']) and $final_post_type != 'product_variation' and 'draft' != get_post_status($missingPostRecord['post_id']))
								{
									$this->wpdb->update( $this->wpdb->posts, array('post_status' => 'draft'), array('ID' => $missingPostRecord['post_id']) );
                                    $this->recount_terms($missingPostRecord['post_id'], $final_post_type);
									$logger and call_user_func($logger, sprintf(__('Instead of deletion, change post with ID `%s` status to Draft', 'wp_all_import_plugin'), $missingPostRecord['post_id']));
								}								
								$to_delete = false;
							}
							
							$to_delete = apply_filters('wp_all_import_is_post_to_delete', $to_delete, $missingPostRecord['post_id'], $this);

							if ($to_delete) {
                                if ( ! in_array($this->options['custom_type'], array("import_users", "taxonomies", "shop_customer")) ){
                                    do_action('pmxi_before_delete_post', $missingPostRecord['post_id'], $this);
                                    // Remove attachments
                                    empty($this->options['is_keep_attachments']) and wp_delete_attachments($missingPostRecord['post_id'], true, 'files');
                                    // Remove images
                                    empty($this->options['is_keep_imgs']) and wp_delete_attachments($missingPostRecord['post_id'], true, 'images');
                                    // Clear post's relationships
                                    wp_delete_object_term_relationships($missingPostRecord['post_id'], get_object_taxonomies('' != $this->options['custom_type'] ? $this->options['custom_type'] : 'post'));
                                }
							}	
							else {
                                $skipp_from_deletion[] = $missingPostRecord['post_id'];
								$postRecord = new PMXI_Post_Record();
								$postRecord->getBy(array(
									'post_id' => $missingPostRecord['post_id'],
									'import_id' => $this->id,
								));
                                if ( ! $postRecord->isEmpty() )
                                {
                                    $is_unlink_missing_posts = apply_filters('wp_all_import_is_unlink_missing_posts', false, $this->id, $missingPostRecord['post_id']);
                                    if ( $is_unlink_missing_posts ){
                                        $postRecord->delete();
                                    }
                                    else {
                                        $postRecord->set(array(
                                            'iteration' => $iteration
                                        ))->save();
                                    }
                                }

								do_action('pmxi_missing_post', $missingPostRecord['post_id']);

								unset($missingPostRecords[$k]);							
							}
						}

                        $ids = array();

						if ( ! empty($missingPostRecords) ){

							foreach ($missingPostRecords as $k => $missingPostRecord) {
								$ids[] = $missingPostRecord['post_id'];
							}

                            switch ($this->options['custom_type']){
								case 'import_users':
								case 'shop_customer':
                                    do_action('pmxi_delete_post', $ids, $this);
									// delete_user action
									foreach( $ids as $id) {
                                        do_action( 'delete_user', $id, $reassign = null );
                                    }
                                    $sql = "delete a,b
                                      FROM ".$this->wpdb->users." a
                                      LEFT JOIN ".$this->wpdb->usermeta." b ON ( a.ID = b.user_id )										
                                      WHERE a.ID IN (" . implode(',', $ids) . ");";
									// deleted_user action
									foreach( $ids as $id) {
                                        do_action( 'deleted_user', $id, $reassign = null );
                                    }
                                    $this->wpdb->query( $sql );
                                    break;
                                case 'taxonomies':
                                    do_action('pmxi_delete_taxonomy_term', $ids, $this);
                                    foreach ($ids as $term_id){
                                        wp_delete_term( $term_id, $this->options['taxonomy_type'] );
                                    }
                                    break;
                                case 'reviews':
                                case 'comments':
                                    do_action('pmxi_delete_comment', $ids, $this);
                                    foreach ($ids as $comment_id){
                                        wp_delete_comment( $comment_id, true );
                                    }
                                    break;
                                default:
                                    do_action('pmxi_delete_post', $ids, $this);
                                    foreach ($ids as $post_id){
                                        wp_delete_post( $post_id, TRUE );
                                    }
                                    break;
                            }
								
							// Delete record form pmxi_posts
							$sql = "DELETE FROM " . PMXI_Plugin::getInstance()->getTablePrefix() . "posts WHERE post_id IN (".implode(',', $ids).") AND import_id = %d";
							$this->wpdb->query( 
								$this->wpdb->prepare($sql, $this->id)
							);	

							$this->set(array('deleted' => $this->deleted + count($ids)))->update();	

							$logger and call_user_func($logger, sprintf(__('%d Posts deleted from database. IDs (%s)', 'wp_all_import_plugin'), $this->deleted, implode(",", $ids)));
						}
					}	

					if ( PMXI_Plugin::is_ajax() and "ajax" == $this->options['import_processing']) break;
				}

                do_action('wp_all_import_skipped_from_deleted', $skipp_from_deletion, $this);

				return (count($missing_ids_arr) > 1 and "ajax" == $this->options['import_processing']) ? false : true; 
			}
		}

		return true;
	}

	protected function pushmeta($pid, $meta_key, $meta_value){

		if (empty($meta_key)) return;		

		$this->post_meta_to_insert[] = array(
			'meta_key' => $meta_key,
			'meta_value' => $meta_value,
			'pid' => $pid
		);		

	}

	protected function executeSQL(){
		
		$import_entry = ( in_array( $this->options['custom_type'], array('import_users', 'shop_customer') ) ) ? 'user' : 'post';

		// prepare bulk SQL query
		$meta_table = _get_meta_table( $import_entry );
		
		if ( $this->post_meta_to_insert ){			
			$values = array();
			$already_added = array();
			
			foreach (array_reverse($this->post_meta_to_insert) as $key => $value) {
				if ( ! empty($value['meta_key']) and ! in_array($value['pid'] . '-' . $value['meta_key'], $already_added) ){
					$already_added[] = $value['pid'] . '-' . $value['meta_key'];						
					$values[] = '(' . $value['pid'] . ',"' . $value['meta_key'] . '",\'' . maybe_serialize($value['meta_value']) .'\')';						
				}
			}
			
			$this->wpdb->query("INSERT INTO $meta_table (`" . $import_entry . "_id`, `meta_key`, `meta_value`) VALUES " . implode(',', $values));
			$this->post_meta_to_insert = array();
		}	
	}
	
	public function _filter_has_cap_unfiltered_html($caps)
	{
		$caps['unfiltered_html'] = true;
		return $caps;
	}

	protected function recount_terms($pid, $post_type){

        $exclude_taxonomies = apply_filters('pmxi_exclude_taxonomies', (class_exists('PMWI_Plugin')) ? array('post_format', 'product_type', 'product_shipping_class') : array('post_format'));
        $post_taxonomies = array_diff_key(get_taxonomies_by_object_type(array($post_type), 'object'), array_flip($exclude_taxonomies));

        foreach ($post_taxonomies as $ctx){
            $terms = wp_get_object_terms( $pid, $ctx->name );
            if ( ! empty($terms) ){
                if ( ! is_wp_error( $terms ) ) {
                    foreach ($terms as $term_info) {
                        $this->wpdb->query(  $this->wpdb->prepare("UPDATE {$this->wpdb->term_taxonomy} SET count = count - 1 WHERE term_taxonomy_id = %d AND count > 0", $term_info->term_taxonomy_id) );
                    }
                }
            }
        }
    }

	protected function associate_terms( $pid, $assign_taxes, $tx_name, $logger, $is_cron = false, $post_status = 'publish' ) {
        $use_wp_set_object_terms = apply_filters('wp_all_import_use_wp_set_object_terms', false, $tx_name);
        if ($use_wp_set_object_terms) {
            $term_ids = [];
            if (!empty($assign_taxes)) {
                foreach ($assign_taxes as $ttid) {
                    $term = get_term_by('term_taxonomy_id', $ttid, $tx_name);
                    if ($term) {
                        $term_ids[] = $term->term_id;
                    }
                }
            }
            return wp_set_object_terms($pid, $term_ids, $tx_name);
        }

	    $term_ids = wp_get_object_terms( $pid, $tx_name, array( 'fields' => 'ids' ) );

		$assign_taxes = ( is_array( $assign_taxes ) ) ? array_filter( $assign_taxes ) : false;

		if ( ! empty( $term_ids ) && ! is_wp_error( $term_ids ) ) {
			$in_tt_ids = "'" . implode( "', '", $term_ids ) . "'";
			$this->wpdb->query( "UPDATE {$this->wpdb->term_taxonomy} SET count = count - 1 WHERE term_taxonomy_id IN ($in_tt_ids) AND count > 0" );
			$this->wpdb->query( $this->wpdb->prepare( "DELETE FROM {$this->wpdb->term_relationships} WHERE object_id = %d AND term_taxonomy_id IN ($in_tt_ids)", $pid ) );
		}

		if ( empty( $assign_taxes ) ) return;

		$values     = array();
		$term_order = 0;

        $term_ids = array();
        foreach ( $assign_taxes as $tt ) {
            do_action( 'wp_all_import_associate_term', $pid, $tt, $tx_name );
            $values[] = $this->wpdb->prepare( "(%d, %d, %d)", $pid, $tt, ++ $term_order );
            $term_ids[] = $tt;
        }

        if ( 'draft' !== $post_status ) {
            $in_tt_ids = "'" . implode("', '", $term_ids) . "'";
            $this->wpdb->query("UPDATE {$this->wpdb->term_taxonomy} SET count = count + 1 WHERE term_taxonomy_id IN ($in_tt_ids)");
        }

        if ( $values ) {
            if ( false === $this->wpdb->query( "INSERT INTO {$this->wpdb->term_relationships} (object_id, term_taxonomy_id, term_order) VALUES " . join( ',', $values ) . " ON DUPLICATE KEY UPDATE term_order = VALUES(term_order)" ) ) {
                $logger and call_user_func( $logger, __( '<b>ERROR</b> Could not insert term relationship into the database', 'wp_all_import_plugin' ) . ': ' . $this->wpdb->last_error );
            }
        }

		wp_cache_delete( $pid, $tx_name . '_relationships' );
	}

	/**
	 * Clear associations with posts via Ajax
	 * @param bool[optional] $keepPosts When set to false associated wordpress posts will be deleted as well
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function deletePostsAjax($keepPosts = TRUE, $is_deleted_images = 'auto', $is_delete_attachments = 'auto') {
		if ( ! $keepPosts) {
			$missing_ids = array();
			$sql = "SELECT post_id FROM " . PMXI_Plugin::getInstance()->getTablePrefix() . "posts WHERE import_id = %d";
			$missingPosts = $this->wpdb->get_results( 
				$this->wpdb->prepare($sql, $this->id)
			);
			if ( ! empty($missingPosts) ):
				foreach ($missingPosts as $missingPost) {
					$missing_ids[] = $missingPost->post_id;
				}
			endif;
			// Delete posts from database
			if ( ! empty($missing_ids) && is_array($missing_ids) ){
				$missing_ids_arr = array_chunk($missing_ids, $this->options['records_per_request']);
				foreach ($missing_ids_arr as $key => $ids) {
					if ( ! empty($ids) ) {
						$this->deleteRecords($is_delete_attachments, $is_deleted_images, $ids);
						// Delete record form pmxi_posts
						$sql = "DELETE FROM " . PMXI_Plugin::getInstance()->getTablePrefix() . "posts WHERE post_id IN (".implode(',', $ids).") AND import_id = %d";
						$this->wpdb->query( 
							$this->wpdb->prepare($sql, $this->id)
						);
						$this->set(array('deleted' => $this->deleted + count($ids)))->update();						
					}
					break;
				}
				return (count($missing_ids_arr) > 1) ? false : true;
			}								
		}
		return true;
	}

	/**
	 * Clear associations with posts
	 * @param bool[optional] $keepPosts When set to false associated wordpress posts will be deleted as well
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function deletePosts($keepPosts = TRUE, $is_deleted_images = 'auto', $is_delete_attachments = 'auto') {
		$post = new PMXI_Post_List();		
		if ( ! $keepPosts) {								
			$ids = array();
			foreach ($post->getBy('import_id', $this->id)->convertRecords() as $p) {								
				$ids[] = $p->post_id;
			}
			if ( ! empty($ids) ){
				$this->deleteRecords($is_delete_attachments, $is_deleted_images, $ids);
			}			
		}
		$this->wpdb->query($this->wpdb->prepare('DELETE FROM ' . $post->getTable() . ' WHERE import_id = %s', $this->id));
		return $this;
	}

	protected function deleteRecords( $is_delete_attachments, $is_deleted_images, $ids = array() ) {
		foreach ( $ids as $k => $id ) {
            if ( ! in_array($this->options['custom_type'], array('import_users', 'taxonomies', 'shop_customer', 'comments', 'reviews')) ){
                do_action('pmxi_before_delete_post', $id, $this);
                // Remove attachments.
                if ($is_delete_attachments == 'yes' or $is_delete_attachments == 'auto' and empty($this->options['is_keep_attachments'])) {
                    wp_delete_attachments($id, true, 'files');
                }
                else {
                    wp_delete_attachments($id, false, 'files');
                }
                // Remove images.
                if ($is_deleted_images == 'yes' or $is_deleted_images == 'auto' and empty($this->options['is_keep_imgs'])) {
                    wp_delete_attachments($id, true, 'images');
                }
                else {
                    wp_delete_attachments($id, false, 'images');
                }
                wp_delete_object_term_relationships($id, get_object_taxonomies('' != $this->options['custom_type'] ? $this->options['custom_type'] : 'post'));
            }
		}

        switch ($this->options['custom_type']){
			case 'import_users':
			case 'shop_customer':
                do_action('pmxi_delete_post', $ids, $this);
                // delete_user action
                foreach( $ids as $id) {
                    do_action( 'delete_user', $id, $reassign = null );
                }
                $sql = "delete a,b
                FROM ".$this->wpdb->users." a
                LEFT JOIN ".$this->wpdb->usermeta." b ON ( a.ID = b.user_id )					
                WHERE a.ID IN (".implode(',', $ids).");";
                // deleted_user action
                foreach( $ids as $id) {
                    do_action( 'deleted_user', $id, $reassign = null );
                }
                $this->wpdb->query($sql);
                break;
            case 'taxonomies':
                do_action('pmxi_delete_taxonomies', $ids);
                foreach ($ids as $term_id){
                    wp_delete_term( $term_id, $this->options['taxonomy_type'] );
                }
                break;
            case 'reviews':
            case 'comments':
                do_action('pmxi_delete_comments', $ids);
                foreach ($ids as $comment_id){
                    wp_delete_comment( $comment_id, true );
                }
                break;
            default:
                do_action('pmxi_delete_post', $ids, $this);
                foreach ($ids as $id) {
                    wp_delete_post($id, TRUE);
                }
                break;
        }
	}

	/**
	 * Delete associated files
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function deleteFiles() {
		$fileList = new PMXI_File_List();
		foreach($fileList->getBy('import_id', $this->id)->convertRecords() as $f) {			
			$f->delete();
		}
		return $this;
	}
	/**
	 * Delete associated history logs
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function deleteHistories(){		
		$historyList = new PMXI_History_List();
		foreach ($historyList->getBy('import_id', $this->id)->convertRecords() as $h) {			
			$h->delete();
		}
		return $this;
	}
	/**
	 * Delete associated sub imports
	 * @return PMXI_Import_Record
	 * @chainable
	 */
	public function deleteChildren($keepPosts = TRUE){
		$importList = new PMXI_Import_List();
		foreach ($importList->getBy('parent_import_id', $this->id)->convertRecords() as $i) {
			$i->delete($keepPosts);
		}
		return $this;
	}	
	/**
	 * @see parent::delete()
	 * @param bool[optional] $keepPosts When set to false associated wordpress posts will be deleted as well
	 */
	public function delete($keepPosts = TRUE, $is_deleted_images = 'auto', $is_delete_attachments = 'auto', $is_delete_import = TRUE) {
		$this->deletePosts($keepPosts, $is_deleted_images, $is_delete_attachments);
		if ($is_delete_import)
		{
			$this->deleteFiles()->deleteHistories()->deleteChildren($keepPosts);
		}		
		$expired_sessions   = array();
		$expired_sessions[] = "_wpallimport_session_expires_" . $this->id . "_";
		$expired_sessions[] = "_wpallimport_session_" . $this->id . "_";
		foreach ($expired_sessions as $expired) {
			wp_cache_delete( $expired, 'options' );
			delete_option($expired);
		}
		return ($is_delete_import) ? parent::delete() : true;
	}

	public function canBeScheduled()
    {
        return in_array($this->type, array('url', 'ftp', 'file'));
    }
	
}
