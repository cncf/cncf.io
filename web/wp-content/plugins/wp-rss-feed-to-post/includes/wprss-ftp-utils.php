<?php

/**
 * General, utility and helper functions, to make code more shorter and more readable.
 *
 * @since 1.0
 */

use Psr\Log\LoggerInterface;

if ( !class_exists( 'WPRSS_FTP_Settings' ) ) {
    require_once ( WPRSS_FTP_INC . 'wprss-ftp-settings.php' );
}


final class WPRSS_FTP_Utils {

    const WPRSS_LOG_LEVEL_PREFIX = 'WPRSS_LOG_LEVEL_';

    const LOG_LEVEL_SYSTEM = 'system';
    const LOG_LEVEL_INFO = 'info';
    const LOG_LEVEL_NOTICE = 'notice';
    const LOG_LEVEL_WARNING = 'warning';
    const LOG_LEVEL_ERROR = 'error';

    /**
     * Retrieves the logger to use.
     *
     * @since 3.7.7
     *
     * @param int|null $feed_id Optional feed ID to retrieve the logger for that feed source.
     *
     * @return LoggerInterface
     */
    public static function get_logger( $feed_id = null ) {
        return ( version_compare( WPRSS_VERSION, '4.13', '>=' ) )
            ? wpra_get_logger( $feed_id )
            : new WPRSS_FTP_Logger();
    }

    /**
     * Used internally to log error messages to a log file.
     *
     * @deprecated 3.7.7
     *
     * @since 1.0
     */
    public static function log( $message, $src = 'Feed to Post', $log_level = null ) {
        // check if the logging function exists in the core
        if ( function_exists( 'wprss_log' ) ) {
            // If log level is declared in core, or the log level is default
            if( is_null($log_level) || $log_level = self::get_log_level_value($log_level) ) {
                if( is_null($log_level) ) $log_level = self::get_log_level_value(self::LOG_LEVEL_ERROR);
                wprss_log( $message, $src, $log_level );
            }
        } else {
            $date =  date( 'd-m-Y H:i:s' );
            $source = 'Feed to Post' . ( ( strlen( $src ) > 0 )? " ($src)" : '' ) ;
            $str = "[$date] $source: '$message'\n";
            file_put_contents( WPRSS_FTP_LOG_FILE , $str, FILE_APPEND );
        }
    }

    /**
     * @deprecated 3.7.7
     *
     * @param $log_level
     *
     * @return mixed|null
     */
    public static function get_log_level_value( $log_level ) {
        if (strtolower($log_level) === 'debug') {
            $log_level = self::LOG_LEVEL_SYSTEM;
        }

        $const_name = self::WPRSS_LOG_LEVEL_PREFIX . strtoupper( $log_level );
        return defined( $const_name ) ? constant( $const_name ) : null;
    }


    /**
     * Calls the log function with a print_r of the given object
     *
     * @since 1.0
     *
     * @deprecated 3.7.7
     */
    public static function log_object( $message, $obj, $src = 'Feed to Post', $log_level = null ) {
        WPRSS_FTP_Utils::log( "$message " . print_r( $obj, TRUE ), $src, $log_level );
    }


    /**
     * Clears the log file
     *
     * @since 1.9
     *
     * @deprecated 3.7.7
     */
    public static function clear_log() {
        file_put_contents(  WPRSS_FTP_LOG_FILE , '' );
    }


    /**
     * Returns the contents of the log file.
     * If the log file does not exists, creates it.
     *
     * @since 1.9
     *
     * @deprecated 3.7.7
     */
    public static function get_log() {
        if ( !file_exists( WPRSS_FTP_LOG_FILE ) ) {
            WPRSS_FTP_Utils::clear_log();
        }
        return file_get_contents(  WPRSS_FTP_LOG_FILE , '' );
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @since 3.7.7
     *
     * @param string   $message The string to interpolate.
     * @param string[] $context An associative array map of values to replace in the message.
     *
     * @return string The interpolated message.
     */
    public static function interpolate($message, array $context)
    {
        $replace = [];

        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = (is_object($val) || is_array($val))
                ? json_encode((array) $val)
                : strval($val);
        }

        return strtr($message, $replace);
    }

