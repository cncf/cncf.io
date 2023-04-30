'use strict';

var ShortPixelToolTip = function(reserved, processor)
{
		this.strings = '';

    this.Init = function()
    {

        var paused =  localStorage.getItem('tooltipPause'); // string returns, not boolean
        if (paused == 'true')
        {
          console.log('manual paused (tooltip)');
          processor.PauseProcess();
        }
        var control = document.querySelector('.ab-item .controls');
				if (control)
        	control.addEventListener('click', this.ToggleProcessing.bind(this));

        this.ToggleIcon();

        if (processor.isManualPaused == true)
        {
            this.ProcessPause();
        }

			this.strings = spio_tooltipStrings;

      window.addEventListener('shortpixel.processor.paused', this.ProcessChange.bind(this));
    }
    this.GetToolTip = function() // internal function please.
    {
        var element =  document.querySelector('li.shortpixel-toolbar-processing');
				if (element === null)
				{
					 console.error('Tooltip could not be found!');
				}
				return element;
    }
		this.InitStats = function()
		{
		      var processData = ShortPixelProcessorData.startData;
					if (typeof processData !== 'object')
					{
						 console.error('Tooltip: No start Data found.');
						 return false;
					}
					this.RefreshStats(processData.media.stats, 'media');
					this.RefreshStats(processData.custom.stats, 'custom');
					this.RefreshStats(processData.total.stats, 'total');

					// Hide Tooltip is manual paused is true, but there is also nothing to do.
					if (processor.isManualPaused == true && processData.total.stats.total <= 0)
					{
						 this.ProcessEnd();
					}
		}
		// Used to put a 'todo' number in the tooltip when processing
    this.RefreshStats = function(stats, type)
    {
				var neededType;

				if (processor.screen.isMedia == true && processor.screen.isCustom == true)
					neededType = 'total';
				else if (processor.screen.isMedia == true && processor.screen.isCustom == false)
					neededType = 'media';
				else if (processor.screen.isMedia == false && processor.screen.isCustom == true)
					neededType = 'custom';

				if (neededType !== type)
					return;

        var toolTip = this.GetToolTip();
				if (toolTip === null)
					return false;

        var statTip = toolTip.querySelector('.stats');

        if (statTip == null)
          return;

				var inqueue = stats.in_queue;
				var inprocess = stats.in_process;

				// @todo This needs fixing.
				var pattern = new RegExp("\\.|\\,", '');

				if (typeof inqueue === 'string'  && inqueue)
						inqueue = inqueue.replace(pattern,''); // remove number formats
				if (typeof inprocess === 'string' && inprocess)
						inprocess = inprocess.replace(pattern,''); // remove number formats

				var number = parseInt(inqueue) + parseInt(inprocess);
        statTip.textContent = this.FormatNumber(number);

				// Updating the titles.

			  var itemTitle = statTip.textContent + ' ';
				itemTitle +=  (number == 1) ? this.strings.item : this.strings.items;

				if (toolTip.querySelector('#short-pixel-notice-toolbar') !== null)
				{
					toolTip.querySelector('#short-pixel-notice-toolbar').title = this.strings.processing + ' ' + itemTitle;
				}
				if (toolTip.querySelector('.dashicons.pause') !== null)
				{
					toolTip.querySelector('.dashicons.pause').title = itemTitle + '\n\n' + this.strings.pause;
				}
				if (toolTip.querySelector('.dashicons.play') !== null)
				{
					toolTip.querySelector('.dashicons.play').title = itemTitle + '\n\n' + this.strings.resume;
				}

        if (statTip.classList.contains('hidden') && number > 0)
          statTip.classList.remove('hidden');
        else if (! statTip.classList.contains('hidden') && number == 0)
          statTip.classList.add('hidden');
    }

		this.FormatNumber = function(num)
		{
				var digits = 1;
				  var si = [
		    { value: 1E18, symbol: "E" },
		    { value: 1E15, symbol: "P" },
		    { value: 1E12, symbol: "T" },
		    { value: 1E9,  symbol: "G" },
		    { value: 1E6,  symbol: "M" },
		    { value: 1E3,  symbol: "k" }
		  ], i;
				  for (i = 0; i < si.length; i++) {
				    if (num >= si[i].value) {
				      return (num / si[i].value).toFixed(digits).replace(/\.?0+$/, "") + si[i].symbol;
				    }
			  }
  	return num;
	}

    this.ToggleProcessing = function(event)
    {
       event.preventDefault();
       //event.stopProp

       if (processor.isManualPaused == false)
       {
          processor.PauseProcess();
          localStorage.setItem('tooltipPause','true');
          this.ProcessPause();
       }
        else
       {
          processor.ResumeProcess();
          localStorage.setItem('tooltipPause','false');
          this.ProcessResume();
       }

       processor.CheckActive();

    }

    this.ToggleIcon = function()
    {
      var controls = document.querySelectorAll('.ab-item .controls > span');

      for(var i = 0; i < controls.length; i++)
      {
          var control = controls[i];
          if (control.classList.contains('pause'))
          {
            if (processor.isManualPaused == true)
              control.classList.add('hidden');
            else
              control.classList.remove('hidden');
          }
           else if (control.classList.contains('play'))
          {
            if (processor.isManualPaused == false)
              control.classList.add('hidden');
            else
              control.classList.remove('hidden');
          }
      }
    }

    this.DoingProcess = function()
    {
        var tooltip = this.GetToolTip();
				if (tooltip === null)
					return false;
        tooltip.classList.remove('shortpixel-hide');
        tooltip.classList.add('shortpixel-processing');
    }

    this.AddNotice = function(message)
    {
      var tooltip = this.GetToolTip(); // li.shortpixel-toolbar-processing
			if (tooltip === null)
				return false;
      var toolcontent = tooltip.querySelector('.toolbar-notice-wrapper');

			if (toolcontent == null)
			{
					var abItem = tooltip.querySelector('.ab-item');
					var wrapper = document.createElement('div');
					wrapper.className = 'toolbar-notice-wrapper';
					abItem.parentNode.insertBefore(wrapper, abItem.nextSibling);
					var toolcontent = tooltip.querySelector('.toolbar-notice-wrapper');
			}

			var id = message.replace(/[^a-zA-Z ]/g, "").replace(/ /g, "").slice(0,20);

      var alert = document.createElement('div');
			alert.dataset.msgid = id;
      alert.className = 'toolbar-notice toolbar-notice-error';
      alert.innerHTML = message;

			// Prevent double notices with same message
			if (toolcontent.querySelector('[data-msgid="' + id + '"]') == null)
			{
      	var alertChild = toolcontent.appendChild(alert);
      	window.setTimeout (this.RemoveNotice.bind(this), 5000, alertChild);
			}
    }


    this.RemoveNotice = function(notice)
    {
        notice.style.opacity = 0;
        window.setTimeout(function () { notice.remove() }, 2000);

    }
    this.ProcessResume = function()
    {
      var tooltip = this.GetToolTip();
			if (tooltip === null)
				return false;
      tooltip.classList.remove('shortpixel-paused');
      tooltip.classList.add('shortpixel-processing');
      this.ToggleIcon();

    }
    this.ProcessEnd = function()
    {
        var tooltip = this.GetToolTip();
				if (tooltip === null)
				{
					return false;
				}
        tooltip.classList.add('shortpixel-hide');
        tooltip.classList.remove('shortpixel-processing');
    }
    this.ProcessPause = function()
    {
        var tooltip = this.GetToolTip();
				if (tooltip === null)
					return false;

        tooltip.classList.add('shortpixel-paused');
        tooltip.classList.remove('shortpixel-processing');
        tooltip.classList.remove('shortpixel-hide');
        this.ToggleIcon();

    }
    this.ProcessChange = function(e)
    {
        var detail = e.detail;

        if (detail.paused == false)
           this.ProcessResume();
        else
           this.ProcessPause();
    }
    this.HandleError = function()
    {
					console.trace('tooltip error');
    }

this.Init();
} // tooltip.
