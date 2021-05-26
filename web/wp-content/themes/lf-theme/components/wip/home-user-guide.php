<?php
/**
 * WIP - Home Hero
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<section class="user-guide">
	<div class="user-guide-wrapper">
		<div class="user-guide-box">

			<?php
			if ( wp_attachment_is_image( 62498 ) ) :
				?>
			<div class="user-guide-box-image newsroom-image-wrapper">
				<?php
				Lf_Utils::display_responsive_images( 62498, 'newsroom-540', '540px', 'archive-image' );
				?>
			</div>
						<?php
			endif;
			?>
			<div
				class="has-white-color has-pink-400-background-color has-text-color has-background home-padding user-guide-box-text">
				<a href="/enduser/" class="box-link"
					title="Explore end user community"></a>
				<h2>End Users</h2>
				<p>Accelerate your cloud native technology adoption in close collaboration with peers, project maintainers and CNCF.</p>
				<a href="/enduser/" class="arrow-cta has-white-color">Explore
					end user community</a>
			</div>
		</div>

		<div class="user-guide-box">

<?php
if ( wp_attachment_is_image( 62497 ) ) :
	?>
<div class="user-guide-box-image newsroom-image-wrapper">
	<?php
	Lf_Utils::display_responsive_images( 62497, 'newsroom-540', '540px', 'archive-image' );
	?>
</div>
			<?php
endif;
?>

		<div
			class="has-white-color has-purple-700-background-color has-text-color has-background home-padding user-guide-box-text">
			<a href="http://contribute.cncf.io/" class="box-link"
				title="Start contributing"></a>
			<h2>Contributors</h2>
			<p>Join our welcoming community of doers and contribute to advancing CNCF hosted projects.</p>
			<a href="http://contribute.cncf.io/"
				class="arrow-cta has-white-color">Start contributing</a>
		</div>
		</div>


		<div class="user-guide-box">

<?php
if ( wp_attachment_is_image( 62499 ) ) :
	?>
<div class="user-guide-box-image newsroom-image-wrapper">
	<?php
	Lf_Utils::display_responsive_images( 62499, 'newsroom-540', '540px', 'archive-image' );
	?>
</div>
			<?php
endif;
?>

		<div
			class="has-white-color has-tertiary-400-background-color has-text-color has-background home-padding user-guide-box-text">
			<a href="/about/join/" class="box-link"
				title="Become a member today"></a>
			<h2>Members</h2>
			<p>Build and shape the cloud native ecosystem and drive cross-company collaboration with more than 550 members.</p>
			<a href="/about/join/" class="arrow-cta has-white-color">Become a
				member today</a>
		</div>
		</div>
	</div>
</section>


<div style="height:80px" aria-hidden="true"
	class="wp-block-spacer is-style-80-responsive"></div>
