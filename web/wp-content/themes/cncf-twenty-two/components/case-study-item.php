<?php
/**
 * Case Study Item
 *
 * Case study item.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// if cn CPT set chinese conditional true.
if ( isset( $query ) && ( 'lf_case_study_cn' === $query->query['post_type'] ) ) {
	$cn = true;
} else {
	$cn = false;
}

// setup projects for both lang.
$projects = get_the_terms( get_the_ID(), 'lf-project' );

if ( $cn ) {
	$read_case_study = '阅读 案例研究';

	// new.
	$case_study_description    = get_post_meta( get_the_ID(), 'lf_case_study_cn_long_title', true );
	$case_study_key_stat       = get_post_meta( get_the_ID(), 'lf_case_study_cn_key_stat', true );
	$case_study_key_stat_label = get_post_meta( get_the_ID(), 'lf_case_study_cn_key_stat_label', true );

} else {
	$read_case_study = 'Read Case Study';

	// new.
	$case_study_description    = get_post_meta( get_the_ID(), 'lf_case_study_long_title', true );
	$case_study_key_stat       = get_post_meta( get_the_ID(), 'lf_case_study_key_stat', true );
	$case_study_key_stat_label = get_post_meta( get_the_ID(), 'lf_case_study_key_stat_label', true );
}
?>

<div class="case-study-item has-animation-scale-2">

	<div class="case-study-item__overlay"></div>

	<?php if ( get_post_thumbnail_id() ) : ?>
	<figure class="case-study-item__bg-figure">
		<?php
		LF_Utils::display_responsive_images( get_post_thumbnail_id(), 'case-study-600', '600px', 'case-study-item__bg-image', 'lazy', get_the_title() );
		?>
	</figure>
	<?php endif; ?>

	<div class="case-study-item__content">

		<!-- title -->
		<h2 class="case-study-item__title"><a title="<?php the_title_attribute(); ?>"
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<!-- horizontal rule -->
		<hr class="wp-block-separator has-text-color has-background has-white-background-color has-white-color is-style-stubby case-study-item__hr">

		<!-- stat with horizontal rule -->
		<?php if ( $case_study_key_stat || $case_study_key_stat_label ) : ?>
		<div>
			<p class="case-study-item__stats"><span class="case-study-item__stat-larger"><?php echo esc_html( $case_study_key_stat ); ?></span> <span class="case-study-item__stat-default"><?php echo esc_html( $case_study_key_stat_label ); ?></span></p>
		</div>
		<?php endif; ?>

		<!-- date  -->
		<div class="case-study-item__date-wrapper show-over-600">
		<span class="case-study-item__date"><?php echo get_the_date(); ?></span>
		</div>

		<!-- description -->
		<?php if ( $case_study_description ) : ?>
		<p
			class="case-study-item__description"><?php echo esc_html( $case_study_description ); ?></p>
		<?php endif; ?>

		<?php if ( $read_case_study ) : ?>
		<a class="case-study-item__cta wp-block-button__link"
			href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		<?php endif; ?>

	</div>
</div>
