<?php
/**
 * Shortcodes for Members
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  *  Latest CNCF Members shortcode.
  *
  * @param array $atts Attributes.
  */
function add_cncf_members_latest_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count'    => 10, // set default.
			'category' => 'endusers', // endusers, members, platinum.
			'size'     => 'large', // small, medium, large.
		),
		$atts,
		'cncf_members_latest'
	);

	// make sure we have a number.
	$count = intval( $atts['count'] );

	// if no number, something wrong.
	if ( ! is_int( $count ) ) {
		return;
	}

	$atts['category'] = strtolower( $atts['category'] );
	$atts['size']     = strtolower( $atts['size'] );

	$transient_name = '';
	$remote_url     = '';
	$members_array  = '';

	if ( 'endusers' == $atts['category'] ) {
		$transient_name = 'cncf_latest_endusers';
		$remote_url     = 'https://landscape.cncf.io/data/exports/end-users-reverse-chronological.json';
	}

	if ( 'members' == $atts['category'] ) {
		$transient_name = 'cncf_latest_members';
		$remote_url     = 'https://landscape.cncf.io/data/exports/members-reverse-chronological.json';
	}

	if ( 'platinum' == $atts['category'] ) {
		$transient_name = 'cncf_platinum_members';
		$remote_url     = 'https://landscape.cncf.io/data/exports/cncf-platinum-members.json';
	}

	if ( ! $transient_name ) {
		return;
	}

	$members_array = get_transient( $transient_name );

	if ( false === $members_array ) {

		$request = wp_remote_get( $remote_url );

		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}

		$members_array = wp_remote_retrieve_body( $request );

		if ( WP_DEBUG === false ) {
			set_transient( $transient_name, $members_array, 6 * HOUR_IN_SECONDS );
		}
	}
	$members_array = json_decode( $members_array );

	ob_start();
	?>
<div class="enduser-latest-wrapper <?php echo esc_html( 'logo_' . $atts['size'] ); ?>">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		echo '<img src="' . esc_url( $members_array[ $i ]->logo ) . '" alt="' . esc_attr( $members_array[ $i ]->name ) . '">';
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'cncf_members_latest', 'add_cncf_members_latest_shortcode' );

/**
 * Members Pricing Table shortcode.
 */
