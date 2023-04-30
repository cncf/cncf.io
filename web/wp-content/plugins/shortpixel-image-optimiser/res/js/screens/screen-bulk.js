'use strict';

class ShortPixelScreen extends ShortPixelScreenBase
{

  isCustom = true;
  isMedia = true;

  panels = [];
  currentPanel = 'dashboard';

  debugCounter = 0;

	averageOptimization = 0;
	numOptimizations = 0;

	Init()
	{
	//	super(MainScreen, processor);



		// Hook up the button and all.
			this.LoadPanels();
			this.LoadActions();

			window.addEventListener('shortpixel.processor.paused', this.TogglePauseNotice.bind(this));
			window.addEventListener('shortpixel.processor.responseHandled', this.CheckPanelData.bind(this));
			window.addEventListener('shortpixel.bulk.onUpdatePanelStatus', this.EventPanelStatusUpdated.bind(this));
			window.addEventListener('shortpixel.bulk.onSwitchPanel', this.EventPanelSwitched.bind(this));
			window.addEventListener('shortpixel.reloadscreen', this.ReloadScreen.bind(this));


			var processData = ShortPixelProcessorData.startData;
			var initMedia = processData.media.stats;
			var initCustom = processData.custom.stats;
			var initTotal = processData.total.stats;
			var isPreparing = false;
			var isRunning = false;
			var isFinished = false;

			if (initMedia.is_preparing == true || initCustom.is_preparing == true )
				isPreparing = true;
			else if (initMedia.is_running == true || initCustom.is_running == true )
				isRunning = true;
			else if ( (initMedia.is_finished == true && initMedia.done > 0)  || (initCustom.is_finished == true && initCustom.done > 0) )
				isFinished = true;

				this.UpdateStats(initMedia, 'media'); // write UI.
				this.UpdateStats(initCustom, 'custom');
				this.UpdateStats(initTotal, 'total');
				this.CheckPanelData();

			if (isPreparing)
			{
				this.SwitchPanel('selection');
				this.UpdatePanelStatus('loading', 'selection');
				this.PrepareBulk();
			}
			else if (isRunning)
			{
				this.SwitchPanel('process');
				this.processor.PauseProcess(); // when loading, default start paused before resume.
			}
			else if (isFinished)
			{
				 this.processor.StopProcess({ waiting: true });

				 if (initMedia.done > 0 || initCustom.done > 0)
				 {

					 this.SwitchPanel('finished');
				 }
				 else
				 {
					 this.SwitchPanel('dashboard');
				 }
				 //this.SwitchPanel('process');  // needs to run a process and get back stats another try.
			}
			else if (initMedia.in_queue > 0 || initCustom.in_queue > 0)
			{
				this.SwitchPanel('summary');
			}
			else
			{
				 this.processor.StopProcess({ waiting: true }); // don't go peeking in the queue. // this doesn't work since its' before the init Worker.
				 this.SwitchPanel('dashboard');
			}

			if (this.processor.isManualPaused)
			{
					var event = new CustomEvent('shortpixel.processor.paused', { detail : {paused: 	this.processor.isManualPaused }});
			}

			// This var is defined in admin_scripts, localize.
			if ( typeof shortPixelScreen.panel !== 'undefined')
			{
				 this.SwitchPanel(shortPixelScreen.panel);
			}
	}

  LoadPanels()
  {
      var elements = document.querySelectorAll('section.panel');
      var self = this;
      elements.forEach(function (panel, index)
      {
          var panelName  = panel.getAttribute('data-panel');
          self.panels[panelName] = panel;
      });

  }

  LoadActions()
  {
      var actions = document.querySelectorAll('[data-action]');
      var self = this;

      actions.forEach(function (action, index)
      {
				  var eventName = (action.getAttribute('data-event')) ? action.getAttribute('data-event') : 'click';

					action.addEventListener(eventName, self.DoActionEvent.bind(self));
					/*
					This is off, since I can't find any clue that children don't get triggered, but it does create double events when added.
					if (action.children.length > 0)
					{
						 for(var i = 0; i < action.children.length; i++)
						 {
							 // action.children[i].addEventListener(eventName, self.DoActionEvent.bind(self));
						 }
					}
					*/
      });
  }