    /**
     * Updates the posts content, taking care to remove KSES filters where needed.
     *
     * @since 2.5
     */
    public static function update_post_content( $post_id, $content, $title = NULL ) {
        // Get the post's soruce
        $source = WPRSS_FTP_Meta::get_instance()->get_meta( $post_id, 'feed_source' );
        // Check if embedded content is allowed
        $allow_embedded_content = WPRSS_FTP_Meta::get_instance()->get_meta( $source, 'allow_embedded_content' );

        // If embedded content is allowed, remove KSES filtering
        if ( WPRSS_FTP_Utils::multiboolean( $allow_embedded_content ) === TRUE ) {
            kses_remove_filters();
        }

        // Prepare the args
        $args = array(
            'ID'			=>	$post_id,
            'post_content'	=>	$content
        );
        // If the title is given, add it to the args
        if ( $title !== NULL ) {
            $args['post_title'] = $title;
        }
        // Update the post
        wp_update_post( $args );

        // If embedded content is allowed, re-add KSES filtering
        if ( WPRSS_FTP_Utils::multiboolean( $allow_embedded_content ) === TRUE ) {
            kses_init_filters();
        }
    }


    /**
     * Checks if a remote file exists, by pinging it and checking the status code.
     *
     * @param $url The url of the remote resource
     * @since 1.3
     */
    public static function remote_file_exists( $url ) {
        $exists = FALSE;

        $curl = curl_init($url);
        // ping the page
        curl_setopt( $curl, CURLOPT_NOBODY, true );
        $response = curl_exec($curl);
        // if the response is not FALSE
        if ( $response !== FALSE ) {
            // check the response status code
            $statusCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
            // If recieved a status code of OK ( 200 )
            if ( $statusCode == 200 ) {
                $exists = TRUE;
            }
        }
        // Close the curl instance
        curl_close( $curl );

        return $exists;
    }


    /**
     * Encodes the given URL, parses it and returns its components.
     *
     * @since 1.0
     */
    public static function encode_and_parse_url( $url ) {
        $encodedUrl = @preg_replace_callback( '%[^:/?#&=\.]+%usD', function ($matches) {
            return sprintf('urlencode(\'%s\')', $matches[0]);
        }, $url );
        $components = parse_url( $encodedUrl );
        foreach ( $components as &$component ) {
            $component = urldecode($component);
        }
        return $components;
    }


    /**
     * Explodes the given array using the given delimiter, and trims each element.
     *
     * @since 3.1
     * @param string $delimiter The splitting delimiter
     * @param array $array The array to split and trim
     * @return array
     */
    public static function trim_explode( $delimiter, $array ) {
        return array_map( 'trim', explode($delimiter, $array) );
    }


    /**
     * Checks if multisite is enabled.
     *
     * @since 1.7
     */
    public static function is_multisite() {
        if ( function_exists( 'wp_get_sites' ) && function_exists( 'is_multisite' ) )
            return is_multisite();
        else
            return FALSE;
    }


    /**
     * Returns TRUE if using WP multisite and the current user is the super admin, FALSE if not,
     * and a message for output if wp_is_large_network() returns TRUE.
     *
     * @since 1.7
     */
    public static function is_multisite_and_main_site() {
        if ( self::is_multisite() === FALSE )
            return FALSE;
        else
            return ( count( wp_get_sites() ) === 0 )?
                __( 'We could not retrieve the list of sites, because the network has no sites or is too large!', WPRSS_TEXT_DOMAIN )
            :	( is_multisite() && is_main_site() );
    }


    /**
     * Returns a list of site names. Used for dropdowns in metaboxes
     *
     * @since 1.7
     */
    public static function get_sites() {
        $site_objects = wp_get_sites();
        $sites = array();
        foreach ( $site_objects as $i => $obj ) {
            $text = $obj['path'];
            if ( $text == '/' ) $text = $obj['domain'];
            $sites[ $obj['blog_id'] ] = $text;
        }
        return $sites;
    }


    /**
     * Returns an array of radio elements for the given associative array.
     * Array _must_ be associative.
     *
     * @since 1.0
     */
    public static function array_to_radio_buttons( $array, $pArgs = array() ) {
        // Merge the passed parameter arguments with the defaults
        $defaults = array(
            'id'					=>	'',
            'class' 				=> 	NULL,
            'name'					=>	NULL,
            'checked'				=>	NULL
        );
        $args = wp_parse_args( $pArgs, $defaults );

        // Prepare the variables
        $class = ( $args['class'] === NULL )? '' : ' class="'.$args['class'].'"';
        $name = ( $args['name'] === NULL )? '' : ' name="'.$args['name'].'"';

        $radios = array();
        $i = 0;
        foreach( $array as $key => $value ) {
            $id = $args['id'] . '-' . $i++;
            $checked = ( $args['checked'] !== NULL && $args['checked'] === $key )? 'checked="checked"': '';
            $radios[] = "<input type='radio' value='$key' id='$id' $name $class $checked /><label for='$id'>$value</label> ";
        }

        return $radios;
    }


