<?php
/**
 * WIP - Home Hero
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

?>

<section class="training-promotion">
	<div style="height:40px" aria-hidden="true"
		class="wp-block-spacer is-style-40-responsive"></div>
	<div class="wp-block-columns is-style-equal-height-responsive">
		<div class="wp-block-column is-vertically-aligned-center"
			style="flex-basis:57%">
			<h2>Save $2,500 off your next Kubernetes Certification</h2>
			<p
				class="h4">Enroll as an <a href="/people/end-user-community/">End User Supporter</a> and <a href="/people/end-user-community/">receive five 100% off coupon codes for any eLearning class</a>, certification exam, or eLearning + Certification exam "bundle" in the Training and Certification Catalog.</p>
			<p
				class="h4"><a href="/people/end-user-community/" class="arrow-cta">Support CNCF and save on certification</a></p>
			</div>
		</div>
		<div class="wp-block-column" style="flex-basis:43%">
			<?php
			$image = new Image();
			?>
			<img src="<?php $image->get_image( 'wip-home/kubernetes-training.jpg' ); ?>"
				alt="">
		</div>
	</div>
	<div>
	</div>
</section>
<div style="height:40px" aria-hidden="true"
	class="wp-block-spacer is-style-40-responsive"></div>
