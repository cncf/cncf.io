/** // phpcs:ignoreFile
 * KCCNC EU 2022 JS
 *
 * @package WordPress
 * @since 1.0.0
 */

 jQuery( document ).ready(
	function( $ ) {

	const open = $('*[data-id="js-hidden-section-trigger-open"]');
	const close = $('*[data-id="js-hidden-section-trigger-close"]');
	const section = $('*[data-id="js-hidden-section"]');

	if (! open || ! section ) {
		return;
	}

	open.click( function(){
		open.slideToggle(100);
		section.slideToggle(600);
		close.slideToggle(300);
	});

	close.click( function(){
		open.slideToggle(100);
		section.slideToggle(600);
		close.slideToggle(300);
	});

}
);
