<?php
/**
 * EU Newsletters Shortcode
 *
 * Usage
 * [eu-newsletters]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add EU Newsletters shortcode.
 */
function add_eu_newsletters_shortcode() {

	$query_args = array(
		'post_type'      => 'lf_eu_newsletter',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'orderby'        => 'post_date',
		'order'          => 'DESC',
	);

	$eu_newsletter_query = new WP_Query( $query_args );
	ob_start();
	if ( $eu_newsletter_query->have_posts() ) {
		$y = 0;
		?>
		<section class="kubeweeklys">
			<?php
			while ( $eu_newsletter_query->have_posts() ) :
				$eu_newsletter_query->the_post();

				$link_url = get_post_meta( get_the_ID(), 'lf_eu_newsletter_external_url', true );

				if ( ! $link_url ) {
					$link_url = get_the_permalink();
				}

				// If end of a year, insert a closing div.
				if ( ( 0 == $y ) || ( $y > (int) get_the_date( 'Y' ) ) ) :
					if ( 0 != $y ) {
						echo '</div>';
					}
					$y = (int) get_the_date( 'Y' );
					// Output the year to being.
					?>
				<h2><?php echo esc_html( $y ); ?></h2>
					<?php
					echo '<div class="kubeweeklys-section columns-three">';
					?>
					<?php
				endif;
				?>

			<div class="kubeweekly-item has-animation-scale-2">

			<p class="kubeweekly-item__title">
			<a class="kubeweekly-item__link" href="<?php echo esc_url( $link_url ); ?>" title="<?php echo esc_html( the_title_attribute() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
			</p>
			<span class="kubeweekly-item__date"><?php the_date(); ?></span>

			</div>
				<?php
		endwhile;
			wp_reset_postdata();
	}
	?>
</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'eu-newsletters', 'add_eu_newsletters_shortcode' );


 /**
  * Add EU Newsletter form shortcode.
  *
  * @param array $atts Attributes.
  */
function add_eu_newsletter_form_shortcode( $atts ) {
	ob_start();
	?>
<div class="wp-block-group is-style-box-shadow has-white-background-color has-background kubeweekly-newsletter">
<h3 class="is-style-spaced-uppercase">SIGN UP FOR THE END USER NEWSLETTER</h3>
<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=7a123838-7748-4322-81eb-622045285f52]' ); ?>
	<div style="height:15px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>
<p class="has-small-font-size margin-top">By submitting this form, you acknowledge that your information is subject to The Linux Foundation’s <a href="https://www.linuxfoundation.org/privacy/">Privacy Policy</a>.</p>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'eu-newsletter-form', 'add_eu_newsletter_form_shortcode' );