	DoActionEvent()
	{
		var element = event.target;
		var action = element.getAttribute('data-action');

		// Might be the child
		if (element.getAttribute('data-action') == null)
		{
			var element = element.parentElement;
		}
		if (element.disabled == true) // disabled button still register events, prevent going.
		{
			return false;
		}
		var actionName = element.getAttribute('data-action');
		var isPanelAction = (actionName == 'open-panel');

		if (isPanelAction)
		{
			 var doPanel = element.getAttribute('data-panel');
			 this.SwitchPanel(doPanel);
		}
		else
		{
				if (typeof this[actionName] == 'function')
				{
						this[actionName].call(this,event);
				}
		}
	}

  UpdatePanelStatus(status, panelName)
  {
     if (typeof panelName !== 'undefined')
      var panel = this.panels[panelName];
     else
      var panel = this.panels[this.currentPanel];

      var currentStatus = panel.getAttribute('data-status');
			panel.setAttribute('data-status', '');
			 setTimeout(function() {
				 panel.setAttribute('data-status', status);
			 }, 1000);

      var event = new CustomEvent('shortpixel.bulk.onUpdatePanelStatus', { detail : {status: status, oldStatus: currentStatus, panelName: panelName}});
      window.dispatchEvent(event);
  }

  ToggleLoading(loading)
  {
    if (typeof loading == 'undefined' || loading == true)
      var loading = true;
    else
      var loading = false;

    var loader = document.getElementById('bulk-loading');

    // This happens when out of quota.
    if (loader == null)
      return;

    if (loading)
      loader.setAttribute('data-status', 'loading');
    else
      loader.setAttribute('data-status', 'not-loading');

  }
  SwitchPanel(targetName)
  {
     console.debug('Switching Panel ' + targetName);

      this.ToggleLoading(false);
      if (! this.panels[targetName])
      {
        console.error('Panel ' + targetName + ' does not exist?');
        return;
      }
      else if (this.currentPanel == targetName)
      {
        return; // no switching needed.
      }

			// This detour is due to the issue that other plugins can attach prototype functions to array and this would return here.
			var panelKeys = Object.keys(this.panels);
			for (var i = 0; i < panelKeys.length; i++)
      {
				 var panelName = panelKeys[i];
         var panel = this.panels[panelName];

				 // Another prevention.
				 if (typeof panel.classList === 'undefined')
				 {
					 continue;
				 }

         panel.classList.remove('active');
         panel.style.display = 'none';
      };

      var panel = this.panels[targetName];

      panel.style.display = 'block';
      // This should be the time of transition needed.
  //    panel.classList.add('active');

    // This non-delay makes the transition fade in properly.
    setTimeout(function() { panel.classList.add('active'); }, 0);

       var oldCurrentPanel = this.currentPanel; // for event
       this.currentPanel = targetName;

       if ( panel.getAttribute('data-loadPanel') !== null)
       {

           this[panel.getAttribute('data-loadPanel')].call(this);
       }

       var event = new CustomEvent('shortpixel.bulk.onSwitchPanel', { detail : {panelLoad: targetName, panelUnload: oldCurrentPanel}});
       window.dispatchEvent(event);

  }
  CreateBulk()
  {
     console.log('Start Bulk');
     var data = {screen_action: 'createBulk', callback: 'shortpixel.PrepareBulk'}; //

     data.mediaActive = (document.getElementById('media_checkbox').checked) ? true : false;
     data.customActive = (document.getElementById('custom_checkbox').checked) ? true : false;
     data.webpActive = (document.getElementById('webp_checkbox').checked) ? true : false;
     data.avifActive = (document.getElementById('avif_checkbox').checked) ? true : false;

		 if (document.getElementById('thumbnails_checkbox') !== null)
		 		data.thumbsActive = (document.getElementById('thumbnails_checkbox').checked) ? true : false;

     this.UpdatePanelStatus('loading', 'selection');

     // Prepare should happen after selecting what the optimize.
     window.addEventListener('shortpixel.PrepareBulk', this.PrepareBulk.bind(this), {'once': true} );
     this.processor.AjaxRequest(data);
  }
  PrepareBulk(event)
  {
      //Remove pause
      if (typeof event == 'object')
        event.preventDefault(); // stop handler in checkResponse.


      this.processor.SetInterval(200); // do this faster.
      // CheckActive. Both Resume and Run call to processor process run.
      if (! this.processor.CheckActive())
      {
         this.processor.ResumeProcess();
      }
			else
			{
				this.processor.RunProcess();
			}
      return false;

      // Run process.run process from now for prepare ( until prepare done? )
  }
  QueueStatus(qStatus, data)
  {
      if (qStatus == 'PREPARING_DONE' || qStatus == 'PREPARING_RECOUNT')
      {
          console.log('Queue status: preparing done');

          this.SwitchPanel('summary');
 					this.UpdatePanelStatus('loaded', 'selection');
				  this.processor.SetInterval(-1); // back to default.

      }
      if (qStatus == 'QUEUE_EMPTY')
      {
					// @todo Pre-release fix, not clean. Fix.
					var total = data.total.stats.total;
					if (typeof total == 'string')
					{
						var pattern = new RegExp("\\.|\\,", '');
						total = total.replace(pattern, '');
					}


          if (total > 0)
          {
            this.SwitchPanel('finished'); // if something actually was done.
            this.processor.StopProcess();
          }
          else
          {
              this.SwitchPanel('dashboard'); // seems we are just at the begin.
              this.processor.StopProcess();

          } // empty queue, no items, start.
      }

  }
  HandleImage(resultItem, type)
  {

      var result = resultItem.result;
      if ( this.processor.fStatus[resultItem.fileStatus] == 'FILE_DONE')
      {
          this.UpdateData('result', result);

          if (document.querySelector('.image-preview-section').classList.contains('hidden')  )
          {
            document.querySelector('.image-preview-section').classList.remove('hidden');
          }

					this.HandleImageEffect(result.original, result.optimized);

          if (result.improvements.totalpercentage)
          {
							// Opt-Circle-Image is average of the file itself.
              var circle = document.querySelector('.opt-circle-image');

              var total_circle = 289.027;
              if(result.improvements.totalpercentage >0 ) {
                  total_circle = Math.round(total_circle-(total_circle*result.improvements.totalpercentage/100));
              }

              for( var i = 0; i < circle.children.length; i++)
              {
                 var child = circle.children[i];
                 if (child.classList.contains('path'))
                 {
                    child.style.strokeDashoffset = total_circle + 'px';
                 }
                 else if (child.classList.contains('text'))
                 {
                    child.textContent = result.improvements.totalpercentage + '%';
                 }
              }

							this.AddAverageOptimization(result.improvements.totalpercentage);
          }
					return true; // This prevents flooding.
      }
			else if (typeof resultItem.preview !== 'undefined' && resultItem.preview != false)
			{
				/* Preloading doesn't solve it.
				 var name = resultItem.preview.split(/[\\/]/).pop();
				 name = name.replace(/[^a-zA-Z0-9 ]/g, '');

				 var preLoader = document.getElementById('preloader');
				 if (preLoader.querySelector('[data-name="' + name + '"]') == null)
				 {
						var el = document.createElement('span');
						var img = document.createElement('img');
						img.src = resultItem.preview;
						el.appendChild(img);
						el.dataset.name = name;
						preloader.appendChild(el)
						console.log('preloading URL with name', name, resultItem.preview, el);

						// Remove from DOM after a while to prevent DOM bloating.
						if (preloader.children.length >= 10)
						{
							 preloader.children[0].remove();
						}
				 } */
			}

			return false;
  }

