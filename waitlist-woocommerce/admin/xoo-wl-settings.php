<?php
//Exit if accessed directly
if(!defined('ABSPATH')){
	return;
}
?>

<?php settings_errors(); ?>
<div class="xoo-container">
	<div class="xoo-main">
		<form method="POST" action="options.php" class="xoo-wl-form">
			<?php settings_fields('xoo-wl-group'); ?>
			<?php do_settings_sections('xoo_waitlist'); ?>
			<?php submit_button(); ?>
		</form>
		<div class="rate-plugin">If you like the plugin , please show your support by rating <a href="https://wordpress.org/support/plugin/waitlist-woocommerce/reviews/" target="_blank">here.</a></div>
	</div>

	<div class="xoo-sidebar">
		<?php include XOO_WL_PATH.'/admin/templates/xoo-wl-sidebar.php'; ?>
	</div>

</div>
