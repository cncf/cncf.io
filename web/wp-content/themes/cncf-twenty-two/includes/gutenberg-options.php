<?php
/**
 * Gutenberg Options
 *
 * Additional settings and functions for Gutenberg
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Block Template - Page
 */
function lf_page_block_template() {
	$page_type_object           = get_post_type_object( 'page' );
	$page_type_object->template = array(
		array(
			'core/paragraph',
			array(
				'placeholder' => 'This first introductory paragraph of text should be H3 size lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo',
				'className'   => 'is-style-max-width-900',
				'fontSize'    => 'header-3',

			),
		),
		array(
			'core/paragraph',
			array(
				'placeholder' => 'And then change to normal paragraph text lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula get dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate get, arcu. In enim justo, rhoncus ut imperdiet a.',
			),
		),
	);
}
// add_action( 'init', 'lf_page_block_template' ); // phpcs:ignore.


/**
 * Register Block Patterns
 *
 * @return void
 */
function lf_register_block_patterns() {

	if ( class_exists( 'WP_Block_Patterns_Registry' ) ) {

				$content = '<!-- wp:spacer {"height":"90px","className":"is-style-70-90"} -->
				<div style="height:90px" aria-hidden="true" class="wp-block-spacer is-style-70-90"></div>
				<!-- /wp:spacer -->

				<!-- wp:columns {"className":"is-style-blob-grid"} -->
				<div class="wp-block-columns is-style-blob-grid"><!-- wp:column -->
				<div class="wp-block-column"><!-- wp:heading {"level":1,"className":"is-style-page-title"} -->
				<h1 class="is-style-page-title">Join CNCF</h1>
				<!-- /wp:heading -->

				<!-- wp:spacer {"height":"90px","className":"is-style-60-70"} -->
				<div style="height:90px" aria-hidden="true" class="wp-block-spacer is-style-60-70"></div>
				<!-- /wp:spacer -->

				<!-- wp:paragraph {"className":"is-style-opening-paragraph"} -->
				<p class="is-style-opening-paragraph">Become an integral part of the Cloud Native Computing Foundation, to build and shape the future cloud native ecosystem</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>We bring together the world’s top developers, end users, and vendors and runs the largest open source developer conferences. </p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>CNCF is part of the nonprofit Linux Foundation.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:column -->

				<!-- wp:column {"width":""} -->
				<div class="wp-block-column"><!-- wp:image {"align":"left","id":65023,"sizeSlug":"large","linkDestination":"none","className":"is-style-blob"} -->
				<div class="wp-block-image is-style-blob"><figure class="alignleft size-large"><img src="https://via.placeholder.com/1200x1000/d9d9d9/000000" alt="Participants cheering at a conference" class="wp-image-65023"/></figure></div>
				<!-- /wp:image --></div>
				<!-- /wp:column --></div>
				<!-- /wp:columns -->

				<!-- wp:spacer -->
				<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->';

		register_block_pattern(
			'lf/blob-title-section',
			array(
				'title'         => __( 'Blob Title Section' ),
				'description'   => _x( 'Blob Title section to be used with No Page Title template.', 'Block pattern description' ),
				'content'       => trim( $content ),
				'categories'    => array( 'hero' ),
				'keywords'      => array( 'blob', 'title' ),
				'viewportWidth' => 1400,
				'blockTypes'    => array( 'core/columns' ),
			)
		);

		$content = '<!-- wp:group {"className":"is-style-no-padding is-style-see-all"} -->
		<div class="wp-block-group is-style-no-padding is-style-see-all"><!-- wp:columns {"verticalAlignment":"top"} -->
		<div class="wp-block-columns are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top","width":80} -->
		<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:80%"><!-- wp:heading {"className":"is-style-section-heading"} -->
		<h2 class="is-style-section-heading">Latest from CNCF</h2>
		<!-- /wp:heading --></div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"top","width":20} -->
		<div class="wp-block-column is-vertically-aligned-top" style="flex-basis:20%"><!-- wp:paragraph -->
		<p>&nbsp;</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:column --></div>
		<!-- /wp:columns -->

		<!-- wp:shortcode -->
		[latest_news]
		<!-- /wp:shortcode -->

		<!-- wp:group {"layout":{"type":"flex","allowOrientation":false,"justifyContent":"center"}} -->
		<div class="wp-block-group"><!-- wp:paragraph {"align":"left","className":"is-style-link-cta"} -->
		<p class="has-text-align-left is-style-link-cta">LATEST POSTS</p>
		<!-- /wp:paragraph --></div>
		<!-- /wp:group --></div>
		<!-- /wp:group -->';

		register_block_pattern(
			'lf/see-all-section',
			array(
				'title'         => __( 'See All Section' ),
				'description'   => _x( 'Used to posistion the See All link underneath on mobile', 'Block pattern description' ),
				'content'       => trim( $content ),
				'categories'    => array( 'hero' ),
				'keywords'      => array( 'all', 'link' ),
				'viewportWidth' => 1400,
				'blockTypes'    => array( 'core/columns' ),
			)
		);


	}

}
add_action( 'init', 'lf_register_block_patterns' );
