<?php
/**
 * @param $custom_types
 * @return array
 */
function pmxi_pmxi_custom_types($custom_types) {
    if ( class_exists('WooCommerce') ) {
        $custom_types['woo_reviews'] = new stdClass();
        $custom_types['woo_reviews']->labels = new stdClass();
        $custom_types['woo_reviews']->labels->name = __('WooCommerce Reviews', PMXI_Plugin::LANGUAGE_DOMAIN);
    }
	if ( class_exists('WooCommerce') && ! class_exists('PMWI_Plugin') ) {
		if ( ! empty($custom_types['product']) ) $custom_types['product']->labels->name = __('WooCommerce Products','wp_all_import_plugin');
		if ( ! empty($custom_types['shop_order']) ) $custom_types['shop_order']->labels->name = __('WooCommerce Orders','wp_all_import_plugin');
		if ( ! empty($custom_types['shop_coupon']) ) $custom_types['shop_coupon']->labels->name = __('WooCommerce Coupons','wp_all_import_plugin');
		if ( ! empty($custom_types['product_variation']) ) unset($custom_types['product_variation']);
		if ( ! empty($custom_types['shop_order_refund']) ) unset($custom_types['shop_order_refund']);

		$order = [ 'shop_order', 'shop_coupon', 'product' ];
		$ordered_custom_types = [];
		foreach ($order as $type) {
			if (isset($ordered_custom_types[$type])) continue;
			foreach ($custom_types as $key => $custom_type) {
				if (isset($ordered_custom_types[$key])) continue;
				if (in_array($key, $order)) {
					if ($key == $type) {
						$ordered_custom_types[$key] = $custom_type;
					}
				} else {
					$ordered_custom_types[$key] = $custom_type;
				}
			}			
		}
        return $ordered_custom_types;
	}
	return $custom_types;
}
