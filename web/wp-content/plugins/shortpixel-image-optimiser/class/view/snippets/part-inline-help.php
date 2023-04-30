<?php
namespace ShortPixel;

?>

<div id="spioHelpShade" class="spio-modal-shade" style="display:none;">
			 <div id="spioHelp" class="spio-modal spio-hide" style="min-width:610px;margin-left:-305px;">
					 <div class="spio-modal-title">
							 <button type="button" class="spio-close-help-button" onclick="jQuery.spioHelpClose()">&times;</button>
					 </div>
					 <div class="spio-modal-body" style="height:auto;min-height:400px;padding:0;">
							 <iframe src="about:blank" width="100%" height="400" style="border:none"></iframe>
					 </div>
			 </div>
			 <script  type="text/javascript" id="spio_help_js">
					 jQuery(document).ready(function($)
					 {

					 $.spioHelpInit = function(){
				 		jQuery('div.spio-inline-help span').on('click', function(elm){ jQuery.spioHelpOpen(elm)});
				 		jQuery('div.spio-modal-shade').on('click', function(elm){ jQuery.spioHelpClose()});
				 	}

				 	$.spioHelpOpen = function(evt) {
				         //$("#shortPixelProposeUpgrade .spio-modal-body").html("");
				         $("#spioHelpShade").css("display", "block");
				         $("#spioHelp .spio-modal-body iframe").attr('src',  evt.target.dataset.link);
				         $("#spioHelp").removeClass('spio-hide');
				     }

				     $.spioHelpClose = function(){
				         jQuery("#spioHelpShade").css("display", "none");
				         $("#spioHelp .spio-modal-body iframe").attr('src',  'about:blank');
				         jQuery("#spioHelp").addClass('spio-hide');
				 	}
					jQuery.spioHelpInit()

					;});
			 </script>
</div>
