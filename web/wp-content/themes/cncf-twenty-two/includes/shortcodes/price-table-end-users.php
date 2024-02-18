<?php
/**
 * End Users Pricing Table
 *
 * Usage
 * [end_user_pricing]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * End Users Pricing Table shortcode.
 */
function add_end_user_pricing_shortcode() {

	wp_enqueue_script(
		'modal',
		get_template_directory_uri() . '/source/js/on-demand/modal.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/modal.js' ),
		true
	);

	ob_start();
	?>

<div class="pricing-table end-user-table">

	<!-- column 2 -->
	<div class="column col2">
		<div class="thead">
			<h3>Silver Member</h3>
		</div>

		<div class="tbody">
			<p>Silver benefits include:</p>
			<ul>
				<li>Linux Foundation <a
						href="https://www.linuxfoundation.org/join/#benefits">Silver
						Membership</a></li>
				<li>Private mailing list and access to end user-only calls, groups, and special events to connect with other cloud native end users</li>
				<li>Run for Governing Board</li>
				<li>Run for the End User Technical Advisory Board</li>
				<li>2 online programs a quarter to
					build thought leadership (on-demand, YouTube, live streams)
				</li>
				<li>A total of 10 KubeCon + CloudNativeCon in-person tickets per year.</li>
				<li>15-seat annual Linux Foundation Training subscription (worth $7.5k) OR
					10 Linux Foundation Training coupons. Additional terms apply.
					(Cannot be combined with any other membership training benefits.)
				</li>
				<li>Access to the <a
						href="https://todogroup.org/">TODO Group</a> to meet
					other open source organizations </li>
				<li>End User Recruiting Booth at KubeCon + CloudNativeCon at Startup Level pricing</li>
			</ul>
		</div>

		<div class="tfoot">
<p>
<button class="js-modal button-reset"
data-modal-content-id="modal-silver"
data-modal-prefix-class="generic"
title="">See Silver <br class="show-over-1000">Pricing Scale</button></p>
		</div>

		<div class="lf-membership-style show-upto-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
		</div>

	</div>
	<!-- column 2 ends -->

	<!-- column 3 -->
	<div class="column col3">

		<div class="thead">
			<h3>Gold Member</h3>
		</div>

		<div class="tbody">
			<p>Everything included in Silver, plus:</p>
			<ul>
				<li>KubeCon + CloudNativeCon keynote mention upon joining </li>
				<li>Personalized press release upon joining</li>
				<li>Quarterly executive engagement with CNCF leadership team</li>
				<li>4 online programs a quarter (on-demand, YouTube, live streams) to build thought
					leadership</li>
				<li>50-seat annual Linux Foundation Training subscription OR
					10 Linux Foundation Training coupons.  Additional terms apply.
					(Cannot be combined with any other membership training benefits.)
				</li>
			</ul>
		</div>

		<div class="tfoot">
		<h4>Up to $120,000 <br class="show-over-1000">annually</h4>
		</div>

		<div class="lf-membership-style show-upto-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
		</div>

	</div>
	<!-- column 3 ends -->

	<!-- column 4 -->
	<div class="column col4">

		<div class="thead">
			<h3>Platinum Member</h3>
		</div>

		<div class="tbody">
			<p>Everything included in Gold, plus:</p>
			<ul>
				<li>Board seat on CNCF Governing Board</li>
				<li>Exec invite to join a KubeCon + CloudNativeCon keynote upon joining</li>
				<li>Personalized executive engagement from CNCF leadership team</li>
				<li>Guidance on open source strategy - e.g. donating a project, running an open source program office</li>
				<li>Recruiting recommendations and DE&I guidance</li>
				<li>Personalized executive engagement from LF leadership team</li>
				<li>Exclusive live webinars with CNCF online programs</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>$370,000</h4>
			<span class="has-small-font-size">Minimum 3-year commitment<br>
		</div>

		<div class="lf-membership-style show-upto-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
		</div>

	</div>
	<!-- column 4 ends -->

	<div class="blank-cell"></div>

	<div class="lf-membership lf-membership-style show-over-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/about/join">Linux Foundation Silver Membership</a></p>
	</div>
</div>

	<?php
	get_template_part( 'components/silver-member-pricing-modal' );
	?>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'end_user_pricing', 'add_end_user_pricing_shortcode' );
