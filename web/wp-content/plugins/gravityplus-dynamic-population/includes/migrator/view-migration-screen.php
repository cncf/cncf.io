<?php
/**
 * Migrator Screen
 * 
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
?>
<style type="text/css">
	.gfp-dynamic-population-migrator-form {
		position: relative;
	}

	.gfp-dynamic-population-migrator-form .gfp-progress {
		background: #ddd;
		position: absolute;
		bottom: -20px;
		height: 15px;
		width: 100%;
	}

	.gfp-dynamic-population-migrator-form .gfp-progress div {
		height: 100%;
		background: #0073aa;
		width: 0;
	}
</style>
<div class="wrap">

	<h2><?php _e( 'Gravity Forms + Dynamic Population Migration', 'gravityplus-dynamic-population' ); ?></h2>

	<div class="postbox gfp-dynamic-population-migrate-field-settings">

		<div class="inside">

			<h3><span><?php _e( 'Migrate Dynamic Population Field Settings to Feeds', 'gravityplus-dynamic-population' ); ?></span>
			</h3>

			<form id="gfp-dynamic-population-field-settings-migrator" class="gfp-dynamic-population-migrator-form" method="post">

				<?php wp_nonce_field( 'gfp_dynamic_population_field_settings_migration', 'gfp_dynamic_population_field_settings_migration' ); ?>

				<input type="hidden" name="gfp-dynamic-population-field-settings-migrator-class" value="GFP_Dynamic_Population_Migrator"/>
									<span>
										<?php
										$doing_migration = get_option( 'gfp_dynamic_population_doing_field_settings_migration', false );

										if ( empty( $doing_migration ) ) {

											$value = __( 'Migrate Field Settings', 'gravityplus-dynamic-population' );

										} else {

											$value = __( 'Resume Field Settings Migration', 'gravityplus-dynamic-population' );

										}
										?>
										<input type="submit" value="<?php echo $value; ?>" class="button-secondary"/>
										<span class="spinner"></span>
									</span>
			</form>

            <div class="gfp-dynamic-population-migrator__errors" style="display: none; box-sizing: border-box; border: 1px solid #DEDEDE; padding-left: 5px; margin-right: 10px; border-radius: 3px; background-color: #EDEDED;">

                <h3 class="gfp-dynamic-population-migrator__errors__title">
					<?php _e( 'Error', 'gravityplus-dynamic-population' ); ?>
                </h3>

                <pre class="gfp-dynamic-population-migrator__errors__text" style="padding-left: 10px;">

                        </pre>
            </div>

		</div>
		
	</div>
	
</div>
<script type="text/javascript">
	jQuery(document).ready(function ($) {

		var GFP_Dynamic_Population_Migrator = {

			migration_message: 'The migration process has started, please be patient. This could take several minutes. You will be prompted to exit the migrator when the migration is finished.',


			init: function () {

				this.submit();

			},

			submit: function () {

				var self = this;

				$('body').on('submit', '.gfp-dynamic-population-migrator-form', function (e) {

					e.preventDefault();

					var data = $(this).serialize();

					$(this).find('input[type="submit"]').attr('disabled', 'disabled');

					$(this).append('<p>' + self.migration_message + '</p><span class="spinner is-active"></span><div class="gfp-progress"><div></div></div>');

					// start the process
					self.process_step(1, data, self);

				});
			},

			process_step: function (step, data, self) {

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						form: data,
						action: 'gfp_dynamic_population_ajax_migrate_field_settings',
						step: step
					},
					dataType: "json",
					success: function (response) {

						if ('done' == response.step) {

							var migration_form = $('.gfp-dynamic-population-migrator-form');

							migration_form.find('.spinner').remove();
							migration_form.find('.gfp-progress').remove();

							if ( response.errors ) {

							    var error_text = '';

                                $.each( response.errors, function ( index, error ) {

                                    error_text = error_text + '[' + index + '] ' + error + '<br />';

                                } );

                                if ( '' !== error_text ) {

                                    var migrator_container = $('.gfp-dynamic-population-migrate-field-settings');

                                    migrator_container.find( '.gfp-dynamic-population-migrator__errors__text' ).html( 'Processing Error :\'(<br />' + error_text );

                                    migrator_container.find( '.gfp-dynamic-population-migrator__errors' ).slideDown();

                                }

                            }

							//window.location = response.url;
                            $( '.gfp-dynamic-population-migrator__errors' ).after( '<p><a href="' + response.url + '">Exit migrator</a></p>' );

						} else {

							$('.gfp-progress div').animate({
								width: response.percentage + '%'
							}, 50, function () {
							// Animation complete.
							});

							self.process_step(parseInt(response.step), data, self);
						}

					}

				}).fail(function (response) {

					if (window.console && window.console.log) {

						console.log(response);

					}

				});

			}

		};

		GFP_Dynamic_Population_Migrator.init();

	});
</script>