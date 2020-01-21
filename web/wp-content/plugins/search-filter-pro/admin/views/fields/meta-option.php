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
<li class='meta-option-item<?php echo $class; ?>'>
	<fieldset>
		<p class='item-container slimmove' style="width:20px">
			<img src="<?php echo plugins_url( 'admin/assets/img/move-ico.svg', SEARCH_FILTER_PRO_BASE_PATH); ?>" />
		</p>
		<p class='item-container slim'>
			<label for="{0}[{1}][meta_options][{2}][option_value]">
				<span><?php _e("Option Value", $this->plugin_slug); ?><br /></span>
				<input type='text' name='{0}[{1}][meta_options][{2}][option_value]' data-field-template-id='{0}[{1}][meta_options][{2}][option_value]' value='<?php echo esc_attr($values['option_value']); ?>' />
			</label>
		</p>
		<p class='item-container slim'>
			<label for="{0}[{1}][meta_options][{2}][option_label]">
				<span><?php _e("Option Label", $this->plugin_slug); ?><br /></span>
				<input type='text' name='{0}[{1}][meta_options][{2}][option_label]' data-field-template-id='{0}[{1}][meta_options][{2}][option_label]' value='<?php echo esc_attr($values['option_label']); ?>' />
			</label>
		</p>

		<div class="clear"></div>
	</fieldset>
	<div class="clear"></div>
	<p class="meta-option-controls">
		<a href="#" class="widget-control-option-remove"><?php _e("Remove", $this->plugin_slug); ?></a>
	</p>

	<div class="clear"></div>
</li>