    /**
     * Returns a select element for the given associative array.
     * Array _must_ be associative.
     *
     * @since 1.0
     */
    public static function array_to_select( $array, $pArgs = array() ) {
        // Merge the passed parameter arguments with the defaults
        $defaults = array(
            'id'					=>	NULL,
            'class' 				=> 	NULL,
            'name'					=>	NULL,
            'selected'				=>	NULL,
            'options_only'			=>	FALSE,
            'add_default_option'	=>	FALSE,
            'multiple'				=>	FALSE,
            'disabled'				=>	FALSE,
            'selectable'			=>	array()
        );
        $args = wp_parse_args( $pArgs, $defaults );

        // Prepare the variables
        $id = ( $args['id'] === NULL )? '' : ' id="'.$args['id'].'"';
        $class = ( $args['class'] === NULL )? '' : ' class="'.$args['class'].'"';
        $name = ( $args['name'] === NULL )? '' : ' name="'.$args['name'].'"';
        $disabled = ( $args['disabled'] === FALSE )? '' : 'disabled="disabled"';
        // Check multiple tag
        $multiple = '';
        if ( $args['multiple'] === TRUE ) {
            $multiple = ' multiple="multiple"';
            // If using a multiple tag, set the name to an array to accept multiple values
            if ( $args['name'] !== NULL ) {
                $name = ' name="'.$args['name'].'[]"';
            }
        }
        // WP MP6 responsiveness fix - set height to auto
        $fix = ( $args['multiple'] === TRUE )? 'style="height:auto;"' : '';

        $select = '';
        // Generate the select elements
        if ( $args['options_only'] !== TRUE )
            $select = "<select $id $class $name $fix $multiple $disabled>";
        if ( $args['add_default_option'] === TRUE ){
            $array = array_merge( array( '' => 'Use Default' ), $array );
        }

        if ( !is_array( $array ) ) $array = array();

        foreach ( $array as $key => $value ) {
            if ( is_array($value) ) {
                $select .= "<optgroup label='$key'>";
                $recursionArgs = $pArgs;
                $recursionArgs['options_only'] = TRUE;
                $select .= self::array_to_select( $value, $recursionArgs );
                $select .= "</optgroup>";
                continue;
            }
            $selected = FALSE;
            if ( is_array( $args['selected'] ) ) {
                $selected = in_array( $key, $args['selected'] );
            }
            else $selected = ( $args['selected'] !== NULL && $args['selected'] == $key );
            $selectable = !isset( $args['selectable'][ $key ] ) || $args['selectable'][ $key ] === TRUE;
            $disabled = $selectable? '' : 'disabled="disabled"';
            $selected = ( $selected == TRUE && $selectable )? 'selected="selected"': '';

            $select .= "<option value='$key' $selected $disabled>$value</option>";
        }
        if ( $args['options_only'] !== TRUE )
            $select .= "</select>";

        // Return the generated select element.
        return $select;
    }


    /**
     * Returns an <input> checkbox element for the given boolean.
     * The booleam determines whether the checkbox will be checked or not.
     * The boolean can also be a string.
     *
     * @since 1.0
     */
    public static function boolean_to_checkbox( $pBool, $pArgs ) {
        // Merge the passed parameter arguments with the defaults
        $defaults = array(
            'id'					=>	NULL,
            'class' 				=> 	NULL,
            'name'					=>	NULL,
            'value'					=>	NULL,
            'disabled'				=>	FALSE,
        );
        $args = wp_parse_args( $pArgs, $defaults );
        // Check if the parameter boolean is a string
        $bool = ( is_string( $pBool ) )? WPRSS_FTP_Utils::multiboolean( $pBool ) : $pBool;
        // Prepare the variables
        $id = ( $args['id'] === NULL )? '' : 'id="'.$args['id'].'"';
        $class = ( $args['class'] === NULL )? '' : 'class="'.$args['class'].'"';
        $name = ( $args['name'] === NULL )? '' : 'name="'.$args['name'].'"';
        $value = ( $args['value'] === NULL )? '' : 'value="'.$args['value'].'"';
        $checked = ( $bool === FALSE )? '' : 'checked="checked"';
        $disabled = ( $args['disabled'] === FALSE )? '' : 'disabled="disabled"';

        return "<input type='hidden' $name value='false' /><input type='checkbox' $id $name $value $class $checked $disabled>";
    }


