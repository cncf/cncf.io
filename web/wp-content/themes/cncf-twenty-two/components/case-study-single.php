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
	</article>
</main>
<?php
get_template_part( 'components/case-study-cta' );
?>
