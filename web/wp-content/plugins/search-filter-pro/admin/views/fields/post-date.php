<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="widget" data-field-type="<?php echo esc_attr($values['type']); ?>">
	<div class="widget-top">
        <div class="widget-title-action">
            <a class="widget-control-edit hide-if-js">
                <span class="edit">Edit</span>
                <span class="add">Add</span>
                <span class="screen-reader-text">Post Date Field</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php _e("Post Date", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		<div class="widget-content" style="position:relative;">
			
			<fieldset class="item-container">
				<p class="sf_input_type">
					<label for="{0}[{1}][input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
						<select name="{0}[{1}][input_type]" class="" id="{0}[{1}][input_type]">
							<option value="date"<?php $this->set_selected($values['input_type'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
							<option value="daterange"<?php $this->set_selected($values['input_type'], "daterange"); ?>><?php _e("Date Range", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p>
					<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][heading]" name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				<p class="sf_accessibility_label">
						<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="" id="{0}[{1}][accessibility_label]" name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
					</p>
			</fieldset>
			<fieldset class="item-container">
				<p>
					<?php _e("Date Format", $this->plugin_slug); ?>
				</p>
				<p>
				<?php
					$format = array();
					$format[0] = "d/m/Y";
					$format[1] = "m/d/Y";
					$format[2] = "Y/m/d";
					
					$formati = 0;
					foreach($format as $aformat)
					{
						if($values['date_format'] == $aformat)
						{
							echo '<input type="hidden" disabled="disabled" class="date_format_hidden" value="'.$formati.'" id="{0}[{1}][date_format_hidden]" name="{0}[{1}][date_format_hidden]" />';
						}
						
						$formati++;
					}
					
				?>
					
					
					<label for="{0}[{1}][date_format][0]"><input class="date_format_radio" id="{0}[{1}][date_format][0]" name="{0}[{1}][date_format]" type="radio" value="<?php echo $format[0] ?>"<?php echo $this->set_radio($values['date_format'], $format[0]); ?>><?php echo date($format[0]) ?></label><br />
					<label for="{0}[{1}][date_format][1]"><input class="date_format_radio" id="{0}[{1}][date_format][1]" name="{0}[{1}][date_format]" type="radio" value="<?php echo $format[1] ?>"<?php echo $this->set_radio($values['date_format'], $format[1]); ?>><?php echo date($format[1]) ?></label><br />
					<label for="{0}[{1}][date_format][2]"><input class="date_format_radio" id="{0}[{1}][date_format][2]" name="{0}[{1}][date_format]" type="radio" value="<?php echo $format[2] ?>"<?php echo $this->set_radio($values['date_format'], $format[2]); ?>><?php echo date($format[2]) ?></label><br />
					<!--<label for="{0}[{1}][date_format]"><input class="" id="{0}[{1}][date_format]" name="{0}[{1}][date_format]" type="radio"> Custom: <input type="text" size="10" /></label>-->
				</p>
			</fieldset>
			<div class="clear"></div>
				<hr />
				<p style="margin-bottom:0;"><strong><?php _e("UI Options", $this->plugin_slug); ?></strong> <span class="hint--top hint--info" data-hint="<?php _e("choose a meta key for this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></p>
				

				<fieldset class="item-container child-columns">
					
					<p class="sf_range_min">
						<label for="{0}[{1}][date_from_prefix]">
							<?php _e("From Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear before the From field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_from_prefix]" name="{0}[{1}][date_from_prefix]" type="text" size="7" value="<?php echo $values['date_from_prefix']; ?>">
						</label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][date_from_postfix]">
							<?php _e("From Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear after the From field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_from_postfix]" name="{0}[{1}][date_from_postfix]" type="text" size="7" value="<?php echo $values['date_from_postfix']; ?>">
						</label>
					</p>
					<p class="sf_range_step">
						<label for="{0}[{1}][date_from_placeholder]">
							<?php _e("From Placeholder", $this->plugin_slug); ?><br />
							<input class="" id="{0}[{1}][date_from_placeholder]" name="{0}[{1}][date_from_placeholder]" type="text" size="7" value="<?php echo $values['date_from_placeholder']; ?>">
						</label>
					</p>
				</fieldset>
				
				<fieldset class="item-container child-columns sf_date_end_meta_key">
					<p class="sf_range_min">
						<label for="{0}[{1}][date_to_prefix]">
							<?php _e("To Prefix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear before the To field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_to_prefix]" name="{0}[{1}][date_to_prefix]" type="text" size="7" value="<?php echo $values['date_to_prefix']; ?>">
						</label>
					</p>
					<p class="sf_range_max">
						<label for="{0}[{1}][date_to_postfix]">
							<?php _e("To Postfix", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text to appear after the To field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<input class="" id="{0}[{1}][date_to_postfix]" name="{0}[{1}][date_to_postfix]" type="text" size="7" value="<?php echo $values['date_to_postfix']; ?>">
						</label>
					</p>
					<p class="sf_range_step">
						<label for="{0}[{1}][date_to_placeholder]">
							<?php _e("To Placeholder", $this->plugin_slug); ?><br />
							<input class="" id="{0}[{1}][date_to_placeholder]" name="{0}[{1}][date_to_placeholder]" type="text" size="7" value="<?php echo $values['date_to_placeholder']; ?>">
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
				

				<br class="clear" />
			
		</div>
		<br class="clear" />
		
		<input type="hidden" name="{0}[{1}][type]" class="widget-id" id="hidden_type" value="<?php echo esc_attr($values['type']); ?>" />
		

		<div class="widget-control-actions">
			<div class="alignleft">
				<a class="widget-control-remove" href="#remove"><?php _e("Delete", $this->plugin_slug); ?></a> |
				<a class="widget-control-close" href="#close"><?php _e("Close", $this->plugin_slug); ?></a>
			</div>
			<br class="clear">
		</div>
	</div>
	<div class="widget-description">
		<?php _e("Add a Post Date Field to your form", $this->plugin_slug); ?>
	</div>
</div>