<?php
require_once CTF_URL . '/inc/widget.php';
require_once CTF_URL . '/inc/admin-pro-hooks.php';

use TwitterFeed\CtfAdmin;
use TwitterFeed\CtfFeedPro;
use TwitterFeed\CTF_Tracking;
use TwitterFeed\CTF_GDPR_Integrations;
use TwitterFeed\CTF_Feed_Locator;
use TwitterFeed\EDD_SL_Plugin_Updater;
use TwitterFeed\Pro\CTF_Feed_Pro;
use TwitterFeed\Pro\CTF_Display_Elements_Pro;
use TwitterFeed\Pro\CTF_Parse_Pro;
use TwitterFeed\Pro\CTF_Settings_Pro;
use TwitterFeed\Pro\CTF_Twitter_Card_Generator;
use TwitterFeed\Pro\CTF_Twitter_Card_Manager;
use TwitterFeed\Pro\CTF_Resizer;
use TwitterFeed\Pro\CTF_Post_Record;
use TwitterFeed\Admin\CTF_Global_Settings;
use TwitterFeed\Admin\CTF_Support;
use TwitterFeed\Admin\CTF_About_Us;
use TwitterFeed\Admin\CTF_Admin_Notices;
use TwitterFeed\Admin\CTF_Notifications;
use TwitterFeed\Admin\CTF_New_User;
use TwitterFeed\Blocks\CTF_Blocks;
use TwitterFeed\CtfDateTime;
use TwitterFeed\Builder\CTF_Feed_Saver;




/**
* include the admin files only if in the admin area
*/
if ( is_admin() ) {
	$admin = new CtfAdmin();
}

/**
 * May include support for templates in theme folders in the future
 *
 * @return string full path to template
 *
 * @since 5.2 custom templates supported
 */
function ctf_get_feed_template_part( $part, $settings = array() ) {
	$options = get_option( 'ctf_options', array() );

	$file                        = '';
	$settings['customtemplates'] = isset( $options['customtemplates'] ) ? $options['customtemplates'] === 'true' || $options['customtemplates'] === 'on' || $options['customtemplates'] === true : false;
	/**
	 * Whether or not to search for custom templates in theme folder
	 *
	 * @param boolean  Setting from DB or shortcode to use custom templates
	 *
	 * @since 5.2
	 */
	$using_custom_templates_in_theme = apply_filters( 'ctf_use_theme_templates', $settings['customtemplates'] );
	$generic_path                    = trailingslashit( CTF_PLUGIN_DIR ) . 'templates/';

	if ( $using_custom_templates_in_theme == true ) {
		$custom_header_template         = locate_template( 'ctf/header.php', false, false );
		$custom_header_generic_template = locate_template( 'ctf/header-generic.php', false, false );
		$custom_header_text_template    = locate_template( 'ctf/header-text.php', false, false );
		$custom_item_template           = locate_template( 'ctf/item.php', false, false );
		$custom_footer_template         = locate_template( 'ctf/footer.php', false, false );
		$custom_feed_template           = locate_template( 'ctf/feed.php', false, false );
		$custom_author_template         = locate_template( 'ctf/author.php', false, false );
		$custom_media_template          = locate_template( 'ctf/media.php', false, false );
		$custom_linkbox_template        = locate_template( 'ctf/linkbox.php', false, false );

	} else {
		$custom_header_template         = false;
		$custom_header_generic_template = false;
		$custom_item_template           = false;
		$custom_footer_template         = false;
		$custom_feed_template           = false;
		$custom_author_template         = false;
		$custom_media_template          = false;
		$custom_linkbox_template        = false;
	}

	if ( $part === 'header' ) {
		if ( $custom_header_template ) {
			$file = $custom_header_template;
		} else {
			$file = $generic_path . 'header.php';
		}
	} if ( $part === 'header-generic' ) {
		if ( $custom_header_generic_template ) {
			$file = $custom_header_generic_template;
		} else {
			$file = $generic_path . 'header-generic.php';
		}
	}  if ( $part === 'header-text' ) {
		if ( $custom_header_generic_template ) {
			$file = $custom_header_text_template;
		} else {
			$file = $generic_path . 'header-text.php';
		}
	} elseif ( $part === 'item' ) {
		if ( $custom_item_template ) {
			$file = $custom_item_template;
		} else {
			$file = $generic_path . 'item.php';
		}
	} elseif ( $part === 'footer' ) {
		if ( $custom_footer_template ) {
			$file = $custom_footer_template;
		} else {
			$file = $generic_path . 'footer.php';
		}
	} elseif ( $part === 'feed' ) {
		if ( $custom_feed_template ) {
			$file = $custom_feed_template;
		} else {
			$file = $generic_path . 'feed.php';
		}
	} elseif ( $part === 'author' ) {
		if ( $custom_author_template ) {
			$file = $custom_author_template;
		} else {
			$file = $generic_path . 'author.php';
		}
	} elseif ( $part === 'media' ) {
		if ( $custom_media_template ) {
			$file = $custom_media_template;
		} else {
			$file = $generic_path . 'media.php';
		}
	} elseif ( $part === 'linkbox' ) {
		if ( $custom_media_template ) {
			$file = $custom_linkbox_template;
		} else {
			$file = $generic_path . 'linkbox.php';
		}
	}

	return $file;
}

/**
 * Generates the Twitter feed wherever the shortcode is placed
 *
 * @param $atts array shortcode arguments
 *
 * @return string
 */
function ctf_init( $atts, $preview_settings = false ) {
	wp_enqueue_script( 'ctf_scripts' );
	$twitter_feed = CtfFeedPro::init( $atts, null, 0, array(), 1, $preview_settings );
	if ( isset( $twitter_feed->feed_options['feederror'] ) && ! empty( $twitter_feed->feed_options['feederror'] ) ) {
			return "<span id='ctf-no-id'>" . sprintf( __( 'No feed found with the ID %1$s. Go to the %2$sAll Feeds page%3$s and select an ID from an existing feed.', 'custom-twitter-feeds' ), esc_html( $twitter_feed->feed_options['feed'] ), '<a href="' . esc_url( admin_url( 'admin.php?page=ctf-feed-builder' ) ) . '">', '</a>' ) . '</span><br /><br />';
	} else {
		// if there is an error, display the error html, otherwise the feed
		if ( ! $twitter_feed->tweet_set || $twitter_feed->missing_credentials || ! isset( $twitter_feed->tweet_set[0]['created_at'] ) ) {
			if ( ! empty( $twitter_feed->tweet_set['errors'] ) ) {
				$twitter_feed->maybeCacheTweets();
			}
			return $twitter_feed->getErrorHtml();
		} else {
			if ( ! $twitter_feed->feed_options['persistentcache'] ) {
				$twitter_feed->maybeCacheTweets();
			}
			$feed_html  = '';
			$feed_html .= $twitter_feed->getTweetSetHtml();

			return $feed_html;
		}
	}
}
add_shortcode( 'custom-twitter-feed', 'ctf_init' );
add_shortcode( 'custom-twitter-feeds', 'ctf_init' );

