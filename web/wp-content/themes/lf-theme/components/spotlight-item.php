<?php
/**
 * Spotlight Item
 *
 * Singular Spotlight item.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$subtitle = get_post_meta( get_the_ID(), 'lf_spotlight_subtitle', true );

// get spotlight type.
$spotlight_type = Lf_Utils::get_term_names( get_the_ID(), 'lf-spotlight-type', true );

?>
<div class="spotlight-box">

	<div class="spotlight-photo">
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php
			if ( has_post_thumbnail() ) {
				echo wp_get_attachment_image( get_post_thumbnail_id(), false, false, array( 'size' => '(min-width: 1100px) 288px, (min-width: 840px) 26.67vw, (min-width: 580px) calc(50vw - 65px), (min-width: 500px) calc(100vw - 82px), calc(100vw - 56px)' ) );
			} else {
				$options = get_option( 'lf-mu' );
				echo wp_get_attachment_image( $options['generic_avatar_id'], 'spotlight', false, array( 'class' => '' ) );
			}
			?>
		</a>
	</div>
	<div class="spotlight-text-wrapper">
		<div class="skew-box secondary margin-top-small centered">CNCF
			<?php echo esc_html( $spotlight_type ); ?> Spotlight</div>

		<h5 class="spotlight-title"><a
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

		<span class="archive-date date-icon spotlight-date">
			<?php echo get_the_date( 'F j, Y' ); ?></span>

		<?php
		if ( $subtitle ) :
			?>
		<p class="margin-bottom"><?php echo esc_html( $subtitle ); ?></p>
			<?php
		endif;
		?>

	</div>
</div>
