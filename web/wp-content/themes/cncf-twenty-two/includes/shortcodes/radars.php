<?php
/**
 * Radars
 *
 * Usage:
 * [radars count=6]
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

/**
 * Add End User Radar shortcode.
 *
 * @param array $atts Attributes.
 */
function add_radars_shortcode( $atts ) {

	// Attributes.
	$atts = shortcode_atts(
		array(
			'count' => 3, // set default.
		),
		$atts,
		'radars'
	);

	$count = $atts['count'];

	// If count is not a number something wrong.
	if ( ! is_int( $count ) ) {
		return;
	}

	// Get all radars.
	$tech_radars_all = LF_utils::get_tech_radars();

	// Check its an array.
	if ( ! is_array( $tech_radars_all ) ) {
		return;
	}

	// Limit to count items.
	$tech_radars = array_slice( $tech_radars_all, 0, $count );

		ob_start();
	?>
<div class="radars columns-three">
		<?php
		foreach ( $tech_radars as $tech_radar ) :

			$url         = 'https://radar.cncf.io/' . $tech_radar->key;
			$radar_title = $tech_radar->name;
			$date        = $tech_radar->date;
			$image       = $tech_radar->image;
			?>

	<div class="radar-item">
		<a href="<?php echo esc_url( $url ); ?>"
			title="<?php echo esc_html( $radar_title ); ?>">
			<?php
			if ( $image ) {
				?>
			<img src="<?php echo esc_url( $image ); ?>"
				alt="<?php echo esc_html( $radar_title ); ?>"
				class="radar-item__image">
				<?php
			} else {
				// show generic.
				$site_options = get_option( 'lf-mu' );
				Lf_Utils::display_responsive_images( $site_options['generic_thumb_id'], 'newsroom-400', '400px', 'radar-item__image', 'lazy', the_title_attribute() );
			}
			?>
			<h3 class="radar-item__title"><?php echo esc_html( $radar_title ); ?></h3>
		</a>

		<span class="radar-item__date"><?php echo esc_html( $date ); ?></span>
	</div>
			<?php
endforeach;
		?>
</div>
		<?php
		$block_content = ob_get_clean();
		return $block_content;
}
add_shortcode( 'radars', 'add_radars_shortcode' );
