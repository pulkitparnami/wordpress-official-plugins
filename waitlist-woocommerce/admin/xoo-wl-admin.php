<?php
/**
 ========================
      ADMIN SETTINGS
 ========================
 */

//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}



function xoo_wl_admin_enqueue($hook){

	if($hook != 'toplevel_page_xoo_waitlist' && $hook != 'wait-list_page_xoo_waitlist_view'){return;}

	wp_enqueue_style('xoo-wl-admin-style',plugins_url('/assets/css/xoo-wl-admin-style.css',__FILE__),array(),XOO_WL_VERSION);

	if($hook == 'toplevel_page_xoo_waitlist'){
		wp_enqueue_style('wp-color-picker');
		wp_enqueue_media();
	}

	if($hook == 'wait-list_page_xoo_waitlist_view'){
		wp_enqueue_style('datatables-style','https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css');
		wp_enqueue_script('datatables-js','https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js',array('jquery'),XOO_WL_VERSION,true);
		wp_enqueue_script('xoo-wl-admin-table-js',plugins_url('/assets/js/xoo-wl-admin-table-js.js',__FILE__),array('jquery','wp-color-picker'),'1.4',true);
		wp_localize_script('xoo-wl-admin-table-js','xoo_wl_admin_table_lz',array(
			'adminurl'     		=> admin_url().'admin-ajax.php',
		));
	}

	wp_enqueue_script('xoo-wl-admin-js',plugins_url('/assets/js/xoo-wl-admin-js.js',__FILE__),array('jquery','wp-color-picker'),'1.4',true);
	wp_localize_script('xoo-wl-admin-js','xoo_wl_admin_lz',array(
		'adminurl'     		=> admin_url().'admin-ajax.php',
	));
	
}
add_action('admin_enqueue_scripts','xoo_wl_admin_enqueue');


//Settings page
function xoo_wl_menu_settings(){
	add_menu_page( 'Wait List Settings', 'Wait List', 'manage_options', 'xoo_waitlist', 'xoo_wl_settings_cb', 'dashicons-list-view', 60 );

	add_submenu_page( 'xoo_waitlist', 'Settings', 'Settings', 'manage_options', 'xoo_waitlist', 'xoo_wl_settings_cb');

	add_submenu_page( 'xoo_waitlist', 'View Waitlist', 'View Waitlist', 'manage_options', 'xoo_waitlist_view', 'xoo_wl_watilist_table_cb');
	add_action('admin_init','xoo_wl_settings');
}
add_action('admin_menu','xoo_wl_menu_settings');

//Settings callback function
function xoo_wl_settings_cb(){
	include_once XOO_WL_PATH.'/admin/xoo-wl-settings.php';
}

//Waitlist table Page callback
function xoo_wl_watilist_table_cb(){
	if(isset($_GET['product_id'])){
		include_once XOO_WL_PATH.'/admin/templates/xoo-wl-waitlist-users.php';
	}
	else{
		include_once XOO_WL_PATH.'/admin/templates/xoo-wl-waitlist-table.php';
	}
}

//Table actions - DELETE | SEND
function xoo_wl_admin_actions(){
	$rows_data  = (array) $_POST['xoo_wl_rows_data'];
	$action_type = $_POST['xoo_wl_action_type'];

	if(empty($rows_data) || !$action_type ) return;

	$result = false;

	if($action_type == 'delete_user'){
		$product_id = (int) $_POST['xoo_wl_product_id'];
		if(!$product_id) return;
		$waitlist = $rows_data;
		$result =xoo_wl_remove_user($product_id,$waitlist);
	}
	else if($action_type == 'delete_product'){
		$product_ids = $rows_data;
		foreach($product_ids as $product_id){
			$result = xoo_wl_remove_user($product_id,array(),true);
		}
	}
	else if($action_type == 'email_user'){
		$product_id = (int) $_POST['xoo_wl_product_id'];
		if(!$product_id) return;
		$waitlist = $rows_data;
		$result = xoo_wl_send_email($product_id,$waitlist);
	}
	else if($action_type == 'email_product'){
		$product_ids = $rows_data;
		foreach($product_ids as $product_id){
			$result = xoo_wl_send_email($product_id,array(),true);
		}
	}

	//Check success
	wp_send_json($result);

}
add_action('wp_ajax_xoo_wl_admin_actions','xoo_wl_admin_actions');


//admin settings
include_once XOO_WL_PATH.'/admin/xoo-wl-settings-functions.php';