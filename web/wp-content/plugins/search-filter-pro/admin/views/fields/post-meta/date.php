<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
				<p class="item-container sf_date_input">
					<label for="{0}[{1}][date_input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
						<select name="{0}[{1}][date_input_type]" class="" id="{0}[{1}][date_input_type]">
							<option value="date"<?php $this->set_selected($values['date_input_type'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
							<option value="daterange"<?php $this->set_selected($values['date_input_type'], "daterange"); ?>><?php _e("Date Range", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="item-container" style="padding-right:0;">
			
					<label for="{0}[{1}][date_heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][date_heading]" name="{0}[{1}][date_heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				<p class="sf_accessibility_label">
					<label for="{0}[{1}][date_accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" id="{0}[{1}][date_accessibility_label]" name="{0}[{1}][date_accessibility_label]" type="text" value="<?php echo esc_attr($values['date_accessibility_label']); ?>"></label>
				</p>
				
				<div class="clear"></div>
				
				<hr />
				
				<div class="clear"></div>
				<p><strong><?php _e("Meta Key", $this->plugin_slug); ?></strong></p>
				<p style="padding-bottom:0;margin-bottom:0;">
					<em><?php _e("Choose the min / max key names to be used for comparison.", $this->plugin_slug); ?></em>
				</p>
				<p class="item-container sf_meta_keys">
					<label for="{0}[{1}][date_start_meta_key]">
						<?php _e("Start Meta Key", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("choose a meta key for this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="{0}[{1}][date_start_meta_key]" class="meta_key start_meta_key" id="{0}[{1}][date_start_meta_key]">';
							
							foreach($all_meta_keys as $v){
								//$data[] = $v->meta_key;
								
								echo '<option value="'.$v.'"'.$this->set_selected($values['date_start_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select>';
							
						?>
						<input type="hidden"  name="{0}[{1}][date_start_meta_key]" id="{0}[{1}][date_start_meta_key]" class="meta_key_hidden"  value="<?php echo esc_attr($values['date_start_meta_key']); ?>" disabled="disabled" />
					</label>
					
				</p>
				
				<p class="item-container sf_meta_keys sf_date_end_meta_key" style="padding-right:0;">
					<label for="{0}[{1}][date_use_same_toggle]">
						<input class="checkbox use_same_toggle date_use_same_toggle" type="checkbox" id="{0}[{1}][date_use_same_toggle]" name="{0}[{1}][date_use_same_toggle]"<?php $this->set_checked($values['date_use_same_toggle']); ?>> 
						<?php _e("Use same for End Key?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("if your meta key is not listed or not yet created enter here", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					</label>
					<label for="{0}[{1}][date_end_meta_key]">	
						
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="{0}[{1}][date_end_meta_key]" class="meta_key end_meta_key" id="{0}[{1}][date_end_meta_key]">';
							
							foreach($all_meta_keys as $v){
								//$data[] = $v->meta_key;
								
								echo '<option value="'.$v.'"'.$this->set_selected($values['date_end_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select>';
							
						?>
						<input type="hidden"  name="{0}[{1}][date_end_meta_key]" id="{0}[{1}][date_end_meta_key]" class="meta_key_hidden"  value="<?php echo esc_attr($values['date_end_meta_key']); ?>" disabled="disabled" />
					</label>
				</p><div class="clear"></div>
				<p class="sf_compare_mode">
					<label for="{0}[{1}][date_compare_mode]"><?php _e("Compare Mode ", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the format the date is saved in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select name="{0}[{1}][date_compare_mode]" class="" id="{0}[{1}][date_compare_mode]">
							<option value="userrange"<?php $this->set_selected($values['date_compare_mode'], "userrange"); ?>><?php _e("Post Meta must be within input range", $this->plugin_slug); ?></option>
							<option value="metarange"<?php $this->set_selected($values['date_compare_mode'], "metarange"); ?>><?php _e("Input must be within the Post Meta range", $this->plugin_slug); ?></option>
							<option value="overlap"<?php $this->set_selected($values['date_compare_mode'], "overlap"); ?>><?php _e("Input overlaps any of the Post Meta range", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p><div class="clear"></div>
				<hr />
				
				<div class="clear"></div>
				<div class="item-container">
					<p>
					<label for="{0}[{1}][date_input_format]"><?php _e("Date Input Format ", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the format the date is saved in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select name="{0}[{1}][date_input_format]" class="" id="{0}[{1}][date_input_format]">
							<option value="timestamp"<?php $this->set_selected($values['date_input_format'], "timestamp"); ?>><?php _e("Timestamp", $this->plugin_slug); ?></option>
							<option value="yyyymmdd"<?php $this->set_selected($values['date_input_format'], "yyyymmdd"); ?>><?php _e("YYYYMMDD (ACF)", $this->plugin_slug); ?></option>
						</select>
					</label>
					</p>
					
					
					<!--<p>
						<label for="{0}[{1}][placeholder]"><?php _e("Placeholder text", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text that appears in the date field before a selection has been made", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br /><input class="" id="{0}[{1}][placeholder]" name="{0}[{1}][placeholder]" type="text" value="<?php /* echo esc_attr($values['placeholder']);*/ ?>"></label>
					</p>-->
					
				</div>
				
				<div class="item-container" style="padding-right:0;">
					<p>
						<?php _e("Date Display Format", $this->plugin_slug); ?>
					</p>
					<p>
					<?php
						$format = array();
						$format[0] = "d/m/Y";
						$format[1] = "m/d/Y";
						$format[2] = "Y/m/d";
						
						$formati = 0;
						
						
					?>
						<label for="{0}[{1}][date_output_format][0]"><input data-radio-checked="<?php echo ($values['date_output_format']==$format[0]) ? 1 : 0 ?>" class="date_format_radio" id="{0}[{1}][date_output_format][0]" name="{0}[{1}][date_output_format]" type="radio" value="<?php echo $format[0] ?>"<?php echo $this->set_radio($values['date_output_format'], $format[0]); ?>><?php echo date($format[0]) ?></label><br />
						<label for="{0}[{1}][date_output_format][1]"><input data-radio-checked="<?php echo ($values['date_output_format']==$format[1]) ? 1 : 0 ?>" class="date_format_radio" id="{0}[{1}][date_output_format][1]" name="{0}[{1}][date_output_format]" type="radio" value="<?php echo $format[1] ?>"<?php echo $this->set_radio($values['date_output_format'], $format[1]); ?>><?php echo date($format[1]) ?></label><br />
						<label for="{0}[{1}][date_output_format][2]"><input data-radio-checked="<?php echo ($values['date_output_format']==$format[2]) ? 1 : 0 ?>" class="date_format_radio" id="{0}[{1}][date_output_format][2]" name="{0}[{1}][date_output_format]" type="radio" value="<?php echo $format[2] ?>"<?php echo $this->set_radio($values['date_output_format'], $format[2]); ?>><?php echo date($format[2]) ?></label><br />
						<!--<label for="{0}[{1}][date_output_format]"><input class="" id="{0}[{1}][date_output_format]" name="{0}[{1}][date_output_format]" type="radio"> Custom: <input type="text" size="10" /></label>-->
					</p>
				</div>
				<div class="clear"></div>
				<hr />
				<p style="margin-bottom:0;"><strong><?php _e("UI Options", $this->plugin_slug); ?></strong>
				

				<fieldset class="item-container child-columns">
					
					<p class="sf_range_min">
						<label for="{0}[{1}][date_from_prefix]">
							<?php _e("From Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear before the From field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_from_prefix]" name="{0}[{1}][date_from_prefix]" type="text" size="7" value="<?php echo esc_attr($values['date_from_prefix']); ?>">
						</label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][date_from_postfix]">
							<?php _e("From Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear after the From field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_from_postfix]" name="{0}[{1}][date_from_postfix]" type="text" size="7" value="<?php echo esc_attr($values['date_from_postfix']); ?>">
						</label>
					</p>
					<p class="sf_range_step">
						<label for="{0}[{1}][date_from_placeholder]">
							<?php _e("From Placeholder", $this->plugin_slug); ?><br />
							<input class="" id="{0}[{1}][date_from_placeholder]" name="{0}[{1}][date_from_placeholder]" type="text" size="7" value="<?php echo esc_attr($values['date_from_placeholder']); ?>">
						</label>
					</p>
				</fieldset>
				
				<fieldset class="item-container child-columns sf_date_end_meta_key">
					<p class="sf_range_min">
						<label for="{0}[{1}][date_to_prefix]">
							<?php _e("To Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear before the To field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_to_prefix]" name="{0}[{1}][date_to_prefix]" type="text" size="7" value="<?php echo esc_attr($values['date_to_prefix']); ?>">
						</label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][date_to_postfix]">
							<?php _e("To Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear after the To field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_to_postfix]" name="{0}[{1}][date_to_postfix]" type="text" size="7" value="<?php echo esc_attr($values['date_to_postfix']); ?>">
						</label>
					</p>
					<p class="sf_range_step">
						<label for="{0}[{1}][date_to_placeholder]">
							<?php _e("To Placeholder", $this->plugin_slug); ?><br />
							<input class="" id="{0}[{1}][date_to_placeholder]" name="{0}[{1}][date_to_placeholder]" type="text" size="7" value="<?php echo esc_attr($values['date_to_placeholder']); ?>">
						</label>
					</p>
				</fieldset>
				<br class="clear" />
				<p class="item-container" style="">
					
					
					<input class="checkbox" type="checkbox" id="{0}[{1}][date_use_dropdown_year]" name="{0}[{1}][date_use_dropdown_year]"<?php $this->set_checked($values['date_use_dropdown_year']); ?>>
					<label for="{0}[{1}][date_use_dropdown_year]"><?php _e("Use dropdown for Year", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Add dropdown for Year", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />
					
					<input class="checkbox " type="checkbox" id="{0}[{1}][date_use_dropdown_month]" name="{0}[{1}][date_use_dropdown_month]"<?php $this->set_checked($values['date_use_dropdown_month']); ?>>
					<label for="{0}[{1}][date_use_dropdown_month]"><?php _e("Use dropdown for month", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Add dropdown for month", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>

				<!--<p class="item-container" style="padding-right:0;">
					
					
					<input class="checkbox" type="checkbox" id="{0}[{1}][combo_box]" name="{0}[{1}][combo_box]"<?php $this->set_checked($values['combo_box']); ?>>
					<label for="{0}[{1}][combo_box]"><?php _e("Use dropdown for Year", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Add dropdown for Year", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label><br />
					
					<input class="checkbox " type="checkbox" id="{0}[{1}][show_count]" name="{0}[{1}][show_count]"<?php $this->set_checked($values['show_count']); ?>>
					<label for="{0}[{1}][show_count]"><?php _e("Use dropdown for month", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Add dropdown for month", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
				</p>-->

				<br class="clear" />
				
				
				<div class="clear"></div>