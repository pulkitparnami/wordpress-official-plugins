<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_El_Frontend{

	public function __construct(){
		add_action('wp_enqueue_scripts',array($this,'enqueue_styles'));
		add_action('wp_enqueue_scripts',array($this,'enqueue_scripts'));
		add_action('wp_footer',array($this,'popup_markup'));

		add_shortcode('xoo_el_action',array($this,'markup_shortcode'));
	}

	//Enqueue stylesheets
	public function enqueue_styles(){
		wp_enqueue_style('xoo-el-style',XOO_EL_URL.'/assets/css/xoo-el-style.css',array(),XOO_EL_VERSION);
		wp_enqueue_style('font-awesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');


		$gl_options = get_option('xoo-el-gl-options');

		$btn_bg_color 	= isset($gl_options['m-btn-bgcolor']) ? $gl_options['m-btn-bgcolor'] : '#333';
		$btn_txt_color 	= isset($gl_options['m-btn-txtcolor']) ? $gl_options['m-btn-txtcolor'] : '#fff';
		$popup_width 	= isset($gl_options['m-popup-width']) ? $gl_options['m-popup-width'] : 750;
		$popup_height 	= isset($gl_options['m-popup-height']) ? $gl_options['m-popup-height'] : 600;
		$sidebar_img  	= isset($gl_options['s-sidebar-img']) ? $gl_options['s-sidebar-img'] : XOO_EL_URL.'/assets/images/popup-sidebar.png';
		$sidebar_width 	= isset($gl_options['s-sidebar-width']) ? $gl_options['s-sidebar-width'] : 46;
		$sidebar_pos 	= isset($gl_options['s-sidebar-pos']) ? $gl_options['s-sidebar-pos'] : 'left';

		$inline_style = "
			button.xoo-el-action-btn{
				background-color: {$btn_bg_color};
				color: {$btn_txt_color};
			}
			.xoo-el-inmodal{
				max-width: {$popup_width}px;
				max-height: {$popup_height}px;
			}
			.xoo-el-sidebar{
    			background-image: url({$sidebar_img});
    			width: {$sidebar_width}%;
    		}
		";

		if($sidebar_pos == 'right'){
			$inline_style .= "
				.xoo-el-wrap{
					direction: rtl;
				}
				.xoo-el-wrap > div{
					direction: ltr;
				}

			";
		}

		wp_add_inline_style('xoo-el-style',$inline_style);
	}

	//Enqueue javascript
	public function enqueue_scripts(){
		wp_enqueue_script('xoo-el-js',XOO_EL_URL.'/assets/js/xoo-el-js.min.js',array('jquery'),XOO_EL_VERSION,true);
		wp_localize_script('xoo-el-js','xoo_el_localize',array(
			'adminurl'  			=> admin_url().'admin-ajax.php',
			'set_footer_position' 	=> apply_filters('xoo_el_set_footer_position',true)
		));
	}

	//Add popup to footer
	public function popup_markup(){
		 wc_get_template('xoo-el-popup.php',array(),'',XOO_EL_PATH.'/templates/');
	}

	//Shortcode
	public function markup_shortcode($atts){
		$atts = shortcode_atts( array(
			'action' => 'login'
		), $atts, 'xoo_el_action');

		$class = 'xoo-el-action-sc ';

		if(is_user_logged_in()){
			$gl_options = get_option('xoo-el-gl-options');
			$logout_redirect = isset($gl_options['m-logout-url']) && !empty($gl_options['m-logout-url']) ? $gl_options['m-logout-url'] : $_SERVER['REQUEST_URI'];

			$html =  '<a href="'.wp_logout_url($logout_redirect).'" class="'.$class.'">'.__('Logout','easy-login-woocommerce').'</a>';
		}
		else{
			$action_type = $atts['action'];
			switch ($action_type) {
				case 'login':
					$class .= 'xoo-el-login-tgr';
					$text  	= __('Login','easy-login-woocommerce');
					break;

				case 'register':
					$class .= 'xoo-el-reg-tgr';
					$text  	= __('Signup','easy-login-woocommerce');
					break;

				case 'lost-password':
					$class .= 'xoo-el-lostpw-tgr';
					$text 	= __('Lost Password','easy-login-woocommerce');
					break;
				
				default:
					$class .= 'xoo-el-login-tgr';
					$text 	= __('Login','easy-login-woocommerce');
					break;
			}

			$html = '<a class="'.$class.'">'.$text.'</a>';
		}
		return $html;
	}

}


new Xoo_El_Frontend();

?>