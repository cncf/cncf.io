<?php
namespace ShortPixel\Model\AdminNotices;

class CompatNotice extends \ShortPixel\Model\AdminNoticeModel
{
	protected $key = 'MSG_COMPAT';
	protected $errorLevel = 'warning';

	protected function checkTrigger()
	{
			$conflictPlugins = $this->getConflictingPlugins();
			if (count($conflictPlugins) > 0)
			{
				$this->addData('conflicts', $conflictPlugins);
				return true;
			}
			else {
				return false;
			}
	}

	protected function getMessage()
	{
//		$conflicts = \ShortPixelTools::getConflictingPlugins();
		$conflicts = $this->getData('conflicts');
		if (! is_array($conflicts))
			$conflicts = array();

		$message = __("The following plugins are not compatible with ShortPixel and may cause unexpected results: ",'shortpixel-image-optimiser');
		$message .= '<ul class="sp-conflict-plugins">';
		foreach($conflicts as $plugin) {
				//ShortPixelVDD($plugin);
				$action = $plugin['action'];
				$link = ( $action == 'Deactivate' )
						? wp_nonce_url( admin_url( 'admin-post.php?action=shortpixel_deactivate_conflict_plugin&plugin=' . urlencode( $plugin['path'] ) ), 'sp_deactivate_plugin_nonce' )
						: $plugin['href'];
				$message .= '<li class="sp-conflict-plugins-list"><strong>' . $plugin['name'] . '</strong>';
				$message .= '<a href="' . $link . '" class="button button-primary">' . $action . '</a>';

				if($plugin['details']) $message .= '<br>';
				if($plugin['details']) $message .= '<span>' . $plugin['details'] . '</span>';
		}
		$message .= "</ul>";

		return $message;
	}

	protected function getConflictingPlugins() {
			$settings = \wpSPIO()->settings();

			$conflictPlugins = array(
					'WP Smush - Image Optimization'
							=> array(
											'action'=>'Deactivate',
											'data'=>'wp-smushit/wp-smush.php',
											'page'=>'wp-smush-bulk'
							),
					'Imagify Image Optimizer'
							=> array(
											'action'=>'Deactivate',
											'data'=>'imagify/imagify.php',
											'page'=>'imagify'
							),
					'Compress JPEG & PNG images (TinyPNG)'
							=> array(
											'action'=>'Deactivate',
											'data'=>'tiny-compress-images/tiny-compress-images.php',
											'page'=>'tinify'
							),
					'Kraken.io Image Optimizer'
							=> array(
											'action'=>'Deactivate',
											'data'=>'kraken-image-optimizer/kraken.php',
											'page'=>'wp-krakenio'
							),
					'Optimus - WordPress Image Optimizer'
							=> array(
											'action'=>'Deactivate',
											'data'=>'optimus/optimus.php',
											'page'=>'optimus'
							),
					'Phoenix Media Rename' => array(
											'action' => 'Deactivate',
											'data' => 'phoenix-media-rename/phoenix-media-rename.php',
					),
					'EWWW Image Optimizer'
							=> array(
											'action'=>'Deactivate',
											'data'=>'ewww-image-optimizer/ewww-image-optimizer.php',
											'page'=>'ewww-image-optimizer%2F'
							),
					'EWWW Image Optimizer Cloud'
							=> array(
											'action'=>'Deactivate',
											'data'=>'ewww-image-optimizer-cloud/ewww-image-optimizer-cloud.php',
											'page'=>'ewww-image-optimizer-cloud%2F'
							),
					'ImageRecycle pdf & image compression'
							=> array(
											'action'=>'Deactivate',
											'data'=>'imagerecycle-pdf-image-compression/wp-image-recycle.php',
											'page'=>'option-image-recycle'
							),
					'CheetahO Image Optimizer'
							=> array(
											'action'=>'Deactivate',
											'data'=>'cheetaho-image-optimizer/cheetaho.php',
											'page'=>'cheetaho'
							),
					'Zara 4 Image Compression'
							=> array(
											'action'=>'Deactivate',
											'data'=>'zara-4/zara-4.php',
											'page'=>'zara-4'
							),
					'CW Image Optimizer'
							=> array(
											'action'=>'Deactivate',
											'data'=>'cw-image-optimizer/cw-image-optimizer.php',
											'page'=>'cw-image-optimizer'
							),
					'Simple Image Sizes'
							=> array(
											'action'=>'Deactivate',
											'data'=>'simple-image-sizes/simple_image_sizes.php'
							),
					'Regenerate Thumbnails and Delete Unused'
						=> array(
										'action' => 'Deactivate',
										'data' => 'regenerate-thumbnails-and-delete-unused/regenerate_wpregenerate.php',
						),
						'Swift Performance'
							=> array(
											'action' => 'Deactivate',
											'data' => 'swift-performance/performance.php',
							),
							'Swift Performance Lite'
								=> array(
												'action' => 'Deactivate',
												'data' => 'swift-performance-lite/performance.php',
								),
						 //DEACTIVATED TEMPORARILY - it seems that the customers get scared.
					/* 'Jetpack by WordPress.com - The Speed up image load times Option'
							=> array(
											'action'=>'Change Setting',
											'data'=>'jetpack/jetpack.php',
											'href'=>'admin.php?page=jetpack#/settings'
							)
					*/
			);
			if($settings->processThumbnails) {
					$details = __('Details: recreating image files may require re-optimization of the resulting thumbnails, even if they were previously optimized. Please use <a href="https://wordpress.org/plugins/regenerate-thumbnails-advanced/" target="_blank">reGenerate Thumbnails Advanced</a> instead.','shortpixel-image-optimiser');

					$conflictPlugins = array_merge($conflictPlugins, array(
							'Regenerate Thumbnails'
									=> array(
													'action'=>'Deactivate',
													'data'=>'regenerate-thumbnails/regenerate-thumbnails.php',
													'page'=>'regenerate-thumbnails',
													'details' => $details
									),
							'Force Regenerate Thumbnails'
									=> array(
													'action'=>'Deactivate',
													'data'=>'force-regenerate-thumbnails/force-regenerate-thumbnails.php',
													'page'=>'force-regenerate-thumbnails',
													'details' => $details
									)
					));
			}


			$found = array();
			foreach($conflictPlugins as $name => $path) {
					$action = ( isset($path['action']) ) ? $path['action'] : null;
					$data = ( isset($path['data']) ) ? $path['data'] : null;
					$href = ( isset($path['href']) ) ? $path['href'] : null;
					$page = ( isset($path['page']) ) ? $path['page'] : null;
					$details = ( isset($path['details']) ) ? $path['details'] : null;
					if(is_plugin_active($data)) {
							if( $data == 'jetpack/jetpack.php' ){
									$jetPackPhoton = get_option('jetpack_active_modules') ? in_array('photon', get_option('jetpack_active_modules')) : false;
									if( !$jetPackPhoton ){ continue; }
							}
							$found[] = array( 'name' => $name, 'action'=> $action, 'path' => $data, 'href' => $href , 'page' => $page, 'details' => $details);
					}
			}
			return $found;
	}

}
