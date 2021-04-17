<?php
/**
 * Who We Are Metrics Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add Kubeweekly Newsletter shortcode.
  *
  * @param array $atts Attributes.
  */
function add_whoweare_metrics_shortcode( $atts ) {
	$metrics = LF_Utils::get_whoweare_metrics();

	ob_start();
	?>
<section data-element="count-up-block" class="count-up-block" style="--text-main-color: #FFFFFF;">
	<div class="count-up-wrapper">
				<div class="count-up-column">
					<a class="no-decoration" target="_blank" rel="noopener" href="https://all.devstats.cncf.io/">
				
						<div class="icon-wrap">
							<img src="https://www.cncf.io/wp-content/uploads/2020/05/icon-computer.svg" class="attachment-medium size-medium" alt="Computer" loading="lazy" height="74.18562" width="118.40117">
						</div>
						<div class="text-wrap" data-mh="facts-text-wrap">
							<div class="number number-item h2"><?php echo esc_html( round( $metrics['contributors'] / 1000 ) ); ?>K+</div>
							<span class="count-up-description"># of contributors to CNCF projects</span>
						</div>
					</a>
				</div>

				<div class="count-up-column">
						<a class="no-decoration" href="https://www.cncf.io/certification/training/">
				
								<div class="icon-wrap">
					<img src="https://www.cncf.io/wp-content/uploads/2020/05/icon-rocket.svg" class="attachment-medium size-medium" alt="Rocket" loading="lazy" height="92.41077" width="92.41107">				</div>
								<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2" data-element="lf-number" data-original="633" data-to="633" data-speed="4000">633</div>
										<span class="count-up-description">CNCF Members</span>
										</div>
							</a>
							</div>
				<div class="count-up-column">
						<a class="no-decoration" href="https://www.cncf.io/certification/software-conformance/">
				
								<div class="icon-wrap">
					<img src="https://www.cncf.io/wp-content/uploads/2020/05/icon-settings.svg" class="attachment-medium size-medium" alt="Settings" loading="lazy" height="94.09873" width="110.60081">				</div>
								<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2" data-element="lf-number" data-original="104" data-to="104" data-speed="4000">104</div>
										<span class="count-up-description">Certified Kubernetes Distributions &amp; Platforms</span>
										</div>
							</a>
							</div>
				<div class="count-up-column">
						<a class="no-decoration" target="_blank" rel="noopener" href="https://www.meetup.com/pro/cncf/">
				
								<div class="icon-wrap">
					<img src="https://www.cncf.io/wp-content/uploads/2020/05/icon-members.svg" class="attachment-medium size-medium" alt="Users" loading="lazy" height="106.10079" width="140.8399">				</div>
								<div class="text-wrap" data-mh="facts-text-wrap">
					<div class="number number-item h2" data-element="lf-number" data-original="159027" data-to="159027" data-speed="4000">159,027</div>
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
