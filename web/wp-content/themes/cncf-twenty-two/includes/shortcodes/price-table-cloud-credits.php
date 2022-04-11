<?php
/**
 * Cloud Credits shortcode.
 *
 * Usage
 * [cloud_credits_pricing]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Cloud Credits Price Table shortcode.
 */
function add_cloud_credits_pricing_shortcode() {
	ob_start();
	?>

<div class="pricing-table cloud-credits-table">

	<!-- column 1 -->
	<div class="column col1">

		<div class="thead">
			<h3>Supporter</h3>
		</div>

		<div class="tbody">
			<p>Starting benefits</p>
			<ul>
				<li>Coordinated CNCF press
					release</li>
				<li>Appropriate placement on
					the CNCF website</li>
			</ul>
		</div>

		<div class="tfoot">
			<h3>$250k+</h3>
		</div>

	</div>

	<!-- column 2 -->
	<div class="column col2">

		<div class="thead">
			<h3>Advocate</h3>
		</div>

		<div class="tbody">
			<p>Everything included
				in Supporter benefits, plus:</p>
			<ul>
				<li>Bonus online program slot
					(live webinar, live stream, or on-demand webinar - your
					choice) to highlight your participation in the program</li>
				<li>For Certified Kubernetes
					Providers, CNCF will run conformance tests for your platform
					and submit the results for certification</li>

			</ul>
		</div>

		<div class="tfoot">
			<h3>$500k+</h3>
		</div>

	</div>

	<!-- column 3 -->
	<div class="column col3">

		<div class="thead">
			<h3>Champion</h3>
		</div>

		<div class="tbody">
		<p>Everything included
					in Advocate benefits, plus:</p>
			<ul>
				<li>Top placement on the CNCF
					website with an explanation of the offering</li>
				<li>CNCF marketing campaign to
					drive awareness towards the donation<br />
					- Coordinated press release and media outreach<br />
					- Social media shout out to thank your company for their
					contribution<br />
					- Mention in Priyanka's keynote at the next KubeCon +
					CloudNativeCon<br />
					- Mention in KubeWeekly and correlating quarterly CNCF
					newsletter<br />
				</li>
				<li>CNCF will set up resource
					pooling and CI capacity for self-service of your offering
				</li>
			</ul>
		</div>

		<div class="tfoot">
			<h3>$1m+</h3>
		</div>

	</div>

</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'cloud_credits_pricing', 'add_cloud_credits_pricing_shortcode' );
