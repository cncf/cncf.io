<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package WordPress
 * @subpackage cncf-theme
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
		case 'lf_case_study_cn':
			get_template_part( 'search-filter/casestudies' );
			break;
		case 'lf_human':
			get_template_part( 'search-filter/humans' );
			break;
		case 'lf_ktp':
			get_template_part( 'search-filter/ktps' );
			break;
		case 'lf_person':
			get_template_part( 'search-filter/ambassadors' );
			break;
		case 'lf_report':
			get_template_part( 'search-filter/reports' );
			break;
	}
} else {
	echo 'No Results Found';
}
