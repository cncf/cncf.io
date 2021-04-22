<?php
/**
 * Latest End Users Shortcode
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add Latest End Users shortcode.
  *
  * @param array $atts Attributes.
  */
function add_eu_latest_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count' => 10, // set default.
		),
		$atts,
		'eu_latest'
	);

	$count = intval( $atts['count'] );

	if ( ! is_int( $count ) ) {
		return;
	}

	$endusers = get_transient( 'cncf_latest_endusers' );
	if ( false === $endusers ) {

		$request = wp_remote_get( 'https://landscape.cncf.io/data/exports/end-users-reverse-chronological.json' );
		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}

		$endusers = wp_remote_retrieve_body( $request );

		if ( WP_DEBUG === false ) {
			set_transient( 'cncf_latest_endusers', $endusers, 6 * HOUR_IN_SECONDS );
		}
	}
	$endusers = json_decode( $endusers );

	ob_start();
	?>
<div class="enduser-latest-wrapper">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		echo '<img src="' . esc_url( $endusers[ $i ]->logo ) . '" alt="' . esc_attr( $endusers[ $i ]->name ) . '">';
	}
	?>
</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'eu_latest', 'add_eu_latest_shortcode' );


 /**
  * Add Latest End User Pricing Table shortcode.
  */
function add_eu_pricing_shortcode() {
	ob_start();
	?>
<div class="enduser-pricing-wrapper">

<!-- column 1 -->
<div class="eup-column">

<div class="thead alt">
<h4>Supporter</h4>
</div>

<div class="tbody">
<ul>
<li><i class="las la-envelope"></i>Private mailing list and calls to meet other cloud native end users</li>
<li><i class="las la-calendar-alt"></i>Unlimited Virtual KubeCon tickets</li>
<li><i class="las la-ticket-alt"></i>5 KubeCon in-person tickets (2 tickets for organization with &le;300 employees)</li>
<li><i class="las la-graduation-cap"></i>5 Linux Foundation Training coupons </li>
<li><i class="las la-tag"></i>End User Recruiting Booth at KubeCon ($7k instead of $21k)</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$4,500</h4>
<p>$1,800 (&le;300 employees)</p>
</div>

</div>
<!-- column 1 ends -->


<!-- column 2 -->
<div class="eup-column">

<div class="thead">
<h4>Silver</h4>
</div>

<div class="tbody">
<ul>
<li><i class="las la-long-arrow-alt-left"></i>Everything included in Supporter, plus:</li>
<li><i class="lab la-linux"></i>Linux Foundation Silver Membership</li>
<li><i class="las la-users"></i>Run for Governing Board</li>
<li><i class="las la-video"></i>2 online programs a quarter to build thought leadership (on-demand, YouTube, live streams)</li>
<li><i class="las la-ticket-alt"></i>A total of 10 KubeCon in-person tickets</li>
<li><i class="las la-graduation-cap"></i>A total of 10 Linux Foundation Training coupons </li>
<li><i class="las la-tag"></i>15-seat Linux Foundation Training subscription (worth $7.5k)
</li>
<li><i class="las la-key"></i>Access to the <a href="#">TODO Group</a> to meet other open source organizations </li>

</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$7,000-$50,000</h4>
<p><button class="js-modal button-reset" data-modal-content-id="modal-wechat" data-modal-prefix-class="lf" data-modal-close-text="Close" title="">See Full Silver Pricing Scale</button></p>
</div>

</div>
<!-- column 2 ends -->


<!-- column 3 -->
<div class="eup-column">

<div class="thead">
<h4>Gold</h4>
</div>

<div class="tbody">
<ul>
<li><i class="las la-long-arrow-alt-left"></i>Everything included in Silver, plus:</li>

<li><i class="las la-users"></i>KubeCon keynote mention upon joining </li>

<li><i class="las la-ticket-alt"></i>Personalized press release upon joining</li>

<li><i class="las la-ticket-alt"></i>Quarterly executive engagement with CNCF leadership team</li>

<li><i class="las la-video"></i>4 online programs a quarter  (on-demand, YouTube, live streams) to build thought leadership</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">Up to $120,000</h4>
<p>&nbsp;</p>
</div>

</div>
<!-- column 3 ends -->




<!-- column 4 -->
<div class="eup-column">

<div class="thead">
<h4>Platinum</h4>
</div>

<div class="tbody">
<ul>
<li><i class="las la-long-arrow-alt-left"></i>Everything included in Gold, plus:</li>

<li><i class="las la-users"></i>Board seat on CNCF Governing Board</li>

<li><i class="las la-ticket-alt"></i>Exec invite to join a KubeCon keynote upon joining
</li>

<li><i class="las la-ticket-alt"></i>Personalized executive engagement from CNCF leadership team</li>

<li><i class="las la-ticket-alt"></i>Guidance on open source strategy - e.g. donating a project, running an open source program office</li>

<li><i class="las la-ticket-alt"></i>Recruiting recommendations and DE&I guidance</li>

<li><i class="las la-ticket-alt"></i>Personalized executive engagement from LF leadership team</li>

<li><i class="las la-video"></i>Exclusive live webinars online program for platinum</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$370,000</h4>
<p>Minimum 3-year commitment</p>

</div>

</div>
<!-- column 4 ends -->



</div><!-- end of wrapper -->

<!-- wp:spacer {"height":20} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->
<a href="https://www.cncf.io/endusersupporter" class="button tertiary-color stretch">Join as Supporter</a>

<!-- wp:spacer {"height":20} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->
<a href="https://cncf.io/lfmembership" class="button tertiary-color stretch">Join as CNCF Member</a>

	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'eu_pricing', 'add_eu_pricing_shortcode' );
