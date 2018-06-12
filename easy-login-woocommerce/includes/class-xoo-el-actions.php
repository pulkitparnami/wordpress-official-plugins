<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_El_Actions{

	public function __construct(){
		add_action('wp_ajax_xoo_el_form_action',array($this,'form_action'));
		add_action('wp_ajax_nopriv_xoo_el_form_action',array($this,'form_action'));
	}

	//Process form
	public function form_action(){
		if(isset($_POST['xoo-el-login'])){
			$action = Xoo_El_Form_Handler::process_login();
		}
		elseif(isset($_POST['xoo-el-register'])){
			$action = Xoo_El_Form_Handler::process_registration();
		}
		elseif(isset($_POST['xoo-el-lost-pw'])){
			$action = Xoo_El_Form_Handler::process_lost_password();
		}

		wp_send_json($action);
		die();

	}

}

new Xoo_El_Actions();

?>