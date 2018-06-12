<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_El_Core{

	protected static $_instance = null;

	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new Xoo_El_Core();
		}
		return self::$_instance;
	}


	public function __construct(){

		add_action('plugins_loaded',array($this,'check_plugin_version'),100);

		if($this->is_request('frontend')){
			require_once XOO_EL_PATH.'includes/class-xoo-el-frontend.php';
			require_once XOO_EL_PATH.'includes/class-xoo-el-form-handler.php';
			require_once XOO_EL_PATH.'includes/class-xoo-el-actions.php';
			require_once XOO_EL_PATH.'includes/xoo-el-functions.php';
		}
		elseif ($this->is_request('admin')) {
			require_once XOO_EL_PATH.'admin/xoo-el-admin-settings.php';
			require_once XOO_EL_PATH.'admin/includes/class-xoo-el-menu-settings.php';
		}
		
	}



	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'frontend':
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	//Update plugin version
	public function check_plugin_version(){
		$db_version = esc_attr(get_option('xoo-el-version'));
		if($db_version != XOO_EL_VERSION){
			update_option('xoo-el-version',XOO_EL_VERSION);
		}
	}


}


?>