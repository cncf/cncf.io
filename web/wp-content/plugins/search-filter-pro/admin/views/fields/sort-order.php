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
                <span class="screen-reader-text">Sort Order Field</span>
            </a>
        </div>
		<div class="widget-title">
			<h4><?php _e("Sort Order", $this->plugin_slug); ?><span class="in-widget-title"></span></h4>
		</div>
	</div>

	<div class="widget-inside">
		
		<div class="widget-content" style="position:relative;">
			<p>
				<em><?php _e("Add a field allowing your users to sort results.", $this->plugin_slug); ?></em>
			</p>
			<p class="item-container sf_input_type">
				<label for="{0}[{1}][input_type]"><?php _e("Input type: ", $this->plugin_slug); ?><br />
					<select name="{0}[{1}][input_type]" class="" id="{0}[{1}][input_type]">
						<option value="select"<?php $this->set_selected($values['input_type'], "select"); ?>><?php _e("Dropdown", $this->plugin_slug); ?></option>
						<option value="radio"<?php $this->set_selected($values['input_type'], "radio"); ?>><?php _e("Radio", $this->plugin_slug); ?></option>
					</select>
				</label>
			</p>
			<p class="item-container">
				<label for="{0}[{1}][heading]"><?php _e("Add a heading?", $this->plugin_slug); ?><br /><input class="" id="{0}[{1}][heading]" name="{0}[{1}][heading]" type="text" value="<?php echo esc_attr($values['heading']); ?>"></label>
			</p>
			<p class="item-container">
				<label for="{0}[{1}][all_items_label]"><?php _e("Change All Items Label?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("override the default - e.g. &quot;Sort Results By&quot;", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
				<input class="" id="{0}[{1}][all_items_label]" name="{0}[{1}][all_items_label]" type="text" value="<?php echo esc_attr($values['all_items_label']); ?>"></label>
			</p>
			
			<p class="item-container sf_accessibility_label">
				<label for="{0}[{1}][accessibility_label]"><?php _e("Add screen reader text?", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("adds hidden text that will be read by screen readers - complies with WCAG 2.0", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span><br />
				<input class="" id="{0}[{1}][accessibility_label]" name="{0}[{1}][accessibility_label]" type="text" value="<?php echo esc_attr($values['accessibility_label']); ?>"></label>
			</p>
			<br class="clear" />
			<hr class="clear" />
			
			<p><strong><?php _e("Sort Options", $this->plugin_slug); ?></strong></p>
			<p>
				<?php _e("Add the sort options that will be available to this field.", $this->plugin_slug); ?>
			</p>
			
			<p class="item-container slimheadings1-sort">
				<strong><?php _e("Sort By", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php _e("sorting option", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
			</p>
			<p class="item-container slimheadings2-sort">
				<strong><?php _e("Direction", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php _e("choose a direction for sorting", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
			</p>
			<p class="item-container slimheadings2-sort">
				<strong><?php _e("Label", $this->plugin_slug); ?> <span class="hint--top hint--info" data-hint="<?php _e("the text label a uses sees when selecting this option", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span></strong>
			</p>
			
			<br class="clear"></span>
			
			<p class="no_sort_label"><?php _e("<strong>There are no sort options</strong>.", $this->plugin_slug); ?></p>
			
			<ul class="sort_options_list">
			<?php
			
			$i = 0;
			$this->display_sort_option( array(), ' sort-option-template ignore-template-init');
			
			if(isset($values['sort_options']))
			{
				foreach ($values['sort_options'] as $sort_option)
				{
					
					$this->display_sort_option($sort_option);
					
					$i++;
				}
			}
			
			?>
			</ul>
			
			<p>
				<a href="#" class="dashicons-plus add-sort-button button-secondary"><?php _e("Add Option", $this->plugin_slug); ?></a>
				<a href="#" class="clear-option-button button-secondary"><?php _e("Clear All Options", $this->plugin_slug); ?></a>
			</p>
			
			<div class="clear"></div>
			
		</div>
		<br class="clear" />
		
		<input type="hidden" name="{0}[{1}][type]" class="widget-id" id="hidden_type" value="<?php echo $values['type']; ?>">
		

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