	// Function to neatly slide the new / old images around.
	HandleImageEffect(originalSrc, optimizedSrc)
	{

		var preview = document.getElementById('preview-structure');
		var offset = preview.offsetWidth;

		var placeHolder = preview.dataset.placeholder;

     if (preview.querySelector('.preview-image.old') !== null)
		 {
			  preview.querySelector('.preview-image.old').remove();
		 }

		var currentItem = preview.children[0];
		var newItem = preview.children[1];
		var cloneNode = newItem.cloneNode(true);


		if (originalSrc)
		{
			 preview.querySelector('.new.preview-image .image.source img').src = originalSrc;
		}
		else {
			preview.querySelector('.new.preview-image .image.source').style.display = 'none';
		}

		if (optimizedSrc)
		{
			 preview.querySelector('.new.preview-image .image.result img').src = optimizedSrc;
		}
		else {
			 preview.querySelector('.new.preview-image .image.result img').src = placeHolder;
			 preview.querySelector('.new.preview-image .image.result img').classList.add('notempty');

		}
		currentItem.style.marginLeft = '-' + offset + 'px';
		setTimeout(function() {

			newItem.classList.remove('new');
			newItem.classList.add('current');

			currentItem.remove();
		}, 1000);

		if (typeof cloneNode !== 'undefined')
		{
			cloneNode.querySelector('.image.source img').src = placeHolder;
			cloneNode.querySelector('.image.result img').src = placeHolder;
			preview.appendChild(cloneNode);
		}

	}

