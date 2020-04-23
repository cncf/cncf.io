<?php
/**
 * Single Post
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

	// Single Post for Case Study.
if ( is_singular( 'cncf_case_study' ) ) :
	get_template_part( 'components/case-study-single' );

	// Single Post for Webinars.
elseif ( is_singular( 'cncf_webinar' ) ) :
	get_template_part( 'components/webinar-single' );

	// Default.
else :
	get_template_part( 'components/post-single' );
endif;

get_template_part( 'components/footer' );