/**
* Called via ajax to get more posts after the "load more" button is clicked
*/
function ctf_get_more_posts() {
	$shortcode_data = ! empty( $_POST['shortcode_data'] ) ? json_decode( str_replace( array( '\"', "\\'" ), array( '"', "'" ), sanitize_text_field( wp_unslash( $_POST['shortcode_data'] ) ) ), true ) : array(); // necessary to unescape quotes
	$last_id_data   = isset( $_POST['last_id_data'] ) ? sanitize_text_field( $_POST['last_id_data'] ) : '';
	$num_needed     = isset( $_POST['num_needed'] ) ? (int) $_POST['num_needed'] : 0;
	$ids_to_remove  = isset( $_POST['ids_to_remove'] ) ? $_POST['ids_to_remove'] : array();
	$feed           = isset( $_POST['v2feed'] ) ? sanitize_key( $_POST['v2feed'] ) : '';
	if ( empty( $shortcode_data ) ) {
		$shortcode_data = array();
	}
	$shortcode_data['feed'] = $feed;

	$is_pagination    = empty( $last_id_data ) ? 0 : 1;
	$persistent_index = isset( $_POST['persistent_index'] ) ? sanitize_text_field( $_POST['persistent_index'] ) : '';

	$twitter_feed = CtfFeedPro::init( $shortcode_data, $last_id_data, $num_needed, $ids_to_remove, $persistent_index );

	if ( ! $twitter_feed->feed_options['persistentcache'] ) {
		$twitter_feed->maybeCacheTweets();
	}

	echo $twitter_feed->getItemSetHtml( $is_pagination );

	$resizer = new CTF_Resizer( $twitter_feed->ids_in_set_w_media, $twitter_feed->feedID(), $twitter_feed->tweet_set, $twitter_feed->feed_options );
	if ( ! $resizer->image_resizing_disabled() ) {
		$resizer->do_resizing();
	}
	$atts = $shortcode_data;

	$feed_id      = isset( $_POST['feed_id'] ) ? sanitize_text_field( $_POST['feed_id'] ) : 'unknown';
	$location     = isset( $_POST['location'] ) && in_array( $_POST['location'], array( 'header', 'footer', 'sidebar', 'content' ), true ) ? sanitize_text_field( $_POST['location'] ) : 'unknown';
	$post_id      = isset( $_POST['post_id'] ) && $_POST['post_id'] !== 'unknown' ? (int) $_POST['post_id'] : 'unknown';
	$feed_details = array(
		'feed_id'  => $feed_id,
		'atts'     => $atts,
		'location' => array(
			'post_id' => $post_id,
			'html'    => $location,
		),
	);

	ctf_do_background_tasks( $feed_details );

	echo ctf_add_resized_image_data( $twitter_feed->feedID(), $twitter_feed->ids_in_set_w_media, $twitter_feed->feed_options );

	die();
}
add_action( 'wp_ajax_nopriv_ctf_get_more_posts', 'ctf_get_more_posts' );
add_action( 'wp_ajax_ctf_get_more_posts', 'ctf_get_more_posts' );

function ctf_resized_image_html( $twitter_feed, $feed_id ) {
	echo ctf_add_resized_image_data( $twitter_feed->feedID(), $twitter_feed->ids_in_set_w_media, $twitter_feed->feed_options );
}
add_action( 'ctf_before_feed_end', 'ctf_resized_image_html', 10, 2 );


function ctf_maybe_ajax_theme_html( $twitter_feed, $feed_id ) {
	$options = ctf_get_database_settings();
	if ( $options['ajax_theme'] ) {
		echo CTF_Display_Elements_Pro::get_ajax_code( $options );
	}
}
add_action( 'ctf_before_feed_end', 'ctf_maybe_ajax_theme_html', 10, 2 );

/**
 * Debug report added at the end of the feed when sbi_debug query arg is added to a page
 * that has the feed on it.
 *
 * @param object $twitter_feed
 * @param string $feed_id
 */
function ctf_debug_report( $twitter_feed, $feed_id ) {

	if ( ! isset( $_GET['sbi_debug'] ) && ! isset( $_GET['sb_debug'] ) ) {
		return;
	}

	$settings_obj = new CTF_Settings_Pro( array(), array() );

	$settings = $twitter_feed->feed_options;

	$public_settings_keys = CTF_Settings_Pro::get_public_db_settings_keys();
	?>

	<p>Status</p>
	<ul>
		<li>Time: <?php echo esc_html( date( 'Y-m-d H:i:s', time() ) ); ?></li>

	</ul>
	<p>Settings</p>
	<ul>
		<?php
		foreach ( $public_settings_keys as $key ) :
			if ( isset( $settings[ $key ] ) ) :
				?>
			<li>
				<small><?php echo esc_html( $key ); ?>:</small>
							<?php
							if ( ! is_array( $settings[ $key ] ) ) :
								echo esc_html( $settings[ $key ] );
							else :
								?>
					<ul>
								<?php
								foreach ( $settings[ $key ] as $sub_key => $value ) {
									echo '<li><small>' . esc_html( $sub_key ) . ':</small> ' . esc_html( $value ) . '</li>';
								}
								?>
					</ul>
							<?php endif; ?>
			</li>

					<?php
		endif;
endforeach;
		?>
	</ul>
	<p>GDPR</p>
	<ul>
		<?php
		$statuses = CTF_GDPR_Integrations::statuses();
		foreach ( $statuses as $status_key => $value ) :
			?>
			<li>
				<small><?php echo esc_html( $status_key ); ?>:</small>
				<?php
				if ( $value == 1 ) {
					echo 'success';
				} else {
					echo 'failed'; }
				?>
			</li>

		<?php endforeach; ?>
		<li>
			<small>Enabled:</small>
			<?php echo CTF_GDPR_Integrations::doing_gdpr( $settings ); ?>
		</li>
	</ul>
	<?php
}
add_action( 'ctf_before_feed_end', 'ctf_debug_report', 99, 2 );

/**
 * the html output is controlled by the user selecting which portions of tweets to show
 *
 * @param $part string          part of the feed in the html
 * @param $feed_options array   options that contain what parts of the tweet to show
 * @return bool                 whether or not to show the tweet
 */
function ctf_show( $part, $feed_options ) {
	if ( ctf_doing_customizer( $feed_options ) ) {
		return true;
	}

	$tweet_excludes = isset( $feed_options['tweet_excludes'] ) ? $feed_options['tweet_excludes'] : '';
	$tweet_includes = isset( $feed_options['tweet_includes'] ) ? $feed_options['tweet_includes'] : '';

	// if part is in the array of excluded parts or not in the array of included parts, don't show
	if ( ! empty( $tweet_excludes ) ) {
		return ( in_array( $part, $tweet_excludes ) === false );
	} else {
		return ( in_array( $part, $tweet_includes ) === true );
	}
}

function ctf_get_database_settings() {
	$options = get_option( 'ctf_options', array() );
	$options = set_global_default_settings( $options );
	return $options;
}

function set_global_default_settings( $options ) {
	$defaults = array(
		'disableintents' => false,
		'creditctf'      => false,
		'ajax_theme'     => false,
	);
	foreach ( $defaults as $key => $value ) {
		if ( ! isset( $options[ $key ] ) ) {
			$options[ $key ] = $value;
		}
	}
	return $options;
}

