<?php // phpcs:ignoreFile.
/**
 * Front Page - TODO
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );
get_template_part( 'components/home-hero' );
get_template_part( 'components/home-projects' );
?>

<article class="container wrap">
		<?php
		echo do_shortcode( '[home_case_studies ids="64415,34869,34901,34928,34890"]' );
		?>
		<div style="height:140px" aria-hidden="true" class="wp-block-spacer"></div>
		<?php echo do_shortcode( '[next_event]' ); ?>
		<div style="height:140px" aria-hidden="true" class="wp-block-spacer"></div>
		<?php
// 		if ( have_posts() ) :
// 			while ( have_posts() ) :
// 				the_post();
// 				the_content();
// 		endwhile;
// endif;
		?>
	</article>
</main>
<?php // Image included here to speed up CSS background image. ?>
<img aria-hidden="true" width="0" height="0" style="display:none !important;" src="/wp-content/themes/cncf-twenty-two/images/bg-cncf-pattern.png">
<?php
get_template_part( 'components/footer' );
