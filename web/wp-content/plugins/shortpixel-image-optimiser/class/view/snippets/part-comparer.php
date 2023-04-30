<?php
namespace ShortPixel;

?>

<!-- The image comparer -->

<div id="sp-modal-shade" class="sp-modal-shade"></div>
    <div id="spUploadCompare" class="shortpixel-modal shortpixel-hide">
      <div class="sp-modal-title">
        <button type="button" class="sp-close-button">&times;</button>
        <?php esc_html_e('Compare Images', 'shortpixel-image-optimiser');?>
      </div>
      <div class="sp-modal-body sptw-modal-spinner" style="height:400px;padding:0;">
        <div class="shortpixel-slider" style="z-index:2000;">
            <div class="twentytwenty-container" id="spCompareSlider">
                <img class="spUploadCompareOriginal"/>
                <img class="spUploadCompareOptimized"/>
            </div>
        </div>
      </div>
    </div>
    <div id="spUploadCompareSideBySide" class="shortpixel-modal shortpixel-hide">
      <div class="sp-modal-title">
        <button type="button" class="sp-close-button">&times;</button>
        Compare Images
      </div>
      <div class="sp-modal-body" style="height:400px;padding:0;">
        <div class="shortpixel-slider" style="text-align: center;">
            <div class="side-by-side"  style="text-align: center; display:inline-block;">
                <img class="spUploadCompareOriginal" style="margin: 10px"/><br>
                Original
            </div>
            <div class="side-by-side" style="text-align: center; display:inline-block;">
                <img class="spUploadCompareOptimized" style="margin: 10px"/><br>
                Optimized
            </div>
        </div>
      </div>
    </div>
