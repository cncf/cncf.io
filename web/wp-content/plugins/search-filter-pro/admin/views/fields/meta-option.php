<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class='meta-option-item<?php echo esc_attr( $class ); ?>'>
	<fieldset>
		<p class='item-container slimmove' style="width:20px">
			<img src="<?php echo esc_attr( plugins_url( 'admin/assets/img/move-ico.svg', SEARCH_FILTER_PRO_BASE_PATH) ); ?>" />
		</p>
		<p class='item-container slim'>
			<label for="{0}[{1}][meta_options][{2}][option_value]">
				<span><?php echo esc_html__("Option Value", $this->plugin_slug); ?><br /></span>
				<input type='text' name='{0}[{1}][meta_options][{2}][option_value]' data-field-template-id='{0}[{1}][meta_options][{2}][option_value]' value='<?php echo esc_attr($values['option_value']); ?>' />
			</label>
		</p>
		<p class='item-container slim'>
			<label for="{0}[{1}][meta_options][{2}][option_label]">
				<span><?php echo esc_html__("Option Label", $this->plugin_slug); ?><br /></span>
				<input type='text' name='{0}[{1}][meta_options][{2}][option_label]' data-field-template-id='{0}[{1}][meta_options][{2}][option_label]' value='<?php echo esc_attr($values['option_label']); ?>' />
			</label>
		</p>

		<div class="clear"></div>
	</fieldset>
	<div class="clear"></div>
	<p class="meta-option-controls">
		<a href="#" class="widget-control-option-remove"><?php echo esc_html__("Remove", $this->plugin_slug); ?></a>
	</p>

	<div class="clear"></div>
</li>