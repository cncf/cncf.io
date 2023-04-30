<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

// #Todo Move this to some env or more appropiate place.
$is_unlimited= (!is_null($this->quotaData) && $this->quotaData->unlimited) ? true : false;

?>
<div class="wrap is-shortpixel-settings-page">
<h1>
    <?php esc_html_e('ShortPixel Plugin Settings','shortpixel-image-optimiser');?>
</h1>
<div class='top-menu'>

  <div class='links'>

		<?php if (! $is_unlimited): ?>
    <a href="https://shortpixel.com/<?php
        echo esc_attr(($view->data->apiKey ? "login/". $view->data->apiKey . '/spio-unlimited': "pricing"));
    ?>" target="_blank"><?php esc_html_e( 'Buy credits', 'shortpixel-image-optimiser' );?></a> |
	  <?php endif; ?>

    <a href="https://shortpixel.com/knowledge-base/" target="_blank"><?php esc_html_e('Knowledge Base','shortpixel-image-optimiser');?></a> |
    <a href="https://shortpixel.com/contact" target="_blank"><?php esc_html_e('Contact Support','shortpixel-image-optimiser');?></a> |
    <a href="https://shortpixel.com/<?php
        echo esc_attr(($view->data->apiKey ? "login/". $view->data->apiKey . "/dashboard" : "login"));
    ?>" target="_blank">
        <?php esc_html_e('ShortPixel account','shortpixel-image-optimiser');?>
    </a>
  </div>

    <?php if ( round($view->averageCompression) > 20 ): ?>
        <div class="spio-status-box">
            <?php if ( round($view->averageCompression) > 20): ?>
                <div class='pie-wrapper'><?php	$this->loadView('settings/part-optpie'); ?></div>
            <?php endif; ?>

            <?php if (!is_null($this->quotaData)): ?>
                <div class='quota-remaining'>
                    <a href="https://shortpixel.com/<?php
                    echo esc_attr(($view->data->apiKey ? "login/". $view->data->apiKey . "/dashboard" : "login"));
                    ?>" target="_blank">
												 <?php if ($is_unlimited)
												 {
													 printf(esc_html__('Shortpixel Unlimited', 'shortpixel-image-optimiser'));
												 }
												 else
                         {
													 printf(esc_html__('%s Credits remaining', 'shortpixel-image-optimiser'),  esc_html($this->formatNumber(max(0, $this->quotaData->total->remaining), 0)));
												 }
												 ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<hr class='wp-header-end'>


<article id="shortpixel-settings-tabs" class="sp-tabs">
    <?php if (! $this->is_verifiedkey)
    {
      $this->loadView('settings/part-nokey');
    } ?>

  <?php
    if ($this->is_verifiedkey):
      ?>
      <div class='section-wrapper'>
				<form name='wp_shortpixel_options' action='<?php echo esc_url(add_query_arg('noheader', 'true')) ?>'  method='post' id='wp_shortpixel_options'>
	        <input type='hidden' name='display_part' value="<?php echo esc_attr($this->display_part) ?>" />
	        <?php wp_nonce_field($this->form_action, 'sp-nonce'); ?>

        <?php
        $this->loadView('settings/part-general');
        $this->loadView('settings/part-advanced');
        if (! $this->view->cloudflare_constant)
        {
          $this->loadView('settings/part-cloudflare');
        }
        if ($view->averageCompression !== null)
        {
    //     $this->loadView('settings/part-statistics');
        }
				$this->loadView('settings/part-tools');

        ?>
			</form>
			<?php
				if (Log::debugIsActive())
        {
          $this->loadView('settings/part-debug');
        }
				?>
			</div> <!-- wrappur -->
      <?php
    endif;
    ?>

</article>
<?php $this->loadView('settings/part-wso'); ?>

<?php $this->loadView('snippets/part-inline-help'); ?>
<?php $this->loadView('snippets/part-inline-modal'); ?>
