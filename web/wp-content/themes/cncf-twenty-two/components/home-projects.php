<?php
/**
 * Home Projects
 *
 * Contains projects intro, numbers and slider.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<section class="home-projects">
	<div class="wp-block-group alignfull">
		<div class="wp-block-group is-style-no-padding">

			<!-- Intro  -->
			<div class="home-projects-intro lf-grid">

				<div class="home-projects-intro__col1">
					<h2 class="has-extra-extra-large-font-size">CNCF projects
						are
						the foundation of cloud native computing </h2>
				</div>
				<div class="home-projects-intro__col2">
					<p>As part of the <a href="https://linuxfoundation.org/">Linux Foundation</a>, we provide support, oversight and direction for fast-growing, <a href="https://github.com/cncf/toc/blob/main/DEFINITION.md">cloud native</a> projects, including Kubernetes, Envoy, and Prometheus.</p>
				</div>

			</div>
			<!-- END Intro  -->

			<div class="wp-block-group is-style-no-padding is-style-see-all">
				<div class="wp-block-columns are-vertically-aligned-bottom">
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:80%">

						<?php
						$project_metrics = LF_Utils::get_homepage_project_metrics();

						// load pure counter countup script.
						wp_enqueue_script( 'purecounter', get_template_directory_uri() . '/source/js/libraries/purecounter.min.js', array(), filemtime( get_template_directory() . '/source/js/libraries/purecounter.min.js' ), false );
						?>

						<!-- project countup start -->
						<div class="home-projects-numbers">
							<div class="home-projects-numbers__graduated">
								<a href="/projects/">
									<span
										data-purecounter-end="<?php echo esc_html( $project_metrics['graduated_count'] ); ?>"
										data-purecounter-delay="75"
										data-purecounter-pulse="false"
										class="purecounter number"><?php echo esc_html( $project_metrics['graduated_count'] ); ?></span>
									<span class="project">Graduated
										<br>Projects</span>
								</a>
							</div>
							<div class="home-projects-numbers__incubating">
								<a href="/projects/#incubating">
									<span
									data-purecounter-start="0"
										data-purecounter-end="<?php echo esc_html( $project_metrics['incubating_count'] ); ?>"
										data-purecounter-delay="20"
										class="purecounter number"><?php echo esc_html( $project_metrics['incubating_count'] ); ?></span>
									<span class="project">Incubating
										<br>Projects</span>
								</a>
							</div>
							<div class="home-projects-numbers__sandbox">
								<a href="/sandbox-projects/">
									<span
									data-purecounter-start="0"
										data-purecounter-end="<?php echo esc_html( $project_metrics['sandbox_count'] ); ?>"
										class="purecounter number"><?php echo esc_html( $project_metrics['sandbox_count'] ); ?></span>
									<span class="project">Sandbox
										<br>Projects</span>
								</a>
							</div>
						</div>
						<!-- project countup end -->

					</div>

					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="/projects">ALL Projects</a></p>
					</div>
				</div>

				<?php

				// load slick css.
				wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

				// load main slick.
				wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

				// load slick config.
				wp_enqueue_script( 'slick-config', get_template_directory_uri() . '/source/js/on-demand/slick-config.js', array( 'jquery', 'slick' ), filemtime( get_template_directory() . '/source/js/on-demand/slick-config.js' ), true );

				$all_project_logos = LF_Utils::partition( $project_metrics['project_data'], 2 );
				?>

				<!-- slider start -->
				<div class="home-projects-slider">
					<?php
					$i = 0;
					foreach ( $all_project_logos as $project_logos ) :
						$i++;
					$direction = ( $i % 2 == 0 ) ? 'rtl' : 'ltr'; // phpcs:ignore

						?>
					<div class="slider home-projects-slider-item-<?php echo esc_html( $i ); ?>"
						dir="<?php echo esc_html( $direction ); ?>">
						<?php
						foreach ( $project_logos as $project_logo ) :
							?>
						<div class="home-projects-slider-slide" dir="ltr">
							<a title="View <?php echo esc_html( $project_logo['title'] ); ?>"
								href="<?php echo esc_url( $project_logo['url'] ); ?>">
								<img src="<?php echo esc_url( $project_logo['logo'] ); ?>"
									loading="lazy"
									alt="Logo of <?php echo esc_html( $project_logo['title'] ); ?>">
							</a>
						</div>
							<?php
					endforeach;
						?>

					</div>
										<?php
endforeach;
					?>
				</div>
				<!-- slider end  -->


			</div>

		</div>
	</div>
</section>
<div style="height:40px" aria-hidden="true" class="wp-block-spacer show-upto-800"></div>

