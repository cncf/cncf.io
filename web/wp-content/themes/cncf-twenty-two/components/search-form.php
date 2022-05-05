<?php
/**
 * Search Form
 *
 * Used on 404 and search results page.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<form class="search-form" method="get" autocomplete="off"
	action="<?php echo esc_url( home_url() ); ?>" role="search">
	<label for="search-bar" class="screen-reader-text">Search
		CNCF</label>
	<input class="search-input" type="search" id="search-bar"
		value="<?php echo esc_attr( get_search_query() ); ?>" name="s"
		placeholder="I'm looking for..." title="Search CNCF site"
		autocapitalize="off" spellcheck="false" maxlength="98" required>
	<input class="wp-block-button__link has-no-padding" type="submit"
		value="Search" />
</form>
