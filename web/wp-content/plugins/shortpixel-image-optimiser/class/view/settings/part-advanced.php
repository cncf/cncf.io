<?php
namespace ShortPixel;
use \ShortPixel\Helper\UiHelper as UiHelper;

?>
<section id="tab-adv-settings" class="clearfix <?php echo esc_attr(($this->display_part == 'adv-settings') ? ' sel-tab ' :''); ?> ">
    <h2><a class='tab-link' href='javascript:void(0);' data-id="tab-adv-settings"><?php esc_html_e('Advanced','shortpixel-image-optimiser');?></a></h2>

    <?php
    $deliverWebpAlteredDisabled = '';
    $deliverWebpUnalteredDisabled = '';
    $deliverWebpAlteredDisabledNotice = false;
    $deliverWebpUnalteredLabel ='';
    $deliverAVIFLabel ='';

    if( $this->is_nginx ){
        $deliverWebpUnaltered = '';                         // Uncheck
        $deliverWebpUnalteredDisabled = 'disabled';         // Disable
        $deliverWebpUnalteredLabel = __('It looks like you\'re running your site on an NGINX server. This means that you can only achieve this functionality by directly configuring the server config files. Please follow this link for instructions:','shortpixel-image-optimiser')." <a class=\"shortpixel-help-link\" href=\"https://shortpixel.com/knowledge-base/article/111-configure-nginx-to-transparently-serve-webp-files-when-supported\" target=\"_blank\" data-beacon-article=\"5bfeb9de2c7d3a31944e78ee\"><span class=\"dashicons dashicons-editor-help\"></span></a>";
        $deliverAVIFLabel = __('<strong>It looks like you\'re running your site on an NGINX server. You may need additional configuration for the AVIF delivery to work as expected</strong>','shortpixel-image-optimiser')." <a class=\"shortpixel-help-link\" href=\"https://shortpixel.com/knowledge-base/article/499-how-do-i-configure-my-web-server-to-deliver-avif-images\" target=\"_blank\"><span class=\"dashicons dashicons-editor-help\"></span></a>";
    } else {
        if( !$this->is_htaccess_writable ){
            $deliverWebpUnalteredDisabled = 'disabled';     // Disable
            if( $view->data->deliverWebp == 3 ){
                $deliverWebpAlteredDisabled = 'disabled';   // Disable
                $deliverWebpUnalteredLabel = __('It looks like you recently moved from an Apache server to an NGINX server, while the option to use .htacces was in use. Please follow this tutorial to see how you could implement by yourself this functionality, outside of the WP plugin: ','shortpixel-image-optimiser') . '<a href="https://shortpixel.com/knowledge-base/article/111-configure-nginx-to-transparently-serve-webp-files-when-supported" target="_blank" data-beacon-article="5bfeb9de2c7d3a31944e78ee"></a>';
            } else {
                $deliverWebpUnalteredLabel = __('It looks like your .htaccess file cannot be written. Please fix this and then return to refresh this page to enable this option.','shortpixel-image-optimiser');
            }
        } elseif (isset($_SERVER['HTTP_USER_AGENT']) && strpos( wp_unslash($_SERVER['HTTP_USER_AGENT']), 'Chrome') !== false) {
            // Show a message about the risks and caveats of serving WEBP images via .htaccess
            $deliverWebpUnalteredLabel = '<span style="color: initial;">'. esc_html__('Based on testing your particular hosting configuration, we determined that your server','shortpixel-image-optimiser').
                '&nbsp;<img alt="can or can not" src="'. esc_url(plugins_url( 'res/img/test.jpg' , SHORTPIXEL_PLUGIN_FILE)) .'">&nbsp;'.
                esc_html__('serve the WebP or AVIF versions of the JPEG files seamlessly, via .htaccess.','shortpixel-image-optimiser').' <a href="https://shortpixel.com/knowledge-base/article/127-delivering-webp-images-via-htaccess" target="_blank" data-beacon-article="5c1d050e04286304a71d9ce4">Open article to read more about this.</a></span>';
        }
    }



    $excludePatterns = '';
    if($view->data->excludePatterns) {
        foreach($view->data->excludePatterns as $item) {
            $excludePatterns .= $item['type'] . ":" . $item['value'] . ", ";
        }
        $excludePatterns = substr($excludePatterns, 0, -2);
    }


    ?>

    <div class="wp-shortpixel-options wp-shortpixel-tab-content" style='visibility: hidden'>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row"><?php esc_html_e('Next Generation Images','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/286-how-to-serve-webp-files-using-spio"></span></div>
									 <div class='switch_button'>
										 <label>
											 <input type="checkbox" class="switch" name="createWebp" value="1" <?php checked( $view->data->createWebp, "1" );?>>
											 <div class="the_switch">&nbsp; </div>
											  <?php printf(esc_html__('Create %s WebP versions %s of the images. Each image/thumbnail will use an additional credit unless you use the %s Unlimited plan. %s','shortpixel-image-optimiser'), '<a href="https://shortpixel.com/blog/how-webp-images-can-speed-up-your-site/" target="_blank">', '</a>', '<a href="https://shortpixel.com/knowledge-base/article/555-how-does-the-unlimited-plan-work" target="_blank">', '</a>' );?>
										 </label>
									 </div>

                    <p>&nbsp;</p>
										<?php
											$avifEnabled = $this->access()->isFeatureAvailable('avif');
											$createAvifChecked = ($view->data->createAvif == 1 && $avifEnabled === true) ? true : false;
											$disabled = ($avifEnabled === false) ? 'disabled' : '';
											$avifEnabledNotice = false;
											if ($avifEnabled == false)
											{
												 $avifEnabledNotice = '<div class="sp-notice sp-notice-warning  avifNoticeDisabled">';
												 $avifEnabledNotice .=  __('The creation of AVIF files is not possible with this license type.', 'shortpixel-image-optimiser') ;
												 $avifEnabledNotice .=  '<div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/555-how-does-the-unlimited-plan-work"></span></div>';
												 $avifEnabledNotice .= '</div>';
											}
										?>

                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/467-how-to-create-and-serve-avif-files-using-shortpixel-image-optimizer"></span></div>
									 <div class='switch_button'>
										 <label>
											 <input type="checkbox" class="switch" name="createAvif" value="1" <?php echo $disabled ?> <?php checked( $createAvifChecked );?>>
											 <div class="the_switch">&nbsp; </div>
											 <?php printf(esc_html__('Create %s AVIF versions %s of the images. Each image/thumbnail will use an additional credit unless you use the %s Unlimited plan. %s','shortpixel-image-optimiser'), '<a href="https://shortpixel.com/blog/what-is-avif-and-why-is-it-good/" target="_blank">', '</a>', '<a href="https://shortpixel.com/knowledge-base/article/555-how-does-the-unlimited-plan-work" target="_blank">', '</a>');?>
										 </label>
									 </div>


                   <?php if(strlen($deliverAVIFLabel)){ ?>
                                <p class="sp-notice sp-notice-warning">
                               <?php echo ( $deliverAVIFLabel );?>
                                </p>
                   <?php } ?>
									 <?php if ($avifEnabledNotice !== false) {  echo $avifEnabledNotice;  } ?>

                    <p>&nbsp;</p>

                    <div class="deliverWebpSettings">
                        <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/126-which-webp-files-delivery-method-is-the-best-for-me"></span></div>
											 <div class='switch_button'>
												 <label>
													 <input type="checkbox" class="switch" name="deliverWebp" data-toggle="deliverTypes" value="1" <?php checked( ($view->data->deliverWebp > 0), true);?>>
													 <div class="the_switch">&nbsp; </div>
													 <?php esc_html_e('Deliver the next generation versions of the images in the front-end:','shortpixel-image-optimiser');?>
												 </label>
											 </div>


                        <ul class="deliverWebpTypes toggleTarget" id="deliverTypes">
                            <li>
                                <input type="radio" name="deliverWebpType" id="deliverWebpAltered" <?php checked( ($view->data->deliverWebp >= 1 && $view->data->deliverWebp <= 2), true); ?> <?php echo esc_attr( $deliverWebpAlteredDisabled );?> value="deliverWebpAltered" data-toggle="deliverAlteringTypes">
                                <label for="deliverWebpAltered">
                                    <?php esc_html_e('Using the &lt;PICTURE&gt; tag syntax','shortpixel-image-optimiser');?>
                                </label>

                                <?php if($deliverWebpAlteredDisabledNotice){ ?>
                                    <p class="sp-notice">
                                        <?php esc_html_e('After the option to work on .htaccess was selected, the .htaccess file has become unaccessible / read-only. Please make the .htaccess file writeable again to be able to further set this option up.','shortpixel-image-optimiser')?>
                                    </p>
                                <?php } ?>

                                <p class="settings-info">
                                     <?php esc_html_e('Each &lt;img&gt; will be replaced with a &lt;picture&gt; tag that will also provide AVIF and WebP images for browsers that support it. Also, it loads the picturefill.js for browsers that don\'t support the &lt;picture&gt; tag. You don\'t need to activate this if you\'re using the Cache Enabler plugin because your AVIF\WebP images are already handled by this plugin. <strong>Please run some tests before using this option!</strong> If the styles that your theme is using rely on the position of your &lt;img&gt; tags, you may experience display problems.','shortpixel-image-optimiser'); ?>
                                    <strong><?php esc_html_e('You can revert anytime to the previous state just by deactivating the option.','shortpixel-image-optimiser'); ?></strong>
                                </p>

                                <ul class="deliverWebpAlteringTypes toggleTarget" id="deliverAlteringTypes">
                                    <li>
                                        <input type="radio" name="deliverWebpAlteringType" id="deliverWebpAlteredWP" <?php checked(($view->data->deliverWebp == 2), true);?> value="deliverWebpAlteredWP">
                                        <label for="deliverWebpAlteredWP">
                                            <?php esc_html_e('Only via Wordpress hooks (like the_content, the_excerpt, etc)');?>
                                        </label>
                                    </li>
                                    <li>
                                        <input type="radio" name="deliverWebpAlteringType" id="deliverWebpAlteredGlobal" <?php checked(($view->data->deliverWebp == 1),true)?>  value="deliverWebpAlteredGlobal">
                                        <label for="deliverWebpAlteredGlobal">
                                            <?php esc_html_e('Global (processes the whole output buffer before sending the HTML to the browser)','shortpixel-image-optimiser');?>
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <input type="radio" name="deliverWebpType" id="deliverWebpUnaltered" <?php checked(($view->data->deliverWebp == 3), true);?> <?php echo esc_attr( $deliverWebpUnalteredDisabled );?> value="deliverWebpUnaltered" data-toggle="deliverAlteringTypes" data-toggle-reverse>

                                <label for="deliverWebpUnaltered">
                                    <?php esc_html_e('Without altering the page code (via .htaccess)','shortpixel-image-optimiser')?>
                                </label>
                                <?php if(strlen($deliverWebpUnalteredLabel)){ ?>
                                    <p class="sp-notice sp-notice-warning"><strong>
                                        <?php echo( $deliverWebpUnalteredLabel );?>
																			</strong>
                                    </p>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Optimize media on upload','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/521-settings-optimize-media-on-upload"></span></div>
									 <div class='switch_button'>
										 <label>
											 <input type="checkbox" class="switch" name="autoMediaLibrary" id='autoMediaLibrary' value="1" <?php checked( $view->data->autoMediaLibrary, "1" );?>>
											 <div class="the_switch">&nbsp; </div>
											 	<?php esc_html_e('Automatically optimize images after they are uploaded (recommended).','shortpixel-image-optimiser');?>
									 </label>
									 </div>
                </td>
            </tr>



						<?php if ( $view->data->frontBootstrap == 1):  ?>


            <tr id="frontBootstrapRow">
                <th scope="row"><?php esc_html_e('Process in the front-end','shortpixel-image-optimiser');?></th>
                <td>
                    <input name="frontBootstrap" type="checkbox" id="frontBootstrap" value="1" <?php checked( $view->data->frontBootstrap, '1' );?>>
                    <label for="frontBootstrap"><?php esc_html_e('Automatically optimize images added by users in front-end of the site.','shortpixel-image-optimiser');?></label>

                </td>
            </tr>
						<tr>
							<th scope='row'>&nbsp;</th>
							<td>
                             <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/536-why-is-the-option-process-in-the-front-end-gone"></span></div>
								<div class='view-notice warning'><p><?php esc_html_e('Important. From version 5 the front processing option is no longer available. There will be no processing on the frontend. To enable optimizing images without visiting the backend, please see the options available for command line optimization.', 'shortpixel-image-optimiser') ?></p>
									<p><?php esc_html_e('To turn off this message, click the checkbox and save settings', 'shortpixel-image-optimiser'); ?></p>
								</div>
							</td>
						</tr>

					<?php endif; ?>



            <?php if($this->has_nextgen) { ?>
            <tr>
                <th scope="row"><?php esc_html_e('NextGen','shortpixel-image-optimiser');?></th>
                <td>
									<div class='switch_button'>
										<label>
                    	<input name="includeNextGen" type="checkbox" id="nextGen" value='1' <?php echo  checked($view->data->includeNextGen,'1' );?>>

										<div class="the_switch">&nbsp; </div>
										<?php esc_html_e('Optimize NextGen galleries.','shortpixel-image-optimiser');?>
									</label>
								</div>

                </td>
            </tr>
            <?php } ?>
            <tr>
                <th scope="row"><?php esc_html_e('Optimize PDFs','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/520-settings-optimize-pdfs"></span></div>
									 <div class='switch_button'>

										 <label>
											 <input type="checkbox" class="switch" name="optimizePdfs" value="1" <?php checked( $view->data->optimizePdfs, "1" );?>>
											 <div class="the_switch">&nbsp; </div>
											 <?php esc_html_e('Also optimize PDF documents.','shortpixel-image-optimiser');?>
										 </label>
									 </div>

                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Optimize Retina images','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/518-settings-optimize-retina-images"></span></div>
									 <div class='switch_button'>
										 <label>
											 <input type="checkbox" class="switch" name="optimizeRetina" value="1" <?php checked( $view->data->optimizeRetina, "1" );?>>
											 <div class="the_switch">&nbsp; </div>
											 		<?php esc_html_e('Also optimize the Retina images (@2x) if they exist.','shortpixel-image-optimiser');?>
								 			</label>
									 </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Optimize other thumbnails','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/519-settings---optimize-other-thumbs"></span></div>
									 <div class='switch_button'>
										 <label>
											 <input type="checkbox" class="switch" name="optimizeUnlisted" value="1" <?php checked( $view->data->optimizeUnlisted, "1" );?>>
											 <div class="the_switch">&nbsp; </div>
													<?php esc_html_e('Also optimize unlisted thumbnails, if found.','shortpixel-image-optimiser');?>
											</label>
									 </div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('Convert PNG images to JPEG','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/516-settings-convert-png-images-to-jpeg"></span></div>
									 <div class='switch_button option-png2jpg'>
										 <label>
											 <input type="checkbox" class="switch" name="png2jpg" value="1" <?php checked( ($view->data->png2jpg > 0), true);?> <?php echo($this->is_gd_installed ? '' : 'disabled') ?> data-toggle="png2jpgforce">
											 <div class="the_switch">&nbsp; </div>
											 <?php esc_html_e('Automatically convert the PNG images to JPEG, if possible.','shortpixel-image-optimiser'); ?>
										 </label>
									 </div>

								 <?php  if(!$this->is_gd_installed):
								  ?>
									 <div style="color:red;"><?php esc_html_e('You need PHP GD with support for JPEG and PNG files for this feature. Please ask your hosting 	provider to install it.','shortpixel-image-optimiser');  ?>
									 </div>
								 <?php endif; ?>


										<div class='switch_button option-png2jpgforce toggleTarget suboption' id="png2jpgforce">
											<p>&nbsp;</p>
											<label>
												<input type="checkbox" class="switch" name="png2jpgForce" value="1" <?php checked(($view->data->png2jpg > 1), true);?> <?php echo($this->is_gd_installed ? '' : 'disabled') ?>>
												<div class="the_switch">&nbsp; </div>
												<?php esc_html_e('Also force the conversion of images with transparency.','shortpixel-image-optimiser'); ?>
											</label>
										</div>

                </td>
            </tr>
            <tr class='exif_warning view-notice-row'>
                <th scope="row">&nbsp;</th>
                <td>
                   <div class='view-notice warning'><p><?php printf(esc_html__('Warning - Converting from PNG to JPG will %s not %s keep the EXIF information!', 'shortpixel-image-optimiser'), "<strong>","</strong>"); ?></p></div>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php esc_html_e('CMYK to RGB conversion','shortpixel-image-optimiser');?></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/517-settings---cmyk-to-rgb-conversion"></span></div>
									 <div class='switch_button'>
										 <label>
											 <input type="checkbox" class="switch" name="cmyk2rgb" value="1" <?php checked( $view->data->CMYKtoRGBconversion, "1" );?>>
											 <div class="the_switch">&nbsp; </div>
											 <?php esc_html_e('Adjust your images\' colors for computer and mobile displays.','shortpixel-image-optimiser');?>
										 </label>
									 </div>

                </td>
            </tr>
            <tr>
                <th scope="row"><label for="excludeSizes"><?php esc_html_e('Exclude thumbnail sizes','shortpixel-image-optimiser');?></label></th>
                <td>
                    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/113-how-can-i-optimize-only-certain-thumbnail-sizes"></span></div>
									<div class="option-content">


                    <?php foreach($view->allThumbSizes as $sizeKey => $sizeVal) {?>
                        <span style="margin-right: 20px; white-space:nowrap; line-height: 24px;">
                          <label>

                            <input name="excludeSizes[]" type="checkbox" id="excludeSizes_<?php echo esc_attr($sizeKey);?>" <?php
														// @TODO This is unreadable
														 echo esc_attr((in_array($sizeKey, $view->data->excludeSizes) ? 'checked' : ''));?>
                                   value="<?php echo esc_attr($sizeKey);?>">&nbsp;<?php $w=$sizeVal['width']?$sizeVal['width'].'px':'*';$h=$sizeVal['height']?$sizeVal['height'].'px':'*';echo("$sizeKey ({$w} &times; {$h})");?>&nbsp;&nbsp;
                            </label>
                        </span><br>
                    <?php } ?>
									</div>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="excludePatterns"><?php esc_html_e('Exclude patterns','shortpixel-image-optimiser');?></label></th>
                <td>
			<div class="option-content">
				<div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/88-how-to-exclude-images-from-being-optimized"></span></div>

				<p class="settings-info" data-toggle="exclude-settings-expanded">
						<?php
						printf(esc_html__('Use this section to exclude images based on patterns (separated by commas). A pattern consists of a %s type:value %s pair and the accepted types are %s "name", "path", "size", "regex-name" and "regex-path" %s. A file is excluded if it matches any of the patterns. Examples can be found in the collapsible area below the exclusion list.','shortpixel-image-optimiser'),
							'<b>','</b>',
							'<b>','</b>'
						);
				 ?>
				 <br /><br />

			 </p>

                    <textarea name="excludePatterns" type="text" id="excludePatterns" placeholder="<?php
                        esc_html_e('name:keepbig, path:/full/path/to/exclude/, regex-name:/valid_regex/, size:1000x2000','shortpixel-image-optimiser');?>" rows="4" cols="60"><?php echo esc_html( $excludePatterns );?></textarea>

			</div>

									 <p  class="settings-info">
										 										 <label><input type='checkbox' class='shortpixel-hide' data-toggle='exclude-settings-expanded'> >> <?php		printf(esc_html__('See examples')); ?></label>
                    </p>

										<div class='exclude-settings-expanded toggleTarget ' id="exclude-settings-expanded">
											<p  class="settings-info">
											<?php
													printf(esc_html__('For the pattern %s"name"%s, only the file name is matched, e.g. the pattern %sname:flower.jpg%s tells ShortPixel to exclude all JPEG images ending in “flower” (lowercase). At the same time, the pattern %sname:logo%s,excludes all images – PNG/JPEG/GIF – that contain the word “logo”  in their name: “nicelogo.jpg”, “alllogos.png”, “logo.gif”.', 'shortpixel-image-optimiser'),
													'<b>','</b>',
													'<b>','</b>',
													'<b>','</b>'
													);
											?>

										</p>
										<br />
										<p  class="settings-info">
											<?php
													printf(esc_html__('For the %s"path"%s pattern, the entire path is matched (useful to exclude certain (sub)-directories altogether). For example, %spath:2022%s excludes all images uploaded in 2022, but also excludes images that contain 2022 in the filename (since this is also part of the path). If you want to exclude only the images uploaded in 2022, use %spath:/2022/%s instead.','shortpixel-image-optimiser'),
													'<b>','</b>',
													'<b>','</b>',
													'<b>','</b>'
													);
													?>
												</p>
												<br />
												<p  class="settings-info">
											<?php
													printf(esc_html__('%s"regex-path"%s and %s"regex-name"%s work the same way, but require a valid regular expression placed between slashes. Special characters should be escaped by prefixing them with \ . For example %sregex-name:/[0-9]+[^\/]*\.(PNG|png)/%s excludes all PNG images that have a numeric prefix.','shortpixel-image-optimiser'),
													'<b>','</b>',
													'<b>','</b>',
													'<b>','</b>'
												);
												?>
											</p>
											<br />
											<p  class="settings-info">
												<?php
													printf(esc_html__('The %s"size"%s type, which applies only to Media Library images, excludes the main images (not thumbnails) whose size is in the specified range. The format for the "size" exclusion type is: %sminWidth-maxWidthxminHeight-maxHeight%s, for example %ssize:1000-1100x2000-2200%s. You can also specify a exact size, for example, %s1000x2000%s.','shortpixel-image-optimiser'),
													'<b>','</b>',
													'<b>','</b>',
													'<b>','</b>',
													'<b>','</b>'
												);
												?>
											</p>

									</div>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="additional-media"><?php esc_html_e('Custom media folders','shortpixel-image-optimiser');?></label></th>
                <td>

                    <?php if($view->customFolders) { ?>

			<div class="option-content">
			    <div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/46-how-to-optimize-images-in-wordpress-themes-and-plugins"></span></div>
                        <div class="shortpixel-folders-list">
                            <div class='heading'>
                                <span><?php esc_html_e('Folder name','shortpixel-image-optimiser');?></span>
                                <span><?php esc_html_e('Type &amp; Status','shortpixel-image-optimiser');?></span>
                                <span><?php esc_html_e('Files','shortpixel-image-optimiser');?></span>
                                <span><?php esc_html_e('Last change','shortpixel-image-optimiser');?></span>
                                <span>&nbsp;</span>
                                <span class='action'>&nbsp;</span>
                            </div>

                        <?php
                        foreach($view->customFolders as $index => $dirObj) {
                            $folder_id = $dirObj->get('id');

                            $type_display = ($dirObj->get('is_nextgen') ) ? __('Nextgen', 'shortpixel-image-optimiser') . ":" : "";
                            $stat = $dirObj->getStats();

                            $fullstatus = esc_html__("Optimized",'shortpixel-image-optimiser') . ": " . $stat['optimized'] . ", "
                                  . " " . esc_html__("Waiting",'shortpixel-image-optimiser') . ": " . $stat['waiting'] . ""
                                  ;

                            if ($stat['total'] == 0)
                            {
                              $optimize_status = __("Empty",'shortpixel-image-optimiser');
                              $fullstatus = '';
                            }
                            elseif ($stat['total'] == $stat['optimized'])
                            {
                              $optimize_status = __("Optimized",'shortpixel-image-optimiser');
                            }
                            elseif ($stat['optimized'] > 0)
                            {
                               $optimize_status = __("Pending",'shortpixel-image-optimiser');
                            }
                            else
                            {
                              $optimize_status = __("Waiting",'shortpixel-image-optimiser');
                            }

                            $action =  __("Stop monitoring",'shortpixel-image-optimiser');

                            $err = ''; // unused since failed is gone.
                            if (! $dirObj->exists() && ! $err)
                              $err = __('Directory does not exist', 'shortpixel-image-optimiser');


                            if ($dirObj->get('is_nextgen') && $view->data->includeNextGen == 1)
                              $action = false;


                              $refreshUrl = add_query_arg(array('sp-action' => 'action_refreshfolder', 'folder_id' => $folder_id, 'part' => 'adv-settings'), $this->url); // has url
                            ?>
                            <div>
                                <span class='folder folder-<?php echo esc_attr($dirObj->get('id')) ?>'><?php echo esc_html($dirObj->getPath()); ?></span>
                                <span>
                                    <?php if(!($stat['total'] == 0)) { ?>
                                    <span title="<?php echo esc_attr($fullstatus); ?>" class='info-icon'>
                                        <img alt='<?php esc_html_e('Info Icon', 'shortpixel-image-optimiser') ?>' src='<?php echo esc_url( wpSPIO()->plugin_url('res/img/info-icon.png' ));?>' style="margin-bottom: -2px;"/>
                                    </span>&nbsp;<?php  }
                                    echo esc_html($type_display. ' ' . $optimize_status . $err);
                                    ?>
                                </span>
                                <span>
                                    <?php echo esc_html($stat['total']); ?> files
                                </span>
                                <span>
                                    <?php echo esc_html(UiHelper::formatTS($dirObj->get('updated'))) ?>
                                </span>
                                <span>
                                  <a href='<?php echo esc_url($refreshUrl) ?>' title="<?php esc_html_e('Recheck for new images', 'shortpixel-image-optimiser'); ?>" class='refresh-folder'><i class='dashicons dashicons-update'>&nbsp;</i></a>
                                </span>
                                <span class='action'>
                                  <?php if ($action): ?>
                                    <input type="button" class="button remove-folder-button" data-value="<?php echo esc_attr($dirObj->get('id')); ?>" data-name="<?php echo esc_attr($dirObj->getPath()) ?>" title="<?php echo esc_attr($action . " " . $dirObj->getPath()); ?>"   value="<?php echo esc_attr($action); ?>">
                                 <?php endif; ?>
                                </span>
                            </div>
                        <?php }?>
                      </div> <!-- shortpixel-folders-list -->
		      </div>
                    <?php } ?>

                    <div class='addCustomFolder'>

                      <input type="hidden" name="removeFolder" id="removeFolder"/>
                      <p class='add-folder-text'><strong><?php esc_html_e('Add a custom folder', 'shortpixel-image-optimiser'); ?></strong></p>
                      <input type="text" name="addCustomFolderView" id="addCustomFolderView" class="regular-text" value="" disabled style="">&nbsp;
                      <input type="hidden" name="addCustomFolder" id="addCustomFolder" value=""/>
                      <input type="hidden" id="customFolderBase" value="<?php echo esc_attr($this->view->customFolderBase); ?>">

                      <a class="button select-folder-button" title="<?php esc_html_e('Select the images folder on your server.','shortpixel-image-optimiser');?>" href="javascript:void(0);">
                          <?php esc_html_e('Select','shortpixel-image-optimiser');?>
                      </a>
                    <input type="submit" name="save" id="saveAdvAddFolder" class="button button-primary hidden" title="<?php esc_html_e('Add this Folder','shortpixel-image-optimiser');?>" value="<?php esc_html_e('Add this Folder','shortpixel-image-optimiser');?>">
                    <p class="settings-info">
                        <?php printf(esc_html__('Use the Select... button to select site folders. ShortPixel will optimize images and PDFs from the specified folders and their subfolders. In the %s Custom Media list %s, under the Media menu, you can see the optimization status for each image or PDF in these folders.','shortpixel-image-optimiser'), '<a href="upload.php?page=wp-short-pixel-custom">', '</a>');?>
                    </p>

                    <div class="sp-modal-shade sp-folder-picker-shade"></div>
                        <div class="shortpixel-modal modal-folder-picker shortpixel-hide">
                            <div class="sp-modal-title"><?php esc_html_e('Select the images folder','shortpixel-image-optimiser');?></div>
                            <div class="sp-folder-picker"></div>
                            <input type="button" class="button button-info select-folder-cancel" value="<?php esc_html_e('Cancel','shortpixel-image-optimiser');?>" style="margin-right: 30px;">
                            <input type="button" class="button button-primary select-folder" value="<?php esc_html_e('Select','shortpixel-image-optimiser');?>">
                        </div>

                    <script>
                        jQuery(document).ready(function () {
                            ShortPixel.initFolderSelector();
                        });
                    </script>
                  </div> <!-- end of AddCustomFolder -->
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="authentication"><?php esc_html_e('HTTP AUTH credentials','shortpixel-image-optimiser');?></label></th>
                <td>
									<?php if (! defined('SHORTPIXEL_HTTP_AUTH_USER')): ?>
		                  <input name="siteAuthUser" type="text" id="siteAuthUser" value="<?php echo( esc_html(wp_unslash($view->data->siteAuthUser )));?>" class="regular-text" placeholder="<?php esc_html_e('User','shortpixel-image-optimiser');?>" style="margin-bottom: 8px"><br>
	                    <input name="siteAuthPass" type="text" id="siteAuthPass" value="<?php echo( esc_html(wp_unslash($view->data->siteAuthPass )));?>" class="regular-text" placeholder="<?php esc_html_e('Password','shortpixel-image-optimiser');?>" style="margin-bottom: 8px">
	                    <p class="settings-info">
	                        <?php printf(esc_html__('Only fill in these fields if your site (front-end) is not publicly accessible and visitors need a user/pass to connect to it.
                                    If you don\'t know what is this then just %sleave the fields empty%s.','shortpixel-image-optimiser'), '<strong>', '</strong>'); ?>
	                    </p>
									<?php else:  ?>
												<p><?php esc_html_e('The HTTP AUTH credentials have been defined in the wp-config file.', 'shortpixel-image-optimiser'); ?></p>
									<?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
    <p class="submit">
        <input type="submit" name="save" id="saveAdv" class="button button-primary" title="<?php esc_attr_e('Save Changes','shortpixel-image-optimiser');?>" value="<?php esc_attr_e('Save Changes','shortpixel-image-optimiser');?>"> &nbsp;
        <input type="submit" name="save_bulk" id="bulkAdvGo" class="button button-primary" title="<?php esc_attr_e('Save and go to the Bulk Processing page','shortpixel-image-optimiser');?>" value="<?php esc_attr_e('Save and Go to Bulk Process','shortpixel-image-optimiser');?>"> &nbsp;
    </p>
    </div>
    <script>
		<!-- @todo // Inline JS -->
        jQuery(document).ready(function () { ShortPixel.setupAdvancedTab();});
    </script>
</section>
