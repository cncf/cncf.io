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
<?php wp_nonce_field( 'search_form_nonce', $this->plugin_slug.'_nonce', true, true ); ?>

<div id="search-form">
	
	<p class="description"><?php _e( 'Build your Search Form here by dragging Available Fields in to this area.', $this->plugin_slug ); ?></p>
		
	<?php
		$widgets = (get_post_meta( $object->ID, '_search-filter-fields', true ));
		
		if(isset($widgets))
		{
			if($widgets!="")
			{
				foreach ($widgets as $widget)
				{
					if(isset($widget['type']))
					{
						$this->display_meta_box_field($widget['type'], $widget, $object);
					}
				}
			}
		}
	?>
</div>
