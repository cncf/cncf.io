<?php
/**
 * Single project page template.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

$logo = get_post_meta( get_the_ID(), 'lf_project_logo', true );

$stage            = Lf_Utils::get_term_names( get_the_ID(), 'lf-project-stage', true );
$description      = get_post_meta( get_the_id(), 'lf_project_description', true );
$project_category = get_post_meta( get_the_ID(), 'lf_project_category', true );
$external_url     = get_post_meta( get_the_ID(), 'lf_project_external_url', true );

$date_accepted   = get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ? gmdate( 'F j, Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_accepted', true ) ) ) : '';
$date_incubating = get_post_meta( get_the_ID(), 'lf_project_date_incubating', true ) ? gmdate( 'F j, Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_incubating', true ) ) ) : '';
$date_graduated  = get_post_meta( get_the_ID(), 'lf_project_date_graduated', true ) ? gmdate( 'F j, Y', strtotime( get_post_meta( get_the_ID(), 'lf_project_date_graduated', true ) ) ) : '';

// Links for Project.
$github         = get_post_meta( get_the_ID(), 'lf_project_github', true );
$stack_overflow = get_post_meta( get_the_ID(), 'lf_project_stack_overflow', true );
$devstats       = get_post_meta( get_the_ID(), 'lf_project_devstats', true );
$logos          = get_post_meta( get_the_ID(), 'lf_project_logos', true );
$mail           = get_post_meta( get_the_ID(), 'lf_project_mail', true );
$blog           = get_post_meta( get_the_ID(), 'lf_project_blog', true );
$twitter        = get_post_meta( get_the_ID(), 'lf_project_twitter', true );
$slack          = get_post_meta( get_the_ID(), 'lf_project_slack', true );
$youtube        = get_post_meta( get_the_ID(), 'lf_project_youtube', true );
$gitter         = get_post_meta( get_the_ID(), 'lf_project_gitter', true );

// LFX stuff.
$lfx_health_score = (int) get_post_meta( get_the_ID(), 'lfx_health_score', true );
$lfx_stars_last_365_days = (int) get_post_meta( get_the_ID(), 'lfx_stars_last_365_days', true );
$lfx_forks_last_365_days = (int) get_post_meta( get_the_ID(), 'lfx_forks_last_365_days', true );
$lfx_active_contributors_last_365_days = (int) get_post_meta( get_the_ID(), 'lfx_active_contributors_last_365_days', true );
$lfx_active_organizations_last_365_days = (int) get_post_meta( get_the_ID(), 'lfx_active_organizations_last_365_days', true );
$lfx_stars_previous_365_days = (int) get_post_meta( get_the_ID(), 'lfx_stars_previous_365_days', true );
$lfx_forks_previous_365_days = (int) get_post_meta( get_the_ID(), 'lfx_forks_previous_365_days', true );
$lfx_active_contributors_previous_365_days = (int) get_post_meta( get_the_ID(), 'lfx_active_contributors_previous_365_days', true );
$lfx_active_organizations_previous_365_days = (int) get_post_meta( get_the_ID(), 'lfx_active_organizations_previous_365_days', true );
$lfx_software_value = (float) get_post_meta( get_the_ID(), 'lfx_software_value', true );
$lfx_first_commit = get_post_meta( get_the_ID(), 'lfx_first_commit', true );

$lfx_contributor_increase = ( $lfx_active_contributors_last_365_days - $lfx_active_contributors_previous_365_days ) / max( 1, $lfx_active_contributors_previous_365_days ) * 100;
if ( $lfx_contributor_increase < 0 ) {
	$lfx_contributor_increase = '<span class="lfx-decrease">' . number_format( $lfx_contributor_increase, 0 ) . '%</span>';
} else {
	$lfx_contributor_increase = '<span class="lfx-increase">+' . number_format( $lfx_contributor_increase, 0 ) . '%</span>';
}
$lfx_organizations_increase = ( $lfx_active_organizations_last_365_days - $lfx_active_organizations_previous_365_days ) / max( 1, $lfx_active_organizations_previous_365_days ) * 100;
if ( $lfx_organizations_increase < 0 ) {
	$lfx_organizations_increase = '<span class="lfx-decrease">' . number_format( $lfx_organizations_increase, 0 ) . '%</span>';
} else {
	$lfx_organizations_increase = '<span class="lfx-increase">+' . number_format( $lfx_organizations_increase, 0 ) . '%</span>';
}
$lfx_stars_increase = ( $lfx_stars_last_365_days - $lfx_stars_previous_365_days ) / max( 1, $lfx_stars_previous_365_days ) * 100;
if ( $lfx_stars_increase < 0 ) {
	$lfx_stars_increase = '<span class="lfx-decrease">' . number_format( $lfx_stars_increase, 0 ) . '%</span>';
} else {
	$lfx_stars_increase = '<span class="lfx-increase">+' . number_format( $lfx_stars_increase, 0 ) . '%</span>';
}
$lfx_forks_increase = ( $lfx_forks_last_365_days - $lfx_forks_previous_365_days ) / max( 1, $lfx_forks_previous_365_days ) * 100;
if ( $lfx_forks_increase < 0 ) {
	$lfx_forks_increase = '<span class="lfx-decrease">' . number_format( $lfx_forks_increase, 0 ) . '%</span>';
} else {
	$lfx_forks_increase = '<span class="lfx-increase">+' . number_format( $lfx_forks_increase, 0 ) . '%</span>';
}

global $post;
$project_slug = strtolower( $post->post_name );
?>

<main class="projects-single">
	<article class="container wrap">

		<div class="projects-single-box lf-grid">
			<!-- column 1 -->
			<div class="projects-single-box__col1">

				<a class="projects-single-box__link"
					href="<?php echo esc_url( $external_url ); ?>"><img
						src="<?php echo esc_url( $logo ); ?>" loading="lazy"
						title="Visit <?php echo esc_html( the_title_attribute() ); ?> website"
						class="projects-single-box__image"></a>
			</div>

			<!-- column 2 -->
			<div class="projects-single-box__col2">
				<?php if ( $description ) { ?>
				<h2 class="projects-single-box__description">
					<?php echo esc_html( $description ); ?>
				</h2>
				<div style="height:20px" aria-hidden="true"
					class="wp-block-spacer">
				</div>
					<?php
				}

				if ( $date_accepted && $stage ) {
					if ( 'sandbox' == strtolower( $stage ) ) {
						echo esc_html( get_the_title() ) . ' was accepted to CNCF on ' . esc_html( $date_accepted ) . ' at the <strong>Sandbox</strong> maturity level.';
					} elseif ( $date_accepted == $date_incubating && 'incubating' == strtolower( $stage ) ) {
						echo esc_html( get_the_title() ) . ' was accepted to CNCF on ' . esc_html( $date_accepted ) . ' at the <strong>Incubating</strong> maturity level.';
					} elseif ( $date_accepted == $date_incubating && 'graduated' == strtolower( $stage ) ) {
						echo esc_html( get_the_title() ) . ' was accepted to CNCF on ' . esc_html( $date_accepted ) . ' at the <strong>Incubating</strong> maturity level and then moved to the <strong>Graduated</strong> maturity level on ' . esc_html( $date_graduated ) . '.';
					} elseif ( $date_incubating && 'incubating' == strtolower( $stage ) ) {
						echo esc_html( get_the_title() ) . ' was accepted to CNCF on ' . esc_html( $date_accepted ) . ' and moved to the <strong>Incubating</strong> maturity level on ' . esc_html( $date_incubating ) . '.';
					} elseif ( $date_incubating && $date_graduated && 'graduated' == strtolower( $stage ) ) {
						echo esc_html( get_the_title() ) . ' was accepted to CNCF on ' . esc_html( $date_accepted ) . ', moved to the <strong>Incubating</strong> maturity level on ' . esc_html( $date_incubating ) . ', and then moved to the <strong>Graduated</strong> maturity level on ' . esc_html( $date_graduated ) . '.';
					}
				} elseif ( $stage ) {
					echo esc_html( get_the_title() ) . ' is at the <strong>' . esc_html( $stage ) . '</strong> maturity level.';
				}
				?>

				<div style="height:60px" aria-hidden="true"
					class="wp-block-spacer is-style-40-60">
				</div>

				<div class="projects-single-box__links">

					<?php if ( $external_url ) : ?>

					<div class="wp-block-button is-style-reduced-height"><a
							href="<?php echo esc_url( $external_url ); ?>"
							class="wp-block-button__link">Visit Project
							Website</a></div>
						<?php
endif;
					?>
					<div class="projects-single-box__icons">

						<?php if ( $github ) : ?>
						<a title="<?php the_title_attribute(); ?> on Github"
							href="<?php echo esc_html( $github ); ?>"><?php LF_utils::get_svg( '/social/boxed-github.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $devstats ) : ?>
						<a title="<?php the_title_attribute(); ?> on DevStats"
							href="<?php echo esc_html( $devstats ); ?>"><?php LF_utils::get_svg( '/social/boxed-lf-devstats.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $logos ) : ?>
						<a title="<?php the_title_attribute(); ?> Logos"
							href="<?php echo esc_html( $logos ); ?>"><?php LF_utils::get_svg( '/social/boxed-lf-artwork.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $stack_overflow ) : ?>
						<a title="<?php the_title_attribute(); ?> on Stack Overflow"
							href="<?php echo esc_html( $stack_overflow ); ?>"><?php LF_utils::get_svg( '/social/boxed-stack-overflow.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $twitter && ( preg_match( '/^https?:\/\/(www\.)?(twitter\.com|x\.com)\/(#!\/)?(?<name>[^\/]+)(\/\w+)*$/', $twitter, $matches ) ) && ( 'CloudNativeFdn' != $matches['name'] ) ) : ?>
						<a title="<?php the_title_attribute(); ?> on X"
							href="<?php echo esc_html( $twitter ); ?>"><?php LF_utils::get_svg( '/social/boxed-x.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $blog ) : ?>
						<a title="<?php the_title_attribute(); ?> Blog"
							href="<?php echo esc_html( $blog ); ?>"><?php LF_utils::get_svg( '/social/boxed-blog.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $mail ) : ?>
						<a title="<?php the_title_attribute(); ?> Discussion Group"
							href="<?php echo esc_html( $mail ); ?>"><?php LF_utils::get_svg( '/social/boxed-discussion.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $slack ) : ?>
						<a title="<?php the_title_attribute(); ?> Slack"
							href="<?php echo esc_html( $slack ); ?>"><?php LF_utils::get_svg( '/social/boxed-slack.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $youtube ) : ?>
						<a title="<?php the_title_attribute(); ?> on YouTube"
							href="<?php echo esc_html( $youtube ); ?>"><?php LF_utils::get_svg( '/social/boxed-youtube.svg' ); ?></a>
						<?php endif; ?>

						<?php if ( $gitter ) : ?>
						<a title="<?php the_title_attribute(); ?> on Gitter"
							href="<?php echo esc_html( $gitter ); ?>"><?php LF_utils::get_svg( '/social/boxed-gitter.svg' ); ?></a>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>

		<div style="height:120px" aria-hidden="true"
			class="wp-block-spacer is-style-80-120"></div>

<?php if ( $lfx_health_score > 0 ) : ?>

	<h2 class="wp-block-heading has-text-align-center is-style-spaced-uppercase has-large-font-size">Project Insights</h2>
	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>

	<div class="wp-block-group is-layout-constrained wp-container-core-group-is-layout-53acd6ed wp-block-group-is-layout-constrained">
	<p class="has-text-align-center">Key metrics, providing insights into development activity, community engagement, and project health. Powered by <a href="https://insights.linuxfoundation.org/" class="sa-set-id">LFX Insights</a>.</p>
	</div>

	<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>

	<div class="wp-block-columns">
	<div class="wp-block-column">
	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php
	if ( $lfx_health_score > 80 ) {
		LF_utils::get_svg( '/project-insights/excellent.svg' );
	} elseif ( $lfx_health_score > 60 ) {
		LF_utils::get_svg( '/project-insights/healthy.svg' );
	} elseif ( $lfx_health_score > 40 ) {
		LF_utils::get_svg( '/project-insights/stable.svg' );
	} elseif ( $lfx_health_score > 20 ) {
		LF_utils::get_svg( '/project-insights/unsteady.svg' );
	} else {
		LF_utils::get_svg( '/project-insights/critical.svg' );
	}
	?>
	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">Health Score</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0.24rem"><strong>

	<?php
	if ( $lfx_health_score > 80 ) {
		echo 'Excellent';
	} elseif ( $lfx_health_score > 60 ) {
		echo 'Healthy';
	} elseif ( $lfx_health_score > 40 ) {
		echo 'Stable';
	} elseif ( $lfx_health_score > 20 ) {
		echo 'Unsteady';
	} else {
		echo 'Critical';
	}
	echo ' (' . esc_html( $lfx_health_score ) . ')';
	?>

	</strong></p>
	</div>
	</div>

	<div style="height:20px" aria-hidden="true" class="wp-block-spacer is-style-default"></div>

	<p class="has-gray-700-color has-text-color has-link-color has-small-font-size health-score">Health Score measures a project’s overall trustworthiness across four key areas: contributors, development, popularity, and security.</p>

	<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<div class="wp-block-column">
	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php LF_utils::get_svg( '/project-insights/i_contributors.svg' ); ?>

	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">Total contributors</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0rem"><strong><?php echo esc_html( number_format( $lfx_active_contributors_last_365_days ) ); ?></strong></p>

	<p class="has-small-font-size has-gray-700-color" style="margin-top:0;margin-bottom:0;"><?php echo $lfx_contributor_increase; //phpcs:ignore ?> vs. previous year</p>
	</div>
	</div>

	<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php LF_utils::get_svg( '/project-insights/i_organizations.svg' ); ?>

	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">Total contributing organizations</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0rem"><strong><?php echo esc_html( number_format( $lfx_active_organizations_last_365_days ) ); ?></strong></p>

	<p class="has-small-font-size has-gray-700-color" style="margin-top:0;margin-bottom:0"><?php echo $lfx_organizations_increase; //phpcs:ignore ?> vs. previous year</p>
	</div>
	</div>

	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<div class="wp-block-column">
	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php LF_utils::get_svg( '/project-insights/i_stars.svg' ); ?>

	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">GitHub Stars</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0rem"><strong><?php echo esc_html( number_format( $lfx_stars_last_365_days ) ); ?></strong></p>

	<p class="has-small-font-size has-gray-700-color" style="margin-top:0;margin-bottom:0"><?php echo $lfx_stars_increase; //phpcs:ignore ?> vs. previous year</p>
	</div>
	</div>

	<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php LF_utils::get_svg( '/project-insights/i_forks.svg' ); ?>

	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">GitHub Forks</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0rem"><strong><?php echo esc_html( number_format( $lfx_forks_last_365_days ) ); ?></strong></p>

	<p class="has-small-font-size has-gray-700-color" style="margin-top:0;margin-bottom:0"><?php echo $lfx_forks_increase; //phpcs:ignore ?> vs. previous year</p>
	</div>
	</div>

	<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>

	<div class="wp-block-column">
	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php LF_utils::get_svg( '/project-insights/i_software-value.svg' ); ?>

	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">Software Value</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0rem"><strong>
		<?php
		// output $lfx_software_value by formatting as a currency value; if it's greater than 1 million, show in millions (e.g., $2.5M), if greater than 1 thousand, show in thousands (e.g., $750K), else show full value (e.g., $850).
		if ( $lfx_software_value >= 1000000 ) {
			echo '$' . number_format( $lfx_software_value / 1000000, 1 ) . 'M';
		} elseif ( $lfx_software_value >= 1000 ) {
			echo '$' . number_format( $lfx_software_value / 1000, 0 ) . 'K';
		} else {
			echo '$' . number_format( $lfx_software_value, 0 );
		}
		?>
	</strong></p>
	</div>
	</div>

	<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

	<div class="wp-block-columns is-not-stacked-on-mobile is-style-0px-gap" style="gap: 0px 15px;">
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:70px">
	<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>

	<?php LF_utils::get_svg( '/project-insights/i_first-commit.svg' ); ?>

	</div>

	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
	<p class="is-style-spaced-uppercase has-extra-small-font-size">First commit</p>

	<p class="has-medium-font-size" style="margin-top:0.24rem;margin-bottom:0rem"><strong><?php echo esc_html( gmdate( 'F j, Y', strtotime( $lfx_first_commit ) ) ); ?></strong></p>
	</div>
	</div>

	<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
	</div>
	</div>

	<div class="wp-block-buttons is-content-justification-center is-layout-flex wp-container-core-buttons-is-layout-16018d1d wp-block-buttons-is-layout-flex"><!-- wp:button -->
	<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="https://insights.linuxfoundation.org/project/<?php echo esc_html( $project_slug ); ?>">Explore more insights</a></div>
	</div>
	<div style="height:120px" aria-hidden="true"
	class="wp-block-spacer is-style-80-120"></div>

<?php endif; ?>


		<?php
		// CASE STUDIES.
		$related_args = array(
			'posts_per_page'     => 2,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'lf_case_study' ),
			'post_status'        => array( 'publish' ),
			'order'              => 'DESC',
			'orderby'            => 'date',
			'no_found_rows'      => true,
			'tax_query'          => array(
				array(
					'taxonomy' => 'lf-project',
					'field'    => 'slug',
					'terms'    => $project_slug,
				),
			),
		);

		$related_query = new WP_Query( $related_args );

		if ( $related_query->have_posts() ) :
			?>

		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:70%">
					<h3 class="is-style-section-heading"><?php the_title(); ?>
						case studies</h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:30%">
					<p class="has-text-align-right is-style-link-cta"><a href="<?php echo esc_url( '/case-studies/?_sft_lf-project=' . $project_slug ); ?>">Related Case
Studies</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>

			<div class="case-studies">
				<?php
				while ( $related_query->have_posts() ) {
					$related_query->the_post();
					get_template_part( 'components/case-study-item' );
				}
				?>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>
		</div>


		<div style="height:120px" aria-hidden="true"
			class="wp-block-spacer is-style-80-120"></div>

			<?php
			wp_reset_postdata();
endif;
		?>

		<?php
		// ONLINE PROGRAMS.

		$programs_args = array(
			'posts_per_page'     => 3,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'lf_webinar' ),
			'post_status'        => array( 'publish' ),
			'meta_key'           => 'lf_webinar_date',
			'order'              => 'DESC',
			'orderby'            => 'meta_value',
			'no_found_rows'      => true,
			'meta_query'         => array(
				array(
					'key'     => 'lf_webinar_recording_url',
					'value'   => 0,
					'compare' => '>',
				),
			),
			'tax_query'          => array(
				array(
					'taxonomy' => 'lf-project',
					'field'    => 'slug',
					'terms'    => $project_slug,
				),
			),
		);

		$programs_query = new WP_Query( $programs_args );

		if ( $programs_query->have_posts() ) :

			?>

		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:70%">
					<h3 class="is-style-section-heading">Recorded
						<?php the_title(); ?> programs</h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:30%">
					<p class="has-text-align-right is-style-link-cta"><a href="<?php echo esc_url( '/online-programs?_sft_lf-project=' . $project_slug ); ?>">See more recordings</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>
	<!-- Embeded svg sprite reference -->
	<svg display="none" xmlns="http://www.w3.org/2000/svg">
	<symbol id="play-button" fill="none" viewBox="0 0 70 71" id=".5155955424562817" xmlns="http://www.w3.org/2000/svg">
	<g clip-path="url(#clip0_4409_15889)">
	<path d="M35 70.468c19.33 0 35-15.67 35-35s-15.67-35-35-35-35 15.67-35 35 15.67 35 35 35z" fill="#D62293"/>
	<path d="M26.676 51.298V18.964a2.682 2.682 0 0 1 4.394-2.06l19.367 16.177a2.686 2.686 0 0 1 0 4.115L31.07 53.362a2.676 2.676 0 0 1-4.394-2.064z" fill="#fff"/>
	</g>
	</symbol>
	</svg>
		<div class="webinars columns-three">
				<?php
				while ( $programs_query->have_posts() ) :
					$programs_query->the_post();
					get_template_part( 'components/webinar-recorded-item' );
				endwhile;
				?>
			</div>
			<div style="height:40px" aria-hidden="true" class="wp-block-spacer is-style-20-40"></div>

		</div>

		<div style="height:120px" aria-hidden="true" class="wp-block-spacer is-style-80-120"></div>

			<?php
			wp_reset_postdata();
endif;
		?>
		<?php
		// NEWS.

		$related_args = array(
			'posts_per_page'     => 3,
			'ignore_custom_sort' => true,
			'post_type'          => array( 'post' ),
			'post_status'        => array( 'publish' ),
			'order'              => 'DESC',
			'orderby'            => 'date',
			'no_found_rows'      => true,
			'tax_query'          => array(
				array(
					'taxonomy' => 'lf-project',
					'field'    => 'slug',
					'terms'    => $project_slug,
				),
			),
		);

		$related_query = new WP_Query( $related_args );

		if ( $related_query->have_posts() ) :
			?>
		<div class="wp-block-group is-style-no-padding is-style-see-all">
			<div class="wp-block-columns are-vertically-aligned-bottom">
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:80%">
					<h3 class="is-style-section-heading">Recent
						<?php the_title(); ?> news</h3>
				</div>
				<div class="wp-block-column is-vertically-aligned-bottom"
					style="flex-basis:20%">
					<p class="has-text-align-right is-style-link-cta"><a
href="<?php echo esc_url( '/blog?_sft_lf-project=' . $project_slug ); ?>">See all news</a></p>
				</div>
			</div>
			<div style="height:40px" aria-hidden="true"
				class="wp-block-spacer is-style-20-40"></div>

			<div class="columns-three">
				<?php
				while ( $related_query->have_posts() ) {
					$related_query->the_post();

					get_template_part( 'components/news-item-vertical' );
				}
				?>
			</div>

			<div style="height:40px" aria-hidden="true"	class="wp-block-spacer is-style-20-40"></div>
		</div>

		<div style="height:120px" aria-hidden="true" class="wp-block-spacer is-style-80-120"></div>

			<?php
			wp_reset_postdata();
endif;
		?>

		<?php
		echo do_shortcode( '[shopify_products collection="' . $post->post_name . '"]' );
		?>

	</article>
</main>
