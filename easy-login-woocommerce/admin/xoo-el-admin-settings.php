<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Xoo_El_Admin_Settings{

	public function __construct(){
		add_action('admin_menu',array($this,'create_settings_page'));
		add_action('admin_enqueue_scripts',array($this,'enqueue_scripts'));
		$this->include_all_settings();
	}


	public function enqueue_scripts($hook) {

		//Enqueue Styles only on plugin settings page
		if($hook != 'toplevel_page_xoo-el'){
			return;
		}
		
		wp_enqueue_media(); // media gallery
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_style( 'xoo-el-admin-style', XOO_EL_URL . '/admin/assets/css/xoo-el-admin-style.css', array(), XOO_EL_VERSION, 'all' );
		wp_enqueue_script( 'xoo-el-admin-js', XOO_EL_URL . '/admin/assets/js/xoo-el-admin-js.js', array( 'jquery','wp-color-picker'), XOO_EL_VERSION, false );

	}


	public function create_settings_page(){
		add_menu_page( 'Login/Signup Popup Settings', 'Login/Signup Popup', 'manage_options', 'xoo-el', array($this,'render_settings_page'));
	}

	public function render_settings_page(){
		include XOO_EL_PATH.'/admin/templates/xoo-el-admin-display.php';
	}

	public function include_all_settings(){
		include XOO_EL_PATH.'admin/includes/class-xoo-el-general-settings.php';
	}

	public function get_section_markup($title){
		echo '<span class="section-title">'.$title.'</span>';
	}

}

new Xoo_El_Admin_Settings();

?>