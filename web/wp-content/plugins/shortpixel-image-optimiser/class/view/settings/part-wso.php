<?php
namespace ShortPixel;

$bool = apply_filters('shortpixel/settings/no_banner', true);
if (! $bool )
  return;

if ( defined('SHORTPIXEL_NO_BANNER') && SHORTPIXEL_NO_BANNER == true)
  return;

?>

<section class='wso banner'>
    <span class="image">
      <img src="<?php echo \wpSPIO()->plugin_url() ?>res/img/robo-winky.png" />
    </span>
    <span class="line"><h3>
      <?php printf(__('ARE YOU CONCERNED WITH YOUR %s %s SITE SPEED? %s', 'shortpixel-image-optimiser'),'<br>', '<span class="red">','</span>'); ?>
      </h3>
    </span>
    <span class="line"><h3>
       <?php printf(__('ALLOW ShortPixel SPECIALISTS TO %s FIND THE  SOLUTION FOR YOU.', 'shortpixel-image-optimiser'), '<br>'); ?>
     </h3>
    </span>
  <span class="button-wrap">
      <a href="https://wso.shortpixel.com/?utm_source=SPIO" target="_blank" class='button' ><?php _e('Find out more', 'shortpixel-image-optimiser'); ?></a>
  </span>
</section>
