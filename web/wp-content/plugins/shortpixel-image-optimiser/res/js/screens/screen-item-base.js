'use strict';

class ShortPixelScreenItemBase extends ShortPixelScreenBase
{

	type; // media / custom
	currentMessage = '';


	constructor(MainScreen, processor)
	{
		super(MainScreen, processor);
		window.addEventListener('shortpixel.' + this.type + '.resumeprocessing', this.processor.ResumeProcess.bind(this.processor));
		window.addEventListener('shortpixel.RenderItemView', this.RenderItemView.bind(this) );
	}

	HandleImage(resultItem, type)
	{
			if (type != this.type )  // We don't eat that here.
				return false;

			if (typeof resultItem.result !== 'undefined')
			{
					// This is final, not more messing with this. In results (multiple) defined one level higher than result object, if single, it's in result.
					var item_id = typeof resultItem.item_id !== 'undefined' ? resultItem.item_id : resultItem.result.item_id;
					var message = resultItem.result.message;

					var element = document.getElementById('sp-msg-' + item_id); // empty result box while getting
					if (typeof message !== 'undefined')
					{
							 var isError = false;
						 if (resultItem.result.is_error == true)
								isError = true;
						 this.UpdateMessage(item_id, message, isError);
					}
					if (element !== null)
					{
						element.innerHTML = '';
					//  var event = new CustomEvent('shortpixel.loadItemView', {detail: {'type' : type, 'id': result.id }}); // send for new item view.
					var fileStatus = this.processor.fStatus[resultItem.result.status];

						if (fileStatus == 'FILE_SUCCESS' || fileStatus == 'FILE_RESTORED' || resultItem.result.is_done == true)
						{
							this.processor.LoadItemView({id: item_id, type: type});
						}
						else if (fileStatus == 'FILE_PENDING')
						{
							 element.style.display = 'none';
						}
						//window.dispatchEvent(event);
					}
			}
			else
			{
				console.error('handleImage without Result');
				console.log(resultItem);
			}

			return false;
	}

	UpdateMessage(id, message, isError)
	{

		 var element = document.getElementById('sp-message-' + id);
		 if (typeof isError === 'undefined')
			 isError = false;

		 this.currentMessage = message;

		 if (element == null)
		 {
				 var parent = document.getElementById('sp-msg-' + id);
				 if (parent !== null)
				 {
					 var element = document.createElement('div');
					 element.classList.add('message');
					 element.setAttribute('id', 'sp-message-' + id);
					 parent.parentNode.insertBefore(element, parent.nextSibling);
				 }
		 }

		 if (element !== null)
		 {
				if (element.classList.contains('error'))
					 element.classList.remove('error');

				element.innerHTML = message;

				if (isError)
					 element.classList.add('error');
		 }
		 else
		 {
			this.processor.Debug('Update Message Column not found - ' + id);
		 }
	}

	// Show a message that an action has started.
	SetMessageProcessing(id)
	{
			var message = this.strings.startAction;

			var loading = document.createElement('img');
			loading.width = 20;
			loading.height = 20;
			loading.src = this.processor.GetPluginUrl() + '/res/img/bulk/loading-hourglass.svg';

			message += loading.outerHTML;
			this.UpdateMessage(id, message);
	}

	UpdateStats(stats, type)
	{
		// for now, since we process both, only update the totals in tooltip.
		if ( type !== 'total')
			return;

		var waiting = stats.in_queue + stats.in_process;
		this.processor.tooltip.RefreshStats(waiting);
	}

	GeneralResponses(responses)
	{
			 var self = this;

			 if (responses.length == 0)  // no responses.
				 return;

			 var shownId = []; // prevent the same ID from creating multiple tooltips. There will be punishment for this.

			 responses.forEach(function (element, index)
			 {

						if (element.id)
						{
								if (shownId.indexOf(element.id) > -1)
								{
									return; // skip
								}
								else
								{
									shownId.push(element.id);
								}
						}

						var message = element.message;
						if (element.filename)
							message += ' - ' + element.filename;

						self.processor.tooltip.AddNotice(message);
						if (self.processor.rStatus[element.code] == 'RESPONSE_ERROR')
						{

						 if (element.id)
						 {
							 var message = self.currentMessage;
							 self.UpdateMessage(element.id, message + '<br>' + element.message);
							 self.currentMessage = message; // don't overwrite with this, to prevent echo.
						 }
						 else
						 {
								 var errorBox = document.getElementById('shortpixel-errorbox');
								 if (errorBox)
								 {
									 var error = document.createElement('div');
									 error.classList.add('error');
									 error.innerHTML = element.message;
									 errorBox.append(error);
								 }
						 }
						}
			 });

		}

		// HandleItemError is handling from results / result, not ResponseController. Check if it has negative effects it's kinda off now.
		HandleItemError(result)
		{
					if (result.message && result.item_id)
					{
						this.UpdateMessage(result.item_id, result.message, true);
					}

					if (typeof result.item_id !== 'undefined')
					{
						this.processor.LoadItemView({id: result.item_id, type: 'media'});
					}
		}

		RestoreItem(id)
		{
				var data = {};
				data.id = id;
				data.type = this.type;
				data.screen_action = 'restoreItem';
				// AjaxRequest should return result, which will go through Handleresponse, then LoaditemView.
				this.SetMessageProcessing(id);
				this.processor.AjaxRequest(data);
		}

		ReOptimize(id, compression)
		{
				var data = {
					 id : id ,
					 compressionType: compression,
					 type: this.type,
					 screen_action: 'reOptimizeItem'
				};

			 if (! this.processor.CheckActive())
					 data.callback = 'shortpixel.' + this.type + '.resumeprocessing';

				this.SetMessageProcessing(id);
				this.processor.AjaxRequest(data);
		}

		Optimize(id)
		{
			 var data = {
					id: id,
					type: this.type,
					screen_action: 'optimizeItem'
			 }

			 if (! this.processor.CheckActive())
				 data.callback = 'shortpixel.' + this.type + '.resumeprocessing';

			 this.SetMessageProcessing(id);
			 this.processor.AjaxRequest(data);
		}


} // class
