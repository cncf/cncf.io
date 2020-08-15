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
                <span class="screen-reader-text">Submit Button</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php _e("Submit Button", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		<div class="widget-content">
		
			<p class="item-container">
				<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][heading]" name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
			</p>
			<p class="item-container">
				<label for="{0}[{1}][label]"><?php _e("Submit label", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Text that appears on the button", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br /><input class="" id="{0}[{1}][label]" name="{0}[{1}][label]" type="text" value="<?php echo esc_attr($values['label']); ?>"></label>
			</p>
			<div class="clear"></div>
		</div>
		
		<input type="hidden" name="{0}[{1}][type]" class="widget-id" id="hidden_type" value="<?php echo $values['type']; ?>">
		
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
		<?php _e("Add a Submit Button to your form", $this->plugin_slug); ?>
	</div>
</div>