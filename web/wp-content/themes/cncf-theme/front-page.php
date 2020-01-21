<?php
/**
 * Front page
 *
 * Template for the front page (home).
 *
 * @category Components
 * @package  WordPress
 * @author   James Hunt <domains@thetwopercent.co.uk>
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

get_template_part( 'blocks/header' );

get_template_part( 'blocks/elements' );

/** get_template_part( 'blocks/hero' ); */

get_template_part( 'blocks/page-content' );

get_template_part( 'blocks/footer' );
