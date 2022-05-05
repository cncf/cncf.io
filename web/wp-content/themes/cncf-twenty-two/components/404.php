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
			<figure class="aligncenter size-full">
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

		<form class="search-form" method="get" autocomplete="off"
			action="<?php echo esc_url( home_url() ); ?>" role="search">
			<label for="search-bar" class="screen-reader-text">Search
				CNCF</label>
			<input class="search-input" type="search" id="search-bar"
				value="<?php echo esc_attr( get_search_query() ); ?>" name="s"
				placeholder="I'm looking for..." title="Search CNCF site"
				autocapitalize="off"
				spellcheck="false" maxlength="98" required>
			<input
				class="wp-block-button__link has-no-padding"
				type="submit" value="Search" />
		</form>
	</article>
</main>