    /**
     * Returns 'on' or 'off' depending on the given boolean.
     *
     * @since 3.1
     * @uses WPRSS_FTP_Utils::multiboolean
     * @param bool $bool The boolean to check
     * @param bool $ucfirst If TRUE, the first letter of the returned string is capitalized.
     * @return string 'on' if $bool is TRUE, 'off' otherwise
     */
    public static function bool_on_off( $bool, $ucfirst = TRUE ) {
        return ucfirst( self::multiboolean( $bool ) ? 'on' : 'off' );
    }


    /**
     * Returns whether or not the given boolean string is a known
     * 'true' value.
     *
     * @since 1.0
     */
    public static function multiboolean( $pBool ) {
        $pBool = ( is_string( $pBool ) === TRUE )? strtolower( $pBool ) : $pBool;
        return in_array(
            $pBool,
            array (
                'true',
                'open',
                'yes',
                'on',
                'y',
                't'
            )
        );
    }


    /**
     * Performs a mass replace on the given string
     *
     * @since 1.0
     */
    public static function str_mass_replace( $string, $replacements) {
        $new_str = $string;
        foreach ($replacements as $old => $new) {
            $new_str = str_replace( $old, $new, $new_str );
        }
        return $new_str;
    }


    /**
     * Uses mass replace to template the given string
     *
     * @since 1.0
     */
    public static function template( $template, $replacements ) {
        $new_replacements = array();
        foreach ( $replacements as $key => $value ) {
            $new_replacements['{{'.$key.'}}'] = $value;
        }
        return self::str_mass_replace( $template, $new_replacements );
    }


    /**
     * Gets taxonomies for a given post type.
     *
     * @since 3.1
     * @param string $post_type The post type
     * @return array An array of taxonomy ids => names
     */
    public static function get_post_type_taxonomies( $post_type ) {
        $taxonomies = get_object_taxonomies( $post_type, 'object' );
        $keys = array_keys( $taxonomies );
        $vals = array_map( array( 'WPRSS_FTP_Utils', 'get_tax_name' ), $taxonomies );
        if ( count($keys) == 0 || count($vals) == 0 ) return array();
        return array_combine( $keys, $vals );
    }


    /**
     * Gets terms for a given taxonomy.
     *
     * @since 3.1
     * @param string $taxonomy The taxnomy
     * @return array An array of term ids => names
     */
    public static function get_taxonomy_terms( $taxonomy ) {
        return WPRSS_FTP_Settings::get_instance()->get_term_names(
            $taxonomy,
            array(
                'hide_empty'	=>	false,
                'order_by'		=>	'name'
            )
        );
    }


    /**
     * Returns a dropdown with the object taxonomies on the 'post_type' parameter in
     * the POST request, to the client. The <select> element returned differs according
     * to the 'source' in the POST request.
     *
     * @since 1.0
     */
    public static function generate_taxonomy_dropdown() {
        $TAX_IGNORE = array(
            'post_format'
        );
        $settings = WPRSS_FTP_Settings::get_instance();
        $source = isset( $_POST['source'] )? $_POST['source'] : '';
        $post_id = isset( $_POST['post_id'] )? $_POST['post_id'] : NULL;

        $selected = WPRSS_FTP_Meta::get_instance()->get_meta( $post_id, 'post_taxonomy' );
        if ( $selected === '' || $post_id === NULL ) $selected = $settings->get( 'post_taxonomy' );

        $post_type = isset( $_POST['post_type'] )? $_POST['post_type'] : $settings->get('post_type');
        $taxonomy = $settings->get( 'post_taxonomy' );
        $taxonomies = get_object_taxonomies( $post_type, 'object' );
        $keys = array_keys( $taxonomies );
        $vals = array_map( array( 'WPRSS_FTP_Utils', 'get_tax_name' ), $taxonomies );

        $id = ( $source === 'meta' )? WPRSS_FTP_Meta::META_PREFIX . 'post_taxonomy' : 'ftp-post-taxonomy';
        $name = ( $source === 'meta' )? WPRSS_FTP_Meta::META_PREFIX . 'post_taxonomy' : WPRSS_FTP_Settings::OPTIONS_NAME . '[post_taxonomy]';

        if ( $taxonomies === NULL || count( $taxonomies ) === 0 ) {
            echo '<p id="'. $id .'">';
            echo __( 'No taxonomies for the selected post type were found!', WPRSS_TEXT_DOMAIN );
            echo '</p>';
            echo '<input type="hidden" name="' . WPRSS_FTP_Settings::OPTIONS_NAME . '[post_taxonomy]" value="" />';
            die();
        }

        $taxonomies = array_combine( $keys, $vals );
        foreach ( $TAX_IGNORE as $ignore ) {
            if ( isset( $taxonomies[$ignore] ) ) {
                unset( $taxonomies[$ignore] );
            }
        }

        # Generate the taxonomy dropdown
        $args = array(
            'id'		=>	$id,
            'name'		=>	$name,
            'selected'	=>	$selected
        );
        # Print the taxonomy dropdown
        echo self::array_to_select( $taxonomies, $args );

        # Re-print the description
        $tax_meta_fields = WPRSS_FTP_Meta::get_instance()->get_meta_fields('tax');
        echo '<br><span class="description">'. $tax_meta_fields['post_taxonomy']['desc'] .'</span>';

        # End AJAX
        die();
    }


