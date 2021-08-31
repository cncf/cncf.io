<?php
/**
 * Custom Feeds for Twitter Feed Locator Summary Template
 * Creates the HTML for the feed locator summary
 *
 * @version 1.14 Custom Feeds for Twitter Pro by Smash Balloon
 *
 */
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$locator_summary = CTF_Feed_Locator::summary();
$database_settings = ctf_get_database_settings();
?>
<div class="ctf-feed-locator-summary-wrap">
    <h3><?php esc_html_e( 'Feed Finder Summary', 'custom-twitter-feeds' ); ?></h3>
    <p><?php esc_html_e( 'The table below shows a record of all feeds found on your site. A feed may not show up here immediately after being created.', 'custom-twitter-feeds' ); ?></p>
	<?php
	if ( ! empty( $locator_summary ) ) : ?>

		<?php foreach ( $locator_summary as $locator_section ) :
			if ( ! empty( $locator_section['results'] ) ) : ?>
                <div class="ctf-single-location">
                    <h4><?php echo esc_html( $locator_section['label'] ); ?></h4>
                    <table class="widefat striped">
                        <thead>
                        <tr>
                            <th><?php esc_html_e( 'Type', 'custom-twitter-feeds' ); ?></th>
                            <th><?php esc_html_e( 'Sources', 'custom-twitter-feeds' ); ?></th>
                            <th><?php esc_html_e( 'Shortcode', 'custom-twitter-feeds' ); ?></th>
                            <th><?php esc_html_e( 'Location', 'custom-twitter-feeds' ); ?></th>
                        </tr>
                        </thead>
                        <tbody>

						<?php
                        $atts_for_page = array();
						foreach ( $locator_section['results'] as $result ) :
						$should_add = true;
						if ( ! empty( $atts_for_page[ $result['post_id'] ] ) ) {
							foreach ( $atts_for_page[ $result['post_id'] ] as $existing_atts ) {
								if ( $existing_atts === $result['shortcode_atts'] ) {
									$should_add = false;
								}
							}
						}
						if ( $should_add ) {
							$atts_for_page[ $result['post_id'] ][] = $result['shortcode_atts'];
							$shortcode_atts = json_decode( $result['shortcode_atts'], true );
							$shortcode_atts = is_array( $shortcode_atts ) ? $shortcode_atts : array();
							include_once( CTF_URL . '/inc/CtfFeed.php' );
							include_once( CTF_URL . '/inc/CtfFeedPro.php' );

							$twitter_feed = CtfFeedPro::init( $shortcode_atts );
							$settings     = $twitter_feed->feed_options;

							$display_terms   = $settings['feed_types_and_terms_display'];
							$comma_separated = implode( ', ', $display_terms );
							$comma_separated = str_replace( ' -filter:retweets', '', $comma_separated );
							$display         = $comma_separated;
							if ( strlen( $comma_separated ) > 31 ) {
								$display         = '<span class="ctf-condensed-wrap">' . substr( $comma_separated, 0, 30 ) . '<a class="ctf-locator-more" href="JavaScript:void(0);">...</a></span>';
								$comma_separated = '<span class="ctf-full-wrap">' . esc_html( $comma_separated ) . '</span>';
							} else {
								$comma_separated = '';
							}
							$type = isset( $settings['type'] ) ? $settings['type'] : 'usertimeline';
							switch ( $type ) {
								case 'usertimeline':
									$type = __( 'User Timeline', 'custom-twitter-feeds' );
									break;
								case 'hometimeline':
									$type = __( 'Home Timeline', 'custom-twitter-feeds' );
									break;
								case 'mentionstimeline':
									$type = __( 'Mentions Timeline', 'custom-twitter-feeds' );
									break;
								case 'search':
									$type = __( 'Search/Hashtag', 'custom-twitter-feeds' );
									break;
								case 'hashtag':
									$type = __( 'Search/Hashtag', 'custom-twitter-feeds' );
									break;
								case 'lists':
									$type = __( 'Lists', 'custom-twitter-feeds' );
									break;
							}
							$full_shortcode_string = '[custom-twitter-feeds';
							foreach ( $shortcode_atts as $key => $value ) {
								$full_shortcode_string .= ' ' . esc_html( $key ) . '="' . esc_html( $value ) . '"';
							}
							$full_shortcode_string .= ']';
							?>
                            <tr>
                                <td><?php echo esc_html( $type ); ?></td>
                                <td><?php echo $display . $comma_separated; ?></td>
                                <td>
                                    <span class="ctf-condensed-wrap"><a class="ctf-locator-more"
                                                                        href="JavaScript:void(0);"><?php esc_html_e( 'Show', 'custom-twitter-feeds' ); ?></a></span>
                                    <span class="ctf-full-wrap"><?php echo $full_shortcode_string; ?></span>
                                </td>
                                <td><a href="<?php echo esc_url( get_the_permalink( $result['post_id'] ) ); ?>"
                                       target="_blank"
                                       rel="noopener"><?php echo esc_html( get_the_title( $result['post_id'] ) ); ?></a>
                                </td>
                            </tr>
							<?php
						}
						endforeach; ?>


                        </tbody>
                    </table>
                </div>

			<?php endif;
		endforeach;
	else: ?>
        <p><?php esc_html_e( 'Locations of your feeds are currently being detected. You\'ll see more information posted here soon!', 'custom-twitter-feeds' ); ?></p>
	<?php endif; ?>
</div>