<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
?>

<div id="shortcode-info" class="widgets-search-filter-draggables ui-search-filter-sortable setup" data-allow-expand="0">
	<?php
		global $post;
	?>
	
	<br /><strong><?php _e("Search Form Shortcode:", $this->plugin_slug ); ?></strong><br /><small><?php _e("You can also use a widget to place the search form.", $this->plugin_slug); ?></small>
	<p class="description-inline">
		<label for="{0}[{1}][enable_auto_count]">
			<input class="" id="" name="form_shortcode" type="text" size="21" value="<?php echo esc_attr('[searchandfilter id="'.$post->ID.'"]');  ?>">
		</label>
	</p>
	<div class="results-shortcode" style="display:none;">
	<br /><strong><?php _e("Results Shortcode:", $this->plugin_slug ); ?></strong><br /><small><?php _e("This must be used on a page where your search form can be found - otherwise S&amp;F won't know where to load the results.", $this->plugin_slug); ?></small>
	<p class="description-inline">
		<input class="" id="" name="results_shortcode" type="text" size="21" value="<?php echo esc_attr('[searchandfilter id="'.$post->ID.'" show="results"]');  ?>">
	</p>
	</div>
	<div class="edd-shortcode" style="display:none;">
	<br /><strong><?php _e("EDD Shortcode:", $this->plugin_slug ); ?></strong><br /><small><?php _e("Place this directly before your EDD [downloads] shortcode", $this->plugin_slug); ?></small>
	<p class="description-inline">
		<input class="" id="" name="results_shortcode" type="text" size="21" value="<?php echo esc_attr('[searchandfilter id="'.$post->ID.'" action="prep_query"]');  ?>">
	</p>
	</div>
	<br /><strong><?php _e("Use slug instead of ID:", $this->plugin_slug ); ?></strong><br /><small><?php _e("You can also use the slug instead of ID in your shortcodes.", $this->plugin_slug); ?></small>
	<p class="description-inline">
		<label for="{0}[{1}][enable_auto_count]">
			<input class="" id="" name="form_shortcode" type="text" size="21" value="<?php echo esc_attr('[searchandfilter slug="'.$post->post_name.'"]');  ?>">
		</label>
	</p>
	<br />
</div>


