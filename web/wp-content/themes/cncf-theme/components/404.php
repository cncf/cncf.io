<?php
/**
 * 404 page
 *
 * Shown when a page is not found.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$image = new Image();
?>

<section class="four-oh-four">
	<div class="container wrap page-padding">

		<img src="<?php $image->get_svg( '404-phippy.svg', true ); ?>" alt="Phippy says Sorry!" class="image-404">

<div class="content-404">
		<span class="extremely-large secondary">404</span>
		<p class="upper h3 secondary">Page not found</p>
		<form role="search" method="get" class="search-form"
			action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<div>
				<label>
					<span class="search-text"><?php esc_attr_e( 'Search the site:', 'label' ); ?></span>
					<input type="search" class="search-field"
						placeholder="<?php echo esc_attr_e( 'Enter search term', 'placeholder' ); ?>"
						value="<?php echo get_search_query(); ?>" name="s"
						title="<?php echo esc_attr_e( 'Search for:', 'label' ); ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
				</label>
			</div>
			<div>
				<input type="submit" class="button"
					value="<?php esc_attr_e( 'Search', 'submit button' ); ?>" />
			</div>
		</form>

<p>or go to CNCF homepage</p>
		<a href="/" class="button">Go to Homepage</a>
		</div>
	</div>
</section>
