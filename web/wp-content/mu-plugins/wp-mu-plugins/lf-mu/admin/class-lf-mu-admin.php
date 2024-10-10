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
		$this->webinar = 'online program';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_styles( $hook_suffix ) {

		// only loads on LF MU top level page.
		if ( 'toplevel_page_lf-mu' === $hook_suffix ) {

			// color picker.
			wp_enqueue_style( 'wp-color-picker' );
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lf-mu-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param string $hook_suffix part of WP.
	 */
	public function enqueue_scripts( $hook_suffix ) {

		// only loads on LF MU top level page.
		if ( 'toplevel_page_lf-mu' === $hook_suffix ) {

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
		add_menu_page( 'Site Options', 'Site Options', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_setup_page' ), null, 4 );
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

		$this->tag_blog_posts_with_projects();

		$options = get_option( $this->plugin_name );

		$options['show_hello_bar'] = ( isset( $input['show_hello_bar'] ) && ! empty( $input['show_hello_bar'] ) ) ? 1 : 0;

		$options['hello_bar_content'] = ( isset( $input['hello_bar_content'] ) && ! empty( $input['hello_bar_content'] ) ) ? $input['hello_bar_content'] : '';

		$options['hello_bar_bg'] = ( isset( $input['hello_bar_bg'] ) && ! empty( $input['hello_bar_bg'] ) ) ? esc_attr( $input['hello_bar_bg'] ) : '';

		$options['hello_bar_text'] = ( isset( $input['hello_bar_text'] ) && ! empty( $input['hello_bar_text'] ) ) ? esc_attr( $input['hello_bar_text'] ) : '';

		$options['header_image_id'] = ( isset( $input['header_image_id'] ) && ! empty( $input['header_image_id'] ) ) ? absint( $input['header_image_id'] ) : '';

		$options['header_cta_text'] = ( isset( $input['header_cta_text'] ) && ! empty( $input['header_cta_text'] ) ) ? esc_html( $input['header_cta_text'] ) : '';

		$options['header_cta_link'] = ( isset( $input['header_cta_link'] ) && ! empty( $input['header_cta_link'] ) ) ? absint( $input['header_cta_link'] ) : '';

		$options['footer_image_id'] = ( isset( $input['footer_image_id'] ) && ! empty( $input['footer_image_id'] ) ) ? absint( $input['footer_image_id'] ) : '';

		$options['footer_cta_text'] = ( isset( $input['footer_cta_text'] ) && ! empty( $input['footer_cta_text'] ) ) ? esc_html( $input['footer_cta_text'] ) : '';

		$options['footer_cta_link'] = ( isset( $input['footer_cta_link'] ) && ! empty( $input['footer_cta_link'] ) ) ? absint( $input['footer_cta_link'] ) : '';

		$options['accessibility_cta_text'] = ( isset( $input['accessibility_cta_text'] ) && ! empty( $input['accessibility_cta_text'] ) ) ? esc_html( $input['accessibility_cta_text'] ) : '';

		$options['accessibility_cta_link'] = ( isset( $input['accessibility_cta_link'] ) && ! empty( $input['accessibility_cta_link'] ) ) ? absint( $input['accessibility_cta_link'] ) : '';

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

		$options['social_wechat'] = ( isset( $input['social_wechat'] ) && ! empty( $input['social_wechat'] ) ) ? esc_url( $input['social_wechat'] ) : '';

		$options['generic_thumb_id'] = ( isset( $input['generic_thumb_id'] ) && ! empty( $input['generic_thumb_id'] ) ) ? absint( $input['generic_thumb_id'] ) : '';

		$options['generic_avatar_id'] = ( isset( $input['generic_avatar_id'] ) && ! empty( $input['generic_avatar_id'] ) ) ? absint( $input['generic_avatar_id'] ) : '';

		$options['generic_hero_id'] = ( isset( $input['generic_hero_id'] ) && ! empty( $input['generic_hero_id'] ) ) ? absint( $input['generic_hero_id'] ) : '';

		$options['youtube_api_key'] = ( isset( $input['youtube_api_key'] ) && ! empty( $input['youtube_api_key'] ) ) ? esc_attr( $input['youtube_api_key'] ) : '';

		$options['google_maps_api_key'] = ( isset( $input['google_maps_api_key'] ) && ! empty( $input['google_maps_api_key'] ) ) ? esc_attr( $input['google_maps_api_key'] ) : '';

		$options['google_maps_api_public_key'] = ( isset( $input['google_maps_api_public_key'] ) && ! empty( $input['google_maps_api_public_key'] ) ) ? esc_attr( $input['google_maps_api_public_key'] ) : '';

		$options['community_api_key'] = ( isset( $input['community_api_key'] ) && ! empty( $input['community_api_key'] ) ) ? esc_attr( $input['community_api_key'] ) : '';

		$options['shopify_api_key'] = ( isset( $input['shopify_api_key'] ) && ! empty( $input['shopify_api_key'] ) ) ? esc_attr( $input['shopify_api_key'] ) : '';

		$options['gtm_id'] = ( isset( $input['gtm_id'] ) && ! empty( $input['gtm_id'] ) ) ? esc_html( $input['gtm_id'] ) : '';

		$options['promotion_image_id'] = ( isset( $input['promotion_image_id'] ) && ! empty( $input['promotion_image_id'] ) ) ? absint( $input['promotion_image_id'] ) : '';

		$options['promotion_title_text'] = ( isset( $input['promotion_title_text'] ) && ! empty( $input['promotion_title_text'] ) ) ? esc_html( $input['promotion_title_text'] ) : '';

		$options['promotion_body_text'] = ( isset( $input['promotion_body_text'] ) && ! empty( $input['promotion_body_text'] ) ) ? esc_html( $input['promotion_body_text'] ) : '';

		$options['promotion_cta_text'] = ( isset( $input['promotion_cta_text'] ) && ! empty( $input['promotion_cta_text'] ) ) ? esc_html( $input['promotion_cta_text'] ) : '';

		$options['promotion_cta_link'] = ( isset( $input['promotion_cta_link'] ) && ! empty( $input['promotion_cta_link'] ) ) ? esc_url( $input['promotion_cta_link'] ) : '';

		$options['promotion_image_id2'] = ( isset( $input['promotion_image_id2'] ) && ! empty( $input['promotion_image_id2'] ) ) ? absint( $input['promotion_image_id2'] ) : '';

		$options['promotion_title_text2'] = ( isset( $input['promotion_title_text2'] ) && ! empty( $input['promotion_title_text2'] ) ) ? esc_html( $input['promotion_title_text2'] ) : '';

		$options['promotion_body_text2'] = ( isset( $input['promotion_body_text2'] ) && ! empty( $input['promotion_body_text2'] ) ) ? esc_html( $input['promotion_body_text2'] ) : '';

		$options['promotion_cta_text2'] = ( isset( $input['promotion_cta_text2'] ) && ! empty( $input['promotion_cta_text2'] ) ) ? esc_html( $input['promotion_cta_text2'] ) : '';

		$options['promotion_cta_link2'] = ( isset( $input['promotion_cta_link2'] ) && ! empty( $input['promotion_cta_link2'] ) ) ? esc_url( $input['promotion_cta_link2'] ) : '';

		return $options;
	}

	/**
	 * Get all projects found more than once in the content.
	 *
	 * @param string $content The content of the post.
	 * @param array  $projects The projects to search for.
	 */
	private function get_project_tags( $content, $projects ) {
		$project_tags = array();
		foreach ( $projects as $project ) {
			if ( substr_count( $content, $project->name ) > 1 ) {
				$project_tags[] = $project->name;
			}
		}
		return $project_tags;
	}

	/**
	 * Tag blog posts with projects.
	 * This is a temporary function used once to tag all blog posts by projects that appear in its copy.
	 */
	private function tag_blog_posts_with_projects() {
		$myposts = get_posts(
			array(
				'post_type'      => 'post',
				'posts_per_page' => -1,
				'category'       => 230,
			)
		);
		$projects = get_terms( 'lf-project' );

		foreach ( $myposts as $post ) {
			if ( get_the_terms( $post->ID, 'lf-project' ) ) {
				continue;
			}

			// only add projects if there are none already assigned.
			$project_tags = $this->get_project_tags( $post->post_content, $projects );
			if ( ! empty( $projects ) ) {
				wp_set_post_terms( $post->ID, $project_tags, 'lf-project' );
			}
		}
		wp_reset_postdata();
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
	 * Change navigation bar colour for version in debug/local
	 */
	public function change_adminbar_colors() {
		if ( WP_DEBUG !== true ) {
			return;
		}

		$change_adminbar_colors = '<style>
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
	 * Sync programs from https://community.cncf.io/
	 */
	public function sync_programs() {
		include_once 'partials/sync-programs.php';
	}

	/**
	 * Sync projects data from landscape.
	 */
	public function sync_projects() {
		include_once 'partials/sync-projects.php';
	}

	/**
	 * Sync people data from https://github.com/cncf/people
	 */
	public function sync_people() {
		include_once 'partials/sync-people.php';
	}

	/**
	 * Sync KTP data from landscape.
	 */
	public function sync_ktps() {
		include_once 'partials/sync-ktps.php';
	}

	/**
	 * Sync KCDs from https://community.cncf.io/ to the events CPT.
	 */
	public function sync_kcds() {
		include_once 'partials/sync-kcds.php';
	}

	/**
	 * Get updated view count from YouTube for recorded online programs.
	 */
	public function get_program_views() {
		$options         = get_option( 'lf-mu' );
		$youtube_api_key = $options['youtube_api_key'] ?? '';

		if ( ! $youtube_api_key ) {
			return;
		}

		$query = new WP_Query(
			array(
				'post_type'      => 'lf_webinar',
				'post_status'    => 'publish',
				'posts_per_page' => 9999,
			)
		);

		while ( $query->have_posts() ) {
			$query->the_post();
			$recording_url = get_post_meta( get_the_ID(), 'lf_webinar_recording_url', true );
			if ( ! $recording_url ) {
				continue;
			}

			preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $recording_url, $match );
			if ( isset( $match[1] ) ) {
				$vid_id = $match[1];

				$request = wp_remote_get( 'https://www.googleapis.com/youtube/v3/videos?part=statistics&id=' . $vid_id . '&key=' . $youtube_api_key );
				if ( is_wp_error( $request ) || ( wp_remote_retrieve_response_code( $request ) !== 200 ) ) {
					continue;
				}
				$vid_stats = wp_remote_retrieve_body( $request );
				$vid_stats = json_decode( $vid_stats );
				if ( ! property_exists( $vid_stats, 'items' ) || ! isset( $vid_stats->items[0] ) ) {
					continue;
				}

				$views = $vid_stats->items[0]->statistics->viewCount;
				update_post_meta( get_the_ID(), 'lf_webinar_recording_views', $views );
			}
		}
	}

	/**
	 * Set meta data of year for reports to faciliate filtering
	 *
	 * @param int    $post_id Post ID.
	 * @param object $post Post object.
	 * @param bool   $update Whether this is an existing post being updated.
	 */
	public function set_report_year( $post_id, $post, $update ) {
		$year = get_post_time( 'Y', false, $post );
		update_post_meta( $post_id, 'lf_report_published_year', $year );
	}

	/**
	 * Add theme usage box into WordPress Dashboard
	 */
	public function add_dashboard_widget_info() {
		wp_add_dashboard_widget( 'dashboard_widget_1', 'Website Details', array( &$this, 'website_details' ) );
	}

	/**
	 * Add content to new dashboard widget
	 */
	public function website_details() {
		echo "<ul>
	<li><a href='https://docs.google.com/document/d/1TmjvB4MAFEFtYKLhMPuWl_J1guaXdHZh5d2BTQhe4wE/edit#heading=h.udn1pgm82b6' target='_blank'>CNCF.io editor instructions</a></li>
<li><strong>Developed By:</strong> <a href='mailto:cjyabraham@gmail.com'>Chris Abraham</a>, <a href='mailto:jim@thetwopercent.co.uk'>James Hunt</a></li>
<li><strong>Development Repo:</strong> <a href='https://github.com/cncf/cncf.io' target='_blank'>Github</a>
</li>
<li><strong>Edit Projects or KTPs:</strong> <a href='https://github.com/cncf/landscape#corrections' target='_blank'>Edit Landscape</a></li>
<li><strong>Edit People:</strong> <a href='https://github.com/cncf/people' target='_blank'>Edit People repository</a></li>
</ul>";
	}

	/**
	 * Add custom post types to Dashboard
	 *
	 * @param int $items Number.
	 */
	public function custom_glance_items( $items = array() ) {
		$post_types = array( 'lf_webinar', 'lf_event', 'lf_case_study', 'lf_case_study_cn', 'lf_kubeweekly', 'lf_eu_newsletter', 'lf_report' );

		foreach ( $post_types as $type ) {

			if ( ! post_type_exists( $type ) ) {
				continue;
			}

			$num_posts = wp_count_posts( $type );

			if ( $num_posts ) {

				$published = intval( $num_posts->publish );
				$post_type = get_post_type_object( $type );
				/* translators: %2$s is replaced with the number of translations */
				$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'cncf-theme' ); // phpcs:ignore
				$text = sprintf( $text, number_format_i18n( $published ) );

				if ( current_user_can( $post_type->cap->edit_posts ) ) {
					$items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_type=%1$s">%2$s</a>', $type, $text ) . "\n";
				} else {
					$items[] = sprintf( '<span class="%1$s-count">%2$s</span>', $type, $text ) . "\n";
				}
			}
		}
		return $items;
	}

	/**
	 * Removes dashboard widgets.
	 */
	public function remove_dashboard_widgets() {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'wp_mail_smtp_reports_widget_lite', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	}

	/**
	 * Add custom column headers to Webinars
	 *
	 * @param array $columns Admin columns.
	 */
	public function set_custom_edit_lf_webinar_columns( $columns ) {
		$date = $columns['date'];
		unset( $columns['date'] );

		$columns['lf_webinar_date']             = 'Webinar Date';
		$columns['lf_webinar_registration_url'] = 'Reg URL';
		$columns['lf_webinar_recording_url']    = 'Rec URL';

		$columns['date'] = $date;

		return $columns;
	}

	/**
	 * Add custom column data to Webinars
	 *
	 * @param array $column Admin columns.
	 * @param int   $post_id Post ID.
	 */
	public function custom_lf_webinar_column( $column, $post_id ) {
		switch ( $column ) {

			// gets the date of webinar.
			case 'lf_webinar_date':
				echo esc_html( gmdate( 'F j, Y', strtotime( get_post_meta( $post_id, 'lf_webinar_date', true ) ) ) );
				break;

			// displays if registration URL has been added and it is a URL.
			case 'lf_webinar_registration_url':
				echo filter_var( get_post_meta( $post_id, 'lf_webinar_registration_url', true ), FILTER_VALIDATE_URL ) ? 'Yes' : 'No';
				break;

			// displays if recording URL has been added.
			case 'lf_webinar_recording_url':
				echo filter_var( get_post_meta( $post_id, 'lf_webinar_recording_url', true ), FILTER_VALIDATE_URL ) ? 'Yes' : 'No';
				break;
		}
	}

	/**
	 * Add custom column headers to Events
	 *
	 * @param array $columns Admin columns.
	 */
	public function set_custom_edit_lf_event_columns( $columns ) {
		$date = $columns['date'];
		unset( $columns['date'] );

		$columns['lf_event_date_start']     = 'Start Date';
		$columns['lf_event_logo']           = 'Logo';
		$columns['lf_event_background']     = 'Background';
		$columns['lf_event_mobile_banner']  = 'Mobile';
		$columns['lf_event_desktop_banner'] = 'Desktop';
		$columns['date']                    = $date;

		return $columns;
	}

	/**
	 * Add custom column data to Events
	 *
	 * @param array $column Admin columns.
	 * @param int   $post_id Post ID.
	 */
	public function custom_lf_event_column( $column, $post_id ) {
		switch ( $column ) {

			// gets the start date of event.
			case 'lf_event_date_start':
				if ( get_post_meta( $post_id, 'lf_event_date_start', true ) ) {
					echo esc_html( gmdate( 'F j, Y', strtotime( get_post_meta( $post_id, 'lf_event_date_start', true ) ) ) );
				} else {
					echo 'TBC';
				}
				break;

			// $yes = '<span class="dashicons dashicons-yes-alt">c</span>';

			// displays if logo is present.
			case 'lf_event_logo':
				echo get_post_meta( $post_id, 'lf_event_logo', true ) ? '<span class="dashicons dashicons-yes-alt" style="color:green"></span>' : '<span class="dashicons dashicons-no-alt" style="color:red"></span>';
				break;

			// displays if background is present.
			case 'lf_event_background':
				echo get_post_meta( $post_id, 'lf_event_background', true ) ? '<span class="dashicons dashicons-yes-alt" style="color:green"></span>' : '<span class="dashicons dashicons-no-alt" style="color:red"></span>';
				break;

			// displays if mobile banner is present.
			case 'lf_event_mobile_banner':
				echo get_post_meta( $post_id, 'lf_event_mobile_banner', true ) ? '<span class="dashicons dashicons-yes-alt" style="color:green"></span>' : '<span class="dashicons dashicons-no-alt" style="color:red"></span>';
				break;

			// displays if desktop banner is present.
			case 'lf_event_desktop_banner':
				echo get_post_meta( $post_id, 'lf_event_desktop_banner', true ) ? '<span class="dashicons dashicons-yes-alt" style="color:green"></span>' : '<span class="dashicons dashicons-no-alt" style="color:red"></span>';
				break;
		}
	}

	/**
	 * Sorting events in date order
	 *
	 * @param array $query The query duh.
	 */
	public function set_events_admin_order( $query ) {

		// check not main query or any other CPT other than Events.
		if ( ! $query->is_main_query() || 'lf_event' !== $query->get( 'post_type' ) ) {
			return;
		}

		$meta_query = array(
			'relation' => 'OR',
			array(
				'lf_event_date_start' => array(
					'key' => 'lf_event_date_start',
				),
			),
		);

		$query->set( 'meta_query', $meta_query );
		$query->set(
			'orderby',
			array(
				'lf_event_date_start' => 'DESC',
			)
		);
		return $query;
	}

	/**
	 * Add custom column headers to Humans.
	 *
	 * @param array $columns Admin columns.
	 */
	public function set_custom_edit_lf_human_columns( $columns ) {
		$date = $columns['date'];
		unset( $columns['date'] );

		$columns['lf_human_image'] = 'Headshot';
		$columns['date']           = $date;

		return $columns;
	}

	/**
	 * Add custom column data to Humans
	 *
	 * @param array $column Admin columns.
	 * @param int   $post_id Post ID.
	 */
	public function custom_lf_human_column( $column, $post_id ) {
		if ( 'lf_human_image' == $column ) {
			echo get_post_meta( $post_id, 'lf_human_image', true ) ? '<span class="dashicons dashicons-yes-alt" style="color:green"></span>' : '<span class="dashicons dashicons-no-alt" style="color:red"></span>';
		}
	}

	/**
	 * Removes unneeded large image sizes default to WP.
	 */
	public function remove_image_sizes() {
		remove_image_size( '1536x1536' );             // 2 x Medium Large (1536 x 1536).
		remove_image_size( '2048x2048' );             // 2 x Large (2048 x 2048).
	}

	/**
	 * Remove tags support from posts.
	 */
	public function unregister_tags_for_posts() {
		unregister_taxonomy_for_object_type( 'post_tag', 'post' );
	}

	/**
	 * Registers REST routes.
	 */
	public function register_lf_rest_routes() {
		require_once plugin_dir_path( __FILE__ ) . '../includes/class-lf-mu-rest-controller.php';
		$controller = new LF_MU_REST_Controller();
		$controller->register_routes();
	}

	/**
	 * Sets the post preview link expiry to 7 days in place of the 48 hour default.
	 */
	public function set_post_preview_expiry() {
		return 7 * DAY_IN_SECONDS;
	}
}
