'use strict';

// MainScreen as an option for delegate functions
class ShortPixelScreen extends ShortPixelScreenItemBase //= function (MainScreen, processor)
{
    isCustom = true;
    isMedia = true;
		type = 'media';


    RenderItemView(e)
    {
				e.preventDefault();
        var data = e.detail;
        if (data.media)
        {
            var id = data.media.id;

            var element = document.getElementById('sp-msg-' + id);
						if (element !== null) // Could be other page / not visible / whatever.
            	element.outerHTML = data.media.itemView;
        }
        return false; // callback shouldn't do more, see processor.
    }

		RedoLegacy(id)
		{
			var data = {
				 id: id,
				 type: 'media',
				 screen_action: 'redoLegacy',
			}
				data.callback = 'shortpixel.LoadItemView';

  		window.addEventListener('shortpixel.LoadItemView', function (e) {
					var itemData = { id: e.detail.media.id, type: 'media' };
					this.processor.timesEmpty = 0; // reset the defer on this.
					this.processor.LoadItemView(itemData);
					this.UpdateMessage(itemData.id, '');

			}.bind(this), {'once': true} );

			this.SetMessageProcessing(id);
			this.processor.AjaxRequest(data);
		}

} // class
