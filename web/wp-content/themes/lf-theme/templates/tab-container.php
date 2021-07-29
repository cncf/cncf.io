<?php
/**
 * Template Name: Tab Container Page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// Include the Tab Container Filter.
require_once dirname( __FILE__ ) . '/../includes/tab-container-filter.php';

get_template_part( 'components/header' );

get_template_part( 'components/hero' );

?>

<main>
	<article class="container wrap entry-content">
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
	get_stylesheet_directory_uri() . '/source/js/third-party/sticky.min.js',
	null,
	filemtime( get_template_directory() . '/source/js/third-party/sticky.min.js' ),
	true
);

wp_enqueue_script(
	'tab-container-js',
	get_stylesheet_directory_uri() . '/source/js/third-party/tab-container.js',
	is_admin() ? null : array( 'jquery', 'sticky-js' ),
	filemtime( get_template_directory() . '/source/js/third-party/tab-container.js' ),
	true
);

get_template_part( 'components/footer' );
