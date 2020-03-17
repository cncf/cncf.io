<?php
/**
 * Back to Top
 *
 * Sends user back to top. Requires JS in Globals.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

$image = new Image();
?>

<div class="back-to-top">
	<a href="#top" title="Go to top" name="Go to top">
		<?php $image->get_svg( 'chevron-up.svg' ); ?>
	</a>
</div>
