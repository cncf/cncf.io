<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="widget">
	<div class="widget-top">
		<div class="widget-title-action">
            <a class="widget-control-edit hide-if-js">
                <span class="edit">Edit</span>
                <span class="add">Add</span>
                <span class="screen-reader-text">Search Field</span>
            </a>
		</div>

		<div class="widget-title">
			<h4><?php _e("Search", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		<div class="widget-content">
		
			<p class="item-container">
				<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" data-field-template-id="{0}[{1}][heading]" data-field-template-name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
			</p>
			<p class="item-container">
				<label for="{0}[{1}][placeholder]"><?php _e("Placeholder text", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text that appears in the search box before the use starts typing", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br /><input class="" data-field-template-id="{0}[{1}][placeholder]" data-field-template-name="{0}[{1}][placeholder]" type="text" value="<?php echo esc_attr($values['placeholder']); ?>"></label>
			</p>
			<p class="item-container sf_accessibility_label">
				<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
				<input class="" data-field-template-id="{0}[{1}][accessibility_label]" data-field-template-name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
			</p>
			<div class="clear"></div>
		</div>
		
		<input type="hidden" data-field-template-name="{0}[{1}][type]" class="widget-id" value="<?php echo $values['type']; ?>">
		
		<br class="clear" />
		
		<div class="widget-control-actions">
			<div class="alignleft">
				<a class="widget-control-remove" href="#remove"><?php _e("Delete", $this->plugin_slug); ?></a> |
				<a class="widget-control-close" href="#close"><?php _e("Close", $this->plugin_slug); ?></a>
			</div>
			<br class="clear">
		</div>
	</div>
	<div class="widget-description">
		<?php _e("Add a Search Field to your form", $this->plugin_slug); ?>
	</div>
</div>