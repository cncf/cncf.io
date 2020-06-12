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
 * @param array  $attributes Block attributes.
 * @param string $content Block content.
 * @return object block_content Output.
 */
function lf_case_study_overview_render_callback( $attributes, $content ) {

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	// not on a case study page.
	if ( ! is_singular( array( 'cncf_case_study', 'cncf_case_study_ch' ) ) ) {
		return;
	}

	if ( is_singular( 'cncf_case_study_ch' ) ) {
		// get chinese content.
		$industries = get_the_terms( get_the_ID(), 'cncf-industry-ch' );

		$location = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-country-ch' );

		$cloud_types = get_the_terms( get_the_ID(), 'cncf-cloud-type-ch' );

		$product_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-product-type-ch' );

		$challenges = get_the_terms( get_the_ID(), 'cncf-challenge-ch' );

		$company_text      = '公司';
		$industry_text     = '行业';
		$location_text     = '地点';
		$cloud_type_text   = '云类型';
		$product_type_text = '产品类型';
		$challenge_text    = '挑战';
		$date_published    = '出版';

	} else {

		// get english content.
		$industries = get_the_terms( get_the_ID(), 'cncf-industry' );

		$location = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-country' );

		$cloud_types = get_the_terms( get_the_ID(), 'cncf-cloud-type' );

		$product_type = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-product-type' );

		$challenges = get_the_terms( get_the_ID(), 'cncf-challenge' );

		$company_text      = 'Company';
		$industry_text     = 'Industry';
		$location_text     = 'Location';
		$cloud_type_text   = 'Cloud Type';
		$product_type_text = 'Product Type';
		$challenge_text    = 'Challenges';
		$date_published    = 'Published';
	}

	ob_start();
	?>
<section
	class="wp-block-lf-case-study-overview <?php echo esc_html( $classes ); ?>">

	<div class="case-study-overview">

		<div className="case-study-intro-wrapper">
		<?php echo wp_kses_post( $content ); ?>
		</div>

		<div class=" case-study-overview-wrapper">

		<div>
				<p><?php echo esc_html( $company_text ); ?></p>
				<span
					class="skew-box secondary"><?php the_title(); ?></span>
			</div>

			<?php
			if ( ! empty( $challenges ) && ! is_wp_error( $challenges ) ) :
				?>
			<div>
				<p><?php echo esc_html( $challenge_text ); ?></p>
				<?php foreach ( $challenges as $challenge ) { ?>
				<span
					class="skew-box secondary"><?php echo esc_html( $challenge->name ); ?></span>
				<?php } ?>
			</div>
				<?php
			endif;

			if ( ! empty( $industries ) && ! is_wp_error( $industries ) ) :
				?>
			<div>
				<p><?php echo esc_html( $industry_text ); ?></p>
				<?php foreach ( $industries as $industry ) { ?>
				<span
					class="skew-box secondary"><?php echo esc_html( $industry->name ); ?></span>
				<?php } ?>
			</div>
				<?php
				endif;

			if ( ! empty( $location ) && ! is_wp_error( $location ) ) :
				?>
			<div>
				<p><?php echo esc_html( $location_text ); ?></p>
				<span
					class="skew-box secondary"><?php echo esc_html( $location ); ?></span>
			</div>
				<?php
					endif;

			if ( ! empty( $cloud_types ) && ! is_wp_error( $cloud_types ) ) :
				?>
			<div>
				<p><?php echo esc_html( $cloud_type_text ); ?></p>
				<?php foreach ( $cloud_types as $cloud_type ) { ?>
				<span
					class="skew-box secondary"><?php echo esc_html( $cloud_type->name ); ?></span>
				<?php } ?>
			</div>
				<?php
					endif;

			if ( ! empty( $product_type ) && ! is_wp_error( $product_type ) ) :
				?>
			<div>
				<p><?php echo esc_html( $product_type_text ); ?></p>
				<span
					class="skew-box secondary"><?php echo esc_html( $product_type ); ?></span>
			</div>
				<?php
					endif;
			?>
			<div>
				<p><?php echo esc_html( $date_published ); ?></p>
				<span
					class="skew-box secondary"><?php the_date(); ?></span>
			</div>

		</div>
	</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
