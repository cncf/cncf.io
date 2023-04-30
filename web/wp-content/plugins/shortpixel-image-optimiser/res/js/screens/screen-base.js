'use strict';

class ShortPixelScreenBase
{
	isCustom = true;
	isMedia = true;
	processor;
	strings = [];


	constructor(MainScreen, processor)
	{
		 this.processor = processor;
		 this.strings = spio_screenStrings;

	}

	// Function for subclasses to add more init. Seperated because of screens that need to call Process functions when starting.
	Init()
	{

	}

//	var message = {status: false, http_status: response.status, http_text: text, status_text: response.statusText };
	HandleError(data)
	{
		var text = String(data.http_text);
		var title = this.strings.fatalError;
		var notice = this.GetErrorNotice(title, text);

 		var el = this.GetErrorPosition();
		if (el === null)
		{
				console.error('Cannot display error - no position found!');
				return;
		}
		el.prepend(notice);

	}

	HandleErrorStop()
	{
		  var title = this.strings.fatalErrorStop;
			var text = this.strings.fatalErrorStopText;

			var notice = this.GetErrorNotice(title, text);
			var el = this.GetErrorPosition();
			if (el === null)
			{
				console.error('Cannot display error - no position found!');
				return;
			}
		el.prepend(notice);
	}


	GetErrorNotice(title, text)
	{
		  var notice = document.createElement('div');
			notice.classList.add('notice', 'notice-error', 'is-dismissible');

			notice.innerHTML += '<p><strong>' + title + '</strong></p>';
			notice.innerHTML += '<div class="error-details">' + text + '</div>';
			return notice;

	}

	// Search for where to insert the notice before ( ala WP system )
	GetErrorPosition()
	{
		var el = document.querySelector('.is-shortpixel-settings-page');
		if (el !== null) // we are on settings page .
		{
			 return el;
		}

		var el = document.querySelector('#wpbody-content');
		if (el !== null)
			return el;


		return null;
	}

	Init()
	{

	}
	HandleImage(result, type)
	{
			return true;
	}

	UpdateStats()
	{

	}


	RenderItemView(e)
	{

	}

	// @todo Find a better home for this. Global screen class?
	ParseNumber(str)
	{
		 str = str.replace(',','', str).replace('.','',str);
		 return parseInt(str);
	}

}
