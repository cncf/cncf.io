<?php
/**
 * Shortcodes for Credits page
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

/**
 * Credits Pricing Table shortcode.
 */
function add_credits_pricing_shortcode() {
	ob_start();

	// This is loaded for the icons in the pricing table.
	wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/5db798d128.js', array(), filemtime( get_template_directory() . '/build/global.js' ), 'all' );
	?>

<div class="credits-pricing-wrapper">

<!-- column 1 -->
<div class="eup-column col1">

<div class="thead">
<h4>Supporter</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-newspaper"></i>Coordinated CNCF press release</li>
<li><i class="fas fa-certificate"></i>Appropriate placement on cncf.io/credits/sponsors</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$250k+</h4>
</div>

</div>
<!-- column 1 ends -->

<!-- column 2 -->
<div class="eup-column col2">
<div class="thead">
<h4>Advocate</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-arrow-from-right"></i>Everything included in Supporter benefits, plus:</li>
<li><i class="fas fa-certificate"></i>Featured on the project website that you are directly contributing to</li>
<li><i class="fab fa-youtube"></i>Bonus online program slot (live webinar, live stream, or on-demand webinar - your choice) to highlight your participation in the program</li>
<li><i class="fas fa-cogs"></i>For Certified Kubernetes Providers, CNCF will run conformance tests for your platform and submit the results for certification</li>

</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$500k+</h4>
</div>

</div>
<!-- column 2 ends -->

<!-- column 3 -->
<div class="eup-column col3">

<div class="thead">
<h4>Champion</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-arrow-from-right"></i>Everything included in Advocate benefits, plus:</li>
<li><i class="fas fa-certificate"></i>Top cncf.io/credits/sponsors placement with an explanation of the offering</li>
<li><i class="fas fa-megaphone"></i>CNCF marketing campaign to drive awareness towards the donation<br/>
- Coordinated press release and media outreach<br/>
- Social media shout out to thank your company for their contribution<br/>
- Mention in Priyanka’s keynote at the next KubeCon + CloudNativeCon<br/>
- Mention in KubeWeekly and correlating quarterly CNCF newsletter<br/>
</li>
<li><i class="fas fa-users-cog"></i>CNCF will set up resource pooling and CI capacity for self-service of your offering</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$1m+</h4>
</div>

</div>
<!-- column 3 ends -->

</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'credits_pricing', 'add_credits_pricing_shortcode' );
