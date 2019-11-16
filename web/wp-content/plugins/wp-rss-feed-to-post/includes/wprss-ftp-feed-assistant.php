<?php

class WPRSS_FTP_Feed_Assistant {
	

	/**
	 * Array of (sanitised) parameters we were called with.
	 */
	private $params;


	/**
	 * The Singleton instance.
	 */
	private static $instance;


	/**
	 * The constructor.
	 * @since 3.3.2
	 */
	public function __construct() {
		$this->register_hooks();
	}


	/**
	 * Returns the singleton instance.
	 * @since 3.3.2
	 */
	public static function get_instance() {
		if ( self::$instance === NULL ) {
			self::$instance = new self();
		}
		return self::$instance;
	}


	/**
	 * Registers the hooks that the class will use.
	 * @since 3.3.2
	 */
	private function register_hooks() {
		add_action( 'wp_ajax_wprss_ajax_check_feed', array( $this, 'ajax_check_feed') );
		add_action( 'wprss_ftp_enqueue_edit_scripts_before', array( $this, 'enqueue_edit_scripts' ) );
	}


	/**
	 * Triggered when adding scripts to the Add New/Edit Feed Source page.
	 * @since 3.3.2
	 */
	public function enqueue_edit_scripts() {
		wp_enqueue_script( 'wprss_ftp_feed_assistant_class', WPRSS_FTP_JS . 'admin-feed-assistant-class.js', array('jquery') );
		wp_enqueue_script( 'wprss_ftp_feed_assistant', WPRSS_FTP_JS . 'admin-feed-assistant.js', array('jquery', 'wprss_ftp_feed_assistant_class') );
	}


	/**
	 * Sanitises the parameters that were passed via the AJAX request.
	 * @since 3.3.2
	 */
	private function sanitize_request_parameters($orig) {
		$params = array(
			'url' => '',
			'num_items' => 1,
			'apply_filters' => FALSE,
			'post_id' => NULL,
			'force_feed' => FALSE,
			'full_content' => FALSE,
		);

		if ( isset($_GET['url']) ) {
			$params['url'] = esc_url_raw($_GET['url']);
		}

		if ( isset($_GET['num_items']) && intval($_GET['num_items']) ) {
			$params['num_items'] = intval($_GET['num_items']);
		}

		if ( isset($_GET['apply_filters']) ) {
			$params['apply_filters'] = WPRSS_FTP_Utils::multiboolean($_GET['apply_filters']);
		}

		if ( isset($_GET['post_id']) ) {
			$params['post_id'] = intval($_GET['post_id']);
		}

		if ( isset($_GET['force_feed']) ) {
			$params['force_feed'] = WPRSS_FTP_Utils::multiboolean($_GET['force_feed']);
		}

		if ( isset($_GET['full_content']) ) {
			$params['full_content'] = WPRSS_FTP_Utils::multiboolean($_GET['full_content']);
		}

		return $params;
	}

	/**
	 * Helper function to send an error message in JSON format.
	 * @since 3.3.2
	 */
	private function send_error($msg) {
		die(
			json_encode(
				array(
					'error' => $msg
				)
			)
		);
	}


	/**
	 * Small formatter for error text
	 * @since 3.3.2
	 */
	private function format_error_string($error) {
		return "<strong style='color:red;'>{$error}</strong>";
	}


	/**
	 * AJAX request handler to check an RSS feed URL
	 * @since 3.3.2
	 */
	public function ajax_check_feed($params) {
		if ( !isset($params) ) {
			$params = $_GET;
		}

		$this->params = $this->sanitize_request_parameters($params);

		$url = $this->params['full_content']
			? WPRSS_FTP_Converter::get_full_content_url($this->params['url'], null, $this->params['force_feed'])
			: $this->params['url'];

		// Fetch the feed and pluck off the amount of items requested.
		if ( version_compare( WPRSS_VERSION, '4.6.12', '>' ) ) {
			$items = wprss_get_feed_items( $url, NULL, $this->params['force_feed'] );
		} else {
			$items = wprss_get_feed_items( $url, NULL );
		}

		if ( !$items ) {
			$this->send_error( sprintf(__('Couldn\'t fetch any feed items from %s', WPRSS_TEXT_DOMAIN), $this->params['url']) );
		}

		$items = array_slice( $items, 0, $this->params['num_items'] );

		$response = array(
			'hints' => array(),
			'preview' => array()
		);

		// Iterate over the feed items...
		foreach ($items as $idx => $item) {

			$title = $this->preview_title($item);
			$content = $this->preview_content($item);
			$date = $this->preview_date($item);

			// Check feed item's images.
			$images = $this->check_image_location($item);
			if ( empty($response['hints']['images']) && isset( $images['hint'] ) ) {
				$response['hints']['images'] = $images['hint'];
			}

			// Check whether force full content should be enabled.
			$force_full_content = $this->check_force_full_content( $item );
			if ( $force_full_content && empty( $response['hints']['force_full_content'] ) ) {
				$response['hints']['force_full_content'] = $force_full_content;
			}


			// Create the feed item preview array
			$response['preview'][] = array(
				'title' => $title,
				'date' => $date,
				'content' => $content,
				'num_enclosures' => sizeof($item->get_enclosures()),
				'images' => $images
			);

		}

		echo json_encode($response);
		die();
	}


