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
add_shortcode( 'kubeweeklys', 'add_kubeweeklys_shortcode' );


/**
 * Add Kubeweekly Newsletter shortcode.
 *
 * @param array $atts Attributes.
 */
function add_kubeweekly_newsletter_shortcode( $atts ) {
	ob_start();
	?>
<div class="wp-block-group is-style-border has-white-background-color has-background kubeweekly-newsletter">
<h3 class="is-style-spaced-uppercase">JOIN THE KUBEWEEKLY MAILING LIST</h3>
<div style="height:25px" aria-hidden="true" class="wp-block-spacer"></div>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=8095ef7d-1275-43f3-b7b7-916056b40b3f]' ); ?>
	<div style="height:15px" aria-hidden="true" class="wp-block-spacer is-style-40-responsive"></div>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'kubeweekly-newsletter', 'add_kubeweekly_newsletter_shortcode' );
