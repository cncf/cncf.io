<?php
/**
 * Back to Top
 *
 * Sends user back to top. Requires JS in Globals.
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

$image = new Image();
?>

<div class="back-to-top vanillatop">
	<span title="Go to top" name="Go to top of page"
		aria-label="Go to top of page">
		<?php $image->get_svg( 'chevron-up.svg' ); ?>
	</span>
</div>
