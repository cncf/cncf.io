<?php
/**
 * 404 page
 *
 * 404 page content includes search.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main>
	<article class="container wrap">

		<div style="height:40px" aria-hidden="true" class="wp-block-spacer">
		</div>

		<div class="wp-block-image">
			<figure style="text-align:center">
				<img loading="eager" width="1000" height="1000" src="<?php Lf_Utils::get_image( '404.png', true ); ?>
" alt="Error 404, this page was not found"
style="max-height: 50vh; width: auto;">
			</figure>
		</div>

		<div style="height:40px" aria-hidden="true" class="wp-block-spacer">
		</div>

		<h1 class="has-text-align-center">The page you entered is out of sync
		</h1>

		<div style="height:50px" aria-hidden="true" class="wp-block-spacer is-style-30-50">
		</div>

		<?php
		get_template_part( 'components/search-form' );
		?>
	</article>
</main>
