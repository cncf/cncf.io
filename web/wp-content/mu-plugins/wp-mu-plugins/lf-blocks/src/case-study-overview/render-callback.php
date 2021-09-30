<?php
/**
 * Render Callback
 *
 * @package WordPress
 * @subpackage lf-blocks
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

	// not on a case study page.
	if ( ! is_singular( array( 'lf_case_study', 'lf_case_study_cn' ) ) ) {
		return;
	}

	// get the classes set from the block if any.
	$classes = isset( $attributes['className'] ) ? $attributes['className'] : '';

	if ( is_singular( 'lf_case_study_cn' ) ) {
		// get chinese content.
		$industries = get_the_terms( get_the_ID(), 'lf-industry-cn' );
		foreach ( $industries as $industry ) {
			$industry->name = preg_replace( '/(.+)(\(\D+\))/', '$1', $industry->name );
		}

		$location      = preg_replace( '/(.+)(\(\D+\))/', '$1', Lf_Utils::get_term_names( get_the_ID(), 'lf-country-cn', true ) );
		$location_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-country-cn', true );

		$cloud_types = get_the_terms( get_the_ID(), 'lf-cloud-type-cn' );
		foreach ( $cloud_types as $cloud_type ) {
			$cloud_type->name = preg_replace( '/(.+)(\(\D+\))/', '$1', $cloud_type->name );
		}

		$product_type      = preg_replace( '/(.+)(\(\D+\))/', '$1', Lf_Utils::get_term_names( get_the_ID(), 'lf-product-type-cn', true ) );
		$product_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-product-type-cn', true );

		$challenges = get_the_terms( get_the_ID(), 'lf-challenge-cn' );
		foreach ( $challenges as $challenge ) {
			$challenge->name = preg_replace( '/(.+)(\(\D+\))/', '$1', $challenge->name );
		}

		$organisation_text = '组织';
		$industry_text     = '行业';
		$location_text     = '地点';
		$cloud_type_text   = '云类型';
		$product_type_text = '产品类型';
		$challenge_text    = '挑战';
		$date_published    = '出版';

		$url_type = '-cn';

		$company_logo = get_post_meta( get_the_ID(), 'lf_case_study_cn_company_logo', true );

	} else {

		// get english content.
		$industries = get_the_terms( get_the_ID(), 'lf-industry' );

		$location      = Lf_Utils::get_term_names( get_the_ID(), 'lf-country', true );
		$location_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-country', true );

		$cloud_types = get_the_terms( get_the_ID(), 'lf-cloud-type' );

		$product_type      = Lf_Utils::get_term_names( get_the_ID(), 'lf-product-type', true );
		$product_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-product-type', true );

		$challenges = get_the_terms( get_the_ID(), 'lf-challenge' );

		$organisation_text = 'Organization';
		$industry_text     = 'Industry';
		$location_text     = 'Location';
		$cloud_type_text   = 'Cloud Type';
		$product_type_text = 'Product Type';
		$challenge_text    = 'Challenges';
		$date_published    = 'Published';

		$url_type = '';

		$company_logo = get_post_meta( get_the_ID(), 'lf_case_study_company_logo', true );

	}

	$projects = get_the_terms( get_the_ID(), 'lf-project' );

	ob_start();
	?>
<section
	class="wp-block-lf-case-study-overview <?php echo esc_html( $classes ); ?>">

	<div class="case-study-overview">

		<!-- column 1 -->
		<div class="case-study-intro-wrapper">
			<?php echo $content; //phpcs:ignore. ?>
		</div>

		<!-- column 2 -->
		<div class="case-study-overview-wrapper">

			<!-- organisation block -->
			<div>
	<?php
	if ( $company_logo ) {
		LF_Utils::display_responsive_images( $company_logo, 'spotlight-320', '200px', 'case-study-company-logo' );
	} else {
		?>
		<p><span class="strong"><?php echo esc_html( $organisation_text ); ?>:</span> <?php the_title(); ?></p>
		<?php
	}

	if ( ! empty( $challenges ) && ! is_wp_error( $challenges ) ) :

		$number_of_items = count( $challenges );
		$i = 0;
		?>
				<p><span class="strong"><?php echo esc_html( $challenge_text ); ?>:</span>
				<?php foreach ( $challenges as $challenge ) { ?>
				<a
					title="See more case studies with a <?php echo esc_attr( $challenge->name ); ?> challenge"
					href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-challenge<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $challenge->slug ); ?>"><?php echo esc_html( $challenge->name ); ?></a>
												  <?php
													if ( ++$i < $number_of_items ) {
														echo ', ';
													}
				}
				?>
				</p>
				<?php
				endif;

	if ( ! empty( $industries ) && ! is_wp_error( $industries ) ) :

		$number_of_items = count( $industries );
		$i = 0;
		?>
				<p><span class="strong"><?php echo esc_html( $industry_text ); ?>:</span>
				<?php foreach ( $industries as $industry ) { ?>
				<a
					title="See more case studies from <?php echo esc_attr( $industry->name ); ?>"
					href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-industry<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $industry->slug ); ?>"><?php echo esc_html( $industry->name ); ?></a>
												  <?php
													if ( ++$i < $number_of_items ) {
														echo ', ';
													}
				}
				?>
			</p>
				<?php
			endif;

	if ( ! empty( $location ) && ! is_wp_error( $location ) ) :
		?>
				<p><span class="strong"><?php echo esc_html( $location_text ); ?>:</span>
				<a
					title="See more case studies from <?php echo esc_attr( $location ); ?>"
					href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-country<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $location_slug ); ?>"><?php echo esc_html( $location ); ?></a>
</p>
				<?php
endif;

	if ( ! empty( $cloud_types ) && ! is_wp_error( $cloud_types ) ) :

		$number_of_items = count( $cloud_types );
		$i = 0;
		?>
				<p><span class="strong"><?php echo esc_html( $cloud_type_text ); ?>:</span>
				<?php foreach ( $cloud_types as $cloud_type ) { ?>
				<a
					title="See more case studies with a <?php echo esc_attr( $cloud_type->name ); ?> cloud type"
					href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-cloud-type<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $cloud_type->slug ); ?>"><?php echo esc_html( $cloud_type->name ); ?></a>
												  <?php
													if ( ++$i < $number_of_items ) {
														echo ', ';
													}
				}
				?>
</p>
				<?php
endif;

	if ( ! empty( $product_type ) && ! is_wp_error( $product_type ) ) :
		?>
				<p><span class="strong"><?php echo esc_html( $product_type_text ); ?>:</span>
				<a
					title="See more case studies with <?php echo esc_attr( $product_type ); ?> product type"
					href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-product-type<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $product_type_slug ); ?>"><?php echo esc_html( $product_type ); ?></a>
			</p>
				<?php
endif;
	?>
			<p><span class="strong"><?php echo esc_html( $date_published ); ?>:</span> <?php the_date(); ?></p>
			</div>

			<?php if ( ! empty( $projects ) && ! is_wp_error( $projects ) ) { ?>
			<div>
			<h5 class="margin-bottom">
					<?php
					if ( 'lf_case_study_cn' === get_post_type() ) {
						echo '使用的项目';
					} else {
						echo 'Projects used';
					}
					?>
				</h5>

				<div class="case-study-project-icons">
					<?php
					foreach ( $projects as $project ) {
						?>
					<div class="case-study-project-icon">
						<img loading="lazy"
							src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/images/projects/' . esc_html( $project->slug ) . '-icon-color.svg'; ?>"
							alt="<?php echo esc_html( $project->name ); ?>">
					</div>
						<?php
					}
					?>
				</div>
			</div>
				<?php
			}
			?>

<div class="case-study-subscription-block">
			<h5 class="margin-bottom">Stay informed</h5>
<p class="margin-bottom">Get the latest news from our community of doers. Subscribe to the CNCF newsletter.</p>
	<?php echo do_shortcode( '[hubspot type=form portal=8112310 id=afe5f966-bae5-4fce-bd5d-84f7ae89111b]' ); ?>
	<p class="privacy-agreement">See footer for our privacy policy.</p>
			</div>

			</div>
		</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
