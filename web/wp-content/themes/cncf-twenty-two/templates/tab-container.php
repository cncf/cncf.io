<?php
/**
 * Template Name: Tab Container Page
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Include the Tab Container Filter.
require_once get_template_directory() . '/includes/tab-container-filter.php';

get_template_part( 'components/header' );

get_template_part( 'components/title' );

?>

<main>
	<article class="container wrap">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</article>
</main>

<?php
// Include the JS file.
wp_enqueue_script(
	'sticky-js',
	get_stylesheet_directory_uri() . '/source/js/libraries/sticky.min.js',
	null,
	filemtime( get_template_directory() . '/source/js/libraries/sticky.min.js' ),
	true
);

wp_enqueue_script(
	'tab-container-js',
	get_stylesheet_directory_uri() . '/source/js/on-demand/tab-container.js',
	is_admin() ? null : array( 'jquery', 'sticky-js' ),
	filemtime( get_template_directory() . '/source/js/on-demand/tab-container.js' ),
	true
);

get_template_part( 'components/footer' );
