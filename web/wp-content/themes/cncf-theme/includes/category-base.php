<?php
/**
 * Remove category base
 *
 * Remove the /category/ base from the blog and associated links with this. Upon adding or removing, refresh rules using wp rewrite flush via WP-CLI or by saving permalinks.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Flushes rules whenever categorys are changed.
 *
 * @return void
 */
function remove_category_url_refresh_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/**
 * Removes category base.
 *
 * @return void
 */
function remove_category_url_permastruct() {
	global $wp_rewrite;
		$wp_rewrite->extra_permastructs['category'][0] = '%category%';
}

/**
 * Adds custom category rewrite rules.
 *
 * @param array $category_rewrite Category rewrite rules.
 *
 * @return array
 */
function remove_category_url_rewrite_rules( $category_rewrite ) {
	global $wp_rewrite;

	$category_rewrite = array();
	$categories       = get_categories( array( 'hide_empty' => false ) );

	foreach ( $categories as $category ) {
		$category_nicename = $category->slug;
		if ( $category->parent == $category->cat_ID ) {
			$category->parent = 0;
		} elseif ( 0 != $category->parent ) {
			$category_nicename = get_category_parents( $category->parent, false, '/', true ) . $category_nicename;
		}
		$category_rewrite[ '(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$' ] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite[ '(' . $category_nicename . ')/page/?([0-9]{1,})/?$' ]                  = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite[ '(' . $category_nicename . ')/?$' ]                                    = 'index.php?category_name=$matches[1]';
	}

	// Redirect support from Old Category Base.
	$old_category_base                                 = get_option( 'category_base' ) ? get_option( 'category_base' ) : 'category';
	$old_category_base                                 = trim( $old_category_base, '/' );
	$category_rewrite[ $old_category_base . '/(.*)$' ] = 'index.php?category_redirect=$matches[1]';

	return $category_rewrite;
}

/**
 * Adds 'category_redirect' query variable
 *
 * @param array $public_query_vars Category rewrite rules.
 *
 * @return array $public_query_vars
 */
function remove_category_url_query_vars( $public_query_vars ) {
	$public_query_vars[] = 'category_redirect';

	return $public_query_vars;
}

/**
 * Handles category redirects. Redirects if 'category_redirect' is set.
 *
 * @param array $query_vars Current query vars.
 *
 * @return array $query_vars Or void if category_redirect is present.
 */
function remove_category_url_request( $query_vars ) {
	if ( isset( $query_vars['category_redirect'] ) ) {
		$catlink = trailingslashit( get_option( 'home' ) ) . user_trailingslashit( $query_vars['category_redirect'], 'category' );
		status_header( 301 );
		header( "Location: $catlink" );
		exit;
	}

	return $query_vars;
}

// Actions.
add_action( 'created_category', 'remove_category_url_refresh_rules' );
add_action( 'delete_category', 'remove_category_url_refresh_rules' );
add_action( 'edited_category', 'remove_category_url_refresh_rules' );
add_action( 'init', 'remove_category_url_permastruct' );

// Filters.
add_filter( 'category_rewrite_rules', 'remove_category_url_rewrite_rules' );
add_filter( 'query_vars', 'remove_category_url_query_vars' );
add_filter( 'request', 'remove_category_url_request' );
