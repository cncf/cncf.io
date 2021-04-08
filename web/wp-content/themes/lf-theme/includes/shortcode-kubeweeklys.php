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
