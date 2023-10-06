<?php
/**
 * Shopify Products
 *
 * Displays items from a collection
 *
 * Usage:
 * [shopify_products]
 * [shopify_products project="tag-security" count=4]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Shopify Products shortcode.
 *
 * @param array $atts Attributes.
 */
function add_shopify_products_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count'   => 3, // set default.
			'project' => 'cncf', // set default.
			'title'   => '',
		),
		$atts,
		'shopify_products'
	);

	$shopify_url     = 'https://cncf-merchandise-store.myshopify.com';
	$endpoint        = $shopify_url . '/api/2022-01/graphql.json';
	$store_url       = 'https://store.cncf.io';
	$gift_card_title = 'Gift Card';

	$site_options = get_option( 'lf-mu' );
	if ( isset( $site_options['shopify_api_key'] ) && $site_options['shopify_api_key'] ) {
		$storefront_api_token = $site_options['shopify_api_key'];
	} else {
		if ( current_user_can( 'edit_posts' ) ) {
			echo 'Requires Shopify API token to be set in Settings.';
			return;
		}
	}

	$count           = intval( $atts['count'] );
	$collection_slug = trim( $atts['project'] );
	$title           = $atts['title'] ?? '';
	$section_title   = $title ? $title : get_the_title();

	if ( ! is_int( $count ) || ! $storefront_api_token ) {
		return;
	}

	$args = array(
		'headers' => array(
			'Content-Type'                      => 'application/json',
			'X-Shopify-Storefront-Access-Token' => $storefront_api_token,
		),
		'body'    => wp_json_encode(
			array(
				'query' => '
			{
				collectionByHandle(handle: "' . $collection_slug . '") {
					products(first: ' . $count . ') {
						edges {
							node {
								title
								handle
								availableForSale
								featuredImage {
									originalSrc
									small: transformedSrc(maxWidth: 480, scale: 1)
									medium: transformedSrc(maxWidth: 768, scale: 1)
									large: transformedSrc(maxWidth: 1024, scale: 1)
								}
								variants(first: 1) {
									edges {
										node {
											priceV2 {
												amount
											}
										}
									}
								}
							}
						}
					}
				}
			}
			',
			)
		),
	);

	$response = wp_remote_post( $endpoint, $args );

	if ( is_wp_error( $response ) ) {
		error_log( $response->get_error_message() ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return;
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( ! isset( $data['data']['collectionByHandle'] ) || null === $data['data']['collectionByHandle'] ) {
		error_log( 'Collection not found or an error occurred.' ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		return;
	}

	$products = $data['data']['collectionByHandle']['products']['edges'] ?? '';

	if ( ! $products || empty( $products ) ) {
		return;
	}

	$actual_products = array_filter(
		$products,
		function( $product ) use ( $gift_card_title ) {
			return $product['node']['title'] !== $gift_card_title && $product['node']['availableForSale'];
		}
	);

	// If only Gift Card is available or no products available, return.
	if ( empty( $actual_products ) ) {
		return;
	}

	ob_start();
	?>
<section class="shopify-products">
	<!-- see all  -->
	<div class="wp-block-group is-style-no-padding is-style-see-all">
		<div class="wp-block-columns are-vertically-aligned-bottom">
			<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:70%">
				<h3 class="is-style-section-heading"><?php echo esc_html( $section_title ); ?> in CNCF Store</h3>
			</div>
			<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:30%">
				<p
					class="has-text-align-right is-style-link-cta"><a href="<?php echo esc_url( 'https://store.cncf.io/collections/' . $collection_slug ); ?>">More Products</a></p>
			</div>
		</div>

		<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

		<div class="products columns-four">

			<?php
			foreach ( $actual_products as $product ) :

					$product_slug  = $product['node']['handle'] ?? '';
					$product_link  = $store_url . '/products/' . $product_slug;
					$product_title = $product['node']['title'] ?? '';
					$price_amount  = $product['node']['variants']['edges'][0]['node']['priceV2']['amount'] ?? '';
					$product_price = $price_amount ? '$' . number_format( $price_amount, 2, '.', '' ) : '';
					$img_original  = $product['node']['featuredImage']['originalSrc'];
					$img_480       = $product['node']['featuredImage']['small'];
					$img_768       = $product['node']['featuredImage']['medium'];
					$img_1024      = $product['node']['featuredImage']['large'];
				?>
			<div class="product-item has-animation-scale-2">
				<a href="<?php echo esc_url( $product_link ); ?>" class="product-item__link" title="Buy <?php echo esc_attr( $product_title ); ?> in CNCF Store">
					<div class="product-item__image">
					<img src="<?php echo esc_url( $img_original ); ?>"
						srcset="<?php echo esc_url( $img_480 ); ?> 480w, <?php echo esc_url( $img_768 ); ?> 768w, <?php echo esc_url( $img_1024 ); ?> 1024w"
						sizes="(max-width: 480px) 480px, (max-width: 768px) 768px, 1024px" width="388" height="204" loading="lazy"
						decoding="async"
						alt="<?php echo esc_attr( $product_title ); ?>">
					</div>
					<h3 class="product-item__title">
						<?php echo esc_html( $product_title ); ?></h3>
				</a>
				<span class="product-item__price"><?php echo esc_html( $product_price ); ?></span>
			</div>
					<?php
			endforeach;
			?>
	</div>
</div>
<div style="height:80px;" aria-hidden="true" class="wp-block-spacer is-style-40-80"></div>
</section>
		<?php
		$block_content = ob_get_clean();
		return $block_content;
}
	add_shortcode( 'shopify_products', 'add_shopify_products_shortcode' );
