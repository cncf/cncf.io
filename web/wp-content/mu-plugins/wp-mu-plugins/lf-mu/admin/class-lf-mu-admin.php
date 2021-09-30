<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.0.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin
 * @author     Chris Abraham <cjyabraham@gmail.com>
 */
class Lf_Mu_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param string $plugin_name       The name of this plugin.
	 * @param string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$options       = get_option( $this->plugin_name );
		$this->site    = ( isset( $options['site'] ) && ! empty( $options['site'] ) ) ? esc_attr( $options['site'] ) : '';
		$this->is_cncf = ( 'cncf' === $this->site ) ? true : false;

		if ( $this->is_cncf ) {
			$this->webinar = 'online program';
		} else {
			$this->webinar = 'webinar';
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_styles( $hook_suffix ) {

			// only loads on LF MU top level page.
		if ( 'toplevel_page_lf-mu' == $hook_suffix ) {

			// color picker.
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lf-mu-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		// only loads on LF MU top level page.
		if ( 'toplevel_page_lf-mu' == $hook_suffix ) {

			// color picker.
			wp_enqueue_script( 'wp-color-picker' );
			// media uploader.
			wp_enqueue_media();
			// custom scripts.
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lf-mu-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	/**
	 * Registers the custom post types
	 */
	public function register_cpts() {
		include_once 'partials/cpts.php';
	}

	/**
	 * Registers the extra sidebar for post types
	 *
	 * See https://melonpan.io/wordpress-plugins/post-meta-controls/ for docs.
	 *
	 * @param array $sidebars    Existing sidebars in Gutenberg.
	 */
	public function create_sidebar( $sidebars ) {
		include 'partials/sidebars.php';
		return $sidebars;
	}

	/**
	 * Registers the taxonomies.
	 */
	public function register_taxonomies() {
		include_once 'partials/taxonomies.php';
	}

	/**
	 * Removes unneeded menu items from the admin.
	 */
	public function remove_menu_items() {
		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.1.0
	 */
	public function add_plugin_admin_menu() {
		add_menu_page( 'Global Options', 'Global Options', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ), null, 4 );
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.1.0
	 */
	public function display_plugin_setup_page() {
		include_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	/**
	 * Validate fields from admin area plugin settings form
	 *
	 * @param  mixed $input as field form settings form.
	 * @return mixed as validated fields.
	 *
	 * @since 1.1.0
	 */
	public function validate( $input ) {

		$options = get_option( $this->plugin_name );

		$options['show_hello_bar'] = ( isset( $input['show_hello_bar'] ) && ! empty( $input['show_hello_bar'] ) ) ? 1 : 0;

		$options['hello_bar_content'] = ( isset( $input['hello_bar_content'] ) && ! empty( $input['hello_bar_content'] ) ) ? $input['hello_bar_content'] : '';

		$options['hello_bar_bg'] = ( isset( $input['hello_bar_bg'] ) && ! empty( $input['hello_bar_bg'] ) ) ? esc_attr( $input['hello_bar_bg'] ) : '';

		$options['hello_bar_text'] = ( isset( $input['hello_bar_text'] ) && ! empty( $input['hello_bar_text'] ) ) ? esc_attr( $input['hello_bar_text'] ) : '';

		$options['header_image_id'] = ( isset( $input['header_image_id'] ) && ! empty( $input['header_image_id'] ) ) ? absint( $input['header_image_id'] ) : '';

		$options['header_cta_text'] = ( isset( $input['header_cta_text'] ) && ! empty( $input['header_cta_text'] ) ) ? esc_html( $input['header_cta_text'] ) : '';

		$options['header_cta_link'] = ( isset( $input['header_cta_link'] ) && ! empty( $input['header_cta_link'] ) ) ? absint( $input['header_cta_link'] ) : '';

		$options['copyright_textarea'] = ( isset( $input['copyright_textarea'] ) && ! empty( $input['copyright_textarea'] ) ) ? $input['copyright_textarea'] : '';

		$options['social_email'] = ( isset( $input['social_email'] ) && ! empty( $input['social_email'] ) ) ? esc_url( $input['social_email'] ) : '';

		$options['social_facebook'] = ( isset( $input['social_facebook'] ) && ! empty( $input['social_facebook'] ) ) ? esc_url( $input['social_facebook'] ) : '';

		$options['social_flickr'] = ( isset( $input['social_flickr'] ) && ! empty( $input['social_flickr'] ) ) ? esc_url( $input['social_flickr'] ) : '';

		$options['social_github'] = ( isset( $input['social_github'] ) && ! empty( $input['social_github'] ) ) ? esc_url( $input['social_github'] ) : '';

		$options['social_instagram'] = ( isset( $input['social_instagram'] ) && ! empty( $input['social_instagram'] ) ) ? esc_url( $input['social_instagram'] ) : '';

		$options['social_linkedin'] = ( isset( $input['social_linkedin'] ) && ! empty( $input['social_linkedin'] ) ) ? esc_url( $input['social_linkedin'] ) : '';

		$options['social_meetup'] = ( isset( $input['social_meetup'] ) && ! empty( $input['social_meetup'] ) ) ? esc_url( $input['social_meetup'] ) : '';

		$options['social_rss'] = ( isset( $input['social_rss'] ) && ! empty( $input['social_rss'] ) ) ? esc_url( $input['social_rss'] ) : '';

		$options['social_slack'] = ( isset( $input['social_slack'] ) && ! empty( $input['social_slack'] ) ) ? esc_url( $input['social_slack'] ) : '';

		$options['social_twitch'] = ( isset( $input['social_twitch'] ) && ! empty( $input['social_twitch'] ) ) ? esc_url( $input['social_twitch'] ) : '';

		$options['social_twitter'] = ( isset( $input['social_twitter'] ) && ! empty( $input['social_twitter'] ) ) ? esc_url( $input['social_twitter'] ) : '';

		$options['social_twitter_handle'] = ( isset( $input['social_twitter_handle'] ) && ! empty( $input['social_twitter_handle'] ) ) ? esc_html( $input['social_twitter_handle'] ) : '';

		$options['social_youtube'] = ( isset( $input['social_youtube'] ) && ! empty( $input['social_youtube'] ) ) ? esc_url( $input['social_youtube'] ) : '';

		$options['social_wechat_id'] = ( isset( $input['social_wechat_id'] ) && ! empty( $input['social_wechat_id'] ) ) ? absint( $input['social_wechat_id'] ) : '';

		$options['generic_thumb_id'] = ( isset( $input['generic_thumb_id'] ) && ! empty( $input['generic_thumb_id'] ) ) ? absint( $input['generic_thumb_id'] ) : '';

		$options['generic_avatar_id'] = ( isset( $input['generic_avatar_id'] ) && ! empty( $input['generic_avatar_id'] ) ) ? absint( $input['generic_avatar_id'] ) : '';

		$options['generic_hero_id'] = ( isset( $input['generic_hero_id'] ) && ! empty( $input['generic_hero_id'] ) ) ? absint( $input['generic_hero_id'] ) : '';

		$options['gtm_id'] = ( isset( $input['gtm_id'] ) && ! empty( $input['gtm_id'] ) ) ? esc_html( $input['gtm_id'] ) : '';

		$options['site'] = ( isset( $input['site'] ) && ! empty( $input['site'] ) ) ? esc_html( $input['site'] ) : '';

		return $options;
	}

	/**
	 * Update options
	 *
	 * @since 1.1.0
	 */
	public function options_update() {
		register_setting(
			$this->plugin_name,
			$this->plugin_name,
			array(
				'sanitize_callback' => array( $this, 'validate' ),
			)
		);
	}

	/**
	 * Sync User of role "Speaker" to the lf_speaker CPT.
	 *
	 * @param int $user_id ID of user.
	 */
	private function sync_speaker( $user_id ) {
		global $post;

		if ( ! $user_id ) {
			return;
		}

		$um_member_directory_data = get_user_meta( $user_id, 'um_member_directory_data', false )[0];
		$um_hide_in_members       = get_user_meta( $user_id, 'hide_in_members', true );
		$photo                    = get_user_meta( $user_id, 'profile_photo', true );
		$first_name               = get_user_meta( $user_id, 'first_name', true );
		$last_name                = get_user_meta( $user_id, 'last_name', true );
		$hidden                   = ( is_array( $um_hide_in_members ) && in_array( 'Yes', $um_hide_in_members ) ) ? true : false;

		if ( 'approved' !== $um_member_directory_data['account_status'] || ! $photo || $hidden ) {
			// speaker must be approved, have a photo, and not have hidden their profile.
			$eligible_for_search = false;
		} else {
			$eligible_for_search = true;
		}

		$query = new WP_Query(
			array(
				'name'      => $user_id,
				'post_type' => 'lf_speaker',
			)
		);

		if ( $query->have_posts() ) {
			$query->the_post();
			$speaker_id = $post->ID;
			if ( ! $eligible_for_search ) {
				wp_delete_post( $speaker_id, true );
				return;
			}
		} else {
			if ( ! $eligible_for_search ) {
				return;
			}
			$speaker_id = wp_insert_post(
				array(
					'post_title'  => $last_name . $first_name,
					'post_name'   => $user_id,
					'post_type'   => 'lf_speaker',
					'post_status' => 'publish',
				)
			);
		}

		$affiliations = get_user_meta( $user_id, 'sb_certifications', false )[0];
		$expertise    = get_user_meta( $user_id, 'expertise', false )[0];
		$languages    = get_user_meta( $user_id, 'languages', false )[0];
		$projects     = get_user_meta( $user_id, 'project', false )[0];
		$country      = get_user_meta( $user_id, 'country', false )[0];

		$country = str_replace( 'Korea, Republic of', 'South Korea', $country );
		$country = str_replace( "Korea, Democratic People's Republic of", 'North Korea', $country );
		$country = str_replace( 'Bolivia, Plurinational State of', 'Bolivia', $country );
		$country = str_replace( 'Congo', 'Congo, Republic of the', $country );
		$country = str_replace( 'Iran, Islamic Republic of', 'Iran', $country );
		$country = str_replace( 'Palestine', 'Palestinian Territory, Occupied', $country );
		$country = str_replace( 'Pitcairn', 'Pitcairn Islands', $country );
		$country = str_replace( 'Saint Martin (French part)', 'Saint Martin', $country );
		$country = str_replace( 'Taiwan, Province of China', 'Taiwan', $country );
		$country = str_replace( 'Virgin Islands, U.S.', 'United States Virgin Islands', $country );
		$country = str_replace( 'Virgin Islands, British', 'British Virgin Islands', $country );
		$country = str_replace( 'Venezuela, Bolivarian Republic of', 'Venezuela', $country );
		$country = str_replace( 'Viet Nam', 'Vietnam', $country );

		wp_set_object_terms( $speaker_id, $affiliations, 'lf-speaker-affiliation' );
		wp_set_object_terms( $speaker_id, $expertise, 'lf-speaker-expertise' );
		wp_set_object_terms( $speaker_id, $languages, 'lf-language' );
		wp_set_object_terms( $speaker_id, $projects, 'lf-project' );
		wp_set_object_terms( $speaker_id, $country, 'lf-country' );

		wp_reset_postdata();
	}

	/**
	 * Syncs all the lf_speaker data with the Users of role "Speaker" metadata.
	 * This function is triggered when you update the "Speakers" page.
	 *
	 * @param int    $post_id ID of post that is trashed.
	 * @param object $post_after Post object following the update.
	 * @param object $post_before Post object before the update.
	 */
	public function sync_speakers( $post_id, $post_after = null, $post_before = null ) {
		$post = get_post( $post_id );
		if ( 'page' !== $post->post_type || 'speakers' !== $post->post_name ) {
			return;
		}

		$allposts = get_posts(
			array(
				'post_type'   => 'lf_speaker',
				'numberposts' => -1,
			),
		);
		foreach ( $allposts as $eachpost ) {
			wp_delete_post( $eachpost->ID, true );
		}

		$args          = array( 'role' => 'um_speaker' );
		$wp_user_query = new WP_User_Query( $args );
		$users         = $wp_user_query->get_results();
		foreach ( $users as $user ) {
			$this->sync_speaker( $user->ID );
		}
	}

	/**
	 * Function is triggered by any action that updates a lf_speaker
	 *
	 * @param int   $user_id User ID.
	 * @param array $args Args.
	 * @param array $userinfo User Info.
	 */
	public function speaker_updated( $user_id, $args = null, $userinfo = null ) {
		$user       = get_userdata( $user_id );
		$user_roles = $user->roles;

		if ( in_array( 'um_speaker', $user_roles, true ) ) {
			$this->sync_speaker( $user_id );
		}
	}

	/**
	 * Function is triggered by a delete user action
	 *
	 * @param int $user_id User ID.
	 */
	public function speaker_deleted( $user_id ) {
		global $post;
		$query = new WP_Query(
			array(
				'name'      => $user_id,
				'post_type' => 'lf_speaker',
			)
		);

		if ( $query->have_posts() ) {
			$query->the_post();
			wp_delete_post( $post->ID, true );
		}
	}

	/**
	 * Change navigation bar colour for version in debug/local
	 */
	public function change_adminbar_colors() {
		if ( WP_DEBUG !== true ) {
			return;
		}

		$change_adminbar_colors = '<style type="text/css">
			#wpadminbar { background-color:#12881D; }
		</style>';
		echo $change_adminbar_colors; // phpcs:ignore
	}

	/**
	 * Set meta data of year for case studies to faciliate filtering
	 *
	 * @param int    $post_id Post ID.
	 * @param object $post Post object.
	 * @param bool   $update Whether this is an existing post being updated.
	 */
	public function set_case_study_year( $post_id, $post, $update ) {
		$year = get_post_time( 'Y', false, $post );
		update_post_meta( $post_id, 'lf_case_study_published_year', $year );
	}

	/**
	 * Sync programs between https://community.cncf.io/ and https://www.cncf.io/online-programs/.
	 * I had to do this to get it to run locally: https://github.com/lando/lando/issues/866#issuecomment-395219617
	 */
	public function sync_programs() {
		$chapters = array(
			'https://community.cncf.io/api/chapter/258/event/', // https://community.cncf.io/cncf-online-programs/ .
			'https://community.cncf.io/api/chapter/296/event/', // https://community.cncf.io/end-user-community/ .
		);

		foreach ( $chapters as $chapter ) {
			$data = wp_remote_get( $chapter );
			if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
				return;
			}

			$remote_body = json_decode( wp_remote_retrieve_body( $data ) );
			foreach ( $remote_body->results as $program ) {
				if ( 'Published' === $program->status ) {
					// add/update CPT.

					$dt_end = strtotime( $program->end_date );
					$last_manual_id = 3566;

					if ( $last_manual_id >= (int) $program->id || $dt_end < time() - ( 14 * DAY_IN_SECONDS ) ) {
						// avoid updating programs that ended more than 2 weeks ago to limit computation and
						// don't mess with existing online programs that were entered manually.
						continue;
					}

					$post_content = '';
					$lf_webinar_recording_url = '';
					$lf_webinar_slides_url = '';

					if ( $dt_end < time() + DAY_IN_SECONDS ) {
						// grab program details for recorded view.
						$details_data = wp_remote_get( 'https://community.cncf.io/api/event/' . $program->id );
						if ( is_wp_error( $details_data ) || ( wp_remote_retrieve_response_code( $details_data ) != 200 ) ) {
							continue;
						}

						$details = json_decode( wp_remote_retrieve_body( $details_data ) );
						$post_content = strip_tags( $details->description );
						$lf_webinar_recording_url = $details->video_url;

						if ( $details->slideshare_url ) {
							preg_match( '/id=(\d*)&/', $details->slideshare_url, $matches );
							if ( array_key_exists( 1, $matches ) ) {
								$lf_webinar_slides_url = 'https://www.slideshare.net/slideshow/embed_code/' . $matches[1];
							}
						}
					}

					$params = array(
						'post_title' => $program->title,
						'post_type' => 'lf_webinar',
						'post_status' => 'publish',
						'post_content' => $post_content,
						'meta_input' => array(
							'lf_webinar_date' => substr( $program->start_date, 0, 10 ),
							'lf_webinar_registration_url' => $program->url,
							'lf_webinar_recording_url' => $lf_webinar_recording_url,
							'lf_webinar_slides_url' => $lf_webinar_slides_url,
							'lf_webinar_timezone' => 'america-los_angeles',
						),
					);

					$query = new WP_Query(
						array(
							'post_type' => 'lf_webinar',
							'meta_value' => $program->url,
							'no_found_rows' => true,
							'update_post_meta_cache' => false,
							'update_post_term_cache' => false,
							'fields' => 'ids',
							'posts_per_page' => 1,
						)
					);
					if ( $query->have_posts() ) {
						$query->the_post();
						$params['ID'] = get_the_ID(); // post to update.
					}

					$newid = wp_insert_post( $params ); // will insert or update the post as needed.

					if ( $newid && 'https://community.cncf.io/api/chapter/296/event/' === $chapter ) {
						wp_set_object_terms( $newid, 'end-user', 'lf-topic', true );
					}
				} else {
					// todo later: turn any matching CPTs to draft since they may have been cancelled/unpublished.
					continue;
				}
			}
		}
	}

	/**
	 * Sync projects data from landscape.
	 */
	public function sync_projects() {
		$projects_url = 'https://landscape.' . $this->site . '.io/api/items?project=hosted';
		$items_url    = 'https://landscape.' . $this->site . '.io/data/items.json';
		$logos_url    = 'https://landscape.' . $this->site . '.io/';

		$args = array(
			'timeout'   => 100,
			'sslverify' => false,
		);

		$data = wp_remote_get( $projects_url, $args );
		if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
			return;
		}
		$projects = json_decode( wp_remote_retrieve_body( $data ) );

		$data = wp_remote_get( $items_url, $args );
		if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
			return;
		}
		$items = json_decode( wp_remote_retrieve_body( $data ) );
		$id_column = array_column( $items, 'id' );

		foreach ( $projects as $level ) {
			foreach ( $level->items as $project ) {
				$key = array_search( $project->id, $id_column );
				if ( false === $key ) {
					continue;
				}

				$p = $items[ $key ];

				$params = array(
					'post_type' => 'lf_project',
					'post_title' => $p->name,
					'post_status' => 'publish',
					'meta_input' => array(
						'lf_project_external_url' => $p->homepage_url,
						'lf_project_twitter' => $p->twitter,
						'lf_project_logo' => $logos_url . $p->href,
						'lf_project_category' => explode( ' / ', $p->path )[1],
					),
				);

				if ( property_exists( $p, 'repo_url' ) ) {
					$params['meta_input']['lf_project_github'] = $p->repo_url;
				}

				if ( property_exists( $p, 'description' ) ) {
					$params['meta_input']['lf_project_description'] = $p->description;
				}

				if ( property_exists( $p, 'extra' ) ) {
					if ( property_exists( $p->extra, 'dev_stats_url' ) ) {
						$params['meta_input']['lf_project_devstats'] = $p->extra->dev_stats_url;
					}
					if ( property_exists( $p->extra, 'artwork_url' ) ) {
						$params['meta_input']['lf_project_logos'] = $p->extra->artwork_url;
					}
					if ( property_exists( $p->extra, 'stack_overflow_url' ) ) {
						$params['meta_input']['lf_project_stack_overflow'] = $p->extra->stack_overflow_url;
					}
					if ( property_exists( $p->extra, 'accepted' ) ) {
						$params['meta_input']['lf_project_date_accepted'] = $p->extra->accepted;
					}
					if ( property_exists( $p->extra, 'blog_url' ) ) {
						$params['meta_input']['lf_project_blog'] = $p->extra->blog_url;
					}
					if ( property_exists( $p->extra, 'mailing_list_url' ) ) {
						$params['meta_input']['lf_project_mail'] = $p->extra->mailing_list_url;
					}
					if ( property_exists( $p->extra, 'slack_url' ) ) {
						$params['meta_input']['lf_project_slack'] = $p->extra->slack_url;
					}
					if ( property_exists( $p->extra, 'youtube_url' ) ) {
						$params['meta_input']['lf_project_youtube'] = $p->extra->youtube_url;
					}
					if ( property_exists( $p->extra, 'gitter_url' ) ) {
						$params['meta_input']['lf_project_gitter'] = $p->extra->gitter_url;
					}
				}

				$pp = get_page_by_title( $p->name, OBJECT, 'lf_project' );
				if ( $pp ) {
					$params['ID'] = $pp->ID;
				}

				// adds term to taxonomy if it doesn't exist.
				if ( ! term_exists( $p->name, 'lf-project' ) ) {
					wp_insert_term( $p->name, 'lf-project' );
				}

				$newid = wp_insert_post( $params ); // will insert or update the post as needed.

				if ( $newid ) {
					if ( $this->is_cncf ) {
						wp_set_object_terms( $newid, $level->key, 'lf-project-stage', false );
					} else {
						wp_set_object_terms( $newid, $p->category, 'lf-project-stage', false );
					}
				}
			}
		}

	}

	/**
	 * Sync people data from https://github.com/cncf/people
	 */
	public function sync_people() {
		$people_url = 'https://raw.githubusercontent.com/cncf/people/main/people.json';
		$github_images_url = 'https://raw.githubusercontent.com/cncf/people/main/images/';

		$args = array(
			'timeout'   => 100,
			'sslverify' => false,
		);

		$data = wp_remote_get( $people_url, $args );
		if ( is_wp_error( $data ) || ( wp_remote_retrieve_response_code( $data ) != 200 ) ) {
			return;
		}
		$people = json_decode( wp_remote_retrieve_body( $data ) );

		if ( ! $people ) {
			return;
		}

		$synced_ids = array();

		foreach ( $people as $p ) {

			$params = array(
				'post_type'    => 'lf_person',
				'post_title'   => $p->name,
				'post_content' => $p->bio,
				'post_status'  => 'publish',
				'meta_input'   => array(),
			);

			if ( property_exists( $p, 'excerpt' ) ) {
				$params['post_excerpt'] = $p->excerpt;
			}
			if ( property_exists( $p, 'company' ) ) {
				$params['meta_input']['lf_person_company'] = $p->company;
			}
			if ( property_exists( $p, 'pronouns' ) ) {
				$params['meta_input']['lf_person_pronouns'] = $p->pronouns;
			}
			if ( property_exists( $p, 'location' ) ) {
				$params['meta_input']['lf_person_location'] = $p->location;
			}
			if ( property_exists( $p, 'linkedin' ) ) {
				$params['meta_input']['lf_person_linkedin'] = $p->linkedin;
			}
			if ( property_exists( $p, 'twitter' ) ) {
				$params['meta_input']['lf_person_twitter'] = $p->twitter;
			}
			if ( property_exists( $p, 'github' ) ) {
				$params['meta_input']['lf_person_github'] = $p->github;
			}
			if ( property_exists( $p, 'wechat' ) ) {
				$params['meta_input']['lf_person_wechat'] = $p->wechat;
			}
			if ( property_exists( $p, 'youtube' ) ) {
				$params['meta_input']['lf_person_youtube'] = $p->youtube;
			}
			if ( property_exists( $p, 'priority' ) ) {
				$params['meta_input']['lf_person_is_priority'] = $p->priority;
			}
			if ( property_exists( $p, 'image' ) ) {
				if ( strpos( $p->image, 'http' ) !== false ) {
					$image_url = $p->image;
				} else {
					$image_url = $github_images_url . $p->image;
				}
				$params['meta_input']['lf_person_image'] = $image_url;
			}
			if ( property_exists( $p, 'website' ) ) {
				$params['meta_input']['lf_person_website'] = $p->website;
			}

			$pp = get_page_by_title( $p->name, OBJECT, 'lf_person' );
			if ( $pp ) {
				$params['ID'] = $pp->ID;
			}

			$newid = wp_insert_post( $params ); // will insert or update the post as needed.

			if ( $newid ) {
				if ( property_exists( $p, 'language' ) ) {
					wp_set_object_terms( $newid, $p->language, 'lf-language', false );
				}
				if ( property_exists( $p, 'projects' ) ) {
					wp_set_object_terms( $newid, $p->projects, 'lf-project', false );
				}
				if ( property_exists( $p, 'category' ) ) {
					wp_set_object_terms( $newid, $p->category, 'lf-person-category', false );
				}

				$synced_ids[] = $newid;
			}
		}

		// delete any People posts which aren't in $synced_ids.
		$query = new WP_Query(
			array(
				'post_type' => 'lf_person',
				'post__not_in' => $synced_ids,
			)
		);
		while ( $query->have_posts() ) {
			$query->the_post();
			wp_delete_post( get_the_id() );
		}
	}

	/**
	 * Dump people from to json format.
	 */
	public function dump_people() {
		$people = array();

		$args = array(
			'post_type'      => 'lf_person',
			'post_status'    => 'publish',
			'posts_per_page' => 999,
			'tax_query'      => array(
				array(
					'taxonomy' => 'lf-person-category',
					'field'    => 'slug',
					'terms'    => array( 'ambassadors', 'governing-board', 'staff', 'technical-oversight-committee', 'toc-contributors' ),
				),
			),
		);

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();

				$people[] = array(
					'name' => get_the_title(),
					'bio' => str_replace( array( "<!-- wp:paragraph -->\n", "\n<!-- /wp:paragraph -->", "\r" ), '', get_the_content() ),
					'excerpt' => get_the_excerpt(),
					'company' => get_post_meta( get_the_ID(), 'lf_person_company', true ),
					'pronouns' => get_post_meta( get_the_ID(), 'lf_person_pronouns', true ),
					'linkedin' => get_post_meta( get_the_ID(), 'lf_person_linkedin', true ),
					'twitter' => get_post_meta( get_the_ID(), 'lf_person_twitter', true ),
					'github' => get_post_meta( get_the_ID(), 'lf_person_github', true ),
					'wechat' => get_post_meta( get_the_ID(), 'lf_person_wechat', true ),
					'website' => get_post_meta( get_the_ID(), 'lf_person_website', true ),
					'youtube' => get_post_meta( get_the_ID(), 'lf_person_youtube', true ),
					'priority' => get_post_meta( get_the_ID(), 'lf_person_is_priority', true ),
					'category' => wp_get_post_terms( get_the_ID(), 'lf-person-category', array( 'fields' => 'names' ) ),
					'image' => str_replace( 'cncfci.lndo.site', 'www.cncf.io', get_the_post_thumbnail_url( get_the_ID() ) ),
				);
			}
		}
		$name = array_column( $people, 'name' );

		array_multisort( $name, SORT_STRING, $people );

		var_dump( json_encode( $people, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ) );

		die();
	}
}
