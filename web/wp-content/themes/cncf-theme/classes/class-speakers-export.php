<?php
/**
 * Speakers Export class that allows for exporting Speakers Bureau data.
 *
 * @category Components
 * @package  WordPress
 * @author   Fuerza
 * @license  https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link     https://cncf.io
 * @since    1.0.0
 */

namespace Fuerza;

use Fuerza_Utils;

/**
 * Speakers Export class.
 */
class Speakers_Export {

	/**
	 * Instance.
	 *
	 * @var object $instance Instance of class.
	 */
	protected static $instance = null;

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'admin_init', array( $this, 'export_csv' ) );
		add_action( 'admin_menu', array( $this, 'add_submenu' ) );
	}

	/**
	 * Adds submenu page in admin.
	 */
	public function add_submenu() {
		add_submenu_page(
			'tools.php',
			'Export Speakers',
			'Export Speakers',
			'manage_options',
			'export-speakers',
			array( $this, 'get_page_content' )
		);
	}

	/**
	 * Get the admin page.
	 */
	public function get_page_content() {
		?>
		<div class="wrap">
			<h1>Export Speakers</h1>
			<a class="button button-primary button-hero" href="<?php echo esc_url( admin_url( '?fz-export-speakers=true' ) ); ?>">Export</a>
		</div>
		<?php
	}

	/**
	 * Exports CSV file.
	 */
	public function export_csv() {
		if ( ! Fuerza_Utils::get( 'fz-export-speakers', false ) ) {
			return;
		}

		$this->export();
	}

	/**
	 * Gets all Speakers data.
	 */
	public function get_speakers() {
		global $wpdb;
		$sql = "SELECT um.user_id as `user_id`, um.meta_value as `status`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'first_name' AND user_id = um.user_id) as `first_name`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'last_name' AND user_id = um.user_id) as `last_name`,
            u.user_email as `email`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'profile_photo' AND user_id = um.user_id) as `profile_photo`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'cncf_expertise' AND user_id = um.user_id) as `expertises`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'languages' AND user_id = um.user_id) as `languages`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'country' AND user_id = um.user_id) as `country`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'sb_certifications' AND user_id = um.user_id) as `certifications`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'twitter' AND user_id = um.user_id) as `twitter`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'sb_website' AND user_id = um.user_id) as `website`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'linkedin' AND user_id = um.user_id) as `linkedin`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'sb_github' AND user_id = um.user_id) as `github`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'sb_bio' AND user_id = um.user_id) as `bio`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'job-category' AND user_id = um.user_id) as `job_category`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'job-title' AND user_id = um.user_id) as `job_title`,
            (SELECT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'cncf_travel_range' AND user_id = um.user_id) as `travel_range`
        	FROM {$wpdb->usermeta} as um
            INNER JOIN {$wpdb->users} as u
            ON u.ID = um.user_id
        	WHERE um.meta_key = 'account_status' AND um.meta_value = 'approved'
        	AND um.user_id IN(SELECT user_id FROM wp_usermeta WHERE meta_key = 'wp_capabilities' AND meta_value LIKE '%s:10:\"um_speaker\"%')";

		return $wpdb->get_results( $sql ); //phpcs:ignore
	}

	/**
	 * Export data.
	 */
	public function export() {
		$filename = 'speakers-' . gmdate( 'Y-m-d' ) . '-' . current_time( 'timestamp' ) . '.csv';
		$columns  = array(
			'User ID',
			'First Name',
			'Last Name',
			'Email',
			'Profile Photo',
			'Expertises',
			'Languages',
			'Country',
			'Certifications',
			'Bio',
			'Job Category',
			'Job Title',
			'Travel Range',
			'Twitter',
			'Website',
			'Linkedin',
			'Github',
		);
		$speakers = $this->get_speakers();
		$output   = fopen( 'php://output', 'w' );

		fputcsv( $output, $columns );

		foreach ( $speakers as $speaker ) {
			$row = array(
				$speaker->user_id,
				$speaker->first_name,
				$speaker->last_name,
				$speaker->email,
				$speaker->profile_photo,
				$this->prepare_serialized_value( $speaker->expertises ),
				$this->prepare_serialized_value( $speaker->languages ),
				$speaker->country,
				$this->prepare_serialized_value( $speaker->certifications ),
				$speaker->bio,
				$speaker->job_category,
				$speaker->job_title,
				$speaker->travel_range,
				$speaker->twitter,
				$speaker->website,
				$speaker->linkedin,
				$speaker->github,
			);

			fputcsv( $output, $row );
		}

		header( 'Content-Type: text/csv; charset=utf-8 decode' );
		header( 'Content-type: text/force-download' );
		header( "Content-Disposition: attachment; filename={$filename}" );

		exit;
	}

	/**
	 * Prep serialized value.
	 *
	 * @param string $value Value to prep.
	 */
	private function prepare_serialized_value( $value ) {
		if ( 'NULL' !== $value && ! empty( $value ) ) {
			$array    = maybe_unserialize( trim( $value, '"' ) );
			$prepared = is_array( $array ) ? implode( ', ', $array ) : $value;
		} else {
			$prepared = 'NULL' === $value ? '' : $value;
		}

		return $prepared;
	}

	/**
	 * Returns the current instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

Speakers_Export::get_instance();
