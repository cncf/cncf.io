<?php
/**
 * Single speaker page template.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

global $post;

$image = new Image();

$user = get_userdata( $post->post_name );

$um_user = um_fetch_user( $user->ID );
$display_name = um_user( 'display_name' );

// get default picture size from UM.
$default_size = UM()->options()->get( 'profile_photosize' );
$default_size = str_replace( 'px', '', $default_size );

?>

<div class="speaker">
	<div class="speaker-photo">
		<a href="<?php echo esc_url( um_user_profile_url() ); ?>"
			title="<?php echo esc_attr( $display_name ); ?>">
			<?php echo get_avatar( um_user( 'ID' ), $default_size ); ?>
		</a>
	</div>
	<h5 class="speaker-title margin-reset margin-top-small"><a
			href="<?php echo esc_url( um_user_profile_url( $user->ID ) ); ?>"
			title="<?php echo esc_attr( $display_name ); ?>"><?php echo esc_html( $display_name ); ?></a>
	</h5>

	<?php
	if ( um_user( 'country' ) ) :
		$country_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-country', true );
		$country_link = '/speakers/?_sft_lf-country=' . $country_slug;
		?>
	<a
		class="speaker-location skew-box secondary margin-top centered" title="See more speakers from <?php echo esc_attr( um_user( 'country' ) ); ?>" href="<?php echo esc_url( $country_link ); ?>"><?php echo esc_html( um_user( 'country' ) ); ?>
	</a>
	<?php endif; ?>

	<div class="speaker-badges">
		<?php
		$travel_range = um_user( 'lf_travel_range' );
		?>
		<?php if ( 'International' == $travel_range ) : ?>
		<div class="column">

		<span class="hint--top" aria-label="Willing to travel internationally">
			<?php $image->get_svg( 'speakers/international.svg' ); ?>
		</span>
		</div>
		<?php endif; ?>
		<?php
		$affiliations = um_user( 'sb_certifications' );
		if ( is_array( $affiliations ) ) {
			foreach ( $affiliations as $affiliation ) {
				if ( 'CKA' == $affiliation ) :
					?>
		<div class="column">

		<span class="hint--top" aria-label="CKA - Certified Kubernetes Administrator">
					<?php $image->get_svg( 'speakers/cka-logo.svg' ); ?>
		</span>

		</div>
					<?php
				endif;
				if ( 'CKAD' == $affiliation ) :
					?>
		<div class="column">

		<span class="hint--top" aria-label="CKAD - Certified Kubernetes Application Developer">
					<?php $image->get_svg( 'speakers/ckad-logo.svg' ); ?>
		</span>

		</div>
					<?php
				endif;
				if ( 'Ambassador' == $affiliation ) :
					?>
		<div class="column">

		<span class="hint--top" aria-label="CNCF Ambassador">
					<?php $image->get_svg( 'speakers/ambassador.svg' ); ?>
		</span>

		</div>
					<?php
				endif;
			}
		}
		?>
	</div>
</div>
