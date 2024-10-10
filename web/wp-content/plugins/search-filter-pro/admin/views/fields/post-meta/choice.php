<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$meta_key_text_input = Search_Filter_Helper::get_option( 'meta_key_text_input' );

?>
				<p class="item-container sf_input_type">
					<label for="{0}[{1}][choice_input_type]"><?php echo esc_html__("Input type: ", $this->plugin_slug); ?><br />
						<select data-field-template-name="{0}[{1}][choice_input_type]" class="" data-field-template-id="{0}[{1}][choice_input_type]">
							<option value="select"<?php $this->set_selected($values['choice_input_type'], "select"); ?>><?php echo esc_html__("Dropdown", $this->plugin_slug); ?></option>
							<option value="checkbox"<?php $this->set_selected($values['choice_input_type'], "checkbox"); ?>><?php echo esc_html__("Checkbox", $this->plugin_slug); ?></option>
							<option value="radio"<?php $this->set_selected($values['choice_input_type'], "radio"); ?>><?php echo esc_html__("Radio", $this->plugin_slug); ?></option>
							<option value="multiselect"<?php $this->set_selected($values['choice_input_type'], "multiselect"); ?>><?php echo esc_html__("Multi-select", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="item-container" style="padding-right:0;">
			
					<label for="{0}[{1}][choice_heading]"><?php echo esc_html__("Add a heading?", $this->plugin_slug); ?><br /><input class="" data-field-template-id="{0}[{1}][choice_heading]" data-field-template-name="{0}[{1}][choice_heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				<div class="clear"></div>
				
				<p class="sf_all_items_label item-container">
					<label for="{0}[{1}][all_items_label]"><?php echo esc_html__("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("override the default - e.g. &quot;All Items&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" data-field-template-id="{0}[{1}][all_items_label]" data-field-template-name="{0}[{1}][all_items_label]" type="text" value="<?php echo esc_attr($values['all_items_label']); ?>"></label>
				</p>
				<p class="sf_accessibility_label">
					<label for="{0}[{1}][choice_accessibility_label]"><?php echo esc_html__("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" data-field-template-id="{0}[{1}][choice_accessibility_label]" data-field-template-name="{0}[{1}][choice_accessibility_label]" type="text" value="<?php echo esc_attr($values['choice_accessibility_label']); ?>"></label>
				</p>
				<p class="sf_operator item-container">
					<label for="{0}[{1}][operator]"><?php echo esc_html__("Search Operator", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("AND - posts must have each option selected, OR - posts must have any of the options selected", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select data-field-template-name="{0}[{1}][operator]" data-field-template-id="{0}[{1}][operator]">
							<option value="and"<?php $this->set_selected($values['operator'], "and"); ?>><?php echo esc_html__("AND", $this->plugin_slug); ?></option>
							<option value="or"<?php $this->set_selected($values['operator'], "or"); ?>><?php echo esc_html__("OR", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				

				<p class="item-container" style="">
					
					<span class="sf_make_combobox">
						<input class="checkbox" type="checkbox" data-field-template-id="{0}[{1}][combo_box]" data-field-template-name="{0}[{1}][combo_box]"<?php $this->set_checked($values['combo_box']); ?>>
						<label for="{0}[{1}][combo_box]"><?php echo esc_html__("Make Combobox?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("Allow for text input to find values, with autocomplete and dropdown suggest", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />
					</span>
					<input class="checkbox " type="checkbox" data-field-template-id="{0}[{1}][show_count]" data-field-template-name="{0}[{1}][show_count]"<?php $this->set_checked($values['show_count']); ?>>
					<label for="{0}[{1}][show_count]"><?php echo esc_html__("Display count?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("display the number of posts for each option - only available if Auto Count is enabled", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />

					<input class="checkbox " type="checkbox" data-field-template-id="{0}[{1}][hide_empty]" data-field-template-name="{0}[{1}][hide_empty]"<?php $this->set_checked($values['hide_empty']); ?>>
					<label for="{0}[{1}][hide_empty]"><?php echo esc_html__("Hide Empty?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("hide values with no results - only available if Auto Count is enabled", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>
                <p class="item-container" style="padding-right:0;">
                    <span class="sf_combobox_message">
                        <label for="{0}[{1}][no_results_message]"><?php echo esc_html__("Combobox No Results message", $this->plugin_slug); ?><br /><input class="" data-field-template-id="{0}[{1}][no_results_message]" data-field-template-name="{0}[{1}][no_results_message]" type="text" value="<?php echo esc_attr($values['no_results_message']); ?>"></label>
                    </span>
                </p>
				<div class="clear"></div>
				<hr />
				<p style="margin-bottom:0;"><strong><?php echo esc_html__("Meta Key", $this->plugin_slug); ?></strong> <span class="hint--top hint--info" data-hint="<?php echo esc_attr__("choose a meta key for this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></p>

				<p class="item-container sf_meta_keys">
					<label for="{0}[{1}][choice_meta_key]">
						
						<?php
							if($meta_key_text_input == 1 ) {
								?>
								<input type="text" placeholder="<?php echo esc_attr__( 'Enter a meta key', 'search-filter' ); ?>" style="width: 100%" class="meta_key choice_meta_key" data-field-template-name="{0}[{1}][choice_meta_key]" data-field-template-id="{0}[{1}][choice_meta_key]" value="<?php echo esc_attr($values['choice_meta_key']); ?>" />
								<?php
							} else {
								$all_meta_keys = $this->get_all_post_meta_keys();
								echo '<select data-field-template-name="{0}[{1}][choice_meta_key]" class="meta_key choice_meta_key" data-field-template-id="{0}[{1}][choice_meta_key]">';
								
								foreach($all_meta_keys as $v){
									echo '<option value="'.esc_attr( $v ).'"'.$this->set_selected($values['choice_meta_key'], $v, false).'>'.esc_html( $v )."</option>";
								}
								echo '</select>';
							}
							
							
						?>
						<input type="hidden" data-field-template-name="{0}[{1}][choice_meta_key_hidden]" data-field-template-id="{0}[{1}][choice_meta_key_hidden]" class="meta_key_hidden"  value="<?php echo esc_attr($values['choice_meta_key']); ?>" disabled="disabled" />
					</label>
				</p>
				<br class="clear" />
				<hr class="clear" />
				<p style="margin-bottom:0;"><strong><?php echo esc_html__("Options", $this->plugin_slug); ?></strong></p>
				
				<?php echo esc_html__("Choose how the options for this field are fetched:", $this->plugin_slug); ?>
				
				<p class="item-container sf_choice_get_options">
					<label for="{0}[{1}][choice_get_option_mode]"><?php echo esc_html__("Get Options: ", $this->plugin_slug); ?><br />
						<select data-field-template-name="{0}[{1}][choice_get_option_mode]" class="" data-field-template-id="{0}[{1}][choice_get_option_mode]">
							<option value="auto"<?php $this->set_selected($values['choice_get_option_mode'], "auto"); ?>><?php echo esc_html__("Automatically", $this->plugin_slug); ?></option>
							<option value="manual"<?php $this->set_selected($values['choice_get_option_mode'], "manual"); ?>><?php echo esc_html__("Manual Entry", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="item-container sf_choice_order_options" style="padding-right:0;">
					<label for="{0}[{1}][choice_order_option_by]"><?php echo esc_html__("Order Options by: ", $this->plugin_slug); ?><br />
						<select data-field-template-name="{0}[{1}][choice_order_option_by]" class="sf_choice_order_option_by" data-field-template-id="{0}[{1}][choice_order_option_by]">
							<option value="value"<?php $this->set_selected($values['choice_order_option_by'], "value"); ?>><?php echo esc_html__("Value", $this->plugin_slug); ?></option>
							<option value="label"<?php $this->set_selected($values['choice_order_option_by'], "label"); ?>><?php echo esc_html__("Label", $this->plugin_slug); ?></option>
							<option value="none"<?php $this->set_selected($values['choice_order_option_by'], "none"); ?>><?php echo esc_html__("None", $this->plugin_slug); ?></option>
						</select>
					</label>
					
						<select data-field-template-name="{0}[{1}][choice_order_option_dir]" class="sf_choice_order_option_dir" data-field-template-id="{0}[{1}][choice_order_option_dir]">
							<option value="asc"<?php $this->set_selected($values['choice_order_option_dir'], "asc"); ?>><?php echo esc_html__("ASC", $this->plugin_slug); ?></option>
							<option value="desc"<?php $this->set_selected($values['choice_order_option_dir'], "desc"); ?>><?php echo esc_html__("DESC", $this->plugin_slug); ?></option>
						</select>
						
						<select data-field-template-name='{0}[{1}][choice_order_option_type]' class="sf_choice_order_option_type" data-field-template-id="{0}[{1}][choice_order_option_type]">
                            <option value="numeric"<?php $this->set_selected($values['choice_order_option_type'], "numeric"); ?>><?php echo esc_html__("Numerical", $this->plugin_slug); ?></option>
							<option value="alphabetic"<?php $this->set_selected($values['choice_order_option_type'], "alphabetic"); ?>><?php echo esc_html__("Alphabetical", $this->plugin_slug); ?></option>
						</select>
					
				</p>
				<p class="item-container choice_is_acf">
					<input class="checkbox " type="checkbox" data-field-template-id="{0}[{1}][choice_is_acf]" data-field-template-name="{0}[{1}][choice_is_acf]"<?php $this->set_checked($values['choice_is_acf']); ?>>
					<label for="{0}[{1}][choice_is_acf]"><?php echo esc_html__("Is ACF Field?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("if this is an 'Advanced Custom Fields' field enable here to sync labels & options with ACF directly", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>
				<div class="clear"></div>
				
				<div class="sf_manual_meta_options">
					<p>
						<?php echo esc_html__("Add the options that will be available to this field, each option must have a value and a label.", $this->plugin_slug); ?>
					</p>
					
					<p class="item-container slimheadings1">
						<strong><?php echo esc_html__("Value", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php echo esc_attr__("the internal meta value - this value will be used to search your meta data", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
					</p>
					<p class="item-container slimheadings2">
						<strong><?php echo esc_html__("Label", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php echo esc_attr__("text that is visible to a user when selecting this option in the Search Form", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
					</p>
					
		
					<br class="clear"></span>
				
					<p class="no_sort_label"><?php echo esc_html__("<strong>There are no options</strong>.", $this->plugin_slug); ?></p>
					
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
						<a href="#" class="dashicons-plus add-option-button button-secondary"><?php echo esc_html__("Add Option", $this->plugin_slug); ?></a>
						<a  href="#" class="dashicons-search detect-option-button button-secondary sfmodal"><?php echo esc_html__("Browse Values", $this->plugin_slug); ?></a>
						<a href="#" class="clear-option-button button-secondary"><?php echo esc_html__("Clear All Options", $this->plugin_slug); ?></a>
					</p>
				</div>