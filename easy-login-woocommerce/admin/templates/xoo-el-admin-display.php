
<div class="xoo-container">
	<div class="xoo-main">
		<form method="post" action="options.php">
			<?php
				settings_fields( 'xoo-el-gl-options' ); // Display Settings

				do_settings_sections( 'xoo-el-gl' ); // Display Sections

				submit_button( 'Save Settings' );	// Display Save Button
			?>			
		</form>
		<div class="xoo-el-faqs">
			<span class="section-title">How to?</span>
			<ol>
				<li>Go to apperance->menus & select the desired option from "Login/Signup Popup" tab.</li>
				<li>Use shortcode [xoo_el_action] to include it anywhere on the website.<br>login: [xoo_el_action action="login"]<br>Register: [xoo_el_action action="register"] <br> Lost Password: [xoo_el_action action="lost-password"]</li>
				<li>Trigger pop up using classes.<br>Login: xoo-el-login-tgr<br>Register:xoo-el-reg-tgr <br>Lost password: xoo-el-lostpw-tgr<br>
					For eg: <?php echo htmlspecialchars('<a class="xoo-el-login-tgr">Login</a>'); ?></li>
			</ol>
		</div>
	</div>

	<div class="xoo-sidebar">
		<?php include XOO_EL_PATH.'/admin/templates/xoo-el-sidebar.php'; ?>
	</div>
</div>

