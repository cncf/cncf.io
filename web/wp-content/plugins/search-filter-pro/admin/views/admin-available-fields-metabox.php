<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */
 
?>

<div id="available-fields" class="widgets-search-filter-draggables ui-search-filter-sortable" data-allow-expand="0">
	
	<p class="description"><?php _e("Drag any of these Available Fields in to the <strong>Search Form UI</strong> to start building your Search Form.", $this->plugin_slug ); ?></p>
	
	<?php
		
		$this->display_meta_box_field("search");
		$this->display_meta_box_field("tag");
		$this->display_meta_box_field("category");
		$this->display_meta_box_field("taxonomy");
		$this->display_meta_box_field("post_type");
		$this->display_meta_box_field("post_date");
		$this->display_meta_box_field("post_meta");
		$this->display_meta_box_field("author");
		$this->display_meta_box_field("sort_order");
		$this->display_meta_box_field("posts_per_page");
		$this->display_meta_box_field("submit");
		$this->display_meta_box_field("reset");
		
	?>
</div>


