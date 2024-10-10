<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<p class="item-container sf_date_input">
					<label for="{0}[{1}][date_input_type]"><?php echo esc_html__("Input type: ", $this->plugin_slug); ?><br />
						<select data-field-template-name="{0}[{1}][date_input_type]" class="" data-field-template-id="{0}[{1}][date_input_type]">
							<option value="date"<?php $this->set_selected($values['date_input_type'], "date"); ?>><?php echo esc_html__("Date", $this->plugin_slug); ?></option>
							<option value="daterange"<?php $this->set_selected($values['date_input_type'], "daterange"); ?>><?php echo esc_html__("Date Range", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="item-container" style="padding-right:0;">
			
					<label for="{0}[{1}][date_heading]"><?php echo esc_html__("Add a heading?", $this->plugin_slug); ?><br /><input class="" data-field-template-id="{0}[{1}][date_heading]" data-field-template-name="{0}[{1}][date_heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				<p class="sf_accessibility_label">
					<label for="{0}[{1}][date_accessibility_label]"><?php echo esc_html__("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" data-field-template-id="{0}[{1}][date_accessibility_label]" data-field-template-name="{0}[{1}][date_accessibility_label]" type="text" value="<?php echo esc_attr($values['date_accessibility_label']); ?>"></label>
				</p>
				
				<div class="clear"></div>
				
				<hr />
				
				<div class="clear"></div>
				<p><strong><?php echo esc_html__("Meta Key", $this->plugin_slug); ?></strong></p>
				<p style="padding-bottom:0;margin-bottom:0;">
					<em><?php echo esc_html__("Choose the min / max key names to be used for comparison.", $this->plugin_slug); ?></em>
				</p>
				<p class="item-container sf_meta_keys">
					<label for="{0}[{1}][date_start_meta_key]">
						<?php echo esc_html__("Start Meta Key", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_html__("choose a meta key for this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<?php
							$meta_key_text_input = Search_Filter_Helper::get_option( 'meta_key_text_input' );
							if($meta_key_text_input == 1 ) {
								?>
								<input type="text" placeholder="<?php echo esc_attr__( 'Enter a meta key', 'search-filter' ); ?>" style="width: 100%" data-field-template-name="{0}[{1}][date_start_meta_key]" class="meta_key start_meta_key" data-field-template-id="{0}[{1}][date_start_meta_key]" value="<?php echo esc_attr($values['date_start_meta_key']); ?>" />
								<?php
							} else {
								$all_meta_keys = $this->get_all_post_meta_keys();
								echo '<select data-field-template-name="{0}[{1}][date_start_meta_key]" class="meta_key start_meta_key" data-field-template-id="{0}[{1}][date_start_meta_key]">';
								
								foreach($all_meta_keys as $v){
									echo '<option value="'. esc_attr( $v ) .'"'.$this->set_selected($values['date_start_meta_key'], $v, false).'>'.esc_html($v)."</option>";
								}
								echo '</select>';
							}
							
						?>
						<input type="hidden" data-field-template-name="{0}[{1}][date_start_meta_key_hidden]" data-field-template-id="{0}[{1}][date_start_meta_key_hidden]" class="meta_key_hidden"  value="<?php echo esc_attr($values['date_start_meta_key']); ?>" disabled="disabled" />
					</label>
					
				</p>
				
				<p class="item-container sf_meta_keys sf_date_end_meta_key" style="padding-right:0;">
					<label for="{0}[{1}][date_use_same_toggle]">
						<input class="checkbox use_same_toggle date_use_same_toggle" type="checkbox" data-field-template-id="{0}[{1}][date_use_same_toggle]" data-field-template-name="{0}[{1}][date_use_same_toggle]"<?php $this->set_checked($values['date_use_same_toggle']); ?>> 
						<?php echo esc_html__("Use same for End Key?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_html__("if your meta key is not listed or not yet created enter here", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					</label>
					<label for="{0}[{1}][date_end_meta_key]">	
						
						<?php
							if($meta_key_text_input == 1 ) {
								?>
								<input type="text" placeholder="<?php echo esc_attr__( 'Enter a meta key', 'search-filter' ); ?>" style="width: 100%"  data-field-template-name="{0}[{1}][date_end_meta_key]" class="meta_key end_meta_key" data-field-template-id="{0}[{1}][date_end_meta_key]" value="<?php echo esc_attr($values['date_end_meta_key']); ?>" />
								<?php
							} else {
								$all_meta_keys = $this->get_all_post_meta_keys();
								echo '<select data-field-template-name="{0}[{1}][date_end_meta_key]" class="meta_key end_meta_key" data-field-template-id="{0}[{1}][date_end_meta_key]">';
								
								foreach($all_meta_keys as $v){
									
									echo '<option value="'.esc_attr( $v ).'"'.$this->set_selected($values['date_end_meta_key'], $v, false).'>'.esc_html( $v )."</option>";
								}
								echo '</select>';
							}
							
						?>
						<input type="hidden"  data-field-template-name="{0}[{1}][date_end_meta_key_hidden]" data-field-template-id="{0}[{1}][date_end_meta_key_hidden]" class="meta_key_hidden"  value="<?php echo esc_attr($values['date_end_meta_key']); ?>" disabled="disabled" />
					</label>
				</p><div class="clear"></div>
				<p class="sf_compare_mode">
					<label for="{0}[{1}][date_compare_mode]"><?php echo esc_html__("Compare Mode ", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("the format the date is saved in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select data-field-template-name="{0}[{1}][date_compare_mode]" class="" data-field-template-id="{0}[{1}][date_compare_mode]">
							<option value="userrange"<?php $this->set_selected($values['date_compare_mode'], "userrange"); ?>><?php echo esc_html__("Post Meta must be within input range", $this->plugin_slug); ?></option>
							<option value="metarange"<?php $this->set_selected($values['date_compare_mode'], "metarange"); ?>><?php echo esc_html__("Input must be within the Post Meta range", $this->plugin_slug); ?></option>
							<option value="overlap"<?php $this->set_selected($values['date_compare_mode'], "overlap"); ?>><?php echo esc_html__("Input overlaps any of the Post Meta range", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p><div class="clear"></div>
				<hr />
				
				<div class="clear"></div>
				<div class="item-container">
					<p>
					<label for="{0}[{1}][date_input_format]"><?php echo esc_html__("Date Input Format ", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("the format the date is saved in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select data-field-template-name="{0}[{1}][date_input_format]" class="" data-field-template-id="{0}[{1}][date_input_format]">
							<option value="timestamp"<?php $this->set_selected($values['date_input_format'], "timestamp"); ?>><?php echo esc_html__("Timestamp", $this->plugin_slug); ?></option>
							<option value="yyyymmdd"<?php $this->set_selected($values['date_input_format'], "yyyymmdd"); ?>><?php echo esc_html__("YYYYMMDD (ACF)", $this->plugin_slug); ?></option>
							<option value="yyyy-mm-dd"<?php $this->set_selected($values['date_input_format'], "yyyy-mm-dd"); ?>><?php echo esc_html__("YYYY-MM-DD (PODS)", $this->plugin_slug); ?></option>
						</select>
					</label>
					</p>
				</div>
				
				<div class="item-container" style="padding-right:0;">
					<p>
						<?php echo esc_html__("Date Display Format", $this->plugin_slug); ?>
					</p>
					<p>
					<?php
						$format = array();
						$format[0] = "d/m/Y";
						$format[1] = "m/d/Y";
						$format[2] = "Y/m/d";
						
						$formati = 0;
						
						
					?>
						<label for="{0}[{1}][date_output_format][0]"><input data-radio-checked="<?php echo esc_attr($values['date_output_format']==$format[0]) ? 1 : 0 ?>" class="date_format_radio" data-field-template-id="{0}[{1}][date_output_format][0]" data-field-template-name="{0}[{1}][date_output_format]" type="radio" value="<?php echo esc_attr( $format[0] ); ?>"<?php echo $this->set_radio($values['date_output_format'], $format[0]); ?>><?php echo esc_html( date($format[0]) ); ?></label><br />
						<label for="{0}[{1}][date_output_format][1]"><input data-radio-checked="<?php echo esc_attr($values['date_output_format']==$format[1]) ? 1 : 0 ?>" class="date_format_radio" data-field-template-id="{0}[{1}][date_output_format][1]" data-field-template-name="{0}[{1}][date_output_format]" type="radio" value="<?php echo esc_attr( $format[1] ); ?>"<?php echo $this->set_radio($values['date_output_format'], $format[1]); ?>><?php echo esc_html( date($format[1]) ); ?></label><br />
						<label for="{0}[{1}][date_output_format][2]"><input data-radio-checked="<?php echo esc_attr($values['date_output_format']==$format[2]) ? 1 : 0 ?>" class="date_format_radio" data-field-template-id="{0}[{1}][date_output_format][2]" data-field-template-name="{0}[{1}][date_output_format]" type="radio" value="<?php echo esc_attr( $format[2] ); ?>"<?php echo $this->set_radio($values['date_output_format'], $format[2]); ?>><?php echo esc_html( date($format[2]) ); ?></label><br />
					</p>
				</div>
				<div class="clear"></div>
				<hr />
				<p style="margin-bottom:0;"><strong><?php echo esc_html__("UI Options", $this->plugin_slug); ?></strong>
				

				<fieldset class="item-container child-columns">
					
					<p class="sf_range_min">
						<label for="{0}[{1}][date_from_prefix]">
							<?php echo esc_html__("From Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("text to appear before the From field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" data-field-template-id="{0}[{1}][date_from_prefix]" data-field-template-name="{0}[{1}][date_from_prefix]" type="text" size="7" value="<?php echo esc_attr($values['date_from_prefix']); ?>">
						</label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][date_from_postfix]">
							<?php echo esc_html__("From Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("text to appear after the From field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" data-field-template-id="{0}[{1}][date_from_postfix]" data-field-template-name="{0}[{1}][date_from_postfix]" type="text" size="7" value="<?php echo esc_attr($values['date_from_postfix']); ?>">
						</label>
					</p>
					<p class="sf_range_step">
						<label for="{0}[{1}][date_from_placeholder]">
							<?php echo esc_html__("From Placeholder", $this->plugin_slug); ?><br />
							<input class="" data-field-template-id="{0}[{1}][date_from_placeholder]" data-field-template-name="{0}[{1}][date_from_placeholder]" type="text" size="7" value="<?php echo esc_attr($values['date_from_placeholder']); ?>">
						</label>
					</p>
				</fieldset>
				
				<fieldset class="item-container child-columns sf_date_end_meta_key">
					<p class="sf_range_min">
						<label for="{0}[{1}][date_to_prefix]">
							<?php echo esc_html__("To Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("text to appear before the To field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" data-field-template-id="{0}[{1}][date_to_prefix]" data-field-template-name="{0}[{1}][date_to_prefix]" type="text" size="7" value="<?php echo esc_attr($values['date_to_prefix']); ?>">
						</label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][date_to_postfix]">
							<?php echo esc_html__("To Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("text to appear after the To field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" data-field-template-id="{0}[{1}][date_to_postfix]" data-field-template-name="{0}[{1}][date_to_postfix]" type="text" size="7" value="<?php echo esc_attr($values['date_to_postfix']); ?>">
						</label>
					</p>
					<p class="sf_range_step">
						<label for="{0}[{1}][date_to_placeholder]">
							<?php echo esc_html__("To Placeholder", $this->plugin_slug); ?><br />
							<input class="" data-field-template-id="{0}[{1}][date_to_placeholder]" data-field-template-name="{0}[{1}][date_to_placeholder]" type="text" size="7" value="<?php echo esc_attr($values['date_to_placeholder']); ?>">
						</label>
					</p>
				</fieldset>
				<br class="clear" />
				<p class="item-container" style="">
					
					
					<input class="checkbox" type="checkbox" data-field-template-id="{0}[{1}][date_use_dropdown_year]" data-field-template-name="{0}[{1}][date_use_dropdown_year]"<?php $this->set_checked($values['date_use_dropdown_year']); ?>>
					<label for="{0}[{1}][date_use_dropdown_year]"><?php echo esc_html__("Use dropdown for Year", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("Add dropdown for Year", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />
					
					<input class="checkbox " type="checkbox" data-field-template-id="{0}[{1}][date_use_dropdown_month]" data-field-template-name="{0}[{1}][date_use_dropdown_month]"<?php $this->set_checked($values['date_use_dropdown_month']); ?>>
					<label for="{0}[{1}][date_use_dropdown_month]"><?php echo esc_html__("Use dropdown for month", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php echo esc_attr__("Add dropdown for month", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>
				<br class="clear" />
				<div class="clear"></div>