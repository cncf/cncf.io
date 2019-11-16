
			
				<p class="item-container sf_number_input_type">
					<label for="{0}[{1}][number_input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
						<select name="{0}[{1}][number_input_type]" class="" id="{0}[{1}][number_input_type]">
							<!--<option value="number-slider"<?php $this->set_selected($values['number_input_type'], "number-slider"); ?>><?php _e("Slider", $this->plugin_slug); ?></option>
							<option value="number-number"<?php $this->set_selected($values['number_input_type'], "number-number"); ?>><?php _e("Number", $this->plugin_slug); ?></option>
							<option value="number-select"<?php $this->set_selected($values['number_input_type'], "number-select"); ?>><?php _e("Dropdown", $this->plugin_slug); ?></option>
							<option value="number-checkbox"<?php $this->set_selected($values['number_input_type'], "number-checkbox"); ?>><?php _e("Checkbox", $this->plugin_slug); ?></option>
							<option value="number-radio"<?php $this->set_selected($values['number_input_type'], "number-radio"); ?>><?php _e("Radio", $this->plugin_slug); ?></option>-->
							<option value="range-slider"<?php $this->set_selected($values['number_input_type'], "range-slider"); ?>><?php _e("Range - Slider", $this->plugin_slug); ?></option>
							<option value="range-number"<?php $this->set_selected($values['number_input_type'], "range-number"); ?>><?php _e("Range - Number", $this->plugin_slug); ?></option>
							<option value="range-select"<?php $this->set_selected($values['number_input_type'], "range-select"); ?>><?php _e("Range - Dropdown", $this->plugin_slug); ?></option>
							<option value="range-radio"<?php $this->set_selected($values['number_input_type'], "range-radio"); ?>><?php _e("Range - Radio", $this->plugin_slug); ?></option>
							<!--<option value="range-checkbox"<?php $this->set_selected($values['number_input_type'], "range-checkbox"); ?>><?php _e("Range - Checkbox", $this->plugin_slug); ?></option>-->
						</select>
					</label>
				</p>
				<p class="item-container" style="padding-right:0;">
					<label for="{0}[{1}][number_heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][number_heading]" name="{0}[{1}][number_heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				
				<div class="clear"></div>
				
				<div class="item-container">
					<p class="sf_display_input_as">
						<label for="{0}[{1}][number_display_input_as]"><?php _e("Display input as", $this->plugin_slug); ?><br />
							<select name="{0}[{1}][number_display_input_as]" class="" id="{0}[{1}][number_display_input_as]">
								<option value="singlefield"<?php $this->set_selected($values['number_display_input_as'], "singlefield"); ?>><?php _e("Single Field", $this->plugin_slug); ?></option>
								<option value="fromtofields"<?php $this->set_selected($values['number_display_input_as'], "fromtofields"); ?>><?php _e("From / To Fields", $this->plugin_slug); ?></option>
							</select>
						</label>
					</p>
					
					<p class="sf_display_values_as">
						<label for="{0}[{1}][number_display_values_as]"><?php _e("Display values as", $this->plugin_slug); ?><br />
							<select name="{0}[{1}][number_display_values_as]" class="" id="{0}[{1}][number_display_values_as]">
								<option value="textinput"<?php $this->set_selected($values['number_display_values_as'], "textinput"); ?>><?php _e("Input Field", $this->plugin_slug); ?></option>
								<!--<option value="select"<?php $this->set_selected($values['number_display_values_as'], "select"); ?>><?php _e("Dropdown", $this->plugin_slug); ?></option>-->
								<option value="text"<?php $this->set_selected($values['number_display_values_as'], "text"); ?>><?php _e("Plain Text", $this->plugin_slug); ?></option>
							</select>
						</label>
					</p>
				</div>
				
				<p class="sf_all_items_label_number item-container" style="padding-right:0;">
					<label for="{0}[{1}][all_items_label_number]"><?php _e("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("override the default - e.g. &quot;All Items&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" id="{0}[{1}][all_items_label_number]" name="{0}[{1}][all_items_label_number]" type="text" value="<?php echo esc_attr($values['all_items_label_number']); ?>"></label>
				</p>
				
				<p class="sf_accessibility_label item-container">
					<label for="{0}[{1}][number_accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" id="{0}[{1}][number_accessibility_label]" name="{0}[{1}][number_accessibility_label]" type="text" value="<?php echo esc_attr($values['number_accessibility_label']); ?>"></label>
				</p>
				
				<div class="clear"></div>
				<hr />
				<p><strong><?php _e("Meta Key", $this->plugin_slug); ?></strong></p>
				<p style="padding-bottom:0;margin-bottom:0;">
					<em><?php _e("Choose the min / max key names to be used for comparison.", $this->plugin_slug); ?></em>
				</p>
				<p class="item-container sf_meta_keys">
					<label for="{0}[{1}][number_start_meta_key]">
						<?php _e("Start Meta Key", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("choose a meta key for this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="{0}[{1}][number_start_meta_key]" class="meta_key start_meta_key" id="{0}[{1}][number_start_meta_key]">';
							
							foreach($all_meta_keys as $v){
								//$data[] = $v->meta_key;
								
								echo '<option value="'.$v.'"'.$this->set_selected($values['number_start_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select>';
							
						?>
						<input type="hidden"  name="{0}[{1}][number_start_meta_key]" id="{0}[{1}][number_start_meta_key]" class="meta_key_hidden"  value="<?php echo esc_attr($values['number_start_meta_key']); ?>" disabled="disabled" />
					</label>
				</p>
				
				<p class="item-container sf_meta_keys sf_end_meta_key" style="padding-right:0;">
					<label for="{0}[{1}][number_use_same_toggle]">
						<input class="checkbox use_same_toggle number_use_same_toggle" type="checkbox" id="{0}[{1}][number_use_same_toggle]" name="{0}[{1}][number_use_same_toggle]"<?php $this->set_checked($values['number_use_same_toggle']); ?>> 
						<?php _e("Use same for End Key?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Tick this box to use the same option from the Start Meta Key", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					</label>
					<label for="{0}[{1}][number_end_meta_key]">	
						
						<?php
							$all_meta_keys = $this->get_all_post_meta_keys();
							echo '<select name="{0}[{1}][number_end_meta_key]" class="meta_key end_meta_key" id="{0}[{1}][number_end_meta_key]">';
							
							foreach($all_meta_keys as $v){
								//$data[] = $v->meta_key;
								
								echo '<option value="'.$v.'"'.$this->set_selected($values['number_end_meta_key'], $v, false).'>'.$v."</option>";
							}
							echo '</select>';
							
						?>
						<input type="hidden"  name="{0}[{1}][number_end_meta_key]" id="{0}[{1}][number_end_meta_key]" class="meta_key_hidden"  value="<?php echo esc_attr($values['meta_key']); ?>" disabled="disabled" />
					</label>
				</p><div class="clear"></div>
				<p class="sf_compare_mode">
					<label for="{0}[{1}][number_compare_mode]"><?php _e("Compare Mode ", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the format the date is saved in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<select name="{0}[{1}][number_compare_mode]" class="" id="{0}[{1}][number_compare_mode]">
							<option value="userrange"<?php $this->set_selected($values['number_compare_mode'], "userrange"); ?>><?php _e("Post Meta must be within input range", $this->plugin_slug); ?></option>
							<option value="metarange"<?php $this->set_selected($values['number_compare_mode'], "metarange"); ?>><?php _e("Input must be within the Post Meta range", $this->plugin_slug); ?></option>
							<option value="overlap"<?php $this->set_selected($values['number_compare_mode'], "overlap"); ?>><?php _e("Input overlaps any of the Post Meta range", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p><div class="clear"></div>
				
				
				
				<p>
					<input class="checkbox number_is_decimal" type="checkbox" id="{0}[{1}][number_is_decimal]" name="{0}[{1}][number_is_decimal]"<?php $this->set_checked($values['number_is_decimal']); ?>>
					<label for="{0}[{1}][number_is_decimal]"><?php _e("Data is decimal?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("use this option if you are filtering things like currencies", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					<br />
					<label for="{0}[{1}][number_decimal_places]">
						<input class="number_decimal_places" id="{0}[{1}][number_decimal_places]" name="{0}[{1}][number_decimal_places]" type="text" size="7" value="<?php echo esc_attr($values['number_decimal_places']); ?>"> <?php _e("Decimal Places - this is used internally to perform accurate database queries", $this->plugin_slug); ?></label>
					</label>
				</p>
				<div class="clear"></div>
				<hr />
				
				<div class="clear"></div>
				<p style="margin-bottom:0;"><strong><?php _e("UI Options", $this->plugin_slug); ?></strong>
				
				<fieldset class="item-container child-columns-w">
					
					<p class="sf_range_min">
						<label for="{0}[{1}][range_min]">
							<?php _e("Min Value", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the lowest value that a user can select", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<?php
								
								$range_min = "";
								if($values['range_min_detect']!=1)
								{
									$range_min = $values['range_min'];
								}
							
							?>
							<input class="range_min" id="{0}[{1}][range_min]" name="{0}[{1}][range_min]" type="text" size="7" value="<?php echo $range_min; ?>">
						</label>
						<br />
						<input class="checkbox range_min_detect" type="checkbox" id="{0}[{1}][range_min_detect]" name="{0}[{1}][range_min_detect]"<?php $this->set_checked($values['range_min_detect']); ?>>
						<label for="{0}[{1}][range_min_detect]"><?php _e("Auto Detect?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("set the min based on the lowest value in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][range_max]">
							<?php _e("Max Value", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the highest value that a user can select", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<?php
								
								$range_max = "";
								if($values['range_max_detect']!=1)
								{
									$range_max = $values['range_max'];
								}
							
							?>
							<input class="range_max" id="{0}[{1}][range_max]" name="{0}[{1}][range_max]" type="text" size="7" value="<?php echo $range_max; ?>">
						</label>
						<br />
						<input class="checkbox range_max_detect" type="checkbox" id="{0}[{1}][range_max_detect]" name="{0}[{1}][range_max_detect]"<?php $this->set_checked($values['range_max_detect']); ?>>
						<label for="{0}[{1}][range_max_detect]"><?php _e("Auto Detect?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("set the max based on the highest value in the database", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</p>
					
				</fieldset>
				<fieldset class="item-container child-columns-w">
					<p class="sf_range_step">
						<label for="{0}[{1}][range_step]">
							<?php _e("Step", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the increment amount", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][range_step]" name="{0}[{1}][range_step]" type="text" size="7" value="<?php echo esc_attr($values['range_step']); ?>">
						</label>
					</p>
				</fieldset>
				<div class="clear"></div>
				
				
				<fieldset class="item-container child-columns-w">
					<p class="sf_range_value_prefix">
						<label for="{0}[{1}][range_value_prefix]">
							<?php _e("Value Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear before a value  - such as a currency symbol - &dollar;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][range_value_prefix]" name="{0}[{1}][range_value_prefix]" type="text" size="7" value="<?php echo esc_attr($values['range_value_prefix']); ?>">
						</label>
					</p>
					
					<p class="sf_range_value_postfix">
						<label for="{0}[{1}][range_value_postfix]">
							<?php _e("Value Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear after a value  - such as a currency symbol - &euro;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][range_value_postfix]" name="{0}[{1}][range_value_postfix]" type="text" size="7" value="<?php echo esc_attr($values['range_value_postfix']); ?>">
						</label>
					</p>
				</fieldset>
				<fieldset class="item-container child-columns-w">
					
					<p class="">
						<label for="{0}[{1}][number_values_seperator]">
							<?php _e("Values Seperator", $this->plugin_slug); ?>
							<input class="" id="{0}[{1}][number_values_seperator]" name="{0}[{1}][number_values_seperator]" type="text" size="7" value="<?php echo esc_attr($values['number_values_seperator']); ?>">
						</label>
					</p>
				</fieldset>
				
				<div class="clear"></div>
				<fieldset class="item-container child-columns-w sf_number_formatting">
					<p class="">
						<label for="{0}[{1}][decimal_places]">
							<?php _e("Decimal Places", $this->plugin_slug); ?>
							<input class="" id="{0}[{1}][decimal_places]" name="{0}[{1}][decimal_places]" type="text" size="7" value="<?php echo esc_attr($values['decimal_places']); ?>">
						</label>
					</p>
					<p class="">
						<label for="{0}[{1}][thousand_seperator]">
							<?php _e("Thousands Seperator", $this->plugin_slug); ?>
							<input class="" id="{0}[{1}][thousand_seperator]" name="{0}[{1}][thousand_seperator]" type="text" size="7" value="<?php echo esc_attr($values['thousand_seperator']); ?>">
						</label>
					</p>
					<p class="">

					</p>
				</fieldset>
                <fieldset class="item-container child-columns-w sf_number_formatting">

                    <p class="">
                        <label for="{0}[{1}][decimal_seperator]">
                            <?php _e("Decimal Seperator", $this->plugin_slug); ?>
                            <input class="" id="{0}[{1}][decimal_seperator]" name="{0}[{1}][decimal_seperator]" type="text" size="7" value="<?php echo esc_attr($values['decimal_seperator']); ?>">
                        </label>
                    </p>
                </fieldset>
				
				
				
				
				<br class="clear" />