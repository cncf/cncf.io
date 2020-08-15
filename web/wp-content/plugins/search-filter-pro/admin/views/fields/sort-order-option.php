<?php
// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<li class='sort-option-item<?php echo $class; ?>'>

	<fieldset class="sitem">
		<p class='item-container slimmove'>
			<img src="<?php echo plugins_url( 'admin/assets/img/move-ico.svg', SEARCH_FILTER_PRO_BASE_PATH); ?>" />
		</p>
		<p class='item-container xslim'>
			<label for="{0}[{1}][sort_options][{2}][sort_by]">
				<span><?php _e("Sort By", $this->plugin_slug); ?><br /></span>
				
				<select name="{0}[{1}][sort_options][{2}][sort_by]" class="sort_by_option" id="{0}[{1}][sort_options][{2}][sort_by]">
					<option value="ID"<?php $this->set_selected($values['sort_by'], "ID"); ?>><?php _e("Post ID", $this->plugin_slug); ?></option>
					<option value="author"<?php $this->set_selected($values['sort_by'], "author"); ?>><?php _e("Author", $this->plugin_slug); ?></option>
					<option value="title"<?php $this->set_selected($values['sort_by'], "title"); ?>><?php _e("Title", $this->plugin_slug); ?></option>
					<option value="name"<?php $this->set_selected($values['sort_by'], "name"); ?>><?php _e("Name (Post Slug)", $this->plugin_slug); ?></option>
					<option value="type"<?php $this->set_selected($values['sort_by'], "type"); ?>><?php _e("Type (Post Type)", $this->plugin_slug); ?></option>
					<option value="date"<?php $this->set_selected($values['sort_by'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
					<option value="modified"<?php $this->set_selected($values['sort_by'], "modified"); ?>><?php _e("Last Modified Date", $this->plugin_slug); ?></option>
					<option value="parent"<?php $this->set_selected($values['sort_by'], "parent"); ?>><?php _e("Parent ID", $this->plugin_slug); ?></option>
					<option value="rand"<?php $this->set_selected($values['sort_by'], "rand"); ?>><?php _e("Random Order", $this->plugin_slug); ?></option>
					<option value="comment_count"<?php $this->set_selected($values['sort_by'], "comment_count"); ?>><?php _e("Comment Count", $this->plugin_slug); ?></option>
                    <option value="relevance"<?php $this->set_selected($values['sort_by'], "relevance"); ?>><?php _e("Relevance", $this->plugin_slug); ?></option>
					<option value="menu_order"<?php $this->set_selected($values['sort_by'], "menu_order"); ?>><?php _e("Menu Order", $this->plugin_slug); ?></option>
					<option value="meta_value"<?php $this->set_selected($values['sort_by'], "meta_value"); ?>><?php _e("Meta Value", $this->plugin_slug); ?></option>
				</select>
			</label>
		</p>
		<p class='item-container xslim'>
			<label for="{0}[{1}][sort_options][{2}][sort_dir]">
				<span><?php _e("Direction", $this->plugin_slug); ?><br /></span>
				<select name="{0}[{1}][sort_options][{2}][sort_dir]" class="meta_key" id="{0}[{1}][sort_options][{2}][sort_dir]">
					<option value="desc"<?php $this->set_selected($values['sort_dir'], "desc"); ?>><?php _e("Descending", $this->plugin_slug); ?></option>
					<option value="asc"<?php $this->set_selected($values['sort_dir'], "asc"); ?>><?php _e("Ascending", $this->plugin_slug); ?></option>
				</select>
			</label>
		</p>
		<p class='item-container slim'>
			<label for="{0}[{1}][sort_options][{2}][sort_label]">
				<span><?php _e("Label", $this->plugin_slug); ?><br /></span>
				<input type="text" name="{0}[{1}][sort_options][{2}][sort_label]" class="meta_key" id="{0}[{1}][sort_options][{2}][sort_label]" value="<?php echo esc_attr($values['sort_label']); ?>" />				
			</label>
		</p>

		<div class="clear"></div>
		
		<p class="meta-option-controls">
			<!--<a href="#" class="widget-control-option-advanced"><?php _e("Advanced", $this->plugin_slug); ?></a> | --><a href="#" class="widget-control-option-remove"><?php _e("Remove", $this->plugin_slug); ?></a>
		</p>
	</fieldset>
	
	

	<div class="clear"></div>
	
	
	<fieldset class='sort-options-advanced'>
		<p class='item-container slimmove'>
			
		</p>
		<p class='item-container slimx2'>
			
			<label for="{0}[{1}][meta_key]">
				<?php _e("Meta Key: ", $this->plugin_slug); ?><span class="hint--top hint--info" data-hint="<?php _e("choose a meta key to sort by", $this->plugin_slug); ?>"><i class="dashicons dashicons-info"></i></span> 
				<?php
					$all_meta_keys = $this->get_all_post_meta_keys();
					echo '<select name="{0}[{1}][sort_options][{2}][meta_key]" class="meta_key" id="{0}[{1}][sort_options][{2}][meta_key]">';
					foreach($all_meta_keys as $v)
					{						
						echo '<option value="'.$v.'"'.$this->set_selected($values['meta_key'], $v, false).'>'.$v."</option>";
					}
					echo '</select>';
					
				?>
			</label>
		</p>
		<p class='item-container slim'>
			
			<label for="{0}[{1}][sort_options][{2}][sort_type]">
				<?php _e("Sort Type: ", $this->plugin_slug); ?> <br />
				<select name='{0}[{1}][sort_options][{2}][sort_type]' data-field-template-id='{0}[{1}][sort_options][{2}][sort_type]'>
					<option value="numeric"<?php $this->set_selected($values['sort_type'], "numeric"); ?>><?php _e("Numeric", $this->plugin_slug); ?></option>
					<option value="alphabetic"<?php $this->set_selected($values['sort_type'], "alphabetic"); ?>><?php _e("Alphabetic", $this->plugin_slug); ?></option>
                    <option value="date"<?php $this->set_selected($values['sort_type'], "date"); ?>><?php _e("Date", $this->plugin_slug); ?></option>
                    <option value="datetime"<?php $this->set_selected($values['sort_type'], "datetime"); ?>><?php _e("Datetime", $this->plugin_slug); ?></option>

                </select>
			</label>
		</p>
		
	</fieldset>
	
</li>