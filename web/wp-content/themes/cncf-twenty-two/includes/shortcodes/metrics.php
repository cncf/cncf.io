<?php
/**
 * CNCF Metrics Shortcode
 *
 * Shows contributors, members, platforms, meetups.
 *
 * Usage
 * [metrics]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Metrics shortcode
 */
function add_cncf_metrics_shortcode() {

	// load pure counter countup script.
	wp_enqueue_script( 'purecounter', get_template_directory_uri() . '/source/js/libraries/purecounter.min.js', array(), filemtime( get_template_directory() . '/source/js/libraries/purecounter.min.js' ), false );

	$metrics = LF_Utils::get_whoweare_metrics();

	ob_start();
	?>
<section class="metrics columns-four">

		<div class="metrics__column">

			<a href="/projects" class="metrics__link has-animation-scale-2"
				title="See CNCF Projects">

				<div class="metrics__image-wrapper">
				<img src="<?php LF_utils::get_svg( 'cncf-icon-kubernetes-distributions.svg', true ); ?>"
					width="130" height="110" class="metrics__image"
					alt="Icon of Kubernetes against app outline" loading="lazy" decoding="async">
				</div>

				<div class="metrics__text-wrapper">

					<h2 class="metrics__number has-extra-extra-large-font-size">
						<span
							data-purecounter-end="<?php echo esc_html( round( $metrics['projects'] ) ); ?>"
							data-purecounter-delay="15" class="purecounter">
							<?php echo esc_html( round( $metrics['projects'] ) ); ?>
						</span>
					</h2>

					<span class="metrics__description">CNCF Projects</span>
				</div>
			</a>
		</div>

		<div class="metrics__column">

		<a href="https://contribute.cncf.io/" class="metrics__link has-animation-scale-2"
			title="Contribute to CNCF projects">

			<div class="metrics__image-wrapper">
					<img src="<?php LF_utils::get_svg( 'cncf-icon-computer.svg', true ); ?>"
						width="130" height="80" class="metrics__image"
						alt="Icon of computer" loading="lazy" decoding="async">
			</div>

			<div class="metrics__text-wrapper">

				<h2 class="metrics__number has-extra-extra-large-font-size">
					<span
						data-purecounter-end="<?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>"
						data-purecounter-delay="15" class="purecounter">
						<?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>
					</span>K+
				</h2>

				<span class="metrics__description">CNCF Project
					<br>Contributors</span>
			</div>
		</a>
	</div>

	<div class="metrics__column">

		<a href="/about/members/" class="metrics__link has-animation-scale-2"
			title="See CNCF Members">

			<div class="metrics__image-wrapper">
				<img src="<?php LF_utils::get_svg( 'cncf-icon-corporations.svg', true ); ?>"
					width="120" height="100" class="metrics__image"
					alt="Icon of corporation building" loading="lazy" decoding="async">
			</div>

			<div class="metrics__text-wrapper">

				<h2 class="metrics__number has-extra-extra-large-font-size">
					<span
						data-purecounter-end="<?php echo esc_html( $metrics['cncf-members'] ); ?>"
						data-purecounter-delay="20" class="purecounter">
						<?php echo esc_html( $metrics['cncf-members'] ); ?>
					</span>
				</h2>

				<span class="metrics__description">CNCF <br>Members</span>
			</div>
		</a>
	</div>

	<div class="metrics__column">

		<a href="https://community.cncf.io/" class="metrics__link has-animation-scale-2"
			title="Explore Cloud Native Community Groups">

			<div class="metrics__image-wrapper">
				<img src="<?php LF_utils::get_svg( 'cncf-icon-meetups1.svg', true ); ?>"
					width="125" height="110" class="metrics__image"
					alt="Icon people discussing code" loading="lazy" decoding="async">
			</div>

			<div class="metrics__text-wrapper">

				<h2 class="metrics__number has-extra-extra-large-font-size">
					<span
						data-purecounter-end="<?php echo esc_html( round( $metrics['community-members'] / 1000 ) ); ?>"
						data-purecounter-delay="20" class="purecounter">
						<?php echo esc_html( round( $metrics['community-members'] / 1000 ) ); ?>
					</span>K+
				</h2>

				<span class="metrics__description">Cloud Native Community Members</span>
			</div>
		</a>
	</div>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'metrics', 'add_cncf_metrics_shortcode' );
