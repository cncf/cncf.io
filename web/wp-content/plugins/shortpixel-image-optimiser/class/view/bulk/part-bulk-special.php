<?php
use \ShortPixel\Controller\BulkController as BulkController;

	$bulk = BulkController::getInstance();
	$queueRunning = $bulk->isAnyBulkRunning();
?>

<section class='panel bulk-restore' data-panel="bulk-restore"  >
  <h3 class='heading'>
    <?php esc_html_e("Bulk Restore", 'shortpixel-image-optimiser'); ?>
  </h3>


	<div class='bulk-special-wrapper'>

	  <h4 class='warning'><?php esc_html_e('Warning', 'shortpixel-image-optimiser'); ?></h4>

	  <p><?php printf(esc_html__('By starting the %s bulk restore %s process, the plugin will try to restore %s all images %s to the original state. All images will become unoptimized.', 'shortpixel-image-optimiser'), '<b>', '</b>', '<b>', '</b>'); ?></p>

		<p><?php printf(esc_html__('We recommend users to %s contact us %s before restoring the images - many times the restoring is not necessary and we can help. But if you choose to continue then we strongly recommend to create a full backup before starting the process.', 'shortpixel-image-optimiser'), '<b><a href="https://shortpixel.com/contact" target="_blank">', '</a></b>'); ?>
		</p>
				<p class='warning'><?php esc_html_e('It is strongly advised to create a full backup before starting this process.', 'shortpixel-image-optimiser'); ?></p>

<?php if ($this->view->approx->custom->has_custom === true) : ?>
					<div class='optiongroup' data-check-visibility data-control="data-check-custom-hascustom">

						<div class='switch_button'>
							<label>
								<input type="checkbox" class="switch" id="restore_media_checkbox" >
								<div class="the_switch">&nbsp; </div>
							</label>
						</div>
						<h4><label for="restore_media_checkbox"><?php esc_html_e('Restore media library','shortpixel-image-optimiser'); ?></label></h4>
					</div>


					<div class='optiongroup' data-check-visibility data-control="data-check-custom-hascustom">
						<div class='switch_button'>
							<label>
								<input type="checkbox" class="switch" id="restore_custom_checkbox" value='1' >
								<div class="the_switch">&nbsp; </div>
							</label>
						</div>
						<h4><label for="restore_custom_checkbox"><?php esc_html_e('Restore custom media','shortpixel-image-optimiser'); ?></label></h4>
					</div>
<?php endif ?>
		<p class='optiongroup warning hidden' id="restore_media_warn"><?php esc_html_e('Please select one of the options', 'shortpixel-image-optimiser'); ?></p>

	  <p class='optiongroup' ><input type="checkbox" id="bulk-restore-agree" value="agree" data-action="ToggleButton" data-target="bulk-restore-button"> <?php esc_html_e('I want to restore all selected images. I understand this action is permanent and nonreversible', 'shortpixel-image-optimiser'); ?></p>


	  <nav>
    	<button type="button" class="button" data-action="open-panel" data-panel="dashboard"><?php esc_html_e('Back','shortpixel-image-optimiser'); ?></button>

			<button type="button" class="button button-primary disabled" id='bulk-restore-button' data-action="BulkRestoreAll" disabled><?php esc_html_e('Bulk Restore All Images', 'shortpixel-image-optimiser') ?></button>

	  </nav>

</div>
</section>


<section class='panel bulk-migrate' data-panel="bulk-migrate"  >
  <h3 class='heading'>
    <?php esc_html_e("Bulk Migrate", 'shortpixel-image-optimiser'); ?>
  </h3>

	<div class='bulk-special-wrapper'>

	  <h4 class='warning'><?php esc_html_e('Warning', 'shortpixel-image-optimiser'); ?></h4>

	  <p><?php printf(esc_html__('By starting the %s bulk metadata migration %s process, the plugin will try to migrate the old format of optimization information (used by the plugin for versions prior to 5.0) to the new format used from version 5.0 onward for %s all the images. %s It is possible to have exceptions and some of the image information migration may fail. You should get all the details for these cases at the end of the process, in the Errors section.', 'shortpixel-image-optimiser'), '<b>', '</b>', '<b>', '</b>'); ?></p>

		<p class='warning optiongroup'><?php esc_html_e('It is strongly advised to create a full backup before starting this process.', 'shortpixel-image-optimiser'); ?></p>

	  <p class='optiongroup'><input type="checkbox" id="bulk-migrate-agree" value="agree" data-action="ToggleButton" data-target="bulk-migrate-button"> <?php esc_html_e('I want to migrate the metadata for all images. I understand this action is permanent. I made a backup of my site including images and database.', 'shortpixel-image-optimiser'); ?></p>


	  <nav>


	    <button class="button" type="button" data-action="open-panel" data-panel="dashboard"><?php esc_html_e('Back','shortpixel-image-optimiser'); ?></button>

			 <button type="button" type="button" class="button disabled button-primary" disabled id='bulk-migrate-button' data-action="BulkMigrateAll"  ><?php esc_html_e('Search and migrate All Images', 'shortpixel-image-optimiser') ?>
			 </button>

	  </nav>
	</div>
</section>

<section class='panel bulk-removeLegacy' data-panel="bulk-removeLegacy"  >
  <h3 class='heading'>
    <?php esc_html_e("Bulk remove legacy data", 'shortpixel-image-optimiser'); ?>
  </h3>

	<div class='bulk-special-wrapper'>

	  <h4 class='warning'><?php esc_html_e('Warning', 'shortpixel-image-optimiser'); ?></h4>

	  <p><?php printf(esc_html__('By starting the %s remove legacy metadata %s process, the plugin will try to remove all the %s legacy data %s (that was used by the plugin to store the optimization information in versions earlier than 5.0). If this legacy metadata isn\'t properly migrated or some of the migration failed for any reason, it will be impossible to undo or redo the process. In these cases, the optimization information for images processed with versions earlier than 5.0 could be lost.', 'shortpixel-image-optimiser'), '<b>', '</b>', '<b>', '</b>'); ?></p>

		<p class='warning optiongroup'><?php esc_html_e('It is strongly advised to create a full backup before starting this process.', 'shortpixel-image-optimiser'); ?></p>
	  <p class='optiongroup'><input type="checkbox" id="bulk-migrate-agree" value="agree" data-action="ToggleButton" data-target="bulk-removelegacy-button"> <?php esc_html_e('I want to remove all legacy data. I understand this action is permanent. I made a backup of my site including images and database.', 'shortpixel-image-optimiser'); ?></p>


	  <nav>

	    <button type="button" class="button" data-action="open-panel" data-panel="dashboard"><?php esc_html_e('Back','shortpixel-image-optimiser'); ?></button>

			 <button type="button" class="button disabled button-primary" disabled id='bulk-removelegacy-button' data-action="BulkRemoveLegacy"  ><?php esc_html_e('Remove all legacy metadata', 'shortpixel-image-optimiser') ?></button>

	  </nav>
	</div>
</section>
