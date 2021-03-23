
<script type="text/javascript">
	var plugin_url = '<?php echo WP_ALL_IMPORT_ROOT_URL; ?>';
</script>

<div class="change_file">

	<div class="rad4 first-step-errors error-upload-rejected">
		<div class="wpallimport-notify-wrapper">
			<div class="error-headers exclamation">
				<h3><?php _e('File upload rejected by server', 'wp_all_import_plugin');?></h3>
				<h4><?php _e("Contact your host and have them check your server's error log.", "wp_all_import_plugin"); ?></h4>
			</div>		
		</div>		
		<a class="button button-primary button-hero wpallimport-large-button wpallimport-notify-read-more" href="http://www.wpallimport.com/documentation/troubleshooting/problems-with-import-files/" target="_blank"><?php _e('Read More', 'wp_all_import_plugin');?></a>		
	</div>

	<div class="rad4 first-step-errors error-file-validation" <?php if ( ! empty($upload_validation) ): ?> style="display:block;" <?php endif; ?>>
		<div class="wpallimport-notify-wrapper">
			<div class="error-headers exclamation">
				<h3><?php _e('There\'s a problem with your import file', 'wp_all_import_plugin');?></h3>
				<h4>
					<?php 
					if ( ! empty($upload_validation) ): 										
						$file_type = strtoupper(pmxi_getExtension($post['file']));
						printf(__('This %s file has errors and is not valid.', 'wp_all_import_plugin'), $file_type); 
					endif;
					?>
				</h4>
			</div>		
		</div>		
		<a class="button button-primary button-hero wpallimport-large-button wpallimport-notify-read-more" href="http://www.wpallimport.com/documentation/troubleshooting/problems-with-import-files/#invalid" target="_blank"><?php _e('Read More', 'wp_all_import_plugin');?></a>		
	</div>		

	<div class="wpallimport-content-section">
		<div class="wpallimport-collapsed-header" style="padding-left:30px;">
			<h3><?php _e('Import File','wp_all_import_plugin');?></h3>	
		</div>
		<div class="wpallimport-collapsed-content" style="padding-bottom: 40px;">
			<hr>
			<table class="form-table" style="max-width:none;">
				<tr>
					<td colspan="3">

						<div class="wpallimport-import-types">
							<h3><?php _e('Specify the location of the file to use for future runs of this import.', 'wp_all_import_plugin'); ?></h3>
							<a class="wpallimport-import-from wpallimport-upload-type <?php echo 'upload' == $import->type ? 'selected' : '' ?>" rel="upload_type" href="javascript:void(0);">
								<span class="wpallimport-icon"></span>
								<span class="wpallimport-icon-label"><?php _e('Upload a file', 'wp_all_import_plugin'); ?></span>
							</a>
							<a class="wpallimport-import-from wpallimport-url-type <?php echo ('url' == $import->type || 'ftp' == $import->type) ? 'selected' : '' ?>" rel="url_type" href="javascript:void(0);">
								<span class="wpallimport-icon"></span>
								<span class="wpallimport-icon-label"><?php _e('Download a file', 'wp_all_import_plugin'); ?></span>
							</a>
							<a class="wpallimport-import-from wpallimport-file-type <?php echo 'file' == $import->type ? 'selected' : '' ?>" rel="file_type" href="javascript:void(0);">
								<span class="wpallimport-icon"></span>
								<span class="wpallimport-icon-label"><?php _e('Use existing file', 'wp_all_import_plugin'); ?></span>
							</a>
						</div>						
						
						<input type="hidden" value="<?php echo $post['type']; ?>" name="new_type"/>

						<div class="wpallimport-upload-type-container" rel="upload_type">							
							<div id="plupload-ui" class="wpallimport-file-type-options">
					            <div>				                
					                <input type="hidden" name="filepath" value="<?php if ('upload' == $import->type) echo $import->path; ?>" id="filepath"/>
					                <a id="select-files" href="javascript:void(0);"/><?php _e('Click here to select file from your computer...', 'wp_all_import_plugin'); ?></a>
					                <div id="progressbar" class="wpallimport-progressbar">
					                	<?php if ('upload' == $import->type) _e( '<span>Upload Complete</span> - '.basename($import->path).' 100%', 'wp_all_import_plugin'); ?>
					                </div>
					                <div id="progress" class="wpallimport-progress" <?php if ('upload' == $import->type):?>style="display: block;"<?php endif;?>>
					                	<div id="upload_process" class="wpallimport-upload-process"></div>				                	
					                </div>
					            </div>
					        </div>
						</div>
						<div class="wpallimport-upload-type-container" rel="url_type">
                            <div class="wpallimport-choose-data-type">
                                <a class="wpallimport-download-from rad4 wpallimport-download-file-from-url <?php if ($import->type == 'url') echo 'wpallimport-download-from-checked'; ?>" rel="url" href="javascript:void(0);">
                                    <span class="wpallimport-download-from-title"><?php _e('From URL', 'wp_all_import_plugin'); ?></span>
                                    <span class="wpallimport-download-from-arrow"></span>
                                </a>
                                <a class="wpallimport-download-from rad4 wpallimport-download-file-from-ftp <?php if ($import->type == 'ftp') echo 'wpallimport-download-from-checked'; ?>" rel="ftp" href="javascript:void(0);">
                                    <span class="wpallimport-download-from-title"><?php _e('From FTP/SFTP', 'wp_all_import_plugin'); ?></span>
                                    <span class="wpallimport-download-from-arrow"></span>
                                </a>
                            </div>
						</div>
						<div class="wpallimport-upload-type-container" rel="file_type">		
							<?php $upload_dir = wp_upload_dir(); ?>					
							<div class="wpallimport-file-type-options">								
								
								<?php
									$files_directory = DIRECTORY_SEPARATOR . PMXI_Plugin::FILES_DIRECTORY . DIRECTORY_SEPARATOR;

                                    $scan_recursively = apply_filters('wp_all_import_scan_files_recursively', TRUE);

                                    $glob_flags = $scan_recursively ? PMXI_Helper::GLOB_NODIR | PMXI_Helper::GLOB_RECURSE : PMXI_Helper::GLOB_NODIR;

                                    $local_files = array_merge(
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.xml', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.gz', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.zip', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.gzip', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.csv', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.dat', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.psv', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.json', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.txt', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.sql', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.xls', $glob_flags),
                                        PMXI_Helper::safe_glob($upload_dir['basedir'] . $files_directory . '*.xlsx', $glob_flags)
                                    );
									sort($local_files);
									$sizes = array();
									if ( ! empty($local_files)){
										foreach ($local_files as $file) {
											$sizes[] = filesize($upload_dir['basedir'] . $files_directory . $file);
										}
									}
								    $import_file = str_replace(DIRECTORY_SEPARATOR . PMXI_Plugin::FILES_DIRECTORY . DIRECTORY_SEPARATOR, '', $import->path);
								?>
								<script type="text/javascript">									
									var existing_file_sizes = <?php echo json_encode($sizes) ?>;
								</script>

								<select name="" id="file_selector">
									<option value=""><?php _e('Select a previously uploaded file', 'wp_all_import_plugin'); ?></option>
									<?php foreach ($local_files as $file) :?>
										<option value="<?php echo $file; ?>" <?php if ( 'file' == $import->type and $file == $import_file ):?>selected="selected"<?php endif; ?>><?php echo basename($file); ?></option>
									<?php endforeach; ?>
								</select>
								
								<input type="hidden" name="file" value="<?php if ('file' == $import->type) echo esc_attr($import->path); ?>"/>	

								<script type="text/javascript">									
									var existing_file_sizes = <?php echo json_encode($sizes) ?>;
								</script>
								<div class="wpallimport-note" style="width:60%; margin: 0 auto; ">
									<?php printf(__('Upload files to <strong>%s</strong> and they will appear in this list', 'wp_all_import_plugin'), $upload_dir['basedir'] . $files_directory) ?>
								</div>
							</div>
						</div>

                        <div class="wpallimport-download-resource-step-two">
                            <div class="wpallimport-download-resource wpallimport-download-resource-step-two-url">
                                <div class="wpallimport-file-type-options">
                                    <span class="wpallimport-input-icon wpallimport-url-icon"></span>
                                    <input type="text" class="regular-text" name="url" value="<?php echo ('url' == $import->type) ? esc_attr($import->path) : 'Enter a web address to download the file from...'; ?>"/>
                                    <!--a href="javascript:void(0);" class="wpallimport-download-from-url"><?php _e('Upload', 'wp_all_import_plugin'); ?></a-->
                                </div>
                                <input type="hidden" name="downloaded"/>
                            </div>
                            <div class="wpallimport-download-resource wpallimport-download-resource-step-two-ftp">
                                <div class="wpallimport-file-type-options">
                                    <span class="wpallimport-input-icon wpallimport-ftp-host-icon"></span>
                                    <input type="text" class="regular-text" name="ftp_host" value="<?php echo ( ! empty($import->options['ftp_host'])) ? esc_attr($import->options['ftp_host']) : ''; ?>" placeholder="Enter FTP server address"/>
                                    <a class="wpallimport-help" href="#help" style="position: relative; top: -2px;" title="<?php _e('The server address of your FTP/SFTP server. This can be an IP address or domain name. You do not need to include the connection protocol. For example, files.example.com or 127.0.0.1', PMXI_Plugin::LANGUAGE_DOMAIN); ?>">?</a>
                                </div>
                                <div class="wpallimport-file-type-options">
                                    <span class="wpallimport-input-icon wpallimport-ftp-port-icon"></span>
                                    <input type="text" class="regular-text" name="ftp_port" value="<?php echo ( ! empty($import->options['ftp_port'])) ? esc_attr($import->options['ftp_port']) : ''; ?>" placeholder="Enter FTP port"/>
                                    <a class="wpallimport-help" href="#help" style="position: relative; top: -2px;" title="<?php _e('The port that your server uses. FTP usually uses port 21, SFTP usually uses port 22', PMXI_Plugin::LANGUAGE_DOMAIN); ?>">?</a>
                                </div>
                                <div class="wpallimport-file-type-options">
                                    <span class="wpallimport-input-icon wpallimport-ftp-username-icon"></span>
                                    <input type="text" class="regular-text" name="ftp_username" value="<?php echo ( ! empty($import->options['ftp_username'])) ? esc_attr($import->options['ftp_username']) : ''; ?>" placeholder="Enter FTP username"/>
                                    <a class="wpallimport-help" href="#help" style="position: relative; top: -2px;" title="<?php _e('If you don\'t know your FTP/SFTP username, contact the host of the server.', PMXI_Plugin::LANGUAGE_DOMAIN); ?>">?</a>
                                </div>
                                <div class="wpallimport-file-type-options">
                                    <span class="wpallimport-input-icon wpallimport-ftp-password-icon"></span>
                                    <input type="text" class="regular-text" name="ftp_password" value="<?php echo ( ! empty($import->options['ftp_password'])) ? esc_attr($import->options['ftp_password']) : ''; ?>" placeholder="Enter FTP password"/>
                                    <a class="wpallimport-help" href="#help" style="position: relative; top: -2px;" title="<?php _e('These passwords are stored in plaintext in your WordPress database. Ideally, the user account should only have read access to the files that you are importing.
