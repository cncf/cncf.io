<?php

class WPRSS_FTP_Admin_User_Ajax {
	
	const COUNT_THRESHOLD = WPRSS_FTP_USER_AJAX_COUNT_THRESHOLD;
	const USER_QUERY_VAR_NAME = 's';
	const AJAX_ACTION_GET_USERS = 'wprss_get_users';
	
	const REQUEST_VAR_EXISTING_USERS_ONLY = 'existing_users_only';
	const REQUEST_VAR_LOGIN_NAMES = 'login_names';
	
	protected static $_instance;

	protected $_search_columns;
	
	
	/**
	 * 
	 * @return WPRSS_FTP_Admin_User_Ajax
	 */
	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			$class_name = __CLASS__;
			self::$_instance = new $class_name;
		}
		
		return self::$_instance;
	}
	
	
	public function __construct() {
		add_action( 'wprss_admin_head_after', array( $this, 'admin_head' ) );
		add_action( 'wprss_admin_footer_after', array( $this, 'admin_footer' ) );
		add_action( 'wprss_ftp_enqueue_wprss_feed_scripts_before', array( $this, 'enqueue_edit_scripts' ) );
		add_action( 'wp_ajax_' . self::AJAX_ACTION_GET_USERS, array( $this, 'ajax_get_users' ) );
		
		$this->add_search_column( array( 'user_login', 'user_email', 'user_nicename' ) );
	}
	
	
	public function enqueue_edit_scripts() {
		wp_enqueue_script( 'wprss_ftp_admin_ajax_chosen', WPRSS_FTP_JS . 'jquery-chosen/ajax-chosen.js', array('wprss-ftp-jquery-chosen') );
		wp_enqueue_script( 'wprss_ftp_admin_user_ajax', WPRSS_FTP_JS . 'admin-user-ajax.js', array('jquery') );
	}
	
	
	public function admin_head() {
		?>
				<!-- <?php echo __METHOD__ ?> -->
				<script type="text/javascript">
				;(function($, window, document, undefined) {
					if( window.wprss.f2p.userAjax ) {
						window.wprss.f2p.userAjax.init({
							'is_enabled':			<?php echo $this->is_over_threshold() ? 'true' : 'false' ?>,
							'request_var_name':		'<?php echo self::USER_QUERY_VAR_NAME ?>',
							'data':					{
								'action':				'<?php echo self::AJAX_ACTION_GET_USERS ?>'
							},
							'messages':				{
								'keep_typing':			'<?php echo __( 'Keep typing...', WPRSS_TEXT_DOMAIN ) ?>',
								'looking_for':			'<?php echo __( 'Looking for', WPRSS_TEXT_DOMAIN ) ?>'
							}
						});
					}
				})(jQuery, top, document);
				</script>
		<?php
	}
	
	
	public function admin_footer() {
		?>
				<!-- <?php echo __METHOD__ ?> -->
				<script type="text/javascript">
				;(function($, window, document, undefined) {
					if( window.wprss.f2p.userAjax )
						window.wprss.f2p.userAjax.run();
				})(jQuery, top, document);
				</script>
		<?php
	}
	
	
	public function get_total_user_count() {
		$result = count_users();
		return isset( $result['total_users'] ) ? $result['total_users'] : null;
	}
	
	
	public function get_users( $term ) {
		$args = array(
			'search'			=> '*' . $term . '*',
			'orderby'			=> 'user_login',
			'search_columns'	=> $this->get_search_columns()
		);
		
		$query = new WP_User_Query( $args );
		return (array) $query->get_results();
	}
	
	
	public function add_search_column( $column ) {
		if ( !is_array( $column ) )
			$column = (array)(string) $column;
		
		foreach ( $column as $_idx => $_column ) {
			$this->_search_columns[ $_column ] = true;
		}
		
		return $this;
	}
	
	
	public function remove_search_column( $column ) {
		if ( !is_array( $column ) )
			$column = (array)(string) $column;
		
		foreach ( $column as $_idx => $_column ) {
			if ( !$this->has_search_column( $_column ) ) continue;
			unset( $this->_search_columns[ $_column ] );
		}
		
		return $this;
	}
	
	
	public function has_search_column( $column ) {
		return isset( $this->_search_columns[ $column ] );
	}
	
	
	public function get_search_columns() {
		return array_keys( $this->_search_columns );
	}
	
	
	public function get_users_for_json( $users, $login_names = false ) {
		if ( is_null( $users ) ) $users = $this->get_query_term();
		if ( is_string( $users ) ) $users = $this->get_users( $users );
		
		$result = array();
		foreach ( $users as $_idx => $_user ) {
			/* @var $_user WP_User */
			$login_name = $_user->get( 'user_login' );
			$result[ $login_names ? $login_name : $_user->ID ] = $login_name;
		}
		
		return $result;
	}
	
	
	public function get_users_json( $users, $existing_only = false, $login_names = false ) {
		if( !is_array( $users ) )
			$users = $this->get_users_for_json ( $users, $login_names );
		
		if( !$existing_only ) {
			$users = array(
				'.'						=> __( 'Author in feed', WPRSS_TEXT_DOMAIN ),
				__( 'Existing user' )	=> $users
			);
		}
		$data = array('items' => $users);
		
		return json_encode( $data );
	}
	
	
	public function ajax_get_users() {
		if ( !($term = $this->get_query_term()) ) return null;
		$existing_only = isset( $_POST[ self::REQUEST_VAR_EXISTING_USERS_ONLY ] ) && $_POST[ self::REQUEST_VAR_EXISTING_USERS_ONLY ];
		$login_names = isset( $_POST[ self::REQUEST_VAR_LOGIN_NAMES ] ) && $_POST[ self::REQUEST_VAR_LOGIN_NAMES ];
		$json = $this->get_users_json( $term, $existing_only, $login_names );
		
		echo $json;
		exit();
	}
	
	
	public function is_over_threshold() {
		return $this->get_total_user_count() > WPRSS_FTP_USER_AJAX_COUNT_THRESHOLD;
	}
	
	
	public function get_query_term() {
		$var_name = self::USER_QUERY_VAR_NAME;
		return isset( $_POST[ $var_name ] ) ? $_POST[ $var_name ] : null;
	}
}

WPRSS_FTP_Admin_User_Ajax::get_instance();