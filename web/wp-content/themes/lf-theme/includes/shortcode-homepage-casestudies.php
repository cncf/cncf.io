<?php
/**
 * Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add shortcode.
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
	var_dump( $ids[0] );
	?>
	
	<figure class="background-image-figure">

	<?php
	LF_Utils::display_responsive_images( 61745, 'case-study-640', '600px' ); // srcset.
	?>

	</figure>

	<div class="wrap background-image-text-overlay">
	<div style="height:60px" aria-hidden="true" class="wp-block-spacer is-style-60-responsive"></div>
		<p class="h5 fw-400">CNCF projects are trusted by organizations around the world</p>
			<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
		<a href="/case-studies/ericsson/">
		<?php
		$image = new Image();
		?>
				<img loading="eager" src="<?php $image->get_svg( 'wip-home/ericsson-logo.svg', true ); ?>"
					alt="Ericsson" width="300" height="64"></a>
		<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-20-responsive"></div>
		<h2><a  class="has-white-color has-text-color" href="/case-studies/ericsson/">How Ericsson is using Kubernetes to leverage cloud native &amp; enable 5G transformation</a></h2>
		<a href="/case-studies/ericsson/" class="button">Read Ericsson Case Study</a>
		<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'homepage-casestudies', 'homepage_casestudies_shortcode' );
