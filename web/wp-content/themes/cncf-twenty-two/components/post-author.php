<?php
/**
 * Post Author area, only used on blog posts
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$author_byline     = Lf_Utils::display_author( get_the_ID() );
$projects_taxonomy = get_the_terms( get_the_ID(), 'lf-project' );
?>

<div class="post-author">
	<p class="post-author__date">Posted on <?php the_date(); ?>

	<?php
	if ( $author_byline ) {
		?>
	<span
		class="post-author__author">by <?php echo esc_html( $author_byline ); ?></span>
		<?php
	}
	?>
</p>
	<?php
	if ( $projects_taxonomy && ! is_wp_error( $projects_taxonomy ) ) {
		?>
	<p
		class="post-author__projects_title">CNCF projects in this post</p>
	<div class="post-author__projects">
		<?php
		$project_slugs = wp_list_pluck( $projects_taxonomy, 'slug' );
		$args          = array(
			'post_type'      => 'lf_project',
			'name__in'       => $project_slugs,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
		);

		$query = new WP_Query( $args );

		$found_projects = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$current_slug                    = get_post_field( 'post_name', get_the_ID() );
				$found_projects[ $current_slug ] = array(
					'title' => get_the_title(),
					'logo'  => get_post_meta( get_the_ID(), 'lf_project_logo', true ),
				);
			}
			wp_reset_postdata();
		}

		foreach ( $projects_taxonomy as $project ) {
			if ( isset( $found_projects[ $project->slug ] ) ) {
				$project_data = $found_projects[ $project->slug ];

				if ( ! empty( $project_data['logo'] ) ) {
					?>

			<a class="post-author__projects_link" title="<?php echo esc_attr( 'Go to ' . $project->name ); ?>"
				href="<?php echo esc_url( '/projects/' . $project->slug ); ?>">
				<img class="post-author__projects_image" loading="eager" decoding="async" width="70" height="60"
					src="<?php echo esc_url( $project_data['logo'] ); ?>"
					alt="<?php echo esc_attr( $project->name . ' logo' ); ?>">
			</a>
					<?php
				}
			} else {
				error_log( 'No project post found for slug: ' . $project->slug );
			}
		}
		?>
	</div>
		<?php
	}
	?>
</div>