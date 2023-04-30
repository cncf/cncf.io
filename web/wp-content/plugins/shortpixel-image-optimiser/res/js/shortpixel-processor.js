
/*** ShortPixel Image Processor ***
* The processor sends via a browser worker tasks in form of Ajax Request to the browser
* Ajax returns from browser are processed and then delegated to the screens
* Every function starts via capitals and camelcased i.e. LoadWorker
* Normal variables are camel-cased.
*
* The remote secret is to prevent several browser clients on different computers but on same site to start processing.
* This is to limit performance usages on sites with a large number of backend users.
*
* -- Screens --
* A Screen is responsible for putting received values to UI
* Required function of screen are : HandleImage HandleError UpdateStats
* Optional functions :  QueueStatus, GeneralResponses
*/
'use strict';

window.ShortPixelProcessor =
{
  //  spp: {},
    isActive: false,
    defaultInterval: 3000, // @todo customize this from backend var, hook filter.  default is onload interval
    interval: 3000, // is current interval. When nothing to be done increases
    deferInterval: 15000, // how long to wait between interval to check for new items.
    screen: null, // UI Object
    tooltip: null,
    isBulkPage: false,
    localSecret: null,
    remoteSecret: null,
    isManualPaused: false,  // tooltip pause :: do not set directly, but only trhough processor functions!
    worker: null,
    timer: null,
    waitingForAction: false, // used if init yields results that should pause the processor.
    timesEmpty: 0, // number of times queue came up empty.
    nonce: [],
		hasStartQuota: false, // if we start without quota, don't notice too much, don't run.
		workerErrors: 0, // times worker encoutered an error.
    qStatus: { // The Queue returns
       1:  'QUEUE_ITEMS',
       4:  'QUEUE_WAITING',
       10: 'QUEUE_EMPTY',
       2:  'PREPARING',
       3:  'PREPARING_DONE',
       11: 'PREPARING_RECOUNT',
    },
    fStatus: { // FileStatus of ImageModel
      '-1': 'FILE_ERROR',
       1: 'FILE_PENDING',
       2: 'FILE_DONE',
       3: 'FILE_RESTORED',
    },
    rStatus: { // ResponseController
       1: 'RESPONSE_ACTION', // when an action has been performed *not used*
       2: 'RESPONSE_SUCCESS', // not sure this one is needed *not used*
       10: 'RESPONSE_ERROR',
       11: 'RESPONSE_WARNING', // *not used*
       12: 'RESPONSE_ERROR_DELAY', // when an error is serious enough to delay things.*not used*
    },
    aStatusError: {  // AjaxController / optimizeController - when an error occured
        '-1': 'PROCESSOR_ACTIVE', // active in another window
        '-2': 'NONCE_FAILED',
        '-3': 'NO_STATUS',
        '-4': 'APIKEY_FAILED',
        '-5': 'NOQUOTA',
        '-10': 'SERVER FAILURE',
				'-903': 'TIMEOUT', // SPIO shortQ retry limit reached.
     },
  /*  apiStatusError: {

  } */

    Load: function(hasQuota)
    {

			window.addEventListener('error', this.ScriptError.bind(this));

        this.isBulkPage = ShortPixelProcessorData.isBulkPage;
        this.localSecret = localStorage.getItem('bulkSecret');
        this.remoteSecret = ShortPixelProcessorData.bulkSecret;

        this.nonce['process'] = ShortPixelProcessorData.nonce_process;
        this.nonce['exit'] = ShortPixelProcessorData.nonce_exit;
        this.nonce['itemview'] = ShortPixelProcessorData.nonce_itemview;
        this.nonce['ajaxRequest'] = ShortPixelProcessorData.nonce_ajaxrequest;

				if (hasQuota == 1)
					this.hasStartQuota = true;


				if (ShortPixelProcessorData.interval && ShortPixelProcessorData.interval > 100)
				this.interval = ShortPixelProcessorData.interval;

				if (ShortPixelProcessorData.interval && ShortPixelProcessorData.interval > 100)
				this.deferInterval = ShortPixelProcessorData.deferInterval;


        console.log('Start Data from Server', ShortPixelProcessorData.startData, this.interval, this.deferInterval);
        console.log('remoteSecret ' + this.remoteSecret + ', localsecret: ' + this.localSecret);


        this.tooltip = new ShortPixelToolTip({}, this);

        if (typeof ShortPixelScreen == 'undefined')
        {
           console.error('Missing Screen!');
           return;
        }
        else
				{
          this.screen = new ShortPixelScreen({}, this);
					this.screen.Init();
				}

				// Load the Startup Data (needs screen)
				this.tooltip.InitStats();

        // Always load worker, also used for UI actions.
        this.LoadWorker();

        if (this.CheckActive())
        {
					 	if (this.hasStartQuota)
            	 this.RunProcess();
        }

    },
    CheckActive: function()
    {

      if (this.remoteSecret == false || this.remoteSecret == '' || this.isBulkPage) // if remoteSecret is false, we are the first process. Take it.
      {
      //   this.localSecret = this.remoteSecret = Math.random().toString(36).substring(7);
         if (this.localSecret && this.localSecret.length > 0)
         {
           this.remoteSecret = this.localSecret;
         }
         else
         {
           this.localSecret = Math.random().toString(36).substring(7);
           localStorage.setItem('bulkSecret',this.localSecret);
					 // tell worker to use correct key.
					 this.worker.postMessage({'action' : 'updateLocalSecret',
					 'key': this.localSecret });
         }
         this.isActive = true;
      }
      else if (this.remoteSecret === this.localSecret) // There is a secret, we are the processor.
      {
         this.isActive = true;
      }
      else
      {
         console.debug('Check Active: Processor not active - ' + this.remoteSecret + ' - ' + this.localSecret);
         this.tooltip.ProcessEnd();
         this.StopProcess();
      }

      if (this.isManualPaused)
      {
          this.isActive = false;
				//	this.tooltip.ProcessEnd();
        //  this.PauseProcess();
         console.debug('Check Active: Paused');
      }
      if (this.waitingForAction)
      {
          this.isActive = false;
					this.tooltip.ProcessEnd();
          console.debug('Check Active : Waiting for action');
      }
      return this.isActive;
    },
    LoadWorker: function()
    {
        if (window.Worker)
        {
            var ajaxURL = ShortPixel.AJAX_URL;
            var nonce = '';
            console.log('Starting Worker');

            this.worker = new Worker(ShortPixelProcessorData.workerURL);

            var isBulk = false;
            if (this.isBulkPage)
               isBulk = true;

            this.worker.postMessage({'action' : 'setEnv',
            'data': {'isBulk' : isBulk, 'isMedia': this.screen.isMedia, 'isCustom': this.screen.isCustom, 'ajaxUrl' : ajaxURL, 'secret' : this.localSecret}
            });

            /*this.worker.postMessage({'action': 'init', 'data' : [ajaxURL, this.localSecret], 'isBulk' : isBulk}); */
            this.worker.onmessage = this.CheckResponse.bind(this);
            window.addEventListener('beforeunload', this.ShutDownWorker.bind(this));

        }
    },
    ShutDownWorker: function()
    {
        if (this.worker === null) // worker already shut / not loaded
          return false;


        console.log('Shutting down Worker');
        this.worker.postMessage({'action' : 'shutdown', 'nonce': this.nonce['exit'] });
      //  this.worker.terminate();
        this.worker = null;
        window.removeEventListener('beforeunload', this.ShutDownWorker.bind(this));
        window.removeEventListener('shortpixel.loadItemView', this.LoadItemView.bind(this));
    },
    Process: function()
    {
        if (this.worker === null)
				{
           this.LoadWorker(); // JIT worker loading
				}

        //this.tooltip.DoingProcess();
        this.worker.postMessage({action: 'process', 'nonce' : this.nonce['process']});

    },
    RunProcess: function()
    {
        if (this.timer)
        {
          window.clearTimeout(this.timer);
        }

        if (! this.CheckActive())
        {
            return;
        }
        //if (this.timesEmpty >= 5) // conflicts with the stop defer.
        //   this.interval = 2000 + (this.timesEmpty * 1000);  // every time it turns up empty, second slower.

        console.log('Processor: Run Process in ' + this.interval);

        this.timer = window.setTimeout(this.Process.bind(this), this.interval);
    },
    PauseProcess: function() // This is a manual intervention.
    {
      this.isManualPaused = true;
      var event = new CustomEvent('shortpixel.processor.paused', { detail : {paused: this.isManualPaused }});
      window.dispatchEvent(event);
      console.log('Processor: Process Paused');
      window.clearTimeout(this.timer);

    },
    StopProcess: function(args)
    {
        console.log('Stop Processing #' + this.timer);

				// @todo this can probably go? Why would StopProcess cancel Manual pauses?
        if (this.isManualPaused == true) /// processor ends on status paused.
        {
            this.isManualPaused = false;
            var event = new CustomEvent('shortpixel.processor.paused', { detail : {paused: this.isManualPaused}});
            window.dispatchEvent(event);
        }
        window.clearTimeout(this.timer);

        if (typeof args == 'object')
        {
           if (typeof args.defer !== 'undefined' && args.defer)
           {
                this.timesEmpty++;
                console.log('Stop, defer wait :' + (this.deferInterval * this.timesEmpty), this.timesEmpty);
                this.SetInterval( (this.deferInterval * this.timesEmpty) ); //set a long interval
                this.RunProcess(); // queue a run once
                this.SetInterval(-1); // restore interval
           }
           else if (typeof args.waiting !== 'undefined')
           {
             console.log('Stop Process: Waiting for action');
             this.waitingForAction = args.waiting;
           }
        }

        this.tooltip.ProcessEnd();
    },
    ResumeProcess: function()
    {
      this.isManualPaused = false;
      this.waitingForAction = false;
			localStorage.setItem('tooltipPause','false'); // also remove the cookie so it doesn't keep hanging on page refresh.

      var event = new CustomEvent('shortpixel.processor.paused', { detail : {paused: this.isManualPaused}});
      window.dispatchEvent(event);


      this.Process(); // don't wait the interval to go on resume.
    },
    SetInterval: function(interval)
    {
       if (interval == -1)
         this.interval = this.defaultInterval;
      else
        this.interval = interval;

    },
    CheckResponse: function(message)
    {
      var data = message.data;

      if (data.status == true && data.response) // data status is from shortpixel worker, not the response object
      {
          var response = data.response;
					var handledError = false; // prevent passing to regular queueHandler is some action is taken.
					this.workerErrors = 0;

          if ( response.callback)
          {
              console.log('Running callback : ' + response.callback);
              var event = new CustomEvent(response.callback, {detail: response, cancelable: true});
              var checkPrevent = window.dispatchEvent(event);

              if (! checkPrevent) // if event is preventDefaulted, stop checking response
                return;
          }
          if ( response.status == false)
          {

             // This is error status, or a usual shutdown, i.e. when process is in another browser.
             var error = this.aStatusError[response.error];
             if (error == 'PROCESSOR_ACTIVE')
             {
               this.Debug(response.message);
							 handledError = true;
               this.StopProcess();
             }
             else if (error == 'NONCE_FAILED')
             {
               this.Debug('Nonce Failed', 'error');
             }
             else if (error == 'NOQUOTA')
             {
							  if (this.hasStartQuota)
                	this.tooltip.AddNotice(response.message);

								this.screen.HandleError(response);
                this.Debug('No Quota - CheckResponse handler');
								this.PauseProcess();
								handledError = true;
             }
						 else if (error == 'APIKEY_FAILED')
						 {
							 this.StopProcess();
							 handledError = true;
							 console.error('No API Key set for this site. See settings');
						 }
             else if (response.error < 0) // something happened.
             {
               this.StopProcess();
							 handledError = true;
							 console.error('Some unknown error occured!', response.error, response);
             }

						 if (handledError == true)
						 	 	return;
           } // status false handler.

           // Check the screen if we are custom or media ( or bulk ) . Check the responses for each of those.
           if (typeof response.custom == 'object' && response.custom !== null)
           {
               this.HandleResponse(response.custom, 'custom');
           }
           if (typeof response.media == 'object' && response.media !== null)
           {
                this.HandleResponse(response.media, 'media');
           }
           // Total is a response type for combined stats in the bulk.
           if (typeof response.total == 'object' && response.total !== null)
           {
              this.HandleResponse(response.total, 'total');
           }

           this.HandleQueueStatus(response);

           if (response.processorKey)
           {
              this.remoteSecret = response.processorKey;
           }

           if (response.responses)
           {
              if (typeof this.screen.GeneralResponses == 'function')
              {
                  this.screen.GeneralResponses(response.responses);
              }
           }
      }
      else  // This is a worker error / http / nonce / generail fail
      {
						this.workerErrors++;
						this.timesEmpty = 0; // don't drag it.

						if (data.message)
						{
							 this.screen.HandleError(data.message);
							 //var message = String(data.message); // whatever this is, cast to string
							 //this.tooltip.AddNotice(message);
							 this.Debug(data.message, 'error');
						}

						if (this.workerErrors >= 3)
						{
							this.screen.HandleErrorStop();
							console.log('Shutting down . Num errors: ' + this.workerErrors);
							this.StopProcess();
							this.ShutDownWorker();
						}
						else
						{
							this.StopProcess({ defer: true });
								console.log('Stop / defer');
						}
      }

			// Binded to bulk-screen js for checking data.
      var event = new CustomEvent('shortpixel.processor.responseHandled', { detail : {paused: this.isManualPaused}});
      window.dispatchEvent(event);
    },
    HandleResponse: function(response, type)
    {
        // Issue with the tooltip is when doing usual cycle of emptiness, a running icon is annoying to user. Once queries and yielded results, it might be said that the processor 'is running'
				console.log('Handle Response - Tooltipping');
        this.tooltip.DoingProcess();

        if (response.has_error == true)
        {
           this.tooltip.AddNotice(response.message);
           //this.screen.HandleError(response, type);
        }

        if (! this.screen)
        {
           console.error('Missing screen - can\'t report results');
           return false;
        }

        // Perhaps if optimization, the new stats and actions should be generated server side?

         // If there are items, give them to the screen for display of optimization, waiting status etc.
				 var imageHandled = false;  // Only post one image per result-set to the ImageHandler (on bulk), to prevent flooding.

				 // @todo Make sure that .result and .results can be iterated the same.
         if (typeof response.results !== 'undefined' && response.results !== null)
         {
             for (var i = 0; i < response.results.length; i++)
             {
                var imageItem = response.results[i];
								if (imageItem == null || ! imageItem.result)
								{
									 console.error('Expecting ImageItem Object with result ', imageItem);
									 continue;
								}
                if (imageItem.result.is_error)
								{
                  this.HandleItemError(imageItem, type);
								}

								if (! imageHandled)
								{
                	imageHandled = this.screen.HandleImage(imageItem, type);
								}

             }
         }
         if (typeof response.result !== 'undefined' && response.result !== null)
         {
              if (response.result.is_error)
							{
									this.HandleItemError(response.result, type);
							}
							else if (! imageHandled)
							{
              	imageHandled = this.screen.HandleImage(response, type); // whole response here is single item. (final!)
							}
         }

         // Queue status?
         if (response.stats)
         {
            this.tooltip.RefreshStats(response.stats, type);
            this.screen.UpdateStats(response.stats, type);
         }

    },
    /// If both are reported back, both did tick, so both must be considered.
    HandleQueueStatus: function(data)
    {
      var mediaStatus = 100;
			var customStatus = 100;

      if (typeof data.media !== 'undefined' && typeof data.media.qstatus !== 'undefined' )
         mediaStatus = data.media.qstatus;
      if (typeof data.custom !== 'undefined' && typeof data.custom.qstatus !== 'undefined')
        customStatus = data.custom.qstatus;


        // The lowest queue status (for now) equals earlier in process. Don't halt until both are done.
        if (mediaStatus <= customStatus)
          var combinedStatus = mediaStatus;
        else
          var combinedStatus = customStatus;

      if (combinedStatus == 100)
			{
					this.StopProcess({ defer: true });
		       return false; // no status in this request.
			}

      if (typeof combinedStatus !== 'undefined')
      {
         var qstatus = this.qStatus[combinedStatus];
          if (qstatus == 'QUEUE_ITEMS' || qstatus == "PREPARING")
          {
            console.log('Qstatus Preparing or items returns');
             this.timesEmpty = 0;
             this.RunProcess();
          }
          if (qstatus == 'QUEUE_WAITING')
          {
             console.log('Item in Queue, but waiting');
             this.timesEmpty++;
             this.RunProcess(); // run another queue with timeout
          }
          else if (qstatus == 'QUEUE_EMPTY')
          {
              console.debug('Processor: Empty Queue');
              //this.tooltip.ProcessEnd();
              this.StopProcess({ defer: true });
          }
          else if (qstatus == "PREPARING_DONE")
          {
              console.log('Processor: Preparing is done');
              this.StopProcess();
          }

          // React to status of the queue.
          if (typeof this.screen.QueueStatus == 'function')
           this.screen.QueueStatus(qstatus, data);
      }
    },

    HandleItemError : function(result, type)
    {
        console.log('Handle Item Error', result, type);
        var error = this.aStatusError[result.error];

        if (error == 'NOQUOTA' )
        {
          this.PauseProcess();
        }

        this.screen.HandleItemError(result, type);


    },
    LoadItemView: function(data)
    {
  //    var data = event.detail;
      var nonce = this.nonce['itemview'];
      this.worker.postMessage({action: 'getItemView', 'nonce' : this.nonce['itemview'], 'data': { 'id' : data.id, 'type' : data.type, 'callback' : 'shortpixel.RenderItemView'}});
    },

    AjaxRequest: function(data)
    {
       var localWorker = false;

       this.worker.postMessage({action: 'ajaxRequest', 'nonce' : this.nonce['ajaxRequest'], 'data': data });
    },
		GetPluginUrl: function()
		{
			 return ShortPixelConstants[0].WP_PLUGIN_URL;
		},
    Debug: function (message, messageType)
    {
      if (typeof messageType == 'undefined')
        messageType = 'debug';

      if (messageType == 'debug')
      {
         console.debug(message);
      }
      if (messageType == 'error')
      {
          console.error('Error: ' + message);

      }

    },

		ScriptError: function(error)
		{
			  console.trace('Script Error! ', error);
		}


}
