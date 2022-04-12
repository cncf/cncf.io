<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Display Case Studies rotator banner on home page.
 * [home_case_studies ids="34,22,122"]
 *
 * @param array $atts Attributes.
 */
function add_home_case_studies_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'ids' => '', // set default.
		),
		$atts,
		'home_case_studies'
	);

	$selected_ids = explode( ',', $atts['ids'] );
	shuffle( $selected_ids );
	$finals_ids = array_slice( $selected_ids, 0, 2 );

	ob_start();
	?>

<div class="featured-case-studies columns-two">

	<?php

	foreach ( $finals_ids as $id ) :

		$company     = get_the_title( $id );
		$description = get_post_meta( $id, 'lf_case_study_long_title', true );
		$url         = get_permalink( $id );
		$logo        = get_post_meta( $id, 'lf_case_study_homepage_company_logo', true );
		if ( ! $logo ) {
			$logo = get_post_meta( $id, 'lf_case_study_company_logo', true );
		}
		$background_image = get_post_meta( $id, 'lf_case_study_homepage_image', true );
		if ( ! $background_image ) {
			// use the regular listing background image if no homepage image exists.
			$image = get_post_thumbnail_id( $id );
		}
		?>
	<div class="featured-case-studies__item">

		<a href="<?php echo esc_url( $url ); ?>" class="box-link"
			title="Read <?php echo esc_html( $company ); ?> case study"></a>

		<figure class="featured-case-studies__bg-figure">
			<?php
			LF_Utils::display_responsive_images( $background_image, 'case-study-640', '600px', 'featured-case-studies__bg-image' );
			?>
		</figure>

		<div class="featured-case-studies__text-overlay">

			<span class="author-category">Case Study</span>

			<figure class="featured-case-studies__logo-figure">
				<?php
				LF_Utils::display_responsive_images( $logo, 'full', '200px', 'featured-case-studies__logo' );
				?>
			</figure>
			<p class="featured-case-studies__description">
		<?php echo esc_html( $description ); ?>
		</p>

		</div>

	</div>

		<?php
	endforeach;
	?>
</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'home_case_studies', 'add_home_case_studies_shortcode' );
