<?php
/**
 * Core functionality for running the cncf.io site.
 *
 * Plugin Name: LF MU
 * Plugin URI:  https://github.com/cncf/cncf.io
 * Description: Core functionality for running the cncf.io site.
 * Author: Chris Abraham, James Hunt
 * Author URI:  https://www.cncf.io
 * Version: 1.1.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: lf-mu
 *
 * @package WordPress
 * @subpackage lf-mu
 */

/**
 * Include the LF MU plugin
 */
if ( file_exists( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-mu/lf-mu.php' ) ) {
	require WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-mu/lf-mu.php';
} else {
	add_action( 'admin_notices', 'lf_theme_lf_mu_admin_notice' );
}

/**
 * Custom admin notice if LF MU plugin not installed.
 */
function lf_theme_lf_mu_admin_notice() { ?>

	<div class="notice notice-error is-dismissible">
		<p><strong>The Linux Foundation CNCF Theme requires the <a href="https://github.com/cncf/wp-mu-plugins" target="_blank">LF MU Plugin</a> to be installed.</strong></p>

		<p><a href="https://github.com/cncf/wp-mu-plugins/archive/master.zip">Download the latest version of this plugin</a>, unzip the archive, rename it's containing folder from <code>wp-mu-plugins-master</code> to <code>wp-mu-plugins</code> and then copy the plugin to <code>/wp-content/mu-plugins/</code>.</p>

<p>Visit the <a href="https://github.com/cncf/wp-mu-plugins" target="_blank">LF MU Plugin</a> repo on Github to file any support issues.</p>
</div>
		<?php
}
