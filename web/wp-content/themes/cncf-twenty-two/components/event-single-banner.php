<?php
/**
 * Event Banner - Single
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

?>

<h3 class="has-normal-font-size header-lines">The Next CNCF Event</h3>

<div class="event-banner has-animation-scale-2" role="banner">
<?php
get_template_part( 'components/event-banner' );
?>
</div>
	<?php // Keep this spacer as its conditionally needed based on an event being displayed. ?>
<div style="height:100px" aria-hidden="true"
	class="wp-block-spacer is-style-60-100"></div>
