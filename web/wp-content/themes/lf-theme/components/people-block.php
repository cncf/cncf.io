<?php
/**
 * People Block
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// setup values.
$person_id = get_the_ID();
$company   = get_post_meta( get_the_ID(), 'lf_person_company', true );
$linkedin  = get_post_meta( get_the_ID(), 'lf_person_linkedin', true );
$twitter   = get_post_meta( get_the_ID(), 'lf_person_twitter', true );
$github    = get_post_meta( get_the_ID(), 'lf_person_github', true );
$wechat    = get_post_meta( get_the_ID(), 'lf_person_wechat', true );
$website   = get_post_meta( get_the_ID(), 'lf_person_website', true );
$youtube   = get_post_meta( get_the_ID(), 'lf_person_youtube', true );

// setup image class.
$image = new Image();
// check to see if profile button should be shown.
$content = get_the_content();
if ( strlen( $content ) > 20 ) {
	$show_modal = true;
} else {
	$show_modal = false;
}
?>
<div class="people-box">
	<!-- thumbnail  -->
	<?php if ( $show_modal ) : ?>
		<button
			data-modal-content-id="modal-<?php echo esc_html( $person_id ); ?>"
			data-modal-prefix-class="lf" data-modal-close-text="Close"
			class="js-modal button-reset">
	<?php endif; ?>
	<div class="background-image-wrapper people-profile-picture">
	<figure class="background-image-figure">
	<?php
	if ( has_post_thumbnail() ) {
		LF_Utils::display_responsive_images( get_post_thumbnail_id(), 'people-250', '400px' );
	} else {
		$options = get_option( 'lf-mu' );
		LF_Utils::display_responsive_images( $options['generic_avatar_id'], 'people-250', '400px' );
	}
	?>
	</figure>
	</div>
	<?php if ( $show_modal ) : ?>
	</button>
	<?php endif; ?>
	<!-- Name  -->
	<h4 class="people-title"><?php the_title(); ?></h4>
	<!-- Company  -->
	<?php
	if ( $company ) :
		?>
	<h5 class="people-company"><?php echo esc_html( $company ); ?></h5>
	<?php endif; ?>
	<div class="people-excerpt">
		<?php the_excerpt(); ?>
	</div>
<div class="social-modal-wrapper">
	<?php
		// Social Icons.
	if ( $linkedin || $twitter || $github || $wechat || $website || $youtube ) :
		?>
		<div class="people-social">
		<?php
		if ( $linkedin ) :
			?>
			<a href="<?php echo esc_url( $linkedin ); ?>"
				rel="noopener"
				target="_blank"><?php $image->get_svg( 'social/linkedin.svg' ); ?></a>
				<?php
		endif;
		if ( $twitter ) :
			?>
			<a href="<?php echo esc_url( $twitter ); ?>" target="_blank"
				rel="noopener"
				target="_blank"><?php $image->get_svg( 'social/twitter.svg' ); ?></a>
				<?php
		endif;
		if ( $github ) :
			?>
			<a href="<?php echo esc_url( $github ); ?>" target="_blank"
				rel="noopener"
				target="_blank"><?php $image->get_svg( 'social/github.svg' ); ?></a>
				<?php
		endif;
		if ( $wechat ) :
			?>
			<a href="<?php echo esc_url( $wechat ); ?>" target="_blank"
				rel="noopener"
				target="_blank"><?php $image->get_svg( 'social/wechat.svg' ); ?></a>
				<?php
		endif;
		if ( $website ) :
			?>
			<a href="<?php echo esc_url( $website ); ?>" target="_blank"
				rel="noopener"
				target="_blank"><?php $image->get_svg( 'social/website.svg' ); ?></a>
				<?php
		endif;
		if ( $youtube ) :
			?>
			<a href="<?php echo esc_url( $youtube ); ?>" target="_blank"
				rel="noopener"
				target="_blank"><?php $image->get_svg( 'social/youtube.svg' ); ?></a>
				<?php
		endif;
		?>
		</div>
		<?php endif; ?>
		<?php
		if ( $show_modal ) :
			// View Profile Button.
			?>
		<button
			data-modal-content-id="modal-<?php echo esc_html( $person_id ); ?>"
			data-modal-prefix-class="lf" data-modal-close-text="Close"
			class="js-modal button smaller margin-top">View profile</button>
		<!-- Modal -->
		<div class="modal-hide" id="modal-<?php echo esc_html( $person_id ); ?>"
			aria-hidden="true">
			<div class="modal-content-wrapper">
				<div class="profile__header">
					<?php
					if ( has_post_thumbnail() ) :
						?>
					<div
						class="background-image-wrapper people-profile-picture">
						<figure class="background-image-figure">
						<?php
						if ( has_post_thumbnail() ) {
							LF_Utils::display_responsive_images( get_post_thumbnail_id(), 'people-250', '400px' );
						} else {
							$options = get_option( 'lf-mu' );
							LF_Utils::display_responsive_images( $options['generic_avatar_id'], 'people-250', '400px' );
						}
						?>
						</figure>
					</div>
						<?php
						endif;
					?>
				</div>
				<div class="modal__content">
					<h3 class="modal__title margin-reset">
						<?php the_title(); ?></h3>
					<?php
					if ( $company ) :
						?>
					<h5 class="margin-top-small ">
						<?php echo esc_html( $company ); ?></h5>
					<?php endif; ?>
						<?php the_content(); ?>
				</div>
			</div>
		</div>
			<?php endif; ?>
	</div>
</div><!-- end of people box  -->
