<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Menu items filter
if( !function_exists( 'xoo_el_nav_menu_items' ) ):
	function xoo_el_nav_menu_items( $items ) {

		if ( ! empty( $items ) && is_array( $items ) && is_user_logged_in()) {

			$actions_classes = array(
				'xoo-el-login-tgr',
				'xoo-el-reg-tgr',
				'xoo-el-lostpw-tgr'
			);

			foreach ( $items as $key => $item ) {
				$classes = $item->classes;
				if(!empty($action_class = array_intersect($actions_classes, $classes))){
					if(in_array('xoo-el-login-tgr', $action_class)){

						$gl_options = get_option('xoo-el-gl-options');
						$logout_redirect = isset($gl_options['m-logout-url']) && !empty($gl_options['m-logout-url']) ? $gl_options['m-logout-url'] : $_SERVER['REQUEST_URI'];

						$items[$key]->url = wp_logout_url($logout_redirect);
						$items[$key]->title = __('Logout','easy-login-woocommerce');
						$items[$key]->classes = array_diff($classes, $action_class);
					}
					else{
						unset($items[$key]);
					}
				}
			}
		}

		return $items;
	}
	add_filter('wp_nav_menu_objects','xoo_el_nav_menu_items',11);
endif;

//Internationalization
if( !function_exists( 'xoo_el_load_plugin_textdomain' ) ):
	function xoo_el_load_plugin_textdomain() {
		$domain = 'easy-login-woocommerce';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/'.$domain.'-' . $locale . '.mo' ); //wp-content languages
		load_plugin_textdomain( $domain, FALSE, basename( dirname( __FILE__ ) ) . '/languages/' ); // Plugin Languages
	}
	add_action('plugins_loaded','xoo_el_load_plugin_textdomain',100);
endif;


?>