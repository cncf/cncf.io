'use strict';
// This file contains debug screen for edit-media

var debugModal;
jQuery(document).ready(function(jq) {
	$ = jq;

	debugModal = function() {

	}

	debugModal.prototype = {
		 currentModal: null,
		 modals: [],
		 parent: '#wpbody',  // modal will be written to this element.
		 multiple: false,
		 windowHeight: false,
		 windowWidth: false,
		 setWidth: false,
		 setHeight: false,
		 target: false,
	}

	debugModal.prototype.init = function()
	{
		this.windowHeight = $(window).height();
		this.windowWidth = $(window).width();

		$(document).off('click', '.debugModal');
		$(document).on('click', '.debugModal', $.proxy(this.buildModal, this));
		$(window).on('resize', $.proxy(this.checkResize, this));

	}


	debugModal.prototype.get = function()
	{
		return this.currentModal;
	}

	debugModal.prototype.show = function()
	{

		$('.debugModal_overlay').remove();
		$('body').removeClass('debug-modal-active');
		this.writeOverlay();
		this.currentModal.show();

		if (this.setWidth)
		{
			this.currentModal.width(this.setWidth);
		}
		if (this.setHeight)
		{
			this.currentModal.height(this.setHeight);
		}

		var $m = this.currentModal;

		var headerHeight = $m.find('.modal_header').outerHeight();

		var contentHeight = $m.find('.modal_content').outerHeight();
		var contentWidth = $m.find('.modal_content').width();

		var modalHeight = headerHeight + contentHeight; //this.currentModal.height();
		var modalWidth = contentWidth; //this.currentModal.width();
		var top  =  (this.windowHeight - modalHeight) / 2;
		var left = (this.windowWidth - modalWidth) / 2;

		if (top < 30)
		{
			top = 30;  // top + admin bar
		}
		if (left < 0)
		{
			left: 0;
		}

		if (modalHeight > this.windowHeight) // if height is higher than screen supports
		{
			var newHeight = this.windowHeight - top - 5;
			this.currentModal.height(newHeight);

			var newContentH = newHeight - headerHeight;
			$m.find('.modal_content').height(newContentH);

		}
		this.currentModal.css('left', left + 'px');
		this.currentModal.css('top', top + 'px');
		this.currentModal.css('height', modalHeight);


		$('.debugModal_overlay').show();
		$('body').addClass('shortpixel-modal-active');

		$(document).off('keydown', $.proxy(this.keyPressHandler, this));
		$(document).on('keydown', $.proxy(this.keyPressHandler, this));

		this.currentModal.trigger('focus');
	}

	debugModal.prototype.keyPressHandler = function (e)
	{
		if (e.keyCode === 27)
			this.close();
	}

	debugModal.prototype.checkResize = function ()
	{
		this.windowHeight = $(window).height();
		this.windowWidth = $(window).width();

		if (this.currentModal === null)
			return;

		this.currentModal.removeAttr('style');
		this.currentModal.find('.modal_content').removeAttr('style');
		this.currentModal.removeAttr('style');

		// redo sizes, repaint.

		this.show();
	}

	debugModal.prototype.close = function()
	{
		this.currentModal.trigger('modal_close', [this]);
		this.currentModal.remove();
		this.currentModal = null;
		$('.debugModal_overlay').remove();
		$('body').removeClass('shortpixel-modal-active');
		$(document).off('keydown', $.proxy(this.keyPressHandler, this));

	}

	debugModal.prototype.fadeOut = function (timeOut)
	{
		if (typeof timeOut == undefined)
			timeOut = 600;

		var self = this;
		this.currentModal.fadeOut(timeOut, function() { self.close(); } );

	}
	/* Set the modal content

	Sets the content of the modal. Do not run this function after adding controls.
	@param string HTML,text content of the modal
	*/
	debugModal.prototype.setContent = function(content)
	{
		this.currentModal.find('.modal_content').html(content);
	}

	/* Builds modal from hidden data

	Builds modal from an formatted data object in DOM. Triggered on Click

	*/
	debugModal.prototype.buildModal = function(e)
	{
		e.preventDefault();

		var target = $(e.target);
		if (typeof target.data('modal') == 'undefined')
		   target = target.parents('.debugModal');

		this.target = target;
		var id = target.data('modal');
		var data = $('#' + id);

		// options
		if (typeof data.data('width') !== 'undefined')
			this.setWidth = data.data('width');
		else
			this.setWidth = false;

		if (typeof data.data('height') !== 'undefined')
			this.setHeight = data.data('height');
		else
			this.setHeight = false;

	//	var title = $(data).find('.title').text();
	//	var controls = $(data).find('.controls').html();
		var content = $(data).find('.content').html();

		this.newModal(id);
		this.setContent(content);

		// callback on init
		if (typeof $(data).data('load') !== 'undefined')
		{

			// default call
			var funcName = data.data('load') + '(modal)';
			var callFunc = new Function ('modal', funcName);

		}

		this.show();
	}

	debugModal.prototype.newModal = function(id)
	{
		if (this.currentModal !== null)
			this.close();

		var modal = $('<div class="debug-modal ' + id + '" > \
						   <div class="modal_header"> \
							   <div class="modal_close dashicons dashicons-no"></div><h3 class="modal_title">Debug</h3> \
						   </div> \
						   <div class="inner modal_content"></div>\
					   </div>');
		if ($(this.parent).length > 0)
			$(this.parent).append(modal);
		else
			$('body').append(modal); // fallback in case of interrupting page builders

		$(modal).draggable({
			handle: '.modal_header'
		});

		this.modals.push(modal);
		this.currentModal = modal;


		document.querySelector('.debug-modal .modal_close').addEventListener('click', this.close.bind(this), { once: true} );

		return this;

	}

	debugModal.prototype.writeOverlay = function()
	{

		$(this.parent).append('<div class="debugModal_overlay"></div>');
		$('.debugModal_overlay').on('click', $.proxy(this.close, this));

	}

  var shortpixelDebug = new debugModal();
	shortpixelDebug.init();
}); // jquery
