<?php
/**
 * Spotlight Item
 *
 * Singular Spotlight item.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$subtitle = get_post_meta( get_the_ID(), 'cncf_spotlight_subtitle', true );

// get spotlight type.
$spotlight_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-spotlight-type', true );

?>
<div class="spotlight-box">

<div class="spotlight-photo">
<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
	<?php
	if ( has_post_thumbnail() ) {
		echo wp_get_attachment_image( get_post_thumbnail_id(), 'spotlight', false, array( 'class' => '' ) );
	} else {
		$options = get_option( 'cncf-mu' );
		echo wp_get_attachment_image( $options['generic_avatar_id'], 'spotlight', false, array( 'class' => '' ) );
	}
	?>
</a>
</div>

<div class="skew-box secondary margin-top-small">CNCF
<?php echo esc_html( $spotlight_type ); ?> Spotlight</div>

<h5 class="spotlight-title"><a
	href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>

	<span class="archive-date date-icon spotlight-date">
<?php echo get_the_date( 'F j, Y' ); ?></span>

<?php echo esc_html( $subtitle ); ?>

</div>
