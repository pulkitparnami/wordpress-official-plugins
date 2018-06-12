<?php
/**
* Plugin Name: WooCommerce Waitlist
* Plugin URI: http://xootix.com
* Author: XootiX
* Version: 1.4
* Text Domain: waitlist-woocommerce
* Domain Path: /languages
* Author URI: http://xootix.com
* Description: Waitlist WooCommerce allow users to add out of stock products to the waitlist and they get informed through email when the product is back in stock.
**/

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}


//Plugin path
define("XOO_WL_PATH", plugin_dir_path(__FILE__));
//Plugin url
define("XOO_WL_URL", plugins_url('',__FILE__));
//Version
define("XOO_WL_VERSION",1.4);


//Include admin file
include_once XOO_WL_PATH.'/admin/xoo-wl-admin.php';

//Core functions
include_once XOO_WL_PATH.'/includes/xoo-wl-core.php';


function xoo_wl_start_plugin(){
	//Front End
	include_once XOO_WL_PATH.'/includes/xoo-wl-public.php';
	Xoo_WL_Public::get_instance(); // Load front end
}
add_action('plugins_loaded','xoo_wl_start_plugin');