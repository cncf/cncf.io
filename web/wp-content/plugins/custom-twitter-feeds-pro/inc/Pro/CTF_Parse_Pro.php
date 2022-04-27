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
namespace TwitterFeed\Pro;

use TwitterFeed\CtfOauthConnect;
use TwitterFeed\CtfOauthConnectPro;
use TwitterFeed\CtfFeedPro;
use TwitterFeed\CTF_GDPR_Integrations;

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class CTF_Parse_Pro
{
	public static function get_tweet_id( $data ) {
		return $data['id_str'];
	}

	public static function get_user_name( $data ) {
		return $data['screen_name'];
	}

	public static function get_retweeter( $data ) {
		return $data['user']['screen_name'];
	}

	public static function get_quoted_post( $data ) {
		$tweet = $data;
		if ( isset( $data['retweeted_status']['quoted_status'] ) ) {
			$tweet = $data['retweeted_status']['quoted_status'];
		} elseif ( isset( $data['quoted_status'] ) ) {
			$tweet = $data['quoted_status'];
		}
		return $tweet;
	}

	public static function get_quoted_user_name( $data ) {
		if ( isset( $data['quoted_status'] ) ) {
			return $data['quoted_status']['user']['screen_name'];
		} elseif ( isset( $data['retweeted_status']['quoted_status'] ) ) {
			return $data['retweeted_status']['quoted_status']['user']['screen_name'];
		}
		return '';
	}

	public static function get_quoted_text( $data, $replace_urls = true, $has_card = false ) {
		$quoted_status = $data;
		if ( isset( $data['quoted_status'] ) ) {
			$quoted_status = $data['quoted_status'];
		} if ( isset( $data['retweeted_status']['quoted_status'] ) ) {
			$quoted_status = $data['retweeted_status']['quoted_status'];
		}

		$content = $quoted_status['text'];


		$first_url = CTF_Parse_Pro::get_first_url_in_tweet( $quoted_status );

		if ( $first_url && $has_card ) {
			$content = CTF_Feed_Pro::removeStringFromText( $first_url, $content );
		}

		$short_urls = $replace_urls === false;

		$content = ctf_replace_urls( $content, array( 'shorturls' => $short_urls ), $quoted_status );


		return $content;
	}

	public static function get_quoted_avatar( $data ) {
		if ( isset( $data['quoted_status'] ) ) {
			return $data['quoted_status']['user']['profile_image_url_https'];
		} if ( isset( $data['retweeted_status']['quoted_status'] ) ) {
			return $data['retweeted_status']['quoted_status']['user']['profile_image_url_https'];
		}
		return '';
	}


	public static function get_quoted_timestamp( $data ) {
		if ( isset( $data['quoted_status'] ) ) {
			return strtotime( $data['quoted_status']['created_at'] );
		} if ( isset( $data['retweeted_status']['quoted_status'] ) ) {
			return strtotime( $data['retweeted_status']['quoted_status']['created_at'] );
		}
		return '';
	}

	public static function get_quoted_media_url( $data, $resolution = 'lightbox' ) {
		if ( isset( $data['retweeted_status'] ) ) {
			if ( isset( $data['retweeted_status']['quoted_status']['extended_entities']['media'][0]['media_url_https'] ) ) {
				return $data['retweeted_status']['quoted_status']['extended_entities']['media'][0]['media_url_https'];
			}
		} else {
			if ( isset( $data['quoted_status']['extended_entities']['media'][0]['media_url_https'] ) ) {
				return $data['quoted_status']['extended_entities']['media'][0]['media_url_https'];
			}
		}

		return '';
	}

	public static function get_handle( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			return $data['retweeted_status']['user']['screen_name'];
		} else {
			return $data['user']['screen_name'];
		}
	}

	public static function get_name( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			return $data['retweeted_status']['user']['name'];
		} else {
			return $data['user']['name'];
		}

	}

	public static function get_media_type( $data, $resolution = 'lightbox' ) {

		$working_tweet = $data;
		if ( isset( $data['retweeted_status'] ) ) {
			$working_tweet = $data['retweeted_status'];
		}

		if ( isset( $working_tweet['quoted_status'] ) ) {
			$working_tweet = $working_tweet['quoted_status'];
		}

		//Media
		$type = 'image';
		if ( isset( $working_tweet['extended_entities']['media'] ) ) {
			if ( $working_tweet['extended_entities']['media'][0]['type'] == 'video' || $working_tweet['extended_entities']['media'][0]['type'] == 'animated_gif' ) {
				$type = 'video';
			}
		} elseif ( isset( $working_tweet['entities']['media'] ) ) {
			if ( $working_tweet['entities']['media'][0]['type'] == 'video' || $working_tweet['entities']['media'][0]['type'] == 'animated_gif' ) {
				$type = 'video';
			}
		} /*elseif ( isset( $working_tweet['entities']['urls'][0]['expanded_url'] ) ) {
			$url_to_check = $working_tweet['entities']['urls'][0]['expanded_url'];

			//Check whether it's a youtube video
			$youtube = stripos($url_to_check, 'youtube.com/watch');
			$youtu = stripos($url_to_check, 'youtu.be');
			$youtubeembed = stripos($url_to_check, 'youtube.com/embed');

			//Check whether it's a Vimeo video
			$vimeo = stripos($url_to_check, 'vimeo');

			//Check whether it's a Vine video
			$vine = stripos($url_to_check, 'vine.co');

			//Check whether it's a SoundCloud embed
			$soundcloud = stripos($url_to_check, 'soundcloud.com');

			//Check whether it's a Spotify embed
			$spotify = stripos($url_to_check, 'open.spotify.com');

			if ( $youtube !== false
				|| $youtu !== false
				|| $youtubeembed !== false
				|| $vimeo !== false
				|| $vine !== false
				|| $soundcloud !== false
				|| $spotify !== false ) {
				$type = 'iframe';
			}
		}*/
		return $type;
	}

	public static function get_media_url( $data, $resolution = 'lightbox' ) {
		if ( isset( $data['retweeted_status'] ) ) {
			if ( isset( $data['retweeted_status']['extended_entities']['media'][0]['media_url_https'] ) ) {
				return $data['retweeted_status']['extended_entities']['media'][0]['media_url_https'];
			}
		} else {
			if ( isset( $data['extended_entities']['media'][0]['media_url_https'] ) ) {
				return $data['extended_entities']['media'][0]['media_url_https'];
			}
		}

		return '';
	}

	public static function get_media_items_for_tweet( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			if ( isset( $data['retweeted_status']['extended_entities']['media'][0]) ) {
				return $data['retweeted_status']['extended_entities']['media'];
			}
		} else {
			if ( isset( $data['extended_entities']['media'][0] ) ) {
				return $data['extended_entities']['media'];
			}
		}

		return '';
	}

	public static function get_video_url( $data ) {

		$url = '';
		$working_tweet = $data;
		if ( isset( $data['retweeted_status'] ) ) {
			$working_tweet = $data['retweeted_status'];
		}

		if ( isset( $working_tweet['quoted_status'] ) ) {
			$working_tweet = $working_tweet['quoted_status'];
		}

		$type = isset( $working_tweet['extended_entities'] ) ? $working_tweet['extended_entities']['media'][0]['type'] : $working_tweet['entities']['media'][0]['type'];
		if ( $type === 'video' || $type === 'animated_gif' ) {
			$url = isset( $working_tweet['extended_entities'] ) ? $working_tweet['extended_entities']['media'][0]['video_info']['variants'][0]['url'] : $working_tweet['entities']['media'][0]['video_info']['variants'][0]['url'];
		}

		return $url;
	}

	public static function get_avatar( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			return $data['retweeted_status']['user']['profile_image_url_https'];
		} elseif ( isset( $data['user'] ) ) {
			return $data['user']['profile_image_url_https'];
		} elseif ( isset( $data['profile_image_url_https'] ) ) {
			return $data['profile_image_url_https'];
		}
		return '';
	}

	public static function get_tweet_content( $data, $replace_urls = true, $has_card = false ) {
		if ( isset( $data['retweeted_status'] ) ) {
			$content = $data['retweeted_status']['text'];
		} else {
			$content = $data['text'];
		}

		$first_url = CTF_Parse_Pro::get_first_url_in_tweet( $data );

		if ( $first_url && $has_card ) {
			$content = CTF_Feed_Pro::removeStringFromText( $first_url, $content );
		}

		$short_urls = $replace_urls === false;

		$content = ctf_replace_urls( $content, array( 'shorturls' => $short_urls ), $data );

		return $content;
	}

	public static function get_first_url_in_tweet( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			$working_tweet = $data['retweeted_status'];
		} else {
			$working_tweet = $data;
		}
		if ( isset( $working_tweet['extended_entities']['urls'] ) ) {
			return $working_tweet['extended_entities']['urls'][0]['expanded_url'];
		} elseif ( isset( $working_tweet['entities']['urls'] ) ) {
			return $working_tweet['entities']['urls'][0]['expanded_url'];
		} else {
			return false;
		}
	}

	public static function get_original_timestamp( $data ) {
		return $data['created_at'];
    }

	public static function get_timestamp( $data ) {
		return strtotime( $data['created_at'] );
	}

	public static function get_original_post_timestamp( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			return strtotime( $data['retweeted_status']['created_at'] );
		} else {
			return strtotime( $data['created_at'] );
		}
	}

	public static function get_permalink( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			return 'https://twitter.com/' . $data['retweeted_status']['user']['screen_name'] . '/status/' . $data['retweeted_status']['id_str'];
		} else {
			return 'https://twitter.com/' . $data['user']['screen_name'] . '/status/' . $data['id_str'];
		}
    }

	public static function get_account_link( $data ) {
		if ( isset( $data['retweeted_status'] ) ) {
			return 'https://twitter.com/' . $data['retweeted_status']['user']['screen_name'];
		} else {
			return 'https://twitter.com/' . $data['user']['screen_name'];
		}
    }

    public static function get_tweet_count( $data ) {

        if ( isset( $data['statuses'] ) && is_array( $data['statuses'] ) ) {
            $tweet_count = count( $data['statuses'] );
        } elseif ( is_array( $data ) ) {
            $tweet_count = count( $data );
        } else {
            $tweet_count = 0;
        }

        return $tweet_count;
    }

    public static function get_num_media( $data ) {

        $num_media = 0;

        if ( isset( $data['extended_entities']['media'] ) ) {
            $num_media = count( $data['extended_entities']['media'] );
        } elseif ( isset( $data['entities']['media'] ) ) {
            $num_media = count( $data['entities']['media'] );
        }

        return $num_media;
    }

    public static function get_media_count( $data ) {
        $num_media = 0;
        if ( isset( $data['extended_entities']['media'] ) ) {
            $num_media = count( $data['extended_entities']['media'] );
        }
        return $num_media;
    }

    public static function get_media_classes( $data, $feed_options ) {
        $media_classes = 'ctf-tweet-media';
        $media_classes .= CTF_Parse_Pro::get_media_count( $data ) > 1 ? ' ctf-tweet-media-masonry' : '';
        return $media_classes;
}


	public static function get_retweet_count( $data ) {
		if ( isset( $data['retweeted_status']['retweet_count'] ) ) {
			return $data['retweeted_status']['retweet_count'];
		} else {
			return $data['retweet_count'];
		}
	}

	public static function get_favorite_count( $data ) {
		if ( isset( $data['retweeted_status']['favorite_count'] ) ) {
			return $data['retweeted_status']['favorite_count'];
		} else {
			return $data['favorite_count'];
		}
	}

	public static function has_twitter_card( $data ) {
		return isset( $data['twitter_card'] );
	}

	public static function twitter_card_not_empty( $data ) {
		return ! empty( $data['twitter_card'] );
	}

	public static function should_retrieve_twitter_card( $post ) {
		if ( ! empty( CTF_Parse_Pro::get_media_url( $post, 'lightbox' ) ) ) {
			return false;
		}
		if ( ! empty( CTF_Parse_Pro::get_quoted_media_url( $post, 'lightbox' ) ) ) {
			return false;
		}

		return true;
	}

	public static function get_twitter_card_type( $data ) {
		$data['twitter_card'] = isset( $data['twitter_card'] ) ? $data['twitter_card'] : $data;
		if ( isset( $data['twitter_card']['twitter:card'] ) ) {
			return $data['twitter_card']['twitter:card'];
		}
		return '';
	}

	public static function get_twitter_card_image( $data ) {
		$data['twitter_card'] = isset( $data['twitter_card'] ) ? $data['twitter_card'] : $data;
		if ( isset( $data['twitter_card']['twitter:image'] ) ) {
			return $data['twitter_card']['twitter:image'];
		}
		if ( isset( $data['image_url'] ) ) {
			return $data['image_url'];
		}
		return '';
	}

	public static function get_twitter_card_image_alt( $data ) {
		$data['twitter_card'] = isset( $data['twitter_card'] ) ? $data['twitter_card'] : $data;
		if ( isset( $data['twitter_card']['twitter:image:alt'] ) ) {
			return $data['twitter_card']['twitter:image:alt'];
		}
		return '';
	}

	public static function get_twitter_card_local( $twitter_card ) {
		if ( ! empty( $twitter_card['local'] ) ) {
			return $twitter_card['local'];
		}
		return array();
	}

	public static function get_twitter_card_title( $data ) {
		$data['twitter_card'] = isset( $data['twitter_card'] ) ? $data['twitter_card'] : $data;
		if ( isset( $data['twitter_card']['twitter:title'] ) ) {
			return $data['twitter_card']['twitter:title'];
		}
		return '';
	}

	public static function get_twitter_card_description( $data ) {
		$data['twitter_card'] = isset( $data['twitter_card'] ) ? $data['twitter_card'] : $data;
		if ( isset( $data['twitter_card']['twitter:description'] ) ) {
			return $data['twitter_card']['twitter:description'];
		}
		return '';
	}

	public static function get_single_medium_url( $medium ) {
		if ( isset( $medium['media_url_https'] ) ) {
			return $medium['media_url_https'];
		} elseif ( isset( $medium['media_url_http'] ) ) {
			return $medium['media_url_http'];
		}
	}

	public static function get_media_src_set( $medium_or_api_data ) {
		if ( isset( $medium_or_api_data['id_str'] ) ) {
			$api_data = $medium_or_api_data;
			$media_items = CTF_Parse_Pro::get_media_items_for_tweet( $api_data );

			if ( isset( $api_data['quoted_status'] ) ) {
				$quoted_media_items = CTF_Parse_Pro::get_media_items_for_tweet( $api_data['quoted_status'] );

				if ( is_array( $quoted_media_items ) ) {
					if ( is_array( $media_items ) ) {
						$media_items = array_merge( $media_items, $quoted_media_items );
					} else {
						$media_items = $quoted_media_items;
					}
				}
			}
		} else {
			$medium = $medium_or_api_data;
			$media_items = array( $medium );
		}
		if ( empty( $media_items ) ) {
			return array();
		}

		$return = array();

		foreach ( $media_items as $medium ) {
			$media_urls = array();

			$this_media_url = CTF_Parse_Pro::get_single_medium_url( $medium );
			if ( isset( $medium['sizes']['thumb']['w'] ) ) {
				$size = $medium['sizes']['thumb']['w'];
				$media_urls[ $size ] = $this_media_url . ':thumb';
			}

			if ( isset( $medium['sizes']['small']['w'] ) ) {
				$size = $medium['sizes']['small']['w'];
				$media_urls[ $size ] = $this_media_url . ':small';
			}

			if ( isset( $medium['sizes']['medium']['w'] ) ) {
				$size = $medium['sizes']['medium']['w'];
				$media_urls[ $size ] = $this_media_url;
			}

			if ( isset( $medium['sizes']['large']['w'] ) ) {
				$size = $medium['sizes']['large']['w'];
				$media_urls[ $size ] = $this_media_url . ':large';
			}

			if ( empty( $medium['sizes'] )
				&& ! empty( $this_media_url ) ) {
				$media_urls[1000] = $this_media_url;
			}
			$return[] = $media_urls;
		}


		if ( ! isset( $medium_or_api_data['id_str'] ) ) {
			return $return[0];
		}

		return $return;
	}

    // Templating methods below

    public static function get_feed_type( $feed_options ) {
        $ctf_feed_type = ! empty ( $feed_options['type'] ) ? $feed_options['type'] : 'multiple';
        return $ctf_feed_type;
    }

    public static function get_feed_classes( $feed_options, $check_for_duplicates, $feed_id = false) {

    	if( ctf_doing_customizer( $feed_options ) ){
			return ' :class="$parent.getFeedClasses()" ';
		}else{
	        $ctf_feed_classes = 'ctf ctf-type-' . CTF_Parse_Pro::get_feed_type( $feed_options );
	        $ctf_feed_classes .= ' ' . $feed_options['class'] . ' ctf-styles';
	        $ctf_feed_classes .= ($feed_id !== false ) ?  ' ctf-feed-' . $feed_id : '';
	        $ctf_feed_classes .= ($feed_options['layout']) ?  ' ctf-' . $feed_options['layout']: '';
	        $ctf_feed_classes .= ( isset( $feed_options['tweetpoststyle'] ) ) ?  ' ctf-' . $feed_options['tweetpoststyle'] . '-style' : '';
	        if ( ! empty( $feed_options['height'] ) ) $ctf_feed_classes .= ' ctf-fixed-height';
	        $ctf_feed_classes .= $feed_options['width_mobile_no_fixed'] ? ' ctf-width-resp' : '';
	        if ( $feed_options['autoscroll'] ) { $ctf_feed_classes .= ' ctf-autoscroll'; }
	        if ( $check_for_duplicates ) { $ctf_feed_classes .= ' ctf-no-duplicates'; }
	        if ( $feed_options['persistentcache'] ) { $ctf_feed_classes .= ' ctf-persistent'; }
	        if ( $feed_options['font_method'] === 'fontfile' ) { $ctf_feed_classes .= ' ctf-fontfile'; }

	        if( isset($feed_options['colorpalette']) && $feed_options['colorpalette'] !== 'inherit' && $feed_id !== false ){
	        	$feed_id_class = $feed_options['colorpalette'] === 'custom' ? ('_' . $feed_id) : '';
	        	$ctf_feed_classes .= ' ctf_palette_' . $feed_options['colorpalette'] . $feed_id_class;
	        }

	        $ctf_feed_classes = apply_filters( 'ctf_feed_classes', $ctf_feed_classes ); //add_filter( 'ctf_feed_classes', function( $ctf_feed_classes ) { return $ctf_feed_classes . ' new-class'; }, 10, 1 );
			return ' class="'.$ctf_feed_classes.'" ';
		}
    }

    public static function get_header_avatar( $data, $feed_options = array() ) {
        $settings = ctf_get_database_settings();
	    if ( CTF_GDPR_Integrations::doing_gdpr( $settings ) ) {
		    $avatar = ctf_get_local_avatar( $feed_options['screenname'], $feed_options );
	    } else {
		    $avatar = $data['profile_image_url_https'];
	    }

	    return $avatar;
	}

	public static function get_header_text( $header_info, $feed_options ) {
		if ( empty( $header_info ) || ! is_array( $header_info ) ) {
			return '';
		}

		if ( $feed_options['headertext'] !== '' ) {
			$header_text = $feed_options['headertext'];
			return $header_text;
		} else {
			$header_text = $header_info['name'];
			return $header_text;
		}

	}

    public static function get_header_description( $data ) {
        return $data['description'];
    }

    public static function get_user_header_json( $data ) {
        $transient = $data['type'] === 'usertimeline' ? 'ctf_header_' . $data['screenname'] : 'ctf_hometimeline_header';

        $header_json = get_transient( $transient );
		$header_array = json_decode( $header_json, true );
        if ( ! $header_json || isset($header_array['errors']) ) {
            $endpoint = 'accountlookup';
            if ( $data['type'] === 'usertimeline' ) {
                $endpoint = 'userslookup';
            }

                // Only can be set in the options page
            $request_settings = array(
                'consumer_key' => $data['consumer_key'],
                'consumer_secret' => $data['consumer_secret'],
                'access_token' => $data['access_token'],
                'access_token_secret' => $data['access_token_secret'],
            );

            $CtfFeedPros = new CtfFeedPro( array(), null, null );

            $get_fields = $CtfFeedPros->setGetFieldsArray( $endpoint, $data['screenname'] );
            // actual connection
            $twitter_connect = new CtfOauthConnectPro( $request_settings, $endpoint );
            $twitter_connect->setUrlBase();
            $twitter_connect->setGetFields( $get_fields );
            $twitter_connect->setRequestMethod( $data['request_method'] );

            $request_results = $twitter_connect->performRequest();

            $header_json = isset( $request_results->json ) ? $request_results->json : false;

            if ( $endpoint === 'accountlookup' ) {
                set_transient( 'ctf_hometimeline_header', $header_json, 60*60 );
            } else {
                set_transient( 'ctf_header_' . $data['screenname'], $header_json, 60*60 );
            }

        }
        $header_info = isset( $header_json ) ? json_decode( $header_json, true ) : array();
        if ( isset( $header_info[0] ) && !isset($header_info['errors'])) {
            return $header_info = $header_info[0];
        } elseif ( ! isset( $header_info['screen_name'] ) ) {
            return [
            	'name' => $data['screenname'],
            	'description' => ''
            ];
        }

        return $header_info;
    }

    public static function get_header_tweet_count( $data ) {
        return number_format( intval( $data['statuses_count'] ) );
    }

    public static function get_follower_count( $data ) {
        return number_format( intval( $data['followers_count'] ) );
    }

    public static function get_post($tweet_set) {

        if ( isset( $tweet_set['retweeted_status'] ) ) {
            return $tweet_set['retweeted_status'];
        } else {
            return $tweet_set;
        }

    }

    public static function get_post_id( $data ) {
        return $data['id_str'];
    }

    public static function get_item_classes( $data, $feed_options, $i ) {

        $data = $data[$i];

        // creates a string of classes applied to each tweet
        $tweet_classes = 'ctf-item ctf-author-' . CTF_Parse_Pro::get_author_screen_name( $data ) .' ctf-new';

        $tweet_classes = apply_filters( 'ctf_tweet_classes', $tweet_classes );

        if ($feed_options['layout'] === 'masonry' && !ctf_doing_customizer($feed_options)) {
            $tweet_classes .= ' ctf-transition';
        }

        if ( !ctf_show( 'avatar', $feed_options ) ) $tweet_classes .= ' ctf-hide-avatar';

        if ( ctf_show( 'logo', $feed_options ) ) $tweet_classes .= ' ctf-with-logo';


        if ( isset( $data['retweeted_status'] ) ) {
            $tweet_classes .= ' ctf-retweet';
        }

        if ( isset( $data['in_reply_to_screen_name'] ) && $data['in_reply_to_screen_name'] !== $data['user']['screen_name'] ) {
            $tweet_classes .= ' ctf-reply';
        }

        if ( isset( $data['quoted_status'] ) ) {
            $tweet_classes .= ' ctf-quoted';
        }

        if ( ctf_show( 'twittercards', $feed_options ) && isset( $data['twitter_card'] ) ) {
		    $tweet_classes .= ' ctf-tc-checked';
	    }

	    if ( ! ctf_show( 'author', $feed_options ) ) {
		    $tweet_classes .= ' ctf-hide-author';
	    }

        return $tweet_classes;
    }

    public static function get_author_name( $data ) {
        return strtolower( $data['user']['name'] );
    }

    public static function get_author_screen_name( $data ) {
        return strtolower( $data['user']['screen_name'] );
    }

    public static function get_quoted_name( $data ) {
        return $data['user']['name'];
    }

    public static function get_quoted_verified( $data ) {
        return $data['user']['verified'];
    }

    public static function get_quoted_screen_name( $data ) {
        return $data['user']['screen_name'];
    }

    public static function get_generic_header_text( $data ) {
        if ( $data['type'] === 'search' || $data['type'] === 'hashtag' ) {
            $using_custom = $data['headertext'] != '';
            $raw_header_text = $using_custom ? $data['headertext'] : $data['feed_term'];

            //List multiple terms
            $hashtags = explode(" OR ", $data['feed_term']);
            if ( ! $using_custom ) {
                $default_header_text = '';
                $h_index = 0;
                foreach ( $hashtags as $hashtag ) {
                    if( $h_index > 0 ) $default_header_text .= ', ';
                    $default_header_text .= $hashtag;
                    $h_index++;
                }
            } else {
                $default_header_text = $data['headertext'];
            }

            $default_header_text = str_replace( ' -filter:retweets', '', $default_header_text );


            return $default_header_text;

        } else {
            $default_header_text = 'Twitter';
            // $url_part = $data['screenname']; //Need to get screenname here

            return $default_header_text;
        }

        //Header for combined feed types
        if ( ! empty( $data['feed_types_and_terms'] ) ) {
            if ( $data['headertext'] != '' ) {
                $default_header_text = $data['headertext'];

                if ( $data['feed_types_and_terms'][0][0] === 'search' || $data['feed_types_and_terms'][0][0] === 'hashtag' ) {
                    $raw_header_text = $data['feed_types_and_terms'][0][1];
                }

                return $default_header_text;

            } else {
                $default_header_text = '';
                $i_term = 0;
                foreach ( $data['feed_types_and_terms'] as $feed_set ) {
                    if ( $feed_set[0] == 'lists' ) {
                        $default_header_text .= '';
                    } else {
                        if ( $i_term > 0 ) {
                            $default_header_text .= ', ';
                        }
                        if ( $feed_set[0] == 'usertimeline' ) {
                            $default_header_text .= '@';
                        }
                        $default_header_text .= $feed_set[1];
                    }
                    $i_term++;
                }
            }

            if ( empty( $default_header_text ) ) {
                return $default_header_text = 'Twitter';
            }

        }
    }

    public static function get_generic_header_url ( $data ) {
        $hashtags = isset($data['feed_term']) ? explode(" OR ", $data['feed_term']) : '';
        if ( $data['type'] === 'search' || $data['type'] === 'hashtag' ) {
            if ( $data['type'] === 'hashtag' ) {
                $url_part = 'hashtag/' . str_replace("#", "", $hashtags[0]);
            } else {
                $url_part = 'search?q=' . rawurlencode( str_replace( array( ', ', "'" ), array( ' OR ', '"' ), $data['feed_term'] ) );
            }

            return $url_part;
        }

        if ( ! empty( $data['feed_types_and_terms'] ) ) {
            if ( $data['feed_types_and_terms'][0][0] === 'search' || $data['feed_types_and_terms'][0][0] === 'hashtag' ) {
                $raw_header_text = $data['feed_types_and_terms'][0][1];
                //List multiple terms
                $hashtags = explode( " OR ", $data['feed_types_and_terms'][0][1] );

                if ( $data['feed_types_and_terms'][0][0] === 'hashtag' ) {
                    $url_part = 'hashtag/' . str_replace( "#", "", $hashtags[0] );

                    return $url_part;
                } else {
                    $url_part = 'search?q=' . rawurlencode( str_replace( array( ', ', "'" ), array(
                            ' OR ',
                            '"'
                        ), $data['feed_types_and_terms'][0][1] ) );

                    return $url_part;
                }
            }
        }

    }

    public static function get_retweet_status( $data ) {
        if ( isset( $data['retweeted_status'] ) ){
            return $data['retweeted_status'];
        }
        return false;
    }

    public static function get_retweet_id( $data ) {
        if( isset( $data['retweeted_status']['id_str'] ) ){
            return $data['retweeted_status']['id_str'];
        }
    }

    public static function get_retweeter_name( $data, $i ) {
        $retweeter = array();

        // check for retweet
        if ( isset( $data[$i]['retweeted_status'] ) ) {
            $data = $data[$i];
            $twitter_card_retweeted = isset( $data['twitter_card'] ) ? $data['twitter_card'] : false;
            $retweeter = array(
                'name' => $data['user']['name'],
                'screen_name' => $data['user']['screen_name']
            );
            // $retweet_data_att = ( $data->check_for_duplicates ) ? ' data-ctfretweetid="'.$data['retweeted_status']['id_str'].'"' : '';

            $data['twitter_card'] = $twitter_card_retweeted;
            return $retweeter;
        } else {
            unset( $retweeter );
        }

    }

    public static function get_replied_to( $data ) {
        $replied_to = '';
        // check for reply
        if ( isset( $data['in_reply_to_screen_name'] ) && $data['in_reply_to_screen_name'] !== $data['user']['screen_name'] ) {
            $replied_to = array(
                'screen_name' => $data['in_reply_to_screen_name'],
                'name' => $data['entities']['user_mentions'][0]['name'],
                'id_str' => $data['in_reply_to_status_id_str']
            );
            return $replied_to;
        } else {
            unset( $replied_to );
        }

    }

    public static function get_quoted_tc( $data ) {

        $quoted = false;

        // check for quoted
        if ( isset( $data['quoted_status'] ) ) {
            $quoted = $data['quoted_status'];
            return $quoted;
        } else {
            unset( $quoted );
        }

    }

    public static function get_media( $data, $num_media = false ) {
        //Media
        $media = false ;

        if ( isset( $data['extended_entities']['media'] ) ) {

            $num_media = count( $data['extended_entities']['media'] );
            for( $ii = 0; $ii < $num_media; $ii++ ) {
                if ( $data['extended_entities']['media'][$ii]['type'] == 'video' || $data['extended_entities']['media'][$ii]['type'] == 'animated_gif' ) {
                    $media[$ii]['url'] = $data['extended_entities']['media'][$ii]['video_info']['variants'][$ii]['url'];
                } else {
                    $media[$ii]['url'] = isset( $data['extended_entities']['media'][$ii]['media_url_https'] ) ? $data['extended_entities']['media'][$ii]['media_url_https'] : '';
                }
                $media[$ii]['type'] = $data['extended_entities']['media'][$ii]['type'];
                if ( $media[$ii]['type'] == 'video' ) {
                    $media[$ii]['video_atts'] = 'controls';
                } elseif ( $media[$ii]['type'] == 'animated_gif' ) {
                    $media[$ii]['video_atts'] = 'controls loop autoplay muted';
                }
                $media[$ii]['poster'] = isset( $data['extended_entities']['media'][$ii]['media_url_https'] ) ? $data['extended_entities']['media'][$ii]['media_url_https'] : '';
                if ( $media[$ii]['type'] == 'photo' ) {
                    $media[$ii]['sizes'] = isset( $data['extended_entities']['media'][$ii]['sizes'] ) ? $data['extended_entities']['media'][$ii]['sizes'] : '';
                }
            }

        } elseif ( isset( $data['entities']['media'] ) ) {

            $num_media = count( $data['entities']['media'] );
            for( $ii = 0; $ii < $num_media; $ii++ ) {
                if ( $data['entities']['media'][$ii]['type'] == 'video' || $data['entities']['media'][$ii]['type'] == 'animated_gif' ) {
                    $media[$ii]['url'] = $data['entities']['media'][$ii]['video_info']['variants'][$ii]['url'];
                } else {
                    $media[$ii]['url'] = $data['entities']['media'][$ii]['media_url_https'];
                }
                $media[$ii]['type'] = $data['entities']['media'][$ii]['type'];
                if ( $media[$ii]['type'] == 'video' ) {
                    $media[$ii]['video_atts'] = 'controls';
                } elseif ( $media[$ii]['type'] == 'animated_gif' ) {
                    $media[$ii]['video_atts'] = 'controls loop autoplay muted';
                }
                $media[$ii]['poster'] = $data['entities']['media'][$ii]['media_url_https'];
                if ( $media[$ii]['type'] == 'photo' ) {
                    $media[$ii]['sizes'] = $data['entities']['media'][$ii]['sizes'];
                }
            }

        }

        return $media;
    }

    public static function get_quoted_media( $data, $num_media ) {
        //Quoted Tweets Media
        $quoted_media = false;

        if ( isset( $data['extended_entities']['media'] ) ) {

            $num_media = count( $data['extended_entities']['media'] );
            for( $ii = 0; $ii < $num_media; $ii++ ) {
                if ( $data['extended_entities']['media'][$ii]['type'] == 'video' || $data['extended_entities']['media'][$ii]['type'] == 'animated_gif' ) {
                    $quoted_media[$ii]['url'] = $data['extended_entities']['media'][$ii]['video_info']['variants'][$ii]['url'];
                } else {
                    $quoted_media[$ii]['url'] = $data['extended_entities']['media'][$ii]['media_url_https'];
                }
                $quoted_media[$ii]['type'] = $data['extended_entities']['media'][$ii]['type'];
                if ( $quoted_media[$ii]['type'] == 'video' ) {
                    $quoted_media[$ii]['video_atts'] = 'controls';
                } elseif ( $quoted_media[$ii]['type'] == 'animated_gif' ) {
                    $quoted_media[$ii]['video_atts'] = 'controls loop autoplay muted';
                }
                $quoted_media[$ii]['poster'] = $data['extended_entities']['media'][$ii]['media_url_https'];
            }

        } elseif ( isset( $data['entities']['media'] ) ) {

            $num_media = count( $data['entities']['media'] );
            for( $ii = 0; $ii < $num_media; $ii++ ) {
                if ( $data['entities']['media'][$ii]['type'] == 'video' || $data['entities']['media'][$ii]['type'] == 'animated_gif' ) {
                    $quoted_media[$ii]['url'] = $data['entities']['media'][$ii]['video_info']['variants'][$ii]['url'];
                } else {
                    $quoted_media[$ii]['url'] = $data['entities']['media'][$ii]['media_url_https'];
                }
                $quoted_media[$ii]['type'] = $data['entities']['media'][$ii]['type'];
                if ( $quoted_media[$ii]['type'] == 'video' ) {
                    $quoted_media[$ii]['video_atts'] = 'controls';
                } elseif ( $quoted_media[$ii]['type'] == 'animated_gif' ) {
                    $quoted_media[$ii]['video_atts'] = 'controls loop autoplay muted';
                }
                $quoted_media[$ii]['poster'] = $data['entities']['media'][$ii]['media_url_https'];
            }

        }

        return $quoted_media;
    }

    public static function get_twitter_card( $data ) {
        if ( isset( $data['twitter_card'] ) ) {
            return $data['twitter_card'];
        }
    }

    public static function get_twitter_card_url( $data ) {
        if ( isset( $data['entities']['urls'][0]['expanded_url'] ) ) {
            return $data['entities']['urls'][0]['expanded_url'];
        }
    }

    public static function iframe_data( $twitter_card_url ) {
        //Check whether it's a 3rd party video (youtube, vimeo, vine)
        $iframe_data = array();
        if( $twitter_card_url ){

            //Check whether it's a youtube video
            $youtube = stripos($twitter_card_url, 'youtube.com/watch');
            $youtu = stripos($twitter_card_url, 'youtu.be');
            $youtubeembed = stripos($twitter_card_url, 'youtube.com/embed');

            //Check whether it's a Vimeo video
            $vimeo = stripos($twitter_card_url, 'vimeo');

            //Check whether it's a Vine video
            $vine = stripos($twitter_card_url, 'vine.co');

            //Check whether it's a SoundCloud embed
            $soundcloud = stripos($twitter_card_url, 'soundcloud.com');

            //Check whether it's a Spotify embed
            $spotify = stripos($twitter_card_url, 'open.spotify.com');

            //YouTube
            if( $youtube || $youtubeembed || $youtu ){
                if ($youtube || $youtubeembed) {
                    //Get the unique video id from the url by matching the pattern
                    if (preg_match("/v=([^&]+)/i", $twitter_card_url, $matches)) {
                        $id = $matches[1];
                    }   elseif(preg_match("/\/v\/([^&]+)/i", $twitter_card_url, $matches)) {
                        $id = $matches[1];
                    }   elseif(preg_match("/\/embed\/([^&]+)/i", $twitter_card_url, $matches)) {
                        $id = $matches[1];
                    }
                } else if ($youtu) {
                    $id = explode('/', $twitter_card_url);
                    $id = end($id);
                }
                if ( isset ( $id ) && ! is_array( $id ) ) {
                    $id = explode("?", $id);
                } else {
                    $id = array();
                }
                if ( isset( $id[0] ) ) {
                    $last = $id[0];
                } else {
                    $last = '';
                }
                $iframe_src = 'https://www.youtube.com/embed/' . $last;
	            $iframe_data['url'] = $iframe_src;
            }

            //Vimeo
            if ($vimeo) {
                $clip_id = '';

                //http://vimeo.com/moogaloop.swf?clip_id=101557016&autoplay=1
                $query = parse_url($twitter_card_url, PHP_URL_QUERY);
                parse_str($query, $params);
                if(isset($params['clip_id'])) $clip_id = $params['clip_id'];

                //https://player.vimeo.com/video/116446625?autoplay=1
                if( !isset($clip_id) || $clip_id == '' ){
                    $vimeo_url = strtok($twitter_card_url,'?');
                    $vimeo_pass = explode('/', $vimeo_url);
                    $clip_id = end(($vimeo_pass));
                }
	            if( !isset($clip_id) || $clip_id == '' ){
		            $vimeo_url = strtok($twitter_card_url,'?');
		            $vimeo_pass = explode('/', $vimeo_url);
		            $clip_id = end(($vimeo_pass));
	            }
                if (!preg_match('([a-zA-Z])', $clip_id)) {
                    $iframe_src = 'https://player.vimeo.com/video/'.$clip_id;
	                $iframe_data['url'] = $iframe_src;
                } else {
                    $iframe_src = '';
                    $vimeo = false;
                }

            }

            //Vine
            if ($vine) {
                //https://vine.co/v/hu77ljU6OOF/embed/simple
                $twitter_card_url = explode("?", $twitter_card_url);
                $iframe_src = $twitter_card_url[0] . '/embed/simple';
	            $iframe_data['url'] = $iframe_src;
            }

            //SoundCloud
            if ($soundcloud){
                $twitter_card_url = explode("/s-", $twitter_card_url);
                $iframe_src = 'https://w.soundcloud.com/player/?url=' . $twitter_card_url[0] . '/&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=true&amp;show_reposts=false&amp;visual=false';
	            $iframe_data['iframe_type'] = 'audio';
	            $iframe_data['url'] = $iframe_src;
            }

            //Spotify
            /*
             * https://open.spotify.com/track/5H0kIgpWNZm9HF6VkU4dow?si=KvuO3MAuQmCxq8AI2QdhCw
             * <iframe src="https://open.spotify.com/embed/album/1DFixLWuPkv3KT3TnV35m3" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
<iframe src="https://open.spotify.com/embed/track/5H0kIgpWNZm9HF6VkU4dow?si=KvuO3MAuQmCxq8AI2QdhCw" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
             */
            if ($spotify){
                $type = strpos( $twitter_card_url, 'track/' ) !== false ? 'track' : 'album';
                $url_pieces = $type === 'track' ? explode('track', $twitter_card_url ) : explode('album', $twitter_card_url );
                if ( isset( $url_pieces[1] ) ) {
                    $iframe_src = 'https://open.spotify.com/embed/' . $type . $url_pieces[1];
	                $iframe_data['iframe_class'] = ' ctf-spotify';
	                $iframe_data['iframe_type'] = 'audio';

	                $iframe_data['url'] = $iframe_src;
                } else {
                    $spotify = false;
                }
            }

            //If the link is for an embedded video then add to media object
            if($youtube || $youtu || $youtubeembed || $vimeo || $vine || $soundcloud || $spotify){
	            $iframe_data['type'] = 'iframe';
                return $iframe_data;
            }

        } // if( $twitter_card_url )

        return array();
    }

    public static function get_medium_type( $data ) {
        return $data['type'];
    }

    public static function get_medium_video_atts( $data ) {
		$atts = isset( $data['video_atts'] ) ? $data['video_atts'] : array();
        return $atts;
    }

    public static function get_medium_url( $data ) {
        return $data['url'];
    }

    public static function get_utc_offset ( $data ) {
        return $data['user']['utc_offset'];
    }

    public static function get_verified ( $data ) {
        return $data['user']['verified'];
    }

    public static function get_profile_image_url_https ( $data ) {
        return $data['user']['profile_image_url_https'];
    }

     /**
     * Get Global Twitter Feed CSS
     *
     * @since 2.0
     * @return array
    */
    public static function parse_css_style ( $css_array ) {
    	$style = '';
    	$color_elements = [
    		'color',
    		'background',
    		'background-color'
    	];

    	$size_elements = [
    		'border-radius',
    		'height',
    		'width',
    		'font-size',
    		'margin',
    		'margin-top',
    		'margin-bottom',
    		'margin-left',
    		'margin-right',
    		'padding',
    		'padding-top',
    		'padding-bottom',
    		'padding-left',
    		'padding-right'
    	];

    	$border_elements = [
    		'border',
    		'border-top',
    		'border-bottom',
    		'border-left',
    		'border-right'
    	];

    	foreach ($css_array as $element) {
    		$items_css = '';
    		if( isset( $element['properties'] ) ){
	    		foreach ($element['properties'] as $property => $item) {
		    		if( in_array( $property, $color_elements) && !empty( $item['value'] ) && $item['value'] !== '#' ){
		    			$items_css .= $property . ':' . stripcslashes($item['value']) . ( isset( $item['important'] ) ? '!important;' : ';' );
		    		}
		    		if( in_array( $property, $size_elements) && !empty( $item['value'] ) && $item['value'] !== '0' && $item['value'] !== 'inherit' ){
		    			$items_css .= $property . ':' . stripcslashes($item['value']) . ( isset( $item['unit'] ) ?  $item['unit'] : 'px' ) . ( isset( $item['important'] ) ? '!important;' : ';' );
		    		}
		    		if( in_array( $property, $border_elements) && !empty( $item['size'] ) && $item['size'] !== '0' && !empty( $item['color'] ) && $item['color'] !== '#' ){
		    			$items_css .= $property . ':' . stripcslashes($item['size']) .  'px ' . ( isset( $item['style'] ) ? $item['style'] : 'solid' ) . ' ' . stripcslashes($item['color']) . ( isset( $item['important'] ) ? '!important;' : ';' );
		    		}
	    		}
	    		$style .= !empty($items_css) ? $element['selector'] . '{'.$items_css .'}' : '';
    		}
    	}

    	return $style;
    }

}
