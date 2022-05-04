<?php
/**
 * Case Study content - the loop
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<main class="case-study-single">
	<article class="container wrap page-content">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
		<!-- wp:spacer {"height":"40px"} -->
		<div style="height:40px" aria-hidden="true"
			class="wp-block-spacer"></div>
		<!-- /wp:spacer -->

	</article>
</main>
<?php
get_template_part( 'components/case-study-cta' );
?>
