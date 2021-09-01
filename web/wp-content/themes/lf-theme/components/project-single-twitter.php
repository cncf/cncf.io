<?php
/**
 * Tweets from a project
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$twitter = $args['twitter'] ?? '';

// Check if Twitter is present, parses username, checks if not CNCF account.
if ( $twitter && ( preg_match( '/^https?:\/\/(www\.)?twitter\.com\/(#!\/)?(?<name>[^\/]+)(\/\w+)*$/', $twitter, $matches ) ) && ( 'CloudNativeFdn' != $matches['name'] ) ) : ?>

<div class="wp-block-columns is-style-section-header">
	<div class="wp-block-column bh-01" style="flex-basis:70%">
		<h3>Latest tweets from <?php the_title(); ?></h3>
	</div>
	<div class="wp-block-column bh-02" style="flex-basis:30%">
		<h6 class="is-style-arrow-cta"><a
				href="<?php echo esc_url( $twitter ); ?>">See all tweets</a>
		</h6>
	</div>
</div>
	<?php
	echo do_shortcode( '[custom-twitter-feeds num=8 layout=masonry includeretweets=false showheader=true showbutton=false masonrycols=4 masonrymobilecols=1 screenname="' . esc_html( $matches['name'] ) . '"]' );
	?>

<?php endif; ?>
