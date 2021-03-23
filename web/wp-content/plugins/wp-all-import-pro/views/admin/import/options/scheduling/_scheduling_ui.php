<div class="wpallimport-collapsed closed wpallimport-section scheduling">
	<div class="wpallimport-content-section">
		<div class="wpallimport-collapsed-header <?php if(!$import->canBeScheduled()) { ?> disabled<?php } ?>"
        <?php if(!$import->canBeScheduled()) { ?> title="<?php _e("To run this import on a schedule you must use the 'Download from URL' or 'Use existing file' options in Step 1.", PMXI_Plugin::LANGUAGE_DOMAIN);?>" <?php }?>>
			<h3 id="scheduling-title"><?php _e('Scheduling Options','wp_all_import_plugin');?>
                <?php if(!$import->canBeScheduled()) { ?>
                <a href="#help" class="wpallimport-help" style="position: relative; top: -2px; margin-left: 0; width: 20px; height: 20px;"  title="<?php _e("To run this import on a schedule you must use the 'Download from URL' or 'Use existing file' option on the Import Settings page.", PMXI_Plugin::LANGUAGE_DOMAIN);?>">?</a>
                <?php } ?>
            </h3>
        </div>
		<div class="wpallimport-collapsed-content" style="padding: 0;">
			<div class="wpallimport-collapsed-content-inner">
				<table class="form-table" style="max-width:none;">
					<tr>
						<td colspan="3">
							<?php
							$scheduling = \Wpai\Scheduling\Scheduling::create();
							$hasActiveLicense = $scheduling->checkLicense();
							$cron_job_key = PMXI_Plugin::getInstance()->getOption('cron_job_key');
							$options = PMXI_Plugin::getInstance()->getOption();
							$import_id = $import->id;
							?>
							<script type="text/javascript">
								(function ($) {
									$(function () {
										$(document).ready(function () {
											<?php if($post['scheduling_timezone'] == 'UTC') {?>
											var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

											if($('#timezone').find("option:contains('"+ timeZone +"')").length != 0){

                        						$('#timezone').val(timeZone);
                        						$('#timezone').trigger("chosen:updated");

                    						}else{

                        						var parts = timeZone.split('/');
                        						var lastPart = parts[parts.length-1];

                        						var opt = $('#timezone').find("option:contains('"+ lastPart +"')");
                        						
                        						$('#timezone').val(opt.val());
                        						$('#timezone').trigger("chosen:updated");

                    						}
											<?php
											}
											?>
										});
									});
								})(jQuery);
							</script>

							<div id="scheduling-form" style="width: 600px;">
								<div style="margin-bottom: 11px;">
									<label>
										<input type="radio" name="scheduling_enable" value="0" <?php if(!$post['scheduling_enable']) { ?> checked="checked" <?php } ?>/>
										<h4 style="display: inline-block; margin: 0;"><?php _e('Do Not Schedule'); ?></h4>
									</label>
								</div>
								<div style="margin-bottom: 2px;">
									<label style="margin-bottom: -4px !important;">
										<input type="radio" name="scheduling_enable" value="1" <?php if($post['scheduling_enable'] == 1) {?> checked="checked" <?php }?>/>
										<h4 style="margin: 0; position: relative; display: inline-block;"><?php _e('Automatic Scheduling', PMXI_Plugin::LANGUAGE_DOMAIN); ?>
											<span class="connection-icon" style="position: absolute; top:-1px; left: 152px;">
															<?php include_once('_connection_icon.php'); ?>
														</span>
											<?php if (!$scheduling->checkConnection()) { ?>
												<span class="wpai-license" style="margin-left: 25px; display: inline-block; font-weight: normal; <?php if(!$hasActiveLicense) { ?> display: none; <?php }?> color: #f2b03d;  ">Unable to connect - <a target="_blank" style="text-decoration: underline" href="http://wpallimport.com/support">please contact support</a>.</span>
											<?php } ?>
										</h4>
									</label>
								</div>

								<div style="margin-bottom: 2px; margin-left:26px;">
									<label style="width: 100%; font-size: 13px;">
										<?php _e('Run this import on a schedule.'); ?>
									</label>
								</div>
								<div id="automatic-scheduling"
									 style="margin-left: 21px; <?php if ($post['scheduling_enable'] != 1) { ?> display: none; <?php } ?>">
									<div>
										<div class="input">
											<label style="color: rgb(68,68,68);">
												<input
													type="radio" <?php if ($post['scheduling_run_on'] != 'monthly') { ?> checked="checked" <?php } ?>
													name="scheduling_run_on" value="weekly"
													checked="checked"/> <?php _e('Every week on...', PMXI_Plugin::LANGUAGE_DOMAIN); ?>
											</label>
										</div>
										<input type="hidden" style="width: 500px;" name="scheduling_weekly_days"
											   value="<?php echo $post['scheduling_weekly_days']; ?>" id="weekly_days"/>
										<?php
										if (isset($post['scheduling_weekly_days'])) {
											$weeklyArray = explode(',', $post['scheduling_weekly_days']);
										} else {
											$weeklyArray = array();
										}
										?>
										<ul class="days-of-week" id="weekly" style="<?php if ($post['scheduling_run_on'] == 'monthly') { ?> display: none; <?php } ?> margin-top: 7px;">
											<li data-day="0" <?php if (in_array('0', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Mon
											</li>
											<li data-day="1" <?php if (in_array('1', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Tue
											</li>
											<li data-day="2" <?php if (in_array('2', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Wed
											</li>
											<li data-day="3" <?php if (in_array('3', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Thu
											</li>
											<li data-day="4" <?php if (in_array('4', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Fri
											</li>
											<li data-day="5" <?php if (in_array('5', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Sat
											</li>
											<li data-day="6" <?php if (in_array('6', $weeklyArray)) { ?> class="selected" <?php } ?>>
												Sun
											</li>
										</ul>
									</div>
									<div style="clear: both;"></div>
									<div style="margin-top: -2px;">
										<div class="input">
											<label style="color: rgb(68,68,68);">
												<input
													type="radio" <?php if ($post['scheduling_run_on'] == 'monthly') { ?> checked="checked" <?php } ?>
													name="scheduling_run_on"
													value="monthly"/> <?php _e('Every month on the first...', PMXI_Plugin::LANGUAGE_DOMAIN); ?>
											</label>
										</div>
										<input type="hidden" name="scheduling_monthly_days" value="<?php if(isset($post['scheduling_monthly_days'])) echo $post['scheduling_monthly_days']; ?>" id="monthly_days"/>
										<?php
										if (isset($post['scheduling_monthly_days'])) {
											$monthlyArray = explode(',', $post['scheduling_monthly_days']);
										} else {
											$monthlyArray = array();
										}
										?>
										<ul class="days-of-week" id="monthly"
											style="<?php if ($post['scheduling_run_on'] != 'monthly') { ?> display: none; <?php } ?> margin-top: 6px;">
											<li data-day="0" <?php if (in_array('0', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Mon
											</li>
											<li data-day="1" <?php if (in_array('1', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Tue
											</li>
											<li data-day="2" <?php if (in_array('2', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Wed
											</li>
											<li data-day="3" <?php if (in_array('3', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Thu
											</li>
											<li data-day="4" <?php if (in_array('4', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Fri
											</li>
											<li data-day="5" <?php if (in_array('5', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Sat
											</li>
											<li data-day="6" <?php if (in_array('6', $monthlyArray)) { ?> class="selected" <?php } ?>>
												Sun
											</li>
										</ul>
									</div>
									<div style="clear: both;"></div>

									<div id="times-container" style="margin-left: 5px;">
										<div style="margin-top: 4px; margin-bottom: 5px; font-size: 12px;">
											What times do you want this import to run?
										</div>

										<div id="times" style="margin-bottom: 10px;">
											<?php if (is_array($post['scheduling_times'])) {
												foreach ($post['scheduling_times'] as $time) { ?>

													<?php if ($time) { ?>
														<input class="timepicker" type="text" name="scheduling_times[]"
															   value="<?php echo $time; ?>"/>
													<?php } ?>
												<?php } ?>
												<input class="timepicker" type="text" name="scheduling_times[]"/>
											<?php } ?>
										</div>
										<div style="clear: both;"></div>
										<div class="timezone-select" style="position:absolute; margin-top: 9px;">
											<?php

											$timezoneValue = false;
											if ($post['scheduling_timezone']) {
												$timezoneValue = $post['scheduling_timezone'];
											}

											$timezoneSelect = new \Wpai\Scheduling\Timezone\TimezoneSelect();
											echo $timezoneSelect->getTimezoneSelect($timezoneValue);
											?>
										</div>
									</div>
									<div style="height: 35px; margin-top: 30px; <?php if(!$hasActiveLicense) {?>display: none; <?php } ?>" id="subscribe-filler">&nbsp;</div>
                                    <input type="hidden" id="scheduling_has_license" value="<?php echo $hasActiveLicense ? '1' : 0; ?>" />
									<?php
									if (!$hasActiveLicense) {
										?>
										<div class="subscribe" style="margin-left: 5px; margin-top: 65px; margin-bottom: 130px; position: relative;">
											<div class="button-container">

												<a href="https://www.wpallimport.com/checkout/?edd_action=add_to_cart&download_id=515704" target="_blank" id="subscribe-button">
													<div class="button button-primary button-hero wpallimport-large-button button-subscribe"
														 style="background-image: none; width: 140px; text-align: center; position: absolute; z-index: 4;">
														<svg class="success" width="30" height="30" viewBox="0 0 1792 1792"
															 xmlns="http://www.w3.org/2000/svg"
															 style="fill: white; display: none; position: absolute; top: 6px; left: 5px;">
															<path
																d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"
																fill="white"/>
														</svg>
														<svg class="error" width="30" height="30" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"
															 style="fill: red; display: none; position: absolute; top: 6px; left: 5px;">
															<path d="M1490 1322q0 40-28 68l-136 136q-28 28-68 28t-68-28l-294-294-294 294q-28 28-68 28t-68-28l-136-136q-28-28-28-68t28-68l294-294-294-294q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294 294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68l-294 294 294 294q28 28 28 68z"/></svg>
														<div class="easing-spinner" style="position: absolute; left: 23px; display: none;">
															<div class="double-bounce1"></div>
															<div class="double-bounce2"></div>
														</div>

														<span class="subscribe-button-text">
																		<?php _e('Subscribe', PMXI_Plugin::LANGUAGE_DOMAIN); ?>
																	</span>
													</div>
												</a>
											</div>
											<div class="text-container" style="position: absolute; left: 151px; top: 1px;">
												<p><?php _e('Get automatic scheduling for unlimited sites, just $9/mo.'); ?></p>
												<p><?php _e('Have a license?'); ?>
													<a href="javascript:void(0);" id="add-subscription"><?php _e('Register this site.'); ?></a> <?php _e('Questions?', PMXI_Plugin::LANGUAGE_DOMAIN); ?> <a href="javascript:void(0);" class="help_scheduling">Read more.</a></p>
												<input type="password" id="add-subscription-field" style="position: absolute; z-index: 2; font-size:14px;" placeholder="<?php _e('Enter your license', PMXI_Plugin::LANGUAGE_DOMAIN); ?>" />
												<div style="position: absolute;" id="find-subscription-link"><a href="http://www.wpallimport.com/portal/automatic-scheduling/" target="_blank"><?php _e('Find your license.', PMXI_Plugin::LANGUAGE_DOMAIN);?></a></div>
											</div>
										</div>
										<?php
									} ?>
								</div>
								<div style="clear:both"></div>
								<?php include_once('_manual_scheduling.php'); ?>

								<div style="clear: both;"></div>
							</div>

							<div class="wpallimport-overlay"></div>
							<fieldset class="optionsset column rad4 wp-all-import-scheduling-help">

								<div class="title">
									<span style="font-size:1.5em;" class="wpallimport-add-row-title"><?php _e('Automatic Scheduling', PMXI_Plugin::LANGUAGE_DOMAIN); ?></span>
								</div>

								<?php include_once('_scheduling_help.php'); ?>

							</fieldset>
						</td>
					</tr>
				</table>
			</div>
		</div>		
	</div>
</div>