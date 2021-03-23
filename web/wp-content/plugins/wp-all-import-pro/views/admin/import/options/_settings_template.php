<div class="wpallimport-collapsed closed wpallimport-section">
	<div class="wpallimport-content-section">
		<div class="wpallimport-collapsed-header">
			<h3><?php _e('Configure Advanced Settings','wp_all_import_plugin');?></h3>	
		</div>
		<div class="wpallimport-collapsed-content" style="padding: 0;">
			<div class="wpallimport-collapsed-content-inner">				
				<table class="form-table" style="max-width:none;">
					<tr>
						<td colspan="3">
							<h4><?php _e('Import Speed Optimization', 'wp_all_import_plugin'); ?></h4>									
							<div class="input">
                                <label for="processing_iteration_logic_custom"><?php _e('In each iteration, process', 'wp_all_import_plugin');?></label> <input type="text" name="records_per_request" style="vertical-align:middle; font-size:11px; background:#fff !important; width: 40px; text-align:center;" value="<?php echo esc_attr($post['records_per_request']) ?>" /> <?php _e('records', 'wp_all_import_plugin'); ?>
                                <a href="#help" class="wpallimport-help" style="position: relative; top: -2px;" title="<?php _e('WP All Import must be able to process this many records in less than your server\'s timeout settings. If your import fails before completion, to troubleshoot you should lower this number. If you are importing images, especially high resolution images, high numbers here are probably a bad idea, since downloading the images can take lots of time - for example, 20 posts with 5 images each = 100 images. At 500Kb per image that\'s 50Mb that needs to be downloaded. Can your server download that before timing out? If not, the import will fail.', 'wp_all_import_plugin'); ?>">?</a>

                                <div class="input" style="margin:5px 0px;">
                                    <input type="hidden" name="chuncking" value="0" />
                                    <input type="checkbox" id="chuncking" name="chuncking" value="1" class="fix_checkbox" <?php echo $post['chuncking'] ? 'checked="checked"': '' ?>/>
                                    <label for="chuncking"><?php _e('Split file up into <strong>' . PMXI_Plugin::getInstance()->getOption('large_feed_limit') . '</strong> record chunks.', 'wp_all_import_plugin');?></label>
                                    <a href="#help" class="wpallimport-help" style="position: relative; top: -2px;" title="<?php _e('This option will decrease the amount of slowdown experienced at the end of large imports. The slowdown is partially caused by the need for WP All Import to read deeper and deeper into the file on each successive iteration. Splitting the file into pieces means that, for example, instead of having to read 19000 records into a 20000 record file when importing the last 1000 records, WP All Import will just split it into 20 chunks, and then read the last chunk from the beginning.','wp_all_import_plugin'); ?>">?</a>
                                </div>
							</div>				
							<div class="input">
								<input type="hidden" name="is_fast_mode" value="0" />
								<input type="checkbox" id="is_fast_mode" name="is_fast_mode" value="1" class="fix_checkbox" <?php echo $post['is_fast_mode'] ? 'checked="checked"': '' ?>/>
								<label for="is_fast_mode"><?php _e('Increase speed by disabling do_action calls in wp_insert_post during import.', 'wp_all_import_plugin') ?> 
									<a href="#help" class="wpallimport-help" style="position: relative; top: -2px;" title="<?php _e('This option is for advanced users with knowledge of WordPress development. Your theme or plugins may require these calls when posts are created. Next action will be disabled: \'transition_post_status\', \'save_post\', \'pre_post_update\', \'add_attachment\', \'edit_attachment\', \'edit_post\', \'post_updated\', \'wp_insert_post\'. Verify your created posts work properly if you check this box.', 'wp_all_import_plugin') ?>">?</a></label>
							</div>					
							<?php if ( ! $this->isWizard ): ?>

								<?php if ( 'taxonomies' == $post['custom_type'] ):?>
									<h4><?php _e('Taxonomy Type', 'wp_all_import_plugin'); ?></h4>
									<p><?php _e('Editing this will change the taxonomy type of the taxonomies processed by this import. Re-run the import for the changes to take effect.', 'wp_all_import_plugin');?></p> <br>
								<?php else: ?>
									<h4><?php _e('Post Type', 'wp_all_import_plugin'); ?></h4>
									<p><?php _e('Editing this will change the post type of the posts processed by this import. Re-run the import for the changes to take effect.', 'wp_all_import_plugin');?></p> <br>
								<?php endif; ?>
									
								<input type="hidden" name="custom_type" value="<?php echo $post['custom_type'];?>">

								<?php if ( 'taxonomies' == $post['custom_type'] ):?>
									<div class="wp_all_import_change_taxonomy_type">
										<input type="hidden" name="taxonomy_type" value="<?php echo $post['taxonomy_type'];?>">
										<select id="taxonomy_to_import">
											<option value=""><?php _e('Select Taxonomy', 'wp_all_export_plugin'); ?></option>
											<?php $options = wp_all_import_get_taxonomies(); ?>
											<?php foreach ($options as $slug => $name):?>
												<option value="<?php echo $slug;?>" <?php if ($post['taxonomy_type'] == $slug):?>selected="selected"<?php endif;?>><?php echo $name;?></option>
											<?php endforeach;?>
										</select>
									</div>
								<?php else: ?>
								<?php
									$hiddenPosts = array(
										'attachment',
										'revision',
										'nav_menu_item',
										'shop_webhook',
										'import_users',
										'wp-types-group',
										'wp-types-user-group',
										'wp-types-term-group',
										'acf-field',
										'acf-field-group',
										'custom_css',
										'customize_changeset',
										'oembed_cache',
                                        'wp_block',
                                        'user_request',
                                        'scheduled-action'
									);
									$custom_types = get_post_types(array('_builtin' => true), 'objects') + get_post_types(array('_builtin' => false, 'show_ui' => true), 'objects'); 
									foreach ($custom_types as $key => $ct) {
										if (in_array($key, $hiddenPosts)) unset($custom_types[$key]);
									}
									$custom_types = apply_filters( 'pmxi_custom_types', $custom_types, 'custom_types' );

									$sorted_cpt = array();
									foreach ($custom_types as $key => $cpt){

										$sorted_cpt[$key] = $cpt;

										// Put users & comments & taxonomies after Pages
										if ( ! empty($custom_types['page']) && $key == 'page' || empty($custom_types['page']) && $key == 'post' ){

                                            $sorted_cpt['taxonomies'] = new stdClass();
                                            $sorted_cpt['taxonomies']->labels = new stdClass();
                                            $sorted_cpt['taxonomies']->labels->name = __('Taxonomies','wp_all_export_plugin');

											$sorted_cpt['import_users'] = new stdClass();
											$sorted_cpt['import_users']->labels = new stdClass();
											$sorted_cpt['import_users']->labels->name = __('Users','wp_all_export_plugin');

                                            $sorted_cpt['comments'] = new stdClass();
                                            $sorted_cpt['comments']->labels = new stdClass();
                                            $sorted_cpt['comments']->labels->name = __('Comments','wp_all_export_plugin');

											break;
										}
									}
									$order = array('shop_order', 'shop_coupon', 'shop_customer', 'product');
									foreach ($order as $cpt){
										if (!empty($custom_types[$cpt])) $sorted_cpt[$cpt] = $custom_types[$cpt];
									}

									uasort($custom_types, "wp_all_import_cmp_custom_types");

									foreach ($custom_types as $key => $cpt) {
										if (empty($sorted_cpt[$key])){
											$sorted_cpt[$key] = $cpt;
										}
									}

									$hidden_post_types = get_post_types(array('_builtin' => false, 'show_ui' => false), 'objects');
									foreach ($hidden_post_types as $key => $ct) {
										if (in_array($key, $hiddenPosts)) unset($hidden_post_types[$key]);
									}
									$hidden_post_types = apply_filters( 'pmxi_custom_types', $hidden_post_types, 'hidden_post_types' );

								?>	
								<div class="wpallimport-change-custom-type">
								<select name="custom_type_selector" id="custom_type_selector" class="wpallimport-post-types">


                                <?php
                                // *****************************************************
                                // **************** START CPT LOOP *********************
                                // *****************************************************
                                ?>

                                    <?php
                                    $known_imgs     = array( 'post', 'page', 'product', 'import_users', 'shop_order', 'shop_coupon', 'shop_customer', 'users', 'comments', 'taxonomies', 'woo_reviews' );
                                    $all_posts      = array_merge( $sorted_cpt, $hidden_post_types );
                                    $all_posts      = apply_filters( 'pmxi_custom_types', $all_posts, 'all_types' );
                                    $ordered_posts  = array( 'post', 'page', 'taxonomies', 'comments', 'import_users', 'shop_order', 'shop_coupon', 'product', 'woo_reviews', 'shop_customer' );

                                    foreach ( $all_posts as $key => $post_obj ) {
                                        if ( ! in_array( $key, $ordered_posts ) ) {
                                            array_push( $ordered_posts, $key );
                                        }
                                    }                                    
                                    
                                    $order_arr          = apply_filters( 'pmxi_post_list_order', $ordered_posts );                                    
                                    $image_data         = apply_filters( 'wp_all_import_post_type_image', array() );

                                    foreach ( $order_arr as $key => $post_name ) {
                                        if ( array_key_exists( $post_name, $all_posts ) ) {
                                            $post_obj = $all_posts[ $post_name ];
                                            
                                            if ( in_array( $post_name, $known_imgs ) ) {
                                                $image_src = 'dashicon-' . $post_name;
                                            } else {
                                                $image_src = 'dashicon-cpt';
                                            }
                                            if ( ! empty( $image_data ) && array_key_exists( $post_name, $image_data ) ) {
                                                $custom_img_defined = true;
                                            } else {
                                                $custom_img_defined = false;
                                            }
                                            
                                            $original_image_src = $image_src;                                                                                                 
                                            $cpt = $post_name;
                                            $cpt_label = $post_obj->labels->name;
                                            
                                            // Allows the MyListing add-on to select the listing type that was imported.
                                            $custom_selected_post = apply_filters( 'wpai_custom_selected_post', false, $post, $cpt, 'settings' );

                                            $img_to_echo = 'dashicon ';

                                            if ( $custom_img_defined === true ) { 
                                                $img_to_echo .= $image_data[ $cpt ]['image']; 
                                            } else {
                                                $img_to_echo .= $image_src;
                                            }
                                            
                                            ?>
                                            <option value="<?php echo $cpt; ?>" data-imagesrc="<?php echo $img_to_echo; ?>" <?php if ( $custom_selected_post === true ):?>selected="selected"<?php else: if ( $cpt == $post['custom_type'] ):?>selected="selected"<?php endif; endif; ?>><?php echo $cpt_label; ?></option>
                                            <?php
                                        }

                                    }                                    
                                    ?>
                                    </select>

                                    <?php
                                    // *****************************************************
                                    // **************** FINISH CPT LOOP ********************
                                    // *****************************************************
                                    ?>

									<?php if ( ! class_exists('PMUI_Plugin') ): ?>
										<div class="wpallimport-upgrade-notice" rel="import_users">
											<p><?php _e('The User Add-On is Required to Import Users', 'wp_all_import_plugin'); ?></p>
											<a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=2707221&edd_options%5Bprice_id%5D=1" target="_blank" class="upgrade_link"><?php _e('Purchase the User Add-On', 'wp_all_import_plugin');?></a>
										</div>
									<?php endif; ?>


									<?php if ( class_exists('WooCommerce') && ! class_exists('PMUI_Plugin') ): ?>
										<div class="wpallimport-upgrade-notice" rel="shop_customer">
											<p><?php _e('The User Add-On is Required to Import Customers', 'wp_all_import_plugin'); ?></p>
											<a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=2707221&edd_options%5Bprice_id%5D=1" target="_blank" class="upgrade_link"><?php _e('Purchase the User Add-On', 'wp_all_import_plugin');?></a>
										</div>
									<?php endif; ?>


									<?php if ( class_exists('WooCommerce') && ! class_exists('PMWI_Plugin') ): ?>
										<div class="wpallimport-upgrade-notice" rel="product">
											<p><?php _e('The WooCommerce Add-On is Required to Import Products', 'wp_all_import_plugin'); ?></p>
											<a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=2707227&edd_options%5Bprice_id%5D=1" target="_blank" class="upgrade_link"><?php _e('Purchase the WooCommerce Add-On Pro', 'wp_all_import_plugin');?></a>
										</div>
									<?php endif; ?>
									<?php if ( class_exists('WooCommerce') &&  ( ! class_exists('PMWI_Plugin') || class_exists('PMWI_Plugin') && PMWI_EDITION == 'free') ): ?>
										<div class="wpallimport-upgrade-notice" rel="shop_order">
											<p><?php _e('The WooCommerce Add-On Pro is Required to Import Orders', 'wp_all_import_plugin'); ?></p>
											<a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=2707227&edd_options%5Bprice_id%5D=1" target="_blank" class="upgrade_link"><?php _e('Purchase the WooCommerce Add-On Pro', 'wp_all_import_plugin');?></a>
										</div>
										<div class="wpallimport-upgrade-notice" rel="shop_coupon">
											<p><?php _e('The WooCommerce Add-On Pro is Required to Import Coupons', 'wp_all_import_plugin'); ?></p>
											<a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=2707227&edd_options%5Bprice_id%5D=1" target="_blank" class="upgrade_link"><?php _e('Purchase the WooCommerce Add-On Pro', 'wp_all_import_plugin');?></a>
										</div>
									<?php endif; ?>

								</div>
								<?php endif; ?>
								<h4><?php _e('XPath', 'wp_all_import_plugin'); ?></h4>
								<p><?php _e('Editing this can break your entire import. You will have to re-create it from scratch.', 'wp_all_import_plugin');?></p> <br>
								<div class="input">
									<input type="text" name="xpath" value="<?php echo esc_attr($import->xpath) ?>" style="width: 50%; font-size: 18px; color: #555; height: 50px; padding: 10px;"/>
								</div>
								<?php if ( ! empty($post['delimiter']) ): ?>
								<h4><?php _e('CSV Delimiter', 'wp_all_import_plugin'); ?></h4>
								<div class="input">
									<input type="text" name="delimiter" value="<?php echo $post['delimiter']; ?>" style="width: 50px !important; font-size: 18px; color: #555; height: 50px; padding: 10px;"/>
								</div>
								<?php endif; ?>
								<h4><?php _e('Downloads', 'wp_all_import_plugin'); ?></h4>

								<div class="input">
									<button class="button button-primary download_import_template" rel="<?php echo add_query_arg(array('page' => 'pmxi-admin-manage', 'id' => intval($_GET['id']), 'action' => 'get_template', '_wpnonce' => wp_create_nonce( '_wpnonce-download_template' )), $this->baseUrl); ?>" style="background-image: none;"><?php _e('Import Template', 'wp_all_import_plugin'); ?></button>
									<button class="button button-primary download_import_bundle" rel="<?php echo add_query_arg(array('page' => 'pmxi-admin-manage', 'id' => intval($_GET['id']), 'action' => 'bundle', '_wpnonce' => wp_create_nonce( '_wpnonce-download_bundle' )), $this->baseUrl); ?>" style="background-image: none;"><?php _e('Import Bundle', 'wp_all_import_plugin'); ?></button>
								</div>
							<?php endif; ?>
							<h4><?php _e('Other', 'wp_all_import_plugin'); ?></h4>
							<div class="input">
								<input type="hidden" name="is_import_specified" value="0" />
								<input type="checkbox" id="is_import_specified" class="switcher fix_checkbox" name="is_import_specified" value="1" <?php echo $post['is_import_specified'] ? 'checked="checked"': '' ?>/>
								<label for="is_import_specified"><?php _e('Import only specified records', 'wp_all_import_plugin') ?> <a href="#help" class="wpallimport-help" style="position:relative; top:0;" title="<?php _e('Enter records or record ranges separated by commas, e.g. <b>1,5,7-10</b> would import the first, the fifth, and the seventh to tenth.', 'wp_all_import_plugin') ?>">?</a></label>
								<div class="switcher-target-is_import_specified" style="vertical-align:middle">
									<div class="input" style="display:inline;">
										<input type="text" name="import_specified" value="<?php echo esc_attr($post['import_specified']) ?>" style="width:320px;"/>
									</div>
								</div>
							</div>
							<?php if (isset($source_type) and in_array($source_type, array('ftp', 'file'))): ?>						
								<div class="input">
									<input type="hidden" name="is_delete_source" value="0" />
									<input type="checkbox" id="is_delete_source" class="fix_checkbox" name="is_delete_source" value="1" <?php echo $post['is_delete_source'] ? 'checked="checked"': '' ?>/>
									<label for="is_delete_source"><?php _e('Delete source XML file after importing', 'wp_all_import_plugin') ?> <a href="#help" class="wpallimport-help" style="position:relative; top:0;" title="<?php _e('This setting takes effect only when script has access rights to perform the action, e.g. file is not deleted when pulled via HTTP or delete permission is not granted to the user that script is executed under.', 'wp_all_import_plugin') ?>">?</a></label>
								</div>						
							<?php endif; ?>
							<?php if (class_exists('PMLC_Plugin')): // option is only valid when `WP Wizard Cloak` pluign is enabled ?>						
								<div class="input">
									<input type="hidden" name="is_cloak" value="0" />
									<input type="checkbox" id="is_cloak" class="fix_checkbox" name="is_cloak" value="1" <?php echo $post['is_cloak'] ? 'checked="checked"': '' ?>/>
									<label for="is_cloak"><?php _e('Auto-Cloak Links', 'wp_all_import_plugin') ?> <a href="#help" class="wpallimport-help" style="position:relative; top:0;" title="<?php printf(__('Automatically process all links present in body of created post or page with <b>%s</b> plugin', 'wp_all_import_plugin'), PMLC_Plugin::getInstance()->getName()) ?>">?</a></label>
								</div> 						
							<?php endif; ?>							
							<div class="input">
								<input type="hidden" name="xml_reader_engine" value="0" />
								
								<?php if ( PMXI_Plugin::getInstance()->getOption('force_stream_reader') ): ?>
									<input type="checkbox" id="xml_reader_engine" class="fix_checkbox" name="xml_reader_engine" value="1" checked="checked" disabled="disabled"/>
									<label for="xml_reader_engine"><?php _e('Use StreamReader instead of XMLReader to parse import file', 'wp_all_import_plugin') ?> <a href="#help" class="wpallimport-help" style="position:relative; top:0;" title="<?php _e('WP All Import is being forced to use Stream Reader for all imports. Go to WP All Import ▸ Settings to modify this setting.', 'wp_all_import_plugin'); ?>">?</a></label>
								<?php else : ?>
									<input type="checkbox" id="xml_reader_engine" class="fix_checkbox" name="xml_reader_engine" value="1" <?php echo $post['xml_reader_engine'] ? 'checked="checked"': '' ?>/>
									<label for="xml_reader_engine"><?php _e('Use StreamReader instead of XMLReader to parse import file', 'wp_all_import_plugin') ?> <a href="#help" class="wpallimport-help" style="position:relative; top:0;" title="<?php _e('XMLReader is much faster, but has a bug that sometimes prevents certain records from being imported with import files that contain special cases.', 'wp_all_import_plugin'); ?>">?</a></label>
								<?php endif; ?>																	
							</div>
							
							<div class="input" style="margin-top: 15px;">
								<p><?php _e('Friendly Name','wp_all_import_plugin');?></p> <br>
								<div class="input">
									<input type="text" name="friendly_name" style="vertical-align:middle; background:#fff !important; width: 50%;" value="<?php echo esc_attr($post['friendly_name']) ?>" />
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>