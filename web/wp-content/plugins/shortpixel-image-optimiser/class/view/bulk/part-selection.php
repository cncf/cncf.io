<?php
namespace ShortPixel;

$approx = $this->view->approx;
?>
<section class='panel selection' data-panel="selection" data-status="loaded" >
  <div class="panel-container">
			<span class='hidden' data-check-custom-hascustom >
				<?php echo  ($this->view->approx->custom->has_custom === true) ? 1 : 0;  ?>
			</span>

      <h3 class="heading"><span><img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/robo-slider.png')); ?>"></span>
        <?php esc_html_e('ShortPixel Bulk Optimization - Select Images', 'shortpixel-image-optimiser'); ?>
      </h3>

      <p class='description'><?php esc_html_e('Select the type of images that ShortPixel should optimize for you.','shortpixel-image-optimiser'); ?></p>

       <?php $this->loadView('bulk/part-progressbar', false); ?>

      <div class='load wrapper' >
         <div class='loading'>
             <span><img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/bulk/loading-hourglass.svg')); ?>" /></span>
             <span>
             <p><?php esc_html_e('Please wait, ShortPixel is checking the images to be processed...','shortpixel-image-optimiser'); ?><br>
               <span class="number" data-stats-total="total">x</span> <?php esc_html_e('items found', 'shortpixel-image-optimiser'); ?></p>
           </span>
         </div>
				 <div class='loading skip'>
					 <span><p><button class='button' data-action="SkipPreparing"><?php _e('Start optimization now', 'shortpixel-image-optimiser'); ?></button></p></span>
				</div>
       </div>

       <div class="interface wrapper">

				 <div class="option-block">

					 <h2><?php esc_html_e('Optimize:','shortpixel-image-optimiser'); ?> </h2>
					 <p><?php printf(esc_html__('ShortPixel has %sestimated%s the number of images that can still be optimized. %sAfter you select the options, the plugin will calculate exactly how many images to optimize.','shortpixel-image-optimiser'), '<b>','</b>', '<br />'); ?></p>

					 <?php if ($approx->media->isLimited): ?>
						 <h4 class='count_limited'><?php esc_html_e('Shortpixel has detected a high number of images. This estimates are limited for performance reasons. On the next step an accurate count will be produced', 'shortpixel-image-optimiser'); ?></h4>
					 <?php endif; ?>


	         <div class="media-library optiongroup">


	            <div class='switch_button'>
	              <label>
	                <input type="checkbox" class="switch" id="media_checkbox" checked>
	                <div class="the_switch">&nbsp; </div>
	              </label>
	            </div>


	            <h4><label for="media_checkbox"><?php esc_html_e('Media Library','shortpixel-image-optimiser'); ?></label></h4>
	            <div class='option'>
	              <label><?php esc_html_e('Images (estimate)', 'shortpixel-image-optimiser'); ?></label>
	              <span class="number" ><?php echo esc_html($approx->media->items) ?></span>
	            </div>

							<?php if (\wpSPIO()->settings()->processThumbnails == 1): ?>
		            <div class='option'>
		              <label><?php esc_html_e('Thumbnails (estimate)','shortpixel-image-optimiser'); ?></label> <span class="number" ><?php echo esc_html($approx->media->thumbs) ?> </span>
		            </div>
							<?php endif; ?>
	         </div>


					<?php if (! \wpSPIO()->settings()->processThumbnails): ?>
					<div class='thumbnails optiongroup'>
						<div class='switch_button'>
							<label>
								<input type="checkbox" class="switch" id="thumbnails_checkbox" <?php checked(\wpSPIO()->settings()->processThumbnails); ?>>
								<div class="the_switch">&nbsp; </div>
							</label>
						</div>
						<h4><label for="thumbnails_checkbox"><?php esc_html_e('Process Image Thumbnails','shortpixel-image-optimiser'); ?></label></h4>
						<div class='option'>
							<label><?php esc_html_e('Thumbnails (estimate)','shortpixel-image-optimiser'); ?></label>
							 <span class="number" ><?php echo esc_html($approx->media->total) ?> </span>
						</div>

						<p><?php esc_html_e('It is recommended to process the WordPress thumbnails. These are the small images that are most often used in posts and pages.This option changes the global ShortPixel settings of your site.','shortpixel-image-optimiser'); ?></p>

					</div>
				<?php endif; ?>

	         <div class="custom-images optiongroup"  data-check-visibility data-control="data-check-custom-hascustom" >
	           <div class='switch_button'>
	             <label>
	               <input type="checkbox" class="switch" id="custom_checkbox" checked>
	               <div class="the_switch">&nbsp; </div>
	             </label>
	           </div>
	           <h4><label for="custom_checkbox"><?php esc_html_e('Custom Media images','shortpixel-image-optimiser') ?></label></h4>
	            <div class='option'>
	              <label><?php esc_html_e('Images (estimate)','shortpixel-image-optimiser'); ?></label>
	               <span class="number" ><?php echo esc_html($approx->custom->images) ?></span>
	            </div>
	         </div>
				</div> <!-- block -->

				 <div class="option-block selection-settings">
					 <h2><?php esc_html_e('Options','shortpixel-image-optimiser') ?>: </h2>
						 <p><?php esc_html_e('Enable these options if you also want to create WebP/AVIF files. These options change the global ShortPixel settings of your site.','shortpixel-image-optimiser'); ?></p>
		         <div class='optiongroup'  >
		           <div class='switch_button'>

		             <label>
		               <input type="checkbox" class="switch" id="webp_checkbox" name="webp_checkbox"
		                <?php checked(\wpSPIO()->settings()->createWebp); ?>  />
		               <div class="the_switch">&nbsp; </div>
		             </label>

		           </div>
			   <h4><label for="webp_checkbox">
					 <?php printf(esc_html__('Also create WebP versions of the images' ,'shortpixel-image-optimiser') ); ?>
				 </label></h4>
				<div class="option"><?php esc_html_e('The total number of WebP images will be calculated in the next step.','shortpixel-image-optimiser'); ?></div>
		       </div>


					 <?php
					 $avifEnabled = $this->access()->isFeatureAvailable('avif');
					 $createAvifChecked = (\wpSPIO()->settings()->createAvif == 1 && $avifEnabled === true) ? true : false;
					 $disabled = ($avifEnabled === false) ? 'disabled' : '';
					 ?>


		       <div class='optiongroup'>
		         <div class='switch_button'>

		           <label>
		             <input type="checkbox" class="switch" id="avif_checkbox" name="avif_checkbox" <?php echo $disabled ?>
		              <?php checked($createAvifChecked); ?>  />
		             <div class="the_switch">&nbsp; </div>
		           </label>

		         </div>
		         <h4><label for="avif_checkbox"><?php esc_html_e('Also create AVIF versions of the images','shortpixel-image-optimiser'); ?></label></h4>
				<?php if ($avifEnabled == true): ?>
				<div class="option"><?php esc_html_e('The total number of AVIF images will be calculated in the next step.','shortpixel-image-optimiser'); ?></div>
		     </div>
			<?php else : ?>
				<div class="option warning"><?php printf(esc_html__('The creation of AVIF files is not possible with this license type. %s Read more %s ','shortpixel-image-optimiser'), '<a href="https://shortpixel.com/knowledge-base/article/555-how-does-the-unlimited-plan-work" target="_blank">', '</a>'); ?>


				</div>
				 </div>
			<?php endif;  ?>

		 </div>

 	 	 <div class="option-block">
       <div class='optiongroup' data-check-visibility="false" data-control="data-check-approx-total">
          <h3><?php esc_html_e('No images found', 'shortpixel-image-optimiser'); ?></h3>
          <p><?php esc_html_e('ShortPixel Bulk couldn\'t find any optimizable images.','shortpixel-image-optimiser'); ?></p>
       </div>

       <h4 class='approx'><?php esc_html_e('An estimate of unoptimized images in this installation', 'shortpixel-image-optimiser'); ?> :
			<span data-check-approx-total><?php echo esc_html($approx->total->images) ?></span> </h4>

       <div><p><?php printf(__('In the next step, the plugin will calculate the total number of images to be optimized, and your bulk process will be prepared. The processing %s will not start yet %s, but a summary of the images to be optimized will be displayed.', 'shortpixel-image-optimiser'),'<b>','</b>'); ?></p></div>
		 </div>

      <nav>
        <button class="button" type="button" data-action="FinishBulk">
					<span class='dashicons dashicons-arrow-left'></span>
					<p><?php esc_html_e('Back', 'shortpixel-image-optimiser'); ?></p>
				</button>

        <button class="button-primary button" type="button" data-action="CreateBulk" data-panel="summary" data-check-disable data-control="data-check-total-total">
					<span class='dashicons dashicons-arrow-right'></span>
					<p><?php esc_html_e('Calculate', 'shortpixel-image-optimiser'); ?></p>
				</button>
      </nav>

    </div> <!-- interface wrapper -->
  </div><!-- container -->
</section>