    public static function generate_tax_terms_dropdown() {
        $settings = WPRSS_FTP_Settings::get_instance();
        $taxonomy = isset( $_POST['taxonomy'] )? $_POST['taxonomy'] : $settings->get('post_taxonomy');
        $post_id = isset( $_POST['post_id'] )? $_POST['post_id'] : NULL;
        $source = isset( $_POST['source'] )? $_POST['source'] : '';

        $id = ( $source === 'meta' )? WPRSS_FTP_Meta::META_PREFIX . 'post_terms' : 'ftp-post-terms';
        $name = ( $source === 'meta' )? $id : WPRSS_FTP_Settings::OPTIONS_NAME . '[post_terms]';

        if ( $taxonomy === NULL || $taxonomy === '' ) {
            echo '<p id="'.$id.'">' . __('No terms were found for this taxonomy.', WPRSS_TEXT_DOMAIN) . '</p>';
            echo '<input type="hidden" name="' . WPRSS_FTP_Settings::OPTIONS_NAME . '[post_terms]" value="" />';
            die();
        }

        # Get the terms for the given taxonomy
        $terms = $settings->get_term_names(
            $taxonomy,
            array(
                'hide_empty'	=>	false,
                'order_by'		=>	'name'
            )
        );

        if ( $terms === NULL || count( $terms ) === 0 ) {
            echo '<p id="'.$id.'">' . __('No terms were found for this taxonomy.', WPRSS_TEXT_DOMAIN) . '</p>';
            echo '<input type="hidden" name="' . WPRSS_FTP_Settings::OPTIONS_NAME . '[post_terms]" value="" />';
            die();
        }
        else {
            # Print the terms dropdown
            $args = array(
                'id'		=>	$id,
                'name'		=>	$name,
                'selected'	=>	$settings->get('post_terms'),
                'multiple'	=>	TRUE
            );
            if ( $source === 'meta' ) {
                if ( $post_id !== NULL )
                    $args['selected'] = WPRSS_FTP_Meta::get_instance()->get_meta( $post_id, 'post_terms' );
                if ( $args['selected'] === '' )
                    $args['selected'] = $settings->get('post_terms');
            }
            echo self::array_to_select( $terms, $args );

            # Re-print the description
            $tax_meta_fields = WPRSS_FTP_Meta::get_instance()->get_meta_fields('tax');
            echo '<br><span class="description">'. $tax_meta_fields['post_terms']['desc'] .'</span>';
        }

        die();
    }


    public static function collapse_metabox_for_user( $user_ID, $page, $box_ID ) {
        // Get the current option
        $optionName = "closedpostboxes_$page";
        $closed = get_user_option( $optionName, $user_ID );
        // Turn string into an array and add the new metabox ID
        //$closeIds = explode( ',', $close );
        //$closeIds[] = $box_ID;
        $closed[] = $box_ID;
        // Remove duplicate IDs
        //$closeIds = array_unique( $closeIds );
        $closedUnique = array_unique( $closed );
        // Turn back to a string
        //$close = implode( ',', $closeIds );
        // Update the option
        update_user_option( $user_ID, $optionName, $closedUnique, TRUE );
    }


    public static function close_ftp_metabox_for_user_by_default( $user_ID, $box_ID ) {
        $page = 'wprss_feed';
        $optionName = "closedpostboxes_$page";
        $closed = get_user_option( $optionName, $user_ID );
        // Close the meta box
        self::collapse_metabox_for_user( $user_ID, $page, $box_ID );
    }


