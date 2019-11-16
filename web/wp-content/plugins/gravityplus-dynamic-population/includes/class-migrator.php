<?php
/**
 * @package   GFP_Dynamic_Population_Migrator
 * @copyright 2018-2019 gravity+
 * @license   GPL-2.0+
 * @since     2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * GFP_Dynamic_Population_Migrator Class
 *
 * This class is for migrating the old field settings to the new feed settings
 *
 * @since  2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
class GFP_Dynamic_Population_Migrator {

	/**
	 * Constructor
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function __construct() {

		add_action( 'gform_' . GFP_DYNAMIC_POPULATION_SLUG . '_render_uninstall', array( $this, 'render_uninstall' ) );


		add_action( 'admin_notices', array( $this, 'admin_notices' ) );

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );


		add_action( 'wp_ajax_gfp_dynamic_population_ajax_migrate_field_settings', array(
			$this,
			'migrate_field_settings'
		) );


	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param GFP_Dynamic_Population_Addon $addon_object
	 */
	public function render_uninstall( $addon_object ) {

		$previous_version = get_option( 'gravityformsaddon_' . GFP_DYNAMIC_POPULATION_SLUG . '_previous_version' );

		if ( '1.6.1' < $previous_version ) {

			if ( ! $this->has_migration_completed( 'migrate_field_settings' ) ) {

				$this->set_migration_complete( 'migrate_field_settings' );

			}

			return;
		}

		$migration_completed = $this->has_migration_completed( 'migrate_field_settings' );

		$resume_migration = $this->maybe_resume_migration();


		if ( ( ! $migration_completed ) && $addon_object->can_create_feed() ) {

			$button_url = esc_url( admin_url( 'index.php?page=gfp-dynamic-population-migrator&gfp-dynamic-population-migration=migrate_field_settings' ) );

			$button_label = __( 'Start Migration', 'gravityplus-dynamic-population' );

		} else if ( ! empty( $resume_migration ) ) {

			$button_url = add_query_arg( $resume_migration, admin_url( 'index.php' ) ) . '&page=gfp-dynamic-population-migrator';

			$button_label = __( 'Resume Migration', 'gravityplus-dynamic-population' );


		} else if ( $migration_completed ) {

			$migration_completed_message = __( 'Migration Completed!', 'gravityplus-dynamic-population' );

		}

		include( trailingslashit( GFP_DYNAMIC_POPULATION_PATH ) . 'includes/migrator/view-plugin-settings-migrate-field-settings.php' );

	}

	public function admin_menu() {

		$gfp_dynamic_population_migrations_screen = add_submenu_page( null, __( 'Gravity Forms + Dynamic Population Migrator', 'gravityplus-dynamic-population' ), __( 'Gravity Forms + Dynamic Population Migrator', 'gravityplus-dynamic-population' ), 'update_plugins', 'gfp-dynamic-population-migrator', array(
			$this,
			'gfp_dynamic_population_migrator_screen'
		) );

	}

	public function gfp_dynamic_population_migrator_screen() {

		include( GFP_DYNAMIC_POPULATION_PATH . 'includes/migrator/view-migration-screen.php' );
	}

	public function admin_notices() {

		$previous_version = get_option( 'gravityformsaddon_' . GFP_DYNAMIC_POPULATION_SLUG . '_previous_version' );

		if ( '1.6.1' < $previous_version ) {

			if ( ! $this->has_migration_completed( 'migrate_field_settings' ) ) {

				$this->set_migration_complete( 'migrate_field_settings' );

			}


				return;
		}
		
		if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'gfp-dynamic-population-migrator' ) {
			return;
		}

		$resume_migration = $this->maybe_resume_migration();

		if ( ! empty( $resume_migration ) ) {

			$resume_url = add_query_arg( $resume_migration, admin_url( 'index.php' ) ) . '&page=gfp-dynamic-population-migrator';

			printf(
				'<div class="error"><p>' . __( 'Gravity Forms + Dynamic Population needs to complete your field settings migration that was previously started, click <a href="%s">here</a> to resume.', 'gravityplus-dynamic-population' ) . '</p></div>',
				esc_url( $resume_url )
			);

		} else {

			if ( ! $this->has_migration_completed( 'migrate_field_settings' ) ) {

				printf(
					'<div class="error"><p>' . __( 'Gravity Forms + Dynamic Population needs to migrate your field settings, click <a href="%s">here</a> to start.', 'gravityplus-dynamic-population' ) . '</p></div>',
					esc_url( admin_url( 'index.php?page=gfp-dynamic-population-migrator&gfp-dynamic-population-migration=migrate_field_settings' ) )
				);
			}

		}

	}

	/**
	 * For use when doing 'stepped' migration routines, to see if we need to start somewhere in the middle
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return mixed   When nothing to resume returns false, otherwise starts the migration where it left off
	 */
	public function maybe_resume_migration() {

		$doing_migration = get_option( 'gfp_dynamic_population_doing_field_settings_migration', false );

		if ( empty( $doing_migration ) ) {

			return false;

		}

		return $doing_migration;

	}

	/**
	 * Check if the migration routine has been run for a specific action
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param  string $migration_action The migration action to check completion for
	 *
	 * @return bool                   If the action has been added to the completed actions array
	 */
	public function has_migration_completed( $migration_action = '' ) {

		if ( empty( $migration_action ) ) {

			return false;

		}

		$completed_migrations = $this->get_completed_migrations();

		return in_array( $migration_action, $completed_migrations );

	}

	/**
	 * Adds a migration action to the completed migrations array
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param  string $migration_action The action to add to the completed migrations array
	 *
	 * @return bool                   If the function was successfully added
	 */
	function set_migration_complete( $migration_action = '' ) {

		if ( empty( $migration_action ) ) {

			return false;

		}

		$completed_migrations = $this->get_completed_migrations();

		$completed_migrations[] = $migration_action;

		$completed_migrations = array_unique( array_values( $completed_migrations ) );

		return update_option( 'gfp_dynamic_population_completed_migrations', $completed_migrations );
	}

	/**
	 * Removes a migration action from the completed migrations array
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param  string $migration_action The action to add to the completed migrations array
	 *
	 * @return bool                   If the function was successfully removed
	 */
	function unset_migration_complete( $migration_action = '' ) {

		if ( empty( $migration_action ) ) {

			return false;

		}

		$completed_migrations = $this->get_completed_migrations();

		foreach ( $completed_migrations as $key => $migration ) {

			if ( $migration == $migration_action ) {

				unset( $completed_migrations[ $key ] );

			}
		}


		return update_option( 'gfp_salesforce_completed_migrations', $completed_migrations );
	}

	/**
	 * Gets the array of completed migration actions
	 *
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @return array The array of completed migrations
	 */
	function get_completed_migrations() {

		$completed_migrations = get_option( 'gfp_dynamic_population_completed_migrations' );

		if ( false === $completed_migrations ) {

			$completed_migrations = array();

		}

		return $completed_migrations;

	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 *
	 * @param $function
	 *
	 * @return bool
	 */
	public function is_func_disabled( $function ) {

		$disabled = explode( ',', ini_get( 'disable_functions' ) );

		return in_array( $function, $disabled );
	}

	/**
	 * @since  2.0.0
	 *
	 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
	 */
	public function migrate_field_settings() {

		if ( ! GFCommon::current_user_can_any( 'gravityplus-dynamic-population_plugin_settings' ) ) {

			wp_die( __( 'You do not have permission to migrate Dynamic Population field settings', 'gravityplus-dynamic-population' ), __( 'Error', 'gravityplus-dynamic-population' ), array( 'response' => 403 ) );

		}

		parse_str( $_POST[ 'form' ], $form );

		$_REQUEST = $form = (array) $form;

		check_ajax_referer( 'gfp_dynamic_population_field_settings_migration', 'gfp_dynamic_population_field_settings_migration' );


		$addon_object = GFP_Dynamic_Population_Addon::get_instance();

		$addon_object->log_debug( "START migrating old Dynamic Population field settings" );
		$addon_object->log_debug( "----------------------------------" );

		$doing_migration = get_option( 'gfp_dynamic_population_doing_field_settings_migration', false );

		$current_step = empty( $doing_migration[ 'step' ] ) ? 1 : absint( $doing_migration[ 'step' ] );
		$total_steps  = empty( $doing_migration[ 'total' ] ) ? false : absint( $doing_migration[ 'total' ] );
		$forms_to_migrate       = empty( $doing_migration[ 'forms_to_migrate' ] ) ? array() : $doing_migration[ 'forms_to_migrate' ];
		$forms_already_migrated = empty( $doing_migration[ 'forms_already_migrated' ] ) ? array() : $doing_migration[ 'forms_already_migrated' ];
		$migration_errors       = empty( $doing_migration[ 'migration_errors' ] ) ? array() : $doing_migration[ 'migration_errors' ];


		$addon_object->log_debug( "STEP: {$current_step}" );
		$addon_object->log_debug( "-------------" );

		global $wpdb;

		if ( $current_step < 2 ) {

			$forms = GFAPI::get_forms();

			$forms_to_migrate = array();

			$x = 1;

			foreach ( $forms as $form ) {

				if ( GFP_Dynamic_Population_API::has_dynamic_choice_field( $form ) ) {

					$forms_to_migrate[ $x ] = $form[ 'id' ];

					$x ++;

				}

			}

			$number_of_forms = count( $forms_to_migrate );

			$addon_object->log_debug( "Forms with field settings to be migrated: {$number_of_forms}" );
			$addon_object->log_debug( " " );

		}


		if ( empty( $total_steps ) || $total_steps <= 1 ) {

			$total_steps = $number_of_forms;

		}

		if ( 0 == $current_step ) {

			$doing_migration_args = array(
				'gfp-dynamic-population-migration' => 'migrate_field_settings',
				'step'                             => 1,
				'total'                            => $total_steps,
				'percentage'                       => 0
			);

			update_option( 'gfp_dynamic_population_doing_field_settings_migration', $doing_migration_args );

			echo json_encode( array( 'step' => 1, 'percentage' => 0 ) );

			exit;

		}


		if ( $total_steps >= $current_step ) {

			$form_to_migrate = $forms_to_migrate[ $current_step ];

			if ( ! in_array( $form_to_migrate, $forms_already_migrated ) ) {

				$form = GFAPI::get_form( $form_to_migrate );

				if ( empty( $form ) ) {

					$error = "Error retrieving form from DB: {$wpdb->last_error}";

					$addon_object->log_debug( $error );

					$migration_errors[] = $error;

					unset( $error );

				} else {

					$dynamic_choice_fields = GFP_Dynamic_Population_API::get_dynamic_choice_fields( $form );

					foreach ( $dynamic_choice_fields as $field_id => $dynamic_choice_info ) {

						$feed_to_be_inserted = array(
							'feedName'                                       => $addon_object->get_default_feed_name(),
							'object'                                         => 'field',
							'field_to_populate'                              => $field_id,
							'field_to_populate_type'                         => 'select',
							'source'                                         => $dynamic_choice_info[ 'source' ],
							'sort_order'                                     => empty( $dynamic_choice_info[ 'sort_order' ] ) ? 'ASC' : $dynamic_choice_info[ 'sort_order' ],
							'dynamic_choice_filter_conditional_logic'        => '0',
							'dynamic_choice_filter_conditional_logic_object' => array(
								'conditionalLogic' =>
									array(
										'actionType' => 'show',
										'logicType'  => 'all',
										'rules'      => array()
									)
							),
							'process_on_entry_update'                        => ''
						);

						switch ( $dynamic_choice_info[ 'source' ] ) {

							case 'wpdb':

								$feed_to_be_inserted[ 'source_wpdb_table' ] = $dynamic_choice_info[ 'table' ];

								$feed_to_be_inserted[ 'source_wpdb_table_column' ] = $dynamic_choice_info[ 'column' ];

								$feed_to_be_inserted[ 'source_wpdb_value_table_column' ] = $dynamic_choice_info[ 'column_value' ];


								break;

							case 'posts':

								$feed_to_be_inserted[ 'source_posts_type' ] = $dynamic_choice_info[ 'post_type' ];

								$feed_to_be_inserted[ 'source_posts_taxonomy' ] = $dynamic_choice_info[ 'taxonomy' ];

								$feed_to_be_inserted[ 'source_posts_taxonomy_term' ] = $dynamic_choice_info[ 'taxonomy_term' ];

								$feed_to_be_inserted[ 'source_posts_label' ] = $dynamic_choice_info[ 'label' ];

								$feed_to_be_inserted[ 'source_posts_value' ] = $dynamic_choice_info[ 'value' ];

								break;

							case 'taxonomy':

								$feed_to_be_inserted[ 'source_taxonomy_name' ] = $dynamic_choice_info[ 'name' ];

								$feed_to_be_inserted[ 'source_taxonomy_label' ] = $dynamic_choice_info[ 'label' ];

								$feed_to_be_inserted[ 'source_taxonomy_value' ] = $dynamic_choice_info[ 'value' ];


								break;

							case 'podio':

								$feed_to_be_inserted[ 'source_podio_org' ] = $dynamic_choice_info[ 'org' ];

								$feed_to_be_inserted[ 'source_podio_space' ] = $dynamic_choice_info[ 'space' ];

								$feed_to_be_inserted[ 'source_podio_app' ] = $dynamic_choice_info[ 'app' ];

								$feed_to_be_inserted[ 'source_podio_app_field' ] = $dynamic_choice_info[ 'app_field' ];


								break;

							case 'salesforce':

								$feed_to_be_inserted[ 'source_salesforce_object' ] = $dynamic_choice_info[ 'object' ];

								$feed_to_be_inserted[ 'source_salesforce_type' ] = 'picklist';

								$feed_to_be_inserted[ 'source_salesforce_object_field' ] = $dynamic_choice_info[ 'object_field' ];


								break;
						}


						if ( ! empty( $dynamic_choice_info[ 'filtered_by' ] ) ) {

							$feed_to_be_inserted[ 'dynamic_choice_filter_conditional_logic' ] = '1';

							foreach ( $dynamic_choice_info[ 'filtered_by' ] as $filter_info ) {

								$feed_to_be_inserted[ 'dynamic_choice_filter_conditional_logic_object' ][ 'conditionalLogic' ][ 'rules' ][] = array(
									'fieldId'  => rgar( $filter_info, 'column' ),
									'operator' => rgar( $filter_info, 'operator' ),
									'value'    => rgar( $filter_info, 'field_id' )
								);

							}

						}


						$feed_inserted = $addon_object->insert_feed( $form[ 'id' ], true, $feed_to_be_inserted );

						if ( 0 >= $feed_inserted ) {

							$error = "Error inserting feed for form {$form['id']} field {$field_id}: {$wpdb->last_error}";

							$addon_object->log_error( $error );

							$migration_errors[] = $error;

						} else {

							$addon_object->log_debug( "Successfully inserted feed {$feed_inserted} for inserting feed for form {$form['id']} field {$field_id}" );

							$this->unset_form_data( $form, $field_id );

						}

						unset( $feed_inserted );

					}


					$addon_object->log_debug( "Form: {$form['id']}" );

				}

			}

			$addon_object->log_debug( " " );

			$addon_object->log_debug( "END step {$current_step}" );
			$addon_object->log_debug( "-------------" );

			$percentage = ( $current_step / $total_steps ) * 100;

			if ( $percentage > 100 ) {
				$percentage = 100;
			}

			$next_step = $current_step + 1;


			$doing_migration_args = array(
				'gfp-dynamic-population-migration' => 'migrate_field_settings',
				'step'                             => $next_step,
				'total'                            => $total_steps,
				'percentage'                       => $percentage,
				'forms_to_migrate'                 => $forms_to_migrate,
				'forms_already_migrated'           => $forms_already_migrated,
				'errors'                           => $migration_errors
			);

			update_option( 'gfp_dynamic_population_doing_field_settings_migration', $doing_migration_args );

			if( ob_get_length() ) {

				ob_clean();
			}

			echo json_encode( array( 'step' => $next_step, 'percentage' => $percentage ) );

			exit;

		}

		$addon_object->log_debug( " " );

		$addon_object->log_debug( "No more items left. Finishing up." );

		//if ( empty( $migration_errors ) ) {

		$this->set_migration_complete( 'migrate_field_settings' );

		delete_option( 'gfp_dynamic_population_doing_field_settings_migration' );

		//}

		//delete old table?

		$addon_object->log_debug( "END migrate field settings" );

		if( ob_get_length() ) {

			ob_clean();
		}

		echo json_encode( array(
			'step'   => 'done',
			'url'    => add_query_arg( array(
				'page'    => 'gf_settings',
				'subview' => 'gravityplus-dynamic-population'
			), admin_url( 'admin.php' ) ),
			'errors' => $migration_errors
		) );

		exit;

	}

	private function unset_form_data( $form, $field_id ) {

		foreach ( $form[ 'fields' ] as &$field ) {

			if ( $field->id == $field_id ) {

				unset(
					$field[ 'dynamicChoicesEnable' ],
					$field[ 'dynamicChoicesSortOrder' ],
					$field[ 'dynamicChoice' ],
					$field[ 'dynamicChoicesSourceTable' ],
					$field[ 'dynamicChoicesSourceTableColumn' ],
					$field[ 'dynamicChoicesSourceValueTableColumn' ],
					$field[ 'dynamicChoicesSource' ],
					$field[ 'dynamicChoicesTaxonomyName' ],
					$field[ 'dynamicChoicesTaxonomyObject' ],
					$field[ 'dynamicChoicesTaxonomyLabel' ],
					$field[ 'dynamicChoicesTaxonomyValue' ],
					$field[ 'dynamicChoicesPostsType' ],
					$field[ 'dynamicChoicesPostsTaxonomy' ],
					$field[ 'dynamicChoicesPostsTaxonomyTerm' ],
					$field[ 'dynamicChoicesPostsLabel' ],
					$field[ 'dynamicChoicesPostsValue' ],
					$field[ 'dynamicChoicesSalesforceObject' ],
					$field[ 'dynamicChoicesSalesforceObjectField' ],
					$field[ 'podioDynamicChoicesEnable' ],
					$field[ 'podioDynamicChoicesOrg' ],
					$field[ 'podioDynamicChoicesSpace' ],
					$field[ 'podioDynamicChoicesApp' ],
					$field[ 'podioDynamicChoicesAppField' ],$field[ 'dynamicChoicesPodioOrg' ],$field[ 'dynamicChoicesPodioSpace' ],$field[ 'dynamicChoicesPodioApp' ],$field[ 'dynamicChoicesPodioAppField' ]);

				GFAPI::update_form( $form );

				break;
			}

		}
	}

}