<br/><br/>Even if the password is correct, sometimes your host will require SFTP connections to use an SSH key and will deny connection attempts using passwords. If you\'re unable to login, you don\'t have a SSH/SFTP Private Key, and you are sure the password is correct, contact the host of the server.', PMXI_Plugin::LANGUAGE_DOMAIN); ?>">?</a>
                                </div>
                                <div class="wpallimport-file-type-options">
                                    <span class="wpallimport-input-icon wpallimport-ftp-private-key-icon"></span>
                                    <textarea class="wpai-ftp-text-area" name="ftp_private_key" placeholder="SFTP Private Key"><?php echo ( ! empty($import->options['ftp_private_key'])) ? esc_attr($import->options['ftp_private_key']) : ''; ?></textarea>
                                    <a class="wpallimport-help" id="wpai-ftp-text-area-help" href="#help" style="position: relative; top: -2px;" title="<?php _e('If you don\'t know if you need an SFTP Private Key, contact the host of the server.', PMXI_Plugin::LANGUAGE_DOMAIN); ?>">?</a>
                                </div>
                                <div style="display:none;">
                                    <input type="hidden" name="ftp_root"
                                           value="<?php echo ( ! empty( $import->options['ftp_root'] ) ) ? esc_attr( $import->options['ftp_root'] ) : ''; ?>"/>
                                </div>
                                <div class="wpallimport-file-type-options ftp_path">

                                    <input type="text" class="regular-text" name="ftp_path"
                                           value="<?php echo ( ! empty($import->options['ftp_path'])) ? esc_attr($import->options['ftp_path']) : ''; ?>"
                                           placeholder="FTP file path"/>

                                    <a class="wpallimport-ftp-builder rad4 button button-primary button-hero wpallimport-large-button wpai-ftp-select-file-button"
                                       href="javascript:void(0);">
                                        <div class="easing-spinner"
                                             style="display: none; left: 36px !important; top: 2px;">
                                            <div class="double-bounce1"></div>
                                            <div class="double-bounce2"></div>
                                        </div>
			                            <?php _e( 'Select File', 'wp_all_import_plugin' ); ?>
                                    </a>

                                </div>
                                <div style="display:block;position:relative;width:75%;margin:auto;">
                                    <span class="wpallimport-input-icon wpallimport-ftp-path-icon"></span>
                                    <a class="wpallimport-help" href="#help"
                                       style="position: absolute;top: -32px;right: -30px;"
                                       title="<?php _e( 'The path to the file you want to import. In case multiple files are found, only the first will be downloaded. Examples: /home/ftpuser/import.csv or import-files/*.csv', PMXI_Plugin::LANGUAGE_DOMAIN ); ?>">?</a>
                                </div>

                                <span class="wpallimport-ftp-builder-wrap">
                                <div class="wpallimport-ftp-connection-builder" id="wpallimport-ftp-connection-builder">
                                </div>
                                <input type="hidden" id="wpai-ftp-browser-nonce"
                                       value="<?php echo wp_create_nonce( 'wpai-ftp-browser' ); ?>"/>
                                </span>

                                <div class="rad4 first-step-errors wpai-ftp-connection-error">
                                    <div class="wpallimport-notify-wrapper">
                                        <div class="error-headers exclamation">
                                            <h3><?php _e('Unable to Connect', 'wp_all_import_plugin');?></h3>
                                            <br/>
                                            <span id="wpai-ftp-connection-error-message"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
					</td>
				</tr>
			</table>
		</div>		
	</div>
</div>