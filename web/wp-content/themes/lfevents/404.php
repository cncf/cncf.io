<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

get_header(); ?>

<div class="main-container">
	<div class="main-grid">
		<main class="main-content">
			<article>
				<header>
					<h1 class="entry-title"><?php _e( 'File Not Found', 'foundationpress' ); // phpcs:ignore ?></h1>
				</header>
				<div class="entry-content">
					<div class="error">
						<p class="bottom"><?php _e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'foundationpress' ); // phpcs:ignore ?></p>
					</div>
					<p><?php _e( 'Please try the following:', 'foundationpress' ); // phpcs:ignore ?></p>
					<ul>
						<li>
							<?php _e( 'Check your spelling', 'foundationpress' ); // phpcs:ignore ?>
						</li>
						<li>
							<?php
								/* translators: %s: home page url */
								printf(
									__( 'Return to the <a href="%s">home page</a>', 'foundationpress' ), // phpcs:ignore
									home_url() // phpcs:ignore
								);
								?>
						</li>
						<li>
							<?php _e( 'Click the <a href="javascript:history.back()">Back</a> button', 'foundationpress' ); // phpcs:ignore?>
						</li>
					</ul>
				</div>
			</article>
		</main>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php
get_footer();
