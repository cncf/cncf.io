<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */
?>

<div class="wrap">
	
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<?php _e('Global settings are applied to all search forms', $this->plugin_slug); ?>
	
	<h3><?php _e('Cache', $this->plugin_slug); ?></h3>
	
	<form method="post" action="options.php">
		
		<?php settings_fields('search_filter_settings'); ?>
		<table class="form-table">
			<tbody>
				
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Caching Speed', $this->plugin_slug); ?><br />
					</th>
					<td>
						<label>
							
							<select name="search_filter_cache_speed">
								<option value="slow"<?php $this->set_selected($cache_speed, "slow"); ?>><?php _e('Slow', $this->plugin_slug); ?></option>
								<option value="medium"<?php $this->set_selected($cache_speed, "medium"); ?>><?php _e('Medium', $this->plugin_slug); ?></option>
								<option value="fast"<?php $this->set_selected($cache_speed, "fast"); ?>><?php _e('Fast', $this->plugin_slug); ?></option>
							</select> 

							<?php _e('This controls the speed at which the Cache is built when first indexing all the posts on your site or when it is required to be rebuilt.', $this->plugin_slug); ?>
							
							<br /><br />
							<div style="padding:10px;background-color: #EAEAEA;border: 1px solid #ddd;">
								<p><?php _e('A faster setting means more posts will be cached in each process, however this is generally considered to me more resource intensive.', $this->plugin_slug); ?></p>
								<p><?php _e('Using a high setting when your server cannot support it may result in internal server errors and resource limits being reached.', $this->plugin_slug); ?></p>
							</div>
							
							
						</label>
						
					</td>
				</tr>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Use Background Processes', $this->plugin_slug); ?><br />
					</th>
					<td>
						<label>
							
							
							<input id="search_filter_cache_use_manual" name="search_filter_cache_use_background_processes" type="checkbox" value="1"<?php $this->set_checked($cache_use_background_processes); ?> />  
							<?php _e('Build the cache in the background using `wp_remote_get()` - this is generally a good thing.', $this->plugin_slug); ?>
							
							<br /><br />
							<div style="padding:10px;background-color: #EAEAEA;border: 1px solid #ddd;">
								<p><?php _e('Disable this if you are having issues with resources in your environement and you have already tried lowering the caching speed above.', $this->plugin_slug); ?></p>
								<p><?php _e('If disabled, you must then goto any <strong>Add/Edit Search Form</strong> screen to allow the caching processes to complete via Ajax.', $this->plugin_slug); ?></p>
							</div>
							 
						</label>
						
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php _e('Use Transients', $this->plugin_slug); ?><br />
					</th>
					<td>
						<label>

							<input id="search_filter_cache_use_transients" name="search_filter_cache_use_transients" type="checkbox" value="1"<?php $this->set_checked($cache_use_transients); ?> />
							<?php _e('Frequently accessed query data will be stored in transients - this sometimes helps on sites with larger numbers of posts and filters/options. ', $this->plugin_slug); ?>

							<br /><br />
							<div style="padding:10px;background-color: #EAEAEA;border: 1px solid #ddd;">
								<p><?php _e('This does not need to be enabled unless you are experiencing performance issues.', $this->plugin_slug); ?></p>
							</div>

						</label>

					</td>
				</tr>
				<!--<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Use Manual Caching', $this->plugin_slug); ?><br />
					</th>
					<td>
						<label>
							
							
							<input id="search_filter_cache_use_manual" name="search_filter_cache_use_manual" type="checkbox" value="1"<?php $this->set_checked($cache_use_manual); ?> />  
							<?php _e('Manually rebuild the cache via the UI', $this->plugin_slug); ?>
							
							<br /><br />
							<div style="padding:10px;background-color: #EAEAEA;border: 1px solid #ddd;">
								<?php _e('This only applies when initially building the cache or rebuilding the entire cache.  Once the cache has been built once, it is automatically maintained regardless of this setting.', $this->plugin_slug); ?>
							</div>
							 
						</label>
						
					</td>
				</tr>-->
				
			</tbody>
		</table>

        <br />

		<h3><?php _e('JavaScript & CSS', $this->plugin_slug); ?></h3>
		
		<table class="form-table">
			<tbody>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Load JavaScript & CSS files', $this->plugin_slug); ?><br />
					</th>
					<td>
						<label>
							<input id="search_filter_load_js_css" name="search_filter_load_js_css" type="checkbox" class="" value="1"<?php $this->set_checked($load_js_css); ?> />  
							 <?php _e('<strong>Do not turn this setting off</strong>, S&amp;F will not work unless you plan to manually copy all JS &amp; CSS into your theme.', $this->plugin_slug); ?>
						</label>
						
					</td>
				</tr>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Lazy Load JavaScript', $this->plugin_slug); ?>
					</th>
					<td>
						<label>
							<input id="search_filter_lazy_load_js" name="search_filter_lazy_load_js" type="checkbox" class="" value="1"<?php $this->set_checked($lazy_load_js); ?> /> 
							<?php _e('Not all themes support lazy loading - enabling this option ensures that Search &amp; Filter JavaScript files are only loaded on the pages that contain search forms - speeding up the other pages on your site.', $this->plugin_slug); ?>
						</label>
					</td>
				</tr>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Combobox Script', $this->plugin_slug); ?>
					</th>
					<td>
						<label>
							<select name="search_filter_combobox_script" id="search_filter_combobox_script">
								<option value="select2"<?php $this->set_selected($combobox_script, "select2"); ?>><?php _e('Select2', $this->plugin_slug); ?></option>
								<option value="chosen"<?php $this->set_selected($combobox_script, "chosen"); ?>><?php _e('Chosen', $this->plugin_slug); ?></option>
							</select> 							
							
						</label>
					</td>
				</tr>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('Load jQuery UI i18n files', $this->plugin_slug); ?><br />
					</th>
					<td>
						<label>
							<input id="search_filter_load_jquery_i18n" name="search_filter_load_jquery_i18n" type="checkbox" class="" value="1"<?php $this->set_checked($load_jquery_i18n); ?> />  
							 <?php _e('This loads the jQuery i18n files - which allows the date picker to be translated automatically using the jQuery translation files.', $this->plugin_slug); ?>
						</label>
						
					</td>
				</tr>
				
			</tbody>
		</table>

        <br />
        <br />
		<h3><?php _e('Miscellaneous', $this->plugin_slug); ?></h3>

		<table class="form-table">
			<tbody>
			<tr valign="top">
				<th scope="row" valign="top">
					<?php _e('Remove all data when deleting Search & Filter', $this->plugin_slug); ?><br />
				</th>
				<td>
					<label>
						<input id="search_filter_remove_all_data" name="search_filter_remove_all_data" type="checkbox" class="" value="1"<?php $this->set_checked($remove_all_data); ?> />
						<?php _e('Enable this setting to remove all data when uninstalling Search & Filter via the `plugins` page.', $this->plugin_slug); ?>
                        <br /><br />
                        <div style="padding:10px;background-color: #EAEAEA;border: 1px solid #ddd;">
                            <p>
                                <?php _e('Leaving this option disabled allows you to delete and re-install later, preserving your saved search forms and cache.', $this->plugin_slug); ?>
                            </p>
                            <p>
                                <?php _e('If you have modified any posts while the plugin is disabled / removed, you will likely need to rebuild the cache when activating Search & Filter again. ', $this->plugin_slug); ?>
                            </p>
                        </div>
					</label>

				</td>
			</tr>
		</table>
		<?php submit_button(); ?>
	</form>
</div>