function ctf_get_fa_el( $icon ) {
	$options     = get_option( 'ctf_options' );
	$font_method = isset( $options['font_method'] ) ? $options['font_method'] : 'svg';

	$elems = array(
		'fa-arrows-alt'   => array(
			'icon' => '<span class="fa fa-arrows-alt"></span>',
			'svg'  => '<svg class="svg-inline--fa fa-arrows-alt fa-w-16" aria-hidden="true" aria-label="expand" data-fa-processed="" data-prefix="fa" data-icon="arrows-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M352.201 425.775l-79.196 79.196c-9.373 9.373-24.568 9.373-33.941 0l-79.196-79.196c-15.119-15.119-4.411-40.971 16.971-40.97h51.162L228 284H127.196v51.162c0 21.382-25.851 32.09-40.971 16.971L7.029 272.937c-9.373-9.373-9.373-24.569 0-33.941L86.225 159.8c15.119-15.119 40.971-4.411 40.971 16.971V228H228V127.196h-51.23c-21.382 0-32.09-25.851-16.971-40.971l79.196-79.196c9.373-9.373 24.568-9.373 33.941 0l79.196 79.196c15.119 15.119 4.411 40.971-16.971 40.971h-51.162V228h100.804v-51.162c0-21.382 25.851-32.09 40.97-16.971l79.196 79.196c9.373 9.373 9.373 24.569 0 33.941L425.773 352.2c-15.119 15.119-40.971 4.411-40.97-16.971V284H284v100.804h51.23c21.382 0 32.09 25.851 16.971 40.971z"></path></svg>',
		),
		'fa-check-circle' => array(
			'icon' => '<span class="fa fa-check-circle"></span>',
			'svg'  => '<svg class="svg-inline--fa fa-check-circle fa-w-16" aria-hidden="true" aria-label="verified" data-fa-processed="" data-prefix="fa" data-icon="check-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path></svg>',
		),
		'fa-reply'        => array(
			'icon' => '<span class="fa fa-reply"></span>',
			'svg'  => CTF_Display_Elements_Pro::get_icon( 'reply' ),
		),
		'fa-retweet'      => array(
			'icon' => '<span class="fa fa-retweet"></span>',
			'svg'  => CTF_Display_Elements_Pro::get_icon( 'retweet' ),
		),
		'fa-heart'        => array(
			'icon' => '<span class="fa fa-heart"></span>',
			'svg'  => CTF_Display_Elements_Pro::get_icon( 'heart' ),
		),
		'fa-twitter'      => array(
			'icon' => '<span class="fa fab fa-twitter"></span>',
			'svg'  => '<svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" aria-label="twitter logo" data-fa-processed="" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>',
		),
		'fa-user'         => array(
			'icon' => '<span class="fa fa-user"></span>',
			'svg'  => '<svg class="svg-inline--fa fa-user fa-w-16" aria-hidden="true" aria-label="followers" data-fa-processed="" data-prefix="fa" data-icon="user" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M96 160C96 71.634 167.635 0 256 0s160 71.634 160 160-71.635 160-160 160S96 248.366 96 160zm304 192h-28.556c-71.006 42.713-159.912 42.695-230.888 0H112C50.144 352 0 402.144 0 464v24c0 13.255 10.745 24 24 24h464c13.255 0 24-10.745 24-24v-24c0-61.856-50.144-112-112-112z"></path></svg>',
		),
		'ctf_playbtn'     => array(
			'icon' => '',
			'svg'  => '<svg aria-label="play button" style="color: rgba(255,255,255,1)" class="svg-inline--fa fa-play fa-w-14 ctf_playbtn" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path></svg>',
		),
	);

	return $elems[ $icon ]['svg'];
}

/**
 * this function returns the properly formatted date string based on user input
 *
 * @param $raw_date string      the date from the Twitter api
 * @param $feed_options array   options for the feed that contain date formatting settings
 * @param $utc_offset int       offset in seconds for the time display based on timezone
 * @return string               formatted date
 */
function ctf_get_formatted_date( $raw_date, $feed_options, $utc_offset ) {

	$options  = get_option( 'ctf_options' );
	$timezone = isset( $options['timezone'] ) ? $options['timezone'] : 'default';
	// use php \DateTimeZone class to handle the date formatting and offsets
	$date_obj = new TwitterFeed\CtfDateTime( $raw_date, new \DateTimeZone( 'UTC' ) );

	if ( $timezone != 'default' ) {
		$date_obj->setTimeZone( new \DateTimeZone( $timezone ) );
		$utc_offset = $date_obj->getOffset();
	}
	$tz_offset_timestamp = $date_obj->getTimestamp() + $utc_offset;

	// use the custom date format if set, otherwise use from the selected defaults
	if ( ! empty( $feed_options['datecustom'] ) ) {
		$date_str = date_i18n( $feed_options['datecustom'], $tz_offset_timestamp );
	} else {

		switch ( $feed_options['dateformat'] ) {
			case '2':
				$date_str = date_i18n( 'F j', $tz_offset_timestamp );
				break;
			case '3':
				$date_str = date_i18n( 'F j, Y', $tz_offset_timestamp );
				break;
			case '4':
				$date_str = date_i18n( 'm.d', $tz_offset_timestamp );
				break;
			case '5':
				$date_str = date_i18n( 'm.d.y', $tz_offset_timestamp );
				break;
			case '6':
				$date_str = date_i18n( 'D M jS, Y', $tz_offset_timestamp );
				break;
			case '7':
				$date_str = date_i18n( 'l F jS, Y', $tz_offset_timestamp );
				break;
			case '8':
				$date_str = date_i18n( 'l F jS, Y - g:i a', $tz_offset_timestamp );
				break;
			case '9':
				$date_str = date_i18n( "l M jS, 'y", $tz_offset_timestamp );
				break;
			case '10':
				$date_str = date_i18n( 'm.d.y', $tz_offset_timestamp );
				break;
			case '18':
				$date_str = date_i18n( 'm.d.y - G:i', $tz_offset_timestamp );
				break;
			case '11':
				$date_str = date_i18n( 'm/d/y', $tz_offset_timestamp );
				break;
			case '12':
				$date_str = date_i18n( 'd.m.y', $tz_offset_timestamp );
				break;
			case '19':
				date_i18n( 'd.m.y - G:i', $tz_offset_timestamp );
				break;
			case '13':
				$date_str = date_i18n( 'd/m/y', $tz_offset_timestamp );
				break;
			case '14':
				$date_str = date_i18n( 'd-m-Y, G:i', $tz_offset_timestamp );
				break;
			case '15':
				$date_str = date_i18n( 'jS F Y, G:i', $tz_offset_timestamp );
				break;
			case '16':
				$date_str = date_i18n( 'd M Y, G:i', $tz_offset_timestamp );
				break;
			case '17':
				$date_str = date_i18n( 'l jS F Y, G:i', $tz_offset_timestamp );
				break;
			case '18':
				$date_str = date_i18n( 'Y-m-d', $tz_offset_timestamp );
				break;
			default:
			// default format is similar to Twitter
                $ctf_minute = ! empty( $options['mtime'] ) ? $options['mtime'] : 'm';
                $ctf_hour = ! empty( $options['htime'] ) ? $options['htime'] : 'h';
                $ctf_now_str = ! empty( $options['nowtime'] ) ? $options['nowtime'] : 'now';

                $now = time() + $utc_offset;

                $difference = $now - $tz_offset_timestamp;
                if ( $difference < 60 ) {
                    $date_str = $ctf_now_str;
                } elseif ( $difference < 60*60 ) {
                    $date_str = round( $difference/60 ) . $ctf_minute;
                } elseif ( $difference < 60*60*24 ) {
                    $date_str = round( $difference/3600 ) . $ctf_hour;
                } else  {
                    $one_year_from_date = new TwitterFeed\CtfDateTime( $raw_date, new \DateTimeZone( "UTC" ) );
                    $one_year_from_date->modify('+1 year');
                    $one_year_from_date_timestamp = $one_year_from_date->getTimestamp();
                    if ( $now > $one_year_from_date_timestamp ) {
                        $date_str = date_i18n( 'j M Y', $tz_offset_timestamp );
                    } else {
                        $date_str = date_i18n( 'j M', $tz_offset_timestamp );
                    }
                }

			break;
		}
	}

	return $date_str;
}


