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
<div class="widget" data-field-type="<?php echo $values['type']; ?>">
	<div class="widget-top">
        <div class="widget-title-action">
            <a class="widget-control-edit hide-if-js">
                <span class="edit">Edit</span>
                <span class="add">Add</span>
                <span class="screen-reader-text">Post Type Field</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php _e("Post Type", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		<!--<form action="" method="post">-->
			<div class="widget-content" style="position:relative;">

				<!--<a class="widget-control-advanced" href="#remove"><?php _e("Advanced settings", $this->plugin_slug); ?></a>-->
				
				<fieldset class="">
					<p class="sf_post_types">
						<?php _e("Post Types:", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("post types available to this field", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<?php _e("Any post types made available here must also be made available to the search form under <strong>Settings</strong> before a user will see them as options.", $this->plugin_slug); ?>
						<br /><br />
						<?php
							
							$args = array(
							   'public'   => true
							);
							
							$post_types = get_post_types( $args, 'objects' ); 
							
							$is_default = false;
							if(!is_array($values['post_types']))
							{
								$is_default = true;
								$values['post_types'] = array();
							}
							
							
							foreach ( $post_types as $post_type )
							{
								//if($post_type->name!="attachment")
								//{
									if($is_default)
									{
										$values['post_types'][$post_type->name] = "1";
									}
									else if(!isset($values['post_types'][$post_type->name]))
									{
										$values['post_types'][$post_type->name] = "";
									}
									
									?>
									
									<input class="checkbox" type="checkbox" id="{0}[{1}][post_types][<?php echo $post_type->name; ?>]" name="{0}[{1}][post_types][<?php echo $post_type->name; ?>]"<?php $this->set_checked($values['post_types'][$post_type->name]); ?>>
									<label for="{0}[{1}][post_types][<?php echo $post_type->name; ?>]"><?php _e($post_type->labels->name, $this->plugin_slug); ?></label>
									
									<?php
								//}
							}
						?>
						
					</p>
				</fieldset>
				<br class="clear" />
				<hr />
				<fieldset class="item-container">
					<p class="sf_input_type">
						<label for="{0}[{1}][input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
							<select name="{0}[{1}][input_type]" class="" id="{0}[{1}][input_type]">
								<option value="select"<?php $this->set_selected($values['input_type'], "select"); ?>><?php _e("Dropdown", $this->plugin_slug); ?></option>
								<option value="checkbox"<?php $this->set_selected($values['input_type'], "checkbox"); ?>><?php _e("Checkbox", $this->plugin_slug); ?></option>
								<option value="radio"<?php $this->set_selected($values['input_type'], "radio"); ?>><?php _e("Radio", $this->plugin_slug); ?></option>
								<option value="multiselect"<?php $this->set_selected($values['input_type'], "multiselect"); ?>><?php _e("Multi-select", $this->plugin_slug); ?></option>
							</select>
						</label>
					</p>

					<p>
						<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][heading]" name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
					</p>
					<p class="sf_all_items_label">
						<label for="{0}[{1}][all_items_label]"><?php _e("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("override the default - e.g. &quot;All Post Types&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="" id="{0}[{1}][all_items_label]" name="{0}[{1}][all_items_label]" type="text" value="<?php echo esc_attr($values['all_items_label']); ?>"></label>
					</p>
					<p class="sf_accessibility_label">
						<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="" id="{0}[{1}][accessibility_label]" name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
					</p>
				</fieldset>
                <fieldset class="item-container">
                    <br /><br />
                    <p class="sf_make_combobox" style="vertical-align: top;">
                        <input class="checkbox" type="checkbox" id="{0}[{1}][combo_box]" name="{0}[{1}][combo_box]"<?php $this->set_checked($values['combo_box']); ?> style="vertical-align: top;margin-top:2px;">
                        <label for="{0}[{1}][combo_box]" style="display:inline-block;">
			                <?php _e("Make Combobox?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("Allow for text input to find values, with autocomplete and dropdown suggest", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>
                            <br />
                            <span class="sf_combobox_message" style="padding-top:10px; display:inline-block;">

                                <input class="" id="{0}[{1}][no_results_message]" name="{0}[{1}][no_results_message]" type="text" value="<?php echo esc_attr($values['no_results_message']); ?>">
                                <br /><em><?php _e("No Matches message", $this->plugin_slug); ?></em>
                                <span class="hint--top hint--info" data-hint="<?php _e("This message is usually displayed when there are no matches in the list - leave blank for default", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span>

                            </span>
                        </label>
                    </p>
                </fieldset>
				
				<div class="clear"></div>
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
		<!--</form>-->
	</div>
	<div class="widget-description">
		<?php _e("Add a Post Type Field your form", $this->plugin_slug); ?>
	</div>
</div>