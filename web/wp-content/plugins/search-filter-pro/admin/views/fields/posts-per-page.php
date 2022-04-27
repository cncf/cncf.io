<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="widget" data-field-type="<?php echo $values['type']; ?>">
	
	<div class="widget-top">
        <div class="widget-title-action">
            <a class="widget-control-edit hide-if-js">
                <span class="edit">Edit</span>
                <span class="add">Add</span>
                <span class="screen-reader-text">Posts Per Page Field</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php _e("Posts Per Page", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		
		<div class="widget-content" style="position:relative;">
			<p>
				<em><?php _e("Add a field allowing your users to change how many results are displayed per page.", $this->plugin_slug); ?></em>
			</p>
			<fieldset class="item-container">
						
				<p class="sf_input_type">
					<label for="{0}[{1}][input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
						<select data-field-template-name="{0}[{1}][input_type]" class="" data-field-template-id="{0}[{1}][input_type]">
							<option value="select"<?php $this->set_selected($values['input_type'], "select"); ?>><?php _e("Dropdown", $this->plugin_slug); ?></option>
							<option value="radio"<?php $this->set_selected($values['input_type'], "radio"); ?>><?php _e("Radio", $this->plugin_slug); ?></option>
						</select>
					</label>
				</p>
				<p class="">
					<label for="{0}[{1}][all_items_label]"><?php _e("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("override the default - e.g. &quot;Sort Results By&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" data-field-template-id="{0}[{1}][all_items_label]" data-field-template-name="{0}[{1}][all_items_label]" type="text" value="<?php echo esc_attr($values['all_items_label']); ?>"></label>
				</p>				
			</fieldset>
			
			<fieldset class="item-container">
				
				<p class="">
					<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" data-field-template-id="{0}[{1}][heading]" data-field-template-name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
				</p>
				
				<p class="sf_accessibility_label">
					<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
					<input class="" data-field-template-id="{0}[{1}][accessibility_label]" data-field-template-name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
				</p>
			</fieldset>
			<div class="clear"></div>
			<hr />
			
			<fieldset class="item-container child-columns-w">
					
				<p class="sf_range_min">
					<label for="{0}[{1}][ppp_min]">
						<?php _e("Min Value", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the lowest value that a user can select", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="ppp_min" data-field-template-id="{0}[{1}][ppp_min]" data-field-template-name="{0}[{1}][ppp_min]" type="text" size="7" value="<?php echo esc_attr($values['ppp_min']); ?>">
					</label>
				</p>
				
				<p class="sf_range_max">
					<label for="{0}[{1}][ppp_max]">
						<?php _e("Max Value", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the highest value that a user can select", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="ppp_max" data-field-template-id="{0}[{1}][ppp_max]" data-field-template-name="{0}[{1}][ppp_max]" type="text" size="7" value="<?php echo esc_attr($values['ppp_max']); ?>">
					</label>
				</p>
				
			</fieldset>
			<fieldset class="item-container child-columns-w">
				<p class="sf_range_step">
					<label for="{0}[{1}][ppp_step]">
						<?php _e("Step", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("the increment amount", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="" data-field-template-id="{0}[{1}][ppp_step]" data-field-template-name="{0}[{1}][ppp_step]" type="text" size="7" value="<?php echo esc_attr($values['ppp_step']); ?>">
					</label>
				</p>
			</fieldset>
			<div class="clear"></div>
		</div>
		<br class="clear" />
		
		<input type="hidden" data-field-template-name="{0}[{1}][type]" class="widget-id" value="<?php echo $values['type']; ?>">
		
		<div class="widget-control-actions">
			<div class="alignleft">
				<a class="widget-control-remove" href="#remove"><?php _e("Delete", $this->plugin_slug); ?></a> |
				<a class="widget-control-close" href="#close"><?php _e("Close", $this->plugin_slug); ?></a>
			</div>
			
			<br class="clear">
		</div>

	</div>
	<div class="widget-description">
		<?php _e("Add a Sort Order Field to your form", $this->plugin_slug); ?>
	</div>
</div>