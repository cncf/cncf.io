<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Gutenberg block assets for both frontend + backend.
 *
 * Assets enqueued:
 * 1. blocks.style.build.css - Frontend + Backend.
 * 2. blocks.build.js - Backend.
 * 3. blocks.editor.build.css - Backend.
 *
 * @uses {wp-blocks} for block type registration & related functions.
 * @uses {wp-element} for WP Element abstraction — structure of blocks.
 * @uses {wp-i18n} to internationalize the block's text.
 * @uses {wp-editor} for WP editor styles.
 * @since 1.0.0
 */
function lf_latest_jobs_block_assets() { // phpcs:ignore
	wp_register_script(
		'lf-latest-jobs-block-js',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
		true
	);

	wp_register_style(
		'lf-latest-jobs-block-style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array(),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
	);

	wp_register_style(
		'lf-latest-jobs-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
	);

	/**
	 * Register Gutenberg block on server-side.
	 *
	 * Register the block on server-side to ensure that the block
	 * scripts and styles for both frontend and backend are
	 * enqueued when the editor loads.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
	 * @since 1.16.0
	 */
	register_block_type(
		'lf/latest-jobs',
		array(
			'style'           => 'lf-latest-jobs-block-style-css',
			'editor_script'   => 'lf-latest-jobs-block-js',
			'editor_style'    => 'lf-latest-jobs-block-editor-css',
			'render_callback' => 'lf_latest_jobs_callback',
		)
	);
}

function lf_latest_jobs_callback( $attributes ) { // phpcs:ignore
	$quantity = isset( $attributes['quantity'] ) ? intval( $attributes['quantity'] ) : 4;
	$items    = lf_latest_jobs_get_external( $quantity );

	if ( empty( $items ) ) {
		return;
	}

	ob_start();

	?>
	<div class="jobs-box grey-title-box">
		<h3 class="sub-head">
			<svg viewBox="0 -31 512 512">
				<path d="M497.094 60.004c-.031 0-.063-.004-.094-.004H361V45c0-24.813-20.188-45-45-45H196c-24.813 0-45 20.188-45 45v15H15C6.648 60 0 66.844 0 75v330c0 24.813 20.188 45 45 45h422c24.813 0 45-20.188 45-45V75.316v-.058c-.574-9.852-6.633-15.2-14.906-15.254zM181 45c0-8.27 6.73-15 15-15h120c8.27 0 15 6.73 15 15v15H181zm295.188 45l-46.583 139.742A14.975 14.975 0 0 1 415.38 240H331v-15c0-8.285-6.715-15-15-15H196c-8.285 0-15 6.715-15 15v15H96.621a14.975 14.975 0 0 1-14.226-10.258L35.813 90zM301 240v30h-90v-30zm181 165c0 8.27-6.73 15-15 15H45c-8.27 0-15-6.73-15-15V167.434l23.934 71.796A44.935 44.935 0 0 0 96.62 270H181v15c0 8.285 6.715 15 15 15h120c8.285 0 15-6.715 15-15v-15h84.379a44.935 44.935 0 0 0 42.687-30.77L482 167.434zm0 0"/>
			</svg>
			Latest Jobs
		</h3>
		<div class="grey-box-content">
			<ul>
				<?php
				foreach ( $items as $item ) :
					$link      = $item->link;
					$enclosure = $item->enclosure;

					if ( $enclosure ) :
						$image = $item->enclosure->{ '@attributes' }->url;
						$image = preg_replace( '/^http:/i', 'https:', $image );
					else :
						$image = plugin_dir_url( __FILE__ ) . 'block/images/jobs-fallback.png';
					endif;

					$title        = $item->title;
					$location     = lf_latest_jobs_extract_text( $title, 'location' );
					$company      = lf_latest_jobs_extract_text( $title );
					$company_trim = mb_strimwidth( $company, 0, 38, '...' );
					$title        = explode( 'at ', $title );
					$title        = $title[0];
					?>
					<li>
						<a href="<?php echo esc_url( $link ); ?>" target="_blank" class="job-image">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>"/>
						</a>
						<div class="job-content">
							<a href="<?php echo esc_url( $link ); ?>" target="_blank" class="job-title">
								<?php echo esc_html( $title ); ?>
								<p>
									<span class="job-company"><i class="text-muted fa fa-building"></i><?php echo esc_html( $company_trim ); ?></span>
									<span class="job-location"><i class="text-muted fa fa-map-marker"></i><?php echo esc_html( $location ); ?></span>
								</p>
							</a>
						</div>
					</li>
					<?php
				endforeach;
				?>
			</ul>
			<a href="https://jobs.cncf.io/" class="btn pink-btn" target="_blank">CNCF Job Board</a>
		</div>
	</div>
	<?php

	return ob_get_clean();
}

function lf_latest_jobs_extract_text( $title, $type = 'company' ) { // phpcs:ignore
	$company = explode( 'at ', $title, 2 );
	$company = $company[1];
	$company = explode( ' (', $company );

	if ( 'company' === $type ) {
		return $company[0];
	}

	$location = '(' . $company[1];
	$location = preg_match( '#\((.*?)\)#', $location, $match );
	$location = $match[1];

	return $location;
}

function lf_latest_jobs_get_external( $quantity = 4 ) { // phpcs:ignore
	$transient_name = "jobs_response_{$quantity}";
	$items          = get_transient( $transient_name );

	if ( ! empty( $items ) ) {
		return $items;
	}

	$jobs = wp_remote_get( 'https://jobs.cncf.io/jobs.rss' );

	if ( ! is_wp_error( $jobs ) && is_array( $jobs ) && intval( $jobs['response']['code'] ) === 200 ) {

		$body            = $jobs['body'];
		$jobs_simple_xml = simplexml_load_string( $body );

		if ( $jobs_simple_xml ) {
			$jobs_json = json_encode( $jobs_simple_xml->channel );
			$jobs_json = json_decode( $jobs_json );
			$items     = $jobs_json->item;
			$items     = array_slice( $items, 0, $quantity );
			set_transient( $transient_name, $items, HOUR_IN_SECONDS );
		}
	}

	return $items;
}

// Hook: Block assets.
add_action( 'init', 'lf_latest_jobs_block_assets' );
