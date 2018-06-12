<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Xoo_El_General_Settings extends Xoo_El_Admin_Settings{

	private static $group = 'xoo-el-gl';
	private static $options = array();

	public function __construct(){
		self::$options = get_option(self::$group.'-options');
		add_action('admin_init',array($this,'settings_api_init'));
	}

	public function settings_api_init(){
		
		register_setting(
			self::$group.'-options',
			self::$group.'-options'
		);

		add_settings_section(
			self::$group.'-main-options',
			'',
			array($this,'main_options_section'),
			self::$group
		);

		add_settings_section(
			self::$group.'-style-options',
			'',
			array($this,'style_options_section'),
			self::$group
		);

		/* Main Section */

		add_settings_field(
			'm-en-reg',
			 __( 'Enable Registration', 'easy-login-woocommerce' ),
			array( $this, 'm_enable_registration' ),
			self::$group,
			self::$group . '-main-options'
		);


		add_settings_field(
			'm-login-url',
			__( 'Login Redirect', 'easy-login-woocommerce' ),
			array( $this, 'm_login_url' ),
			self::$group,
			self::$group . '-main-options'
		);

		add_settings_field(
			'm-register-url',
			__( 'Registration Redirect', 'easy-login-woocommerce' ),
			array( $this, 'm_register_url' ),
			self::$group,
			self::$group . '-main-options'
		);

		add_settings_field(
			'm-logout-url',
			__( 'Logout Redirect', 'easy-login-woocommerce' ),
			array( $this, 'm_logout_url' ),
			self::$group,
			self::$group . '-main-options'
		);

		/** Style **/
		add_settings_field(
			'm-btn-bgcolor',
			__( 'Button Background Color', 'easy-login-woocommerce' ),
			array( $this, 'm_button_bg_color' ),
			self::$group,
			self::$group . '-style-options'
		);

		add_settings_field(
			'm-btn-txtcolor',
			__( 'Button Text Color', 'easy-login-woocommerce' ),
			array( $this, 'm_button_text_color' ),
			self::$group,
			self::$group . '-style-options'
		);

		add_settings_field(
			'm-popup-width',
			__( 'Pop Up Width', 'easy-login-woocommerce' ),
			array( $this, 'm_popup_width' ),
			self::$group,
			self::$group . '-style-options'
		);

		add_settings_field(
			'm-popup-height',
			__( 'Pop Up Height', 'easy-login-woocommerce' ),
			array( $this, 'm_popup_height' ),
			self::$group,
			self::$group . '-style-options'
		);

		add_settings_field(
			's-sidebar-img',
			__( 'Sidebar Image', 'easy-login-woocommerce' ),
			array( $this, 's_sidebar_img' ),
			self::$group,
			self::$group . '-style-options'
		);

		add_settings_field(
			's-sidebar-pos',
			__( 'Sidebar Position', 'easy-login-woocommerce' ),
			array( $this, 's_sidebar_position' ),
			self::$group,
			self::$group . '-style-options'
		);

		add_settings_field(
			's-sidebar-width',
			__( 'Sidebar Width', 'easy-login-woocommerce' ),
			array( $this, 's_sidebar_width' ),
			self::$group,
			self::$group . '-style-options'
		);

	}


	public function main_options_section(){
		$this->get_section_markup('Main');
	}

	public function style_options_section(){
		$this->get_section_markup('Style');
	}


	public function m_enable_registration(){
		$key = 'm-en-reg';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : 1
		?>

		<input type="hidden" name="<?php echo $id; ?>" value="false">
		<input type="checkbox" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="1" <?php checked($value, 1); ?> />
		<?php
	}


	public function m_button_bg_color(){
		$key = 'm-btn-bgcolor';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : '#333';
		?>

		<input type="text" class="color-field" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<?php
	}


	public function m_button_text_color(){
		$key = 'm-btn-txtcolor';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : '#fff';
		?>

		<input type="text" class="color-field" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<?php
	}


	public function m_popup_width(){
		$key = 'm-popup-width';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : 750;
		?>

		<input type="number" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<p class="description">Size in px</p>
		<?php
	}

	public function m_popup_height(){
		$key = 'm-popup-height';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : 600;
		?>

		<input type="number" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<p class="description">Size in px</p>
		<?php
	}



	public function s_sidebar_img(){
		$key = 's-sidebar-img';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : XOO_EL_URL.'/assets/images/popup-sidebar.png';
		?>

		<a class="button-primary xoo-upload-icon">Select</a>
		<input type="hidden" id="<?php echo $id; ?>" name="<?php echo $id; ?>" class="xoo-upload-url" value="<?php echo $value; ?>">
		<a class="button xoo-remove-media">Remove</a>
		<span class="xoo-upload-title"></span>
		<p class="description">Supported format: JPEG,PNG </p>

		<?php
	}


	public function s_sidebar_position(){
		$key = 's-sidebar-pos';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : 'left';
		?>

		<select name="<?php echo $id; ?>">
			<option value="left" <?php selected( $value, "left" ); ?>>Left</option>
			<option value="right" <?php selected( $value, "right" ); ?>>Right</option>
		</select>

		<?php
	}



	public function s_sidebar_width(){
		$key = 's-sidebar-width';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? self::$options[$key] : 45;
		?>

		<input type="number" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<p class="description">Width in percentage.</p>

		<?php
	}

	public function m_login_url(){
		$key = 'm-login-url';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? esc_attr(self::$options[$key]) : '';
		?>

		<input type="text" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<p class="description">Leave empty to redirect on the same page.</p>
		<?php
	}

	public function m_register_url(){
		$key = 'm-register-url';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? esc_attr(self::$options[$key]) : '';
		?>

		<input type="text" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<p class="description">Leave empty to redirect on the same page.</p>
		<?php
	}


	public function m_logout_url(){
		$key = 'm-logout-url';
		$id = self::$group.'-options['.$key.']';
		$value = isset(self::$options[$key]) ? esc_attr(self::$options[$key]) : '';
		?>

		<input type="text" id="<?php echo $id; ?>" name="<?php echo $id; ?>" value="<?php echo $value; ?>" />
		<p class="description">Leave empty to redirect on the same page.</p>
		<?php
	}

}

new Xoo_El_General_Settings();

?>