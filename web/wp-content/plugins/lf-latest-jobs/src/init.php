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
function lf_latest_jobs_block_assets() {
	wp_register_script(
		'lf-latest-jobs-block',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
		true
	);

	wp_register_style(
		'lf-latest-jobs-block-style',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array(),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
	);

	wp_register_style(
		'lf-latest-jobs-block-editor',
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
			'style'           => 'lf-latest-jobs-block-style',
			'editor_script'   => 'lf-latest-jobs-block',
			'editor_style'    => 'lf-latest-jobs-block-editor',
			'render_callback' => 'lf_latest_jobs_callback',
		)
	);
}
add_action( 'init', 'lf_latest_jobs_block_assets' );


/**
 * Render the block
 *
 * @param array $attributes Block attributes.
 *
 * @return object Output.
 */
function lf_latest_jobs_callback( $attributes ) {
	$quantity = isset( $attributes['quantity'] ) ? intval( $attributes['quantity'] ) : 4;
	$items    = lf_latest_jobs_get_external( $quantity );
$classes = isset($attributes['className']) ? $attributes['className'] : "";
	if ( empty( $items ) ) {
		return;
	}
	ob_start();

	?>
<div class="jobs-box <?php echo esc_html($classes); ?>">
	<!-- <h3 class="sub-head">
		<svg viewBox="0 -31 512 512">
			<path
				d="M497.094 60.004c-.031 0-.063-.004-.094-.004H361V45c0-24.813-20.188-45-45-45H196c-24.813 0-45 20.188-45 45v15H15C6.648 60 0 66.844 0 75v330c0 24.813 20.188 45 45 45h422c24.813 0 45-20.188 45-45V75.258c-.574-9.852-6.633-15.2-14.906-15.254zM181 45c0-8.27 6.73-15 15-15h120c8.27 0 15 6.73 15 15v15H181zm295.188 45l-46.583 139.742A14.975 14.975 0 01415.38 240H331v-15c0-8.285-6.715-15-15-15H196c-8.285 0-15 6.715-15 15v15H96.621a14.975 14.975 0 01-14.226-10.258L35.813 90zM301 240v30h-90v-30zm181 165c0 8.27-6.73 15-15 15H45c-8.27 0-15-6.73-15-15V167.434l23.934 71.796A44.935 44.935 0 0096.62 270H181v15c0 8.285 6.715 15 15 15h120c8.285 0 15-6.715 15-15v-15h84.379a44.935 44.935 0 0042.687-30.77L482 167.434zm0 0" />
		</svg>
		Latest Jobs
	</h3> -->
	<div class="grey-box-content">
		<ul class="jobs-list">
			<?php
			foreach ( $items as $item ) :
				if ( isset( $item->link ) ) {
					$link = $item->link;
				}
				if ( isset( $item->enclosure ) ) :
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
				<a href="<?php echo esc_url( $link ); ?>" target="_blank"
					class="job-image"
					title="<?php echo esc_html( $title ) . 'at ' . esc_html( $company ); ?>">
					<img src="<?php echo esc_url( $image ); ?>"
						alt="<?php echo esc_attr( $title ); ?>" />
				</a>
				<div class="job-content">
					<a href="<?php echo esc_url( $link ); ?>" target="_blank"
						class="job-title"
						title="<?php echo esc_html( $title ) . 'at ' . esc_html( $company ); ?>">
						<?php echo esc_html( $title ); ?>
						<p>
							<span class="job-company">
								<svg viewBox="0 0 448 512">
									<path
										d="M436 480h-20V24c0-13.255-10.745-24-24-24H56C42.745 0 32 10.745 32 24v456H12c-6.627 0-12 5.373-12 12v20h448v-20c0-6.627-5.373-12-12-12zM128 76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76zm0 96c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40zm52 148h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12zm76 160h-64v-84c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v84zm64-172c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40z" />
								</svg>
								<?php echo esc_html( $company_trim ); ?>
							</span>
							<span class="job-location">
								<svg viewBox="0 0 384 512">
									<path
										d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z" />
								</svg>
								<?php echo esc_html( $location ); ?>
							</span>
						</p>
					</a>
				</div>
			</li>
			<?php
				endforeach;
			?>
		</ul>
		<!-- <a href="https://jobs.cncf.io/" class="btn pink-btn" target="_blank"
			title="CNCF Job Board">CNCF Job Board</a> -->
	</div>
</div>
<?php
	return ob_get_clean();
}

/**
 * Utility function to extract job title, company and location from string
 *
 * @param string $title Job title.
 * @param string $type Company.
 *
 * @return string $location Location of job.
 */
function lf_latest_jobs_extract_text( $title, $type = 'company' ) {
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

/**
 * Utility function to grab a number of posts from the RSS feed.
 *
 * @param integer $quantity Number of posts, default 4.
 *
 * @return array $items Return jobs to display.
 */
function lf_latest_jobs_get_external( $quantity = 4 ) {
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
