<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

if ( $query->have_posts() ) {
	set_query_var( 'query', $query );
	switch ( $query->query['post_type'] ) {
		case 'cncf_webinar':
			get_template_part( 'search-filter/webinars' );
			break;
		case 'cncf_event':
			get_template_part( 'search-filter/events' );
			break;
		case 'cncf_case_study':
			get_template_part( 'search-filter/casestudies' );
			break;
		case 'cncf_case_study_ch':
			get_template_part( 'search-filter/casestudies' );
			break;
	}
} else {
	echo 'No Results Found';
}
