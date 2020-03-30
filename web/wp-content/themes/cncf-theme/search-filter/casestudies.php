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

if ( $query->have_posts() ) {
	if ( 'cncf_case_study_ch' === $query->query['post_type'] ) {
		$ch = true;
	} else {
		$ch = false;
	}

	while ( $query->have_posts() ) {
		$query->the_post();
		if ( $ch ) {
			$cs_type = get_post_meta( $post->ID, 'cncf_case_study_ch_type', true );
			$read_case_study = '阅读';
			if ( $cs_type ) {
				$read_case_study .= $cs_type;
			}
			$read_case_study .= '案例研究';
			echo '发现' . esc_html( $query->found_posts ) . '个案例研究';
		} else {
			$cs_type = get_post_meta( $post->ID, 'cncf_case_study_type', true );
			$read_case_study = 'read the ';
			if ( $cs_type ) {
				$read_case_study .= $cs_type . ' ';
			}
			$read_case_study .= 'case study';
			echo 'Found ' . esc_html( $query->found_posts ) . ' Case Studies';
		}
		?>
		<div class="result-item">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<a class="read" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		</div>
		<hr />
		<?php
	}
} else {
	echo 'No Results Found';
}