	AddAverageOptimization(num)
	{
			this.numOptimizations++;
			this.averageOptimization += num;

			var total = this.averageOptimization / this.numOptimizations;

			// There are circles on process and finished.
			var circles = document.querySelectorAll('.opt-circle-average');

			circles.forEach(function (circle)
			{
				var total_circle = 289.027;
				if( total  >0 ) {
						total_circle = Math.round(total_circle-(total_circle * total /100));
				}

				for(var i = 0; i < circle.children.length; i++)
				{
					 var child = circle.children[i];
					 if (child.classList.contains('path'))
					 {
							child.style.strokeDashoffset = total_circle + 'px';
					 }
					 else if (child.classList.contains('text'))
					 {
							child.textContent = Math.round(total) + '%';
					 }
				}
			}); // circles;
	}
  DoSelection() // action to update response.
  {
      // @todo Check the future of this function, since checking this is now createBulk.
      var data = {screen_action: 'applyBulkSelection'}; //
      data.callback = 'shortpixel.applySelectionDone';

      data.mediaActive = (document.getElementById('media_checkbox').checked) ? true : false;
      data.customActive = (document.getElementById('custom_checkbox').checked) ? true : false;
      data.webpActive = (document.getElementById('webp_checkbox').checked) ? true : false;
      data.avifActive = (document.getElementById('avif_checkbox').checked) ? true : false;

      window.addEventListener('shortpixel.applySelectionDone', function (e) { this.SwitchPanel('summary'); }.bind(this) , {'once': true} );
      this.processor.AjaxRequest(data);

  }

