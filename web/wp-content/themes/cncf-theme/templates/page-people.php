<?php
/**
 * Template Name: People
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

get_template_part( 'components/header' );
get_template_part( 'components/hero' );
?>
<main class="page-content">
	<article class="container wrap entry-content">
	<div class="people-wrapper">
		<?php
		$query_args = array(
			'post_type'           => 'cncf_person',
			'post_status'         => array( 'publish' ),
			'posts_per_page'      => -1,
			'order'               => 'ASC',
			'orderby'             => 'title',
		);

		$persons_query = new WP_Query( $query_args );
		if ( $persons_query->have_posts() ) {
			$count = 0;
			while ( $persons_query->have_posts() ) :
				$persons_query->the_post();
				// setup values.
				$person_id = get_the_ID();
				$company   = get_post_meta( get_the_ID(), 'cncf_person_company', true );

				$linkedin = get_post_meta( get_the_ID(), 'cncf_person_linkedin', true );
				$twitter  = get_post_meta( get_the_ID(), 'cncf_person_twitter', true );
				$github   = get_post_meta( get_the_ID(), 'cncf_person_github', true );
				$wechat   = get_post_meta( get_the_ID(), 'cncf_person_wechat', true );
				$website  = get_post_meta( get_the_ID(), 'cncf_person_website', true );
				$youtube  = get_post_meta( get_the_ID(), 'cncf_person_youtube', true );

				$category = Cncf_Utils::get_term_names( get_the_ID(), 'cncf-person-category', true );
				?>
		<div class="people-box"
			data-micromodal-trigger="modal-<?php echo esc_html( $person_id ); ?>">
				<?php
				if ( has_post_thumbnail() ) {
					echo wp_get_attachment_image( get_post_thumbnail_id(), 'thumbnail', false, array( 'class' => 'thumbnail' ) );
				}
				?>
			<h5><?php the_title(); ?></h5>
				<?php
				if ( $company ) :
					?>
			<h6><?php echo esc_html( $company ); ?></h6>
			<?php endif; ?>
				<?php
				if ( $category ) :
					?>
			<h6>Category: <?php echo esc_html( $category ); ?></h6>
			<?php endif; ?>
			<p><?php the_excerpt(); ?></p>
				<?php
				if ( $linkedin ) :
					?>
			<a href="#linkedin">linkedin</a>
					<?php
			endif;
				if ( $twitter ) :
					?>
			<a href="#twitter">twitter</a>
					<?php
			endif;
				if ( $github ) :
					?>
			<a href="#github">github</a>
					<?php
			endif;
				if ( $wechat ) :
					?>
			<a href="#wechat">wechat</a>
					<?php
			endif;
				if ( $website ) :
					?>
			<a href="#website">website</a>
					<?php
			endif;
				if ( $youtube ) :
					?>
			<a href="#youtube">youtube</a>
					<?php
			endif;
				?>
		</div>
				<?php
		endwhile;
			/* Restore original Post Data */
			wp_reset_postdata();
		}
		?>
		</div>
	</article>
</main>
<?php
get_template_part( 'components/footer' );