	/**
	 * Get the specified feed item's title
	 * @since 3.3.2
	 */
	private function preview_title($item) {
		
		$title = $item->get_title();
		
		if ( WPRSS_FTP_Utils::multiboolean( $this->params['apply_filters'] ) === TRUE ) {
			$title = apply_filters( 'wprss_ftp_converter_post_title', $title, 0 );
		}

		if (empty($title)) {
			$title = $this->format_error_string( __('The item has no title!', WPRSS_TEXT_DOMAIN) );
		}

		return $title;
	}


	/**
	 * Get the specified feed item's content
	 * @since 3.3.2
	 */
	private function preview_content($item) {
		
		$content = $item->get_content();

		if ( WPRSS_FTP_Utils::multiboolean( $this->params['apply_filters'] ) === TRUE ) {
			$content = apply_filters( 'wprss_ftp_converter_post_content', $content, 0 );
		}

		if (empty($content)) {
			$content = $this->format_error_string( __('The item has no content!', WPRSS_TEXT_DOMAIN) );
		}

		return $content;
	}


	/**
	 * Get the specified feed item's date
	 * @since 3.3.2
	 */
	private function preview_date($item) {
		
		$date = $item->get_date( 'U' );
		
		if ( WPRSS_FTP_Utils::multiboolean( $this->params['apply_filters'] ) === TRUE ) {
			$date = apply_filters( 'wprss_ftp_converter_post_date', $date, 0 );
		}

		if (empty($date)) {
			$date = $this->format_error_string( __('The item has no date!', WPRSS_TEXT_DOMAIN) );
		} else {
                        $date_difference = human_time_diff( $date, current_time('timestamp'));
			$date = ( $date > current_time('timestamp') ) ? __( 'In', WPRSS_TEXT_DOMAIN ) . ' ' .$date_difference : $date_difference .' '. __( 'ago', WPRSS_TEXT_DOMAIN );
		}


		return $date;

	}


	/**
	 * Checks for images in the feed.
	 * @since 3.3.2
	 */
	private function check_image_location($item) {
		$ret = array(
			'locations' => array()
		);

		$autoselect_val = $autoselect_name = '';
		$thumb_width = 0;

		if ( $enclosure = $item->get_enclosure() ) {
			if ( $thumbnail = $enclosure->get_thumbnail() ) {
				$ret['locations'][] = $autoselect_name = 'media:thumbnail tag';
				$autoselect_val = 'thumb';
				$thumb_width = $enclosure->get_width();
			} else if ( $enclosure->get_link() && stripos($enclosure->get_type(), 'image') === 0 ) {
				$ret['locations'][] = $autoselect_name = 'enclosure tag';
				$autoselect_val = 'enclosure';
				$thumb_width = $enclosure->get_width();
			}
		}


		$content = $item->get_content();
		if ( stripos($content, '<img') !== FALSE ) {
			$ret['locations'][] = 'content';
			if ( empty($autoselect_val) ) {
				$autoselect_val = 'first';
				$autoselect_name = 'content';
			}

			// Try to get a 'width' attribute from the img tag and if we found it...
			$matched = preg_match('/<img[^>]*width\s?=\s?[\'"]([^>\s]+)[\'"]/', $content, $matches);
			if ($matched && !empty($matches[1])) {
				$width = intval($matches[1]);

				// ...check if it's wider than the width we got from the enclosures.
				if ($width > $thumb_width) {
					$autoselect_val = 'first';
					$autoselect_name = 'content';
				}
			}
		}

		$noImagesHint = $this->params['full_content']
			? __("No images were found in the feed.", 'wprss')
			: __("No images were found in the feed. Try enabling <strong>'Force Full Content.'</strong>", 'wprss');

		$foundImageHint = sprintf(__("Found highest-resolution image in the item's %s", 'wprss'), $autoselect_name);

		$ret['hint'] = array(
			'id' => 'wprss_ftp_featured_image',
			'placement' => 'wprss-tooltip-field_f2p_featured_image',
			'text' => empty($autoselect_val) ? $noImagesHint : $foundImageHint,
			'type' => empty($autoselect_val) ? 'warning' : 'ok',
			'autoselectValue' => empty($autoselect_val) ? 'first' : $autoselect_val,
			'autoselectName' => empty($autoselect_val) ? 'content' : $autoselect_name
		);

		return $ret;
	}


	/**
	 * Checks whether Force Full Content should be checked.
	 * @since 3.3.2
	 */
	private function check_force_full_content($item) {
		$link = $item->get_link();
		$hint = NULL;

		if ( stripos($link, ".facebook.com") !== FALSE ) {
			$hint = __("Facebook feed sources should generally leave this unchecked.", WPRSS_TEXT_DOMAIN);
		} else if ( stripos($link, ".youtube.com") !== FALSE ) {
			$hint = __("YouTube feed sources should generally leave this unchecked.", WPRSS_TEXT_DOMAIN);
		}

		if ( $hint ) {
			return array(
				'id' => 'wprss_ftp_force_full_content',
				'placement' => 'wprss-tooltip-field_f2p_force_full_content',
				'text' => $hint,
				'type' => 'ok',
				'autoselectValue' => 'unchecked',
				'autoselectName' => 'unchecked'
			);
		} else {
			return NULL;
		}
	}

}