    public static function get_wpml_languages() {
        if ( !defined( 'ICL_SITEPRESS_VERSION' ) ) return array();
        $languages_before = icl_get_languages();
        $languages_after = array();
        foreach ( $languages_before as $key => $value ) {
            $languages_after[$key] = $value['native_name'];
        }
        return $languages_after;
    }


    public static function get_tax_name( $item ) {
        return $item->label;
    }


    /*===== UPDATE FUNCTIONS =======================================*/


    /**
     * Detects the namespaces used the in feed.
     *
     * @since 2.8
     */
    public static function get_namespaces_from_feed() {
        // Get the feed source from POST data
        $feed_source = ( isset($_POST['feed_source']) )? $_POST['feed_source'] : NULL;
        // If no feed source is given, or an empty feed source is given, print an error message
        if ( $feed_source === '' || $feed_source === NULL ) {
            die( __('Invalid feed source given.', WPRSS_TEXT_DOMAIN) );
        }

        // Read the feed source
        $feed = @file_get_contents( $feed_source );
        // Show an error
        if ( $feed === FALSE ) {
            die( __( 'Failed to read feed source XML. Check that your URL is a valid feed source URL', WPRSS_TEXT_DOMAIN ) );
        }

        try {
            // Parse the XML
            $xml = new SimpleXmlElement($feed);
            // Get the namespaces
            $namespaces = $xml->getNameSpaces(true);
            // Unset the standard RSS and XML namespaces
            unset( $namespaces[''] );
            unset( $namespaces['xml'] );
            // Print the remaining namespaces as an encoded JSON string
            die( json_encode( $namespaces ) );
        }
        catch( Exception $e ) {
            die( __( 'Failed to parse the RSS feed XML. The feed may contain errors or is not a valid feed source.', WPRSS_TEXT_DOMAIN ) );
        }
    }

    /**
     * Builds a URL from a given URL, using only the specified parts of it.
     *
     * @see parse_url()
     * @param string|array $url The URL which is to be rebuilt, or a result of parse_url().
     * @param bool|array|string $parts An array, or comma-separated list of
     *			which to use for building the new URL. Boolean false for all.
     * @return null|string The rebuilt URL on success, or null of given URL is malformed.
     */
    public static function rebuild_url( $url, $parts = false ) {

        // Allow parsed array
        if ( is_string( $url ) )
            $url = parse_url( $url );

        // Super-malformed or empty URL
        if ( !$url )
            return null;

        // Allow comma-separated values
        if ( is_string($parts ) )
            $parts = explode( ',', $parts );

        // Include all parts
        if ( $parts === false )
            return http_build_url( $url );

        // Nothing to do here
        if( empty( $parts ) )
            return '';

        $newParts = array();
        foreach ( $parts as $_idx => $_part ) {
            $_part = trim( $_part );
            if ( isset( $url[ $_part ] ) )
                $newParts[ $_part ] = $url[ $_part ];
        }

        // Rebuilding the URL from parts
        return http_build_url($newParts);
    }
        
        
    /**
     * Returns an admin user, or the value of their specified field.
     *
     * Admin users are considered to be users with the "Administrator" role.
     * There may be many such users in the system. By default, this function
     * will return the first one in the result set.
     *
     * @since 3.3.2
     * @param string|null $field_name The name of the field of the admin user to return.
     * @param int $idx The zero-based intex of the admin user to return
     * @return WP_User|string The user object, or the requested field
     */
    public static function get_admin( $field_name = null, $idx = 0 ) {
        $admins = array_values( self::get_admins() );
        if ( !isset( $admins[ $idx ] ) ) return null;

        $admin = $admins[ $idx ];
        if ( is_null( $field_name ) ) return $admin;

        return isset( $admin->{$field_name} ) ? $admin->{$field_name} : null;
    }


    /**
     * Admin users are considered to be those with the "Administrator" role.
     *
     * @since 3.3.2
     * @return array An array of WP_User objects, all of which are admin users.
     */
    public static function get_admins() {
        $qry = new WP_User_Query( array( 'role' => 'Administrator' ) );

        return empty( $qry->results ) ? array() : $qry->results;
    }
}

