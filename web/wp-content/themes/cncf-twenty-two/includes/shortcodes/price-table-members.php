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
			<p>Benefits for all members:</p>
			<ul>
				<li>Private member and marketing
					mailing lists</li>
				<li>Private monthly calls to
					meet other cloud native marketing experts</li>
				<li>Discounts on KubeCon + CloudNativeCon sponsorship</li>
				<li>Display <a
						href="https://github.com/cncf/artwork/blob/master/examples/other.md#cncf-member-logos"
						title="CNCF member logos">CNCF membership logos</a> on
					your website </li>
				<li>Display of your company’s logo  on the CNCF website and <a
						href="https://landscape.cncf.io/"
						title="CNCF member logos">Interactive landscape</a></li>
				<li>Apply to be a certified
					vendor, consulting partner, or training partner via our conformance programs (including <a
						href="/certification/software-conformance/"
						title="Certified Kubernetes">Certified Kubernetes</a>,
					<a href="/certification/kcsp/"
						title="Kubernetes Certified Service Provider">Kubernetes
						Certified Service Provider</a>, and <a
						href="/certification/training/#kubernetestrainingpartners"
						title="Kubernetes Training Partner">Kubernetes Training
						Partner</a>)</li>
			</ul>
			<div style="height:40px;" aria-hidden="true"
				class="wp-block-spacer">
			</div>
			<p>Additional benefits for End Users<sup><a href="#footnote-2">2</a></sup>:</p>
			<ul>
				<li>Eligibility to run for the elected 
				<a href="/people/end-user-technical-advisory-board/"
					title="End User Technical Advisory Board">	
					End User Technical Advisory Board</a></li>
				<li>End User Recruiting Booth at KubeCon + CloudNativeCon at Startup Level pricing</li>
				<li>Access to end user-only groups, discussion forums, and special events</li>
			</ul>
			<div style="height:40px;" aria-hidden="true"
				class="wp-block-spacer">
			</div>
			<p>Additional benefits for academic / nonprofit institutions:</p>
			<ul>
				<li>Discounted nonprofit booth at CNCF events</li>
				<li>Linux Foundation Associate Membership</li>
			</ul>
		</div>

		<?php
		if ( ! $atts['no_prices'] ) {
			?>
		<div class="tfoot">
			<h4>Academic: $1,000 / Nonprofit: $500</h4>
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
			academic / nonprofit, plus:</p>
			<ul>
				<li>Run for Governing Board</li>
				<li>2 online programs a quarter to
					build thought leadership (on-demand, YouTube, live streams, video spotlight)
				</li>
				<li>Submit vendor neutral content to
					CNCF blog</li>
				<li>Submit announcements to
					KubeCon + CloudNativeCon news packages</li>
				<li>Access to the <a
						href="https://todogroup.org/" title="TODO Group">TODO Group</a> to meet
					other open source organizations </li>
				<li>Ten LF Education coupon codes for any eLearning, certification exam, or eLearning/exam bundle<sup><a href="#footnote-1">1</a></sup></li>
				<li><a href="/npe-deterrence-benefits/">Non-Practicing Entity / Patent Troll Deterrence Programs</a></li>
			</ul>
			<div style="height:40px;" aria-hidden="true"
				class="wp-block-spacer">
			</div>
			<p>Additional benefits for End Users<sup><a href="#footnote-2">2</a></sup>:</p>
			<ul>
				<li>A total of 10 KubeCon + CloudNativeCon in-person tickets per year</li>
				<li>End Users can choose to substitute the 10 LF Education coupons for a <strong>15-seat annual subscription</strong> to LF Education<sup><a href="#footnote-1">1</a></sup></li>
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
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Membership</a><br/>
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
				<li>Executive engagement with CNCF leadership team</li>
				<li>A total of 4 online programs a
					quarter (on-demand, YouTube, live streams) to build thought
					leadership</li>
				<li>Increased access to Linux
					Foundation’s invitation-only Linux Foundation Member Summit
				</li>
				<li>50-seat annual Linux Foundation Training subscription OR 10 Linux Foundation Training coupons<sup><a href="#footnote-1">1</a></sup>
				</li>
				<li><a href="/npe-deterrence-benefits/">Additional NPE / Patent Troll Deterrence Tools</a> including royalty-free licenses from NPEs</li>
			</ul>
		</div>

		<?php
		if ( ! $atts['no_prices'] ) {
			?>
		<div class="tfoot">
			<h4>$100,000 <br class="show-over-1000">+ LF Membership</h4>
		</div>
			<?php
		}
		?>


		<div class="lf-membership-style show-upto-1000">
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Membership</a><br/>
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
				<li>Personalized executive engagement with CNCF leadership teams</li>
				<li>Guidance on open source strategy - e.g. donating a project, running an open source program office</li>
				<li>Exclusive live webinars with
					CNCF online programs</li>
				<li><a href="/npe-deterrence-benefits/">Additional NPE / Patent Troll Deterrence Tools</a> including expanded access to prior art</li>
			</ul>
			<div style="height:40px;" aria-hidden="true"
				class="wp-block-spacer">
			</div>
			<p>Additional benefits for End Users<sup><a href="#footnote-2">2</a></sup>:</p>
			<ul>
				<li>Appoint a representative to the <a href="/people/end-user-technical-advisory-board/">End User Technical Advisory Board</a></li>
			</ul>

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
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Membership</a><br/>
		(CNCF and LF memberships are invoiced separately)</p>
		</div>
	</div>
	<!-- column 4 ends -->

	<div class="blank-cell"></div>

	<div class="lf-membership lf-membership-style show-over-1000">
		<p>Requires <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Membership</a><br/>
		(CNCF and LF memberships are invoiced separately)</p>
	</div>


</div><!-- end of wrapper -->
<div style="height:60px;" aria-hidden="true"
				class="wp-block-spacer">
			</div>
<p class="footnotes">
	<sup id="footnote-1">1</sup> Additional terms apply. Cannot be combined with any other membership training benefits.<br>
	<sup id="footnote-2">2</sup> These benefits are available only to End User companies that meet the <a href="/enduser/#end-user-definition">End User Definition</a>.
</p>

	<?php
	get_template_part( 'components/silver-member-pricing-modal' );
	?>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'members_pricing', 'add_members_pricing_shortcode' );
