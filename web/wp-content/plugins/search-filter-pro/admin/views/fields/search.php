<?php
/**
 * Represents the view for the administration settings dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Plugin_Name
 * @author    Your Name <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */
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
				<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][heading]" name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
			</p>
			<p class="item-container">
				<label for="{0}[{1}][placeholder]"><?php _e("Placeholder text", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("text that appears in the search box before the use starts typing", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br /><input class="" id="{0}[{1}][placeholder]" name="{0}[{1}][placeholder]" type="text" value="<?php echo esc_attr($values['placeholder']); ?>"></label>
			</p>
			<p class="item-container sf_accessibility_label">
				<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
				<input class="" id="{0}[{1}][accessibility_label]" name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
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
		<?php _e("Add a Search Field to your form", $this->plugin_slug); ?>
	</div>
</div>