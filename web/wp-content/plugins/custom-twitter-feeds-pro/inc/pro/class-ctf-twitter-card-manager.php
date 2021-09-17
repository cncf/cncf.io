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

class CTF_Twitter_Card_Manager {

	public static function maybe_stored_card( $key ) {
		$existing_twitter_card_data = get_option( 'ctf_twitter_cards', array() );
		if ( ! is_array( $existing_twitter_card_data ) ) {
			$existing_twitter_card_data = array();
		}
		if ( isset( $existing_twitter_card_data[ $key ] ) ) {
			return $existing_twitter_card_data[ $key ];
		}

		return false;
	}

	public static function get_key_for_card( $id_or_url ) {
		$key = $id_or_url;
		if ( strpos( $id_or_url, '//' ) !== false ) {
			$key = preg_replace( '~[^a-zA-Z0-9]+~', '', $id_or_url );
		}

		return $key;
	}

	public static function store_card( $key, $data ) {
		$existing_twitter_card_data = get_option( 'ctf_twitter_cards', array() );
		if ( ! is_array( $existing_twitter_card_data ) ) {
			$existing_twitter_card_data = array();
		}
		if ( is_array( $existing_twitter_card_data ) && count( $existing_twitter_card_data ) > CTF_TC_LIMIT - 1 ) {
			reset( $existing_twitter_card_data );
			unset( $existing_twitter_card_data[ key($existing_twitter_card_data)]);
		}
		$existing_twitter_card_data[ $key ] = $data;

		update_option( 'ctf_twitter_cards', $existing_twitter_card_data, false );
	}

	public static function process_url_batch( $items, $max = 5 ) {

		$new_cards_retrieved = 0;
		$return              = array();

		foreach ( $items as $url_or_item_array ) {
			if ( is_array( $url_or_item_array ) ) {
				$id  = $url_or_item_array['id'];
				$url = $url_or_item_array['url'];
			} else {
				$id  = CTF_Twitter_Card_Manager::get_key_for_card( $url_or_item_array );
				$url = $url_or_item_array;
			}
			$maybe_stored_card = CTF_Twitter_Card_Manager::maybe_stored_card( $id );

			if ( $maybe_stored_card !== false ) {
				if ( ! isset( $maybe_stored_card['local'] ) ) {
					$maybe_stored_card['local'] = CTF_Twitter_Card_Manager::add_local_image( $maybe_stored_card, $id );
				}
				$return[] = array(
					'id'   => $id,
					'url' => $url,
					'twitter_card' => $maybe_stored_card,
					'is_new' => false
				);
			} elseif ( $new_cards_retrieved < $max ) {
				$new_cards_retrieved ++;
				$twitter_card = new CTF_Twitter_Card_Generator( $url );
				$twitter_card->generate();

				$new_data = $twitter_card->get_twitter_card_data();

				CTF_Twitter_Card_Manager::store_card( $id, $new_data );

				$return[] = array(
					'id'   => $id,
					'url' => $url,
					'twitter_card' => $new_data,
					'is_new' => true
				);
			}

		}

		return $return;
	}

	public static function add_local_image( $card, $id ) {
		$existing_twitter_card_data = get_option( 'ctf_twitter_cards', array() );

		$twitter_card = new CTF_Twitter_Card_Generator( '' );
		$local = false;
		if ( ! empty( $card['twitter:image'] ) ) {
			$local = $twitter_card->create_local_image( $card['twitter:image'] );
		}
		$card['local'] = $local;
		$existing_twitter_card_data[ $id ] = $card;

		update_option( 'ctf_twitter_cards', $existing_twitter_card_data, false );

		return $local;
	}

	public static function delete_local( $card_data ) {

		$resizer = new CTF_Resizer();

		if ( isset( $card_data['local'] ) ) {

			if ( is_array( $card_data['local'] ) ) {
				foreach ( $card_data['local'] as $size => $file ) {
					$resizer->delete_image( $file );

				}
			}


			unset( $card_data['local'] );
		}

		return $card_data;
	}

	public static function clear_all_local() {

		$existing_twitter_card_data = get_option( 'ctf_twitter_cards', array() );
		if ( ! is_array( $existing_twitter_card_data ) ) {
			$existing_twitter_card_data = array();
		}

		foreach ( $existing_twitter_card_data as $key => $single_card ) {
			$existing_twitter_card_data[ $key ] = CTF_Twitter_Card_Manager::delete_local( $single_card );
		}

		update_option( 'ctf_twitter_cards', $existing_twitter_card_data, false );
	}
}
