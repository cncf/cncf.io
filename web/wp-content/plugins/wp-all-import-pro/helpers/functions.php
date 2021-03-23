<?php
if( !function_exists('wpai_wp_enqueue_code_editor')){
function wpai_wp_enqueue_code_editor( $args ) {

	// We need syntax highlighting to work in the plugin regardless of user setting.
	// Function matches https://developer.wordpress.org/reference/functions/wp_enqueue_code_editor/ otherwise.
	/*if ( is_user_logged_in() && 'false' === wp_get_current_user()->syntax_highlighting ) {
		return false;
	}*/

	$settings = wp_get_code_editor_settings( $args );

	if ( empty( $settings ) || empty( $settings['codemirror'] ) ) {
		return false;
	}

	wp_enqueue_script( 'code-editor' );
	wp_enqueue_style( 'code-editor' );

	if ( isset( $settings['codemirror']['mode'] ) ) {
		$mode = $settings['codemirror']['mode'];
		if ( is_string( $mode ) ) {
			$mode = array(
				'name' => $mode,
			);
		}

		if ( ! empty( $settings['codemirror']['lint'] ) ) {
			switch ( $mode['name'] ) {
				case 'css':
				case 'text/css':
				case 'text/x-scss':
				case 'text/x-less':
					wp_enqueue_script( 'csslint' );
					break;
				case 'htmlmixed':
				case 'text/html':
				case 'php':
				case 'application/x-httpd-php':
				case 'text/x-php':
					wp_enqueue_script( 'htmlhint' );
					wp_enqueue_script( 'csslint' );
					wp_enqueue_script( 'jshint' );
					if ( ! current_user_can( 'unfiltered_html' ) ) {
						wp_enqueue_script( 'htmlhint-kses' );
					}
					break;
				case 'javascript':
				case 'application/ecmascript':
				case 'application/json':
				case 'application/javascript':
				case 'application/ld+json':
				case 'text/typescript':
				case 'application/typescript':
					wp_enqueue_script( 'jshint' );
					wp_enqueue_script( 'jsonlint' );
					break;
			}
		}
	}

	wp_add_inline_script( 'code-editor', sprintf( 'jQuery.extend( wp.codeEditor.defaultSettings, %s );', wp_json_encode( $settings ) ) );

	/**
	 * Fires when scripts and styles are enqueued for the code editor.
	 *
	 * @since 4.9.0
	 *
	 * @param array $settings Settings for the enqueued code editor.
	 */
	do_action( 'wp_enqueue_code_editor', $settings );

	return $settings;
}
}

	if ( ! function_exists('pmxi_if') ) {
		function pmxi_if( $left_condition, $operand = '', $right_condition = '', $then, $else = '' ) {
			$str = trim(implode(' ', array($left_condition, html_entity_decode($operand), $right_condition)));												
			return (eval ("return ($str);")) ? $then : $else;
		}		
	}

	if ( ! function_exists('is_empty') ) {
		function is_empty( $var ) {
		 	return empty($var);
		}
	}	

	if ( ! function_exists('pmxi_human_filesize') ) {
		function pmxi_human_filesize($bytes, $decimals = 2) {
		 	$sz = 'BKMGTP';
            $factor = (int) floor((strlen($bytes) - 1) / 3);
            return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . (isset($sz[$factor]) ? $sz[$factor] : '');
		}
	}	

	if ( ! function_exists('pmxi_get_remote_image_ext') ) {
		function pmxi_get_remote_image_ext( $filePath ) {
			$response = wp_remote_get($filePath);
			$headers = wp_remote_retrieve_headers( $response );			
			$content_type = (!empty($headers['content-type'])) ? explode('/', $headers['content-type']) : false;					
			if (!empty($content_type[1])){				
				if (preg_match('%jpeg%i', $content_type[1])) return 'jpeg';
				if (preg_match('%jpg%i', $content_type[1])) return 'jpg';
				if (preg_match('%png%i', $content_type[1])) return 'png';
				if (preg_match('%gif%i', $content_type[1])) return 'gif';
				if (preg_match('%svg%i', $content_type[1])) return 'svg';
				if (preg_match('%webp%i', $content_type[1])) return 'webp';
                if (preg_match('%pdf%i', $content_type[1])) return 'pdf';
				return ($content_type[1] == "unknown") ? "" : $content_type[1];
			}
			return '';
		}
	}

	if ( ! function_exists('pmxi_getExtension') ) {
		function pmxi_getExtension( $str ){
	        $i = strrpos($str,".");        
	        if (!$i) return "";
	        $l = strlen($str) - $i;        
	        $ext = substr($str,$i+1,$l);	        
	        return (strlen($ext) <= 4) ? $ext : "";
		}
	}

	if ( ! function_exists('pmxi_getExtensionFromStr' ) ) {
		function pmxi_getExtensionFromStr( $str ) {
	    	$filetype = wp_check_filetype($str);
            if (empty($filetype['ext'])){
              $filetype = wp_check_filetype(strtok($str, "?"));
            }
	        return ($filetype['ext'] == "unknown") ? "" : $filetype['ext'];
		}
	}			

	if ( ! function_exists('pmxi_convert_encoding')) {
		function pmxi_convert_encoding ( $source, $target_encoding = 'ASCII' ) {
			if ( function_exists('mb_detect_encoding') ) {
			    // detect the character encoding of the incoming file
			    $encoding = mb_detect_encoding( $source, "auto" );
			    // escape all of the question marks so we can remove artifacts from
			    // the unicode conversion process
			    $target = str_replace( "?", "[question_mark]", $source );
			    // convert the string to the target encoding
			    $target = mb_convert_encoding( $target, $target_encoding, $encoding);
			    // remove any question marks that have been introduced because of illegal characters
			    $target = str_replace( "?", "", $target );
			    // replace the token string "[question_mark]" with the symbol "?"
			    $target = str_replace( "[question_mark]", "?", $target );
			    return html_entity_decode($target, ENT_COMPAT, 'UTF-8');
			}
			return $source;
		}
	}		

	if ( ! function_exists('wp_all_import_get_remote_file_name') ) {
		function wp_all_import_get_remote_file_name( $filePath ) {
		    $bn = wp_all_import_basename($filePath);
			$type = (preg_match('%\W(csv|txt|dat|psv)$%i', $bn)) ? 'csv' : false;
			if (!$type) $type = (preg_match('%\W(xml)$%i', $bn)) ? 'xml' : false;
            if (!$type) $type = (preg_match('%\W(zip)$%i', $bn)) || (preg_match('%\W(get_bundle)$%i', $bn) && strpos($bn, 'export_id') !== false && strpos($bn, 'security_token') !== false) ? 'zip' : false;
			if (!$type) $type = (preg_match('%\W(gz)$%i', $bn)) ? 'gz' : false;

            if(!$type){
                $filePath = strtok($filePath, "?");
                $bn = wp_all_import_basename($filePath);
                $type = (preg_match('%\W(csv|txt|dat|psv)$%i', $bn)) ? 'csv' : false;
                if (!$type) $type = (preg_match('%\W(xml)$%i', $bn)) ? 'xml' : false;
                if (!$type) $type = (preg_match('%\W(zip)$%i', $bn)) ? 'zip' : false;
                if (!$type) $type = (preg_match('%\W(gz)$%i', $bn)) ? 'gz' : false;
            }
			return ($type) ? $type : false;
		}
	}	

	if ( ! function_exists('wp_all_import_translate_uri') ) {
		function wp_all_import_translate_uri($uri) {
		    $parts = explode('/', $uri);
		    for ($i = 1; $i < count($parts); $i++) {
		      $parts[$i] = rawurlencode($parts[$i]);
		    }
		    return implode('/', $parts);
		}
	}	

	if ( ! function_exists('wp_all_import_cdata_filter') ) {
		function wp_all_import_cdata_filter($matches) {
		    PMXI_Import_Record::$cdata[] = $matches[0];
		    return '{{CPLACE_'. count(PMXI_Import_Record::$cdata) .'}}';
		}
	}

    if ( ! function_exists('wp_all_import_amp_filter') ) {
        function wp_all_import_amp_filter($matches) {
            if (empty($matches[1]) && !empty($matches[0])) {
                return "&amp;";
            }
            return in_array($matches[1], array("amp;", "lt;", "gt;")) ? "&" . $matches[1] : "&amp;" . $matches[1];
        }
    }

	if ( ! function_exists('wp_all_import_isValidMd5') ) {
		function wp_all_import_isValidMd5($md5 ='') {
		    return preg_match('/^[a-f0-9]{32}$/', $md5);
		}
	}

	if ( ! function_exists('wp_all_import_get_relative_path') ) {
		function wp_all_import_get_relative_path($path){
			$uploads = wp_upload_dir();
			return str_replace($uploads['basedir'], '', $path);
		}
	}

	if ( ! function_exists('wp_all_import_get_absolute_path') ) {
		function wp_all_import_get_absolute_path($path) {
			$uploads = wp_upload_dir();
			return ( strpos($path, $uploads['basedir']) === false and ! preg_match('%^https?://%i', $path)) ? $uploads['basedir'] . $path : $path;
		}
	}

	if ( ! function_exists('wp_all_import_clear_xss') ) {
		function wp_all_import_clear_xss( $str ) {
			return stripslashes(esc_sql(htmlspecialchars(strip_tags($str))));
		}
	}

	if ( ! function_exists('wp_all_import_get_taxonomies') ) {
        function wp_all_import_get_taxonomies() {
            // get all taxonomies
            $taxonomies = get_taxonomies(FALSE, 'objects');
            $ignore = array('nav_menu', 'link_category');
            $r = array();
            // populate $r
            foreach ($taxonomies as $taxonomy) {
                if (in_array($taxonomy->name, $ignore)) {
                    continue;
                }
                if ( ! empty($taxonomy->labels->name) && strpos($taxonomy->labels->name, "_") === false){
                    $r[$taxonomy->name] = $taxonomy->labels->name;
                }
                else{
                    $r[$taxonomy->name] = empty($taxonomy->labels->singular_name) ? $taxonomy->name : $taxonomy->labels->singular_name;
                }
            }
            asort($r, SORT_FLAG_CASE | SORT_STRING);
            // return
            return $r;
        }
    }

    if ( ! function_exists('wp_all_import_is_password_protected_feed') ) {
        function wp_all_import_is_password_protected_feed($url){
            $url_data = parse_url($url);
            return (!empty($url_data['user']) and !empty($url_data['pass'])) ? true : false;
        }
    }

    if ( ! function_exists('wp_all_import_cmp_custom_types') ) {
        function wp_all_import_cmp_custom_types($a, $b) {
            return strcmp($a->labels->name, $b->labels->name);
        }
    }

    if ( ! function_exists('wp_all_import_basename') ) {
        function wp_all_import_basename($file) {
            $a = explode('/', $file);
            return end($a);
        }
    }

    if ( ! function_exists('wp_all_import_update_post_count') ) {
        function wp_all_import_update_post_count() {
            global $wpdb;
            update_option( 'post_count', (int) $wpdb->get_var( "SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_status = 'publish' and post_type = 'post'" ) );
        }
    }

    if ( ! function_exists('wp_all_import_supported_image_types') ) {
        function wp_all_import_supported_image_types() {
            $supported_image_types = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP);
            if (defined('IMAGETYPE_WEBP')) {
                $supported_image_types[] = IMAGETYPE_WEBP;
            }
            return $supported_image_types;
        }
    }

    if ( ! function_exists('wp_all_import_generate_functions_hash') ) {
        function wp_all_import_generate_functions_hash() {
            $uploads = wp_upload_dir();
            $functions_hash = false;
            $functions_file = $uploads['basedir'] . DIRECTORY_SEPARATOR . WP_ALL_IMPORT_UPLOADS_BASE_DIRECTORY . DIRECTORY_SEPARATOR . 'functions.php';
            if (@file_exists($functions_file)) {
                $functions_hash = hash_file('md5', $functions_file);
                // Check functions file from current theme.
                $theme_functions_file = get_template_directory() . '/functions.php';
                if (@file_exists($theme_functions_file)) {
                    $functions_hash .= hash_file('md5', $theme_functions_file);
                }
            }
            return $functions_hash;
        }
    }



