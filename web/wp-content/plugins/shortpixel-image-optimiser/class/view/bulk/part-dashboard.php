<?php
namespace ShortPixel;
?>

<section class='dashboard panel active' data-panel="dashboard" style='display: block'  >
  <div class="panel-container">


    <h3 class="heading"><span><img src="<?php echo esc_url(\wpSPIO()->plugin_url('res/img/robo-slider.png')); ?>"></span>
      <?php esc_html_e('Welcome to the Bulk Processing page!', 'shortpixel-image-optimiser'); ?>
    </h3>

    <div class='interface wrapper'>

      <div class='bulk-wrapper'>
        <button type="button" class="button-primary button" id="start-optimize" data-action="open-panel" data-panel="selection" <?php echo ($this->view->error) ? "disabled" : ''; ?>  >
            <span class='dashicons dashicons-controls-play'>&nbsp;</span>
						<p><?php esc_html_e('Start optimizing','shortpixel-image-optimiser'); ?></p>
        </button>
      </div>

			<div class='dashboard-text'>
	      <p class='description'><?php esc_html_e('Here you can (re)optimize your Media Library or Custom Media folders from your website.', 'shortpixel-image-optimiser'); ?></p>

				<p class='description'><?php
					printf(__('If you have any question don\'t hesitate to %s contact us %s %s, we are friendly and helpful, 24/7. %s
	Also, if you have a minute please leave a %s review %s for us, it always brings joy to our team! %s','shortpixel-image-optimiser'),
					'<a href="https://shortpixel.com/contact" target="_blank">',
					'</a>',
					'&#x1F4AC;',
					'<br>',
					'<a href="https://wordpress.org/support/plugin/shortpixel-image-optimiser/reviews/?filter=5" target="_blank">',
					'</a>',
					'&#x1F913');
				?>

				</p>
			</div>
 </div>



   <?php if ($this->view->error): ?>
     <div class='bulk error'>
        <h3><?php echo esc_html($this->view->errorTitle); ?></h3>
        <p><?php echo $this->view->errorContent; ?></p>
        <?php if (property_exists($this->view, 'errorText')): ?>
            <p class='text'><?php echo esc_html($this->view->errorText) ?></p>
        <?php endif; ?>

     </div>

   <?php endif; ?>

   <?php if (count($this->view->logs) > 0): ?>

	 <div id="LogModal" class="shortpixel-modal shortpixel-hide bulk-modal">
		 <span class="close" data-action="CloseModal" data-id="LogModal">X</span>
	 	  <div class='title'>

			</div>
			<div class="content sptw-modal-spinner">
				 <div class='table-wrapper'>

				 </div>

			</div>
	 </div>
	 <div id="LogModal-Shade" class='sp-modal-shade'></div>
   <div class='dashboard-log'>

      <h3><?php esc_html_e('Previous Bulks', 'shortpixel_image_optimizer'); ?></h3>
      <?php
        echo "<div class='head'>";
        foreach($this->view->logHeaders as $header)
        {
           echo "<span>" . esc_attr($header) . "</span>";
        }
        echo "</div>";
        foreach ($this->view->logs as $logItem):
        {
          	echo "<div class='data " . esc_attr($logItem['type']) . "'>";

					  echo "<span>" . esc_html($logItem['images'])  . '</span>';
						echo "<span>" . $logItem['errors'] . '</span>';

              echo '<span class="checkmark_green date">' . sprintf(esc_html__('%sCompleted%s on %s','shortpixel-image-optimiser'), '<b>','</b>', esc_html($logItem['date'])) . '</span>';

						echo "<span>" . esc_html($logItem['bulkName']) . '</span>';

          echo "</div>";
         }
        ?>


      <?php endforeach; ?>

   </div>
  <?php endif; ?>


  <?php if (! $this->view->error): ?>
     <div class='shortpixel-bulk-loader' id="bulk-loading" data-status='loading'>
       <div class='loader'>
				 	 <span class="svg-spinner"><?php $this->loadView('snippets/part-svgloader', false); ?></span>

           <span>
           <h2><?php esc_html_e('Please wait, ShortPixel is loading'); ?></h2>

         </span>

       </div>
     </div>
  <?php endif; ?>
 </div> <!-- panel-container -->
</section> <!-- section -->