function ctf_maybe_shorten_text( $string, $feed_settings ) {
	#if( !ctf_doing_customizer($feed_settings) ){
	$limit = is_array( $feed_settings ) ? $feed_settings['textlength'] : $feed_settings;

	if ( strlen( $string ) <= $limit
		|| $limit >= 280 ) {
		return $string;
	}

	$parts       = preg_split( '/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE );
	$parts_count = count( $parts );

	$length      = 0;
	$last_part   = 0;
	$first_parts = array();
	$end_parts   = array();
	for ( ; $last_part < $parts_count; $last_part++ ) {
		$length += strlen( $parts[ $last_part ] );
		if ( $length < $limit ) {
			$first_parts[] = $parts[ $last_part ];
		} else {
			$end_parts[] = $parts[ $last_part ];
		}
	}
	$return = implode( ' ', $first_parts ) . '<a href="#" class="ctf_more">...</a><span class="ctf_remaining">';

	$return .= implode( ' ', $end_parts ) . '</span>';

	return $return;
	#}
	#return $string;
}
add_filter( 'ctf_tweet_text', 'ctf_maybe_shorten_text', 10, 2 );

function ctf_replace_urls( $string, $feed_settings, $post ) {

	if ( $feed_settings['shorturls'] ) {
		return $string;
	}

	if ( isset( $post['entities']['urls'][0] ) ) {
		foreach ( $post['entities']['urls'] as $url ) {

			if ( isset( $url['url'] ) ) {
				$string = str_replace( $url['url'], $url['expanded_url'], $string );
			}
		}
	}

	return $string;
}
add_filter( 'ctf_tweet_text', 'ctf_replace_urls', 9, 3 );
add_filter( 'ctf_quoted_tweet_text', 'ctf_replace_urls', 9, 3 );

function ctf_background_processing() {

	if ( ! isset( $_POST['feed_id'] ) ) {
		return;
	}
	$feed_id = sanitize_text_field( $_POST['feed_id'] );

	$url_item_batch = array();
	if ( isset( $_POST['cards'] ) ) {
		foreach ( $_POST['cards'] as $tc_item ) {
			$url_item_batch[] = array(
				'id'  => sanitize_text_field( $tc_item['id'] ),
				'url' => esc_url_raw( $tc_item['url'] ),
			);
		}
	}

	$twitter_card_batch = CTF_Twitter_Card_Manager::process_url_batch( $url_item_batch );

	$twitter_return = array();
	$new_found      = false;
	foreach ( $twitter_card_batch as $twitter_card_array ) {
		$url = $twitter_card_array['url'];

		$twitter_card = $twitter_card_array['twitter_card'];

		$parts = CTF_Display_Elements_Pro::get_twitter_card_parts( $url, $twitter_card );

		$content = '';
		if ( ! empty( $parts ) ) {
			$feed_options = get_option( 'ctf_options', array() );

			$twittercards_attr = CTF_Display_Elements_Pro::get_element_attribute( 'twitter_cards', $feed_options );

			$content = CTF_Display_Elements_Pro::get_twitter_card_html( $parts, $twittercards_attr );
		}

		$twitter_return[ $twitter_card_array['id'] ] = array(
			'html'   => $content,
			'url'    => $url,
			'is_new' => $twitter_card_array['is_new'],
		);
		if ( $twitter_card_array['is_new'] ) {
			$new_found = true;
		}
	}

	if ( ! empty( $twitter_card_batch )
		&& ! $new_found
		&& strpos( $feed_id, '_!_' ) === false ) {
		$twitter_return['cleared'] = true;
		delete_transient( $feed_id );
	}

	$atts_raw = isset( $_POST['atts'] ) ? json_decode( stripslashes( $_POST['atts'] ), true ) : array();
	if ( is_array( $atts_raw ) ) {
		array_map( 'sanitize_text_field', $atts_raw );
	} else {
		$atts_raw = array();
	}
	$atts = $atts_raw; // now sanitized

	$location     = isset( $_POST['location'] ) && in_array( $_POST['location'], array( 'header', 'footer', 'sidebar', 'content' ), true ) ? sanitize_text_field( $_POST['location'] ) : 'unknown';
	$post_id      = isset( $_POST['post_id'] ) && $_POST['post_id'] !== 'unknown' ? (int) $_POST['post_id'] : 'unknown';
	$feed_details = array(
		'feed_id'  => $feed_id,
		'atts'     => $atts,
		'location' => array(
			'post_id' => $post_id,
			'html'    => $location,
		),
	);

	ctf_do_background_tasks( $feed_details );

	// resizing
	$images_need_resizing_raw = isset( $_POST['needs_resizing'] ) ? $_POST['needs_resizing'] : array();
	if ( empty( $images_need_resizing_raw ) ) {
		$twitter_return['resizing'] = 'none';

		echo wp_json_encode( $twitter_return );

		wp_die();
	}

	if ( is_array( $images_need_resizing_raw ) ) {
		array_map( 'sanitize_text_field', $images_need_resizing_raw );
	} else {
		$images_need_resizing_raw = array();
	}
	$images_need_resizing = $images_need_resizing_raw;

	//$twitter_feed_settings = new CTF_Settings_Pro( $atts );
	//$twitter_feed_settings->set_feed_type_and_terms();
	//$tw_settings = $twitter_feed_settings->get_settings();
	$twitter_feed_object = CtfFeedPro::init( $atts, '', 0, array(), 0 );
	$tw_settings = $twitter_feed_object->feed_options;

	$twitter_feed = new CTF_Feed_Pro( $feed_id );
	$twitter_feed->set_cache( $tw_settings['cache_time'], $tw_settings );
	$posts = array();
	if ( $twitter_feed->regular_cache_exists() ) {
		$twitter_feed->set_post_data_from_cache();
		$posts = $twitter_feed->get_post_data();
	}

	$resizer = new CTF_Resizer( $images_need_resizing, $feed_id, $posts, $tw_settings );

	if ( ! $resizer->image_resizing_disabled() ) {
		$resizer->do_resizing();
	}
	ctf_clear_resize_cache( $feed_id );

	$results = CTF_Resizer::get_resized_image_data_for_set( $images_need_resizing );
	$return  = array();
	if ( ! empty( $results ) && is_array( $results ) ) {

		foreach ( $results as $result ) {
			$sizes = maybe_unserialize( $result['sizes'] );
			if ( ! is_array( $sizes ) ) {
				$sizes = array( 700 );
			}
			$return[ $result['twitter_id'] ] = array(
				'id'    => $result['media_id'],
				'sizes' => $sizes,
			);
		}

		$twitter_return['resizing'] = $return;
		echo ctf_json_encode( $twitter_return );

		wp_die();
	}

	$twitter_return['resizing'] = 'success';

	echo wp_json_encode( $twitter_return );

	wp_die();
}
add_action( 'wp_ajax_ctf_background_processing', 'ctf_background_processing' );
add_action( 'wp_ajax_nopriv_ctf_background_processing', 'ctf_background_processing' );

function ctf_do_locator() {
	if ( ! isset( $_POST['feed_id'] ) || strpos( $_POST['feed_id'], 'ctf' ) === false ) {
		die( 'invalid feed ID' );
	}

	$feed_id = sanitize_text_field( $_POST['feed_id'] );

	$atts_raw = isset( $_POST['atts'] ) ? json_decode( stripslashes( $_POST['atts'] ), true ) : array();
	if ( is_array( $atts_raw ) ) {
		array_map( 'sanitize_text_field', $atts_raw );
	} else {
		$atts_raw = array();
	}
	$atts = $atts_raw; // now sanitized

	$location     = isset( $_POST['location'] ) && in_array( $_POST['location'], array( 'header', 'footer', 'sidebar', 'content' ), true ) ? sanitize_text_field( $_POST['location'] ) : 'unknown';
	$post_id      = isset( $_POST['post_id'] ) && $_POST['post_id'] !== 'unknown' ? (int) $_POST['post_id'] : 'unknown';
	$feed_details = array(
		'feed_id'  => $feed_id,
		'atts'     => $atts,
		'location' => array(
			'post_id' => $post_id,
			'html'    => $location,
		),
	);

	ctf_do_background_tasks( $feed_details );

	wp_die( 'locating success' );
}
add_action( 'wp_ajax_ctf_do_locator', 'ctf_do_locator' );
add_action( 'wp_ajax_nopriv_ctf_do_locator', 'ctf_do_locator' );

function ctf_do_background_tasks( $feed_details ) {
	$locator = new CTF_Feed_Locator( $feed_details );
	$locator->add_or_update_entry();
	if ( $locator->should_clear_old_locations() ) {
		$locator->delete_old_locations();
	}
}

function ctf_add_resized_image_data( $feed_id, $ids, $settings, $page = 1 ) {
	$settings = get_option( 'ctf_options' );

	$disable_resizing = isset( $settings['resizing'] ) ? $settings['resizing'] === 'disabled' : false;

	if ( $disable_resizing ) {
		return '';
	}
	$settings['num']        = ! empty( $settings['num'] ) ? $settings['num'] : 5;
	$settings['cache_time'] = ! empty( $settings['cache_time'] ) ? max( (int) $settings['cache_time'], 60 ) : 3600;
	$args                   = array(
		'limit' => isset( $settings['minnum'] ) ? $settings['minnum'] : $settings['num'],
	);
	if ( $page > 1 ) {
		$args['offset'] = (int) $page * (int) $args['limit'];
	}

	$transient_name = str_replace( 'ctf_', 'ctf_i', $feed_id );
	$cache          = get_transient( $transient_name );

	if ( $cache ) {
		$att = $cache;
	} else {
		$resized_data = CTF_Resizer::get_resized_image_data_for_set( $ids, $args );
		set_transient( $transient_name, ctf_json_encode( $resized_data ), $settings['cache_time'] );
		$att = ctf_json_encode( $resized_data );
	}

	$return  = '<span class="ctf-resized-image-data" data-feedid="' . esc_attr( $feed_id ) . '" data-resized="' . esc_attr( $att ) . '">';
	$return .= '</span>';

	return $return;
}

function ctf_clear_resize_cache( $feed_id ) {
	$transient_name = str_replace( 'ctf_', 'ctf_i', $feed_id );
	delete_transient( $transient_name );
}

function ctf_get_local_avatar( $screenname, $feed_options, $maybe_url = false ) {

	$local_avatars = get_option( 'ctf_local_avatars', array() );

	if ( isset( $local_avatars[ $screenname ] ) ) {
		if ( $local_avatars[ $screenname ] ) {
			return ctf_get_resized_uploads_url() . $screenname . '.jpg';
		}
	}

	if ( ! $maybe_url ) {
		$transient = $feed_options['type'] === 'usertimeline' ? 'ctf_header_' . $feed_options['screenname'] : 'ctf_hometimeline_header';

		$header_json = get_transient( $transient );

		if ( ! $header_json ) {
			$endpoint = 'accountlookup';
			if ( $feed_options['type'] === 'usertimeline' ) {
				$endpoint = 'userslookup';
			}

			// Only can be set in the options page
			$request_settings = array(
				'consumer_key'        => $feed_options['consumer_key'],
				'consumer_secret'     => $feed_options['consumer_secret'],
				'access_token'        => $feed_options['access_token'],
				'access_token_secret' => $feed_options['access_token_secret'],
			);
			$get_fields = array( 'screen_name' => $feed_options['screenname'] );

			// actual connection
			$twitter_connect = new TwitterFeed\CtfOauthConnectPro( $request_settings, $endpoint );
			$twitter_connect->setUrlBase();
			$twitter_connect->setGetFields( $get_fields );
			$twitter_connect->setRequestMethod( $feed_options['request_method'] );

			$request_results = $twitter_connect->performRequest();

			$header_json = isset( $request_results->json ) ? $request_results->json : false;

			if ( $endpoint === 'accountlookup' ) {
				set_transient( 'ctf_hometimeline_header', $header_json, 60 * 60 );
			} else {
				set_transient( 'ctf_header_' . $screenname, $header_json, 60 * 60 );
			}
		}
		$header_info = isset( $header_json ) ? json_decode( $header_json, true ) : array();

		$avatar_url = CTF_Parse_Pro::get_avatar( $header_info[0] );

	} else {
		$avatar_url = $maybe_url;
	}

	if ( $avatar_url ) {
		$local_avatar = ctf_create_local_avatar( $screenname, $avatar_url );
		if ( $local_avatar ) {
			return ctf_get_resized_uploads_url() . $screenname . '.jpg';
		}

		return $local_avatar;
	}
	return false;

}
function ctf_create_local_avatar( $screenname, $file_name ) {
	$image_editor = wp_get_image_editor( $file_name );

	if ( ! is_wp_error( $image_editor ) ) {
		$upload = wp_upload_dir();

		$full_file_name = trailingslashit( $upload['basedir'] ) . trailingslashit( CTF_UPLOADS_NAME ) . $screenname . '.jpg';

		$saved_image = $image_editor->save( $full_file_name );

		if ( $saved_image ) {
			return ctf_store_local_avatar( $screenname );
		}
	}

	return false;
}
function ctf_store_local_avatar( $screenname ) {
	$local_avatars = get_option( 'ctf_local_avatars', array() );
	if ( ! is_array( $local_avatars ) ) {
		$local_avatars = array();
	}

	$local_avatars[ $screenname ] = true;

	//return true;
	return update_option( 'ctf_local_avatars', $local_avatars, false );
}

/**
 * Called via ajax to automatically save access token and access token secret
 * retrieved with the big blue button
 */
function ctf_auto_save_tokens() {
	if ( current_user_can( 'edit_posts' ) ) {
		wp_cache_delete( 'alloptions', 'options' );

		$options = get_option( 'ctf_options', array() );

		$options['access_token']        = sanitize_text_field( $_POST['access_token'] );
		$options['access_token_secret'] = sanitize_text_field( $_POST['access_token_secret'] );

		update_option( 'ctf_options', $options );
		die();
	}
	die();
}
add_action( 'wp_ajax_ctf_auto_save_tokens', 'ctf_auto_save_tokens' );

/**
* manually clears the cached tweets in case of error or user preference
*
* @return mixed bool whether or not it was successful
*/

function ctf_clear_cache() {
	//Delete all transients

	ctf_clear_cache_sql();
	echo '1';
	die();
}
add_action( 'wp_ajax_ctf_clear_cache', 'ctf_clear_cache' );

function ctf_clear_cache_sql() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'options';
	$result     = $wpdb->query(
		"
		DELETE
		FROM $table_name
		WHERE `option_name` LIKE ('%\_transient\_ctf\_%')
		"
	);
	$wpdb->query(
		"
		DELETE
		FROM $table_name
		WHERE `option_name` LIKE ('%\_transient\_timeout\_ctf\_%')
		"
	);
}
add_action( 'ctf_cron_job', 'ctf_clear_cache_sql' );