  UpdateStats(stats, type)
  {
      this.UpdateData('stats', stats, type);

  }
  // dataName refers to domain of data i.e. stats, result. Those are mentioned in UI with data-stats-media="total" or data-result
  UpdateData(dataName, data, type)
  {
      console.log('updating Data :',  dataName, data, type);

      if (typeof type == 'undefined')
      {
          var elements = document.querySelectorAll('[data-' + dataName + ']');
          var attribute = 'data-' + dataName;
      }
      else
      {
        var elements = document.querySelectorAll('[data-' + dataName + '-' + type + ']');
        var attribute = 'data-' + dataName + '-' + type;
      }

      if (elements)
      {
          elements.forEach(function (element, index)
          {
                var el = element.getAttribute(attribute);
                var presentation = false;
                if (element.hasAttribute('data-presentation'))
                  presentation = element.getAttribute('data-presentation');

                if (el == null)
                  return;
                var index = el.indexOf('-');
                if (index > -1)
                {
                   var first  = el.substr(0, index);
                   var second = el.substr(index+1);
                   if (typeof data[first] !== 'undefined' && typeof data[first][second] !== 'undefined')
                    var value = data[first][second];
                  else
                    var value = false;
                }
                else
                {
                   if (typeof data[el] !== 'undefined')
                    var value = data[el];
                   else
                    var value =  false;
                }

                if (presentation)
                {
                  if (value !== false)
                  {
                    if (presentation == 'css.width.percentage')
                      element.style.width = parseInt(value) + '%';
                    if (presentation == 'inputval')
                    {
                      element.value = value;
                    }
                    if (presentation == 'append')
                    {
                      element.innerHTML = element.innerHTML + value;
                    }
                  }
                }
                else
                {
                  if (value !== false)
									{

										element.textContent = value;

									}
                }

          });
      }
  }
	/** HandleError is used for item errors. The latter have a result object embedded and more information */
  HandleItemError(result, type)
  {
//    console.error(result);

		var fatal = false;
		var cssClass = '';
		var message = '';
		var info = '';

		if (typeof result.result !== 'undefined') // item error
		{
			 if (result.result)
			 {
			 		var item = result.result;
			 		var filename = (typeof item.filename !== 'undefined') ? item.filename : false;
			 		var message = item.message;
			 		var fatal = (item.is_done == true) ? true : false;
			 		if (filename)
			 		{
				  		message += ' (' + filename + ') ';
			 		}

					if (item.kblink)
					{
						var info = '<span class="kbinfo"><a href="' + result.kblink + '" target="_blank" ><span class="dashicons dashicons-editor-help">&nbsp;</span></a></span>';
					}
			 }

			 var error = this.processor.aStatusError[result.error];
			 if (error == 'NOQUOTA')
			 {

						 this.ToggleOverQuotaNotice(true);
			 }

		}
		else // unknown.
		{
    	var message = result.message + '(' + result.item_id + ')';
			console.error('Error without item - ' + message);

		}

		if (fatal)
			 cssClass += ' fatal';
		var data = {message: '<div class="'+ cssClass + '">' + message + info + '</div>'};
		this.UpdateData('error', data, type);

  }

	ToggleErrorBox(event)
	{

		 var type = event.target.getAttribute('data-errorbox');
		 var checked = event.target.checked;
		 var inputName = event.target.name;

			// There are multiple errorBoxes
			var errorBoxes = document.querySelectorAll('.errorbox.' + type);

			errorBoxes.forEach(function(errorbox)
			{
				if (checked === true)
				{
				 	errorbox.style.opacity = 1;
					errorbox.style.display = 'block';
				}
				else
				{
					errorbox.opacity = 0;
					errorbox.style.display = 'none';
				}
			}); //foreach

			var inputs = document.querySelectorAll('input[name="' + inputName + '"]');
			inputs.forEach(function (inputBox) {
					if (inputBox.getAttribute('data-errorbox') != type)
					{
						 return;
					}
					if (checked != inputBox.checked)
					{
						 // sync other boxes with same name and type
						 inputBox.checked = checked;
					}
			});
	}

  StartBulk() // Open panel action
  {
      console.log('Starting to Bulk!');
      var data = {screen_action: 'startBulk', callback: 'shortpixel.bulk.started'}; //

      // Prepare should happen after selecting what the optimize.
      //window.addEventListener('shortpixel.prepareBulk', this.PrepareBulk.bind(this), {'once': true} );
      this.processor.AjaxRequest(data);

      // process stops after preparing.
			// ResumeProcess, not RunProcess because that hits the pauseToggles.
			window.addEventListener('shortpixel.bulk.started', function() {
					this.processor.ResumeProcess();
				}.bind(this), {'once': true} );
      //this.processor.ResumeProcess();

      this.SwitchPanel('process');

  }
  PauseBulk(event)
  {
     this.processor.tooltip.ToggleProcessing(event);
  }

