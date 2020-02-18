<?php
/**
 * Search & Filter Pro
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */
?>

	<!--<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>-->

<?php
$current_tab = ! empty( $_REQUEST['tab'] ) ? sanitize_title( $_REQUEST['tab'] ) : 'status';
?>
<div class="wrap woocommerce">
	<div class="icon32 icon32-woocommerce-status" id="icon-woocommerce"><br /></div><h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
		<?php
			$tabs = array(
				'status' => __( 'System Status', 'search-filter-pro' ),
				'search-forms'  => __( 'Search Forms', 'search-filter-pro' )
			);
			foreach ( $tabs as $name => $label ) {
				echo '<a href="' . admin_url( 'edit.php?post_type=search-filter-widget&page=search-filter-system-status&tab=' . $name ) . '" class="nav-tab ';
				if ( $current_tab == $name ) echo 'nav-tab-active';
				echo '">' . $label . '</a>';
			}
		?>
	</h2>
<?php
if ( $current_tab == "status") {
	

?>

<?php /*<div class="updated woocommerce-message">
	<p><?php _e( 'Please copy and paste this information in your ticket when contacting support:', 'search-filter-pro' ); ?> </p>
	<p class="submit"><a href="#" class="button-primary debug-report"><?php _e( 'Get System Report', 'search-filter-pro' ); ?></a>
	<a class="button-secondary docs" href="#" target="_blank"><?php _e( 'Understanding the Status Report', 'search-filter-pro' ); ?></a></p>
	<div id="debug-report">
		<textarea readonly="readonly"></textarea>
		<p class="submit"><button id="copy-for-support" class="button-primary" href="#" data-tip="<?php esc_attr_e( 'Copied!', 'search-filter-pro' ); ?>"><?php _e( 'Copy for Support', 'search-filter-pro' ); ?></button></p>
		<p class="copy-error hidden"><?php _e( 'Copying to clipboard failed. Please press Ctrl/Cmd+C to copy.', 'search-filter-pro' ); ?></p>
	</div>
</div>*/ ?>

	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="WordPress Environment"><?php _e( 'WordPress Environment', 'search-filter-pro' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Home URL"><?php _e( 'Home URL', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The URL of your site\'s homepage.', 'search-filter-pro' ) ); ?></td>
				<td><?php form_option( 'home' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Site URL"><?php _e( 'Site URL', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The root URL of your site.', 'search-filter-pro' ) ); ?></td>
				<td><?php form_option( 'siteurl' ); ?></td>
			</tr>
			<tr>
				<td data-export-label="WC Version"><?php _e( 'Search & Filter Pro Version', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The version of Search & Filter Pro installed on your site.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo esc_html( Search_Filter_Admin::VERSION ); ?></td>
			</tr>
			<?php /*<!--<tr>
				<td data-export-label="Log Directory Writable"><?php _e( 'Log Directory Writable', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'Several WooCommerce extensions can write logs which makes debugging problems easier. The directory must be writable for this to happen.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					if ( @fopen( WC_LOG_DIR . 'test-log.log', 'a' ) ) {
						echo '<mark class="yes">&#10004; <code class="private">' . WC_LOG_DIR . '</code></mark> ';
					} else {
						printf( '<mark class="error">&#10005; ' . __( 'To allow logging, make <code>%s</code> writable or define a custom <code>WC_LOG_DIR</code>.', 'search-filter-pro' ) . '</mark>', WC_LOG_DIR );
					}
				?></td>
			</tr>--> */ ?>
			<tr>
				<td data-export-label="WP Version"><?php _e( 'WP Version', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The version of WordPress installed on your site.', 'search-filter-pro' ) ); ?></td>
				<td><?php bloginfo('version'); ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Multisite"><?php _e( 'WP Multisite', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'Whether or not you have WordPress Multisite enabled.', 'search-filter-pro' ) ); ?></td>
				<td><?php if ( is_multisite() ) echo '&#10004;'; else echo '&ndash;'; ?></td>
			</tr>
			<tr>
				<td data-export-label="WP Memory Limit"><?php _e( 'WP Memory Limit', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The maximum amount of memory (RAM) that your site can use at one time.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					$memory = $this->sf_let_to_num( WP_MEMORY_LIMIT );

					if ( function_exists( 'memory_get_usage' ) ) {
						$system_memory =  $this->sf_let_to_num( @ini_get( 'memory_limit' ) );
						$memory        = max( $memory, $system_memory );
					}
					
					if ( $memory < 67108864 ) {
						//echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least 64MB. See: %s', 'search-filter-pro' ), size_format( $memory ), '<a href="http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . __( 'Increasing memory allocated to PHP', 'search-filter-pro' ) . '</a>' ) . '</mark>';
						echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least 64MB.', 'search-filter-pro' ), size_format( $memory ) ) . '</mark>';
					} else {
						echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
					}
				?></td>
			</tr>
			<tr>
				<td data-export-label="WP Debug Mode"><?php _e( 'WP Debug Mode', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'Displays whether or not WordPress is in Debug Mode.', 'search-filter-pro' ) ); ?></td>
				<td><?php if ( defined('WP_DEBUG') && WP_DEBUG ) echo '<mark class="yes">&#10004;</mark>'; else echo '<mark class="no">&ndash;</mark>'; ?></td>
			</tr>
			<tr>
				<td data-export-label="Language"><?php _e( 'Language', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The current language used by WordPress. Default = English', 'search-filter-pro' ) ); ?></td>
				<td><?php echo get_locale() ?></td>
			</tr>
		</tbody>
	</table>
	<table class="widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Server Environment"><?php _e( 'Server Environment', 'search-filter-pro' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Server Info"><?php _e( 'Server Info', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'Information about the web server that is currently hosting your site.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ); ?></td>
			</tr>
			<tr>
				<td data-export-label="PHP Version"><?php _e( 'PHP Version', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The version of PHP installed on your hosting server.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					// Check if phpversion function exists.
					if ( function_exists( 'phpversion' ) ) {
						$php_version = phpversion();

						//if ( version_compare( $php_version, '5.4', '<' ) ) {
						//	echo '<mark class="error">' . sprintf( __( '%s - We recommend a minimum PHP version of 5.4. See: %s', 'search-filter-pro' ), esc_html( $php_version ), '<a href="#" target="_blank">' . __( 'How to update your PHP version', 'search-filter-pro' ) . '</a>' ) . '</mark>';
						//} else {
							//echo '<mark class="yes">' . esc_html( $php_version ) . '</mark>';
							echo '' . esc_html( $php_version ) . '';
						//}
					} else {
						_e( "Couldn't determine PHP version because phpversion() doesn't exist.", 'search-filter-pro' );
					}
					?></td>
			</tr>
			<?php if ( function_exists( 'ini_get' ) ) : ?>
				<tr>
					<td data-export-label="PHP Post Max Size"><?php _e( 'PHP Post Max Size', 'search-filter-pro' ); ?>:</td>
					<td class="help"><?php echo ( __( 'The largest filesize that can be contained in one post.', 'search-filter-pro' ) ); ?></td>
					<td><?php echo size_format( $this->sf_let_to_num( ini_get( 'post_max_size' ) ) ); ?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Time Limit"><?php _e( 'PHP Time Limit', 'search-filter-pro' ); ?>:</td>
					<td class="help"><?php echo ( __( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'search-filter-pro' ) ); ?></td>
					<td><?php echo ini_get( 'max_execution_time' ); ?></td>
				</tr>
				<tr>
					<td data-export-label="PHP Max Input Vars"><?php _e( 'PHP Max Input Vars', 'search-filter-pro' ); ?>:</td>
					<td class="help"><?php echo ( __( 'The maximum number of variables your server can use for a single function to avoid overloads.', 'search-filter-pro' ) ); ?></td>
					<td><?php echo ini_get( 'max_input_vars' ); ?></td>
				</tr>
				<tr>
					<td data-export-label="SUHOSIN Installed"><?php _e( 'SUHOSIN Installed', 'search-filter-pro' ); ?>:</td>
					<td class="help"><?php echo ( __( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'search-filter-pro' ) ); ?></td>
					<td><?php echo extension_loaded( 'suhosin' ) ? '&#10004;' : '&ndash;'; ?></td>
				</tr>
			<?php endif; ?>
			<tr>
				<td data-export-label="MySQL Version"><?php _e( 'MySQL Version', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The version of MySQL installed on your hosting server.', 'search-filter-pro' ) ); ?></td>
				<td>
					<?php
					/** @global wpdb $wpdb */
					global $wpdb;
					echo $wpdb->db_version();
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Max Upload Size"><?php _e( 'Max Upload Size', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The largest filesize that can be uploaded to your WordPress installation.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo size_format( wp_max_upload_size() ); ?></td>
			</tr>
			<?php /*<tr>
				<td data-export-label="Default Timezone is UTC"><?php _e( 'Default Timezone is UTC', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The default timezone for your server.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					$default_timezone = date_default_timezone_get();
					if ( 'UTC' !== $default_timezone ) {
						echo '<mark class="error">&#10005; ' . sprintf( __( 'Default timezone is %s - it should be UTC', 'search-filter-pro' ), $default_timezone ) . '</mark>';
					} else {
						echo '<mark class="yes">&#10004;</mark>';
					} ?>
				</td>
			</tr>*/ ?>
			<?php
				$posting = array();

				// fsockopen/cURL.
				$posting['fsockopen_curl']['name'] = 'fsockopen/cURL';
				$posting['fsockopen_curl']['help'] = ( __( 'Payment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services.', 'search-filter-pro' ) );

				if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
					$posting['fsockopen_curl']['success'] = true;
				} else {
					$posting['fsockopen_curl']['success'] = false;
					$posting['fsockopen_curl']['note']    = __( 'Your server does not have fsockopen or cURL enabled - PayPal IPN and other scripts which communicate with other servers will not work. Contact your hosting provider.', 'search-filter-pro' );
				}

				// SOAP.
				/*$posting['soap_client']['name'] = 'SoapClient';
				$posting['soap_client']['help'] = ( __( 'Some webservices like shipping use SOAP to get information from remote servers, for example, live shipping quotes from FedEx require SOAP to be installed.', 'search-filter-pro' ) );

				if ( class_exists( 'SoapClient' ) ) {
					$posting['soap_client']['success'] = true;
				} else {
					$posting['soap_client']['success'] = false;
					$posting['soap_client']['note']    = sprintf( __( 'Your server does not have the %s class enabled - some gateway plugins which use SOAP may not work as expected.', 'search-filter-pro' ), '<a href="http://php.net/manual/en/class.soapclient.php">SoapClient</a>' );
				}*/

				// DOMDocument.
				/*$posting['dom_document']['name'] = 'DOMDocument';
				$posting['dom_document']['help'] = ( __( 'HTML/Multipart emails use DOMDocument to generate inline CSS in templates.', 'search-filter-pro' ) );

				if ( class_exists( 'DOMDocument' ) ) {
					$posting['dom_document']['success'] = true;
				} else {
					$posting['dom_document']['success'] = false;
					$posting['dom_document']['note']    = sprintf( __( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'search-filter-pro' ), '<a href="http://php.net/manual/en/class.domdocument.php">DOMDocument</a>' );
				}*/

				// GZIP.
				/*$posting['gzip']['name'] = 'GZip';
				$posting['gzip']['help'] = ( __( 'GZip (gzopen) is used to open the GEOIP database from MaxMind.', 'search-filter-pro' ) );

				if ( is_callable( 'gzopen' ) ) {
					$posting['gzip']['success'] = true;
				} else {
					$posting['gzip']['success'] = false;
					$posting['gzip']['note']    = sprintf( __( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind. The API fallback will be used instead for geolocation.', 'search-filter-pro' ), '<a href="http://php.net/manual/en/zlib.installation.php">gzopen</a>' );
				}*/

				// Multibyte String.
				$posting['mbstring']['name'] = 'Multibyte String';
				$posting['mbstring']['help'] = ( __( 'Multibyte String (mbstring) is used to convert character encoding, like for emails or converting characters to lowercase.', 'search-filter-pro' ) );

				if ( extension_loaded( 'mbstring' ) ) {
					$posting['mbstring']['success'] = true;
				} else {
					$posting['mbstring']['success'] = false;
					$posting['mbstring']['note']    = sprintf( __( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', 'search-filter-pro' ), '<a href="http://php.net/manual/en/mbstring.installation.php">mbstring</a>' );
				}

				// WP Remote Post Check.
				/*$posting['wp_remote_post']['name'] = __( 'Remote Post', 'search-filter-pro');
				$posting['wp_remote_post']['help'] = ( __( 'PayPal uses this method of communicating when sending back transaction information.', 'search-filter-pro' ) );

				$response = wp_safe_remote_post( 'https://www.paypal.com/cgi-bin/webscr', array(
					'timeout'    => 60,
					'user-agent' => 'Search_Filter/' . Search_Filter_Admin::VERSION,
					'body'       => array(
						'cmd'    => '_notify-validate'
					)
				) );

				if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
					$posting['wp_remote_post']['success'] = true;
				} else {
					$posting['wp_remote_post']['note']    = __( 'wp_remote_post() failed. PayPal IPN won\'t work with your server. Contact your hosting provider.', 'search-filter-pro' );
					if ( is_wp_error( $response ) ) {
						$posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Error: %s', 'search-filter-pro' ), wc_clean( $response->get_error_message() ) );
					} else {
						$posting['wp_remote_post']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'search-filter-pro' ), wc_clean( $response['response']['code'] ) );
					}
					$posting['wp_remote_post']['success'] = false;
				}

				// WP Remote Get Check.
				$posting['wp_remote_get']['name'] = __( 'Remote Get', 'search-filter-pro');
				$posting['wp_remote_get']['help'] = ( __( 'Search & Filter uses this method for building the cache in the background.', 'search-filter-pro' ) );

				$response = wp_safe_remote_get( 'searchandfilterurl' . ( is_multisite() ? '1' : '0' ) );

				if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
					$posting['wp_remote_get']['success'] = true;
				} else {
					$posting['wp_remote_get']['note']    = __( 'wp_remote_get() failed. The Search & Filter plugin updater won\'t work with your server. Contact your hosting provider.', 'search-filter-pro' );
					if ( is_wp_error( $response ) ) {
						$posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Error: %s', 'search-filter-pro' ), wc_clean( $response->get_error_message() ) );
					} else {
						$posting['wp_remote_get']['note'] .= ' ' . sprintf( __( 'Status code: %s', 'search-filter-pro' ), wc_clean( $response['response']['code'] ) );
					}
					$posting['wp_remote_get']['success'] = false;
				}

				$posting = apply_filters( 'woocommerce_debug_posting', $posting );
				*/
				foreach ( $posting as $post ) {
					$mark = ! empty( $post['success'] ) ? 'yes' : 'error';
					?>
					<tr>
						<td data-export-label="<?php echo esc_html( $post['name'] ); ?>"><?php echo esc_html( $post['name'] ); ?>:</td>
						<td class="help"><?php echo isset( $post['help'] ) ? $post['help'] : ''; ?></td>
						<td>
							<mark class="<?php echo $mark; ?>">
								<?php echo ! empty( $post['success'] ) ? '&#10004' : '&#10005'; ?> <?php echo ! empty( $post['note'] ) ? wp_kses_data( $post['note'] ) : ''; ?>
							</mark>
						</td>
					</tr>
					<?php
				}
			?>
		</tbody>
	</table>
	<table class="widefat" cellspacing="0" id="status">
		<thead>
			<tr>
				<th colspan="3" data-export-label="WordPress Environment"><?php _e( 'Database', 'search-filter-pro' ); ?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td data-export-label="Home URL"><?php echo sprintf( _x( 'Table `%s` Exists', 'search-filter-pro' ), $this->cache_table_name); ?>:</td>
				<td class="help"><?php echo ( __( 'The URL of your site\'s homepage.', 'search-filter-pro' ) ); ?></td>
				<td><?php 
					
					if($wpdb->get_var("SHOW TABLES LIKE '$this->cache_table_name'") != $this->cache_table_name) {
						//table is not created. you may create the table here.
						$table_error = true;
						echo '<mark class="error">' . __('Table Not Found', 'search-filter-pro') . '</mark>';
					}
					else
					{//table exists, grab number of rows
				
						$row_count = $wpdb->get_results( 
							"
							SELECT COUNT(*) FROM $this->cache_table_name
							"
						);
						
						$number_of_rows = $row_count[0]->{"COUNT(*)"};
						
						echo '<mark class="yes">&#10004; ' . $number_of_rows . " " . __('Rows Found', 'search-filter-pro') . '</mark>';
					}
				 
				?></td>
			</tr>
			<tr>
				<td data-export-label="Home URL"><?php echo sprintf( _x( 'Table `%s` Exists', 'search-filter-pro' ), $this->term_results_table_name); ?>:</td>
				<td class="help"><?php echo ( __( 'The URL of your site\'s homepage.', 'search-filter-pro' ) ); ?></td>
				<td><?php 
					
					if($wpdb->get_var("SHOW TABLES LIKE '$this->term_results_table_name'") != $this->term_results_table_name) {
						//table is not created. you may create the table here.
						$table_error = true;
						echo '<mark class="error">' . __('Table Not Found', 'search-filter-pro') . '</mark>';
					}
					else
					{//table exists, grab number of rows
				
						$row_count = $wpdb->get_results( 
							"
							SELECT COUNT(*) FROM $this->term_results_table_name
							"
						);
						
						$number_of_rows = $row_count[0]->{"COUNT(*)"};
						
						echo '<mark class="yes">&#10004; ' . $number_of_rows . " " . __('Rows Found', 'search-filter-pro') . '</mark>';
					}
					
				
				?></td>
			</tr>
			<tr>
				<td data-export-label="Home URL"><?php _e( 'Total Number of Fields Cached', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The URL of your site\'s homepage.', 'search-filter-pro' ) ); ?></td>
				<td>
				<?php
					
					$field_results = $wpdb->get_results( 
						"
						SELECT field_name, field_value, result_ids
						FROM $this->term_results_table_name
						GROUP BY field_name
						"
					);
					
					$number_of_fields = count($field_results);
					
					if($number_of_fields==0)
					{
						echo '<mark class="error">' . esc_html( $number_of_fields ) . '</mark>';
					}
					else
					{
						echo '<mark class="yes">' . esc_html( $number_of_fields ) . '</mark>';
					}
				?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Fields in Cache"><?php _e( 'Fields in Cache', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The URL of your site\'s homepage.', 'search-filter-pro' ) ); ?></td>
				<td>
					<?php
					$fields_in_cache = array();
					foreach($field_results as $field_result)
					{
						array_push($fields_in_cache, $field_result->field_name);
					}
					echo implode(", " , $fields_in_cache);
					?>
				</td>
			</tr>
		</tbody>
	</table>

	
	<table class="wc_status_table widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Active Plugins (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)"><?php _e( 'Active Plugins', 'search-filter-pro' ); ?> (<?php echo count( (array) get_option( 'active_plugins' ) ); ?>)</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$active_plugins = (array) get_option( 'active_plugins', array() );

			if ( is_multisite() ) {
				$network_activated_plugins = array_keys( get_site_option( 'active_sitewide_plugins', array() ) );
				$active_plugins            = array_merge( $active_plugins, $network_activated_plugins );
			}

			foreach ( $active_plugins as $plugin ) {

				$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
				$dirname        = dirname( $plugin );
				$version_string = '';
				$network_string = '';

				if ( ! empty( $plugin_data['Name'] ) ) {

					// Link the plugin name to the plugin url if available.
					$plugin_name = esc_html( $plugin_data['Name'] );

					if ( ! empty( $plugin_data['PluginURI'] ) ) {
						$plugin_name = '<a href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="' . esc_attr__( 'Visit plugin homepage' , 'search-filter-pro' ) . '" target="_blank">' . $plugin_name . '</a>';
					}

					

					?>
					<tr>
						<td><?php echo $plugin_name; ?></td>
						<td class="help">&nbsp;</td>
						<td><?php echo sprintf( _x( 'by %s', 'by author', 'search-filter-pro' ), $plugin_data['Author'] ) . ' &ndash; ' . esc_html( $plugin_data['Version'] ) . $version_string . $network_string; ?></td>
					</tr>
					<?php
				}
			}
			?>
		</tbody>
	</table>
	<table class="wc_status_table widefat" cellspacing="0">
		<thead>
			<tr>
				<th colspan="3" data-export-label="Theme"><?php _e( 'Theme', 'search-filter-pro' ); ?></th>
			</tr>
		</thead>
			<?php
			include_once( ABSPATH . 'wp-admin/includes/theme-install.php' );

			$active_theme         = wp_get_theme();
			$theme_version        = $active_theme->Version;
			//$update_theme_version = WC_Admin_Status::get_latest_theme_version( $active_theme );
			?>
		<tbody>
			<tr>
				<td data-export-label="Name"><?php _e( 'Name', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The name of the current active theme.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo esc_html( $active_theme->Name ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Version"><?php _e( 'Version', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The installed version of the current active theme.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					echo esc_html( $theme_version );

					/*if ( version_compare( $theme_version, $update_theme_version, '<' ) ) {
						echo ' &ndash; <strong style="color:red;">' . sprintf( __( '%s is available', 'search-filter-pro' ), esc_html( $update_theme_version ) ) . '</strong>';
					}*/
				?></td>
			</tr>
			<tr>
				<td data-export-label="Author URL"><?php _e( 'Author URL', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The theme developers URL.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo $active_theme->{'Author URI'}; ?></td>
			</tr>
			<tr>
				<td data-export-label="Child Theme"><?php _e( 'Child Theme', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'Displays whether or not the current theme is a child theme.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					//echo is_child_theme() ? '<mark class="yes">&#10004;</mark>' : '&#10005; &ndash; ' . sprintf( __( 'If you\'re modifying Search & Filter on a parent theme you didn\'t build personally, then we recommend using a child theme. See: <a href="%s" target="_blank">How to create a child theme</a>', 'search-filter-pro' ), 'http://codex.wordpress.org/Child_Themes' );
					echo is_child_theme() ? '<mark class="yes">&#10004;</mark>' : '&#10005;';
				?></td>
			</tr>
			<?php
			if( is_child_theme() ) :
				$parent_theme         = wp_get_theme( $active_theme->Template );
				//$update_theme_version = WC_Admin_Status::get_latest_theme_version( $parent_theme );
			?>
			<tr>
				<td data-export-label="Parent Theme Name"><?php _e( 'Parent Theme Name', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The name of the parent theme.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo esc_html( $parent_theme->Name ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Version"><?php _e( 'Parent Theme Version', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The installed version of the parent theme.', 'search-filter-pro' ) ); ?></td>
				<td><?php
					echo esc_html( $parent_theme->Version );

					/*if ( version_compare( $parent_theme->Version, $update_theme_version, '<' ) ) {
						echo ' &ndash; <strong style="color:red;">' . sprintf( __( '%s is available', 'search-filter-pro' ), esc_html( $update_theme_version ) ) . '</strong>';
					}*/
				?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Author URL"><?php _e( 'Parent Theme Author URL', 'search-filter-pro' ); ?>:</td>
				<td class="help"><?php echo ( __( 'The parent theme developers URL.', 'search-filter-pro' ) ); ?></td>
				<td><?php echo $parent_theme->{'Author URI'}; ?></td>
			</tr>
			<?php endif ?>
			
		</tbody>
	</table>
	
<?php 

}
else if ( $current_tab == "search-forms")
{
	$search_form_query = new WP_Query('post_type=search-filter-widget&post_status=publish,draft&posts_per_page=-1&suppress_filters=1');
	$search_forms = $search_form_query->get_posts();
	
	foreach($search_forms as $search_form)
	{
		
?>

<table class="widefat" cellspacing="0" id="">
	<thead>
		<tr>
			<th colspan="3" data-export-label="<?php echo esc_attr($search_form->post_title); ?>"><a href="<?php echo admin_url( 'post.php?post='.$search_form->ID.'&action=edit' ); ?>" target="_blank"><?php echo $search_form->post_title; ?> - <?php echo $search_form->ID; ?></a></th>
		</tr>
	</thead>
	<tbody>

		<tr>
			<td data-export-label="Fields"><?php _e( 'Fields', 'search-filter-pro' ); ?>:</td>
			<td class="help"><?php echo ( __( 'The list of fields in your search form.', 'search-filter-pro' ) ); ?></td>
			<td>
			<?php	

				//as we only want to update "enabled", then load all settings and update only this key
				$search_form_fields = Search_Filter_Helper::get_fields_meta($search_form->ID);
				$filters = array();
				foreach($search_form_fields as $key => $field)
				{
					$valid_filter_types = array("tag", "category", "taxonomy", "post_meta");
					
					if(in_array($field['type'], $valid_filter_types))
					{
						if(($field['type']=="tag")||($field['type']=="category")||($field['type']=="taxonomy"))
						{
							array_push($filters, "_sft_".$field['taxonomy_name']);
						}
						else if($field['type']=="post_meta")
						{
							if($field['meta_type']=="choice")
							{
								array_push($filters, "_sfm_".$field['meta_key']);
							}
						}
					}
					else
					{
						array_push($filters, $field['type']);
					}

				}
				
				echo implode(", " , $filters);
			?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Display Results Method"><?php _e( 'Display Results Method', 'search-filter-pro' ); ?>:</td>
			<td class="help"><?php echo ( __( 'The method your search form uses to display results.', 'search-filter-pro' ) ); ?></td>
			<td>
			<?php

				//as we only want to update "enabled", then load all settings and update only this key
				$search_form_settings = Search_Filter_Helper::get_settings_meta($search_form->ID);

				if(is_array($search_form_settings))
				{
					$display_results_as = "";
					$results_label = "";
					
					if(isset($search_form_settings['display_results_as']))
					{
						$display_results_as = $search_form_settings['display_results_as'];
					}

					if($display_results_as=="archive")
					{
						$results_label = __("As an Archive", $this->plugin_slug);
					}
					else if($display_results_as=="post_type_archive")
					{
						$post_type = "";
						if(isset($search_form_settings['post_types']))
						{
							if(count($search_form_settings['post_types'])==1)
							{
								$post_types = array_keys($search_form_settings['post_types']);

								$post_type_object = get_post_type_object( $post_types[0] );

								if(isset($post_type_object->label))
								{
									$post_type = $post_type_object->label;
								}
							}
						}
						$results_label = sprintf(__("Post Type Archive: <strong>%s</strong>", $this->plugin_slug), $post_type);
					}
					else if($display_results_as=="shortcode")
					{
						$results_label = __("Using a Shortcode", $this->plugin_slug);
					}
					else if($display_results_as=="custom")
					{
						$results_label = __("Custom", $this->plugin_slug);
					}
					else if($display_results_as=="custom_woocommerce_store")
					{
						$results_label = __("WooCommerce Shop", $this->plugin_slug);
					}
					else if($display_results_as=="custom_edd_store")
					{
						$results_label = __("EDD Downloads Page", $this->plugin_slug);
					}

					echo $results_label;
				}
			?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Potential Issues"><?php _e( 'Potential Issues', 'search-filter-pro' ); ?>:</td>
			<td class="help"><?php echo ( __( 'A list of potential issues', 'search-filter-pro' ) ); ?></td>
			<td><?php
			
				$this->admin_notices->set_post_notices($search_form->ID);
				$post_notice_log = $this->admin_notices->get_post_notices();
				$this->admin_notices->clear_post_notices();
				
				$error_count = count($post_notice_log);
				$error_messages = array();
				
				if($error_count>0)
				{
					foreach($post_notice_log as $post_message)
					{
						$message_level = __("Error: ", $this->plugin_slug);
						if($post_message['type']=="sf-notice")
						{
							$message_level = __("Notice:", $this->plugin_slug);
						}
						
						array_push($error_messages, '<mark class="error"><!-- &#10005; -->'.$message_level.$post_message['message'].'</mark>');
					}
					
					//echo '<mark class="yes">&#10004; ' . __('None Reported', 'search-filter-pro') . '</mark>';
					echo implode("<br />", $error_messages);
				}
				else
				{
					echo '<mark class="yes">&#10004; ' . __('None Reported', 'search-filter-pro') . '</mark>';
				}
			?></td>
		</tr>
		
	</tbody>
</table>
<?php
	
		}
		?>
	<?php
}
?>
</div>