function add_members_pricing_shortcode() {
	ob_start();

	// This is loaded for the icons in the pricing table.
	wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/5db798d128.js', array(), filemtime( get_template_directory() . '/build/global.js' ), 'all' );
	?>

<div class="enduser-pricing-wrapper">

	<!-- column 1 -->
	<div class="eup-column col1">

		<div class="thead alt">
			<h4>Academic/Nonprofit</h4>
		</div>

		<div class="tbody">
			<ul>
				<li><em>Limited to academic and nonprofit institutions.</em>
				</li>
				<li><i class="fas fa-envelope"></i>Private member and marketing
					mailing lists</li>
				<li><i class="fas fa-calendar-alt"></i>Private monthly calls to
					meet other cloud native marketing experts</li>
				<li><i class="fas fa-ticket-alt"></i>Receive discounts on
					KubeCon + CloudNativeCon sponsorship</li>
				<li><i class="fas fa-certificate"></i>Display <a
						href="https://github.com/cncf/artwork/blob/master/examples/other.md#cncf-member-logos"
						target="_blank" rel="noopener"
						title="CNCF member logos">CNCF membership logos</a> on
					your website. Logo also displayed on the CNCF website and in
					marketing materials. </li>
				<li><i class="fas fa-map-marker-alt"></i><a
						href="https://landscape.cncf.io/" target="_blank"
						rel="noopener"
						title="CNCF Cloud Native Interactive Landscape">Interactive
						landscape</a> placement as a member</li>
				<li><i class="fas fa-graduation-cap"></i>Apply to be a certified
					vendor, consulting partner, or training partner via our <a
						href="/certification/software-conformance/"
						target="_blank" rel="noopener"
						title="Certified Kubernetes">Certified Kubernetes</a>,
					<a href="/certification/kcsp/"
						target="_blank" rel="noopener"
						title="Kubernetes Certified Service Provider">Kubernetes
						Certified Service Provider</a>, and <a
						href="/certification/training/#kubernetestrainingpartners"
						target="_blank" rel="noopener"
						title="Kubernetes Training Partner">Kubernetes Training
						Partner</a> programs. </li>
				<li><i class="fas fa-megaphone"></i>Announcement in the
					quarterly CNCF New Member press release</li>
				<li><i class="fas fa-ticket-alt"></i>Includes LF Associate
					Membership</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4 class="main-price">$1,000/$500 annually</h4>
		</div>

	</div>
	<!-- column 1 ends -->

	<!-- column 2 -->
	<div class="eup-column col2">
		<div class="thead">
			<h4>Silver</h4>
		</div>

		<div class="tbody">
			<ul>
				<li><i class="fas fa-arrow-from-right"></i>Everything included
					in nonprofit/academic, plus:</li>
				<li><i class="fas fa-users"></i>Run for Governing Board</li>
				<li><i class="fab fa-youtube"></i>2 online programs a quarter to
					build thought leadership (on-demand, YouTube, live streams)
				</li>
				<li><i class="fas fa-edit"></i>Submit vendor neutral content to
					CNCF blog, Kubernetes.io blog, & KubeWeekly</li>
				<li><i class="fas fa-chart-pie"></i> Receive access to quarterly
					analyst reports including Top Analysts by keyword, quotes,
					and research highlights</li>
				<li><i class="fas fa-megaphone"></i>Submit announcements to
					KubeCon + CloudNativeCon news packages</li>
				<li><i class="fas fa-edit"></i>Support End User Driven open
					source with end user case studies and referral benefits</li>
				<li><i class="fas fa-calendar-alt"></i>Host a local Kubernetes
					Community Day</li>
				<li><i class="fas fa-ticket-alt"></i>Access to the <a
						href="https://todogroup.org/" target="_blank"
						rel="noopener" title="TODO Group">TODO Group</a> to meet
					other open source organizations </li>
				<li><i class="fas fa-tag"></i>Ten coupon codes good for any
					eLearning, certification exam, or eLearning/exam bundle.
					Additional terms apply. (Part of LF membership)</li>

			</ul>
		</div>

		<div class="tfoot">
			<h4 class="main-price"><button class="js-modal button-reset"
					data-modal-content-id="modal-silver"
					data-modal-prefix-class="lf" data-modal-close-text="Close"
					title="">See Silver Pricing Scale</button></h4>
		</div>

	</div>
	<!-- column 2 ends -->

	<!-- column 3 -->
	<div class="eup-column col3">

		<div class="thead">
			<h4>Gold</h4>
		</div>

		<div class="tbody">
			<ul>
				<li><i class="fas fa-arrow-from-right"></i>Everything included
					in Silver, plus:</li>
				<li><i class="fas fa-podium"></i>KubeCon keynote mention upon
					joining </li>
				<li><i class="fas fa-newspaper"></i>Personalized press release
					upon joining</li>
				<li><i class="fas fa-handshake"></i>Quarterly executive
					engagement with CNCF leadership team</li>
				<li><i class="fab fa-youtube"></i>A total of 4 online programs a
					quarter (on-demand, YouTube, live streams) to build thought
					leadership</li>
				<li><i class="fas fa-handshake"></i>Increased access to Linux
					Foundation’s invitation-only Linux Foundation Member Summit
				</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4 class="main-price">Up to $120,000 annually</h4>
			<p><a href="/about/contact/">Contact us</a></p>
		</div>

	</div>
	<!-- column 3 ends -->

	<!-- column 4 -->
	<div class="eup-column col4">

		<div class="thead">
			<h4>Platinum</h4>
		</div>

		<div class="tbody">
			<ul>
				<li><i class="fas fa-arrow-from-right"></i>Everything included
					in Gold, plus:</li>
				<li><i class="fal fa-chair-office"></i>Board seat on CNCF
					Governing Board</li>
				<li><i class="fas fa-podium"></i>Exec invite to join a KubeCon
					keynote upon joining</li>
				<li><i class="fas fa-handshake"></i>Personalized executive
					engagement from CNCF and LF leadership teams: <br />- Open
					source strategy e.g. donating a project, running an open
					source program office</li>
				<li><i class="fab fa-youtube"></i>Exclusive live webinars with
					CNCF online programs</li>
			</ul>
		</div>

		<div class="tfoot">
			<h4 class="main-price">$370,000</h4>
			<p>Minimum 3-year commitment</p>
			<p><a href="/about/contact/">Contact us</a></p>
		</div>
	</div>
	<!-- column 4 ends -->

	<div class="blank-cell"></div>

	<div class="lf-membership">
		<p
			class="margin-reset">Includes <a href="https://www.linuxfoundation.org/join/#benefits" target="_blank" rel="noopener">Linux Foundation Silver Membership</a></p>
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
