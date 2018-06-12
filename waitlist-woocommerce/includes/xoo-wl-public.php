<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

/**
* Front End class
*/
class Xoo_WL_Public{

	protected static $instance = null;

	public $current_product;

	public function __construct(){
		global $xoo_wl_gl_enshop_value;

		add_action('wp_enqueue_scripts',array($this,'enqueue_scripts')); // Enqueue scripts
		add_action('plugins_loaded',array($this,'load_txtdomain'),99); // Load text domain
		add_action('wp_footer',array($this,'waitlist_form_output')); // Output waitlist form
		add_action('woocommerce_after_add_to_cart_button',array($this,'show_waitlist_button_for_variable_products')); // Show waitlist button for variable product
		add_filter('woocommerce_get_stock_html',array($this,'show_waitlist_button_for_other_products'),100,2); // Show waitlist button other than variable

		add_action('woocommerce_single_product_summary',array($this,'backup_show_waitlist_button_for_other_products'),31);

		if($xoo_wl_gl_enshop_value){
			add_filter('woocommerce_loop_add_to_cart_link',array($this,'show_waitlist_button_on_shop'));
		}
	}


	//Get instance
	public static function get_instance(){
		if(self::$instance === null){
			self::$instance = new self();
		}

		return self::$instance;
	}


	//Load plugin text domain
	public function load_txtdomain() {
		$domain = 'waitlist-woocommerce';
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		load_textdomain( $domain, WP_LANG_DIR . '/'.$domain.'-' . $locale . '.mo' ); //wp-content languages
		load_plugin_textdomain( $domain, FALSE, basename( XOO_WL_PATH ) . '/languages/' ); // Plugin Languages
	}


	//Eqneueu Script
	public function enqueue_scripts(){
		global $xoo_wl_sy_anim_value,$xoo_wl_gl_enbo_value;
		wp_enqueue_style('xoo-wl-style',XOO_WL_URL.'/assets/css/xoo-wl-style.css',null,XOO_WL_VERSION);
		wp_enqueue_script('xoo-wl-js',XOO_WL_URL.'/assets/js/xoo-wl-js.js',array('jquery'),XOO_WL_VERSION,true);

		wp_localize_script('xoo-wl-js','xoo_wl_localize',array(
			'adminurl'     		=> admin_url().'admin-ajax.php',
			'animation'			=> $xoo_wl_sy_anim_value,
			'allow_backorders'	=> $xoo_wl_gl_enbo_value,
			'e_empty_email' 	=> __('Email address cannot be empty.','waitlist-woocommerce'),
			'e_invalid_email' 	=> __('Please enter valid email address.','waitlist-woocommerce'),
			'e_min_qty' 		=> __('Quantity field cannot be empty','waitlist-woocommerce')
			));


		$style = '';
		if($xoo_wl_sy_anim_value  == 'fade-in'){
			$style  .=  '
				.xoo-wl-inmodal{
					-webkit-animation: xoo-wl-key-fadein 500ms ease;
					animation: xoo-wl-key-fadein 500ms ease;
	    			animation-fill-mode: forwards;
	   				opacity: 0;
				}

			';
		}
		elseif($xoo_wl_sy_anim_value  == 'slide-down'){
			$style  .=  '
				.xoo-wl-inmodal{
					-webkit-animation: xoo-wl-key-slide 650ms ease;
					animation: xoo-wl-key-slide 650ms ease;
	    			animation-fill-mode: forwards;
				}

			';
		}
		elseif($xoo_wl_sy_anim_value  == 'bounce-in'){
			$style  .=  '
				.xoo-wl-inmodal{
					-webkit-animation: xoo-wl-key-slide 650ms cubic-bezier(.47,1.41,.6,1.17);
					animation: xoo-wl-key-slide 650ms cubic-bezier(.47,1.41,.6,1.17);
	    			animation-fill-mode: forwards;
				}

			';
		}

		wp_add_inline_style('xoo-wl-style',$style);
	}


	//Waitlist button html
	public function waitlist_button_html($stock_html = ''){
		global $xoo_wl_gl_bntxt_value,$product;

		$product_id   = $product->get_id();
		$product_type = $product->get_type();

		$style 		= $product_type == 'variable' ? 'display: none;' : '';

		$btn_html =  '<a class="xoo-wl-btn button btn" data-xoo_product_id ="'.$product_id.'" data-min_qty="'.$product->get_min_purchase_quantity().'" style="'.$style.'">'.__($xoo_wl_gl_bntxt_value,'waitlist-woocommerce').'</a>';

		return apply_filters('xoo_wl_button_markup',$btn_html,$product_id);
	}


	//Waitlist form HTML
	public function waitlist_form_output(){
		wc_get_template('xoo-wl-form.php','','',XOO_WL_PATH.'/templates/');
	}


	//Display waitlist button on shop page
	public function show_waitlist_button_on_shop($html){
		global $product;

		if($product->is_type('variable') || $product->is_in_stock()){
			return $html;
		}
		else{
			return $html.$this->waitlist_button_html($html);
		}
	}


	//Display waitlist button on product page
	public function show_waitlist_button_for_other_products($html,$product){

		if($product->is_type('variation') || $product->is_in_stock()){
			return $html;
		}
		else{
			return $html.$this->waitlist_button_html($html);
		}
	}

	//Backup waitlist button
	public function backup_show_waitlist_button_for_other_products(){
		global $product;

		if(has_filter('woocommerce_get_stock_html') || $product->is_type('variation') || $product->is_in_stock()){
			return;
		}

		echo $this->waitlist_button_html();
	}


	//Display waitlist button for variable products on product page
	public function show_waitlist_button_for_variable_products($product){
		global $product;

		if(!$product->is_type('variable')) return;

		echo $this->waitlist_button_html();
	}

}

?>