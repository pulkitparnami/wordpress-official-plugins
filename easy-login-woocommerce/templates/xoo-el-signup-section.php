<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="xoo-el-head">
	<span><?php _e('Sign Up','easy-login-woocommerce'); ?></span>
	<a class="xoo-el-login-tgr xoo-el-head-nav"><?php _e('Already Registered? Sign In','easy-login-woocommerce'); ?></a>
</div>


<div class="xoo-el-fields">
	<form class="xoo-el-action-form">
		<div class="xoo-el-notice"></div>

		<?php do_action('xoo_el_register_form_start'); ?>


		<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
			<input type="text" placeholder="<?php _e('Username','easy-login-woocommerce'); ?>" id="xoo-el-reg-username" name="xoo-el-username">
		<?php endif; ?>

		<input type="email" placeholder="<?php _e('Email','easy-login-woocommerce'); ?>" id="xoo-el-reg-email" name="xoo-el-email">

		<input type="text" placeholder="<?php _e('First Name','easy-login-woocommerce'); ?>" id="xoo-el-reg-fname" name="xoo-el-fname">
		<input type="text" placeholder="<?php _e('Last Name','easy-login-woocommerce'); ?>" id="xoo-el-reg-lname" name="xoo-el-lname">


		<input type="password" placeholder="<?php _e('Password','easy-login-woocommerce'); ?>" id="xoo-el-reg-password" name="xoo-el-password">
		<input type="password" placeholder="<?php _e('Confirm Password','easy-login-woocommerce'); ?>" id="xoo-el-reg-confirm-password" name="xoo-el-confirm-password">

		<input type="hidden" name="xoo-el-register" value="1">
		<button class="button btn xoo-el-action-btn xoo-el-register-btn"><?php _e('Sign Up','easy-login-woocommerce'); ?></button>

		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

		<?php do_action('xoo_el_register_form_end'); ?>

	</form>
</div>