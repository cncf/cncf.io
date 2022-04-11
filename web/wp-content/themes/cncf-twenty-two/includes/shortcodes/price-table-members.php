<?php
/**
 * Members (Join) Pricing Table
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Members (Join) Pricing Table shortcode.
 */
function add_members_pricing_shortcode() {
	ob_start();
	?>
<div class="pricing-table members-table">

	<!-- column 1 -->
	<div class="column col1">

		<div class="thead">
			<h3>Academic / Nonprofit</h3>
		</div>

		<div class="tbody">
			<p>Limited to academic and nonprofit institutions.</p>
		<ul>
				<li>Private member and marketing
					mailing lists</li>
				<li>Private monthly calls to
					meet other cloud native marketing experts</li>
				<li>Receive discounts on
					KubeCon + CloudNativeCon sponsorship</li>
				<li>Display <a
						href="https://github.com/cncf/artwork/blob/master/examples/other.md#cncf-member-logos"
						title="CNCF member logos">CNCF membership logos</a> on
					your website. Logo also displayed on the CNCF website and in
					marketing materials. </li>
				<li><a
						href="https://landscape.cncf.io/"
						title="CNCF Cloud Native Interactive Landscape">Interactive
						landscape</a> placement as a member</li>
				<li>Apply to be a certified
					vendor, consulting partner, or training partner via our <a
						href="/certification/software-conformance/"
						title="Certified Kubernetes">Certified Kubernetes</a>,
					<a href="/certification/kcsp/"
						title="Kubernetes Certified Service Provider">Kubernetes
						Certified Service Provider</a>, and <a
						href="/certification/training/#kubernetestrainingpartners"
						title="Kubernetes Training Partner">Kubernetes Training
						Partner</a> programs. </li>
				<li>Announcement in the
					quarterly CNCF New Member press release</li>
				<li>Includes LF Associate
					Membership</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>$1,000 / <br class="show-over-1000">$500 annually</h4>
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
			in nonprofit / academic, plus:</p>
			<ul>
				<li>Run for Governing Board</li>
				<li>2 online programs a quarter to
					build thought leadership (on-demand, YouTube, live streams)
				</li>
				<li>Submit vendor neutral content to
					CNCF blog, Kubernetes.io blog, & KubeWeekly</li>
				<li>Receive access to quarterly
					analyst reports including Top Analysts by keyword, quotes,
					and research highlights</li>
				<li>Submit announcements to
					KubeCon + CloudNativeCon news packages</li>
				<li>Support End User Driven open
					source with end user case studies and referral benefits</li>
				<li>Host a local Kubernetes
					Community Day</li>
				<li>Access to the <a
						href="https://todogroup.org/" title="TODO Group">TODO Group</a> to meet
					other open source organizations </li>
				<li>Ten coupon codes good for any
					eLearning, certification exam, or eLearning/exam bundle.
					Additional terms apply. (Part of LF membership)</li>

			</ul>
		</div>

		<div class="tfoot">
			<h4><button class="js-modal button-reset"
					data-modal-content-id="modal-silver"
					data-modal-prefix-class="generic"
					title="">See  <br class="show-over-1000">Silver Pricing Scale</button></h4>
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
		<p>Everything included
			in Silver, plus:</p>
			<ul>
				<li>KubeCon keynote mention upon
					joining </li>
				<li>Personalized press release
					upon joining</li>
				<li>Quarterly executive
					engagement with CNCF leadership team</li>
				<li>A total of 4 online programs a
					quarter (on-demand, YouTube, live streams) to build thought
					leadership</li>
				<li>Increased access to Linux
					Foundation’s invitation-only Linux Foundation Member Summit
				</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>Up to  <br class="show-over-1000">$120,000 annually</h4>
			<span><a href="/about/contact/">Contact us</a></span>
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
					engagement from CNCF and LF leadership teams: <br />- Open
					source strategy e.g. donating a project, running an open
					source program office</li>
				<li>Exclusive live webinars with
					CNCF online programs</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4>$370,000</h4>
			<span class="has-small-font-size">Minimum 3-year commitment<br>
			<a href="/about/contact/">Contact us</a></span>
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

</div><!-- end of wrapper -->

<!-- Modal -->
<div class="modal-hide" id="modal-silver" aria-hidden="true">
	<div class="modal-content-wrapper">
		<div class="modal__content" id="modal-silver-content">

			<h3>Silver Member Pricing Scale</h3>

			<!-- wp:table {"hasFixedLayout":true,"className":"is-style-pricing-table"} -->
			<figure class="wp-block-table is-style-pricing-table">
				<table class="has-fixed-layout">
					<caption class="screen-reader-text">Silver Member Pricing
						Scale</caption>
					<thead>
						<tr>
							<th>Consolidated employees</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>5,000 employees +</td>
							<td>$50,000</td>
						</tr>
						<tr>
							<td>3,000 – 4,999 employees</td>
							<td>$45,000</td>
						</tr>
						<tr>
							<td>1,000 – 2,999 employees</td>
							<td>$35,000</td>
						</tr>
						<tr>
							<td>500 – 999 employees</td>
							<td>$25,000</td>
						</tr>
						<tr>
							<td>100 – 499 employees</td>
							<td>$15,000</td>
						</tr>
						<tr>
							<td>50 – 99 employees</td>
							<td>$10,000</td>
						</tr>
						<tr>
							<td>Under 50 employees</td>
							<td>$7,000</td>
						</tr>
					</tbody>
				</table>
			</figure>
			<!-- /wp:table -->
		</div>
	</div>
</div>

	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'members_pricing', 'add_members_pricing_shortcode' );
