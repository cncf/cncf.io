<?php
/**
 * Title Links
 *
 * One file to control all the different taxonomy/parent links.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

if ( is_singular( 'lf_webinar' ) ) :
	?>
<span>
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/online-programs/"
		title="Go to online programs">Online program</a>
</span>

	<?php
elseif ( is_singular( 'lf_spotlight' ) ) :
	?>
<span>
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/spotlights/"
		title="Go to Spotlights">Spotlight</a>
</span>
	<?php
	// get spotlight type.
	$spotlight_type      = Lf_Utils::get_term_names( get_the_ID(), 'lf-spotlight-type', true );
	$spotlight_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-spotlight-type', true );
	$spotlight_type_link = '/spotlights/?_sft_lf-spotlight-type=' . $spotlight_type_slug;

	?>
<div class="space-slash">&nbsp;/&nbsp;</div>
<span><a class="author-category"
		title="See <?php echo esc_attr( $spotlight_type ); ?> posts"
		href="<?php echo esc_url( $spotlight_type_link ); ?>">
		<?php echo esc_html( $spotlight_type ); ?>
	</a></span>

	<?php
	elseif ( is_archive() || is_search() || is_category() ) :
		?>
	<!-- display nothing -->
		<?php
elseif ( is_tag() || is_tax() ) :
	// Single Post.
	$all_categories = get_the_category();

	if ( $all_categories ) {
		// Only get the first item in the array.
		$category = array_shift( $all_categories );
		?>
<span>
	<a class="parent-link"
		href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
		title="See <?php echo esc_html( $category->name ); ?> posts"><?php echo esc_html( $category->name ); ?></a>
</span>
		<?php
	};
	?>
	<?php
elseif ( is_singular( 'lf_project' ) ) :
	// Check for Sandbox Projects page.
	if ( get_the_ID() && ( Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true ) == 'Sandbox' ) ) {
		?>
<span><a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/sandbox-projects/"
		title="Go to Sandbox Projects">Projects</a></span>
		<?php
	} else {
		?>
<span>
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/projects/"
		title="Go to Graduated and Incubating Projects">Projects</a>
</span>
		<?php
	}
elseif ( is_singular( 'lf_kubeweekly' ) ) :
	?>
<span><a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/kubeweekly/"
		title="See all Kubeweeklys">Kubeweekly</a></span>
		<?php
elseif ( is_singular( 'lf_report' ) ) :
	?>
<span><a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/reports/"
		title="See all Reports">Report</a></span>

	<?php

	$report_type = Lf_Utils::get_term_names( get_the_ID(), 'lf-report-type', true );

	$report_type_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-report-type', true );

	if ( $report_type && $report_type_slug ) {
		$report_type_link = get_home_url() . '/reports/?_sft_lf-report-type=' . $report_type_slug;
		?>
<div class="space-slash">&nbsp;/&nbsp;</div>
<a class="parent-link"
	title="See more <?php echo esc_attr( $report_type ); ?> reports"
	href="<?php echo esc_url( $report_type_link ); ?>">
		<?php echo esc_html( $report_type ); ?></a>
		<?php
	}
	?>
	<?php
else :
	// Single Post.
	$all_categories = get_the_category();
	if ( $all_categories ) {
		// Only get the first item in the array.
		$category = array_shift( $all_categories );
		?>
<span>
	<a class="parent-link"
		href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
		title="See <?php echo esc_html( $category->name ); ?> posts"><?php echo esc_html( $category->name ); ?></a>
</span>
		<?php
	}
	// Get the Category Author.
	$category_author      = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );
	$category_author_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );
	if ( $category_author ) {
		$category_link = get_home_url() . '/lf-author-category/' . $category_author_slug . '/';
		?>
<div class="space-slash">&nbsp;/&nbsp;</div>
<span><a class="author-category"
		title="See <?php echo esc_attr( $category_author ); ?> posts"
		href="<?php echo esc_url( $category_link ); ?>">
		<?php echo esc_html( $category_author ) . ' Post'; ?>
	</a></span>
		<?php
	}

endif;
