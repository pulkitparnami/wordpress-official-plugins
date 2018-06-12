<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="xoo-el-head">
	<span><?php _e('Sign In','easy-login-woocommerce'); ?></span>
	<?php if($en_reg == 1): ?>
		<a class="xoo-el-reg-tgr xoo-el-head-nav"><?php _e('Not registered? Sign up','easy-login-woocommerce'); ?></a>
	<?php endif; ?>
</div>

<div class="xoo-el-fields">
	<form class="xoo-el-action-form">
		<div class="xoo-el-notice"></div>

		<?php do_action('xoo_el_login_form_start'); ?>

		<input type="text" placeholder="<?php _e('Username / Email','easy-login-woocommerce'); ?>" id="xoo-el-username" name="xoo-el-username">
		<input type="password" placeholder="<?php _e('Password','easy-login-woocommerce'); ?>" id="xoo-el-password" name="xoo-el-password">
		<a class="xoo-el-lostpw-tgr"><?php _e('Forgot Password?','easy-login-woocommerce'); ?></a>

		<input type="hidden" name="xoo-el-login" value="1">

		<button class="button btn xoo-el-action-btn xoo-el-login-btn"><?php _e('Sign In','easy-login-woocommerce'); ?></button>
		<input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

		<?php do_action('xoo_el_login_form_end'); ?>

	</form>
</div>