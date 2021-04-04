<?php
/**
 * Front page
 *
 * Template for the front page (home).
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 // phpcs:ignoreFile
get_template_part( 'components/header' );

?>
<main class="page-content">
	<article class="container wrap entry-content">


	<?php
get_template_part( 'components/wip/home-hero' );

get_template_part( 'components/wip/home-user-guide' );

get_template_part( 'components/wip/home-hosted-projects' );

get_template_part( 'components/wip/home-event-highlight' );

get_template_part( 'components/wip/home-training-promotion' );

get_template_part( 'components/wip/home-announcement' );

the_content(); ?>

	</article>
</main>
<?php

get_template_part( 'components/footer' );
