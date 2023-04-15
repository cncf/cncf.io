<?php
/**
 * Single Posts
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

if ( is_singular( 'lf_case_study' ) || is_singular( 'lf_case_study_cn' ) ) :
	get_template_part( 'components/case-study-single' );

elseif ( is_singular( 'lf_webinar' ) ) :
	get_template_part( 'components/title' );
	get_template_part( 'components/webinar-single' );

elseif ( is_singular( 'lf_human' ) ) :
	get_template_part( 'components/title' );
	get_template_part( 'components/human-single' );

elseif ( is_singular( 'lf_project' ) ) :
	get_template_part( 'components/title' );
	get_template_part( 'components/project-single' );

elseif ( is_singular( 'lf_report' ) ) :
	get_template_part( 'components/title' );
	get_template_part( 'components/report-single' );
	// Default.
else :
	get_template_part( 'components/title' );
	get_template_part( 'components/post-single' );
endif;

get_template_part( 'components/footer' );
