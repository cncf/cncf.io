'use strict'

// New Class for Settings Section.
var ShortPixelSettings = function()
{

	 this.Init = function()
	 {
			this.InitActions();
			this.SaveOnKey();
	 }

	this.InitActions = function()
	{
			var toggles = document.querySelectorAll('[data-toggle]');
			var self = this;

			toggles.forEach(function (toggle, index)
			{
				//	var target = (action.getAttribute('data-toggle')) ? action.getAttribute('data-toggle') : 'click';
					toggle.addEventListener('change', self.DoToggleAction.bind(self));

					var evInit = new CustomEvent('change',  {detail : { init: true }} );
					toggle.dispatchEvent(evInit);
			});

			var modals = document.querySelectorAll('[data-action="open-modal"]');
			modals.forEach(function (modal, index)
			{
					modal.addEventListener('click', self.OpenModal.bind(self));
			});



	}


	this.DoToggleAction = function(event)
	{
			event.preventDefault();

			var checkbox = event.target;
			var target = document.getElementById(checkbox.getAttribute('data-toggle'));

		  if (typeof checkbox.dataset.toggleReverse !== 'undefined')
			{
				var checked = ! checkbox.checked;
			}
			else {
				var checked = checkbox.checked;
			}

			if (target === null)
			{
				 console.error('Target element ID not found', checkbox);
				 return false;
			}

			if (checked)
			{
			  // target.classList.add('is-visible');
				this.ShowElement(target);
			}
			else
			{
				this.HideElement(target);
  			//	target.classList.remove('is-visible');
			}
	}

	this.ShowElement = function (elem) {

	// Get the natural height of the element
	var getHeight = function () {
		elem.style.display = 'block'; // Make it visible
		var height = elem.scrollHeight + 'px'; // Get it's height
		elem.style.display = ''; //  Hide it again
		return height;
	};

	var height = getHeight(); // Get the natural height
	elem.classList.add('is-visible'); // Make the element visible
	elem.style.height = height; // Update the max-height

	// Once the transition is complete, remove the inline max-height so the content can scale responsively
	window.setTimeout(function () {
		elem.style.height = '';
	}, 350);

};

// Hide an element
this.HideElement = function (elem) {

	// Give the element a height to change from
	elem.style.height = elem.scrollHeight + 'px';

	// Set the height back to 0
	window.setTimeout(function () {
		elem.style.height = '0';
	}, 1);

	// When the transition is complete, hide it
	window.setTimeout(function () {
		elem.classList.remove('is-visible');
	}, 350);

};


this.OpenModal = function(elem)
{
		var target = elem.target;
		var targetElem = document.getElementById(target.dataset.target);
		if (! targetElem)
			return;

		var shade = document.getElementById('spioSettingsModalShade');
		var modal = document.getElementById('spioSettingsModal');

		shade.style.display = 'block';
		modal.classList.remove('spio-hide');

		var body = modal.querySelector('.spio-modal-body');
		body.innerHTML = ('afterbegin', targetElem.innerHTML); //.cloneNode()
		body.style.background = '#fff';
		shade.addEventListener('click', this.CloseModal.bind(this), {'once': true} );

		modal.querySelector('.spio-close-help-button').addEventListener('click', this.CloseModal.bind(this), {'once': true});

		if (body.querySelector('[data-action="ajaxrequest"]') !== null)
		{
			body.querySelector('[data-action="ajaxrequest"]').addEventListener('click', this.SendModal.bind(this));
		}

}

this.CloseModal = function(elem)
{
	var shade = document.getElementById('spioSettingsModalShade');
	var modal = document.getElementById('spioSettingsModal');

	shade.style.display = 'none';
	modal.classList.add('spio-hide');

}

this.SendModal = function(elem)
{
	var modal = document.getElementById('spioSettingsModal');
	var body = modal.querySelector('.spio-modal-body');
	var inputs = body.querySelectorAll('input');

	var data = {};
	var validated = true;

	for (var i = 0; i < inputs.length; i++)
	{
		 data[inputs[i].name] = inputs[i].value;
		 if (typeof inputs[i].dataset.required !== 'undefined')
		 {
			  if (inputs[i].value !== inputs[i].dataset.required)
				{
					 inputs[i].style.border = '1px solid #ff0000';
					 validated = false;
					 return false;
				}
		 }
	}

	if (! validated)
		return false;

	data.callback = 'shortpixelSettings.receiveModal'
	data.type = 'settings';

	window.addEventListener('shortpixelSettings.receiveModal', this.ReceiveModal.bind(this), {'once': true} );

	window.ShortPixelProcessor.AjaxRequest(data);

}

this.ReceiveModal = function(elem)
{


	 if (typeof elem.detail.settings.results !== 'undefined')
	 {
		 var modal = document.getElementById('spioSettingsModal');
	 	 var body = modal.querySelector('.spio-modal-body');

		 body.innerHTML = elem.detail.settings.results;
	 }

	 if (typeof elem.detail.settings.redirect !== 'undefined')
	 {
			window.location.href = elem.detail.settings.redirect;
	 }

}

this.SaveOnKey = function()
{
	var saveForm = document.getElementById('wp_shortpixel_options');
	if (saveForm === null)
		return false; // no form no save.

	window.addEventListener('keydown', function(event) {

    if (! (event.key == 's' || event.key == 'S')  || ! event.ctrlKey)
		{
			return true;
		}
		document.getElementById('wp_shortpixel_options').submit();
    event.preventDefault();
    return false;
	});
}


 	this.Init();
} // SPSettings


document.addEventListener("DOMContentLoaded", function(){
	  var s = new ShortPixelSettings();
});
