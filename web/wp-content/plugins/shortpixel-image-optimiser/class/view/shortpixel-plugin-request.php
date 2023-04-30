<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

/**
 * User: simon
 * Date: 11.04.2018
 */
// @todo This is used by feedback. Should be replaced a some point.
class ShortPixelPluginRequest {

    /**
     * Url for the request
     *
     * @var string
     */
    private $url;
    /**
     * Api endpoint
     *
     * @var string
     */
    private $data = array(
        'server' => array(),
        'user' => array(),
        'wordpress' => array(
            'deactivated_plugin' => array(),
        ),
    );
    /**
     * Plugin file
     *
     * @var string
     */
    private $plugin_file = '';

    private $allow_tracking = 0;

    public $request_successful = false;

    function __construct( $_plugin_file, $url, $args ) {

        $this->url = $url;
        // Set variables
        $this->allow_tracking = ($args['anonymous'] === false)? true : false;
        $this->plugin_file = $_plugin_file;
        $this->data['unique'] = md5( home_url() . get_bloginfo( 'admin_email' ) );
				if ($args['anonymous'] == false)
        	$this->data['key'] = $args['key'];
        $this->data['wordpress']['deactivated_plugin']['uninstall_reason'] = $args['reason'];
        $this->data['wordpress']['deactivated_plugin']['uninstall_details'] = $args['details'];

        // Start collecting data
        $this->_collect_data();
        $this->request_successful = $this->_send_request();
    }

    /**
     * Collect all data for the request.
     *
     */
    private function _collect_data() {

        $current_plugin = get_plugin_data( $this->plugin_file );

        // Plugin data
        $this->data['wordpress']['deactivated_plugin']['slug'] = $current_plugin['TextDomain'];
        $this->data['wordpress']['deactivated_plugin']['name'] = $current_plugin['Name'];
        $this->data['wordpress']['deactivated_plugin']['version'] = $current_plugin['Version'];
        $this->data['wordpress']['deactivated_plugin']['author'] = $current_plugin['AuthorName'];

        if ( $this->allow_tracking ) {
            //$this->_collect_wordpress_data();
            //$this->_collect_server_data();
            $this->_collect_user_data();
        }

    }

    /**
     * Collect WordPress data.
     *
     */
    private function _collect_wordpress_data() {
        $this->data['wordpress']['locale'] = ( get_bloginfo( 'version' ) >= 4.7 ) ? get_user_locale() : get_locale();
        $this->data['wordpress']['wp_version'] = get_bloginfo( 'version' );
        $this->data['wordpress']['multisite'] = is_multisite();

        $this->data['wordpress']['themes'] = $this->get_themes();
        $this->data['wordpress']['plugins'] = $this->get_plugins();
    }

    /**
     * Collect server data.
     *
     */
    private function _collect_server_data() {
        $this->data['server']['server'] = isset( $_SERVER['SERVER_SOFTWARE'] ) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_SOFTWARE'])) : '';
        $this->data['server']['php_version'] = phpversion();
        $this->data['server']['url'] = esc_url(home_url());
    }

    /**
     * Collect user data.
     *
     */
    private function _collect_user_data() {
        $admin = get_user_by( 'email', get_bloginfo( 'admin_email' ) );
        if ( ! $admin ) {
            $this->data['user']['email'] = '';
            $this->data['user']['first_name'] = '';
            $this->data['user']['last_name'] = '';
        }else{
            $this->data['user']['email'] = get_bloginfo( 'admin_email' );
            $this->data['user']['first_name'] = $admin->first_name;
            $this->data['user']['last_name'] = $admin->last_name;
        }
    }

    /**
     * Get current themes
     *
     * @return array
     */
    private function get_themes() {
        $theme = wp_get_theme();

        return array(
            'installed' => $this->_get_installed_themes(),
            'active'    => array(
                'slug'    => get_stylesheet(),
                'name'    => $theme->get( 'Name' ),
                'version' => $theme->get( 'Version' ),
                'author'  => $theme->get( 'Author' ),
            ),
        );
    }

    /**
     * Get an array of installed themes
     */
    private function _get_installed_themes() {
        $installed = wp_get_themes();
        $theme     = get_stylesheet();
        $arr       = array();

        foreach ( $installed as $slug => $info ) {
            if ( $slug === $theme ) {
                continue;
            }
            $arr[ $slug ] = array(
                'slug'    => $slug,
                'name'    => $info->get( 'Name' ),
                'version' => $info->get( 'Version' ),
                'author'  => $info->get( 'Author' )
            );
        };

        return $arr;
    }

    /**
     * Get a list of installed plugins
     */
    private function get_plugins() {
        if ( ! function_exists( 'get_plugins' ) ) {
            include ABSPATH . '/wp-admin/includes/plugin.php';
        }

        $plugins   = get_plugins();
        $option    = get_option( 'active_plugins', array() );
        $active    = array();
        $installed = array();
        foreach ( $plugins as $id => $info ) {
            if ( in_array( $id, $active ) ) {
                continue;
            }

            $id = explode( '/', $id );
            $id = ucwords( str_replace( '-', ' ', $id[0] ) );

            $installed[] = $id;
        }

        foreach ( $option as $id ) {
            $id = explode( '/', $id );
            $id = ucwords( str_replace( '-', ' ', $id[0] ) );

            $active[] = $id;
        }

        return array(
            'installed' => $installed,
            'active'    => $active,
        );
    }

    /**
     * Send dat to server.
     *
     */
    private function _send_request() {

        $request = wp_remote_post( $this->url, array(
            'method'      => 'POST',
            'timeout'     => 20,
            'redirection' => 5,
            'httpversion' => '1.1',
            'blocking'    => true,
            'body'        => $this->data,
            'user-agent'  => 'MT/EPSILON-CUSTOMER-TRACKING/' . esc_url( home_url() )
        ) );


        if ( is_wp_error( $request ) ) {
            return false;
        }

        return true;

    }
}
