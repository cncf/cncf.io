<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="widget" data-field-type="<?php echo esc_attr( $values['type'] ); ?>">
	<div class="widget-top">
        <div class="widget-title-action">
            <a class="widget-control-edit hide-if-js">
                <span class="edit">Edit</span>
                <span class="add">Add</span>
                <span class="screen-reader-text">Post Meta Field</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php echo esc_html__("Post Meta", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
	
		<div class="widget-content" style="position:relative;">
			
			<p><?php echo esc_html__("Choose from displaying the field as numerical data, choice input or date picker.", $this->plugin_slug); ?><br /></p>
			
			<div class="tab-header sf_meta_type">
				<label for="{0}[{1}][meta_type][0]" class="active"><input data-radio-checked="<?php echo ($values['meta_type']=="number") ? 1 : 0 ?>" class="meta_type_radio" data-field-template-id="{0}[{1}][meta_type][0]" data-field-template-name="{0}[{1}][meta_type]" type="radio" value="number"<?php $this->set_radio($values['meta_type'], 'number'); ?>><?php echo esc_html__("Number", $this->plugin_slug); ?></label> 
				<label for="{0}[{1}][meta_type][1]"><input data-radio-checked="<?php echo ($values['meta_type']=="choice") ? 1 : 0 ?>" class="meta_type_radio" data-field-template-id="{0}[{1}][meta_type][1]" data-field-template-name="{0}[{1}][meta_type]" type="radio" value="choice"<?php $this->set_radio($values['meta_type'], 'choice'); ?>><?php echo esc_html__("Choice", $this->plugin_slug); ?></label>
				<label for="{0}[{1}][meta_type][2]"><input data-radio-checked="<?php echo ($values['meta_type']=="date") ? 1 : 0 ?>" class="meta_type_radio" data-field-template-id="{0}[{1}][meta_type][2]" data-field-template-name="{0}[{1}][meta_type]" type="radio" value="date"<?php $this->set_radio($values['meta_type'], 'date'); ?>><?php echo esc_html__("Date", $this->plugin_slug); ?></label>
			</div>
			<br class="clear" />
			
			<div class="sf_field_data sf_number" data-number-is-range="">
				<?php //echo plugin_dir_path( dirname( __FILE__ ) ) ;
				include( ( plugin_dir_path( dirname( __FILE__ ) ) ) . 'fields/post-meta/number.php' ); ?>
			
			</div>
			
			<div class="sf_field_data sf_choice">
				
				<?php include( ( plugin_dir_path( dirname( __FILE__ ) ) ) . 'fields/post-meta/choice.php' ); ?>
				
			</div>
			
			<div class="sf_field_data sf_date">
				
				<?php include( ( plugin_dir_path( dirname( __FILE__ ) ) ) . 'fields/post-meta/date.php' ); ?>
				
				
			</div>
			<div class="clear"></div>
			
		</div>
		<br class="clear" />
		
		<input type="hidden" data-field-template-name="{0}[{1}][type]" class="widget-id" value="<?php echo esc_attr($values['type']); ?>" />
		

		<div class="widget-control-actions">
			<div class="alignleft">
				<a class="widget-control-remove" href="#remove"><?php echo esc_html__("Delete", $this->plugin_slug); ?></a> |
				<a class="widget-control-close" href="#close"><?php echo esc_html__("Close", $this->plugin_slug); ?></a>
			</div>
			<br class="clear" />
		</div>

	</div>
	<div class="widget-description">
		<?php echo esc_html__("Add a Post Meta Field to your form", $this->plugin_slug); ?>
	</div>
</div>