<?php
/**
 * Shortcodes for End Users
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * End Users Pricing Table shortcode.
 */
function add_eu_pricing_shortcode() {
	ob_start();

	// This is loaded for the icons in the pricing table.
	wp_enqueue_script( 'font-awesome', 'https://kit.fontawesome.com/5db798d128.js', array(), filemtime( get_template_directory() . '/build/global.js' ), 'all' );
	?>

<div class="enduser-pricing-wrapper">

<!-- column 1 -->
<div class="eup-column col1">

<div class="thead alt">
<h4>Supporter</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-envelope"></i>Private mailing list and calls to meet other cloud native end users</li>
<li><i class="fas fa-calendar-alt"></i>Unlimited Virtual KubeCon tickets</li>
<li><i class="fas fa-ticket-alt"></i>5 KubeCon in-person tickets (2 tickets for organization with &lt;300 employees)</li>
<li><i class="fas fa-graduation-cap"></i>5 Linux Foundation Training coupons </li>
<li><i class="fas fa-tag"></i>End User Recruiting Booth at KubeCon ($7k instead of $21k)</li>
<li><i class="fas fa-couch"></i>Exclusive <a href="/blog/2021/04/22/introducing-the-cncf-end-user-lounge-exclusive-live-streams-for-end-user-organizations">CNCF End User Lounge</a> live streams</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$4,500</h4>
<p>$1,800 (&lt;300 employees)</p>
</div>

</div>
<!-- column 1 ends -->

<!-- column 2 -->
<div class="eup-column col2">
<div class="thead">
<h4>Silver Member</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-arrow-from-right"></i>Everything included in Supporter, plus:</li>
<li><i class="fab fa-linux"></i>Linux Foundation <a href="https://www.linuxfoundation.org/join/#benefits">Silver Membership</a></li>
<li><i class="fas fa-vote-yea"></i>Run for Governing Board</li>
<li><i class="fab fa-youtube"></i>2 online programs a quarter to build thought leadership (on-demand, YouTube, live streams)</li>
<li><i class="fas fa-ticket-alt"></i>A total of 10 KubeCon in-person tickets</li>
<li><i class="fas fa-tag"></i>15-seat Linux Foundation Training subscription (worth $7.5k)
</li>
<li><i class="fas fa-graduation-cap"></i>A total of 10 Linux Foundation Training coupons </li>
<li><i class="fas fa-key"></i>Access to the <a href="https://todogroup.org/">TODO Group</a> to meet other open source organizations </li>

</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$7,000-$50,000</h4>
<p><button class="js-modal button-reset" data-modal-content-id="modal-silver" data-modal-prefix-class="lf" data-modal-close-text="Close" title="">See Full Silver Pricing Scale</button></p>
</div>

</div>
<!-- column 2 ends -->

<!-- column 3 -->
<div class="eup-column col3">

<div class="thead">
<h4>Gold Member</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-arrow-from-right"></i>Everything included in Silver, plus:</li>
<li><i class="fas fa-podium"></i>KubeCon keynote mention upon joining </li>
<li><i class="fas fa-newspaper"></i>Personalized press release upon joining</li>
<li><i class="fas fa-handshake"></i>Quarterly executive engagement with CNCF leadership team</li>
<li><i class="fab fa-youtube"></i>4 online programs a quarter  (on-demand, YouTube, live streams) to build thought leadership</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">Up to $120,000</h4>
<p>Annually</p>
</div>

</div>
<!-- column 3 ends -->

<!-- column 4 -->
<div class="eup-column col4">

<div class="thead">
<h4>Platinum Member</h4>
</div>

<div class="tbody">
<ul>
<li><i class="fas fa-arrow-from-right"></i>Everything included in Gold, plus:</li>
<li><i class="fal fa-dharmachakra"></i>Board seat on CNCF Governing Board</li>
<li><i class="fas fa-podium"></i>Exec invite to join a KubeCon keynote upon joining</li>
<li><i class="fas fa-handshake"></i>Personalized executive engagement from CNCF leadership team</li>
<li><i class="fas fa-location-circle"></i>Guidance on open source strategy - e.g. donating a project, running an open source program office</li>
<li><i class="fas fa-user-plus"></i>Recruiting recommendations and DE&I guidance</li>
<li><i class="fas fa-handshake"></i>Personalized executive engagement from LF leadership team</li>
<li><i class="fab fa-youtube"></i>Exclusive live webinars with CNCF online programs</li>
</ul>
</div>

<div class="tfoot">
<h4 class="main-price">$370,000</h4>
<p>Minimum 3-year commitment</p>
</div>
</div>
<!-- column 4 ends -->

<div class="blank-cell"></div>

<div class="lf-membership">
<p class="margin-reset">Includes <a href="https://www.linuxfoundation.org/join/#benefits">Linux Foundation Silver Membership</a></p>
</div>

<!-- div for supporter CTA -->
<div class="supporter-cta">
<!-- wp:spacer {"height":20} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer show-over-1000"></div>
<!-- /wp:spacer -->
<a href="https://www.cncf.io/endusersupporter" class="button tertiary-color stretch">Join as Supporter</a>
</div>

<!-- div for member CTA  -->
<div class="member-cta">
<!-- wp:spacer {"height":20} -->
<div style="height:20px" aria-hidden="true" class="wp-block-spacer show-over-1000"></div>
<!-- /wp:spacer -->
<a href="https://cncf.io/lfmembership" class="button stretch">Join as CNCF Member</a>
</div>


</div><!-- end of wrapper -->

<!-- Modal -->
<div class="modal-hide" id="modal-silver" aria-hidden="true">
			<div class="modal-content-wrapper">
				<div class="modal__content"
					id="modal-silver-content">

				<h3>Silver Member Pricing Scale</h3>

<!-- wp:table {"hasFixedLayout":true,"className":"is-style-pricing-table"} -->
<figure class="wp-block-table is-style-pricing-table"><table class="has-fixed-layout">
	<caption class="screen-reader-text">Silver Member Pricing Scale</caption>
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
add_shortcode( 'eu_pricing', 'add_eu_pricing_shortcode' );

/**
 * Show Representatives shortcode.
 *
 * @param array $atts Attributes.
 */
function show_reps( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'person_ids' => '', // set default.
		),
		$atts,
		'show_reps'
	);

	if ( ! $atts['person_ids'] ) {
		return;
	}
	$ids = explode( ',', $atts['person_ids'] );
	ob_start();
	echo '<div class="enduser-people-wrapper hide-descriptions">';

	foreach ( $ids as $id ) {
		$args  = array(
			'p'         => $id,
			'post_type' => 'lf_person',
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$query->the_post();
			get_template_part( 'components/people-block' );
		}
		wp_reset_postdata();
	}
	echo '</div>';

	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'show_reps', 'show_reps' );

