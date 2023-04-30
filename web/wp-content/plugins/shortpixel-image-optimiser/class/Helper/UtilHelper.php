<?php
namespace ShortPixel\Helper;

// Our newest Tools class
class UtilHelper
{

		public static function getPostMetaTable()
		{
			 global $wpdb;

			 return $wpdb->prefix . 'shortpixel_postmeta';
		}

		public static function shortPixelIsPluginActive($plugin) {
        $activePlugins = apply_filters( 'active_plugins', get_option( 'active_plugins', array()));
        if ( is_multisite() ) {
            $activePlugins = array_merge($activePlugins, get_site_option( 'active_sitewide_plugins'));
        }
        return in_array( $plugin, $activePlugins);
    }

		static public function timestampToDB($timestamp)
		{
				return date("Y-m-d H:i:s", $timestamp);
		}

		static public function DBtoTimestamp($date)
		{
				return strtotime($date);
		}

		public static function getWordPressImageSizes()
		{
			global $_wp_additional_image_sizes;

			$sizes_names = get_intermediate_image_sizes();
			$sizes = array();
			foreach ( $sizes_names as $size ) {
					$sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
					$sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
					$sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
			}
			if(function_exists('wp_get_additional_image_sizes')) {
					$sizes = array_merge($sizes, wp_get_additional_image_sizes());
			} elseif(is_array($_wp_additional_image_sizes)) {
					$sizes = array_merge($sizes, $_wp_additional_image_sizes);
			}

			$sizes = apply_filters('shortpixel/settings/image_sizes', $sizes);
			return $sizes;
		}

		// wp_normalize_path doesn't work for windows installs in some situations, so we can use it, but we still want some of the functions.
		public static function spNormalizePath($path)
		{
				$path = preg_replace( '|(?<=.)/+|', '/', $path );
				return $path;
		}

		// Copy of private https://developer.wordpress.org/reference/functions/_wp_relative_upload_path/
		public static function getRelativeUploadPath($path)
		{
				$new_path = $path;
						$uploads = wp_get_upload_dir();
				if ( 0 === strpos( $new_path, $uploads['basedir'] ) ) {
						$new_path = str_replace( $uploads['basedir'], '', $new_path );
						$new_path = ltrim( $new_path, '/' );
				}
			return $new_path;
		}

