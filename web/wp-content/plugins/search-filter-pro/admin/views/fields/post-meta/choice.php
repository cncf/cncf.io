<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<p class="item-container sf_input_type">
					<label for="{0}[{1}][choice_input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
						<select name="{0}[{1}][choice_input_type]" class="" id="{0}[{1}][choice_input_type]">
							<option value="select"<?php $this->set_selected($values['choice_input_type'], "select"); ?>><?php _e("Dropdown", $this->plugin_slug); ?></option>
							<option value="checkbox"<?php $this->set_selected($values['choice_input_type'], "checkbox"); ?>><?php _e("Checkbox", $this->plugin_slug); ?></option>
							<option value="radio"<?php $this->set_selected($values['choice_input_type'], "radio"); ?>><?php _e("Radio", $this->plugin_slug); ?></option>
							<option value="multiselect"<?php $this->set_selected($values['choice_input_type'], "multiselect"); ?>><?php _e("Multi-select", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="item-container" style="padding-right:0;">
			
					<label for="{0}[{1}][choice_heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][choice_heading]" name="{0}[{1}][choice_heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				<div class="clear"></div>
				
				<p class="sf_all_items_label item-container">
					<label for="{0}[{1}][all_items_label]"><?php _e("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("override the default - e.g. &quot;All Items&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" id="{0}[{1}][all_items_label]" name="{0}[{1}][all_items_label]" type="text" value="<?php echo esc_attr($values['all_items_label']); ?>"></label>
				</p>
				<p class="sf_accessibility_label">
					<label for="{0}[{1}][choice_accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" id="{0}[{1}][choice_accessibility_label]" name="{0}[{1}][choice_accessibility_label]" type="text" value="<?php echo esc_attr($values['choice_accessibility_label']); ?>"></label>
				</p>
				<p class="sf_operator item-container">
					<label for="{0}[{1}][operator]"><?php _e("Search Operator", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("AND - posts must have each option selected, OR - posts must have any of the options selected", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select name="{0}[{1}][operator]" id="{0}[{1}][operator]">
							<option value="and"<?php $this->set_selected($values['operator'], "and"); ?>><?php _e("AND", $this->plugin_slug); ?></option>
							<option value="or"<?php $this->set_selected($values['operator'], "or"); ?>><?php _e("OR", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				

				<p class="item-container" style="">
					
					<span class="sf_make_combobox">
						<input class="checkbox" type="checkbox" id="{0}[{1}][combo_box]" name="{0}[{1}][combo_box]"<?php $this->set_checked($values['combo_box']); ?>>
						<label for="{0}[{1}][combo_box]"><?php _e("Make Combobox?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Allow for text input to find values, with autocomplete and dropdown suggest", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />
					</span>
					<input class="checkbox " type="checkbox" id="{0}[{1}][show_count]" name="{0}[{1}][show_count]"<?php $this->set_checked($values['show_count']); ?>>
					<label for="{0}[{1}][show_count]"><?php _e("Display count?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("display the number of posts for each option - only available if Auto Count is enabled", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />

					<input class="checkbox " type="checkbox" id="{0}[{1}][hide_empty]" name="{0}[{1}][hide_empty]"<?php $this->set_checked($values['hide_empty']); ?>>
					<label for="{0}[{1}][hide_empty]"><?php _e("Hide Empty?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("hide values with no results - only available if Auto Count is enabled", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>
                <p class="item-container" style="padding-right:0;">
                    <span class="sf_combobox_message">
                        <label for="{0}[{1}][no_results_message]"><?php _e("Combobox No Results message", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][no_results_message]" name="{0}[{1}][no_results_message]" type="text" value="<?php echo esc_attr($values['no_results_message']); ?>"></label>
                    </span>
                </p>
				<div class="clear"></div>
				<hr />
				<p style="margin-bottom:0;"><strong><?php _e("Meta Key", $this->plugin_slug); ?></strong> <span class="hint--top hint--info" data-hint="<?php _e("choose a meta key for this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></p>
				<!--<p style="padding-bottom:0;margin-bottom:0;">
					<em><?php _e("Choose the min / max key names to be used for comparison.", $this->plugin_slug); ?></em>
				</p>-->
				<p class="item-container sf_meta_keys">
					<label for="{0}[{1}][choice_meta_key]">
						
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="{0}[{1}][choice_meta_key]" class="meta_key choice_meta_key" id="{0}[{1}][choice_meta_key]">';
							
							foreach($all_meta_keys as $v){
								//$data[] = $v->meta_key;
								
								echo '<option value="'.$v.'"'.$this->set_selected($values['choice_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select>';
							
						?>
						<input type="hidden"  name="{0}[{1}][choice_meta_key]" id="{0}[{1}][choice_meta_key]" class="meta_key_hidden"  value="<?php echo esc_attr($values['choice_meta_key']); ?>" disabled="disabled" />
					</label>
				</p>
				<br class="clear" />
				<hr class="clear" />
				<p style="margin-bottom:0;"><strong><?php _e("Options", $this->plugin_slug); ?></strong></p>
				
				<!--<p>
					<?php _e("Choose how the options for this field are fetched:", $this->plugin_slug); ?>
				</p>-->
				
				<p class="item-container sf_choice_get_options">
					<label for="{0}[{1}][choice_get_option_mode]"><?php _e("Get Options: ", $this->plugin_slug); ?><br />
						<select name="{0}[{1}][choice_get_option_mode]" class="" id="{0}[{1}][choice_get_option_mode]">
							<option value="auto"<?php $this->set_selected($values['choice_get_option_mode'], "auto"); ?>><?php _e("Automatically", $this->plugin_slug); ?></option>
							<option value="manual"<?php $this->set_selected($values['choice_get_option_mode'], "manual"); ?>><?php _e("Manual Entry", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="item-container sf_choice_order_options" style="padding-right:0;">
					<label for="{0}[{1}][choice_order_option_by]"><?php _e("Order Options by: ", $this->plugin_slug); ?><br />
						<select name="{0}[{1}][choice_order_option_by]" class="sf_choice_order_option_by" id="{0}[{1}][choice_order_option_by]">
							<option value="value"<?php $this->set_selected($values['choice_order_option_by'], "value"); ?>><?php _e("Value", $this->plugin_slug); ?></option>
							<option value="label"<?php $this->set_selected($values['choice_order_option_by'], "label"); ?>><?php _e("Label", $this->plugin_slug); ?></option>
							<option value="none"<?php $this->set_selected($values['choice_order_option_by'], "none"); ?>><?php _e("None", $this->plugin_slug); ?></option>
						</select>
					</label>
					
						<select name="{0}[{1}][choice_order_option_dir]" class="sf_choice_order_option_dir" id="{0}[{1}][choice_order_option_dir]">
							<option value="asc"<?php $this->set_selected($values['choice_order_option_dir'], "asc"); ?>><?php _e("ASC", $this->plugin_slug); ?></option>
							<option value="desc"<?php $this->set_selected($values['choice_order_option_dir'], "desc"); ?>><?php _e("DESC", $this->plugin_slug); ?></option>
						</select>
						
						<select name='{0}[{1}][choice_order_option_type]' class="sf_choice_order_option_type" id="{0}[{1}][choice_order_option_type]">
                            <option value="numeric"<?php $this->set_selected($values['choice_order_option_type'], "numeric"); ?>><?php _e("Numerical", $this->plugin_slug); ?></option>
							<option value="alphabetic"<?php $this->set_selected($values['choice_order_option_type'], "alphabetic"); ?>><?php _e("Alphabetical", $this->plugin_slug); ?></option>
						</select>
					
				</p>
				<p class="item-container choice_is_acf">
					<input class="checkbox " type="checkbox" id="{0}[{1}][choice_is_acf]" name="{0}[{1}][choice_is_acf]"<?php $this->set_checked($values['choice_is_acf']); ?>>
					<label for="{0}[{1}][choice_is_acf]"><?php _e("Is ACF Field?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("if this is an 'Advanced Custom Fields' field enable here to sync labels & options with ACF directly", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>
				<div class="clear"></div>
				
				<div class="sf_manual_meta_options">
					<p>
						<?php _e("Add the options that will be available to this field, each option must have a value and a label.", $this->plugin_slug); ?>
					</p>
					
					<p class="item-container slimheadings1">
						<strong><?php _e("Value", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php _e("the internal meta value - this value will be used to search your meta data", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
					</p>
					<p class="item-container slimheadings2">
						<strong><?php _e("Label", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php _e("text that is visible to a user when selecting this option in the Search Form", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
					</p>
					
					<!--<p>
						
						<a href="#" class="button-secondary sort-options-button"><?php _e("Sort By Value", $this->plugin_slug); ?></a>
						<a href="#" class="button-secondary sort-options-button"><?php _e("Sort By Label", $this->plugin_slug); ?></a>
					</p>-->
					<br class="clear"></span>
				
					<p class="no_sort_label"><?php _e("<strong>There are no options</strong>.", $this->plugin_slug); ?></p>
					
					<ul class="meta_options_list">
						<?php
						
						$i = 0;
						$this->display_meta_option( array(), ' meta-option-template ignore-template-init');
						
						if(isset($values['meta_options']))
						{
							foreach ($values['meta_options'] as $sort_option)
							{
								$this->display_meta_option($sort_option);
								
								$i++;
							}
						}
						
						?>
					</ul>
					
					<p>
						<a href="#" class="dashicons-plus add-option-button button-secondary"><?php _e("Add Option", $this->plugin_slug); ?></a>
						<a  href="#" class="dashicons-search detect-option-button button-secondary sfmodal"><?php _e("Browse Values", $this->plugin_slug); ?><!--<span class="hint--top hint--info" data-hint="<?php _e("*experimental - suggest possible values based on a search of existing values for the meta key", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>--></a>
						<a href="#" class="clear-option-button button-secondary"><?php _e("Clear All Options", $this->plugin_slug); ?></a>
					</p>
				</div>