  ResumeBulk(event)
  {
      this.processor.ResumeProcess();
  }
  StopBulk(event)
  {
      if (confirm(shortPixelScreen.endBulk))
         this.FinishBulk(event);
  }
  FinishBulk(event)
  {
		// Screen needs reloading after doing all to reset all / load the logs.
    var data = {screen_action: 'finishBulk', callback: 'shortpixel.reloadscreen'}; //
    this.processor.AjaxRequest(data);
  }
	SkipPreparing()
	{
		this.processor.StopProcess({ waiting: true });
		this.SwitchPanel('summary');
		this.UpdatePanelStatus('loaded', 'selection');
		this.processor.tooltip.ProcessEnd();
		this.processor.SetInterval(-1); // back to default.
	}

	ReloadScreen(event)
	{
		 	//window.trigger('shortpixel.process.stop');
			var url = shortPixelScreen.reloadURL;
			location.href = url;

//			this.SwitchPanel('dashboard');

	}

  TogglePauseNotice(event)
  {
     var data = event.detail;

     var el = document.getElementById('processPaused'); // paused overlay
     var buttonPause  = document.getElementById('PauseBulkButton'); // process window buttons
     var buttonResume = document.getElementById('ResumeBulkButton');

     if(data.paused == true)
     {
        el.style.display = 'block';
        buttonPause.style.display = 'none';
        buttonResume.style.display = 'inline-block';

     }
     else
     {
        el.style.display = 'none';
        buttonPause.style.display = 'inline-block';
        buttonResume.style.display = 'none';

				// in case this is overquota situation, on unpause, recheck situation, hide the thing.
				this.ToggleOverQuotaNotice(false);
     }

		 var spinners = document.querySelectorAll('.line-progressbar-spinner');
		 for (var i =0; i < spinners.length; i++)
		 {
					 if (data.paused == true)
					 	spinners[i].classList.remove('spin');
					 else
					 	spinners[i].classList.add('spin');
		 }


  }

  // Everything that needs to happen when going overQuota.
	ToggleOverQuotaNotice (toggle)
	{
		 var overQ = document.getElementById('processorOverQuota');

		 if (toggle)
		 {
				overQ.style.display = 'block';
		 }
		 else
		 {
			   overQ.style.display = 'none';
		 }

	}

  EventPanelStatusUpdated(event)
  {
     var status = event.detail.status;
     var oldStatus = event.detail.oldStatus;
     var panelName = event.detail.panelName;

     console.log('Status Updated', event.detail);
  }
  EventPanelSwitched (event)
  {
      // @todo Might not be relevant in new paging order.
     console.log('Panel Switched', event.detail);
     var panelLoad = event.detail.panelLoad;
     var panelUnload = event.detail.panelUnload;

  }
  /* Checks number data and shows / hide elements based on that
  * data-check-visibility - will hide/show check against the defined data-control
  * data-control name must be a data-check- item at the number element - must be with value only.
  * data-check-control element will check against another number.
  * data-control must be 0 /higher than data-check-control to  get the check positive.

  */
  CheckPanelData() // function to check and hide certain areas if data is not happy.
  {
      // Element that should be hidden if referenced number is 0,NaN or elsewhat
      var panelControls = document.querySelectorAll('[data-control]');
      var self = this;

      panelControls.forEach(function (element, index)
      {

          var control = element.getAttribute('data-control');
              var hasCompareControl = element.hasAttribute('data-control-check');


          var checker = document.querySelector('[' + control + ']');

          // basic check if value > 0
          if (checker == null)
          {
            console.log('Control named ' + control + ' on ' + element.innerHTML + ' didn\'t find reference value element ');
            return;
          }

          var value = self.ParseNumber(checker.innerHTML);
          if ( hasCompareControl)
          {
            var compareControl = document.querySelector('[' + element.getAttribute('data-control-check') + ']');
            if (compareControl !== null) {
                var compareValue = self.ParseNumber(compareControl.innerHTML);
            }
          }
          if (isNaN(value))
          {
             var check = false;  // NaN can't play.
          }
          else if (hasCompareControl)
          {
             compareControl = document.querySelector('[' +  + ']');

             if (value > compareValue )
                var check = true;
             else
               var check = false;
          }
          else if (value <= 0)
          {
             var check = false;   // check failed.
          }
          else
          {
             var check = true;  // check succeeds
          }

          if (element.hasAttribute('data-check-visibility'))
          {
            var visibility = element.getAttribute('data-check-visibility'); // if check succeeds, show.
            if (visibility == null || visibility == 'true' || visibility == '')
               visibility = true;
            else // if check succeeds, hide.
               visibility = false;

            var hasHidden = element.classList.contains('hidden');
            if (check && hasHidden && visibility)
              element.classList.remove('hidden');
            else if (! check && ! hasHidden && visibility)
              element.classList.add('hidden');
            else if (check && ! visibility && ! hasHidden)
              element.classList.add('hidden');
            else if (! check && ! visibility && hasHidden)
              element.classList.remove('hidden');
          }
          else if ( element.hasAttribute('data-check-presentation'))
          {
              var presentation = element.getAttribute('data-check-presentation');
              if (presentation == 'disable')
              {
                  if (check)
                    element.disabled = false;
                  else
                    element.disabled = true;
              }
          }


      });

  }

