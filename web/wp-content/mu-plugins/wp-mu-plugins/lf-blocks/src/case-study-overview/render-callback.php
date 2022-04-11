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

	$case_study_description = get_post_meta( get_the_ID(), 'lf_case_study_long_title', true );

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
		$projects_used     = '使用的项目';
		$url_type          = '-cn';

		$company_logo     = get_post_meta( get_the_ID(), 'lf_case_study_cn_company_logo', true );
		$long_description = get_post_meta( get_the_ID(), 'lf_case_study_cn_long_title', true );

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
		$projects_used     = 'Projects used';
		$url_type          = '';

		$company_logo     = get_post_meta( get_the_ID(), 'lf_case_study_company_logo', true );
		$long_description = get_post_meta( get_the_ID(), 'lf_case_study_long_title', true );
	}

	$projects = get_the_terms( get_the_ID(), 'lf-project' );

	ob_start();
	?>
<section
	class="wp-block-lf-case-study-overview <?php echo esc_html( $classes ); ?>">

	<div class="case-study-overview">

		<!-- column 1 -->
		<div class="case-study-overview__intro">

			<h2 class="is-style-opening-paragraph">
				<?php echo esc_html( $long_description ); ?></h2>

			<?php echo $content; //phpcs:ignore ?>

		</div>

		<!-- column 2 -->
		<div class="case-study-overview__meta">

			<!-- logo -->
			<?php
			if ( $company_logo ) {
				LF_Utils::display_responsive_images( $company_logo, 'spotlight-320', '200px', 'case-study-overview__logo' );
			} else {
				// Insert spacer to maintain layout.
				?>
				<div style="height:5px" aria-hidden="true"
				class="wp-block-spacer case-study-overview__logo"></div>
				<?php
			}
			?>

			<div class="case-study-overview__taxonomies">
				<?php

				if ( ! empty( $challenges ) && ! is_wp_error( $challenges ) ) :

					$number_of_items = count( $challenges );
					$i               = 0;
					?>
				<div class="row">
					<div class="col1">
						<?php echo esc_html( $challenge_text ); ?>:</div>
					<div class="col2">
						<?php foreach ( $challenges as $challenge ) { ?>
							<?php
							if ( ++$i < $number_of_items ) {
								$comma = ', ';
							} else {
								$comma = '';
							}
							?>
						<a title="See more case studies with a <?php echo esc_attr( $challenge->name ); ?> challenge"
							href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-challenge<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $challenge->slug ); ?>"><?php echo esc_html( $challenge->name ); ?></a><?php echo esc_html( $comma ); ?>
							<?php
						}
						?>
					</div>
				</div>
					<?php
endif;

				if ( ! empty( $industries ) && ! is_wp_error( $industries ) ) :

					$number_of_items = count( $industries );
					$i               = 0;
					?>
				<div class="row">
					<div class="col1"><?php echo esc_html( $industry_text ); ?>:
					</div>
					<div class="col2">
						<?php foreach ( $industries as $industry ) { ?>
							<?php
							if ( ++$i < $number_of_items ) {
								$comma = ', ';
							} else {
								$comma = '';
							}
							?>
						<a title="See more case studies from <?php echo esc_attr( $industry->name ); ?>"
							href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-industry<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $industry->slug ); ?>"><?php echo esc_html( $industry->name ); ?></a><?php echo esc_html( $comma ); ?>
							<?php
						}
						?>
					</div>
				</div>
					<?php
endif;

				if ( ! empty( $location ) && ! is_wp_error( $location ) ) :
					?>

				<div class="row">
					<div class="col1"><?php echo esc_html( $location_text ); ?>:
					</div>
					<div class="col2">
						<a title="See more case studies from <?php echo esc_attr( $location ); ?>"
							href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-country<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $location_slug ); ?>"><?php echo esc_html( $location ); ?></a>
					</div>
				</div>
					<?php
endif;

				if ( ! empty( $cloud_types ) && ! is_wp_error( $cloud_types ) ) :

					$number_of_items = count( $cloud_types );
					$i               = 0;
					?>
				<div class="row">
					<div class="col1">
						<?php echo esc_html( $cloud_type_text ); ?>:</div>
					<div class="col2">
						<?php foreach ( $cloud_types as $cloud_type ) { ?>
							<?php
							if ( ++$i < $number_of_items ) {
								$comma = ', ';
							} else {
								$comma = '';
							}
							?>
						<a title="See more case studies with a <?php echo esc_attr( $cloud_type->name ); ?> cloud type"
							href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-cloud-type<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $cloud_type->slug ); ?>"><?php echo esc_html( $cloud_type->name ); ?></a><?php echo esc_html( $comma ); ?>
							<?php
						}
						?>
					</div>
				</div>
					<?php
endif;

				if ( ! empty( $product_type ) && ! is_wp_error( $product_type ) ) :
					?>
				<div class="row">
					<div class="col1">
						<?php echo esc_html( $product_type_text ); ?>:</div>
					<div class="col2">
						<a title="See more case studies with <?php echo esc_attr( $product_type ); ?> product type"
							href="/case-studies<?php echo esc_attr( $url_type ); ?>?_sft_lf-product-type<?php echo esc_attr( $url_type ); ?>=<?php echo esc_attr( $product_type_slug ); ?>"><?php echo esc_html( $product_type ); ?></a>
					</div>
				</div>
					<?php
endif;
				?>
				<div class="row">
					<div class="col1">
						<?php echo esc_html( $date_published ); ?>:</div>
					<div class="col2"><?php the_date(); ?></div>
				</div>
			</div>

			<!-- Project area  -->
			<?php if ( ! empty( $projects ) && ! is_wp_error( $projects ) ) { ?>
			<div class="case-study-overview__projects">

				<p
					class="is-style-spaced-uppercase"><?php echo esc_html( $projects_used ); ?></p>

				<div class="case-study-overview__project-icons">
					<?php
					foreach ( $projects as $project ) {
						?>
					<div class="case-study-overview__project-icon">
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

		</div>
	</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
