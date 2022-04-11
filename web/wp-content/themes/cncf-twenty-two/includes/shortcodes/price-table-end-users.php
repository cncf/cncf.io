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
	ob_start();
	?>

<div class="pricing-table end-user-table">

	<!-- column 1 -->
	<div class="column col1">

		<div class="thead">
			<h3>Supporter</h3>
		</div>

		<div class="tbody">
			<p>Get started with CNCF as a supporting member:</p>
			<ul>
				<li>Private mailing list and
					calls to meet other cloud native end users</li>
				<li>Unlimited Virtual KubeCon
					tickets</li>
				<li>5 KubeCon in-person tickets
					(2 tickets for organization with &lt;300 employees)</li>
				<li>5 Linux Foundation
					Training coupons </li>
				<li>End User Recruiting Booth at
					KubeCon ($7k instead of $21k)</li>
				<li>Exclusive <a
						href="/blog/2021/04/22/introducing-the-cncf-end-user-lounge-exclusive-live-streams-for-end-user-organizations">CNCF
						End User Lounge</a> live streams</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>$4,500</h4>
			<p>$1,800 (&lt;300 employees)</p>
		</div>

	</div>
	<!-- column 1 ends -->

	<!-- column 2 -->
	<div class="column col2">
		<div class="thead">
			<h3>Silver</h3>
		</div>

		<div class="tbody">
			<p>Everything included
					in Supporter, plus:</p>
			<ul>
				<li>Linux Foundation <a
						href="https://www.linuxfoundation.org/join/#benefits">Silver
						Membership</a></li>
				<li>Run for Governing Board</li>
				<li>2 online programs a quarter to
					build thought leadership (on-demand, YouTube, live streams)
				</li>
				<li>A total of 10 KubeCon
					in-person tickets</li>
				<li>15-seat Linux Foundation Training
					subscription (worth $7.5k)
				</li>
				<li>A total of 10 Linux
					Foundation Training coupons </li>
				<li>Access to the <a
						href="https://todogroup.org/">TODO Group</a> to meet
					other open source organizations </li>

			</ul>
		</div>

		<div class="tfoot">
			<h4>$7,000-$50,000</h4>
<p>
<button class="js-modal button-reset"
data-modal-content-id="modal-silver"
data-modal-prefix-class="generic"
title="">See Silver Pricing Scale</button></p>
		</div>

		<div class="lf-membership-style show-upto-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
		</div>

	</div>
	<!-- column 2 ends -->

	<!-- column 3 -->
	<div class="column col3">

		<div class="thead">
			<h3>Gold</h3>
		</div>

		<div class="tbody">
			<p>Everything included in Silver, plus:</p>
			<ul>
				<li>KubeCon keynote mention upon
					joining </li>
				<li>Personalized press release
					upon joining</li>
				<li>Quarterly executive
					engagement with CNCF leadership team</li>
				<li>4 online programs a quarter
					(on-demand, YouTube, live streams) to build thought
					leadership</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>Up to $120,000</h4>
			<p>Annually</p>
		</div>

		<div class="lf-membership-style show-upto-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
		</div>

	</div>
	<!-- column 3 ends -->

	<!-- column 4 -->
	<div class="column col4">

		<div class="thead">
			<h3>Platinum</h3>
		</div>

		<div class="tbody">
			<p>Everything included
					in Gold, plus:</p>
			<ul>
				<li>Board seat on CNCF
					Governing Board</li>
				<li>Exec invite to join a KubeCon
					keynote upon joining</li>
				<li>Personalized executive
					engagement from CNCF leadership team</li>
				<li>Guidance on open
					source strategy - e.g. donating a project, running an open
					source program office</li>
				<li>Recruiting recommendations
					and DE&I guidance</li>
				<li>Personalized executive
					engagement from LF leadership team</li>
				<li>Exclusive live webinars with
					CNCF online programs</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>$370,000</h4>
			<p>Minimum 3-year commitment</p>
		</div>

		<div class="lf-membership-style show-upto-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
		</div>

	</div>
	<!-- column 4 ends -->

	<div class="blank-cell"></div>

	<div class="lf-membership lf-membership-style show-over-1000">
		<p>Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
	</div>

	<!-- CTA Buttons  -->
	<div class="supporter-cta">

		<div style="height:20px" aria-hidden="true"
			class="wp-block-spacer show-over-1000"></div>

		<a href="https://www.cncf.io/endusersupporter"
			class="wp-block-button__link has-gray-700-background-color has-background">Join as Supporter</a>
	</div>
	<div class="member-cta">

		<div style="height:20px" aria-hidden="true"
			class="wp-block-spacer show-over-1000"></div>
		<a href="https://cncf.io/lfmembership" class="wp-block-button__link">Join as
			CNCF Member</a>

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
