<?php
/**
 * Single Post
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

	// Single Post for Case Study.
if ( is_singular( 'lf_case_study' ) || is_singular( 'lf_case_study_ch' ) ) :
	get_template_part( 'components/case-study-single' );

	// Single Post for Webinars.
elseif ( is_singular( 'lf_webinar' ) ) :
	get_template_part( 'components/webinar-single' );
	get_template_part( 'components/webinar-footer' );

	// Single Post for Events.
elseif ( is_singular( 'lf_event' ) ) :
	get_template_part( 'components/event-single' );


	elseif ( is_singular( 'lf_spotlight' ) ) :
		get_template_part( 'components/spotlight-single' );
		// Default.
else :
	get_template_part( 'components/post-single' );
endif;

get_template_part( 'components/footer' );
