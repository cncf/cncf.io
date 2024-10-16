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
<div class="parent-link-align">
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/online-programs/"
		title="Go to online programs">Online program</a>
</div>

	<?php
elseif ( is_singular( 'lf_human' ) ) :
	?>
<div class="parent-link-align">
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/humans-of-cloud-native/"
		title="Go to Humans of Cloud Native">Humans of Cloud Native</a>
</div>
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
<div class="parent-link-align">
	<a class="parent-link"
		href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
		title="See <?php echo esc_html( $category->name ); ?> posts"><?php echo esc_html( $category->name ); ?></a>
</div>
		<?php
	}
	?>
	<?php
elseif ( is_singular( 'lf_project' ) ) :
	// Check for Sandbox Projects page.
	if ( get_the_ID() && ( Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true ) == 'Sandbox' ) ) {
		?>
<div class="parent-link-align">
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/sandbox-projects/"
		title="Go to Sandbox Projects">Projects</a>
</div>
		<?php
	} else {
		?>
<div class="parent-link-align">
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/projects/"
		title="Go to Graduated and Incubating Projects">Projects</a>
</div>
		<?php
	}
elseif ( is_singular( 'lf_kubeweekly' ) ) :
	?>
<div class="parent-link-align"><a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/kubeweekly/"
		title="See all Kubeweeklys">Kubeweekly</a>
</div>
	<?php
elseif ( is_singular( 'lf_report' ) ) :
	?>
<div class="parent-link-align">
	<a class="parent-link"
		href="<?php echo esc_url( get_home_url() ); ?>/reports/"
		title="See all Reports">Report</a>

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
</div>
	<?php
else :
	// Single Post.
	$all_categories = get_the_category();
	if ( $all_categories ) {
		// Only get the first item in the array.
		$category = array_shift( $all_categories );
		?>
		<div class="parent-link-align">
		<a class="parent-link"
		href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
		title="See <?php echo esc_html( $category->name ); ?> posts"><?php echo esc_html( $category->name ); ?></a>
		<?php

		// Get the Category Author.
		$category_author      = Lf_Utils::get_term_names( get_the_ID(), 'lf-author-category', true );
		$category_author_slug = Lf_Utils::get_term_slugs( get_the_ID(), 'lf-author-category', true );
		if ( $category_author ) {
			$category_link = get_home_url() . '/blog?_sft_lf-author-category=' . $category_author_slug;
			?>
		<div class="space-slash">&nbsp;/&nbsp;</div>
		<span><a class="author-category"
				title="See <?php echo esc_attr( $category_author ); ?> posts"
				href="<?php echo esc_url( $category_link ); ?>">
				<?php echo esc_html( $category_author ) . ' Post'; ?>
			</a></span>
			<?php
		}
		?>
		</div>
		<?php
	}
endif;
