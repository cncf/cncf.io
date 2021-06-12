<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Display Case Studies rotator banner on home page.
  * [homepage-casestudies ids="34,22,122"]
  *
  * @param array $atts Attributes.
  */
function homepage_casestudies_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'ids' => '', // set default.
		),
		$atts,
		'homepage-casestudies'
	);

	ob_start();
	$ids = explode( ',', $atts['ids'] );
	shuffle( $ids );

	$title    = get_post_meta( $ids[0], 'lf_case_study_long_title', true );
	$logo     = get_post_meta( $ids[0], 'lf_case_study_homepage_company_logo', true );
	if ( ! $logo ) {
		$logo     = get_post_meta( $ids[0], 'lf_case_study_company_logo', true );
	}
	$logo_url = wp_get_attachment_image_src( $logo );
	$image    = get_post_meta( $ids[0], 'lf_case_study_homepage_image', true );
	$url      = get_permalink( $ids[0] );
	if ( ! $image ) {
		// use the regular listing background image if no homepage image exists.
		$image = get_post_thumbnail_id( $ids[0] );
	}
	$company = get_the_title( $ids[0] );
	?>

	<figure class="background-image-figure">
	<?php
	LF_Utils::display_responsive_images( $image, 'case-study-640', '600px' ); // srcset.
	?>
	</figure>

	<div class="wrap background-image-text-overlay">
	<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
		<p class="h5 fw-400">CNCF projects are trusted by organizations around the world</p>
		<a href="<?php echo esc_url( $url ); ?>" class="logo-link">
		<?php
		$image = new Image();
		?>
		<img loading="eager" src="<?php echo esc_url( $logo_url[0] ); ?>" alt="<?php echo esc_attr( $company ); ?>" width="300" height="70"></a>
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
		<h2><a  class="has-white-color has-text-color" href="<?php echo esc_url( $url ); ?>">
		<?php echo esc_html( $title ); ?>
		</a></h2>
		<a href="<?php echo esc_url( $url ); ?>" class="button">Read <?php echo esc_html( $company ); ?> Case Study</a>
		<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-casestudies', 'homepage_casestudies_shortcode' );
