<?php
/**
 * People Block
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

// setup values.
global $post;
$person_id   = get_the_ID();
$person_slug = $post->post_name;
$company     = get_post_meta( get_the_ID(), 'lf_person_company', true );
$pronouns    = ucwords( get_post_meta( get_the_ID(), 'lf_person_pronouns', true ), $separators = " \t\r\n\f\v\\;/" );
$linkedin    = get_post_meta( get_the_ID(), 'lf_person_linkedin', true );
$twitter     = get_post_meta( get_the_ID(), 'lf_person_twitter', true );
$github      = get_post_meta( get_the_ID(), 'lf_person_github', true );
$wechat      = get_post_meta( get_the_ID(), 'lf_person_wechat', true );
$website     = get_post_meta( get_the_ID(), 'lf_person_website', true );
$youtube     = get_post_meta( get_the_ID(), 'lf_person_youtube', true );
$image_url   = get_post_meta( get_the_ID(), 'lf_person_image', true );
$location    = get_post_meta( get_the_ID(), 'lf_person_location', true );
$languages   = get_the_terms( get_the_ID(), 'lf-language' );
$projects    = get_the_terms( get_the_ID(), 'lf-project' );

global $wp;
$current_url = home_url( $wp->request );

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
			data-modal-slug="<?php echo esc_html( $person_slug ); ?>"
			data-modal-prefix-class="lf" data-modal-close-text="Close"
			class="js-modal button-reset" aria-label="Close">
	<?php endif; ?>
	<div class="background-image-wrapper people-profile-picture">
	<figure class="background-image-figure">
	<img loading="lazy" src="<?php echo esc_attr( $image_url ); ?>" >
	</figure>
	</div>
	<?php if ( $show_modal ) : ?>
	</button>
	<?php endif; ?>
	<!-- Name  -->
	<h4 class="people-title">
		<?php the_title(); ?>
			<?php
			if ( $pronouns ) {
				?>
				<span class='pronouns'>(<?php echo esc_html( $pronouns ); ?>)</span>
				<?php
			}
			?>
	</h4>
	<!-- Company  -->
	<?php
	if ( $company ) :
		?>
	<h5 class="people-company"><?php echo esc_html( $company ); ?></h5>
	<?php endif; ?>
	<div class="people-excerpt">
		<?php
		if ( $location ) {
			?>
			<p><span class="strong">Location:</span> <?php echo esc_html( $location ); ?> </p>
			<?php
		}
		?>
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
			data-modal-slug="<?php echo esc_html( $person_slug ); ?>"
			data-modal-prefix-class="lf" data-modal-close-text="Close" aria-label="Close"
			class="js-modal button smaller margin-top modal-<?php echo esc_html( $person_slug ); ?>">View profile</button>
		<!-- Modal -->
		<div class="modal-hide" id="modal-<?php echo esc_html( $person_id ); ?>"
			aria-hidden="true">
			<div class="modal-content-wrapper">
				<div class="profile__header">
					<div
						class="background-image-wrapper people-profile-picture">
						<figure class="background-image-figure">
						<img loading="lazy" src="<?php echo esc_attr( $image_url ); ?>" >
						</figure>
					</div>
				</div>
				<div class="modal__content">
					<h3 class="modal__title margin-reset">
						<?php the_title(); ?>
						<?php
						if ( $pronouns ) {
							?>
							<span class='pronouns'>(<?php echo esc_html( $pronouns ); ?>)</span>
							<?php
						}
						?>
					</h3>
					<?php
					if ( $company ) :
						?>
					<h5 class="margin-top-small ">
						<?php echo esc_html( $company ); ?></h5>
					<?php endif; ?>
						<?php the_content(); ?>
					<?php
					if ( $location ) {
						?>
						<p><span class="strong">Location:</span> <?php echo esc_html( $location ); ?> </p>
						<?php
					}

					if ( $languages ) {
						?>
						<p><span class="strong">Languages:</span>
						<?php
						$comma = '';
						$out = '';
						foreach ( $languages as $language ) {
							$out .= esc_html( $comma ) . '<a href="' . $current_url . '/?_sft_lf-language=' . $language->slug . '">' . esc_html( $language->name ) . '</a>';
							$comma = ', ';
						}
						echo $out; //phpcs:ignore
						?>
						</p>
						<?php
					}

					if ( $projects ) {
						?>
						<p><span class="strong">Specialties:</span>
						<?php
						$comma = '';
						$out = '';
						foreach ( $projects as $project ) {
							$out .= esc_html( $comma ) . '<a href="' . $current_url . '/?_sft_lf-project=' . $project->slug . '">' . esc_html( $project->name ) . '</a>';
							$comma = ', ';
						}
						echo $out; //phpcs:ignore
						?>
						</p>
						<?php
					}
					?>
				</div>
			</div>
		</div>
			<?php endif; ?>
	</div>
</div><!-- end of people box  -->