		public static function alterHtaccess($webp = false, $avif = false)
		{
         // [BS] Backward compat. 11/03/2019 - remove possible settings from root .htaccess
         /* Plugin init is before loading these admin scripts. So it can happen misc.php is not yet loaded */
         if (! function_exists('insert_with_markers'))
         {
           Log::addWarn('AlterHtaccess Called before WP init');
           return;
           //require_once( ABSPATH . 'wp-admin/includes/misc.php' );
         }
           $upload_dir = wp_upload_dir();
           $upload_base = trailingslashit($upload_dir['basedir']);

           if ( ! $webp && ! $avif ) {
               insert_with_markers( get_home_path() . '.htaccess', 'ShortPixelWebp', '');
               insert_with_markers( $upload_base . '.htaccess', 'ShortPixelWebp', '');
               insert_with_markers( trailingslashit(WP_CONTENT_DIR) . '.htaccess', 'ShortPixelWebp', '');
           } else {

           $avif_rules = '
           <IfModule mod_rewrite.c>
           RewriteEngine On
           ##### Directives for delivering AVIF files, if they exist #####
           # Does the browser support avif?
           RewriteCond %{HTTP_ACCEPT} image/avif
           # AND is the request a jpg or png? (also grab the basepath %1 to match in the next rule)
           RewriteCond %{REQUEST_URI} ^(.+)\.(?:jpe?g|png|gif)$
           # AND does a .avif image exist?
           RewriteCond %{DOCUMENT_ROOT}/%1.avif -f
           # THEN send the avif image and set the env var avif
           RewriteRule (.+)\.(?:jpe?g|png)$ $1.avif [NC,T=image/avif,E=avif,L]

					 # Does the browser support avif?
					 RewriteCond %{HTTP_ACCEPT} image/avif
					 # AND is the request a jpg or png? (also grab the basepath %1 to match in the next rule)
					 RewriteCond %{REQUEST_URI} ^(.+)\.(?:jpe?g|png|gif)$
					 # AND does a .jpg.avif image exist?
					 RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI}.avif -f
					 # THEN send the avif image and set the env var avif
					 RewriteRule ^(.+)$ $1.avif [NC,T=image/avif,E=avif,L]

           </IfModule>
           <IfModule mod_headers.c>
           # If REDIRECT_avif env var exists, append Accept to the Vary header
           Header append Vary Accept env=REDIRECT_avif
           </IfModule>
           <IfModule mod_mime.c>
           AddType image/avif .avif
           </IfModule>
                 ';

               $webp_rules = '
           <IfModule mod_rewrite.c>
             RewriteEngine On
             ##### TRY FIRST the file appended with .webp (ex. test.jpg.webp) #####
             # Is the browser Chrome?
             RewriteCond %{HTTP_USER_AGENT} Chrome [OR]
             # OR Is request from Page Speed
             RewriteCond %{HTTP_USER_AGENT} "Google Page Speed Insights" [OR]
             # OR does this browser explicitly support webp
             RewriteCond %{HTTP_ACCEPT} image/webp
             # AND NOT MS EDGE 42/17 - doesnt work.
             RewriteCond %{HTTP_USER_AGENT} !Edge/17
             # AND is the request a jpg, png or gif?
             RewriteCond %{REQUEST_URI} ^(.+)\.(?:jpe?g|png|gif)$
             # AND does a .ext.webp image exist?
             RewriteCond %{DOCUMENT_ROOT}%{REQUEST_URI}.webp -f
             # THEN send the webp image and set the env var webp
             RewriteRule ^(.+)$ $1.webp [NC,T=image/webp,E=webp,L]
             ##### IF NOT, try the file with replaced extension (test.webp) #####
             RewriteCond %{HTTP_USER_AGENT} Chrome [OR]
             RewriteCond %{HTTP_USER_AGENT} "Google Page Speed Insights" [OR]
             RewriteCond %{HTTP_ACCEPT} image/webp
             RewriteCond %{HTTP_USER_AGENT} !Edge/17
             # AND is the request a jpg, png or gif? (also grab the basepath %1 to match in the next rule)
             RewriteCond %{REQUEST_URI} ^(.+)\.(?:jpe?g|png|gif)$
             # AND does a .webp image exist?
             RewriteCond %{DOCUMENT_ROOT}/%1.webp -f
             # THEN send the webp image and set the env var webp
             RewriteRule (.+)\.(?:jpe?g|png|gif)$ $1.webp [NC,T=image/webp,E=webp,L]
           </IfModule>
           <IfModule mod_headers.c>
             # If REDIRECT_webp env var exists, append Accept to the Vary header
             Header append Vary Accept env=REDIRECT_webp
           </IfModule>
           <IfModule mod_mime.c>
             AddType image/webp .webp
           </IfModule>
           ' ;

             $rules = '';
         //    if ($avif)
             $rules .= $avif_rules;
           //  if ($webp)
             $rules .= $webp_rules;

             insert_with_markers( get_home_path() . '.htaccess', 'ShortPixelWebp', $rules);

    /** In uploads and on, it needs Inherit. Otherwise things such as the 404 error page will not be loaded properly
   * since the WP rewrite will not be active at that point (overruled) **/
    $rules = str_replace('RewriteEngine On', 'RewriteEngine On' . PHP_EOL . 'RewriteOptions Inherit', $rules);

               insert_with_markers( $upload_base . '.htaccess', 'ShortPixelWebp', $rules);
               insert_with_markers( trailingslashit(WP_CONTENT_DIR) . '.htaccess', 'ShortPixelWebp', $rules);

           }
    }
} // class