  ToggleButton(event)
  {
      var checkbox = event.target;
      var target = document.getElementById(checkbox.getAttribute('data-target'));
      if (checkbox.checked)
      {
        target.disabled = false;
        target.classList.remove('disabled');
      }
      else
      {
         target.disabled = true;
         target.classList.add('disabled');
      }
  }

  BulkRestoreAll(event)
  {
    console.log('Start Restore All');
	//	var media = document.getElementById('restore_media_checkbox');
		var media = document.getElementById('restore_media_checkbox');
		var custom = document.getElementById('restore_custom_checkbox');
		var queues = [];

		// no checkboxes, only media in system => do media.
		if (media == null && custom == null)
		{
			 queues.push('media');
		}
		else if (media.checked == false && custom.checked == false) // pick one
		{
			 document.getElementById('restore_media_warn').classList.remove('hidden');
			 return false;
		}
		else // check which one
		{
			if (media.checked == true)
				queues.push('media');
			if (custom.checked == true)
				queues.push('custom');
		}
    var data = {screen_action: 'startRestoreAll', callback: 'shortpixel.startRestoreAll', queues: queues}; //

    // Prepare should happen after selecting what the optimize.
    window.addEventListener('shortpixel.startRestoreAll', this.PrepareBulk.bind(this), {'once': true} );
    window.addEventListener('shortpixel.bulk.onSwitchPanel', this.StartBulk.bind(this), {'once': true});
    this.processor.AjaxRequest(data);
  }

  BulkMigrateAll(event)
  {
    var data = {screen_action: 'startMigrateAll', callback: 'shortpixel.startMigrateAll'}; //

		this.UpdatePanelStatus('loading', 'selection');
		this.SwitchPanel('selection');

  	//this.SwitchPanel('process');

    // Prepare should happen after selecting what the optimize.
    window.addEventListener('shortpixel.startMigrateAll', this.PrepareBulk.bind(this), {'once': true} );
    window.addEventListener('shortpixel.bulk.onSwitchPanel', this.StartBulk.bind(this), {'once': true});
    this.processor.AjaxRequest(data);
  }
	BulkRemoveLegacy(event)
  {

    var data = {screen_action: 'startRemoveLegacy', callback: 'shortpixel.startRemoveLegacy'}; //

    this.SwitchPanel('selection');
    this.UpdatePanelStatus('loading', 'selection');
  	//this.SwitchPanel('process');

    // Prepare should happen after selecting what the optimize.
    window.addEventListener('shortpixel.startRemoveLegacy', this.PrepareBulk.bind(this), {'once': true} );
    window.addEventListener('shortpixel.bulk.onSwitchPanel', this.StartBulk.bind(this), {'once': true});
    this.processor.AjaxRequest(data);
  }
	StartBulkOperation(event)
	{
		this.PrepareBulk();

		this.UpdatePanelStatus('loading', 'selection');
		this.SwitchPanel('selection');


	}

