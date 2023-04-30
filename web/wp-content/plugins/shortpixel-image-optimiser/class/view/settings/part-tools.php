<?php
namespace ShortPixel;
use \ShortPixel\Controller\BulkController as BulkController;
use \ShortPixel\Helper\UiHelper as UiHelper;

$url = esc_url_raw(remove_query_arg('part'));

$bulk = BulkController::getInstance();
$queueRunning = $bulk->isAnyBulkRunning();

?>

<section id="tab-tools" class="clearfix <?php echo ($this->display_part == 'tools') ? ' sel-tab ' :''; ?> ">
    <h2><a class='tab-link' href='javascript:void(0);' data-id="tab-tools"><?php esc_html_e('Tools','shortpixel-image-optimiser');?></a></h2>


	<p><?php printf(esc_html__('The tools provided below are designed to make bulk changes to your image and optimization data. Therefore, it is %s very important %s that you back up your entire website before running them. ', 'shortpixel-image-optimiser'), '<b>', '</b>'); ?></p>

	<div class='wp-shortpixel-options wp-shortpixel-tab-content'>



		<?php if ($queueRunning === true): ?>
		<div class='option'>
			<div class='name'>&nbsp;</div>

			<div class='field action queue-warning'>
				 	<?php esc_html_e('It looks like a bulk process is still active. Please note that bulk actions will reset running bulk processes. ', 'shortpixel-image-optimiser'); ?>
			 </div>
		</div>
		<?php endif; ?>


		<div class='option'>
			<div class='name'><?php esc_html_e('Migrate data', 'shortpixel-image-optimiser'); ?></div>
			<div class='field'>
				<div class='option-content'>
						<div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/539-spio-5-tells-me-to-convert-legacy-data-what-is-this">
					 </span></div>
						<a href="<?php echo esc_url(add_query_arg(array('sp-action' => 'action_debug_redirectBulk', 'bulk' => 'migrate', 'noheader' => true), $url)); ?>" class="button">
								<?php esc_html_e('Search and Migrate All', 'shortpixel-image-optimiser'); ?>
						</a>
				</div>
				<p class='settings-info'><?php printf(esc_html__('ShortPixel Image Optimizer version 5.0 brings a new format for saving the image optimization information. If you have upgraded from a version prior to version 5.0, you may want to convert all your image data to the new format. This conversion will speed up the plugin and ensure that all data is preserved. %s Check your image data after doing the conversion! %s', 'shortpixel-image-optimiser'), '<br><b>', '</b>') ?> </p>
			</div>
		</div>



 		<div class='option'>
			<div class='name'><?php esc_html_e('Clear Queue','shortpixel-image-optimiser'); ?></div>
			<div class='field'>

				<a href="<?php echo esc_url(add_query_arg(array('sp-action' => 'action_debug_resetQueue', 'queue' => 'all', 'part' => 'tools', 'noheader' => true), $url)); ?>" class="button"><?php esc_html_e('Clear the Queue','shortpixel-image-optimiser'); ?></a>
				<p class='settings-info'><?php esc_html_e('Removes all items currently waiting or being processed from all queues. This stops all optimization processes in the entire installation.', 'shortpixel-image-optimiser'); ?> </p>

			</div>
		</div>



		<hr />

		<div class='danger-zone'>
			<h3><?php esc_html_e('Danger Zone - please read carefully!', 'shortpixel-image-optimiser'); ?></h3>
			<p><?php printf(esc_html__('The following actions are related to cleaning up and uninstalling the plugin. %s They cannot be undone %s. It is important that you create a new backup copy before performing any of these actions, as this may result in data loss.', 'shortpixel-image-optimiser'), '<strong>', '</strong>');  ?></p>
			<hr />


			<div class='option'>
					<div class='name'>Remove data</div>
					<div class='field'>
						<div class="option-content">
							<a href="<?php echo esc_url(add_query_arg(array('sp-action' => 'action_debug_redirectBulk', 'bulk' => 'restore', 'noheader' => true), $url)) ?>" class="button danger">Bulk Restore</a>

							<div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/14-can-i-restore-my-images-what-happens-with-the-originals"></span></div>
						</div>
						<p class='settings-info'><?php printf(esc_html__('%sUndoes%s all optimizations and restores all your backed-up images to their original state. Credits used will not be refunded and you will have to optimize your images again.', 'shortpixel-image-optimiser'), '<b>','</b>'); ?></p>
					</div>
			</div>

			<div class='option'>
					<div class='name'>&nbsp;</div>
					<div class='field'>
						<a href="<?php echo esc_url(add_query_arg(array('sp-action' => 'action_debug_redirectBulk', 'bulk' => 'removeLegacy', 'noheader' => true), $url)); ?>" class="button danger">Remove Legacy Data</a>

					<p class='settings-info'><?php printf(esc_html__('%sRemoves Legacy Data%s (the old format for storing image optimization information in the database, which was used before version 5). This may result in data loss. It is not recommended to do this manually.', 'shortpixel-image-optimiser'), '<b>','</b>'); ?></p>
				</div>
			</div>

			<div class='option'>
					<div class='name'>&nbsp;</div>
					<div class='field'>
						<div class="option-content">
							<button type="button" class='button danger' data-action="open-modal" data-target="ToolsRemoveAll">
														<?php esc_html_e('Remove all ShortPixel Data', 'shortpixel-image-optimiser'); ?></button>

							<div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/81-remove-all-the-shortpixel-related-data-on-a-wp-website"></span></div>
						</div>
						<div class='remove-all modalTarget' id="ToolsRemoveAll">

							<input type="hidden" name="screen_action" value="toolsRemoveAll" />
							<?php  wp_nonce_field('remove-all', 'tools-nonce'); ?>

							<p>&nbsp;</p>
							<p><?php esc_html_e('This will remove all ShortPixel Data including data about optimization and image backups.', 'shortpixel-image-optimiser'); ?></p>
							<?php esc_html_e('Type confirm to delete all ShortPixel data', 'shortpixel-image-optimiser'); ?>
							<input type="text" name="confirm" value=""  data-required='confirm' />

							<p><b><?php esc_html_e('I understand that all ShortPixel data will be removed.','shortpixel-image-optimiser'); ?></b></p>

							<button type="button" class='button modal-send' name="uninstall" data-action='ajaxrequest'><?php esc_html_e('Remove all data', 'shortpixel-image-optimiser'); ?></button>

						</div> <!-- modal -->
						<p class='settings-info'><?php printf(esc_html__('%sRemoves all ShortPixel data (including backups) %s and deactivates the plugin. Your images will not be changed (the optimized images will remain), but the next time ShortPixel is activated, it will no longer recognize previous optimizations.', 'shortpixel-image-optimiser'), '<b>','</b>'); ?></p>
				 </div>
			</div>


			 <div class="option">
				 		<div class='name'>&nbsp;</div>
						<div class='field'>
										<div class="backup-modal">
									<?php wp_nonce_field('empty-backup', 'tools-nonce'); ?>

									<div class="option-content">
										<button type="button" class='button danger' data-action="open-modal" data-target="ToolsRemoveBackup">
																	<?php esc_html_e('Remove backups', 'shortpixel-image-optimiser'); ?></button>

										<div class="spio-inline-help"><span class="dashicons dashicons-editor-help" title="Click for more info" data-link="https://shortpixel.com/knowledge-base/article/83-how-to-remove-the-backed-up-images-in-wordpress"></span></div>

									</div>
									<div class='remove-backup modalTarget' id="ToolsRemoveBackup">

										<input type="hidden" name="screen_action" value="toolsRemoveBackup" />
										<?php  wp_nonce_field('empty-backup', 'tools-nonce'); ?>

										<p>&nbsp;</p>
										<p><?php esc_html_e('This will delete all the backup images. You won\'t be able to restore from backup or to reoptimize with different settings if you delete the backups.', 'shortpixel-image-optimiser'); ?></p>
										<?php esc_html_e('Type confirm to delete all ShortPixel backups', 'shortpixel-image-optimiser'); ?>
										<input type="text" name="confirm" value="" data-required='confirm' />

										<p><b><?php esc_html_e('I understand that all Backups will be removed.','shortpixel-image-optimiser'); ?>  </b></p>

										<p class='center'>
											<button type="button" class='button modal-send' name="removebackups" data-action='ajaxrequest'><?php esc_html_e('Remove backups', 'shortpixel-image-optimiser'); ?></button>
										</p>
									</div>
							</div> <!-- backup modal -->

							<p class='settings-info'><?php esc_html_e('When backups are enabled, original images are stored in a backup folder. If you remove the backup folder, you will not be able to restore or reoptimize the images. We strongly recommend that you keep a copy of the backup folder (/wp-content/uploads/ShortpixelBackups/) somewhere safe.','shortpixel-image-optimiser');?>
						</div>

				</div>


			</div> <!-- danger zone -->
	</div> <!-- options tab content -->
</section>
