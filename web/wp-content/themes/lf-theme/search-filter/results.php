<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

if ( $query->have_posts() ) {
	set_query_var( 'query', $query );
	switch ( $query->query['post_type'] ) {
		case 'lf_webinar':
			get_template_part( 'search-filter/webinars' );
			break;
		case 'lf_event':
			get_template_part( 'search-filter/events' );
			break;
		case 'lf_case_study':
			get_template_part( 'search-filter/casestudies' );
			break;
		case 'lf_case_study_cn':
			get_template_part( 'search-filter/casestudies' );
			break;
		case 'lf_spotlight':
			get_template_part( 'search-filter/spotlights' );
			break;
	}
} else {
	echo 'No Results Found';
}
