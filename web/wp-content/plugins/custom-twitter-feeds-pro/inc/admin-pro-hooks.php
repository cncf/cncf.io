<?php
function ctf_admin_hide_unrelated_notices() {

	// Bail if we're not on a ctf screen or page.
	if ( ! isset( $_GET['page'] ) || ($_GET['page'] !== 'custom-twitter-feeds' && $_GET['page'] !== 'custom-twitter-feeds-sw') ) {
		return;
	}

	// Extra banned classes and callbacks from third-party plugins.
	$blacklist = array(
		'classes'   => array(),
		'callbacks' => array(
			'ctfdb_admin_notice', // 'Database for ctf' plugin.
		),
	);

	global $wp_filter;

	foreach ( array( 'user_admin_notices', 'admin_notices', 'all_admin_notices' ) as $notices_type ) {
		if ( empty( $wp_filter[ $notices_type ]->callbacks ) || ! is_array( $wp_filter[ $notices_type ]->callbacks ) ) {
			continue;
		}
		foreach ( $wp_filter[ $notices_type ]->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
					unset( $wp_filter[ $notices_type ]->callbacks[ $priority ][ $name ] );
					continue;
				}
				$class = ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) ? strtolower( get_class( $arr['function'][0] ) ) : '';
				if (
					! empty( $class ) &&
					strpos( $class, 'ctf' ) !== false &&
					! in_array( $class, $blacklist['classes'], true )
				) {
					continue;
				}
				if (
					! empty( $name ) && (
						strpos( $name, 'ctf' ) === false ||
						in_array( $class, $blacklist['classes'], true ) ||
						in_array( $name, $blacklist['callbacks'], true )
					)
				) {
					unset( $wp_filter[ $notices_type ]->callbacks[ $priority ][ $name ] );
				}
			}
		}
	}
}
add_action( 'admin_print_scripts', 'ctf_admin_hide_unrelated_notices' );

add_filter( 'ctf_admin_validate_include_replies', 'ctf_validate_include_replies', 10, 1 );
function ctf_validate_include_replies( $val, $type ) {
    if ( $val == 'on' ) {
        return true;
    } else {
        return false;
    }
}

add_filter( 'ctf_admin_set_include_replies', 'ctf_set_include_replies', 10, 1 );
function ctf_set_include_replies( $new_input ) {
    if ( version_compare( CTF_VERSION, '2.0', '>=' ) ) {
        if ( isset( $new_input ) ) {
            if ( isset( $new_input['includereplies'] ) && ($new_input['includereplies'] == 'on' || $new_input['includereplies'] == 'true')) {
                return true;
            } else {
                return false;
            }
        }
    }else{
    	if ( isset( $new_input ) && isset( $new_input['type'] ) ) {
    	    if ( isset( $new_input[$new_input['type'] . '_includereplies'] ) && $new_input[$new_input['type'] . '_includereplies'] == 'on' ) {
    	        return true;
    	    } else {
    	        return false;
    	    }
    	}
    }
}

add_filter( 'ctf_admin_set_include_retweets', 'ctf_set_include_retweets', 10, 1 );
function ctf_set_include_retweets( $new_input ) {
    if ( version_compare( CTF_VERSION, '2.0', '>=' ) ) {
        if ( isset( $new_input ) ) {
            if ( isset( $new_input['includeretweets'] ) && ($new_input['includeretweets'] == 'on' || $new_input['includeretweets'] == 'true')) {
                return true;
            } else {
                return false;
            }
        }
    }else{
        if ( isset( $new_input ) && isset( $new_input['type'] ) ) {
            if ( isset( $new_input[$new_input['type'] . '_includeretweets'] ) && $new_input[$new_input['type'] . '_includeretweets'] == 'on' ) {
                return true;
            } else {
                return false;
            }
        }
    }
}