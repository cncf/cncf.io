<?php
/**
 * Front page
 *
 * Template for the front page (home).
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );

// get_template_part( 'components/wip-blocks' ); / phpcsignore.

// get_template_part( 'components/elements' ); // phpcsignore.

// get_template_part( 'components/hero' ); // phpcsignore.

get_template_part( 'components/page-loop' );

// get_template_part( 'components/post-loop' ); // phpcsignore.

get_template_part( 'components/footer' );
