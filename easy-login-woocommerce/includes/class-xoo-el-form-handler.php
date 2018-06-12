<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Xoo_El_Form_Handler{

	public static $register_add_extra_data = array();

	//Process Login
	public static function process_login(){

		$nonce_value = isset( $_POST['xoo-el-wc-login-nonce'] ) ? $_POST['woocommerce-login-nonce'] : null;

		if ( ! empty( $_POST['xoo-el-login'] ) ) {

			try {
				$creds = array(
					'user_login'    => trim( $_POST['xoo-el-username'] ),
					'user_password' => $_POST['xoo-el-password'],
					'remember'      => isset( $_POST['xoo-el-rememberme'] ),
				);

				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_login_errors', $validation_error, $_POST['username'], $_POST['password'] );

				if ( $validation_error->get_error_code() ) {
					throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . $validation_error->get_error_message() );
				}

				if ( empty( $creds['user_login'] ) ) {
					throw new Exception( '<strong>' . __( 'Error:', 'woocommerce' ) . '</strong> ' . __( 'Username is required.', 'woocommerce' ) );
				}

				// On multisite, ensure user exists on current site, if not add them before allowing login.
				if ( is_multisite() ) {
					$user_data = get_user_by( is_email( $creds['user_login'] ) ? 'email' : 'login', $creds['user_login'] );

					if ( $user_data && ! is_user_member_of_blog( $user_data->ID, get_current_blog_id() ) ) {
						add_user_to_blog( get_current_blog_id(), $user_data->ID, 'customer' );
					}
				}

				// Perform the login
				$user = wp_signon( apply_filters( 'woocommerce_login_credentials', $creds ), is_ssl() );

				if ( is_wp_error( $user ) ) {

					$message_code = $user->get_error_code();
					$lost_pw_text = ' <a class="xoo-el-lostpw-tgr">' .
						__( 'Lost your password?','easy-login-woocommerce' ).
						'</a>';
					if($message_code == 'incorrect_password'){
						$message  = __( 'The password you entered is incorrect.','easy-login-woocommerce' ).$lost_pw_text;

					}
					elseif($message_code == 'invalid_username'){
						$message = __( 'Invalid username.','easy-login-woocommerce' ) .
						' <a class="xoo-el-lostpw-tgr">' .$lost_pw_text;
					}

					elseif($message_code == 'invalid_email'){
						$message = __( 'Invalid email.','easy-login-woocommerce' ) .$lost_pw_text;
					}

					else{
						$message = $user->get_error_message();
						$message = str_replace( '<strong>' . esc_html( $creds['user_login'] ) . '</strong>', '<strong>' . esc_html( $creds['user_login'] ) . '</strong>', $message );
					}
					throw new Exception( $message );

				} else {

					if ( ! empty( $_POST['redirect'] ) ) {
						$redirect = $_POST['redirect'];
					} elseif ( wc_get_raw_referer() ) {
						$redirect = wc_get_raw_referer();
					} else {
						$redirect = wc_get_page_permalink( 'myaccount' );
					}

					$redirect = wp_validate_redirect( apply_filters( 'woocommerce_login_redirect', remove_query_arg( 'wc_error', $redirect ), $user ), wc_get_page_permalink( 'myaccount' ) );
					
					return array(
						'error' => 0,
						'notice' => '<i class="fa fa-check-circle" aria-hidden="true"></i> '.__('Login successfull'),
						'redirect' => $redirect
					);

				}
			} catch ( Exception $e ) {
				$error = apply_filters( 'xoo_el_login_errors', $e->getMessage() );
				do_action( 'xo_el_login_failed' );

				return array(
					'error' => 1,
					'notice' => $error
				);

			}
		}

	}


	/**
	 * Process the registration form.
	 */
	public static function process_registration() {

		if ( ! empty( $_POST['xoo-el-register'] ) ) {
			$username 		= 'no' === get_option( 'woocommerce_registration_generate_username' ) ? $_POST['xoo-el-username'] : '';
			$password 		= $_POST['xoo-el-password'];
			$re_password 	= $_POST['xoo-el-confirm-password'];
			$email    		= $_POST['xoo-el-email'];
			$fname 			= sanitize_text_field($_POST['xoo-el-fname']);
			$lname 			= sanitize_text_field($_POST['xoo-el-lname']);

			try {
				$validation_error = new WP_Error();
				$validation_error = apply_filters( 'woocommerce_process_registration_errors', $validation_error, $username, $password, $email );

				if ( $validation_error->get_error_code() ) {
					throw new Exception( $validation_error->get_error_message() );
				}

				if($password !== $re_password){
					throw new Exception(__("Passwords don't match","easy-login-woocommerce"));
				}

				if(!$fname || !$lname){
					throw new Exception(__("First/Last name cannot be empty","easy-login-woocommerce"));
				}

				self::$register_add_extra_data = array(
					'first_name' => $fname,
					'last_name'  => $lname
				);

				//Adding extra data
				add_filter('woocommerce_new_customer_data',function($data){
					return array_merge($data,self::$register_add_extra_data);
				});

				$new_customer = wc_create_new_customer( sanitize_email( $email ), wc_clean( $username ), $password );

				if ( is_wp_error( $new_customer ) ) {
					throw new Exception( $new_customer->get_error_message() );
				}

				if ( apply_filters( 'woocommerce_registration_auth_new_customer', true, $new_customer ) ) {
					wc_set_customer_auth_cookie( $new_customer );
				}

				if ( ! empty( $_POST['redirect'] ) ) {
					$redirect = wp_sanitize_redirect( $_POST['redirect'] );
				} elseif ( wc_get_raw_referer() ) {
					$redirect = wc_get_raw_referer();
				} else {
					$redirect = wc_get_page_permalink( 'myaccount' );
				}

				$redirect = wp_validate_redirect( apply_filters( 'woocommerce_registration_redirect', $redirect ), wc_get_page_permalink( 'myaccount' ) );

				return array(
					'error' => 0,
					'notice' => '<i class="fa fa-check-circle" aria-hidden="true"></i> '.__('Registration successfull','easy-login-woocommerce'),
					'redirect' => $redirect
				);

			} catch ( Exception $e ) {
				$error = apply_filters( 'xoo_el_registration_errors', $e->getMessage() );
				do_action('xoo_el_registration_failed');
				return array(
					'error' => 1,
					'notice' => $error
				);
			}
		}
	}


	// Process lost password form
	public static function process_lost_password(){
		if(isset($_POST['xoo-el-lost-pw'])){
			wc_clear_notices(); // clear notices
			$success = WC_Shortcode_My_Account::retrieve_password();
			if($success){
				ob_start();
				wc_get_template( 'myaccount/lost-password-confirmation.php' );
				$lost_password_confirmation = ob_get_clean();
				return array(
					'error' => 0,
					'notice' => '<div class="xoo-el-lostpw-success">'.$lost_password_confirmation.'</div>',
					'redirect' => null
				);

			}
			else{
				$errors = wc_get_notices('error');
				return array(
					'error' => 1,
					'notice' => $errors[0]
				);
			}
		}
	}

}

?>