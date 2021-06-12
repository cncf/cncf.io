<?php
/**
 * KubeWeeklys Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add kubeweeklys shortcode.
  *
  * @param array $atts Attributes.
  */
function add_kubeweeklys_shortcode( $atts ) {

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
		while ( $kubeweekly_query->have_posts() ) :
			$kubeweekly_query->the_post();
			$link_url = get_post_meta( get_the_ID(), 'lf_kubeweekly_external_url', true );
			if ( ( 0 == $y ) || ( $y > (int) get_the_date( 'Y' ) ) ) {
				if ( 0 != $y ) {
					echo '</div>';
				}
				$y = (int) get_the_date( 'Y' );
				echo '<h2>' . esc_html( $y ) . '</h2>';
				echo '<div class="kubeweeklys-wrapper">';
			}

			?>
			<div class="kubeweekly-box">
			<p class="archive-title">

			<?php
			if ( $link_url ) {
				echo '<a class="external is-primary-color" target="_blank" rel="noopener" href="' . esc_url( $link_url ) . '" title="' . esc_html( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</a>';
			} else {
				echo '<a href="' . esc_url( get_the_permalink() ) . '" title="' . esc_html( get_the_title() ) . '">' . esc_html( get_the_title() ) . '</a>';
			}
			?>
			</p>
			<div class="sent date-icon"><?php the_date(); ?></div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
	}
	?>
</div>
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
<p class="has-small-font-size margin-top">By submitting this form, you acknowledge that your information is subject to The Linux Foundation’s <a href="https://www.linuxfoundation.org/privacy/" rel="noopener" class="external has-white-color" target="_blank">Privacy Policy</a>.</p>
</div></div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'kubeweekly-newsletter', 'add_kubeweekly_newsletter_shortcode' );
