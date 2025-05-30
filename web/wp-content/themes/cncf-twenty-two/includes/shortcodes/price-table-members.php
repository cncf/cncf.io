<?php
/**
 * Members (Join) Pricing Table
 *
 * Usage:
 * [members_pricing]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Members (Join) Pricing Table shortcode.
 *
 * @param array $atts Attributes.
 */
function add_members_pricing_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'no_prices' => false, // set default.
		),
		$atts,
		'members_pricing'
	);

	wp_enqueue_script(
		'modal',
		get_template_directory_uri() . '/source/js/on-demand/modal.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/modal.js' ),
		true
	);

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
				<li>Programs for deterring patent trolls
					(see <a href="/npe-deterrence-benefits/">NPE Deterrence for CNCF Members</a>)</li>
			</ul>
		</div>

		<?php
		if ( ! $atts['no_prices'] ) {
			?>
		<div class="tfoot">
			<h4>$1,000 / <br class="show-over-1000">$500 annually</h4>
		</div>
			<?php
		}
		?>

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
				<li>Receive access to industry
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
				<li>Additional programs for deterring patent trolls
					(see <a href="/npe-deterrence-benefits/">NPE Deterrence for CNCF Members</a>)</li>

			</ul>
		</div>

		<?php
		if ( ! $atts['no_prices'] ) {
			?>
		<div class="tfoot">
			<h4><button class="js-modal button-reset"
					data-modal-content-id="modal-silver"
					data-modal-prefix-class="generic"
					title="">See Silver <br class="show-over-1000">Pricing Scale</button></h4>
		</div>
			<?php
		}
		?>

		<div class="lf-membership-style show-upto-1000">
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a><br/>
		(CNCF and LF memberships are invoiced separately)</p>
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
				<li>50-seat annual Linux Foundation Training subscription OR 10 Linux Foundation Training coupons.
					Additional terms apply. (Cannot be combined with any other membership training benefits.)
				</li>
				<li>Additional programs for deterring patent trolls
					(see <a href="/npe-deterrence-benefits/">NPE Deterrence for CNCF Members</a>)</li>
			</ul>
		</div>

		<?php
		if ( ! $atts['no_prices'] ) {
			?>
		<div class="tfoot">
			<h4>$100,000<br class="show-over-1000">+ LF Membership</h4>
		</div>
			<?php
		}
		?>


		<div class="lf-membership-style show-upto-1000">
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a><br/>
		(CNCF and LF memberships are invoiced separately)</p>
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
				<li>Additional programs for deterring patent trolls
					(see <a href="/npe-deterrence-benefits/">NPE Deterrence for CNCF Members</a>)</li>

			</ul>
		</div>

		<?php
		if ( ! $atts['no_prices'] ) {
			?>
		<div class="tfoot">
			<h4>$350,000 + LF Membership</h4>
			<span class="has-small-font-size">Minimum 3-year commitment</span>
		</div>
			<?php
		}
		?>


		<div class="lf-membership-style show-upto-1000">
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a><br/>
		(CNCF and LF memberships are invoiced separately)</p>
		</div>
	</div>
	<!-- column 4 ends -->

	<div class="blank-cell"></div>

	<div class="lf-membership lf-membership-style show-over-1000">
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a><br/>
		(CNCF and LF memberships are invoiced separately)</p>
	</div>

</div><!-- end of wrapper -->

	<?php
	get_template_part( 'components/silver-member-pricing-modal' );
	?>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'members_pricing', 'add_members_pricing_shortcode' );
