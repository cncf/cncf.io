<?php
namespace ShortPixel;
?>
<section class="panel process" data-panel="process" >
  <div class="panel-container">

    <h3 class="heading"><span><img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/robo-slider.png')); ?>"></span>
      <?php esc_html_e('ShortPixel Bulk Process is in progress','shortpixel-image-optimiser'); ?>

      <div class='average-optimization'>
          <p><?php esc_html_e('Average this run','shortpixel-image-optimiser'); ?></p>
          <svg class="opt-circle-average" viewBox="-10 0 150 140">
                        <path class="trail" d="
                            M 50,50
                            m 0,-46
                            a 46,46 0 1 1 0,92
                            a 46,46 0 1 1 0,-92
                            " stroke-width="16" fill-opacity="0">
                        </path>
                        <path class="path" d="
                            M 50,50
                            m 0,-46
                            a 46,46 0 1 1 0,92
                            a 46,46 0 1 1 0,-92
                            " stroke-width="16" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 180px;">
                        </path>
                        <text class="text" x="50" y="50"><?php esc_html_e('N/A', 'shortpixel-image-optimiser'); ?></text>
                    </svg>

      </div>
    </h3>

    <p class='description'><?php esc_html_e('ShortPixel is processing your images. Please keep this window open to complete the process.', 'shortpixel-image-optimiser'); ?> </p>

    <?php $this->loadView('bulk/part-progressbar', false); ?>

		<!--- ###### MEDIA ###### -->
		<span class='hidden' data-check-media-total data-stats-media="total">0</span>
    <div class='bulk-summary' data-check-visibility data-control="data-check-media-total">
      <div class='heading'>
        <span><i class='dashicons dashicons-images-alt2'>&nbsp;</i> <?php esc_html_e('Media Library' ,'shortpixel-image-optimiser'); ?></span>
        <span>
              <span class='line-progressbar'>
                <span class='done-text'><i data-stats-media="percentage_done"></i> %</span>
                <span class='done' data-stats-media="percentage_done" data-presentation="css.width.percentage"></span>

              </span>
							<span class='dashicons spin dashicons-update line-progressbar-spinner' data-check-visibility data-control="data-check-media-in_process">&nbsp;</span>

        </span>
        <span><?php esc_html_e('Processing', 'shortpixel-image-optimiser') ?>: <i data-stats-media="in_process" data-check-media-in_process >0</i></span>
      </div>

      <div>
        <span><?php esc_html_e('Processed', 'shortpixel-image-optimiser'); ?>: <i data-stats-media="done">0</i></span>

        <span><?php esc_html_e('Waiting','shortpixel-image-optimiser'); ?>: <i data-stats-media="in_queue">0</i></span>
        <span><?php esc_html_e('Errors','shortpixel-image-optimiser') ?>: <i data-check-media-fatalerrors data-stats-media="fatal_errors" class='error'>0 </i>
					<span class="display-error-box" data-check-visibility data-control="data-check-media-fatalerrors" ><label title="<?php esc_html_e('Show Errors', 'shortpixel-image-optimiser'); ?>">
						<input type="checkbox" name="show-errors" value="show" data-action='ToggleErrorBox' data-errorbox='media' data-event='change'>
							<?php esc_html_e('Show Errors','shortpixel-image-optimiser'); ?></label>
				 </span>

				</span>


      </div>

    </div>

		<div data-error-media="message" data-presentation="append" class='errorbox media'>
				<?php if(property_exists($this->view, 'mediaErrorLog') && $this->view->mediaErrorLog !== false)
				{
					echo $this->view->mediaErrorLog;
				}
				?>
		</div>

		<!-- ****** CUSTOM ********  --->
		<span class='hidden' data-check-custom-total data-stats-custom="total">0</span>

    <div class='bulk-summary' data-check-visibility data-control="data-check-custom-total">
      <div class='heading'>
        <span><i class='dashicons dashicons-open-folder'>&nbsp;</i> <?php esc_html_e('Custom Media', 'shortpixel-image-optimiser'); ?> </span>
        <span>
              <span class='line-progressbar'>
                <span class='done-text'><i data-stats-custom="percentage_done"></i> %</span>
                <span class='done' data-stats-custom="percentage_done" data-presentation="css.width.percentage"></span>
              </span>
							<span class='dashicons spin dashicons-update line-progressbar-spinner' data-check-visibility data-control="data-check-custom-in_process">&nbsp;</span>

        </span>
  			<span><?php esc_html_e('Processing', 'shortpixel-image-optimiser') ?>: <i data-stats-custom="in_process" data-check-custom-in_process>-</i></span>

      </div>
      <div>
        <span><?php esc_html_e('Processed','shortpixel-image-optimiser'); ?>: <i data-stats-custom="done">-</i></span>

        <span><?php esc_html_e('Waiting','shortpixel-image-optimiser'); ?>: <i data-stats-custom="in_queue">-</i></span>
        <span><?php esc_html_e('Errors') ?>: <i data-check-custom-fatalerrors  data-stats-custom="fatal_errors" class='error'>-</i>

					<span class="display-error-box" data-check-visibility data-control="data-check-custom-fatalerrors" ><label title="<?php esc_html_e('Show Errors', 'shortpixel-image-optimiser'); ?>">
						<input type="checkbox" name="show-errors" value="show" data-action='ToggleErrorBox' data-errorbox='custom' data-event='change'><?php esc_html_e('Show Errors','shortpixel-image-optimiser'); ?></label>
				 </span>
				</span>



      </div>

    </div>

    <div data-error-custom="message" data-presentation="append" class='errorbox custom'>
			<?php if(property_exists($this->view, 'customErrorLog') && $this->view->customErrorLog !== false)
			{
					echo $this->view->customErrorLog;
			}
			?>
		</div>

		<nav>
			<button class='button stop' type='button' data-action="StopBulk" >
					<?php esc_html_e('Stop Bulk Processing' ,'shortpixel-image-optimiser'); ?>
			</button>
			<button class='button pause' type='button' data-action="PauseBulk" id="PauseBulkButton">
				<?php esc_html_e('Pause Bulk Processing' ,'shortpixel-image-optimiser') ?>
			</button>
			<button class='button button-primary resume' type='button' data-action='ResumeBulk' id="ResumeBulkButton">
				<?php esc_html_e('Resume Bulk Processing','shortpixel-image-optimiser'); ?>
			</button>

		</nav>

    <div class='image-preview-section hidden'> <!-- /hidden -->
			 <div class='title'><?php esc_html_e('Just Optimized', 'shortpixel-image-optimiser'); ?></div>
       <div class="image-preview-line">
        <!-- <strong data-result="queuetype"></strong>  -->
				<span>&nbsp;</span> <!-- Spacer for flex -->
				<span data-result="filename">&nbsp;</span>

        <svg class="opt-circle-image" viewBox="0 0 100 100">
                      <path class="trail" d="
                          M 50,50
                          m 0,-46
                          a 46,46 0 1 1 0,92
                          a 46,46 0 1 1 0,-92
                          " stroke-width="8" fill-opacity="0">
                      </path>
                      <path class="path" d="
                          M 50,50
                          m 0,-46
                          a 46,46 0 1 1 0,92
                          a 46,46 0 1 1 0,-92
                          " stroke-width="8" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: 180px;">
                      </path>
                      <text class="text" x="50" y="50">-- %</text>
                  </svg>
      </div>

      <div class="preview-wrapper">
			 <div class="slide-mask" id="preview-structure" data-placeholder="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/bulk/placeholder.svg')); ?>">

					<div class='current preview-image'>
		        <div class="image source">
		          <img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/bulk/placeholder.svg')); ?>" >
		          <p><?php esc_html_e('Original Image', 'shortpixel-image-optimiser'); ?></p>
							<?php $this->loadView('snippets/part-svgloader', false); ?>
		        </div>

		        <div class="image result">
		          <img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/bulk/placeholder.svg')); ?>" >
						<p><?php esc_html_e('Optimized Image', 'shortpixel-image-optimiser'); ?>
								- <span data-result="improvements-totalpercentage"></span>% <?php _e('smaller', 'shortpixel-image-optimiser'); ?>
						</p>
						<?php $this->loadView('snippets/part-svgloader', false); ?>
		        </div>
					</div>

					<div class='new preview-image'>

							<div class="image source">
								<img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/bulk/placeholder.svg')); ?>" >
								<?php $this->loadView('snippets/part-svgloader', false); ?>
								<p><?php esc_html_e('Original Image','shortpixel-image-optimiser'); ?></p>
							</div>

							<div class="image result">
								<img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/bulk/placeholder.svg')); ?>" >
								<?php $this->loadView('snippets/part-svgloader', false); ?>
							<p><?php esc_html_e('Optimized Image','shortpixel-image-optimiser'); ?>
								- <span data-result="improvements-totalpercentage"></span>% <?php _e('smaller', 'shortpixel-image-optimiser'); ?>
							</p>
							</div>
					</div>
	      </div> <!-- slidemask -->
			</div>  <!-- preview wrapper -->
    </div>

		<div id="preloader" class="hidden">

  	</div>

</section>
