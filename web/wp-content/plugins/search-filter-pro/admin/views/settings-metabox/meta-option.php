<?php

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<li class="<?php echo $class; ?>">
	<table class="settings_post_meta">
		<tr>
			<td>
				<label for="settings_post_meta[{0}][meta_key]">
					<?php
						$all_meta_keys = $this->get_all_post_meta_keys();
						echo '<select name="settings_post_meta[{0}][meta_key]" class="meta_key" id="settings_post_meta[{0}][meta_key]" data-field-template-id="settings_post_meta[{0}][meta_key]" data-field-template-name="settings_post_meta[{0}][meta_key]">';
						
						foreach($all_meta_keys as $v){
							//$data[] = $v->meta_key;
							
							echo '<option value="'.$v.'"'.$this->set_selected($values['meta_key'], $v, false).'>'.$v."</option>";
						}
						echo '</select>';
						
					?>
					<input type="hidden"  name="{0}[{1}][meta_key]" id="{0}[{1}][meta_key]" class="meta_key_hidden"  value="<?php echo $values['meta_key']; ?>" disabled="disabled" data-field-template-id="settings_post_meta[{0}][meta_key]" data-field-template-name="settings_post_meta[{0}][meta_key]" />
				</label>
			</td>
			<td>
				<label for="settings_post_meta[{0}][meta_type]">
					<?php
						$all_meta_keys = $this->get_all_post_meta_keys();
						echo '<select name="settings_post_meta[{0}][meta_type]" class="meta_type" id="settings_post_meta[{0}][meta_type]" data-field-template-id="settings_post_meta[{0}][meta_type]" data-field-template-name="settings_post_meta[{0}][meta_type]">';
						
							echo '<option value="CHAR"'.$this->set_selected($values['meta_type'], "CHAR", false).'>char</option>';
							echo '<option value="NUMERIC"'.$this->set_selected($values['meta_type'], "NUMERIC", false).'>numeric</option>';
							//echo '<option value="BINARY"'.$this->set_selected($values['meta_type'], "BINARY", false).'>binary</option>';
							echo '<option value="DATE"'.$this->set_selected($values['meta_type'], "DATE", false).'>date</option>';
							//echo '<option value="TIME"'.$this->set_selected($values['meta_type'], "TIME", false).'>time</option>';
							echo '<option value="DATETIME"'.$this->set_selected($values['meta_type'], "DATETIME", false).'>datetime</option>';
							echo '<option value="TIMESTAMP"'.$this->set_selected($values['meta_type'], "TIMESTAMP", false).'>timestamp</option>';
							echo '<option value="DECIMAL"'.$this->set_selected($values['meta_type'], "DECIMAL", false).'>decimal</option>';
							//echo '<option value="SIGNED"'.$this->set_selected($values['meta_type'], "SIGNED", false).'>signed</option>';
							//echo '<option value="UNSIGNED"'.$this->set_selected($values['meta_type'], "UNSIGNED", false).'>unsigned</option>';
						echo '</select>';
						
					?>
					<input type="hidden" name="settings_post_meta[{0}][meta_type]" id="settings_post_meta[{0}][meta_type]" class="meta_type"  value="<?php echo $values['meta_type']; ?>" disabled="disabled" data-field-template-id="settings_post_meta[{0}][meta_type]" data-field-template-name="settings_post_meta[{0}][meta_type]" />
				</label>
			</td>
			<td>
				<label for="{0}[{1}][meta_compare]">
					<?php
						$all_meta_keys = $this->get_all_post_meta_keys();
						
						echo '<select name="settings_post_meta[{0}][meta_compare]" class="meta_compare" id="settings_post_meta[{0}][meta_compare]" data-field-template-id="settings_post_meta[{0}][meta_compare]" data-field-template-name="settings_post_meta[{0}][meta_compare]">';
						
							echo '<option value="e"'.$this->set_selected($values['meta_compare'], "e", false).' class="date-format-supported">= &nbsp;&nbsp;(equals)</option>';
							echo '<option value="ne"'.$this->set_selected($values['meta_compare'], "ne", false).' class="date-format-supported">!= &nbsp;(not equals)</option>';
							echo '<option value="lt"'.$this->set_selected($values['meta_compare'], "lt", false).' class="date-format-supported">&lt; &nbsp;&nbsp;(less than)</option>';
							echo '<option value="gt"'.$this->set_selected($values['meta_compare'], "gt", false).' class="date-format-supported">&gt; &nbsp;&nbsp;(greater than)</option>';
							echo '<option value="lte"'.$this->set_selected($values['meta_compare'], "lte", false).' class="date-format-supported">&lt;= &nbsp;&nbsp;(less than or equal)</option>';
							echo '<option value="gte"'.$this->set_selected($values['meta_compare'], "gte", false).' class="date-format-supported">&gt;= &nbsp;&nbsp;(greater than or equal)</option>';
							
							echo '<option value="LIKE"'.$this->set_selected($values['meta_compare'], "LIKE", false).'>like</option>';
							echo '<option value="NOT LIKE"'.$this->set_selected($values['meta_compare'], "NOT LIKE", false).'>not like</option>';
							//echo '<option value="IN"'.$this->set_selected($values['meta_compare'], "IN", false).'>in</option>';
							//echo '<option value="NOT IN"'.$this->set_selected($values['meta_compare'], "NOT IN", false).'>not in</option>';
							/* echo '<option value="BETWEEN"'.$this->set_selected($values['meta_compare'], "BETWEEN", false).'>between</option>'; */
							/* echo '<option value="NOT BETWEEN"'.$this->set_selected($values['meta_compare'], "NOT BETWEEN", false).'>not between</option>'; */
							echo '<option value="EXISTS"'.$this->set_selected($values['meta_compare'], "EXISTS", false).'>exists</option>';
							echo '<option value="NOT EXISTS"'.$this->set_selected($values['meta_compare'], "NOT EXISTS", false).'>not exists</option>';
							
						
						echo '</select>';
					?>
					<input type="hidden" name="settings_post_meta[{0}][meta_compare]" id="settings_post_meta[{0}][meta_compare]" class="meta_compare"  value="<?php echo $values['meta_compare']; ?>" disabled="disabled" data-field-template-id="settings_post_meta[{0}][meta_compare]" data-field-template-name="settings_post_meta[{0}][meta_compare]" />
				</label>
			</td>
			<td width="170">
				
				<div class="meta_value_c">
					<input type="text" name="settings_post_meta[{0}][meta_value]" id="settings_post_meta[{0}][meta_value]" class="meta_value"  value="<?php echo $values['meta_value']; ?>" data-field-template-id="settings_post_meta[{0}][meta_value]" data-field-template-name="settings_post_meta[{0}][meta_value]" />
				</div>
				
				
				<div class="meta_value_date_c">
					<input type="text" maxlength="8" name="settings_post_meta[{0}][meta_date_value_date]" placeholder="YYYYMMDD" id="settings_post_meta[{0}][meta_date_value_date]" class="meta_date_value_date"  value="<?php echo $values['meta_date_value_date']; ?>" data-field-template-id="settings_post_meta[{0}][meta_date_value_date]" data-field-template-name="settings_post_meta[{0}][meta_date_value_date]" />
					
					<br />
					<label for="settings_post_meta[{0}][meta_date_value_current_date]">
						<input type="checkbox" name="settings_post_meta[{0}][meta_date_value_current_date]" class="meta_date_value_current_date" id="settings_post_meta[{0}][meta_date_value_current_date]" data-field-template-id="settings_post_meta[{0}][meta_date_value_current_date]" data-field-template-name="settings_post_meta[{0}][meta_date_value_current_date]" <?php $this->set_checked($values['meta_date_value_current_date']); ?>>
						<?php echo __('Current Date', $this->plugin_slug); ?> 
						<span class="hint--top hint--info" data-hint="<?php _e("this meta query is always performed against the current date", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
					</label>
				</div>
				<div class="meta_value_timestamp_c">
					
					<input type="text" name="settings_post_meta[{0}][meta_date_value_timestamp]" placeholder="" id="settings_post_meta[{0}][meta_date_value_timestamp]" class="meta_date_value_timestamp"  value="<?php echo $values['meta_date_value_timestamp']; ?>" data-field-template-id="settings_post_meta[{0}][meta_date_value_timestamp]" data-field-template-name="settings_post_meta[{0}][meta_date_value_timestamp]" />
					
					<br />
					<label for="settings_post_meta[{0}][meta_date_value_current_timestamp]">
						<input type="checkbox" name="settings_post_meta[{0}][meta_date_value_current_timestamp]" class="meta_date_value_current_timestamp" id="settings_post_meta[{0}][meta_date_value_current_timestamp]" data-field-template-id="settings_post_meta[{0}][meta_date_value_current_timestamp]" data-field-template-name="settings_post_meta[{0}][meta_date_value_current_timestamp]" <?php $this->set_checked($values['meta_date_value_current_timestamp']); ?>>
						<?php echo __('Current Time', $this->plugin_slug); ?> 
						<span class="hint--top hint--info" data-hint="<?php _e("this meta query is always performed against the current time (NOW)", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
					</label>
				</div>
			</td>
			<td>
				<a href="#" class="option-remove">Remove</a>
			</td>
		</tr>
	</table>
</li>