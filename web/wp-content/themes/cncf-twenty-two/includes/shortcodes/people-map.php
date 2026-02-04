<?php
/**
 * CNCF People Map
 *
 * Displays people on a world map.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * People map shortcode
 *
 * @param array $atts Attributes.
 */
function add_cncf_people_map_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'category' => 'ambassadors', // set default.
		),
		$atts,
		'people-map'
	);

	$chosen_category            = $atts['category'];
	$options                    = get_option( 'lf-mu' );
	$google_maps_api_public_key = $options['google_maps_api_public_key'] ?? null;

	if ( ! $google_maps_api_public_key ) {
		return;
	}

	wp_enqueue_script(
		'people-map',
		get_template_directory_uri() . '/source/js/on-demand/people-map.js',
		array( 'jquery' ),
		filemtime( get_template_directory() . '/source/js/on-demand/people-map.js' ),
		true
	);
	wp_enqueue_script(
		'markerclusterer',
		get_template_directory_uri() . '/source/js/libraries/markerclusterer.min.js',
		array(),
		filemtime( get_template_directory() . '/source/js/libraries/markerclusterer.min.js' ),
		true
	);

	ob_start();
	?>
<section>
<div id="map"></div>
</section>
<!-- prettier-ignore -->
<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "<?php echo esc_html( $google_maps_api_public_key ); ?>", v: "beta"});</script>

	<?php
	$args = array(
		'posts_per_page'     => 5000,
		'post_type'          => array( 'lf_person' ),
		'post_status'        => array( 'publish' ),
		'no_found_rows'      => true,
		'lf-person-category' => $chosen_category,
	);

	global $post;
	$people = array();
	$query  = new WP_Query( $args );
	while ( $query->have_posts() ) {
		$query->the_post();
		$lat = get_post_meta( $post->ID, 'lf_person_location_lat' );
		$lng = get_post_meta( $post->ID, 'lf_person_location_lng' );

		if ( has_term( 'golden-kubestronaut', 'lf-person-category' ) ) {
			$golden = true;
		} else {
			$golden = false;
		}

		if ( $lat && $lng ) {
			$people[] = array(
				'lat'  => $lat,
				'lng'  => $lng,
				'name' => get_the_title(),
				'slug' => $post->post_name,
				'id'   => get_the_ID(),
				'golden' => $golden,
			);
			$person_id             = get_the_ID();
			$person_slug           = $post->post_name;
			$company               = get_post_meta( get_the_ID(), 'lf_person_company', true );
			$company_logo_url      = get_post_meta( get_the_ID(), 'lf_person_company_logo_url', true );
			$company_landscape_url = get_post_meta( get_the_ID(), 'lf_person_company_landscape_url', true );
			$pronouns              = ucwords( get_post_meta( get_the_ID(), 'lf_person_pronouns', true ), $separators = " \t\r\n\f\v\\;/" );
			$gb_role               = get_post_meta( get_the_ID(), 'lf_person_gb_role', true );
			$toc_role              = get_post_meta( get_the_ID(), 'lf_person_toc_role', true );
			$tab_role              = get_post_meta( get_the_ID(), 'lf_person_tab_role', true );
			$linkedin              = get_post_meta( get_the_ID(), 'lf_person_linkedin', true );
			$bluesky               = get_post_meta( get_the_ID(), 'lf_person_bluesky', true );
			$twitter               = get_post_meta( get_the_ID(), 'lf_person_twitter', true );
			$mastodon              = get_post_meta( get_the_ID(), 'lf_person_mastodon', true );
			$github                = get_post_meta( get_the_ID(), 'lf_person_github', true );
			$wechat                = get_post_meta( get_the_ID(), 'lf_person_wechat', true );
			$website               = get_post_meta( get_the_ID(), 'lf_person_website', true );
			$youtube               = get_post_meta( get_the_ID(), 'lf_person_youtube', true );
			$certdirectory         = get_post_meta( get_the_ID(), 'lf_person_certdirectory', true );
			$image_url             = get_post_meta( get_the_ID(), 'lf_person_image', true );
			$location              = get_post_meta( get_the_ID(), 'lf_person_location', true );
			$related_post          = get_post_meta( get_the_ID(), 'lf_related_post', true );
			$languages             = get_the_terms( get_the_ID(), 'lf-language' );
			$projects              = get_the_terms( get_the_ID(), 'lf-project' );
			$content               = get_the_content();
			$current_url           = home_url( 'people/ambassadors' );
			$extra_classes = '';
			if ( has_term( 'golden-kubestronaut', 'lf-person-category' ) ) {
				$extra_classes = 'golden-kubestronaut';
			}
			$show_logos = false;
			?>
			<div class="modal-hide" id="modal-map-<?php echo esc_html( $person_id ); ?>"
			aria-hidden="true">
			<div class="modal-content-wrapper<?php echo ' ' . esc_html( $extra_classes ); ?>">

				<figure class="person__image">
					<img loading="lazy"
						src="<?php echo esc_attr( $image_url ); ?>"
						alt="Picture of <?php the_title_attribute(); ?>">
				</figure>

				<div class="modal__content">

					<h3 class="person__name">
						<?php the_title(); ?>
						<br class="show-upto-600">
						<?php
						if ( $pronouns ) :
							?>
							<span
							class="person__pronouns">(<?php echo esc_html( $pronouns ); ?>)</span>
							<?php
						endif;
						?>
					</h3>

					<?php
					if ( $toc_role ) :
						?>
						<h4 class="person__company person__role">TOC <?php echo esc_html( $toc_role ); ?></h4>
						<?php
					endif;

					if ( $gb_role ) :
						?>
						<h4 class="person__company person__role">GB <?php echo esc_html( $gb_role ); ?></h4>
						<?php
					endif;

					if ( $company ) {
						?>
					<div class="person__company-container">
						<?php
						if ( $show_logos && $company_logo_url && $company_landscape_url ) {
							?>
								<a class="person__company-logo-link" title="View <?php echo esc_html( $company ); ?> in the CNCF Landscape" href="<?php echo esc_url( $company_landscape_url ); ?>">
									<img class="person__company-logo" src="<?php echo esc_attr( $company_logo_url ); ?>"
									alt="Logo of <?php echo esc_html( $company ); ?>">
								</a>
								<?php
						} elseif ( $show_logos && $company_logo_url ) {
							?>
							<img class="person__company-logo" src="<?php echo esc_attr( $company_logo_url ); ?>"
									alt="Logo of <?php echo esc_html( $company ); ?>">
							<?php
						} else {
							?>
							<h4 class="person__company"><?php echo esc_html( $company ); ?></h4>
							<?php
						}
						?>
					</div>
						<?php
					}

					if ( $location || $projects || $languages ) :
						?>
					<ul class="person__metadata">
						<?php
						if ( $location ) {
							?>
						<li><strong>Location:</strong>
							<?php echo esc_html( $location ); ?> </li>
							<?php
						}

						if ( $languages ) {
							?>
						<li><strong>Languages:</strong>
							<?php
							$comma = '';
							$out   = '';
							foreach ( $languages as $language ) {
								$out  .= esc_html( $comma ) . '<a title="See more Ambassadors who speak ' . esc_html( $language->name ) . '" href="' . $current_url . '/?_sft_lf-language=' . $language->slug . '">' . esc_html( $language->name ) . '</a>';
								$comma = ', ';
							}
						echo $out; //phpcs:ignore
							?>
						</li>
							<?php
						}

						if ( $projects ) {
							?>
						<li><strong>Project Experience:</strong>
							<?php
							$comma = '';
							$out   = '';
							foreach ( $projects as $project ) {
								$out  .= esc_html( $comma ) . '<a title="See more Ambassadors who have experience in ' . esc_html( $project->name ) . '" href="' . $current_url . '/?_sft_lf-project=' . $project->slug . '">' . esc_html( $project->name ) . '</a>';
								$comma = ', ';
							}
						echo $out; //phpcs:ignore
							?>
						</li>
							<?php
						}

						if ( $related_post ) {
							?>
						<li><strong>Related Post:</strong>
							<?php
							// Display related post.
							echo '<a href="' . esc_url( get_permalink( $related_post ) ) . '">' . esc_html( get_the_title( $related_post ) ) . '</a>';
							?>
						</li>
							<?php
						}
						?>
					</ul>
					<?php endif; ?>

					<div class="person__content">
						<?php the_content(); ?>
					</div>

					<div class="person__social">
						<?php
						// Social Icons.
						if ( $linkedin || $bluesky || $twitter || $mastodon || $github || $wechat || $website || $youtube || $certdirectory ) :
							?>
						<div class="person__social-margin">
							<?php
							if ( $linkedin ) :
								?>
							<a
								href="<?php echo esc_url( $linkedin ); ?>"><?php LF_Utils::get_svg( 'social/boxed-linkedin.svg' ); ?></a>
								<?php
								endif;
							if ( $bluesky ) :
								?>
							<a
								href="<?php echo esc_url( $bluesky ); ?>"><?php LF_Utils::get_svg( 'social/boxed-bluesky.svg' ); ?></a>
								<?php
								endif;
							if ( $twitter ) :
								?>
							<a
								href="<?php echo esc_url( $twitter ); ?>"><?php LF_Utils::get_svg( 'social/boxed-x.svg' ); ?></a>
								<?php
								endif;
							if ( $mastodon ) :
								?>
							<a  rel="me"
								href="<?php echo esc_url( $mastodon ); ?>"><?php LF_Utils::get_svg( 'social/boxed-mastodon.svg' ); ?></a>
								<?php
								endif;
							if ( $github ) :
								?>
							<a
								href="<?php echo esc_url( $github ); ?>"><?php LF_Utils::get_svg( 'social/boxed-github.svg' ); ?></a>
								<?php
								endif;
							if ( $wechat ) :
								?>
							<a
								href="<?php echo esc_url( $wechat ); ?>"><?php LF_Utils::get_svg( 'social/boxed-wechat.svg' ); ?></a>
								<?php
								endif;
							if ( $website ) :
								?>
							<a
								href="<?php echo esc_url( $website ); ?>"><?php LF_Utils::get_svg( 'social/boxed-website.svg' ); ?></a>
								<?php
								endif;
							if ( $youtube ) :
								?>
							<a
								href="<?php echo esc_url( $youtube ); ?>"><?php LF_Utils::get_svg( 'social/boxed-youtube.svg' ); ?></a>
								<?php
								endif;
							if ( $certdirectory ) :
								?>
							<a
								href="<?php echo esc_url( $certdirectory ); ?>"><?php LF_Utils::get_svg( 'social/boxed-certdirectory.svg' ); ?></a>
								<?php
								endif;
							?>
						</div>
						<?php endif; ?>
					</div>


				</div>
			</div>
		</div>
			<?php
		}
	}
	wp_reset_postdata();
	?>
<script>
	let people = '<?php echo wp_json_encode( $people ); ?>'
</script>

	<?php
	$block_content = ob_get_clean();
	return $block_content;
}
add_shortcode( 'people-map', 'add_cncf_people_map_shortcode' );
