<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WF_Software_Activate {
	private $is_ajax;
	public function __construct($upgrade_url, $plugin_name, $product_id, $api_key, $activation_email, $renew_license_url, $instance, $domain, $software_version, $plugin_or_theme, $text_domain, $extra='',  $wf_email_key, $wf_api_licence_key, $wf_instance_key){
		// API data
		$this->upgrade_url 			= $upgrade_url;
		$this->plugin_name 			= $plugin_name;
		$this->product_id 			= $product_id;
		$this->api_key 				= $api_key;
		$this->activation_email 	= $activation_email;
		$this->renew_license_url 	= $renew_license_url;
		$this->instance 			= $instance;
		$this->domain 				= $domain;
		$this->software_version 	= $software_version;

		$this->wf_email_key = $wf_email_key;
		$this->wf_api_licence_key = $wf_api_licence_key;
		$this->wf_instance_key = $wf_instance_key;

		$is_ajax = false;
	}

	public function create_software_api_url( $args ) {

		$api_url = add_query_arg( 'wc-api', 'am-software-api', $this->upgrade_url );

		return $api_url . '&' . http_build_query( $args );
	}


	public function wf_activation(){
		$is_ajax = false;
		if( isset($_GET['licence_key']) ){
			$this->api_key = $_GET['licence_key'];
			$this->is_ajax = true;
		}
		if( isset($_GET['email']) ){
			$this->activation_email = $_GET['email'];
			$this->is_ajax = true;
		}

		require_once( 'class-wc-api-manager-passwords.php' );
		
		$password_management = new API_Manager_Password_Management();

		// Generate a unique installation $instance id
		$instance = $password_management->generate_password( 12, false );

		$args = array(
			'email'				=> $this->activation_email,
			'licence_key'		=> $this->api_key,
			'request' 			=> 'activation',
			'product_id' 		=> $this->product_id,
			'instance' 			=> $instance,
			'platform' 			=> $this->domain,
			'software_version' 	=> $this->software_version,
		);
		
		$target_url = esc_url_raw( $this->create_software_api_url( $args ) );
		
		$response = wp_remote_get( $target_url );
        
    
		// Request failed
		if( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
			if( $this->is_ajax ){
				echo'{"error": "Request failed, Please try again"}';
				exit();
			}
			return false;
		}
        else
        {
            $response_array = json_decode($response['body'], true);
		    if(!isset($response_array['error']) && isset($response_array['activated']) && $response_array['activated'] == true){
                $plugin_name = trim($this->product_id," ");
                $single_options = array(
                    $plugin_name.'_activation_status'  => 'active',
                    $this->wf_api_licence_key 	=> $this->api_key,
                    $this->wf_instance_key 		=> $instance,
                    $this->wf_email_key 		=> $this->activation_email,
                );

                foreach ( $single_options as $key => $value ) {
                    update_option( $key, $value );
                }
            }
        }

		if( $this->is_ajax ){
			print_r($response['body']);
			exit();
		}else{
			return json_decode($response['body'], true);
		}
	}

	public function wf_status() {
		// $instance = get_option($this->wf_instance_key);
		$args = array(
			'request' 		=> 'status',
			'email'			=> $this->activation_email,
			'licence_key'	=> $this->api_key,
			'product_id' 	=> $this->product_id,
			'instance' 		=> $this->instance,
			'platform' 		=> $this->domain,
		);

		$target_url = esc_url_raw( $this->create_software_api_url( $args ) );

		$request = wp_remote_get( $target_url );

		$response = wp_remote_retrieve_body( $request );
		return $response;
	}

	public function wf_update_status(){
        
        $status = $this->wf_status();
		$status = json_decode($status, true);
		$plugin_name = trim($this->product_id," ");
		
		//case of plugin acivated once
		if( isset($status['status_check']) ){
			update_option( $plugin_name.'_activation_status', $status['status_check'] );
		}
		//case of order expiry
		elseif( isset( $status['activated'] ) ){
			update_option( $plugin_name.'_activation_status', $status['activated'] );
		}
	}
	
	public function wf_deactivation() {
		$is_ajax = false;
		$api_key = '';
		$activation_email = '';
		if( isset($_GET['licence_key']) ){
			$api_key = $_GET['licence_key'];
			$this->is_ajax = true;
		}
		if( isset($_GET['email']) ){
			$activation_email = $_GET['email'];
			$this->is_ajax = true;
		}

		$args = array(
			'request' 		=> 'deactivation',
			'email'			=> !empty($activation_email) ? $activation_email : $this->activation_email,
			'licence_key'	=> !empty($api_key) ? $api_key : $this->api_key,
			'product_id' 	=> $this->product_id,
			'instance' 		=> $this->instance,
			'platform' 		=> $this->domain,
		);
		
		$target_url = esc_url_raw( $this->create_software_api_url( $args ) );
		
		$response = wp_remote_get( $target_url );
		
		// Request failed
		if( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) {
			if( $this->is_ajax ){
				echo'{"error": "Request failed, Please try again"}';
				exit();
			}
			return false;
		}
        else{
            $plugin_name = trim($this->product_id," ");
			$single_options = array(
				$this->wf_api_licence_key 			=> '',
				$this->wf_instance_key 				=> '',
				$this->wf_email_key 				=> '',
				$plugin_name.'_activation_status' 	=> '',
			);

			foreach ( $single_options as $key => $value ) {
				update_option( $key, $value );
			}    
        }
		
		if( $this->is_ajax ){
			print_r($response['body']);
			exit();
		}else{
			return json_decode($response['body'], true);
		}
	}

} // End of class
