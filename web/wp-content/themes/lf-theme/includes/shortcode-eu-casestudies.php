<?php
/**
 * Latest End Users Case Studies
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add Latest End Users shortcode.
  */
function add_eu_casestudies_shortcode() {
	ob_start();
	?>
<div class="enduser-casestudies-wrapper">

<div class="eucs-box background-image-wrapper">
	<div class="eucs-box-overlay"></div>
	<figure class="background-image-figure">
<img src="http://www.fillmurray.com/600/834" alt="" class="eucs-box-logo">
	</figure>

	<div class="eucs-box-text-wrapper background-image-text-overlay">

<img src="https://via.placeholder.com/200x50/d9d9d9/000000" alt="Logo">
<p class="h4">Lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo</p>
<h4 class="deploy-stat">1000</h4>
<p class="h5 deploy-stat-desc">Deployments Weekly</p>
<a href="#" class="arrow-cta has-white-color">Read X Case Study</a>
</div>
</div>

<div class="eucs-box background-image-wrapper">
	<div class="eucs-box-overlay"></div>
	<figure class="background-image-figure">
<img src="http://www.fillmurray.com/800/834" alt="" class="eucs-box-logo">
	</figure>

	<div class="eucs-box-text-wrapper background-image-text-overlay">

<img src="https://via.placeholder.com/100x50/d9d9d9/000000" alt="Logo">
<p class="h4">Lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo</p>
<h4 class="deploy-stat">1000</h4>
<p class="h5 deploy-stat-desc">Deployments Weekly</p>
<a href="#" class="arrow-cta has-white-color">Read X Case Study</a>
</div>
</div>

<div class="eucs-box background-image-wrapper">
	<div class="eucs-box-overlay"></div>
	<figure class="background-image-figure">
<img src="http://www.fillmurray.com/940/834" alt="" class="eucs-box-logo">
	</figure>

	<div class="eucs-box-text-wrapper background-image-text-overlay">

<img src="https://via.placeholder.com/100x50/d9d9d9/000000" alt="Logo">
<p class="h4">Lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo</p>
<h4 class="deploy-stat">1000</h4>
<p class="h5 deploy-stat-desc">Deployments Weekly</p>
<a href="#" class="arrow-cta has-white-color">Read X Case Study</a>
</div>
</div>

<div class="eucs-box background-image-wrapper">
	<div class="eucs-box-overlay"></div>
	<figure class="background-image-figure">
<img src="http://www.fillmurray.com/500/834" alt="" class="eucs-box-logo">
	</figure>

	<div class="eucs-box-text-wrapper background-image-text-overlay">

<img src="https://via.placeholder.com/100x50/d9d9d9/000000" alt="Logo">
<p class="h4">Lorem ipsum dolor sit amet consectetuer adipiscing elit aenean commodo</p>
<h4 class="deploy-stat">1000</h4>
<p class="h5 deploy-stat-desc">Deployments Weekly</p>
<a href="#" class="arrow-cta has-white-color">Read X Case Study</a>
</div>
</div>



</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'eu_casestudies', 'add_eu_casestudies_shortcode' );
