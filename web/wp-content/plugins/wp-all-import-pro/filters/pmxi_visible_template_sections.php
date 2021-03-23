<?php
function pmxi_pmxi_visible_template_sections( $sections, $post_type ){

	if ( 'taxonomies' == $post_type ) return array('caption', 'main', 'cf', 'featured', 'other');

    if ( in_array($post_type, ['comments', 'woo_reviews']) ) return array('main', 'cf', 'other');

	return $sections;

}