/**
* manually clears the cached twitter cards in case of error or user preference
*
* @return mixed bool whether or not it was successful
*/
function ctf_clear_twitter_card_cache() {
	if ( current_user_can( 'edit_posts' ) ) {
		CTF_Twitter_Card_Manager::clear_all_local();
		delete_option( 'ctf_twitter_cards' );
	} else {
		return false;
	}

	die( '1' );
}
add_action( 'wp_ajax_ctf_clear_twitter_card_cache', 'ctf_clear_twitter_card_cache' );

function ctf_reset_resized() {
	CTF_Twitter_Card_Manager::clear_all_local();
	CTF_Resizer::delete_resizing_table_and_images();
	echo CTF_Resizer::create_resizing_table_and_uploads_folder();

	die();
}
add_action( 'wp_ajax_ctf_reset_resized', 'ctf_reset_resized' );

/**
 * manually clears the persistent cached tweets
 *
 * @return mixed bool whether or not it was successful
 *
 * @deprecated
 */

function ctf_clear_persistent_cache() {
}

function ctf_admin_database_warning() {
	if ( isset( $_GET['page'] ) && in_array( $_GET['page'], array( 'custom-twitter-feeds', '' ) ) ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		global $wpdb;
		$table_name = $wpdb->prefix . 'options';
		$result     = $wpdb->get_var(
			"
			SELECT COUNT(*)
			FROM $table_name
			WHERE option_name LIKE '%ctf_!%'
			"
		);

		if ( (int) $result < 500 ) {
			return;
		}
		?>
		<div class="notice notice-warning is-dismissible ctf-admin-notice">
			<p>
				<?php echo esc_html__( 'Heads up! It looks like you have over 500 Twitter feeds stored in your WordPress database. This is typically caused by a large number of hashtag feeds on your site, as the plugin permanently stores older Tweets to work around Twitter\'s 7 day hashtag feed limit. This many caches may lead to performance issues.', 'custom-twitter-feeds' ); ?>
			</p>
			<p>
				<?php echo sprintf( __( 'For a solution, please follow the directions %1$shere%2$s.', 'custom-twitter-feeds' ), '<a href="https://smashballoon.com/why-does-my-database-have-a-lot-of-twitter-feed-caches/" target="_blank" rel="nofollow noopener noreferrer">', '</a>' ); ?>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'ctf_admin_database_warning' );

function ctf_retrieve_lists_by_owner() {
	if ( current_user_can( 'edit_posts' ) ) {

		$options          = get_option( 'ctf_options' );
		$consumer_key     = ! empty( $options['consumer_key'] ) && $options['have_own_tokens'] ? $options['consumer_key'] : 'FPYSYWIdyUIQ76Yz5hdYo5r7y';
		$consumer_secret  = ! empty( $options['consumer_secret'] ) && $options['have_own_tokens'] ? $options['consumer_secret'] : 'GqPj9BPgJXjRKIGXCULJljocGPC62wN2eeMSnmZpVelWreFk9z';
		$request_settings = array(
			'consumer_key'        => $consumer_key,
			'consumer_secret'     => $consumer_secret,
			'access_token'        => $options['access_token'],
			'access_token_secret' => $options['access_token_secret'],
		);

		$request_method = 'auto';

		$twitter_api = new TwitterFeed\CtfOauthConnectPro( $request_settings, 'listsmeta' );
		$twitter_api->setUrlBase();
		$get_fields = array( 'screen_name' => sanitize_text_field( $_POST['screen_name'] ) );
		$twitter_api->setGetFields( $get_fields );
		$twitter_api->setRequestMethod( $request_method );

		$twitter_api->performRequest();
		$response = json_decode( $twitter_api->json, $assoc = true );
		if ( isset( $response[0]['name'] ) ) {
			$lists = array();
			foreach ( $response as $list ) {
				$lists[] = array(
					'name' => $list['name'],
					'id'   => $list['id_str'],
				);
			}
			echo json_encode( $lists );
		} else {
			echo '0';
		}
	}

	die();
}
add_action( 'wp_ajax_ctf_retrieve_lists_by_owner', 'ctf_retrieve_lists_by_owner' );

function ctf_get_default_type_and_terms() {
	$tw_atts = array();

	$twitter_feed_settings = new CTF_Settings_Pro( $tw_atts );

	$twitter_feed_settings->set_feed_type_and_terms();
	$tw_feed_type_and_terms = $twitter_feed_settings->get_feed_type_and_terms();

	$return      = array(
		'type'       => '',
		'term_label' => '',
		'terms'      => '',
	);
	$terms_array = array();
	foreach ( $tw_feed_type_and_terms as $key => $values ) {
		if ( empty( $type ) ) {
			if ( $key === 'usertimeline' ) {
				$return['type']       = 'user timeline';
				$return['term_label'] = 'screen names(s)';
				foreach ( $values as $value ) {
					$terms_array[] = $value['term'];
				}
			}
		}
	}

	$return['terms'] = implode( ', ', $terms_array );

	return $return;
}

function ctf_get_account_and_feed_info() {

	$return                = array();
	$twitter_feed_settings = new CTF_Settings_Pro( array() );
	$twitter_feed_settings->set_feed_type_and_terms();
	$tw_settings            = $twitter_feed_settings->get_settings();
	$tw_feed_type_and_terms = $twitter_feed_settings->get_feed_type_and_terms();

	$connected_accounts = array();

	if ( ! empty( $tw_settings['access_token'] ) && $tw_settings['access_token'] !== 'missing' ) {
		$connected_accounts = array(
			'access_token' => true,
		);
	}

	$type_and_terms = array(
		'type'       => '',
		'term_label' => '',
		'terms'      => array(),
	);
	foreach ( $tw_feed_type_and_terms as $key => $values ) {
		if ( empty( $type_and_terms['type'] ) ) {
			$type_and_terms['type'] = $key;
			foreach ( $values as $value ) {
				$type_and_terms['terms'][] = $value['term'];
			}
		}
	}

	$return['type_and_terms']     = $type_and_terms;
	$return['connected_accounts'] = $connected_accounts;
	$return['available_types']    = array(
		'usertimeline'     => array(
			'label'          => 'User Timeline',
			'input'          => 'text',
			'shortcode'      => 'usertimeline',
			'term_shortcode' => 'screenname',
			'instructions'   => __( 'Any Twitter handle', 'custom-twitter-feed' ),
		),
		'hashtag'          => array(
			'label'          => 'Hashtag',
			'input'          => 'text',
			'shortcode'      => 'hashtag',
			'term_shortcode' => 'hashtag',
			'instructions'   => __( 'Any hashtag', 'custom-twitter-feed' ),
		),
		'search'           => array(
			'label'          => 'Search',
			'input'          => 'text',
			'shortcode'      => 'search',
			'term_shortcode' => 'search',
			'instructions'   => __( 'Search text', 'custom-twitter-feed' ),
		),
		'lists'            => array(
			'label'          => 'List',
			'input'          => 'text',
			'shortcode'      => 'lists',
			'term_shortcode' => 'lists',
			'instructions'   => __( 'List ID', 'custom-twitter-feed' ),
		),
		'hometimeline'     => array(
			'label'          => 'Home Timeline',
			'input'          => 'message',
			'shortcode'      => 'hometimeline',
			'term_shortcode' => 'hometimeline',
		),
		'mentionstimeline' => array(
			'label'          => 'Mentions Timeline',
			'input'          => 'message',
			'shortcode'      => 'mentionstimeline',
			'term_shortcode' => 'mentionstimeline',
		),

	);
	$return['settings'] = array();

	return $return;
}

function ctf_check_for_db_updates() {

	$db_ver = get_option( 'ctf_db_version', 0 );

	if ( version_compare( $db_ver, '1.1', '<' ) ) {
		$upload     = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = trailingslashit( $upload_dir ) . CTF_UPLOADS_NAME;
		if ( ! file_exists( $upload_dir ) ) {
			$created = wp_mkdir_p( $upload_dir );
			if ( $created ) {
				//$sb_instagram_posts_manager->remove_error( 'upload_dir' );
			}
		}

		ctf_create_database_table();

		update_option( 'ctf_db_version', CTF_DBVERSION );

		$timestamp    = strtotime( 'next monday' );
		$timestamp    = $timestamp + ( 3600 * 24 * 7 );
		$six_am_local = $timestamp + ctf_get_utc_offset() + ( 6 * 60 * 60 );

		wp_schedule_event( $six_am_local, 'ctfweekly', 'ctf_notification_update' );

		update_option( 'ctf_db_version', CTF_DBVERSION );
	}

	if ( version_compare( $db_ver, '1.2', '<' ) ) {
		$ctf_options      = get_option( 'ctf_options' );
		$disable_resizing = isset( $ctf_options['resizing'] ) ? $ctf_options['resizing'] === 'disabled' : false;

		$ctf_statuses_option = get_option( 'ctf_statuses', array() );

		if ( $disable_resizing || ! CTF_GDPR_Integrations::gdpr_tests_successful( true ) ) {
			$ctf_statuses_option['gdpr']['from_update_success'] = false;
		} else {
			$ctf_statuses_option['gdpr']['from_update_success'] = true;
		}

		update_option( 'ctf_statuses', $ctf_statuses_option );

		update_option( 'ctf_db_version', CTF_DBVERSION );
	}

	if ( version_compare( $db_ver, '1.3', '<' ) ) {
		CTF_Feed_Locator::create_table();
		update_option( 'ctf_db_version', CTF_DBVERSION );
	}

	// For v2.0
	if ( version_compare( $db_ver, '1.4', '<' ) ) {
		\TwitterFeed\Builder\CTF_Db::create_tables();
		update_option( 'ctf_db_version', CTF_DBVERSION );
		$ctf_statuses_option = get_option( 'ctf_statuses', array() );
		$ctf_options         = get_option( 'ctf_options', array() );

		if ( ! isset( $ctf_statuses_option['first_install'] ) ) {

			$options_set = get_option( 'ctf_options', false );

			if ( $options_set ) {
				$ctf_statuses_option['first_install'] = 'from_update';
			} else {
				$ctf_statuses_option['first_install'] = time();
			}

			$ctf_rating_notice_option = get_option( 'ctf_rating_notice', false );

			if ( $ctf_rating_notice_option === 'dismissed' ) {
				$ctf_statuses_option['rating_notice_dismissed'] = time();
			}

			$ctf_rating_notice_waiting = get_transient( 'custom_twitter_feeds_rating_notice_waiting' );

			if ( $ctf_rating_notice_waiting === false
				&& $ctf_rating_notice_option === false ) {
				$time = 2 * WEEK_IN_SECONDS;
				set_transient( 'custom_twitter_feeds_rating_notice_waiting', 'waiting', $time );
				update_option( 'ctf_rating_notice', 'pending', false );
			}
		}

		//Legacy feeds
		$options_support_legacy = false;

		if ( isset( $ctf_options['access_token'] ) && ! empty( $ctf_options['access_token'] ) ) {
			$options_support_legacy = true;

			if ( ctf_is_pro_version() ) {
				$base_settings = CTF_Settings_Pro::legacy_shortcode_atts( array(), $ctf_options );
			} else {
				$base_settings = CTF_Settings::legacy_shortcode_atts( array(), $ctf_options );
			}

			update_option( 'ctf_legacy_feed_settings', ctf_json_encode( $base_settings ), false );
		}
		// how many legacy feeds?
		$args = array(
			'html_location' => array( 'header', 'footer', 'sidebar', 'content', 'unknown' ),
			'group_by'      => 'shortcode_atts',
			'page'          => 1,
		);

		$feeds_data                                      = CTF_Feed_Locator::legacy_twitter_feed_locator_query( $args );
		$num_legacy                                      = count( $feeds_data );
		$ctf_statuses_option['support_legacy_shortcode'] = $options_support_legacy;
		if ( $num_legacy > 0 ) {
			if ( $num_legacy > 1 ) {
				$ctf_statuses_option['legacy_onboarding']        = array(
					'active' => true,
					'type'   => 'multiple',
				);
				$ctf_statuses_option['support_legacy_shortcode'] = true;
			} else {
				$ctf_statuses_option['legacy_onboarding'] = array(
					'active' => true,
					'type'   => 'single',
				);

				$shortcode_atts = ! empty( $feeds_data[0] ) && $feeds_data[0]['shortcode_atts'] != '[""]' ? json_decode( $feeds_data[0]['shortcode_atts'], true ) : array();
				$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();

				$ctf_statuses_option['support_legacy_shortcode'] = $shortcode_atts;

				$shortcode_atts['from_update'] = true;

				$db = ctf_get_database_settings();
				if ( ctf_is_pro_version() ) {
					$base_settings = CTF_Settings_Pro::legacy_shortcode_atts( $shortcode_atts, $db );
				} else {
					$base_settings = CTF_Settings_Pro::legacy_shortcode_atts( $shortcode_atts, $db );
				}

				$feed_saver = new CTF_Feed_Saver( false );
				$feed_saver->set_data( $base_settings );

					//$selected_feed = [];
					//$selected_feed_model = [];
					//array_push( $selected_feed, $base_settings['type'] );
					//$feed_name = CTF_Feed_Saver_Manager::create_feed_name( $selected_feed, $selected_feed_model );

				$feed_name = 'My Feed';
				$feed_saver->set_feed_name( $feed_name );

				$new_feed_id = $feed_saver->update_or_insert();

				$args = array(
					'new_feed_id'    => $new_feed_id,
					'legacy_feed_id' => $feeds_data[0]['feed_id'],
				);

				CTF_Feed_Locator::update_legacy_to_builder( $args );
			}
		} elseif ( $num_legacy === 0 && $options_support_legacy ) {
			$ctf_statuses_option['support_legacy_shortcode'] = true;
		}

		update_option( 'ctf_statuses', $ctf_statuses_option, false );
		update_option( 'ctf_db_version', CTF_DBVERSION );

		if ( ! wp_next_scheduled( 'ctf_feed_update' ) ) {
			wp_schedule_event( time() + 60, 'twicedaily', 'ctf_feed_update' );
		}
	}

}
add_action( 'wp_loaded', 'ctf_check_for_db_updates' );

/**
* clear the cache and unschedule an cron jobs when deactivated
*/
function ctf_deactivate() {
	ctf_clear_cache();

	wp_clear_scheduled_hook( 'ctf_cron_job' );
}
register_deactivation_hook( __FILE__, 'ctf_deactivate' );

function ctf_pro_cron_custom_interval( $schedules ) {
	$schedules['ctfweekly'] = array(
		'interval' => 3600 * 24 * 7,
		'display'  => __( 'Weekly' ),
	);

	return $schedules;
}
add_filter( 'cron_schedules', 'ctf_pro_cron_custom_interval' );

function ctf_get_utc_offset() {
	return get_option( 'gmt_offset', 0 ) * HOUR_IN_SECONDS;
}

/**
* outputs the custom js from the "Customize" tab on the Settings page
*/
function ctf_custom_js() {
	$options       = get_option( 'ctf_options' );
	$ctf_custom_js = isset( $options['custom_js'] ) ? $options['custom_js'] : '';

	if ( ! empty( $ctf_custom_js ) ) {
		?>
		<!-- Custom Twitter Feeds JS -->
		<script type="text/javascript">
			window.ctf_custom_js = function(){
				var $ = jQuery;
				<?php echo stripslashes( $ctf_custom_js ) . "\r\n"; ?>
			};
		</script>
		<?php
	}
}
add_action( 'wp_footer', 'ctf_custom_js' );

/**
 * outputs the custom css from the "Customize" tab on the Settings page
 */
function ctf_custom_css() {
	$options        = get_option( 'ctf_options' );
	$ctf_custom_css = isset( $options['custom_css'] ) ? $options['custom_css'] : '';

	//Show CSS if an admin (so can see Hide Tweet link), if including Custom CSS
	( current_user_can( 'edit_posts' ) || ! empty( $ctf_custom_css ) ) ? $ctf_show_css = true : $ctf_show_css = false;

	if ( $ctf_show_css ) {
		echo '<!-- Custom Twitter Feeds CSS -->' . "\r\n";
		echo "<style type='text/css'>" . "\r\n";
		if ( ! empty( $ctf_custom_css ) ) {
			echo stripslashes( $ctf_custom_css ) . "\r\n";
		}
		if ( current_user_can( 'edit_posts' ) ) {
			echo '#ctf_mod_link{ display: block; }' . "\r\n";
		}
		echo '</style>' . "\r\n";
	}
}
add_action( 'wp_head', 'ctf_custom_css' );

function ctf_pro_text_domain() {
	load_plugin_textdomain( 'custom-twitter-feeds', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'ctf_pro_text_domain' );

function ctf_get_current_time() {
	$current_time = time();

	// where to do tests
	//$current_time = strtotime( 'November 25, 2020' ) + 1;

	return $current_time;
}


function ctf_json_encode( $thing ) {
	if ( function_exists( 'wp_json_encode' ) ) {
		return wp_json_encode( $thing );
	} else {
		return json_encode( $thing );
	}
}

function ctf_plugin_init() {

	#require_once trailingslashit( CTF_PLUGIN_DIR ) . 'inc/blocks/class-ctf-blocks.php';

	$ctf_blocks = new CTF_Blocks();

	if ( $ctf_blocks->allow_load() ) {
		$ctf_blocks->load();
	}

	#include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/CTF_Global_Settings.php';
	#include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/CTF_Support.php';
	#include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/CTF_About_Us.php';
	#include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/CTF_Admin_Notices.php';
	include_once trailingslashit( CTF_PLUGIN_DIR ) . 'inc/Builder/CTF_Tooltip_Wizard.php';

	if ( is_admin() ) {
		if ( version_compare( PHP_VERSION, '5.3.0' ) >= 0
			&& version_compare( get_bloginfo( 'version' ), '4.6', '>' ) ) {
			#require_once trailingslashit( CTF_PLUGIN_DIR ) . 'inc/Admin/class-ctf-notifications.php';
			$ctf_notifications = new CTF_Notifications();
			$ctf_notifications->init();

			$ctf_newuser = new CTF_New_User();
			$ctf_newuser->init();

			#require_once trailingslashit( CTF_PLUGIN_DIR ) . 'inc/Admin/class-ctf-new-user.php';
		}
		include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/addon-functions.php';
		include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/PluginSilentUpgrader.php';
		include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/PluginSilentUpgraderSkin.php';
		include_once trailingslashit( CTF_PLUGIN_DIR ) . 'admin/class-install-skin.php';
	}

	//From v2.0
	$ctf_global_settings = new TwitterFeed\Admin\CTF_Global_Settings();
	$ctf_support         = new TwitterFeed\Admin\CTF_Support();
	$ctf_about_us        = new TwitterFeed\Admin\CTF_About_Us();
	$ctf_admin_notices   = new TwitterFeed\Admin\CTF_Admin_Notices();
	$ctf_tooltip_wizard  = new TwitterFeed\Builder\CTF_Tooltip_Wizard();
}

add_action( 'plugins_loaded', 'ctf_plugin_init' );

function ctf_is_pro_version() {
	return defined( 'CTF_STORE_URL' );
}


/**
 * Check if it's Customizer
 *
 * @since 2.0
*/
function ctf_doing_customizer( $settings ) {
	return ! empty( $settings['customizer'] ) && $settings['customizer'] == true;
}

/**
 * Triggered by a cron event to update feeds
 *
 * @since 2.0
 */
function ctf_cron_updater() {
	$settings = ctf_get_database_settings();
	if ( ! empty( $settings['ctf_caching_type'] ) && $settings['ctf_caching_type'] === 'page' ) {
		return;
	}

	$cron_updater = new TwitterFeed\SB_Twitter_Cron_Updater_Pro();
	$cron_updater->do_feed_updates();
	ctf_do_background_tasks( array() );
}
add_action( 'ctf_feed_update', 'ctf_cron_updater' );

function ctf_process_additional_batch() {
	$args         = array(
		'cron_update'      => true,
		'additional_batch' => true,
	);
	$cron_records = \TwitterFeed\Builder\CTF_Db::feed_caches_query( $args );

	$num = count( $cron_records );
	if ( $num === \TwitterFeed\Builder\CTF_Db::RESULTS_PER_CRON_UPDATE ) {
		wp_schedule_single_event( time() + 120, 'ctf_cron_additional_batch' );
	}

	\TwitterFeed\SB_Twitter_Cron_Updater_Pro::update_batch( $cron_records );
}
add_action( 'ctf_cron_additional_batch', 'ctf_process_additional_batch' );

/**
 * Check if User Can
 *
 * @since 2.0
*/
function ctf_current_user_can( $cap ) {
	if ( $cap === 'manage_twitter_feed_options' ) {
		$cap = current_user_can( 'manage_twitter_feed_options' ) ? 'manage_twitter_feed_options' : 'manage_options';
	}
	$cap = apply_filters( 'ctf_settings_pages_capability', $cap );

	return current_user_can( $cap );
}

