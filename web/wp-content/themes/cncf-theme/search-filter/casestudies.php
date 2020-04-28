<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 */

if ( $query->have_posts() ) :
	// get total list of case studies.
	$count_case_study = wp_count_posts( 'cncf_case_study' );
	$full_count       = $count_case_study->publish;
	?>

<p class="results-count">
	<?php
	// if post_style is case study set chinese conditional true.
	if ( 'cncf_case_study_ch' === $query->query['post_type'] ) {
		$ch = true;
		echo '发现' . esc_html( $query->found_posts ) . '个案例研究';
	} else {
		$ch = false;
		if ( $full_count == $query->found_posts ) {
			echo 'Found ' . esc_html( $query->found_posts ) . ' case studies';
		} else {
			echo 'Showing ' . esc_html( $query->found_posts ) . ' of ' . esc_html( $full_count ) . ' case studies';
		}
	}
	?>
</p>
	<?php
	while ( $query->have_posts() ) {
		$query->the_post();

		if ( $ch ) {
			$cs_type         = get_post_meta( $post->ID, 'cncf_case_study_ch_type', true );
			$read_case_study = '阅读';
			if ( $cs_type ) {
				$read_case_study .= $cs_type;
			}
			$read_case_study .= '案例研究';
		} else {
			$cs_type         = get_post_meta( $post->ID, 'cncf_case_study_type', true );
			$read_case_study = 'read the ';
			if ( $cs_type ) {
				$read_case_study .= $cs_type . ' ';
			}
			$read_case_study .= 'case study';


		}
		?>
<div class="result-item">
	<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
	<a class="read"
		href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		<?php
		if ( has_post_thumbnail() ) {
			echo wp_get_attachment_image( get_post_thumbnail_id(), 'thumbnail', false, array( 'class' => 'thumbnail' ) );
		}
		?>
</div>
		<?php

	}
	?>
	<?php
else :
	echo 'No Results Found';
endif;
