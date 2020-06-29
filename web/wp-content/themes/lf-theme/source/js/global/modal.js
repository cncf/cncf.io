/**
 * Modal window
 *
 * From https://a11y.nicolas-hoffmann.net/modal/.
 *
 * @package WordPress
 * @since 1.0.0
 */

jQuery( document ).ready(
	function( $ ) {
		/*
			* jQuery simple and accessible modal window, using ARIA
			* @version v1.11.0
			* Website: https://a11y.nicolas-hoffmann.net/modal/
			* License MIT: https://github.com/nico3333fr/jquery-accessible-modal-window-aria/blob/master/LICENSE
			*/

		// init.
		let $modals = $( '.js-modal' ),
		$body = $( 'body' );

		$modals.each(
			function( index_to_expand ) {
				let $this = $( this ),
				index_lisible = index_to_expand + 1;

				$this.attr(
					{
						id: 'label_modal_' + index_lisible,
						'aria-haspopup': 'dialog',
					}
				);
			}
		);

		// jQuery formatted selector to search for focusable items.
		let focusableElementsString = "a[href], area[href], input:not([type='hidden']):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, *[tabindex], *[contenteditable]";

		if ( $( '#js-modal-page' ).length === 0 ) { // just to avoid missing #js-modal-page.
			$body.wrapInner( '<div id="js-modal-page"></div>' );
		}

		// events.
		$body.on(
			'click',
			'.js-modal',
			function( event ) {
				let $this = $( this ),
				options = $this.data(),
				$modal_starter_id = $this.attr( 'id' ),
				$modal_prefix_classes = typeof options.modalPrefixClass !== 'undefined' ? options.modalPrefixClass + '-' : '',
				$modal_text = options.modalText || '',
				modal_content_id = typeof options.modalContentId !== 'undefined' ? options.modalContentId : '',
				$modal_content = typeof options.modalContentId !== 'undefined' ? $( '#' + modal_content_id ) : '',
				$modal_title = options.modalTitle || '',
				$modal_close_text = options.modalCloseText || 'Close',
				$modal_close_title = options.modalCloseTitle || options.modalCloseText,
				$modal_close_img = options.modalCloseImg || '',
				$modal_background_click = options.modalBackgroundClick || '',
				$modal_focus_id = options.modalFocusId || '',
				$modal_aria = typeof options.modalAriaModal !== 'undefined' ? 'aria-modal="true"' : '',
				$modal_role_alertdialog = typeof options.modalUseRoleAlertdialog !== 'undefined' ? 'role="alertdialog"' : '',
				$modal_role_dialog = typeof options.modalRemoveRoleDialog !== 'undefined' || $modal_role_alertdialog === 'role="alertdialog"' ? '' : 'role="dialog"',
				$modal_tag = typeof options.modalRemoveDialogTag !== 'undefined' ? 'div' : 'dialog',
				$modal_code,
				$modal_overlay,
				$page = $( '#js-modal-page' );

				// insert code at the end.
				$modal_code = '<' + $modal_tag + ' ' + $modal_role_dialog + ' ' + $modal_role_alertdialog + ' id="js-modal" class="' + $modal_prefix_classes + 'modal" aria-labelledby="modal-title" open ' + $modal_aria + '><div role="document" class="' + $modal_prefix_classes + 'modal__wrapper">';
				$modal_code += '<button type="button" id="js-modal-close" class="' + $modal_prefix_classes + 'modal-close" data-content-back-id="' + modal_content_id + '" data-focus-back="' + $modal_starter_id + '" title="' + $modal_close_title + '">';
				if ( $modal_close_img !== '' ) {
					 $modal_code += '<img src="' + $modal_close_img + '" alt="' + $modal_close_text + '" class="' + $modal_prefix_classes + 'modal__closeimg" />';
				} else {
						 $modal_code += '<span class="' + $modal_prefix_classes + 'modal-close__text">' + $modal_close_text + '</span>';
				}
				$modal_code += '</button>';
				$modal_code += '<div class="' + $modal_prefix_classes + 'modal__content">';
				if ( $modal_title !== '' ) {
					   $modal_code += '<h1 id="modal-title" class="' + $modal_prefix_classes + 'modal-title">' + $modal_title + '</h1>';
				}

				if ( $modal_text !== '' ) {
					  $modal_code += '<p>' + $modal_text + '</p>';
				} else if ( modal_content_id !== '' && $modal_content.length ) {
					 $modal_code += '<div id="js-modal-content">';
					 $modal_code += $modal_content.html();
					 $modal_code += '</div>';
					 $modal_content.empty();
				}
				$modal_code += '</div></div></' + $modal_tag + '>';

				$( $modal_code ).insertAfter( $page );
				$body.addClass( 'no-scroll' );

				$page.attr( 'aria-hidden', 'true' );

				// add overlay.
				if ( $modal_background_click !== 'disabled' ) {
					$modal_overlay = '<span id="js-modal-overlay" class="' + $modal_prefix_classes + 'modal-overlay" title="' + $modal_close_title + '" data-background-click="enabled"><span class="invisible">' + $modal_close_text + '</span></span>';
				} else {
					$modal_overlay = '<span id="js-modal-overlay" class="' + $modal_prefix_classes + 'modal-overlay" data-background-click="disabled"></span>';
				}

				$( $modal_overlay ).insertAfter( $( '#js-modal' ) );

				if ( $modal_focus_id !== '' ) {
					$( '#' + $modal_focus_id ).focus();
				} else {
					$( '#js-modal-close' ).focus();
				}

				event.preventDefault();
			}
		);
		// close button and esc key.
		$body.on(
			'click',
			'#js-modal-close',
			function() {
				let $this = $( this ),
				$focus_back = '#' + $this.attr( 'data-focus-back' ),
				$content_back_id = $this.attr( 'data-content-back-id' ),
				$js_modal = $( '#js-modal' ),
				$js_modal_content = $( '#js-modal-content' ),
				$class_element = $js_modal.attr( 'class' ),
				$class_element_reverse = $class_element + '--reverse',
				$js_modal_overlay = $( '#js-modal-overlay' ),
				$page = $( '#js-modal-page' );

				$page.removeAttr( 'aria-hidden' );

				let delay = $js_modal.css( 'animation-duration' );
				if ( delay != '0s' ) {
					  let timeout = parseFloat( delay.replace( 's', '' ) ) * 1000;
					  timeout++;

					  $js_modal.removeClass( $class_element );
					setTimeout(
						function() {
							$js_modal.addClass( $class_element_reverse );
						},
						1
					);
					setTimeout(
						function() {
							$body.removeClass( 'no-scroll' );
							$js_modal.remove();
							$js_modal_overlay.remove();
							if ( $content_back_id !== '' ) {
									 $( '#' + $content_back_id ).html( $js_modal_content.html() );
							}
							$( $focus_back ).focus();
							$js_modal.removeClass( $class_element_reverse );
							$js_modal.addClass( $class_element );
						},
						timeout
					);
				} else {
					 $body.removeClass( 'no-scroll' );
					 $js_modal.remove();
					 $js_modal_overlay.remove();
					if ( $content_back_id !== '' ) {
						$( '#' + $content_back_id ).html( $js_modal_content.html() );
					}
					$( $focus_back ).focus();
				}
			}
		)
		.on(
			'click',
			'#js-modal-overlay',
			function( event ) {
				let $close = $( '#js-modal-close' );

				event.preventDefault();
				$close.trigger( 'click' );
			}
		)
		.on(
			'click',
			'.js-modal-close',
			function( event ) {
				let $close = $( '#js-modal-close' );

				event.preventDefault();
				$close.trigger( 'click' );
			}
		)
		.on(
			'keydown',
			'#js-modal-overlay',
			function( event ) {
				let $close = $( '#js-modal-close' );

				if ( event.keyCode == 13 || event.keyCode == 32 ) { // space or enter.
					 event.preventDefault();
					 $close.trigger( 'click' );
				}
			}
		)
		.on(
			'keydown',
			'#js-modal',
			function( event ) {
				let $this = $( this ),
				$close = $( '#js-modal-close' );

				if ( event.keyCode == 27 ) { // esc.
					 $close.trigger( 'click' );
				}
				if ( event.keyCode == 9 ) { // tab or maj+tab.
					// get list of all children elements in given object.
					let children = $this.find( '*' );

					// get list of focusable items.
					let focusableItems = children.filter( focusableElementsString ).filter( ':visible' );

					// get currently focused item.
					let focusedItem = $( document.activeElement );

					// get the number of focusable items.
					let numberOfFocusableItems = focusableItems.length;

					let focusedItemIndex = focusableItems.index( focusedItem );

					if ( ! event.shiftKey && ( focusedItemIndex == numberOfFocusableItems - 1 ) ) {
						focusableItems.get( 0 ).focus();
						event.preventDefault();
					}
					if ( event.shiftKey && focusedItemIndex == 0 ) {
						focusableItems.get( numberOfFocusableItems - 1 ).focus();
						event.preventDefault();
					}
				}
			}
		)
		.on(
			'keyup',
			':not(#js-modal)',
			function( event ) {
				let $js_modal = $( '#js-modal' ),
				focusedItem = $( document.activeElement ),
				in_jsmodal = focusedItem.parents( '#js-modal' ).length ? true : false,
				$close = $( '#js-modal-close' );

				if ( $js_modal.length && event.keyCode == 9 && in_jsmodal === false ) { // tab or maj+tab.
					 $close.focus();
				}
			}
		)
		.on(
			'focus',
			'#js-modal-tabindex',
			function() {
				let $close = $( '#js-modal-close' );

				$close.focus();
			}
		);
	}
);
