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
<div class="widget" data-field-type="tag">
	<div class="widget-top">
        <div class="widget-title-action">
            <a class="widget-control-edit hide-if-js">
                <span class="edit">Edit</span>
                <span class="add">Add</span>
                <span class="screen-reader-text">Tag Field</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php _e("Tag", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		<!--<form action="" method="post">-->
			<div class="widget-content" style="position:relative;">

				<a class="widget-control-advanced" href="#remove"><?php _e("Advanced settings", $this->plugin_slug); ?></a>
				
				<fieldset class="item-container">
					<input type="hidden" name="{0}[{1}][taxonomy_name]" class="" id="{0}[{1}][taxonomy_name]" value="post_tag" />
					<p class="sf_input_type">
						<label for="{0}[{1}][input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
							<select name="{0}[{1}][input_type]" class="" id="{0}[{1}][input_type]">
								<!--<option value="list"<?php $this->set_selected($values['input_type'], "list"); ?>><?php _e("List", $this->plugin_slug); ?></option>-->
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
						<label for="{0}[{1}][all_items_label]"><?php _e("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("override the default - e.g. &quot;All Tags&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="" id="{0}[{1}][all_items_label]" name="{0}[{1}][all_items_label]" type="text" value="<?php echo esc_attr($values['all_items_label']); ?>"></label>
					</p>
					<p class="sf_accessibility_label">
						<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="" id="{0}[{1}][accessibility_label]" name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
					</p>
					
					<p class="sf_operator">
						<label for="{0}[{1}][operator]"><?php _e("Search Operator", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("AND - posts must be in each tag, OR - posts must be in any tag", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
							<select name="{0}[{1}][operator]" id="{0}[{1}][operator]">
								<option value="and"<?php $this->set_selected($values['operator'], "and"); ?>><?php _e("AND", $this->plugin_slug); ?></option>
								<option value="or"<?php $this->set_selected($values['operator'], "or"); ?>><?php _e("OR", $this->plugin_slug); ?></option>
							</select>
						</label>
					</p>
					
				</fieldset>
				
				
				<fieldset class="item-container">
					<br />
					<p>
						<input class="checkbox" type="checkbox" id="{0}[{1}][show_count]" name="{0}[{1}][show_count]"<?php $this->set_checked($values['show_count']); ?>>
						<label for="{0}[{1}][show_count]"><?php _e("Display count?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("display the number of posts in each tag", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</p>
					<p>
						<input class="checkbox" type="checkbox" id="{0}[{1}][hide_empty]" name="{0}[{1}][hide_empty]"<?php $this->set_checked($values['hide_empty']); ?>>
						<label for="{0}[{1}][hide_empty]"><?php _e("Hide empty terms?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("hide tags with no posts/items", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</p>
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
					<!--<p>
						<input class="checkbox" type="checkbox" id="{0}[{1}][hierarchical]" name="{0}[{1}][hierarchical]"<?php $this->set_checked($values['hierarchical']); ?>>
						<label for="{0}[{1}][hierarchical]"><?php _e("Hierarchical?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("show child tags underneath their parents", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</p>-->
					<!--<p class="sf_drill_down">
						<input class="checkbox" type="checkbox" id="{0}[{1}][drill_down]" name="{0}[{1}][drill_down]"<?php $this->set_checked($values['drill_down']); ?>>
						<label for="{0}[{1}][drill_down]"><?php _e("Make drill down?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("child tags will only be revealed once a parent has been selected", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
					</p>-->
				</fieldset>
				
				<div class="clear"></div>
				
				<fieldset class="advanced-settings">
					<hr />
					
					<p class="item-container">
						<label for="{0}[{1}][order_by]"><?php _e("Order terms by: ", $this->plugin_slug); ?><br />
							<select name="{0}[{1}][order_by]" id="{0}[{1}][order_by]">
								<option value="default"<?php $this->set_selected($values['order_by'], "default"); ?>><?php _e("Default", $this->plugin_slug); ?></option>
								<option value="id"<?php $this->set_selected($values['order_by'], "id"); ?>><?php _e("ID", $this->plugin_slug); ?></option>
								<option value="name"<?php $this->set_selected($values['order_by'], "name"); ?>><?php _e("Name", $this->plugin_slug); ?></option>
								<option value="slug"<?php $this->set_selected($values['order_by'], "slug"); ?>><?php _e("Slug", $this->plugin_slug); ?></option>
								<option value="count"<?php $this->set_selected($values['order_by'], "count"); ?>><?php _e("Count", $this->plugin_slug); ?></option>
								<option value="term_group"<?php $this->set_selected($values['order_by'], "term_group"); ?>><?php _e("Term Group", $this->plugin_slug); ?></option>
							</select>
							
							<select name="{0}[{1}][order_dir]" id="{0}[{1}][order_dir]">
								<option value="asc"<?php $this->set_selected($values['order_dir'], "asc"); ?>><?php _e("ASC", $this->plugin_slug); ?></option>
								<option value="desc"<?php $this->set_selected($values['order_dir'], "desc"); ?>><?php _e("DESC", $this->plugin_slug); ?></option>
							</select>
							
						</label>
					</p>
					
					<p class="item-container">
						<label for="{0}[{1}][exclude_ids]"><?php _e("Exclude IDs", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("comma seperated list of tag IDs to exclude", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
						<input class="exclude_ids settings_exclude_ids" id="{0}[{1}][exclude_ids]" name="{0}[{1}][exclude_ids]" type="text" value="<?php echo esc_attr($values['exclude_ids']); ?>">
						<input class="exclude_ids_hidden" id="{0}[{1}][exclude_ids_hidden]" name="{0}[{1}][exclude_ids]" type="hidden" value="<?php echo esc_attr($values['exclude_ids']); ?>" disabled="disabled">
						</label>
						<?php
							$tax_obj = get_taxonomy('post_tag');
						?>
						<a href="#" class="dashicons-search search-tax-button button-secondary sfmodal" data-taxonomy-name="<?php echo esc_attr($tax_obj->name); ?>" data-taxonomy-label="<?php echo esc_attr($tax_obj->label); ?>"></a>
						<br />
						<input class="checkbox sync_include_exclude" type="checkbox" id="{0}[{1}][sync_include_exclude]" name="{0}[{1}][sync_include_exclude]"<?php $this->set_checked($values['sync_include_exclude']); ?>>
						<label for="{0}[{1}][sync_include_exclude]"><?php _e("Sync with Settings?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("This will show / hide tags for this field based upon the settings from the &quot;Settings &amp; Defaults&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></label>
						
					</p>
					
				</fieldset>
				
				<div class="clear"></div>
				
			</div>
			<br class="clear" />
			
			<input type="hidden" name="{0}[{1}][type]" class="widget-id" id="hidden_type" value="tag">
			

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
		<?php _e("Add a Tag Field to your form", $this->plugin_slug); ?>
	</div>
</div>