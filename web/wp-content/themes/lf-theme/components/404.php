<?php
/**
 * 404 page
 *
 * Shown when a page is not found.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$image = new Image();
?>

<section class="four-oh-four">
	<div class="container wrap">

		<img src="<?php $image->get_svg( '404-phippy.svg', true ); ?>" alt="Phippy says Sorry!" class="image-404">

<div class="content-404">
		<span class="extremely-large secondary">404</span>
		<h3 class="margin-y-small">Sorry that page wasn't found.</h3>

		<form role="search" method="get" class="error-search-form"
			action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div>
				<label>
					<span class="search-text">Search the site</span><br/>

				<input type="search" class="search-field margin-y"
						placeholder="Enter search term"
						value="<?php echo get_search_query(); ?>" name="s"
						title="Search for" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
				</label>
			</div>
			<div>
				<input type="submit" class="button"
					value="Search" />
			</div>
		</form>

<p class="margin-top-large">or go to CNCF homepage</p>
		<a href="/" class="button">Go to Homepage</a>
		</div>
	</div>
</section>
