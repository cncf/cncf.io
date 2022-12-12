<?php
/**
 * Template Name: Annual Report 2022
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'annual-reports/2022/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'ar-2022', get_template_directory_uri() . '/build/annual-report-2022.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2022.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Anunal Report 2022 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2022.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="ar-2022">
	<article class="container wrap">

	</article>
</main>
<?php

// custom scripts.
wp_enqueue_script(
	'annual-report-22',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-22.js',
	array( 'jquery', 'chart-js' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-22.js' ),
	true
);

get_template_part( 'components/footer' );