	// Opening of Log files on the dashboard
	OpenLog(event)
	{
		 event.preventDefault();

    var data = {screen_action: 'loadLogFile', callback: 'shortpixel.showLogModal'};
		data['loadFile'] = event.target.getAttribute('data-file');
		data['type'] = 'log'; // for the answer.

		var modalData = this.GetModal();
		var modal = modalData[0];
		var title = modalData[1];
		var content = modalData[2];
		var wrapper = modalData[3];

		modal.classList.remove('shortpixel-hide');
		title.textContent = '';

		if (wrapper !== null)
			wrapper.innerHTML = '';
		else
			content.innerHTML = ''; //empty

		if (! content.classList.contains('sptw-modal-spinner'))
			content.classList.add('sptw-modal-spinner');

    window.addEventListener('shortpixel.showLogModal', this.ShowLogModal.bind(this), {'once': true});
    this.processor.AjaxRequest(data);
	}

	GetModal()
	{
			var modal = document.getElementById('LogModal');
			var wrapper = null;
			for (var i = 0; i < modal.children.length; i++)
			{
				 if (modal.children[i].classList.contains('title'))
				 {
				 	var title = modal.children[i];
				 }
				 else if (modal.children[i].classList.contains('content'))
				 {
					 if (modal.children[i].querySelector('.table-wrapper'))
					 {
						 	wrapper = modal.children[i].querySelector('.table-wrapper');
					 }
				   var content = modal.children[i];

				}
			}

			return [modal, title, content, wrapper];
	}

	ShowLogModal(event)
	{
			var log = event.detail.log;

			if (log.is_error == true)
			{
				console.error(log);
				this.CloseModal();
			}

			var shade = document.getElementById('LogModal-Shade');
			shade.style.display = 'block';
			shade.addEventListener('click', this.CloseModal.bind(this), {'once': true});

			var modalData = this.GetModal();
			var modal = modalData[0];
			var title = modalData[1];
			var content = modalData[2];
			var wrapper = modalData[3];

			title.textContent = log.title;

			var logType = log.logType;

			for (var i = 0; i < log.results.length; i++)
			{
				  if (i === 0)
						var html = '<div class="heading">';
					else
						var html = '<div>';

					if (i == 0)
					{
						for (var j = 0; j < log.results[i].length; j++ )
						{
							html += '<span>' + log.results[i][j] + '</span>';
						}
					}
					else if (log.results[i].length >= 3)
					{
						html += '<span>' + log.results[i][0] + '</span>';
						if (logType == 'custom')
							html += '<span>' + log.results[i][1] + '</span>';
						else
							html += '<span><a href="' + log.results[i][2] + '" target="_blank">' + log.results[i][1] + '</a></span>';

						if (log.results[i][4])
							var info = '<span class="kbinfo"><a href="' + log.results[i][4] + '" target="_blank" ><span class="dashicons dashicons-editor-help">&nbsp;</span></a></span>';
						else
							var info = '';
							html += '<span>' + log.results[i][3] + info + '</span>';
					}

					html += '</div>';

					if (wrapper !== null)
						wrapper.innerHTML += html;
					else
						content.innerHTML += html;

					content.classList.remove('sptw-modal-spinner');
			}

	}

	CloseModal(event)
	{
		 event.preventDefault();
 		 var modal = document.getElementById('LogModal');
		 modal.classList.add('shortpixel-hide');

		 var shade = document.getElementById('LogModal-Shade');
		 shade.style.display = 'none';
	}


} // Screen