/**
 * End User Playlist shortcode.
 *
 * @param array $atts Attributes.
 */
function add_playlist_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count'       => 2, // set default.
			'playlist_id' => 'PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40',
		),
		$atts,
		'youtube_playlist'
	);

	// need to enqueue youtube lite script.
	wp_enqueue_script(
		'youtube-lite-js',
		home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
		null,
		filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
		true
	);

	$count       = $atts['count'];
	$playlist_id = $atts['playlist_id'];

	$options         = get_option( 'lf-mu' );
	$youtube_api_key = $options['youtube_api_key'] ?? '';

	if ( ! is_int( $count ) || ! $youtube_api_key ) {
		return;
	}

	if ( 'PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40' === $playlist_id ) {
		$transient_name = 'cncf_eu_playlist';
	} else {
		$transient_name = 'cncf_member_playlist';
	}
	$playlist = get_transient( $transient_name );
	if ( false === $playlist ) {

		$request = wp_remote_get( 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=' . $count . '&playlistId=' . $playlist_id . '&key=' . $youtube_api_key );
		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}
		$playlist = wp_remote_retrieve_body( $request );

		set_transient( $transient_name, $playlist, 6 * HOUR_IN_SECONDS );
	}
	$playlist = json_decode( $playlist );

	ob_start();
	?>
<section class="end-users-playlist">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		if ( array_key_exists( $i, $playlist->items ) ) {

			$pub_date = new DateTime( $playlist->items[ $i ]->contentDetails->videoPublishedAt );

			?>
	<div class="newsroom-post-wrapper">
<div class="">
<div class="wp-block-lf-youtube-lite">
<lite-youtube
videoid="<?php echo esc_attr( $playlist->items[ $i ]->snippet->resourceId->videoId ); ?>"
webpStatus="0"
sdthumbStatus="1"
>
</lite-youtube></div></div>

<h5 class="newsroom-title"><a href="https://www.youtube.com/watch?v=<?php echo esc_attr( $playlist->items[ $i ]->snippet->resourceId->videoId ); ?>&list=PLj6h78yzYM2MiFgpFi1ci4i94A50LeZ40" title="<?php echo esc_attr( $playlist->items[ $i ]->snippet->title ); ?> "><?php echo esc_attr( $playlist->items[ $i ]->snippet->title ); ?></a></h5>

<span class="newsroom-date live-icon"><?php echo esc_html( $pub_date->format( 'F j, Y' ) ); ?></span>
</div>
			<?php
		}
	}
	?>

</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'youtube_playlist', 'add_playlist_shortcode' );


/**
 * Add End User Radar shortcode.
 *
 * @param array $atts Attributes.
 */
function add_eu_radar_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count' => 3, // set default.
		),
		$atts,
		'eu_radar'
	);

	$count = $atts['count'];

	if ( ! is_int( $count ) ) {
		return;
	}
	$eu_radar = get_transient( 'cncf_eu_radar' );
	if ( false === $eu_radar ) {

		$request = wp_remote_get( 'https://radar.cncf.io/radars.json' );
		if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) != 200 ) ) {
			return;
		}
		$eu_radar = wp_remote_retrieve_body( $request );

		set_transient( 'cncf_eu_radar', $eu_radar, 12 * HOUR_IN_SECONDS );
	}
	$eu_radar = json_decode( $eu_radar );

	ob_start();
	?>
	<section class="wp-block-lf-newsroom">
	<?php
	for ( $i = 0; $i < $count; $i++ ) {
		$item_url = 'https://radar.cncf.io/' . $eu_radar[ $i ]->key;
		$title    = $eu_radar[ $i ]->name;
		$date     = $eu_radar[ $i ]->date;
		?>
		<div class="newsroom-post-wrapper">
			<div class="newsroom-image-wrapper">
			<a class="box-link" href="<?php echo esc_url( $item_url ); ?>"
				title="<?php echo esc_attr( $title ); ?>"></a>
			<img loading="lazy" class="archive-image radar" src="<?php echo esc_url( $eu_radar[ $i ]->image ); ?>" alt="<?php echo esc_attr( $title ); ?>">	</div>

			<h5 class="newsroom-title"><a class="external is-primary-color" href="<?php echo esc_url( $item_url ); ?>"
				title="<?php echo esc_attr( $title ); ?>">
				<?php echo esc_html( $title ); ?></a>
			</h5>
			<span class="newsroom-date date-icon">
				<?php echo esc_html( $date ); ?>
			</span>
		</div>
		<?php
	}
	?>

	</section>
	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'eu_radar', 'add_eu_radar_shortcode' );
