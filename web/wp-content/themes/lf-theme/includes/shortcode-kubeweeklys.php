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
		?>

<div class="kubeweeklys-wrapper">
		<?php
		while ( $kubeweekly_query->have_posts() ) :
			$kubeweekly_query->the_post();
			?>
			<div class="kubeweekly-box">
			<p class="archive-title"><a href="<?php the_permalink(); ?>"
				title="<?php esc_html( the_title() ); ?>"><?php esc_html( the_title() ); ?></a>
			</p>
			
			<div class="sent date-icon"><?php the_date() ?></div>
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
