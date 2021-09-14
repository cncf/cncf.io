<?php
/**
 * Class SB_Instagram_Parse
 *
 * The structure of the data coming from the Instagram API is different
 * for the old API vs the new graph API. This class is used to parse
 * whatever structure the data has as well as use this to generate
 * parts of the html used for image sources.
 *
 * @since 2.0/5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_Display_Elements_Pro {
	public static function get_icon( $icon ) {
		if ( $icon === 'instagram' ) {
			return '<svg class="svg-inline--fa fa-instagram fa-w-14" aria-hidden="true" data-fa-processed="" aria-label="Instagram" data-prefix="fab" data-icon="instagram" role="img" viewBox="0 0 448 512">
	                <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
	            </svg>';
		} elseif ( $icon === 'facebook' ) {
			return '<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-facebook fa-w-16"><path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z" class=""></path></svg>';
		} elseif ( $icon === 'youtube' ) {
			return '<svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="sby_new_logo svg-inline--fa fa-youtube fa-w-18"><path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" class=""></path></svg>';
		} elseif ( $icon === 'twitter' ) {
			return '<svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" aria-label="twitter logo" data-fa-processed="" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>';
		} elseif ( $icon === 'share' ) {
			return '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="share" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-share fa-w-16"><path fill="currentColor" d="M503.691 189.836L327.687 37.851C312.281 24.546 288 35.347 288 56.015v80.053C127.371 137.907 0 170.1 0 322.326c0 61.441 39.581 122.309 83.333 154.132 13.653 9.931 33.111-2.533 28.077-18.631C66.066 312.814 132.917 274.316 288 272.085V360c0 20.7 24.3 31.453 39.687 18.164l176.004-152c11.071-9.562 11.086-26.753 0-36.328z" class=""></path></svg>';
		} elseif ( $icon === 'link' ) {
			return '<svg viewBox="0 0 24 24"><path fill="currentColor" d="M11.96 14.945c-.067 0-.136-.01-.203-.027-1.13-.318-2.097-.986-2.795-1.932-.832-1.125-1.176-2.508-.968-3.893s.942-2.605 2.068-3.438l3.53-2.608c2.322-1.716 5.61-1.224 7.33 1.1.83 1.127 1.175 2.51.967 3.895s-.943 2.605-2.07 3.438l-1.48 1.094c-.333.246-.804.175-1.05-.158-.246-.334-.176-.804.158-1.05l1.48-1.095c.803-.592 1.327-1.463 1.476-2.45.148-.988-.098-1.975-.69-2.778-1.225-1.656-3.572-2.01-5.23-.784l-3.53 2.608c-.802.593-1.326 1.464-1.475 2.45-.15.99.097 1.975.69 2.778.498.675 1.187 1.15 1.992 1.377.4.114.633.528.52.928-.092.33-.394.547-.722.547z"></path><path fill="currentColor" d="M7.27 22.054c-1.61 0-3.197-.735-4.225-2.125-.832-1.127-1.176-2.51-.968-3.894s.943-2.605 2.07-3.438l1.478-1.094c.334-.245.805-.175 1.05.158s.177.804-.157 1.05l-1.48 1.095c-.803.593-1.326 1.464-1.475 2.45-.148.99.097 1.975.69 2.778 1.225 1.657 3.57 2.01 5.23.785l3.528-2.608c1.658-1.225 2.01-3.57.785-5.23-.498-.674-1.187-1.15-1.992-1.376-.4-.113-.633-.527-.52-.927.112-.4.528-.63.926-.522 1.13.318 2.096.986 2.794 1.932 1.717 2.324 1.224 5.612-1.1 7.33l-3.53 2.608c-.933.693-2.023 1.026-3.105 1.026z"></path></svg>';
		} elseif ( $icon === 'reply' ) {
			return '<svg class="svg-inline--fa fa-w-16" viewBox="0 0 24 24" aria-label="reply" role="img" xmlns="http://www.w3.org/2000/svg"><g><path fill="currentColor" d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"></path></g></svg>';
		} elseif ( $icon === 'retweet' ) {
			return '<svg class="svg-inline--fa fa-w-16" viewBox="0 0 24 24" aria-hidden="true" aria-label="retweet" role="img"><path fill="currentColor" d="M23.77 15.67c-.292-.293-.767-.293-1.06 0l-2.22 2.22V7.65c0-2.068-1.683-3.75-3.75-3.75h-5.85c-.414 0-.75.336-.75.75s.336.75.75.75h5.85c1.24 0 2.25 1.01 2.25 2.25v10.24l-2.22-2.22c-.293-.293-.768-.293-1.06 0s-.294.768 0 1.06l3.5 3.5c.145.147.337.22.53.22s.383-.072.53-.22l3.5-3.5c.294-.292.294-.767 0-1.06zm-10.66 3.28H7.26c-1.24 0-2.25-1.01-2.25-2.25V6.46l2.22 2.22c.148.147.34.22.532.22s.384-.073.53-.22c.293-.293.293-.768 0-1.06l-3.5-3.5c-.293-.294-.768-.294-1.06 0l-3.5 3.5c-.294.292-.294.767 0 1.06s.767.293 1.06 0l2.22-2.22V16.7c0 2.068 1.683 3.75 3.75 3.75h5.85c.414 0 .75-.336.75-.75s-.337-.75-.75-.75z"></path></svg>';
		} elseif ( $icon === 'heart' ) {
			return '<svg class="svg-inline--fa fa-w-16" viewBox="0 0 24 24" aria-hidden="true" aria-label="like" role="img" xmlns="http://www.w3.org/2000/svg"><g><path fill="currentColor" d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"></path></g></svg>';
		}
	}

	public static function get_media_placeholder( $media_url, $settings = array( 'autores' => false ) ) {
		if ( empty( $media_url ) ) {
			return '';
		}
		if ( $settings['autores'] ) {
			return trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png';
		}

		return $media_url;
	}

	public static function author_name( $data ) {
		return $data['user']['name'];
	}

	public static function author_screen_name( $data ) {
		return $data['user']['screen_name'];
  }
  
	public static function get_avatar_url( $post ) {
		if ( true /* doing GDPR */) {
			return trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png';
		}

		return CTF_Parse_Pro::get_avatar( $post );
	}

	public static function get_twitter_card_media_html( $data ) {
		$alt              = ! empty( CTF_Parse_Pro::get_twitter_card_image_alt( $data ) ) ? CTF_Parse_Pro::get_twitter_card_image_alt( $data ) : __( 'Image for twitter card', 'social-wall' );
		$available_images = '';
		$local = CTF_Parse_Pro::get_twitter_card_local( $data );
		if ( ! empty( $local ) || CTF_GDPR_Integrations::doing_gdpr( ctf_get_database_settings() ) ) {
			$image = trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png';
			$available_images = ' data-available-images="' . esc_attr( json_encode( $local ) ) . '"';
		} else {
			$image = CTF_Parse_Pro::get_twitter_card_image( $data );
		}
		if ( ! empty( $image ) ) {
			return '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $alt ) . '"' . $available_images . '>';
		}

		return CTF_Display_Elements_Pro::get_icon( 'link' );
	}

	public static function get_twitter_card_link_text( $data_or_url ) {
		$link = $data_or_url;
		if ( is_array( $data_or_url ) ) {
			$link = CTF_Parse_Pro::get_twitter_card_url( $data_or_url );
		}
		$working_url = explode( "/", preg_replace( "(^https?://)", "", $link ) );

		return $working_url[0];
	}

	public static function get_twitter_card_parts( $url, $twitter_card ) {

		$type      = CTF_Parse_Pro::get_twitter_card_type( $twitter_card );
		$image     = CTF_Display_Elements_Pro::get_twitter_card_media_html( $twitter_card );
		$image_url = CTF_Parse_Pro::get_twitter_card_image( $twitter_card );
		$image_alt = CTF_Parse_Pro::get_twitter_card_image_alt( $twitter_card );
		$local     = CTF_Parse_Pro::get_twitter_card_local( $twitter_card );

		$title       = CTF_Parse_Pro::get_twitter_card_title( $twitter_card );
		$description = CTF_Parse_Pro::get_twitter_card_description( $twitter_card );
		$link_html   = CTF_Display_Elements_Pro::get_icon( 'link' ) . CTF_Display_Elements_Pro::get_twitter_card_link_text( $url );

		$parts = array();
		if ( ! empty( $title )
		     || ! empty( $description ) ) {
			$parts = array(
				'type'        => $type,
				'url'         => $url,
				'image_url'   => $image_url,
				'image'       => $image,
				'image_alt'   => $image_alt,
				'title'       => $title,
				'description' => ctf_maybe_shorten_text( $description, 150 ),
				'link_html'   => $link_html,
				'local'       => $local
			);
		}

		return $parts;
	}

	public static function get_twitter_card_html( $parts ) {

		$twitter_card_url = $parts['url'];
		$type             = $parts['type'];
		$image_url        = $parts['image_url'];
		$image_alt        = $parts['image_alt'];
		$title            = $parts['title'];
		$description      = $parts['description'];

		$display_url_parts = explode( "/", preg_replace( "(^https?://)", "", $twitter_card_url ) );

		$card_html = '';

		if ( $type === 'summary'
		     || $type === 'summary_large_image'
		     || $type === 'player' ) {
			$card_html .= '<a href="' . esc_url( $twitter_card_url ) . '" class="ctf-twitter-card ctf-tc-type-' . esc_attr( $type ) . '" target="_blank" rel="noopener noreferrer">';
			if ( ! empty( $image_url ) ) {
				if ( ! empty( $parts['local'] ) ) {
					$image_url = trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png';
				}
				$card_html .= '<div class="ctf-tc-image" data-bg="' . esc_url( $image_url ) . '">';
				$card_html .= CTF_Display_Elements_Pro::get_twitter_card_media_html( $parts );
				$card_html .= '</div>';
			}
			$card_html .= '<div class="ctf-tc-summary-info">';
			$card_html .= '<p class="ctf-tc-heading">' . esc_html( $title ) . '</p>';
			$card_html .= '<p class="ctf-tc-desc">' . esc_html( substr( $description, 0, 150 ) );
			if ( strlen( $description ) > 150 ) {
				$card_html .= '...';
			}
			$card_html .= '</p>';
			$card_html .= '<p class="ctf-tc-url">' . esc_html( $display_url_parts[0] ) . '</p>';
			$card_html .= '</div>';

			$card_html .= '</a>';
		} elseif ( $type === 'amplify' ) {

			//HTML5 video
			if ( isset( $image_url ) ) {
				$card_html .= '<div class="ctf-tweet-media">';

				$card_html .= '<a href="' . esc_url( $twitter_card_url ) . '" data-ctf-lightbox="1" data-title="' . esc_attr( $description ) . '" data-user="" data-name="" data-id="" data-url="" data-avatar="" data-date="" data-video="" data-iframe="' . esc_url( $twitter_card_url ) . '" data-amplify="true" class="ctf-video">';
				$card_html .= ctf_get_fa_el( 'ctf_playbtn' );
				$card_html .= '<div class="ctf-photo-hover"></div>';
				$card_html .= CTF_Display_Elements_Pro::get_twitter_card_media_html( $parts );
				$card_html .= '</a>' .
				              '</div>';
			}

		} else {
			$card_html .= '<a href="' . esc_url( $twitter_card_url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $twitter_card_url ) . '</a>';
		}

		return $card_html;
	}

	public static function get_twitter_card_placeholder( $post, $first_url, $short_url = '' ) {
		return '<span class="ctf-twitter-card-placeholder" data-tweet-id="' . esc_attr( CTF_Parse_Pro::get_tweet_id( $post ) ) . '" data-tc-url="' . esc_attr( $first_url ) . '" data-tc-short-url="' . esc_attr( $short_url ) . '"></span>';
	}

	public static function get_available_images_attribute( $post ) {
		$data_array = CTF_Parse_Pro::get_media_src_set( $post );
		$attr       = ' data-available-images="' . esc_attr( json_encode( $data_array ) ) . '"';

		return $attr;
	}

	public static function media_alt_text( $post ) {
		if ( isset( $post['text'] ) && ! empty( $post['text'] ) ) {
			$alt_text_for_image = explode( " ", $post['text'], 6 );
			$alt_text_for_image = __( 'Image for the Tweet beginning', 'custom-twitter-feeds' ) . ': ' . implode( " ", array_splice( $alt_text_for_image, 0, 5 ) );
		} else {
			$alt_text_for_image = __( 'View on Twitter', 'custom-twitter-feeds' );
		}

		return htmlspecialchars( preg_replace( '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', '', $alt_text_for_image ) );

	}
	public static function lightbox_image( $medium ) {
		$ctf_lightbox_image = isset( $medium['poster'] ) ? $medium['poster'] : $medium['url'];

		if ( $medium['type'] == 'iframe' ){
			$ctf_lightbox_image = trailingslashit( CTF_PLUGIN_URL ) . 'img/video-lightbox.png';
		}

		return $ctf_lightbox_image;
	}

	public static function media_wrap_classes( $medium, $feed_options = array() ) {
		$classes = '';
		if ( $medium['type'] == 'iframe' ) {
			$classes = isset( $medium['iframe_type'] ) ? ' ctf-if-type-' . $medium['iframe_type'] : '';
			$classes .= isset( $medium['iframe_class'] ) ? $medium['iframe_class'] : '';
			if ( CTF_GDPR_Integrations::doing_gdpr( $feed_options ) ) {
				$classes .= ' ctf-no-consent';
			}
		}
		return $classes;
	}

	public static function media_link_classes( $medium, $disablelightbox ) {
		$media_link_classes = $disablelightbox ? 'ctf-media-link' : 'ctf-lightbox-link';
		if ( ! $disablelightbox ) {
			if ( $medium['type'] == 'video' || $medium['type'] == 'animated_gif') {
				$media_link_classes .= ' ctf-video ctf-video-type-' . $medium['type'];
			} elseif ( $medium['type'] == 'iframe' ) {
				$media_link_classes .= ' ctf-iframe';
			} else {
				$media_link_classes .= ' ctf-image';
			}
		};
		return $media_link_classes;
	}

	public static function media_link_attributes( $medium, $post, $feed_options, $disablelightbox ) {
        $media_link_atts = array();
        
		if ( ! $disablelightbox ) {
			$media_link_atts = array(
				'data-title' => $post['text'],
				'data-user' => $post['user']['screen_name'],
				'data-name' => $post['user']['name'],
				'data-id' => CTF_Parse_Pro::get_post_id( $post ),
				'data-url' => 'https://twitter.com/' .$post['user']['screen_name'] . '/status/' . $post['id_str'],
				'data-avatar' => CTF_Parse_Pro::get_avatar( $post ),
				'data-date' => ctf_get_formatted_date( $post['created_at'] , $feed_options, $post['user']['utc_offset'] ),
				'data-ctf-lightbox' => 1,
				'data-video' => '',
				'data-iframe' => '',

			);
			if ( $medium['type'] == 'iframe' ) {
				$media_link_atts['data-iframe'] = $medium['url'];
            }
            if ($medium['type'] == 'video' || $medium['type'] == 'animated_gif') {
                $media_link_atts['data-video'] = $medium['url'];
            } 
		};
		$media_link_atts_string = '';
		foreach ( $media_link_atts as $key => $value ) {
			$media_link_atts_string .= ' '. esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
		}
		return $media_link_atts_string;
	}

	public static function media_screenreader_text( $medium ) {
		if ( $medium['type'] == 'video' || $medium['type'] == 'animated_gif') {
			return '<span class="ctf-screenreader">' . esc_html__( 'Twitter feed video.', 'custom-twitter-feeds' ) . '</span>';
		} else if ( $medium['type'] == 'iframe' ) {
			return '<span class="ctf-screenreader">' . esc_html__( 'Twitter feed video.', 'custom-twitter-feeds' ) . '</span>';
		}
		return '<span class="ctf-screenreader">' . esc_html__( 'Twitter feed image.', 'custom-twitter-feeds' ) . '</span>';
	}

	public static function media_element_atts( $medium, $feed_options ) {
		$data_sizes = ' data-ctfsizes="full"';
		if ( $feed_options['autores'] === true ) {
			$sizes_string = isset( $medium['sizes'] ) && is_array( $medium['sizes'] ) ? $medium['sizes']['thumb']['w'] . ',' . $medium['sizes']['small']['w'] . ',' . $medium['sizes']['medium']['w'] . ',' . $medium['sizes']['large']['w']: '';
			$data_sizes = isset( $medium['sizes'] ) && is_array( $medium['sizes'] ) ? ' data-ctfsizes="' . esc_attr( $sizes_string ) . '"' : $data_sizes;
		}

		return $data_sizes;
    }
    
    public static function get_cols_atts( $feed_options ) {
        $mobile_cols = 1;
        $cols_att = '';
        if ( $feed_options['layout'] === 'masonry' ) {

            if ( $feed_options['masonrycols'] > 3 && $feed_options['masonrycols'] < 7 ) {
                $desktop_cols = $feed_options['masonrycols'];
            } else {
                $desktop_cols = 3;
            }

            if ( $feed_options['masonrycols'] == 2 ) {
                $desktop_cols = 2;
            }

            if ( $feed_options['masonrymobilecols'] == 2 ) {
                $mobile_cols = 2;
            }
            $cols_att = ' data-ctf-cols="'. $desktop_cols .'" data-ctf-mobilecols="'. $mobile_cols .'"';
        }

        return $cols_att;
    }


    public static function linkbox_link_attributes( $medium, $post, $feed_options, $disablelightbox ) {
        $linkbox_link_atts = array();

		if ( ! $disablelightbox ) {
			$linkbox_link_atts = array(				
                'data-title' => $post['text'],
                'data-user' => $post['user']['screen_name'],
                'data-name' => $post['user']['name'],
                'data-id' => CTF_Parse_Pro::get_post_id( $post ),
                'data-url' => 'https://twitter.com/' .$post['user']['screen_name'] . '/status/' . $post['id_str'],
                'data-avatar' => CTF_Parse_Pro::get_avatar( $post ),
                'data-date' => ctf_get_formatted_date( $post['created_at'] , $feed_options, $post['user']['utc_offset'] ),
                'data-ctf-lightbox' => 1,
                'data-video' => '',
                'data-iframe' => '',
            );
            
			if ( $medium['type'] == 'iframe' ) {
				$linkbox_link_atts['data-iframe'] = $medium['url'];
            }
            if ($medium['type'] == 'video' || $medium['type'] == 'animated_gif') {
                $linkbox_link_atts['data-video'] = $medium['url'];
            } 
		};
		$linkbox_link_atts_string = '';
		foreach ( $linkbox_link_atts as $key => $value ) {
			$linkbox_link_atts_string .= ' '. esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
		}
		return $linkbox_link_atts_string;
    }

    public static function header_type( $feed_options ) {
	    $header_template = 'header-generic';
	    if ( $feed_options['type'] === 'usertimeline' || $feed_options['type'] === 'mentionstimeline' || $feed_options['type'] === 'hometimeline' ) {
		    $header_template = 'header';
	    }

	    return $header_template;
    }

	public static function seperator_style_att( $feed_options ) {
		$header_template = 'header-generic';
		if ( $feed_options['type'] === 'usertimeline' || $feed_options['type'] === 'mentionstimeline' || $feed_options['type'] === 'hometimeline' ) {
			$header_template = 'header';
		}

		return $header_template;
	}

	public static function post_text( $post, $feed_options ) {
		$post_text = apply_filters( 'ctf_tweet_text', $post['text'], $feed_options, $post );

		return $post_text;
	}

	public static function tweet_media( $post, $num_media ) {
		$media = CTF_Parse_Pro::get_media( $post, $num_media );
		$media = apply_filters( 'ctf_item_media', $media );

		return $media;
	}

	public static function media_classes( $media ) {
		$media_classes = 'ctf-tweet-media';
		$media_classes .= $media && count( $media ) > 1 ? ' ctf-tweet-media-masonry' : '';

		return $media_classes;
	}

	public static function load_more_style_att( $feed_options ) {
		$load_more_styles = '';
		if ( ! empty( $feed_options['buttoncolor'] ) && $feed_options['buttoncolor'] !== '#'
		     || ! empty( $feed_options['buttontextcolor'] ) && $feed_options['buttontextcolor'] !== '#' ) {
			$load_more_styles = ' style="' .$feed_options['buttoncolor'] . $feed_options['buttontextcolor'] . '"';
		}

		return $load_more_styles;
	}
    
    public static function get_ajax_code( $feed_options ) {
	    $json_array = array(
		    'ajax_url' => admin_url( 'admin-ajax.php' ),
		    'font_method' => 'svg',
		    'placeholder' => trailingslashit( CTF_PLUGIN_URL ) . 'img/placeholder.png',
		    'resized_url' => ctf_get_resized_uploads_url(),
	    );

        return '<script> var ctfOptions = ' . ctf_json_encode( $json_array ) . '</script><script type="text/javascript" src="'. CTF_JS_URL .'"></script>';
    }
}