<?php
/**
 * Admin and Dashboard options
 *
 * Use to customise the WP Admin
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Move menu elements in WP Admin
 */
add_filter(
	'custom_menu_order',
	function () {
		return true;
	}
);
add_filter( 'menu_order', 'my_new_admin_menu_order' );

/**
 * New Admin Menu Order
 *
 * @param array $menu_order The menu order.
 */
function my_new_admin_menu_order( $menu_order ) {
	$new_positions = array(
		'upload.php' => 11,
		// 'edit.php?post_type=page' => 4,
	);
	/**
	 * Sorting
	 *
	 * @param array $array The menu order.
	 * @param array $a The menu order.
	 * @param array $b The menu order.
	 */
	function move_element( &$array, $a, $b ) {
		$out = array_splice( $array, $a, 1 );
		array_splice( $array, $b, 0, $out );
	}
	foreach ( $new_positions as $value => $new_index ) {
		if ( $current_index = array_search( $value, $menu_order ) ) { // phpcs:ignore
			move_element( $menu_order, $current_index, $new_index );
		}
	}
	return $menu_order;
};

/**
 * Add theme usage box into WordPress Dashboard
 */
function add_dashboard_widget_info() {
	wp_add_dashboard_widget( 'dashboard_widget_1', 'Website Details', 'website_details' );
}
add_action( 'wp_dashboard_setup', 'add_dashboard_widget_info' );

/**
 * Add content to new dashboard widget
 */
function website_details() {
	echo "<ul>
	<li><a href='#' target='_blank'>Link to editing guide will be here</a></li>
<li><strong>Developed By:</strong> <a href='mailto:cjyabraham@gmail.com'>Chris Abraham</a>, <a href='mailto:jim@thetwopercent.co.uk'>James Hunt</a></li>
<li><strong>Development Repo:</strong> <a href='https://github.com/cncf/cncf.io' target='_blank'>Github</a>
</li>
</ul>";
}


/**
 * Add custom post types to Dashboard
 *
 * @param int $items Number.
 */
function custom_glance_items( $items = array() ) {
	$post_types = array( 'cncf_webinar', 'cncf_event', 'cncf_case_study', 'cncf_case_study_ch', 'cncf_project', 'cncf_person' );

	foreach ( $post_types as $type ) {

		if ( ! post_type_exists( $type ) ) {
			continue;
		}

		$num_posts = wp_count_posts( $type );

		if ( $num_posts ) {

			$published = intval( $num_posts->publish );
			$post_type = get_post_type_object( $type );
			/* translators: %2$s is replaced with the number of translations */
			$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'your_textdomain' ); // phpcs:ignore
			$text = sprintf( $text, number_format_i18n( $published ) );

			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_type=%1$s">%2$s</a>', $type, $text ) . "\n";
			} else {
				$items[] = sprintf( '<span class="%1$s-count">%2$s</span>', $type, $text ) . "\n";
			}
		}
	}
	return $items;
}
add_filter( 'dashboard_glance_items', 'custom_glance_items', 10, 1 );

/**
 * Removes dashboard widgets.
 */
function remove_dashboard_widgets() {
	remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

/**
 * Add custom column headers to Webinars
 *
 * @param array $columns Admin columns.
 */
function set_custom_edit_cncf_webinar_columns( $columns ) {
	$date = $columns['date'];
	unset( $columns['date'] );

	$columns['cncf_webinar_date']             = 'Webinar Date';
	$columns['cncf_webinar_registration_url'] = 'Reg URL';
	$columns['cncf_webinar_recording_url']    = 'Rec URL';

	$columns['date'] = $date;

	return $columns;
}
add_filter( 'manage_cncf_webinar_posts_columns', 'set_custom_edit_cncf_webinar_columns' );

/**
 * Add custom column data to Webinars
 *
 * @param array $column Admin columns.
 * @param int   $post_id Post ID.
 */
function custom_cncf_webinar_column( $column, $post_id ) {
	switch ( $column ) {

		// gets the date of webinar.
		case 'cncf_webinar_date':
			echo esc_html( gmdate( 'F j, Y', strtotime( get_post_meta( $post_id, 'cncf_webinar_date', true ) ) ) );
			break;

		// displays if registration URL has been added and it is a URL.
		case 'cncf_webinar_registration_url':
			echo filter_var( get_post_meta( $post_id, 'cncf_webinar_registration_url', true ), FILTER_VALIDATE_URL ) ? 'Yes' : 'No';
			break;

		// displays if recording URL has been added.
		case 'cncf_webinar_recording_url':
			echo filter_var( get_post_meta( $post_id, 'cncf_webinar_recording_url', true ), FILTER_VALIDATE_URL ) ? 'Yes' : 'No';
			break;
	}
}
add_action( 'manage_cncf_webinar_posts_custom_column', 'custom_cncf_webinar_column', 10, 2 );

/**
 * Add custom column headers to Events
 *
 * @param array $columns Admin columns.
 */
function set_custom_edit_cncf_event_columns( $columns ) {
	$date = $columns['date'];
	unset( $columns['date'] );

	$columns['cncf_event_date_start'] = 'Start Date';
	$columns['cncf_event_logo']       = 'Logo';
	$columns['cncf_event_background'] = 'BG';
	$columns['date']                  = $date;

	return $columns;
}
add_filter( 'manage_cncf_event_posts_columns', 'set_custom_edit_cncf_event_columns' );

/**
 * Add custom column data to Events
 *
 * @param array $column Admin columns.
 * @param int   $post_id Post ID.
 */
function custom_cncf_event_column( $column, $post_id ) {
	switch ( $column ) {

		// gets the start date of event.
		case 'cncf_event_date_start':
			if ( get_post_meta( $post_id, 'cncf_event_date_start', true ) ) {
				echo esc_html( gmdate( 'F j, Y', strtotime( get_post_meta( $post_id, 'cncf_event_date_start', true ) ) ) );
			} else {
				echo 'TBC';
			}
			break;

		// displays if logo is present.
		case 'cncf_event_logo':
			echo get_post_meta( $post_id, 'cncf_event_logo', true ) ? 'Yes' : 'No';
			break;

		// displays if background is present.
		case 'cncf_event_background':
			echo get_post_meta( $post_id, 'cncf_event_background', true ) ? 'Yes' : 'No';
			break;
	}
}
add_action( 'manage_cncf_event_posts_custom_column', 'custom_cncf_event_column', 10, 2 );

/**
 * Sorting events in date order
 *
 * @param array $query The query duh.
 */
function set_events_admin_order( $query ) {
	// only apply on admin side.
	if ( ! is_admin() ) {
		return;
	}

	// check not main query or any other CPT other than Events.
	if ( ! $query->is_main_query() || 'cncf_event' != $query->get( 'post_type' ) ) {
		return;
	}

	$meta_query = array(
		'relation' => 'OR',
		array(
			'cncf_event_date_start' => array(
				'key' => 'cncf_event_date_start',
			),
		),
	);

	$query->set( 'meta_query', $meta_query );
	$query->set(
		'orderby',
		array(
			'cncf_event_date_start' => 'DESC',
		)
	);
	return $query;
}
add_filter( 'pre_get_posts', 'set_events_admin_order' );
