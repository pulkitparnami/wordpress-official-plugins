<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$gl_options = get_option('xoo-el-gl-options');
$en_reg = isset($gl_options['m-en-reg']) ? $gl_options['m-en-reg'] : 1;
$reg_redirect = isset($gl_options['m-register-url']) && !empty($gl_options['m-register-url']) ? esc_attr($gl_options['m-register-url']) : $_SERVER['REQUEST_URI'];
$login_redirect = isset($gl_options['m-login-url']) && !empty($gl_options['m-login-url']) ? esc_attr($gl_options['m-login-url']) : $_SERVER['REQUEST_URI'];

$data_reg = array(
	'redirect' => $reg_redirect
);

$data_login = array(
	'en_reg' => $en_reg,
	'redirect' => $login_redirect
);

$data_lostpw = array(
'en_reg' => $en_reg,
);

?>

<div class="xoo-el-container">
	<div class="xoo-el-opac"></div>
	<div class="xoo-el-modal">
		<div class="xoo-el-inmodal">
			<div class="xoo-el-wrap">
				<div class="xoo-el-sidebar"></div>
				<div class="xoo-el-main">
					<span class="xoo-el-close fa fa-times"></span>

					<?php do_action('xoo_el_popup_start'); ?>

					<div class="xoo-el-section xoo-el-section-login xoo-el-active">
						<?php wc_get_template('xoo-el-login-section.php',$data_login,'',XOO_EL_PATH.'/templates/'); ?>
					</div>

					<?php if($en_reg == 1): ?>
						<div class="xoo-el-section xoo-el-section-register">
							<?php wc_get_template('xoo-el-signup-section.php',$data_reg,'',XOO_EL_PATH.'/templates/'); ?>
						</div>
					<?php endif; ?>

					<div class="xoo-el-section xoo-el-section-lostpw">
						<?php wc_get_template('xoo-el-lostpw-section.php',$data_lostpw,'',XOO_EL_PATH.'/templates/'); ?>
					</div>

					<?php do_action('xoo_el_popup_end'); ?>

					<span class="xoo-el-footer-note"><?php _e('We do not share your personal details with anyone.','easy-login-woocommerce'); ?></span>

				</div>
			</div>
		</div>
	</div>
</div>