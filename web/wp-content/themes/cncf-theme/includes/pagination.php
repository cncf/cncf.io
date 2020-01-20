<?php

/**
 * numeric_posts_nav - TODO: replace?
 *
 * @method numeric_posts_nav
 *
 * @param [query object] $custom_query [if not paginating for default WP_Query, pass in custom query object to paginate properly]
 *
 * @return [null] [prints/echos the prev/next and numeric page links]
 */
function numeric_posts_nav( $custom_query = null ) {
	// set here to only work on some posts types
	// if ( is_singular() ) {
	// return;
	// }
	global $wp_query;
	if ( $custom_query !== null ) {
		// store global $wp_query so that get_previous_posts_link() and get_next_posts_link() work properly
		$default_query = $wp_query;
		$wp_query      = $custom_query;
		$current_query = $custom_query;
	} else {
		$current_query = $wp_query;
	}
	/* Stop execution if there's only 1 page */
	if ( $current_query->max_num_pages <= 1 ) {
		return;
	}
	$paged    = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max      = intval( $wp_query->max_num_pages );
	$li_count = 0;
	/*  Add current page to the array */
	if ( $paged >= 1 ) {
		$links[] = $paged;
	}
	/*  Add the pages around the current page to the array */
	if ( $paged >= 4 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
		$links[] = $paged - 3;
	}
	if ( ( $paged + 4 ) <= $max ) {
		$links[] = $paged + 3;
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}
	if ( ( $paged === 3 ) || ( $paged === 6 ) ) {
		$links[] = 2;
	}
	echo '<nav class="pagination"><ul>' . "\n";
	/*  Previous Post Link */
	if ( get_previous_posts_link() ) {
		printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link( '<i class="fa fa-angle-left" aria-hidden="true"></i> Prev' ) );
	} else {
		printf( '<li class="prev inactive">%s</li>' . "\n", '<span><i class="fa fa-angle-left" aria-hidden="true"></i> Prev</span>' );
	}
	/*  Link to first 9 pages if current page is not one of the 'middle' links */
	if ( $paged <= 9 ) {
		$i = 1;
		while ( ( ( $paged + $i ) <= 9 ) && ( ( $paged + $i ) <= $max ) ) {
			$links[] = $paged + $i;
			++$i;
		}
	}
	/*  Link to last 9 pages if current page is not one of the 'middle' links */
	if ( ( $paged >= ( $max - 5 ) ) && ( ( $max - 5 ) >= 1 ) ) {
		$i = $max - min( array( 8, $max - 1 ) );
		while ( $i <= $max ) {
			$links[] = $i;
			++$i;
		}
	}
	/*  Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 === $paged ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );
		++$li_count;
		if ( ! in_array( 2, $links ) ) {
			echo '<li><span>&#8230;</span></li>';
			++$li_count;
		}
	}
	/*  Link to current page, plus pages in either direction if necessary */
	sort( $links );
	$links = array_unique( $links );
	foreach ( $links as $link ) {
		$class = $paged === $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		++$li_count;
	}
	/*  Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) ) {
			echo '<li><span>&#8230;</span></li>' . "\n";
			++$li_count;
		}
		$class = $paged === $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		++$li_count;
	}
	/*  Next Post Link */
	if ( get_next_posts_link() ) {
		printf( '<li class="next">%s</li>' . "\n", get_next_posts_link( 'Next <i class="fa fa-angle-right" aria-hidden="true"></i>' ) );
	} else {
		printf( '<li class="next inactive">%s</li>' . "\n", '<span>Next <i class="fa fa-angle-right" aria-hidden="true"></i></span>' );
	}
	echo '</ul></nav>' . "\n";
	// reset global $wp_query
	if ( $custom_query !== null ) {
		$wp_query = $default_query;
	}
}
