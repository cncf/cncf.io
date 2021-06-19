<?php
/**
 * Who We Are Metrics Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Who we are Metric shortcode
  *
  * @param array $atts Attributes.
  */
function add_whoweare_metrics_shortcode( $atts ) {
	// purecounter countup.
	wp_enqueue_script( 'purecounter', get_template_directory_uri() . '/source/js/third-party/purecounter_vanilla.js', array(), filemtime( get_template_directory() . '/source/js/third-party/purecounter_vanilla.js' ), false );

	$metrics = LF_Utils::get_whoweare_metrics();

	ob_start();
	?>
<section data-element="count-up-block" class="count-up-block" style="--text-main-color: #FFFFFF;">
	<div class="count-up-wrapper">
		<div class="count-up-column">
			<a class="no-decoration" target="_blank" rel="noopener" href="https://all.devstats.cncf.io/">
				<div class="icon-wrap">
					<img src="/wp-content/uploads/2020/05/icon-computer.svg" class="attachment-medium size-medium" alt="Computer" loading="lazy" height="74.18562" width="118.40117">
				</div>
				<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2">
					<span data-purecounter-end="<?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>"
						data-purecounter-delay="15"
						class="purecounter">
						<?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>
					</span>K+
					</div>
					<span class="count-up-description"># of contributors to CNCF projects</span>
				</div>
			</a>
		</div>

		<div class="count-up-column">
			<a class="no-decoration" href="/about/members/">
				<div class="icon-wrap">
					<img src="/wp-content/uploads/2020/05/icon-rocket.svg" class="attachment-medium size-medium" alt="Rocket" loading="lazy" height="92.41077" width="92.41107">
				</div>
				<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2">
					<span data-purecounter-end="<?php echo esc_html( $metrics['cncf-members'] ); ?>"
						data-purecounter-delay="20"
						class="purecounter">
						<?php echo esc_html( $metrics['cncf-members'] ); ?>
					</span>
					</div>
					<span class="count-up-description">CNCF Members</span>
				</div>
			</a>
		</div>
		<div class="count-up-column">
			<a class="no-decoration" href="/certification/software-conformance/">
				<div class="icon-wrap">
					<img src="/wp-content/uploads/2020/05/icon-settings.svg" class="attachment-medium size-medium" alt="Settings" loading="lazy" height="94.09873" width="110.60081">
				</div>
				<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2">
					<span data-purecounter-end="<?php echo esc_html( $metrics['certified-kubernetes'] ); ?>"
						data-purecounter-delay="20"
						class="purecounter">
						<?php echo esc_html( $metrics['certified-kubernetes'] ); ?>
					</span>
					</div>
					<span class="count-up-description">Certified Kubernetes Distributions &amp; Platforms</span>
				</div>
			</a>
		</div>
		<div class="count-up-column">
			<a class="no-decoration" target="_blank" rel="noopener" href="https://www.meetup.com/pro/cncf/">
				<div class="icon-wrap">
					<img src="/wp-content/uploads/2020/05/icon-members.svg" class="attachment-medium size-medium" alt="Users" loading="lazy" height="106.10079" width="140.8399">
				</div>
				<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2">
					<span data-purecounter-end="163"
						data-purecounter-delay="10"
						class="purecounter">
						163
					</span>K+
					</div>
					<span class="count-up-description">CNCF Meetup members</span>
				</div>
			</a>
		</div>
	</div>
</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'whoweare-metrics', 'add_whoweare_metrics_shortcode' );
