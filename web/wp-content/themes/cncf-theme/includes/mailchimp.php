<?php

function subscribe_user_to_mailchimp() {

	// inspo https://artisansweb.net/mailchimp-integration-in-wordpress-without-using-a-plugin/

	$the_api     = get_field( 'api_key', 'option' );
	$the_list_id = get_field( 'list_id', 'option' );

	check_ajax_referer( 'subscribe_user', 'security' );
	$email       = $_POST['email'];
	$name        = $_POST['name'];
	$audience_id = $the_list_id;
	$api_key     = $the_api;
	$data_center = substr( $api_key, strpos( $api_key, '-' ) + 1 );
	$url         = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $audience_id . '/members';
	$auth        = base64_encode( 'user:' . $api_key );
	$arr_data    = json_encode(
		array(
			'email_address' => $email,
			'status'        => 'pending',
			'merge_fields'  => array(
				'FNAME' => $name,
			),
		)
	);
	$response    = wp_remote_post(
		$url,
		array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => "Basic $auth",
			),
			'body'    => $arr_data,
		)
	);
	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		echo "Something went wrong: $error_message";
	} else {
		$status_code = wp_remote_retrieve_response_code( $response );
		switch ( $status_code ) {
			case '200':
				echo $status_code;
				break;
			case '400':
				$api_response = json_decode( wp_remote_retrieve_body( $response ), true );
				echo $api_response['title'];
				break;
			default:
				echo 'Something went wrong. Please try again.';
				break;
		}
	}
	wp_die();
}

add_action( 'wp_ajax_subscribe_user', 'subscribe_user_to_mailchimp' );
add_action( 'wp_ajax_nopriv_subscribe_user', 'subscribe_user_to_mailchimp' );
