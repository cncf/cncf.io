<?php

require_once( ABSPATH . '/wp-admin/includes/class-wp-list-table.php' );

class GF_API_Keys_Table extends WP_List_Table {

	public function __construct( $args = array() ) {
		parent::__construct( $args );

	}

	protected function get_table_classes() {
		return array( 'widefat', 'striped', 'feeds',  'api_key_table' );
	}

	/**
	 * Returns an array of columns to be included in the list table.
	 *
	 * @since 2.4
	 * @since 2.4.22 Removed the key column.
	 *
	 * @return array
	 */
	function get_columns() {

		return array(
			'description' => esc_html__( 'Description', 'gravityforms' ),
			'user'        => esc_html__( 'User', 'gravityforms' ),
			'permissions' => esc_html__( 'Permissions', 'gravityforms' ),
			'last_access' => esc_html__( 'Last Access', 'gravityforms' ),
		);
	}

	function prepare_items() {

		$this->_column_headers = array( $this->get_columns(), array(), array() );
		$this->items = GFWebAPI::get_api_keys();
	}

	function process_action() {

		$action = rgget( 'single_action' );

		if ( $action !== 'revoke' ) {
			return;
		}

		check_admin_referer( 'gforms_revoke_key' );

		$this->delete_api_key( rgget( 'key_id' ) );
	}

	function column_default( $item, $column_name ) {
		return $item[ $column_name ];
	}

	function column_description( $item ) {

		// create a nonce
		$revoke_nonce = wp_create_nonce( 'gforms_revoke_key' );

		$description = $item['description'];

		$confirm = "javascript: if( ! confirm('WARNING: You are about to revoke this API Key. \'Cancel\' to stop, \'OK\' to revoke.')){ event.stopPropagation(); return false } ";
		$nonce_url = wp_nonce_url( '?page=gf_settings&subview=gravityformswebapi', 'gf_revoke_key' );

		$actions = array(
			'edit' => '<a href="' . $this->get_edit_url( $item['key_id'] ) . '">' . esc_html__( 'Edit', 'gravityforms' ) . '</a>',
			'delete' => sprintf( '<a data-wp-lists="delete:the-list:key_row_%d::status=delete&action=delete_key&key=%d" onclick="%s" href="%s" class="submitdelete">Revoke</a>', absint( $item['key_id'] ), absint( $item['key_id'] ), $confirm, $nonce_url ),
		);

		return $description . $this->row_actions( $actions );
	}

	function get_edit_url( $key_id ) {
		return sprintf( '?page=gf_settings&subview=gravityformswebapi&action=edit&key_id=%s', absint( $key_id ) );
	}

	function column_last_access( $item ) {
		return empty( $item['last_access'] ) ? __( 'Never Accessed', 'gravityforms' ) : GFCommon::format_date( $item['last_access'], true, '', true );
	}

	function column_permissions( $item ) {

		if ( $item['permissions'] == 'read_write' ) {
			return 'Read/Write';
		} else {
			return ucwords( $item['permissions'] );
		}

	}

	function no_items() {
		echo '<div style="padding:10px;">' . sprintf( esc_html__( 'You don\'t have any API keys. Let\'s go %1$screate one%2$s!', 'gravityforms' ), '<a ' . $this->add_key_link() . '>', '</a>' ) . '</div>';
	}

	/**
	 * Determines if the API is enabled in the database.
	 *
	 * @since 2.4.22.8
	 *
	 * @return boolean True if the API is enabled, false otherwise.
	 */
	public function is_api_enabled() {
		$web_api_settings = get_option( 'gravityformsaddon_gravityformswebapi_settings' );
		return ( !empty( $web_api_settings ) && $web_api_settings['enabled'] );
	}

	/**
	 * Return the notice text to display if API access is not enabled.
	 *
	 * @since 2.4.22.8
	 *
	 * @return string the update notice.
	 */
	public function update_notice() {
		$notice_text = __( 'Click the Update button below to add API Keys.', 'gravityforms' );
		return $this->is_api_enabled() ? '' : '<div class="api-update-notice"><p>' . $notice_text . '</p></div>';
	}

	/**
	 * Return the href attribute for the "Add Key" link if API access is not enabled.
	 *
	 * @since 2.4.22.8
	 *
	 * @return string The href attribute to add a new key, or a blank string.
	 */
	public function add_key_link() {
		return $this->is_api_enabled() ? 'href="' . $this->get_edit_url( 0 ) . '"' : '';
	}

	/**
	 * Display the table
	 *
	 * @since 3.1.0
	 */
	public function display() {
		$singular = $this->_args['singular'];

		$disabled = $this->is_api_enabled() ? '' : 'disabled';

		$this->screen->render_screen_reader_content( 'heading_list' );
		?>

		<input type="hidden" name="single_action"/> <input type="hidden" name="action_args"/>
		<table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>">
			<thead>
			<tr>
				<?php $this->print_column_headers(); ?>
			</tr>
			</thead>

			<tbody id="the-list"<?php
			if ( $singular ) {
				echo " data-wp-lists='list:$singular'";
			} ?>>
			<?php $this->display_rows_or_placeholder(); ?>
			</tbody>

		</table>
		<?php echo $this->update_notice(); ?>
		<div>
			<a class="button-secondary gfbutton gaddon-setting" id="add_setting_button" <?php echo $this->add_key_link(); echo $disabled ?>>Add Key</a>
		</div>
		<?php

	}

	/**
	 * Generates content for a single row of the table
	 *
	 * @since 3.1.0
	 *
	 * @param object $item The current item
	 */
	public function single_row( $item ) {
		echo "<tr id='key_row_{$item['key_id']}' >";
		$this->single_row_columns( $item );
		echo '</tr>';
	}

	public function output_styles() {
		?>
		<style>
			table.gforms_form_settings .api_key_table td { padding-left: 10px; vertical-align: top; }
			#add_setting_button { margin-top: 10px; }
			tr:hover .row-actions { position: relative; }
			.api_key_table tr:hover .row-actions { position: static; }
		</style>
		<?php
	}

	public function output_scripts() {
		?>
		<script type="text/javascript">

			jQuery(document).ready(function () {

				jQuery("#the-list").wpList();

			});

		</script>
		<?php
	}
}
