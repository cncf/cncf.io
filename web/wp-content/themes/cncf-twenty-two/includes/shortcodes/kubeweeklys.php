<?php
/**
 * KubeWeeklys Shortcode
 *
 * Usage
 * [kubeweeklys]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add kubeweeklys shortcode.
 */
function add_kubeweeklys_shortcode() {

	$query_args = array(
		'post_type'      => 'lf_kubeweekly',
		'post_status'    => array( 'publish' ),
		'posts_per_page' => -1,
		'orderby'        => 'post_date',
		'order'          => 'DESC',
	);

	$kubeweekly_query = new WP_Query( $query_args );
	ob_start();
	if ( $kubeweekly_query->have_posts() ) {
		$y = 0;
		?>
		<section class="kubeweeklys">
			<?php
			while ( $kubeweekly_query->have_posts() ) :
				$kubeweekly_query->the_post();

				$link_url = get_post_meta( get_the_ID(), 'lf_kubeweekly_external_url', true );

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

			<div class="kubeweekly-item">

			<p class="kubeweekly-item__title">
			<a class="kubeweekly-item__link" href="<?php echo esc_url( $link_url ); ?>" title="<?php echo esc_html( get_the_title() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>
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
add_shortcode( 'kubeweeklys', 'add_kubeweeklys_shortcode' );


 /**
  * Add Kubeweekly Newsletter shortcode.
  *
  * @param array $atts Attributes.
  */
function add_kubeweekly_newsletter_shortcode( $atts ) {
	ob_start();
	?>
<div class="wp-block-group has-white-color has-tertiary-400-background-color has-text-color has-background kubeweekly-newsletter"><div class="wp-block-group__inner-container">
<h4>Join the KubeWeekly mailing list</h4>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=cf924a1f-5b8b-40dc-9452-b207c494dae2]' ); ?>
<p class="has-small-font-size margin-top">By submitting this form, you acknowledge that your information is subject to The Linux Foundation’s <a href="https://www.linuxfoundation.org/privacy/">Privacy Policy</a>.</p>
</div></div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'kubeweekly-newsletter', 'add_kubeweekly_newsletter_shortcode' );
