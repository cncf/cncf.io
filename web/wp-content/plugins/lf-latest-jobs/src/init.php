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


	wp_register_style(
		'lf-latest-jobs-block-style',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		is_admin() ? array( 'wp-editor' ) : null,
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
	);

	wp_register_style(
		'lf-latest-jobs-block-editor',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
	);

	wp_register_script(
		'lf-latest-jobs-block',
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
		filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
		true
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
	$classes  = isset( $attributes['className'] ) ? $attributes['className'] : '';
	if ( empty( $items ) ) {
		return;
	}
	ob_start();

	?>
<div class="wp-block-lf-latest-jobs <?php echo esc_html( $classes ); ?>">

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
				$title        = mb_strimwidth( $title[0], 0, 50, '...' );
				?>
		<li>
			<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"
				class="job-image"
				title="<?php echo esc_html( $title ) . 'at ' . esc_html( $company ); ?>">
				<img src="<?php echo esc_url( $image ); ?>"
					alt="<?php echo esc_attr( $title ); ?>" />
			</a>

			<div class="job-content">
				<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"
					title="<?php echo esc_html( $title ) . 'at ' . esc_html( $company ); ?>"><?php echo esc_html( $title ); ?></a>

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
			</div>
		</li>
		<?php endforeach; ?>
	</ul>
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