// See https://github.com/jakeasmith/http_build_url/blob/master/src/http_build_url.php
if (!function_exists('http_build_url')) {
    /**
     * URL constants as defined in the PHP Manual under "Constants usable with
     * http_build_url()".
     *
     * @see http://us2.php.net/manual/en/http.constants.php#http.constants.url
     */
    if (!defined('HTTP_URL_REPLACE')) {
        define('HTTP_URL_REPLACE', 1);
    }
    if (!defined('HTTP_URL_JOIN_PATH')) {
        define('HTTP_URL_JOIN_PATH', 2);
    }
    if (!defined('HTTP_URL_JOIN_QUERY')) {
        define('HTTP_URL_JOIN_QUERY', 4);
    }
    if (!defined('HTTP_URL_STRIP_USER')) {
        define('HTTP_URL_STRIP_USER', 8);
    }
    if (!defined('HTTP_URL_STRIP_PASS')) {
        define('HTTP_URL_STRIP_PASS', 16);
    }
    if (!defined('HTTP_URL_STRIP_AUTH')) {
        define('HTTP_URL_STRIP_AUTH', 32);
    }
    if (!defined('HTTP_URL_STRIP_PORT')) {
        define('HTTP_URL_STRIP_PORT', 64);
    }
    if (!defined('HTTP_URL_STRIP_PATH')) {
        define('HTTP_URL_STRIP_PATH', 128);
    }
    if (!defined('HTTP_URL_STRIP_QUERY')) {
        define('HTTP_URL_STRIP_QUERY', 256);
    }
    if (!defined('HTTP_URL_STRIP_FRAGMENT')) {
        define('HTTP_URL_STRIP_FRAGMENT', 512);
    }
    if (!defined('HTTP_URL_STRIP_ALL')) {
        define('HTTP_URL_STRIP_ALL', 1024);
    }


    /**
     * Build a URL.
     *
     * The parts of the second URL will be merged into the first according to
     * the flags argument.
     *
     * @param mixed $url     (part(s) of) an URL in form of a string or
     *                       associative array like parse_url() returns
     * @param mixed $parts   same as the first argument
     * @param int   $flags   a bitmask of binary or'ed HTTP_URL constants;
     *                       HTTP_URL_REPLACE is the default
     * @param array $new_url if set, it will be filled with the parts of the
     *                       composed url like parse_url() would return
     * @return string
     */
    function http_build_url($url, $parts = array(), $flags = HTTP_URL_REPLACE, &$new_url = array())	{
        is_array($url) || $url = parse_url($url);
        is_array($parts) || $parts = parse_url($parts);

        isset($url['query']) && is_string($url['query']) || $url['query'] = null;
        isset($parts['query']) && is_string($parts['query']) || $parts['query'] = null;

        $keys = array('user', 'pass', 'port', 'path', 'query', 'fragment');

        // HTTP_URL_STRIP_ALL and HTTP_URL_STRIP_AUTH cover several other flags.
        if ($flags & HTTP_URL_STRIP_ALL) {
            $flags |= HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS
                | HTTP_URL_STRIP_PORT | HTTP_URL_STRIP_PATH
                | HTTP_URL_STRIP_QUERY | HTTP_URL_STRIP_FRAGMENT;
        } elseif ($flags & HTTP_URL_STRIP_AUTH) {
            $flags |= HTTP_URL_STRIP_USER | HTTP_URL_STRIP_PASS;
        }

        // Schema and host are alwasy replaced
        foreach (array('scheme', 'host') as $part) {
            if (isset($parts[$part])) {
                $url[$part] = $parts[$part];
            }
        }

        if ($flags & HTTP_URL_REPLACE) {
            foreach ($keys as $key) {
                if (isset($parts[$key])) {
                    $url[$key] = $parts[$key];
                }
            }
        } else {
            if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH)) {
                if (isset($url['path']) && substr($parts['path'], 0, 1) !== '/') {
                    $url['path'] = rtrim(
                            str_replace(basename($url['path']), '', $url['path']),
                            '/'
                        ) . '/' . ltrim($parts['path'], '/');
                } else {
                    $url['path'] = $parts['path'];
                }
            }

            if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY)) {
                if (isset($url['query'])) {
                    parse_str($url['query'], $url_query);
                    parse_str($parts['query'], $parts_query);

                    $url['query'] = http_build_query(
                        array_replace_recursive(
                            $url_query,
                            $parts_query
                        )
                    );
                } else {
                    $url['query'] = $parts['query'];
                }
            }
        }

        foreach ($keys as $key) {
            $strip = 'HTTP_URL_STRIP_' . strtoupper($key);
            if ($flags & constant($strip)) {
                unset($url[$key]);
            }
        }

        $parsed_string = '';

        if (isset($url['scheme'])) {
            $parsed_string .= $url['scheme'] . '://';
        }

        if (isset($url['user'])) {
            $parsed_string .= $url['user'];

            if (isset($url['pass'])) {
                $parsed_string .= ':' . $url['pass'];
            }

            $parsed_string .= '@';
        }

        if (isset($url['host'])) {
            $parsed_string .= $url['host'];
        }

        if (isset($url['port'])) {
            $parsed_string .= ':' . $url['port'];
        }

        if (!empty($url['path'])) {
            $parsed_string .= $url['path'];
        } else {
            $parsed_string .= '/';
        }

        if (isset($url['query'])) {
            $parsed_string .= '?' . $url['query'];
        }

        if (isset($url['fragment'])) {
            $parsed_string .= '#' . $url['fragment'];
        }

        $new_url = $url;

        return $parsed_string;
    }
}


