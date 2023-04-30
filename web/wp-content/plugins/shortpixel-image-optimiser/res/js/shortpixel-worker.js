'use strict';

onmessage = function(e)
{

  var action = e.data.action;
  var data = e.data.data;
  var nonce = e.data.nonce;
  var isBulk = false;

  SpWorker.nonce = nonce;

  if (typeof e.data.isBulk !== 'undefined')
     isBulk = e.data.isBulk;

  switch(action)
  {
     case 'setEnv':
        SpWorker.SetEnv(data);
     break;
     case 'shutdown':
        SpWorker.ShutDown();
     break;
     case 'process':
       SpWorker.Process(data);
     break;
     case 'getItemView':
       SpWorker.GetItemView(data);
     break;
     case 'ajaxRequest':
      SpWorker.AjaxRequest(data);
     break;
		 case 'updateLocalSecret':

		  var key = e.data.key;
		  SpWorker.UpdateLocalSecret(key);
		 break;
  }

}

var SpWorker = {
   ajaxUrl: null,
   action: 'shortpixel_image_processing',
   secret: null,
   nonce: null,
   isBulk: false, // If we are on the bulk screen  / queue
   isCustom: false, // Process this queueType - depends on screen
   isMedia: false,  // Process this queueType  - depends on screen.
	 stopped: false,

   Fetch: async function (data)
   {

      var params = new URLSearchParams();
      params.append('action', this.action);
      params.append('bulk-secret', this.secret);
      params.append('nonce', this.nonce);
      params.append('isBulk', this.isBulk);

      var queues = [];
      if (this.isMedia == true)
        queues.push('media');
      if (this.isCustom == true)
        queues.push('custom');

      params.append('queues', queues);

      if (typeof data !== 'undefined' && typeof data == 'object')
      {
         for(var key in data)
             params.append(key, data[key]);
      }

      var response = await fetch(this.ajaxUrl, {
          'method': 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
          },
          body: params.toString(),

      }).catch (function (error){
					 if (this && ! this.stopped) // if page is switched during init , this might not be set.
					 {
					 		postMessage({'status' : false, message: error});
					 		console.error('Worker.js reporting issue on catch', error);
					 }
					 else {
					 	console.log('stopped but not complaining!');
					 }
					return false;
				});

      if (response.ok)
      {
          var json = await response.json();

          postMessage({'status' : true, response: json});
      }
      else if(this && ! this.stopped)
      {
				var text = await response.text();
				var message = {status: false, http_status: response.status, http_text: text, status_text: response.statusText };

				 if (response.status == 500) // fatal error
				 {
					 console.error('Worker: Fatal error detected');
				 }
				 else if (response.status == 502 || response.status == 503) // server gave up
				 {
					 	console.error('Worker: server unavailable or overloaded');
				 }
				 else	 {
					 	console.error('Worker: Unknown error', response);
				 }
				 postMessage({'status' : false, message: message});
      }
   },
   SetEnv: function (data)
   {
      for (var key in data)
      {
          this[key] = data[key];
      }
   },
   ShutDown: function()
   {
       this.stopped = true;
//       this.Fetch();
   },
	 UpdateLocalSecret: function(key)
	 {
		  this.secret = key;
	 },
   GetItemView: function(data)
   {
      this.action = 'shortpixel_get_item_view';
      this.Fetch(data);
   },
   AjaxRequest: function(data)
   {
      this.action = 'shortpixel_ajaxRequest';
      this.Fetch(data);
   },
   Process: function(data)
   {
      this.action = 'shortpixel_image_processing';
      this.Fetch(data);
   }


} // worker
