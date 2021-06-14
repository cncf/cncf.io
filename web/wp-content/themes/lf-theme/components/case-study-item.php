<?php
/**
 * Case Study Item
 *
 * Singular case study item.
 *
 * @package WordPress
 * @subpackage lf-theme
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
	$case_study_long_title     = get_post_meta( get_the_ID(), 'lf_case_study_cn_long_title', true );
	$case_study_key_stat       = get_post_meta( get_the_ID(), 'lf_case_study_cn_key_stat', true );
	$case_study_key_stat_label = get_post_meta( get_the_ID(), 'lf_case_study_cn_key_stat_label', true );

} else {
	$read_case_study = 'Read Case Study';

	// new.
	$case_study_long_title     = get_post_meta( get_the_ID(), 'lf_case_study_long_title', true );
	$case_study_key_stat       = get_post_meta( get_the_ID(), 'lf_case_study_key_stat', true );
	$case_study_key_stat_label = get_post_meta( get_the_ID(), 'lf_case_study_key_stat_label', true );
}
?>

<div class="case-study-box background-image-wrapper">

	<div class="case-study-overlay"></div>

	<?php if ( get_post_thumbnail_id() ) : ?>
	<figure class="background-image-figure">
		<?php
		LF_Utils::display_responsive_images( get_post_thumbnail_id(), 'case-study-640', '600px' );
		?>
	</figure>
	<?php endif; ?>

	<div class="case-study-content-wrapper background-image-text-overlay">

<div class="title-stat-date-type">

<!-- title -->
<h2 class="case-study-title"><a title="<?php the_title(); ?>"
				href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

<!-- stat  -->
<?php if ( $case_study_key_stat || $case_study_key_stat_label ) : ?>
<p class="case-study-stat"><span><?php echo esc_html( $case_study_key_stat ); ?></span> <?php echo esc_html( $case_study_key_stat_label ); ?>
</p>
<?php endif; ?>

<div class="date-and-type">
<!-- date  -->
<p class="case-study-date date-icon"><?php echo get_the_date(); ?></p>
</div>

</div>

<div class="marketing-title-and-cta">

<?php if ( $case_study_long_title ) : ?>
<p class="case-study-long-title"><?php echo esc_html( $case_study_long_title ); ?></p>
<?php endif; ?>
<?php if ( $read_case_study ) : ?>
		<a class="case-study-cta button on-image"
			href="<?php the_permalink(); ?>"><?php echo esc_html( $read_case_study ); ?></a>
		<?php endif; ?>

</div>




	</div>
</div>