/* AJAX hook for taxonomy dropdown */
add_action( 'wp_ajax_ftp_get_object_taxonomies', array( 'WPRSS_FTP_Utils', 'generate_taxonomy_dropdown' ) );
add_action( 'wp_ajax_ftp_get_taxonomy_terms', array( 'WPRSS_FTP_Utils', 'generate_tax_terms_dropdown' ) );

/* AJAX hook for namespace auto detector */
add_action( 'wp_ajax_ftp_detect_namespaces', array( 'WPRSS_FTP_Utils', 'get_namespaces_from_feed' ) );


/**
 * An implementation of the Command pattern.
 *
 * Instances of this class encapsulate all data necessary to make a call.
 * 
 * @since 3.3.2
 */
class WPRSS_Command {

    protected $_callable;
    protected $_args = array();


    /**
     *
     * @since 3.3.2
     * @param callable $data The {@link set_function() function} to give to the command.
     * @param array|mixed The {@link set_args() arguments} to give to the command.
     */
    public function __construct( $data = null ) {
        $args = func_get_args();

        if ( isset( $args[0] ) )
            $this->set_function( $args[0] );

        if( isset( $args[1] ) )
            $this->set_args( $args[1] );


        $this->_construct();
    }


    /**
     * Parameter-less private constructor.
     *
     * @since 3.3.2
     */
    protected function _construct() {

    }


    /**
     * Sets the function to be called with this command.
     *
     * @since 3.3.2
     * @param callable $function The function or method to be called.
     * @return \WPRSS_Command This instance.
     * @throws Exception If passed function is not a valid callable.
     */
    public function set_function( $function ) {
        if ( !is_callable( $function, true ) )
            throw new Exception( 'Could not set function: function is not a valid callable' );

        $this->_callable = $function;
        return $this;
    }


    /**
     * Sets the argument or arguments for this command.
     *
     * If index is null or omitted, all arguments will be set to the value of $args.
     * If in this case $args is not an array, args will be an array where $args is
     * the only element.
     * In any case, the indexes of $args do not matter, but the order does.
     *
     * @since 3.3.2
     * @param array $args The argument or arguments to set for this command.
     * @param int $index The index, at which to set the argument.
     * @return \WPRSS_Command This instance.
     */
    public function set_args( $args, $index = null ) {
        if ( is_null( $index ) ) {
            $this->_args = array_values( (array) $args );
            return $this;
        }

        $index = (int) $index;
        $this->_args[ $index ] = $args;

        return $this;
    }


    /**
     * @since 3.3.2
     * @return callable The function of the command.
     */
    public function get_function() {
        return $this->_callable;
    }


    /**
     * Gets the argument or arguments for this command.
     *
     * @param int|null $index The index of the argument to return.
     * @return array|mixed|null The argument, or arguments, or null if not found.
     */
    public function get_args( $index = null ) {
        if ( is_null( $index ) )
            return $this->_args;

        $index = (int) $index;
        return isset( $this->_args[ $index ] ) ? $this->_args[ $index ] :  null;
    }


    /**
     * Calls the function of this command with the given arguments.
     *
     * @param array $args_override A different set of arguments that will override the original.
     * @return mixed The return value of the function of the command.
     * @throws Exception If the function of the command is not callable.
     */
    public function call( $args_override = array() ) {
        $args = $this->get_args();
        $args = WPRSS_Help::get_instance()->array_merge_recursive_distinct( $args, $args_override );

        if ( !is_callable( $callable = $this->get_function() ) )
                throw new Exception( 'Could not call function: function must be callable.' );

        $result = call_user_func_array( $callable, $args);
        return $result;
    }
}
