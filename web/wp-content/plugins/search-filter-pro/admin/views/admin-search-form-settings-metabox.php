<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div id="settings-defaults" class="widgets-search-filter-draggables ui-search-filter-sortable setup" data-allow-expand="0">
	<?php
		global $post;
	?>
	<!--<div style="display:none;">
		<input class="checkbox treat_child_posts_as_parent" type="hidden" id="treat_child_posts_as_parent" name="treat_child_posts_as_parent" value="<?php /* echo esc_attr($values['treat_child_posts_as_parent']); */  ?>">
	</div>-->
	<p class="description"><?php _e("Settings &amp; Default Conditions for this Search Form.", $this->plugin_slug ); ?></p>
	
	<div class="tabs-container">
		<div class="tab-header sf_settings_tabs">
			<label for="tab-header-settings" class="active"><input data-radio-checked="1" class="meta_type_radio" id="tab-header-settings" name="tab-header" type="radio" value="settings"><?php _e("General", $this->plugin_slug ); ?></label> 
			<label for="tab-header-template"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-template" name="tab-header" type="radio" value="template"><?php _e("Display Results", $this->plugin_slug ); ?></label> 
			<label for="tab-header-post-data"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-post-data" name="tab-header" type="radio" value="post_data"><?php _e("Posts", $this->plugin_slug ); ?></label>
			<label for="tab-header-taxonomies"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-taxonomies" name="tab-header" type="radio" value="taxonomies"><?php _e("Tags, Categories &amp; Taxonomies", $this->plugin_slug ); ?></label>
			<label for="tab-header-post-meta"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-post-meta" name="tab-header" type="radio" value="post_meta"><?php _e("Post Meta", $this->plugin_slug ); ?></label>
			<label for="tab-header-advanced"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-advanced" name="tab-header" type="radio" value="advanced"><?php _e("Advanced", $this->plugin_slug ); ?></label>
			<!--<label for="tab-header-post-author"><input data-radio-checked="0" class="meta_type_radio" id="tab-header-post-author" name="tab-header" type="radio" value="author">Author</label>-->
			
		</div>
		<br class="clear" />
		<div class="sf_field_data sf_tab_content_settings" style="display: block;">
			
			<!-- Post Types -->
			<table>
				<!--<tr>
					<td colspan="2">
						<strong><?php _e("Post Types", $this->plugin_slug ); ?></strong>
					</td>
				</tr>-->
				<tr>
					<td width="275">
						<p><strong><?php _e("Search in the following post types:", $this->plugin_slug ); ?></strong></p>
					</td>
					<td>
						<div class="sf_post_types"><p>
						<?php
							$args = array(
							   //'public'   => true,
							   //'publicly_queryable '   => true
							);
							
							$post_types = get_post_types( $args, 'objects' ); 
							
							$is_default = false;
							if(isset($values['post_types']))
							{
								if(!is_array($values['post_types']))
								{
									$is_default = true;
									$values['post_types'] = array();
								}
							}
							else
							{
								$is_default = true;
								$values['post_types'] = array();
							}
							
							$exclude_post_types = array("search-filter-widget","revision","nav_menu_item","shop_webhook");
							
							foreach ( $post_types as $post_type )
							{
								
								if(!in_array($post_type->name, $exclude_post_types))
								{
									if($is_default)
									{
										if(($post_type->name=="post")||($post_type->name=="page"))
										{
											$values['post_types'][$post_type->name] = "1";
										}
										else
										{
											$values['post_types'][$post_type->name] = "";
										}
									}
									else if(!isset($values['post_types'][$post_type->name]))
									{
										$values['post_types'][$post_type->name] = "";
									}
									
									?>
									<span>
									<label for="{0}[{1}][post_types][<?php echo $post_type->name; ?>]">
									<input class="checkbox" type="checkbox" id="{0}[{1}][post_types][<?php echo $post_type->name; ?>]" value="<?php echo $post_type->name; ?>" name="settings_post_types[<?php echo $post_type->name; ?>]"<?php $this->set_checked($values['post_types'][$post_type->name]); ?>>
									<?php _e($post_type->labels->name, $this->plugin_slug); ?></label>
									</span>
									<?php
								}
							}
						?>
						</p></div>
					</td>
				</tr>
				
				<tr>
					<td>
						<label for="posts_per_page"><?php _e("Results per page:", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<input class="" id="posts_per_page" name="posts_per_page" type="text" size="7" value="<?php echo esc_attr($values['results_per_page']); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="auto_submit"><?php _e("Auto submit form?", $this->plugin_slug ); ?><span class="hint--top hint--info" data-hint="<?php _e("Update the results whenever a user changes a value - no need for a submit button", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</td>
					<td>
						<input class="checkbox auto_submit" type="checkbox" id="auto_submit" name="auto_submit"<?php $this->set_checked($values['auto_submit']); ?>> 
					</td>
				</tr>
				<!--<tr>
					<td>
						<label for="maintain_state"><?php _e("Maintain Search Form State", $this->plugin_slug ); ?>
							<span class="hint--top hint--info" data-hint="<?php _e("Prevents the Search Form from resetting when clicking through on to individual search results (modifies permalinks).", $this->plugin_slug ); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</td>
					<td>
						<input class="checkbox maintain_state" type="checkbox" id="maintain_state" name="maintain_state"<?php $this->set_checked($values['maintain_state']); ?>> 
					</td>
				</tr>-->
				
				
				<tr>
					<td valign="middle">
						<label for="field_relation"><?php _e("Field relationships:", $this->plugin_slug ); ?><span class="hint--top hint--info" data-hint="<?php _e("AND - posts shown will match all fields, OR - posts shown will match any of the fields", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</td>
					<td>
						<select name="field_relation" id="field_relation">
							<option value="and"<?php $this->set_selected($values['field_relation'], "and"); ?>><?php _e("AND", $this->plugin_slug); ?></option>
							<option value="or"<?php $this->set_selected($values['field_relation'], "or"); ?>><?php _e("OR", $this->plugin_slug); ?></option>
						</select>
						<p class="description"><?php _e("The relationship between tag, category, taxonomy & post meta (choice) fields", $this->plugin_slug ); ?></p>
					</td>
				</tr>
				
				<tr>
					<td valign="middle">
						<label for="enable_auto_count"><?php _e("Enable Auto Count:", $this->plugin_slug ); ?><span class="hint--top hint--info" data-hint="<?php _e("Dynamic counts of results in form fields - eg - Plugins (12)", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</td>
					<td>
						<p class="description" style="font-style:normal;">
							<label>
								<input class="checkbox enable_auto_count" type="checkbox" id="enable_auto_count" name="enable_auto_count"<?php $this->set_checked($values['enable_auto_count']); ?>>
								<?php _e("Enable", $this->plugin_slug); ?>
							</label>
						</p>
						<p class="description"><?php _e("Dynamically update the count number shown and also calculate which options to hide in your tag, category, taxonomy & post meta (choice) fields.", $this->plugin_slug); ?></p>
						
						<p class="description" style="font-style:normal;">
							<label>
								<input class="checkbox auto_count_refresh_mode" type="checkbox" id="auto_count_refresh_mode" name="auto_count_refresh_mode"<?php $this->set_checked($values['auto_count_refresh_mode']); ?><?php if($values['enable_auto_count']!=1){ echo ' disabled="disabled"'; } ?>> 
								<?php _e("Update the Search Form on user interaction", $this->plugin_slug); ?>
							</label>
						</p>
						<p class="description"><?php _e("If disabled, the count numbers will only update when new results are loaded (ie, when the Search form is submitted)", $this->plugin_slug); ?></p>
						
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<p style="margin-bottom:0;"><strong><?php _e("Detect defaults from current page", $this->plugin_slug ); ?></strong></p>
						<p class="description"><?php _e("When a Search Form is used on any page other than the Search Results Page, S&amp;F will try to detect the post type and associated taxonomies of the current page - and set defaults in the Search Form to match these.", $this->plugin_slug ); ?></p>
						
					</td>
				</tr>

				<tr>
					<td valign="middle">
						<?php _e("Choose which kinds of pages S&amp;F will try to do this on:", $this->plugin_slug ); ?><!--<span class="hint--top hint--info" data-hint="<?php /* _e("AND - posts shown will match all fields, OR - posts shown will match any of the fields", $this->plugin_slug);*/ ?>"><i class="dashicons dashicons-info"></i></span>-->
					</td>
					<td>
						<input class="checkbox inherit_current_post_type_archive" type="checkbox" id="inherit_current_post_type_archive" name="inherit_current_post_type_archive"<?php $this->set_checked($values['inherit_current_post_type_archive']); ?>><label for="inherit_current_post_type_archive"><?php _e(" Post Type Archives <!--(is_post_type_archive)-->", $this->plugin_slug ); ?></label><br />
						<input class="checkbox inherit_current_taxonomy_archive" type="checkbox" id="inherit_current_taxonomy_archive" name="inherit_current_taxonomy_archive"<?php $this->set_checked($values['inherit_current_taxonomy_archive']); ?>><label for="inherit_current_taxonomy_archive"><?php _e(" Tag, Category &amp; Taxonomy Archives <!--(is_tag, is_category, is_tax)-->", $this->plugin_slug ); ?></label><br />
						<!--<input class="checkbox inherit_current_single_post" type="checkbox" id="" name="inherit_current_single_post"<?php $this->set_checked($values['inherit_current_single_post']); ?>> Individual Posts &amp; Custom Post Types (is_single)<br />-->
						<input class="checkbox inherit_current_author_archive" type="checkbox" id="inherit_current_author_archive" name="inherit_current_author_archive"<?php $this->set_checked($values['inherit_current_author_archive']); ?>><label for="inherit_current_author_archive"><?php _e(" Author Archives<!-- (is_author)-->", $this->plugin_slug ); ?></label><br />
						<!--<input class="checkbox inherit_current_date_archive" type="checkbox" id="" name="inherit_current_date_archive"<?php $this->set_checked($values['inherit_current_date_archive']); ?>> Date Archives<br />-->
						
						
						
						<!--<input class="checkbox maintain_state" type="checkbox" id="maintain_state" name="maintain_state"<?php $this->set_checked($values['maintain_state']); ?>> Post Type Archives (is_post_type_archive)<br />
						<input class="checkbox maintain_state" type="checkbox" id="maintain_state" name="maintain_state"<?php $this->set_checked($values['maintain_state']); ?>> Tag Archives (is_tag)<br />
						<input class="checkbox maintain_state" type="checkbox" id="maintain_state" name="maintain_state"<?php $this->set_checked($values['maintain_state']); ?>> Category Archives (is_cat)<br />
						<input class="checkbox maintain_state" type="checkbox" id="maintain_state" name="maintain_state"<?php $this->set_checked($values['maintain_state']); ?>> Taxonomy Archives (is_tax)<br />-->
					</td>
				</tr>
			
			</table>
		
		</div>


        <?php

        $display_results_methods = array();

        $display_results_methods['archive'] = array(
            'label'         => __('As an Archive'),
            'description'   =>
                '<p>'.__("Use a regular template from your theme to output your results.", $this->plugin_slug ).'</p>'.
                '<p><em>'.__("* Templates must use the <a href='http://codex.wordpress.org/The_Loop' target='_blank'>The Loop</a> and not a custom query", $this->plugin_slug ).'</em></p>'.
                '<p><a href="https://searchandfilter.com/documentation/search-results/as-an-archive/" target="_blank">'.__("View the Archive setup instructions", $this->plugin_slug ).'</a></p>',
            'base'          => 'archive'
        );

        $display_results_methods['post_type_archive'] = array(
            'label'         => __('Post Type Archive'),
            'description'   =>
                '<p>'.__("Filter results on your Post Type Archives - only one post type must be selected.", $this->plugin_slug ).'</p>'.
                '<p><em>'.__("* Templates must use the <a href='http://codex.wordpress.org/The_Loop' target='_blank'>The Loop</a> and not a custom query", $this->plugin_slug ).'</em></p>'.
                '<p><a href="https://searchandfilter.com/documentation/search-results/as-a-post-type-archive/" target="_blank">'.__("View the Post Type Archive setup instructions", $this->plugin_slug ).'</a></p>',
            'base'          => 'post_type_archive'
        );
        $display_results_methods['shortcode'] = array(
            'label'         => __('Using a Shortcode'),
            'description'   =>
                '<p>'.__("Place a results shortcode in any post or theme file to position where the results are displayed.", $this->plugin_slug ).'</p>'.
                '<p><em>'.__("* You can find your results shortcode in the <strong>Shortcodes</strong> box on this page", $this->plugin_slug ).'</em></p>'.
                '<p><a href="https://searchandfilter.com/documentation/search-results/using-a-shortcode/" target="_blank">'.__("View the Shortcode setup instructions", $this->plugin_slug ).'</a></p>',

            'base'          => 'shortcode'
        );

        if(Search_Filter_Helper::has_woocommerce()) {
	        $display_results_methods['custom_woocommerce_store'] = array(
		        'label'       => __( 'WooCommerce - Shop' ),
		        'description' =>
			        '<p>' . __( "Let WooCommerce handle the display of results and direct all searches to the shop page.", $this->plugin_slug ) . '</p>' .
			        '<p><a href="https://searchandfilter.com/documentation/3rd-party/woocommerce/" target="_blank">' . __( "View the WooCommerce setup instructions", $this->plugin_slug ) . '</a></p>',
		        'base'        => 'custom_woocommerce_store'
	        );
        }
        /*$display_results_methods['custom_woocommerce_products_shortcode'] = array(
            'label'         => __('WooCommerce - Products Shortcode'),
            'description'   =>
                '<p>'.__("Use a WooCommerce Products Shortcode to display results - <code>[products]</code>", $this->plugin_slug ).'</p>'.
                '<p>'.__("Search & Filter will override any query settings you may have passed to the shortcode.", $this->plugin_slug ).'</p>'.
				'<p><a href="https://searchandfilter.com/documentation/3rd-party/woocommerce/" target="_blank">'.__("View the WooCommerce setup instructions", $this->plugin_slug ).'</a></p>',
            'base'          => 'custom_woocommerce_store'
        );*/
        $display_results_methods['custom_edd_store'] = array(
            'label'         => __('EDD - Downloads Page'),
            'description'   =>
                '<p>'.__("Let Easy Digital Downloads handle the display of results - simply supply the full URL of a page containing your downloads shortcode.", $this->plugin_slug ).'</p>'.
                '<p><a href="https://searchandfilter.com/documentation/3rd-party/easy-digital-downloads/" target="_blank">'.__("View the Easy Digital Downloads setup instructions", $this->plugin_slug ).'</a></p>',

            'base'          => 'shortcode'
        );
        $display_results_methods['custom'] = array(
            'label'         => __('Custom'),
            'description'   => '<p>'.__("Manually add S&F to an existing query and then simply supply the URL where this can be located.", $this->plugin_slug ).'</p>'.
				'<p><a href="https://searchandfilter.com/documentation/search-results/custom/" target="_blank">'.__("View the Custom setup instructions", $this->plugin_slug ).'</a></p>',
            'base'          => 'custom'
        );

        if(has_filter("search_filter_admin_option_display_results"))
        {
            $display_results_methods = apply_filters('search_filter_admin_option_display_results', $display_results_methods);
        }

        ?>


		<div class="sf_field_data sf_tab_content_template">
			<table class="template_results_table">
				<tr>
					<td colspan="2">
						<p>
							<strong><?php _e("Display results method:", $this->plugin_slug); ?></strong>
						</p>
						<p>
							<select name="display_results_as" class="display_results_as" id="display_results_as">
                                <?php

                                foreach($display_results_methods as $display_slug => $display_result_method)
                                {
                                    echo '<option value="'.esc_attr($display_slug).'"'.$this->set_selected($values['display_results_as'], $display_slug, false).' data-sf-base="'.$display_result_method['base'].'">'.$display_result_method['label'].'</option>';
                                }

                                ?>
							</select>
						</p>
						
						<div class="display_result_txt_cont notice-alert">

                            <?php
                            foreach($display_results_methods as $display_slug => $display_result_method) {

                                if($display_result_method['description']!="") {
                                    ?>
                                    <div class="display_result_txt" id="display_result_<?php echo $display_slug; ?>_txt">
                                        <?php echo $display_result_method['description']; ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
						</div>
					</td>
					
				</tr>
				
				
			</table>
			
			<hr /><br />
			<div class="template_options_sect">
				<table class="template_options_table">
					<tr>
						<td colspan="2">
							<strong><?php _e("Template Options", $this->plugin_slug ); ?></strong>
						</td>
					</tr>
					<tr class="tpl_shortcode_rows">
						<td colspan="2" style="width:auto;">
						<div>
							<label for="results_url">
								<?php _e("Results URL:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("The full URL of a page where your results shortcode can be found", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
							</label><br /><small><?php _e("This should be the Full URL to a page/post where your results can be found - must contain the shortcode", $this->plugin_slug); ?></small>
							<p><input class="results_url" id="results_url" name="results_url" type="text" value="<?php echo esc_attr($values['results_url']); ?>" placeholder="<?php echo home_url(); ?>..." size="80" style="width:100%; max-width:100%">
							<input type="hidden"  name="results_url" id="results_url_hidden" class="results_url_hidden"  value="<?php echo $values['results_url']; ?>" disabled="disabled" />
							</p>
							
						</div>
						</td>
					</tr>
					<tr class="tpl_archive_rows">
						<td>
							<label for="use_template_manual_toggle">
								<?php _e("Use a custom template for results?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("if this is not set you may not have control on how your results page displays", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
								
							</label>
						</td>
						<td>
							<input class="checkbox use_template_manual_toggle" type="checkbox" id="use_template_manual_toggle" name="use_template_manual_toggle"<?php $this->set_checked($values['use_template_manual_toggle']); ?>> 
							<input type="hidden"  name="use_template_manual_toggle" class="use_template_manual_toggle_hidden" id="use_template_manual_toggle_hidden"  value="<?php echo $values['use_template_manual_toggle']; ?>" disabled="disabled" />
							<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
						</td>
					</tr>
					<tr class="tpl_post_type_archive_rows tpl_custom_woocommerce_rows">
						<td>
							<label for="enable_taxonomy_archives">
								<?php _e("Enable filtering on Taxonomy Archives?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("enabling this will allow S&F to filter your taxonomy archives as well as post type archives", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
							</label>
						</td>
						<td>
							<input class="checkbox enable_taxonomy_archives" type="checkbox" id="enable_taxonomy_archives" name="enable_taxonomy_archives"<?php $this->set_checked($values['enable_taxonomy_archives']); ?>>
							<input type="hidden"  name="enable_taxonomy_archives" class="enable_taxonomy_archives" id="enable_taxonomy_archives"  value="<?php echo $values['enable_taxonomy_archives']; ?>" disabled="disabled" />
							<small class="taxonomy_archive_woocommerce_label"><?php _e("In WooCommerce this will mean the search form also works with your Product Tag and Product Category Archives.", $this->plugin_slug); ?></small>
						</td>
					</tr>
					
					<tr class="tpl_archive_rows">
						<td>
							<label for="template_name_manual">
								<?php _e("Enter the filename of the custom template:", $this->plugin_slug); ?>
							</label>
						</td>
						<td>
							<input class="template_name_manual" id="template_name_manual" name="template_name_manual" type="text" value="<?php echo esc_attr($values['template_name_manual']); ?>" />
							<input type="hidden"  name="template_name_manual" class="template_name_manual_hidden" id="template_name_manual_hidden"  value="<?php echo $values['template_name_manual']; ?>" disabled="disabled" />
							 <br /><small><?php _e("The template will be loaded from your theme directory.", $this->plugin_slug); ?></small>
							<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
						</td>
					</tr>
					
					<tr class="tpl_archive_rows">
						<td>
							<label for="page_slug">
								<?php _e("Set a slug?", $this->plugin_slug); ?>
							</label>
						</td>
						<td>
							<?php
								$home_url = home_url();
								$query_args = "";

								if (strpos($home_url, '?') !== false) {
									$url_parts = explode("?", $home_url);
									$home_url = trailingslashit($url_parts[0]);
									$query_args = "/?".$url_parts[1];

								}
								else
								{
									$home_url = trailingslashit(home_url());
								}
							?>
							<?php echo $home_url; ?> <input class="page_slug" id="page_slug" name="page_slug" type="text" value="<?php echo esc_attr($values['page_slug']); ?>" placeholder="?sfid=<?php echo $post->ID; ?>"  />
							<input type="hidden"  name="page_slug" id="page_slug_hidden" class="page_slug_hidden"  value="<?php echo $values['page_slug']; ?>" disabled="disabled" /> <?php echo $query_args; ?>
						</td>
					</tr>
				</table>
				<hr />
				<br />
			</div>
			<table class="template_ajax_table">
				
				<tr>
					<td colspan="2">
						<strong><?php _e("Ajax", $this->plugin_slug ); ?></strong>
					</td>
					
				</tr>
				
				<tr>
					<td>
						<label for="use_ajax_toggle"><?php _e("Load results using Ajax?", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<input class="checkbox use_ajax_toggle" type="checkbox" id="use_ajax_toggle" name="use_ajax_toggle"<?php $this->set_checked($values['use_ajax_toggle']); ?>> 
					</td>
				</tr>
				
				
				<tr class="tpl_use_ajax_rows">
					<td>
						<label for="update_ajax_url">
							<?php _e("Make searches bookmarkable?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("If using results shortcode then &quot;Results URL&quot; must be valid to enable this", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						</label>
					</td>
					<td>
						<input class="checkbox update_ajax_url" type="checkbox" id="update_ajax_url" name="update_ajax_url"<?php $this->set_checked($values['update_ajax_url']); ?>>
						 <small><?php _e("Changes the URL in the address bar as the user searches.", $this->plugin_slug); ?></small>
					</td>
				</tr>
				<!--<tr class="tpl_use_ajax_rows tpl_archive_rows">-->
				<tr class="tpl_use_ajax_rows">
					<td>
						<label for="only_results_ajax">
							<?php _e("Only use Ajax on the results page?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Initially redirect users to your results page", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</td>
					<td>
						<input class="checkbox only_results_ajax" type="checkbox" id="only_results_ajax" name="only_results_ajax"<?php $this->set_checked($values['only_results_ajax']); ?>> 
						 <small><?php _e("If the user is not on the results page already, the first submit of the Search Form will cause a page redirect.", $this->plugin_slug); ?></small><br /><br />
					</td>
				</tr>
				
				<tr class="tpl_use_ajax_rows scroll_to_row">
					<td>
						<label for="scroll_to_pos">
							<?php _e("Scroll window to:", $this->plugin_slug ); ?>
							<span class="hint--top hint--info" data-hint="<?php _e("Automatically scroll the page when new results are loading", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</td>
					<td>
						<span>
							<select name="scroll_to_pos" class="scroll_to_pos" id="scroll_to_pos">
								<option value="0"><?php _e("None", $this->plugin_slug); ?></option>
								<option value="window"<?php $this->set_selected($values['scroll_to_pos'], "window"); ?>><?php _e("Top of Page (Window)", $this->plugin_slug); ?></option>
								<option value="form"<?php $this->set_selected($values['scroll_to_pos'], "form"); ?>><?php _e("Search Form", $this->plugin_slug); ?></option>
								<option value="results"<?php $this->set_selected($values['scroll_to_pos'], "results"); ?>><?php _e("Results Container", $this->plugin_slug); ?></option>
								<option value="custom"<?php $this->set_selected($values['scroll_to_pos'], "custom"); ?>><?php _e("Custom Selector:", $this->plugin_slug); ?></option>
							</select>
							<div class="custom_scroll_to">
								<input type="text" id="" name="custom_scroll_to" class="" value="<?php echo esc_attr($values['custom_scroll_to']); ?>" size="14" placeholder="<?php _e("#id or .class", $this->plugin_slug); ?>" />
							</div>
						</span>
						
						<span class="scroll_on_action">
							<?php _e("on", $this->plugin_slug); ?>
							
							<select name="scroll_on_action" class="scroll_on_action" id="scroll_on_action">
								<option value="all"<?php $this->set_selected($values['scroll_on_action'], "all"); ?>><?php _e("All", $this->plugin_slug); ?></option>
								<option value="submit"<?php $this->set_selected($values['scroll_on_action'], "submit"); ?>><?php _e("Submit", $this->plugin_slug); ?></option>
								<option value="pagination"<?php $this->set_selected($values['scroll_on_action'], "pagination"); ?>><?php _e("Pagination", $this->plugin_slug); ?></option>
							</select>
						</span>
					</td>
				</tr>
				
				<tr class="tpl_archive_rows tpl_use_ajax_rows tpl_custom_rows tpl_post_type_archive_rows tpl_woocommerce_rows template_ajax_container">
					<td>
						<label for="ajax_target">
							<?php _e("Ajax Container:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("The ID or class of the container which your results are loaded in to", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</td>
					<td>
						<input class="ajax_target" id="ajax_target" name="ajax_target" type="text" value="<?php echo esc_attr($values['ajax_target']); ?>" placeholder="<?php _e("#id or .class", $this->plugin_slug); ?>">
						<!-- <br /><em><?php _e("This should be an ID, ie - <code>#content</code> - or a unique class selector, ie - <code>.content-container</code>.", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
		</table>
		
		<hr />
		<br />
		<table class="template_pagination_table" data-sf-pagination-type="<?php echo $values['pagination_type']; ?>">
				<tr>
					<td colspan="2">
						<strong><?php _e("Ajax Pagination", $this->plugin_slug ); ?></strong>
					</td>
					
				</tr>
				
				<tr class="tpl_use_ajax_rows">
					<td>
						<label for="pagination_type"><?php _e("Pagination Type", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<select name="pagination_type" class="pagination_type" id="pagination_type">
							<option value="normal"<?php $this->set_selected($values['pagination_type'], "normal"); ?>><?php _e("Normal", $this->plugin_slug); ?></option>
							<option value="infinite_scroll"<?php $this->set_selected($values['pagination_type'], "infinite_scroll"); ?>><?php _e("Infinite Scroll", $this->plugin_slug); ?></option>
						</select>
						
						<!--<input class="checkbox use_infinite_scroll" type="checkbox" id="use_infinite_scroll" name="use_infinite_scroll"<?php /* $this->set_checked($values['use_infinite_scroll']); */ ?>> -->
					</td>
				</tr>
				
				<tr class="tpl_use_ajax_rows tpl_pagination_normal_rows template_pagination_selector">
					<td>
						<label for="ajax_links_selector">
							<?php _e("Pagination selector:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("to enable Ajax on your pagination links you must put the CSS selector here", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							
						</label>
					</td>
					<td>
						<input class="ajax_links_selector" id="ajax_links_selector" name="ajax_links_selector" type="text" value="<?php echo esc_attr($values['ajax_links_selector']); ?>" placeholder="<?php _e("#id or .class", $this->plugin_slug); ?>">
						<!-- <br /><em><?php _e("This must be a selector targeting all pagination links on your page - ie, <code>.nav-links a</code>", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				
				
				<tr class="tpl_use_ajax_rows tpl_pagination_scroll_rows">
					<td colspan="2">
						<div class="display_result_txt_cont notice-alert">
								<div>
									<p>
										<?php _e("Setting up Infinite Scroll will require some knowledge of html/css - <a href=\"https://searchandfilter.com/documentation/search-results/infinite-scroll/\" target=\"_blank\">read the guide here</a>.", $this->plugin_slug ); ?>
									</p>
								</div>
						</div>
					</td>
				</tr>
				
				<tr class="tpl_use_ajax_rows tpl_pagination_scroll_rows">
					<td>
						<label for="show_infinite_scroll_loader">
							<?php _e("Show loading icon?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Disable this if you wish to add your own", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
					</td>
					<td>
						<input class="checkbox show_infinite_scroll_loader" type="checkbox" id="show_infinite_scroll_loader" name="show_infinite_scroll_loader"<?php $this->set_checked($values['show_infinite_scroll_loader']); ?>> 
					</td>
				</tr>
				
				<!--<tr class="tpl_use_ajax_rows tpl_pagination_scroll_rows">
					<td>
						<label for="infinite_scroll_container">
							<?php _e("Infinite Scroll jQuery Selector Type:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("The ID or class of the container which your results are loaded in to", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<small><?php _e("Choose another selector type to better control the behaviour of infinite scroll.", $this->plugin_slug); ?></small>
							<br />
						</label>
					</td>
					<td>
						<select name="infinite_scroll_additional_selector_type" class="infinite_scroll_additional_selector_type" id="pagination_type">
							<option value=""<?php /*$this->set_selected($values['infinite_scroll_additional_selector_type'], "");*/ ?>><?php _e("None", $this->plugin_slug); ?></option>
							<option value="posts_container"<?php /*$this->set_selected($values['infinite_scroll_additional_selector_type'], "posts_container");*/ ?>><?php _e("Posts Container", $this->plugin_slug); ?></option>
							<option value="post_class"<?php /*$this->set_selected($values['infinite_scroll_additional_selector_type'], "post_class");*/ ?>><?php _e("Post Class", $this->plugin_slug); ?></option>
						</select>
					</td>
				</tr>-->
				
				<tr class="tpl_use_ajax_rows tpl_pagination_scroll_rows">
					<td>
						<label for="infinite_scroll_result_class">
							<?php _e("Post / Result Selector:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("tag or class to select the actual posts/results themselves", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<em><?php _e("(optional)", $this->plugin_slug); ?></em>
						</label>
					</td>
					<td>
						<input class="infinite_scroll_result_class" id="infinite_scroll_result_class" name="infinite_scroll_result_class" type="text" value="<?php echo esc_attr($values['infinite_scroll_result_class']); ?>" placeholder="<?php _e("html tag or .class", $this->plugin_slug); ?>">
						<br /><small><?php _e("Rather than adding all the html content from a container, you can specify a css selector to target only elements that are results - eg - `article` or `div.post`", $this->plugin_slug); ?></small>
						<!-- <br /><em><?php _e("This should be an ID, ie - <code>#content</code> - or a unique class selector, ie - <code>.content-container</code>.", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				<tr class="tpl_use_ajax_rows tpl_pagination_scroll_rows">
					<td>
						<label for="infinite_scroll_container">
							<?php _e("Infinite Scroll Container:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("This should be a container which contains only the results themselves (the repeatable content for each result listing)", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<em><?php _e("(optional)", $this->plugin_slug); ?></em>
							<!--<small><?php _e("* if using the demo template set this to <strong>.search-filter-results-list<strong>", $this->plugin_slug); ?></small><br />-->
						</label>
					</td>
					<td>
						<input class="infinite_scroll_container" id="infinite_scroll_container" name="infinite_scroll_container" type="text" value="<?php echo esc_attr($values['infinite_scroll_container']); ?>" placeholder="<?php _e("#id or .class", $this->plugin_slug); ?>">
						<br /><small><?php _e("The infinite scroll container should only contain the posts/results themselves, no pagination or other result related data.", $this->plugin_slug); ?></small>
						
						<!-- <br /><em><?php _e("This should be an ID, ie - <code>#content</code> - or a unique class selector, ie - <code>.content-container</code>.", $this->plugin_slug); ?></em> -->
					</td>
				</tr>
				<tr class="tpl_use_ajax_rows tpl_pagination_scroll_rows">
					<td>
						<label for="infinite_scroll_trigger">
							<?php _e("Infinite Scroll Trigger:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("This should be a container which contains only the results themselves (the repeatable content for each result listing)", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<!--<small><?php _e("* if using the demo template set this to <strong>.search-filter-results-list<strong>", $this->plugin_slug); ?></small><br />-->
						</label>
					</td>
					<td>
						<input class="infinite_scroll_trigger" id="infinite_scroll_trigger" name="infinite_scroll_trigger" type="text" value="<?php echo esc_attr($values['infinite_scroll_trigger']); ?>" placeholder="<?php _e("", $this->plugin_slug); ?>"> px
						<br /><small><?php _e("When loading more results, S&F uses the bottom of Ajax Container (or Infinite Scroll container) to determine when the user has reached the bottom of the results.<br />Choose an offset in pixels from this point to activate infinite scroll.", $this->plugin_slug); ?></small>

						<!-- <br /><em><?php _e("This should be an ID, ie - <code>#content</code> - or a unique class selector, ie - <code>.content-container</code>.", $this->plugin_slug); ?></em> -->
					</td>
				</tr>

				
				
			</table>
		</div>
		<div class="sf_field_data sf_tab_content_post_data">
			<table>
			<tr>
				<td>
					<?php _e("Post Status:", $this->plugin_slug ); ?>
				</td>
				<td>
					<div class="sf_post_types">
						<?php
							
							foreach ($post_stati as $post_status)
							{
								?>
								<label for="{0}[{1}][post_status][<?php echo $post_status->name; ?>]">
									<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][<?php echo $post_status->name; ?>]" value="publish" name="settings_post_status[<?php echo $post_status->name; ?>]"<?php $this->set_checked($values['post_status'][$post_status->name]); ?>>
									<?php echo $post_status->label; ?>
								</label>
								
								<?php
							}
							/*echo "<hr />";
							foreach ($post_stati_private as $post_status)
							{
								?>
								<label for="{0}[{1}][post_status][<?php echo $post_status->name; ?>]">
									<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][<?php echo $post_status->name; ?>]" value="publish" name="settings_post_status[<?php echo $post_status->name; ?>]"<?php $this->set_checked($values['post_status'][$post_status->name]); ?>>
									<?php echo $post_status->label; ?>
								</label>
								
								<?php
							}*/
						
						?>
					
						<!--<label for="{0}[{1}][post_status][publish]">
							<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][publish]" value="publish" name="settings_post_status[publish]"<?php $this->set_checked($values['post_status']['publish']); ?>>
							<?php _e('Published', $this->plugin_slug); ?>
						</label>
						
						<label for="{0}[{1}][post_status][pending]">
							<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][pending]" value="pending" name="settings_post_status[pending]"<?php $this->set_checked($values['post_status']['pending']); ?>>
							<?php _e('Pending', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("post is pending review", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
						
						<label for="{0}[{1}][post_status][draft]">
							<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][draft]" value="draft" name="settings_post_status[draft]"<?php $this->set_checked($values['post_status']['draft']); ?>>						
							<?php _e('Draft', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("a post in draft status", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
						
						<label for="{0}[{1}][post_status][future]">
							<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][future]" value="future" name="settings_post_status[future]"<?php $this->set_checked($values['post_status']['future']); ?>>
							<?php _e('Future', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("a post to publish in the future", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>
						
						<label for="{0}[{1}][post_status][private]">
							<input class="checkbox" type="checkbox" id="{0}[{1}][post_status][private]" value="private" name="settings_post_status[private]"<?php $this->set_checked($values['post_status']['private']); ?>>
							<?php _e('Private', $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("not visible to users who are not logged in", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
						</label>-->
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<label for="exclude_post_ids">
					<?php _e("Exclude Post IDs:", $this->plugin_slug ); ?><span class="hint--top hint--info" data-hint="<?php _e("comma seperated list of post IDs to exclude - these can be of any post type", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
					</label>
				</td>
				<td>
					<input class="" id="exclude_post_ids" name="exclude_post_ids" type="text" size="20" value="<?php echo esc_attr($values['exclude_post_ids']); ?>">
				</td>
			</tr><tr>
				<td>
					<label for="sticky_posts">
					<?php _e("Sticky Posts:", $this->plugin_slug ); ?>
					</label>
				</td>
				<td>
					<fieldset class="sitem">
						
						<select name="sticky_posts" class="sticky_posts" id="sticky_posts">
							<option value=""><?php _e("Default", $this->plugin_slug); ?></option>
							<option value="exclude"<?php $this->set_selected($values['sticky_posts'], "exclude"); ?>><?php _e("Exclude", $this->plugin_slug); ?></option>
							<option value="ignore"<?php $this->set_selected($values['sticky_posts'], "ignore"); ?>><?php _e("Ignore", $this->plugin_slug); ?></option>
							
						</select>
						
					</fieldset>
				</td>
			</tr>
			<tr>
				<td>
					<label for="default_sort_by">
					<?php _e("Default Order:", $this->plugin_slug ); ?>
					</label>
				</td>
				<td>
					<fieldset class="sitem">
						
						<select name="default_sort_by" class="default_sort_by" id="default_sort_by">
							<option value="0"><?php _e("Choose an option", $this->plugin_slug); ?></option>
							<option value="ID"<?php $this->set_selected($values['default_sort_by'], "ID"); ?>><?php _e("Post ID", $this->plugin_slug); ?></option>
							<option value="author"<?php $this->set_selected($values['default_sort_by'], "author"); ?>><?php _e("Author", $this->plugin_slug); ?></option>
							<option value="title"<?php $this->set_selected($values['default_sort_by'], "title"); ?>><?php _e("Title", $this->plugin_slug); ?></option>
							<option value="name"<?php $this->set_selected($values['default_sort_by'], "name"); ?>><?php _e("Name (Post Slug)", $this->plugin_slug); ?></option>
							<option value="type"<?php $this->set_selected($values['default_sort_by'], "type"); ?>><?php _e("Type (Post Type)", $this->plugin_slug); ?></option>
							<option value="date"<?php $this->set_selected($values['default_sort_by'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
							<option value="modified"<?php $this->set_selected($values['default_sort_by'], "modified"); ?>><?php _e("Last Modified Date", $this->plugin_slug); ?></option>
							<option value="parent"<?php $this->set_selected($values['default_sort_by'], "parent"); ?>><?php _e("Parent ID", $this->plugin_slug); ?></option>
							<option value="rand"<?php $this->set_selected($values['default_sort_by'], "rand"); ?>><?php _e("Random Order", $this->plugin_slug); ?></option>
							<option value="comment_count"<?php $this->set_selected($values['default_sort_by'], "comment_count"); ?>><?php _e("Comment Count", $this->plugin_slug); ?></option>
							<option value="relevance"<?php $this->set_selected($values['default_sort_by'], "relevance"); ?>><?php _e("Relevance", $this->plugin_slug); ?></option>
							<option value="menu_order"<?php $this->set_selected($values['default_sort_by'], "menu_order"); ?>><?php _e("Menu Order", $this->plugin_slug); ?></option>
							<option value="meta_value"<?php $this->set_selected($values['default_sort_by'], "meta_value"); ?>><?php _e("Meta Value", $this->plugin_slug); ?></option>
						</select>
					
						<select name="default_sort_dir" class="meta_key" id="default_sort_dir">
							<option value="desc"<?php $this->set_selected($values['default_sort_dir'], "desc"); ?>><?php _e("Descending", $this->plugin_slug); ?></option>
							<option value="asc"<?php $this->set_selected($values['default_sort_dir'], "asc"); ?>><?php _e("Ascending", $this->plugin_slug); ?></option>
						</select>
						
					</fieldset>
				</td>
			</tr>
			<tr class="sort_by_meta_container_default">
				<td>
					<label for="default_meta_key">
					<?php  _e("Choose Meta Key:", $this->plugin_slug );  ?>
					</label>
				</td>
				<td>
					<fieldset>
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="default_meta_key" class="meta_key" id="default_meta_key">';
							foreach($all_meta_keys as $v)
							{						
								echo '<option value="'.$v.'"'.$this->set_selected($values['default_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select> ';
							
						?> 
					
						<select name='default_sort_type' data-field-template-id='default_sort_type'>
							<option value="numeric"<?php $this->set_selected($values['default_sort_type'], "numeric"); ?>><?php _e("Numerical", $this->plugin_slug); ?></option>
							<option value="alphabetic"<?php $this->set_selected($values['default_sort_type'], "alphabetic"); ?>><?php _e("Alphabetical", $this->plugin_slug); ?></option>
                            <option value="date"<?php $this->set_selected($values['default_sort_type'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
                            <option value="datetime"<?php $this->set_selected($values['default_sort_type'], "datetime"); ?>><?php _e("Datetime", $this->plugin_slug); ?></option>
                            <!--<option value="decimal"<?php $this->set_selected($values['default_sort_type'], "decimal"); ?>><?php _e("Decimal", $this->plugin_slug); ?></option>-->
						</select>
					</fieldset>
				</td>
			</tr>
			
			<tr>
				<td>
					<label for="secondary_sort_by" style="white-space: nowrap;">
					<?php _e("Secondary Sort Order:", $this->plugin_slug ); ?> <span class="hint--top hint--info" data-hint="<?php _e("only works with WordPress 4.2 and up", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
					</label>
				</td>
				<td>
					<fieldset class="sitem">
						
						<select name="secondary_sort_by" class="secondary_sort_by" id="secondary_sort_by">
							<option value="0"><?php _e("None", $this->plugin_slug); ?></option>
							<option value="ID"<?php $this->set_selected($values['secondary_sort_by'], "ID"); ?>><?php _e("Post ID", $this->plugin_slug); ?></option>
							<option value="author"<?php $this->set_selected($values['secondary_sort_by'], "author"); ?>><?php _e("Author", $this->plugin_slug); ?></option>
							<option value="title"<?php $this->set_selected($values['secondary_sort_by'], "title"); ?>><?php _e("Title", $this->plugin_slug); ?></option>
							<option value="name"<?php $this->set_selected($values['secondary_sort_by'], "name"); ?>><?php _e("Name (Post Slug)", $this->plugin_slug); ?></option>
							<option value="type"<?php $this->set_selected($values['secondary_sort_by'], "type"); ?>><?php _e("Type (Post Type)", $this->plugin_slug); ?></option>
							<option value="date"<?php $this->set_selected($values['secondary_sort_by'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
							<option value="modified"<?php $this->set_selected($values['secondary_sort_by'], "modified"); ?>><?php _e("Last Modified Date", $this->plugin_slug); ?></option>
							<option value="parent"<?php $this->set_selected($values['secondary_sort_by'], "parent"); ?>><?php _e("Parent ID", $this->plugin_slug); ?></option>
							<option value="rand"<?php $this->set_selected($values['secondary_sort_by'], "rand"); ?>><?php _e("Random Order", $this->plugin_slug); ?></option>
							<option value="comment_count"<?php $this->set_selected($values['secondary_sort_by'], "comment_count"); ?>><?php _e("Comment Count", $this->plugin_slug); ?></option>
                            <option value="relevance"<?php $this->set_selected($values['secondary_sort_by'], "relevance"); ?>><?php _e("Relevance", $this->plugin_slug); ?></option>
							<option value="menu_order"<?php $this->set_selected($values['secondary_sort_by'], "menu_order"); ?>><?php _e("Menu Order", $this->plugin_slug); ?></option>
							<option value="meta_value"<?php $this->set_selected($values['secondary_sort_by'], "meta_value"); ?>><?php _e("Meta Value", $this->plugin_slug); ?></option>
						</select>
					
						<select name="secondary_sort_dir" class="meta_key" id="secondary_sort_dir">
							<option value="desc"<?php $this->set_selected($values['secondary_sort_dir'], "desc"); ?>><?php _e("Descending", $this->plugin_slug); ?></option>
							<option value="asc"<?php $this->set_selected($values['secondary_sort_dir'], "asc"); ?>><?php _e("Ascending", $this->plugin_slug); ?></option>
						</select>
						
					</fieldset>
				</td>
			</tr>
			<tr class="sort_by_meta_container_secondary">
				<td>
					<label for="secondary_meta_key">
					<?php _e("Choose Meta Key:", $this->plugin_slug ); ?>
					</label>
				</td>
				<td>
					<fieldset>
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="secondary_meta_key" class="meta_key" id="secondary_meta_key">';
							foreach($all_meta_keys as $v)
							{						
								echo '<option value="'.$v.'"'.$this->set_selected($values['secondary_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select> ';
							
						?> 
					
						<select name='secondary_sort_type' data-field-template-id='secondary_sort_type'>
							<option value="numeric"<?php $this->set_selected($values['secondary_sort_type'], "numeric"); ?>><?php _e("Numerical", $this->plugin_slug); ?></option>
							<option value="alphabetic"<?php $this->set_selected($values['secondary_sort_type'], "alphabetic"); ?>><?php _e("Alphabetical", $this->plugin_slug); ?></option>
						</select>
					</fieldset>
				</td>
			</tr>
			</table>
		</div>
		<div class="sf_field_data sf_tab_content_taxonomies">
			
			<p class="description"><?php _e("Include or Exclude results with specific tags, categories and taxonomy terms.", $this->plugin_slug ); ?></p>
			
			<table>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					
					<td>
						<strong><?php _e("Comma Seperated IDs", $this->plugin_slug ); ?></strong>
					</td>
				</tr>
				<?php
					$args = array(
					  //'public'   => true
					);
					
					$output = 'object';
					$taxonomies = get_taxonomies( $args, $output );
					
					if(isset($taxonomies['nav_menu']))
					{
						unset($taxonomies['nav_menu']);
					}
					if(isset($taxonomies['link_category']))
					{
						unset($taxonomies['link_category']);
					}
										
					if(count($taxonomies)>0)
					{
						$i = 0;
						foreach ($taxonomies as $taxonomy)
						{
							echo '<tr>';
							echo "<td>";
							echo '<label for="'.$taxonomy->name.'_include_exclude">';
							echo $taxonomy->label.' <span class="label_taxonomy_name">('.$taxonomy->name.')';
							echo '</label>';
							echo "</td>";
							
							echo "<td>";
							
							
							$tval = "";
							$sval = "";
							if(isset($values['taxonomies_settings'][$taxonomy->name]))
							{
								if(isset($values['taxonomies_settings'][$taxonomy->name]['ids']))
								{
									$tval = $values['taxonomies_settings'][$taxonomy->name]['ids'];
								}
								
								if(isset($values['taxonomies_settings'][$taxonomy->name]['include_exclude']))
								{
									$sval = $values['taxonomies_settings'][$taxonomy->name]['include_exclude'];
								}
							}
							
							echo '<select name="settings_taxonomies['.$taxonomy->name.'][include_exclude]" class="meta_key" id="'.$taxonomy->name.'_include_exclude">';
							echo '<option value="include"'.$this->set_selected($sval, "include", false).'>Include</option>';
							echo '<option value="exclude"'.$this->set_selected($sval, "exclude", false).'>Exclude</option>';
							echo '</select>';
							
							$ids_string = "";
							if($tval!="")
							{
								$ids_array = array_map("intval" , explode(",", $tval));
								
								if(Search_Filter_Helper::has_wpml()) {

									$res = array();
									foreach ($ids_array as $id) {

										$xlat = Search_Filter_Helper::wpml_object_id($id, $taxonomy->name, true);
										if(!is_null($xlat)) $res[] = $xlat;
									}

									$ids_array = $res;

								}
								$ids_string = implode("," , $ids_array);
							}
							
							?>
							</td>
							<td>
							<input class="settings_exclude_ids" id="<?php echo esc_attr($taxonomy->name); ?>_ids" name="settings_taxonomies[<?php echo esc_attr($taxonomy->name); ?>][ids]" type="text" size="20" value="<?php echo esc_attr($ids_string); ?>">
							<a href="#" class="dashicons-search search-tax-button button-secondary sfmodal" data-taxonomy-name="<?php echo esc_attr($taxonomy->name); ?>" data-taxonomy-label="<?php echo esc_attr($taxonomy->label); ?>"></a>
							<?php
							echo "</td>";
							
							echo '</tr>';
							
							$i++;
						}
						
					}
				?>
			</table>
			
			<br class="clear" />
		</div>
		<div class="sf_field_data sf_tab_content_post_meta">
			
			<p class="description"><?php _e("Only return results which match specific post meta data.", $this->plugin_slug ); ?></p>
			
			<p>
				<div class="" style="overflow:auto;margin-bottom:10px;">
					<ul class="meta_list">
						<?php
				
						$i = 0;
						$this->display_settings_meta_option( array(), 'template');
						
						if(isset($values['settings_post_meta']))
						{
							foreach ($values['settings_post_meta'] as $meta_option)
							{
								
								$this->display_settings_meta_option($meta_option);
								$i++;
							}
						}
						
						?>
					</ul>
				</div>
				<a href="#" class="dashicons-plus add-option-button button-secondary"><?php _e("Add Condition", $this->plugin_slug ); ?></a>
					
			</p>
			
		</div>
		<div class="sf_field_data sf_tab_content_advanced">
			
			<table>
				<tr>
					<td colspan="2">
						
						<p><strong><?php _e("Advanced / Miscellaneous Settings", $this->plugin_slug ); ?></strong></p>
					</td>
				</tr>
				<?php
				
					//if ((is_plugin_active('relevanssi/relevanssi.php')) || (is_plugin_active( 'relevanssi-premium/relevanssi.php'))){
					//plugin is activated
					?>
					<tr>
						<td>
							<label for="use_relevanssi"><?php _e("Relevanssi", $this->plugin_slug ); ?></label>
						</td>
						<td>
							<p class="description" style="font-style:normal;">
								<label for="use_relevanssi">
									<input class="checkbox use_relevanssi" type="checkbox" id="use_relevanssi" name="use_relevanssi"<?php $this->set_checked($values['use_relevanssi']); ?>> 
									<?php _e("Enable", $this->plugin_slug ); ?>
								</label>
							</p>
							
						</td>
					</tr>
					<tr>
						<td>
							<label for="use_relevanssi_sort"><?php _e("", $this->plugin_slug ); ?></label>
						</td>
						<td>
							<p class="description" style="font-style:normal;">
								<label for="use_relevanssi_sort">
									<input class="checkbox use_relevanssi_sort" type="checkbox" id="use_relevanssi_sort" name="use_relevanssi_sort"<?php $this->set_checked($values['use_relevanssi_sort']); ?>>
									<?php _e("Sort Results By relevance?", $this->plugin_slug ); ?>
								</label>
							</p>
							<p class="description"><?php _e("When a Search Term has been entered results will be ordered by relevance instead of the default sort order", $this->plugin_slug ); ?></p>
							<!-- <input type="hidden" name="maintain_state" id="auto_submit_hidden" class="auto_submit_hidden" value="1"> -->
						</td>
					</tr>
					<?php
					//}
				?>
				<?php
				
					//if (is_plugin_active('woocommerce/woocommerce.php')){
					//plugin is activated
					/*?>
					<tr>
						<td>
							<label for="is_woocommerce"><?php _e("Use on WooCommerce Store?", $this->plugin_slug ); ?></label>
						</td>
						<td>
							<input class="checkbox is_woocommerce" type="checkbox" id="is_woocommerce" name="is_woocommerce"<?php $this->set_checked($values['is_woocommerce']); ?>> 
							<!-- <input type="hidden" name="maintain_state" id="auto_submit_hidden" class="auto_submit_hidden" value="1"> -->
						</td>
					</tr>
					<?php*/
					//}
				?>
				<tr>
					<td width="275">
						<label for="force_is_search"><?php _e("Force <a href='http://codex.wordpress.org/Function_Reference/is_search' target='_blank'>is_search</a> to always be true?", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<input class="checkbox force_is_search" type="checkbox" id="force_is_search" name="force_is_search"<?php $this->set_checked($values['force_is_search']); ?>> 
					</td>
				</tr>
				<tr>
					<td width="275">
						<label for="force_is_archive"><?php _e("Force <a href='http://codex.wordpress.org/Function_Reference/is_archive' target='_blank'>is_archive</a> to always be true?", $this->plugin_slug ); ?></label>
					</td>
					<td>
						<input class="checkbox force_is_archive" type="checkbox" id="force_is_archive" name="force_is_archive"<?php $this->set_checked($values['force_is_archive']); ?>> 
					</td>
				</tr>
				
				
				
			</table>
		</div>
	</div>
	
</div>


