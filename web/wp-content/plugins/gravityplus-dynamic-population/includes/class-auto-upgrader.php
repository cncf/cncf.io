<?php
/*
 * @package   GFP_Auto_Upgrader
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class GFP_Auto_Upgrader
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Auto_Upgrader {

	protected $_version;

	protected $_min_gravityforms_version;

	protected $_slug;

	protected $_title;

	protected $_full_path;

	protected $_path;

	protected $_api_url;

	protected $_product_url;

	protected $_is_gravityforms_supported;

	protected $_api_data;


	/**
	 * GFP_Auto_Upgrader constructor.
	 *
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $slug
	 * @param $version
	 * @param $min_gravityforms_version
	 * @param $title
	 * @param $full_path
	 * @param $path
	 * @param $url
	 * @param $is_gravityforms_supported
	 * @param $_api_data
	 */
	public function __construct( $slug, $version, $min_gravityforms_version, $title, $full_path, $path, $api_url, $product_url, $is_gravityforms_supported, $_api_data ) {

		$this->_slug                      = $slug;

		$this->_version                   = $version;

		$this->_min_gravityforms_version  = $min_gravityforms_version;

		$this->_title                     = $title;

		$this->_full_path                 = $full_path;

		$this->_path                      = $path;

		$this->_api_url                   = $api_url;

		$this->_product_url               = $product_url;

		$this->_is_gravityforms_supported = $is_gravityforms_supported;

		$this->_api_data                  = $_api_data;


		add_action( 'init', array( $this, 'init' ) );

	}

	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function init() {

		if ( is_admin() ) {

			if ( basename( $_SERVER[ 'PHP_SELF' ] ) == 'plugins.php' ) {

				add_action( 'after_plugin_row_' . $this->_path, array( $this, 'plugin_row' ) );

			}

			add_filter( 'pre_set_site_transient_update_plugins', array( $this, 'check_update' ) );

			add_filter( 'plugins_api', array( $this, 'plugins_api' ), 10, 3 );

		}

		add_filter( 'mwp_premium_update_notification', array( $this, 'mwp_premium_update' ) );

		add_filter( 'mwp_premium_perform_update', array( $this, 'mwp_premium_update' ) );

	}

	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return void
	 */
	public function plugin_row() {

		if ( ! $this->_is_gravityforms_supported ) {

			$message = __( 'Gravity Forms ' . $this->_min_gravityforms_version . " is required.", 'gfp_auto_upgrader' );

			$style   = 'style="background-color: #ffebe8;"';

			echo '</tr><tr class="plugin-update-tr"><td colspan="5" class="plugin-update"><div class="update-message" ' . $style . '>' . $message . '</div></td>';

		} else {

			$version_info = $this->get_version_info( $this->_slug, $this->_api_data['license'], $this->_version, $this->_api_data['early_access'] );

			if ( ! $version_info[ 'is_valid_key' ] ) {

				$new_version = '';

				$message     = $new_version . sprintf( __( '%sRegister%s your copy of %s to receive access to automatic updates and support. Need a license key? %sPurchase one now%s.', 'gfp_auto_upgrader' ), '<a href="' . admin_url( 'admin.php' ) . '?page=gf_settings&subview=' . $this->_slug . '">', '</a>', $this->_title, '<a href="' . $this->_product_url. '">', '</a>' ) . '</div></td>';

				$this->display_plugin_message( $message );

			}

		}
	}


	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $update_plugins_option
	 *
	 * @return mixed
	 */
	public function check_update( $update_plugins_option ) {

		if ( empty( $update_plugins_option->checked ) ) {

			return $update_plugins_option;

		}

		$version_info = $this->get_version_info( $this->_slug, $this->_api_data['license'], $this->_version, $this->_api_data['early_access'], false );

		$this->set_version_info( $version_info );


		if ( $version_info == false ) {

			return $update_plugins_option;

		}

		if ( empty( $update_plugins_option->response[ $this->_path ] ) ) {

			$update_plugins_option->response[ $this->_path ] = new stdClass();

		}

		if ( ! $version_info['is_valid_key'] || version_compare( $this->_version, $version_info['version'], '>=' ) ) {

			unset( $update_plugins_option->response[ $this->_path ] );

		}
		else {

			$update_plugins_option->response[ $this->_path ]->url         = $this->_product_url;
			$update_plugins_option->response[ $this->_path ]->slug        = $this->_slug;
			$update_plugins_option->response[ $this->_path ]->package     = str_replace( "{KEY}", $this->_api_data['license'], $version_info['package'] );
			$update_plugins_option->response[ $this->_path ]->new_version = $version_info['version'];
			$update_plugins_option->response[ $this->_path ]->id          = '0';

		}


		return $update_plugins_option;

	}

	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $result
	 * @param $action
	 * @param $args
	 *
	 * @return bool|stdClass
	 */
	public function plugins_api( $result, $action, $args ) {

		if ( ( 'plugin_information' != $action ) || ( $args->slug != $this->_slug ) ) {

			return $result;

		}

		return $this->get_version_details( $this->_slug, $this->_api_data['license'], $this->_version, $this->_api_data['early_access'] );
	}

	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $version_info
	 */
	public function set_version_info ( $version_info ) {

		if ( function_exists( 'set_site_transient' ) ) {

			set_site_transient( $this->_slug . '_version', $version_info, 60 * 60 * 12 );

		} else {

			set_transient( $this->_slug . '_version', $version_info, 60 * 60 * 12 );

		}

	}


	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param      $message
	 * @param bool $is_error
	 */
	public function display_plugin_message ( $message, $is_error = false ) {

		$style = '';

		if ( $is_error ) {

			$style = 'style="background-color: #ffebe8;"';

		}

		echo '</tr><tr class="plugin-update-tr"><td colspan="5" class="plugin-update"><div class="update-message" ' . $style . '>' . $message . '</div></td>';
	}

	/**
	 * @since 1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $plugin_name
	 * @param $plugin_title
	 * @param $version
	 * @param $message
	 */
	public function display_upgrade_message ( $plugin_name, $plugin_title, $version, $message ) {

		$upgrade_message = $message . ' <a class="thickbox" title="' . $plugin_title . '" href="plugin-install.php?tab=plugin-information&plugin=' . $plugin_name . '&TB_iframe=true&width=640&height=808">' . sprintf( __( 'View version %s Details', 'gfp_auto_upgrader' ), $version ) . '</a>. ';

		$this->display_plugin_message( $upgrade_message );

	}

	/**
	 * Displays current version details on Plugin's page
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $product
	 * @param $key
	 * @param $version
	 * @param $early_access
	 *
	 * @return stdClass|WP_Error
	 */
	public function get_version_details ( $product, $key, $version, $early_access ) {

		$version_info = $this->get_version_info( $product, $key, $version, $early_access, false );

		if ( ( $version_info == false ) || ( ! array_key_exists( 'version_details', $version_info ) || ( empty( $version_info['version_details'] ) ) ) ) {

			return new WP_Error( 'no_version_info', __( 'An unexpected error occurred. Unable to find version details for this plugin. Please contact gravity+ Support.' ) );

		}

		$response = new stdClass();

		$response->name          = $version_info['version_details']['name'];
		$response->slug          = $version_info['version_details']['slug'];
		$response->version       = $version_info['version'];
		$response->download_link = str_replace( "{KEY}", $key, $version_info['package'] );
		$response->author        = $version_info['version_details']['author'];
		$response->requires      = $version_info['version_details']['requires'];
		$response->tested        = $version_info['version_details']['tested'];
		$response->last_updated  = $version_info['version_details']['last_updated'];
		$response->homepage      = $version_info['version_details']['homepage'];
		$response->sections      = $version_info['version_details']['sections'];

		return $response;

	}


	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param string    $product
	 * @param string    $key
	 * @param string    $version
	 * @param bool      $early_access
	 * @param bool      $use_cache
	 *
	 * @return array|int|mixed
	 */
	public function get_version_info ( $product, $key, $version, $early_access, $use_cache = true ) {

		$version_info = function_exists( 'get_site_transient' ) ? get_site_transient( $this->_slug . '_version' ) : get_transient( $this->_slug . '_version' );

		if ( ! $version_info || ! $use_cache || ( false == $version_info ) ) {

			$body               = "key=$key";

			$options            = array( 'method' => 'POST', 'timeout' => 3, 'body' => $body );

			$options['headers'] = array(
				'Content-Type'   => 'application/x-www-form-urlencoded; charset=' . get_option( 'blog_charset' ),
				'Content-Length' => strlen( $body ),
				'User-Agent'     => 'WordPress/' . get_bloginfo( 'version' ),
				'Referer'        => get_bloginfo( 'url' )
			);

			$url                = trailingslashit( $this->_api_url ) . $this->get_remote_request_params( $product, $key, $version, $early_access );

			$raw_response       = wp_remote_post( $url, $options );

			if ( is_wp_error( $raw_response ) || ( 200 != wp_remote_retrieve_response_code( $raw_response ) ) ) {

				$version_info = false;

			}
			else {

				$response     = json_decode( wp_remote_retrieve_body( $raw_response ), true );

				$version_info = array(
					'is_valid_key'    => $response['is_valid_key'],
					'version'         => $response['version'],
					'package'         => urldecode( $response['package'] ),
					'version_details' => $response['version_details'],
				);

			}

			$this->set_version_info( $version_info );

		}


		return $version_info;
	}

	/**
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $product
	 * @param $key
	 * @param $version
	 * @param $early_access
	 *
	 * @return string
	 */
	public function get_remote_request_params ( $product, $key, $version, $early_access ) {

		global $wpdb;

		return sprintf( "%s&key=%s&v=%s&wp=%s&php=%s&mysql=%s&earlyaccess=%s", urlencode( $product ), urlencode( $key ), urlencode( $version ), urlencode( get_bloginfo( 'version' ) ), urlencode( phpversion() ), urlencode( $wpdb->db_version() ), urlencode( $early_access ) );

	}

	/**
	 * ManageWP integration
	 *
	 * @since  1.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $premium_update
	 *
	 * @return array
	 */
	public function mwp_premium_update( $premium_update ) {

		if ( ! function_exists( 'get_plugin_data' ) ) {

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		}

		$update = $this->get_version_info( $this->_slug, $this->_api_data['license'], $this->_version, $this->_api_data['early_access'] );

		if ( rgar( $update, 'is_valid_key' ) && version_compare( $this->_version, $update['version'], '<' ) ) {

			$plugin_data                = get_plugin_data( $this->_full_path );

			$plugin_data['type']        = 'plugin';

			$plugin_data['slug']        = $this->_path;

			$plugin_data['new_version'] = isset( $update['version'] ) ? $update['version'] : false;

			$plugin_data['url']         = isset( $update['url'] ) ? $update['url'] : false;

			$premium_update[]           = $plugin_data;

		}


		return $premium_update;
	}

}