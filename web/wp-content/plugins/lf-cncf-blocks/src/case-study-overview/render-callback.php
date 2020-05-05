<?php
/**
 * Render Callback
 *
 * @package WordPress
 * @subpackage cncf-blocks
 * @since 1.0.0
 */

/**
 * Render the block
 *
 * @param array $attributes Block attributes.
 * @return object block_content Output.
 */
function lf_case_study_overview_render_callback( $attributes ) {
	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// not on a case study page.
	if ( ! is_singular( array( 'cncf_case_study', 'cncf_case_study_ch' ) ) ) {
		return;
	}

	if ( is_singular( 'cncf_case_study_ch' ) ) {
		// get chinese content.
		$industry = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-industry-ch' );

		$location = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-country-ch' );

		$cloud_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-cloud-type-ch' );

		$product_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-product-type-ch' );

		$challenge = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-challenge-ch' );

		$industry_text     = '行业';
		$location_text     = '地点';
		$cloud_type_text   = '云类型';
		$product_type_text = '产品类型';
		$challenge_text    = '挑战';

	} else {
		// get english content.
		$industry = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-industry' );

		$location = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-country' );

		$cloud_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-cloud-type' );

		$product_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-product-type' );

		$challenge = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-challenge' );

		$industry_text     = 'Industry';
		$location_text     = 'Location';
		$cloud_type_text   = 'Cloud Type';
		$product_type_text = 'Product Type';
		$challenge_text    = 'Challenge';
	}

	ob_start();
	?>
<section class="wp-block-lf-case-study-overview <?php echo esc_html( $classes ); ?>">

<div class="case-study-overview alignwide">
				<div class="container case-study-overview-wrapper">

				<?php if ( ! empty( $industry ) && ! is_wp_error( $industry ) ) : ?>
					<div>
						<span class="skew-box smaller"><?php echo esc_html( $industry_text ); ?></span>
						<p><?php echo esc_html( $industry ); ?></p>
					</div>
					<?php
				endif;

				if ( ! empty( $location ) && ! is_wp_error( $location ) ) :
					?>
					<div>
						<span class="skew-box smaller"><?php echo esc_html( $location_text ); ?></span>
						<p><?php echo esc_html( $location ); ?></p>
					</div>
					<?php
					endif;

				if ( ! empty( $cloud_type ) && ! is_wp_error( $cloud_type ) ) :
					?>
					<div>
						<span class="skew-box smaller"><?php echo esc_html( $cloud_type_text ); ?></span>
						<p><?php echo esc_html( $cloud_type ); ?></p>
					</div>
					<?php
					endif;

				if ( ! empty( $product_type ) && ! is_wp_error( $product_type ) ) :
					?>
					<div>
						<span class="skew-box smaller"><?php echo esc_html( $product_type_text ); ?></span>
						<p><?php echo esc_html( $product_type ); ?></p>
					</div>
					<?php
					endif;

				if ( ! empty( $challenge ) && ! is_wp_error( $challenge ) ) :
					?>
					<div>
						<span class="skew-box smaller"><?php echo esc_html( $challenge_text ); ?></span>
						<p><?php echo esc_html( $challenge ); ?></p>
					</div>
<?php endif; ?>
				</div>
			</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
