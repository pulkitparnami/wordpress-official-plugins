<?php

//Custom settings
function xoo_wl_settings(){

	//==== MAIN || Register Settings ==== //

	/*General Options*/
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enguest'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enmail'
	);


	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enqty'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-enshop'
	);


	register_setting(
		'xoo-wl-group',
 		'xoo-wl-gl-bntxt'
	);

	/* Style Options */
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-sy-posi'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-sy-anim'
	);

	//========//

	//==== EMAIL || Register Settings ==== //

	/*General Options*/
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emgl-frem'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emgl-frnm'
	);

	/*Style Options*/
	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emsy-logo'
	);

	register_setting(
		'xoo-wl-group',
 		'xoo-wl-emsy-align'
	);


	//========//

	//==== MAIN || Section Settings ==== //

	add_settings_section(//General Section
		'xoo-wl-gl-main',
		'',
		'xoo_wl_gl_main_cb',
		'xoo_waitlist'
	);

	add_settings_section(//Style Section
		'xoo-wl-sy-main',
		'',
		'xoo_wl_sy_main_cb',
		'xoo_waitlist'
	);

	
	add_settings_section(//End Main settings Section
		'xoo-wl-end-main',
		'',
		'xoo_wl_end_main_cb',
		'xoo_waitlist'
	);
	//========//

	//==== EMAIL || Section Settings ==== //
	add_settings_section(//General Section
		'xoo-wl-gl-email',
		'',
		'xoo_wl_gl_email_cb',
		'xoo_waitlist'
	);

	add_settings_section(//Style Section
		'xoo-wl-sy-email',
		'',
		'xoo_wl_sy_email_cb',
		'xoo_waitlist'
	);

	add_settings_section(//End Email settings Section
		'xoo-wl-end-email',
		'',
		'xoo_wl_end_email_cb',
		'xoo_waitlist'
	);
	//========//

	//==== ADVANCED || Section Settings ==== //


	add_settings_section(//Begin End Advanced Settings
		'xoo-wl-adv',
		'',
		'xoo_wl_adv_cb',
		'xoo_waitlist'
	);


	//========//


	//==== MAIN || Add Fields ==== //

	/*General Options*/
	add_settings_field(
		'xoo-wl-gl-enguest',
		'Enable Guest',
		'xoo_wl_gl_enguest_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	add_settings_field(
		'xoo-wl-gl-enmail',
		'Auto Email',
		'xoo_wl_gl_enmail_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);


	add_settings_field(
		'xoo-wl-gl-enqty',
		'Allow Quantity',
		'xoo_wl_gl_enqty_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	add_settings_field(
		'xoo-wl-gl-enshop',
		'Shop Button',
		'xoo_wl_gl_enshop_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	add_settings_field(
		'xoo-wl-gl-bntxt',
		'Waitlist Button Text',
		'xoo_wl_gl_bntxt_cb',
		'xoo_waitlist',
		'xoo-wl-gl-main'
	);

	/* Style Options*/

	add_settings_field(
		'xoo-wl-sy-anim',
		'Modal Animation',
		'xoo_wl_sy_anim_cb',
		'xoo_waitlist',
		'xoo-wl-sy-main'
	);



	//========//

	//==== EMAIL || Add Fields ==== //

	/*General Options*/
	add_settings_field(
		'xoo-wl-emgl-frem',
		'From: [Email]',
		'xoo_wl_emgl_frem_cb',
		'xoo_waitlist',
		'xoo-wl-gl-email'
	);

	add_settings_field(
		'xoo-wl-emgl-frnm',
		'From: [Name]',
		'xoo_wl_emgl_frnm_cb',
		'xoo_waitlist',
		'xoo-wl-gl-email'
	);

	/*Style Options*/
	add_settings_field(
		'xoo-wl-emsy-logo',
		'Select Logo',
		'xoo_wl_emsy_logo_cb',
		'xoo_waitlist',
		'xoo-wl-sy-email'
	);

	add_settings_field(
		'xoo-wl-emsy-align',
		'Align Email',
		'xoo_wl_emsy_align_cb',
		'xoo_waitlist',
		'xoo-wl-sy-email'
	);

	//========//

}

/***** Custom Settings Callback *****/

//Main - General Settings callback
function xoo_wl_gl_main_cb(){
	?>

<?php 	/** Settings Tab **/ ?>
	<div class="xoo-tabs">
		<ul>
			<li class="tab-1 active-tab">Main</li>
			<li class="tab-2">Email</li>
			<li class="tab-3">Advanced</li>
		</ul>
	</div>

<?php 	/** Settings Tab **/ ?>

	<?php
	$tab = '<div class="main-settings settings-tab settings-tab-active" tab-class ="tab-1">';  //Begin Main settings
	echo $tab.'<h2>General Options</h2>';
}

//Main - Style Settings callback
function xoo_wl_sy_main_cb(){
	echo '<h2>Style Options</h2>';
}

//End Main Settings / Begin Email Settings
function xoo_wl_end_main_cb(){
	$tab  = '</div>'; // End Main Settings
	$tab .= '<div class="email-settings settings-tab" tab-class ="tab-2">';  //Begin Email Settings settings
	echo $tab;
}

//Email - General Settings callback
function xoo_wl_gl_email_cb(){
	echo '<h2>General Options</h2>';
}

//Email - Style Settings callback
function xoo_wl_sy_email_cb(){
	echo '<h2>Style Options</h2>';
}

//End Email Settings // Begin How to
function xoo_wl_end_email_cb(){
	$html   = '</div>'; // End Email Settings
	$html  .= '<div class="advanced-settings settings-tab" tab-class ="tab-3">';
	echo $html;
}

// Begin/End Advanced Settings
function xoo_wl_adv_cb(){
	ob_start();
	include(XOO_WL_PATH.'/admin/templates/xoo-wl-fvsp-template.php');
	$html  = ob_get_clean();
	$html .= '</div>'; // End Advanced settings
	echo $html;
}



//========================================//
//============ MAIN CALLBACK ============//
//======================================//

 //Enable guest
$xoo_wl_gl_enguest_value = esc_attr(get_option('xoo-wl-gl-enguest','true'));
function xoo_wl_gl_enguest_cb(){
	global $xoo_wl_gl_enguest_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enguest" id ="xoo-wl-gl-enguest" value="true"'.checked('true',$xoo_wl_gl_enguest_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enguest">Allow guest users to be in waitlist.(<span style="text-decoration: italic;">If untick , make sure registration is enabled for woocommerce users.</span>)</label>';
	echo $html;
}

//Enable Auto Email
$xoo_wl_gl_enmail_value = esc_attr(get_option('xoo-wl-gl-enmail','true'));
function xoo_wl_gl_enmail_cb(){
	global $xoo_wl_gl_enmail_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enmail" id ="xoo-wl-gl-enmail" value="true"'.checked('true',$xoo_wl_gl_enmail_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enmail">Send Email automatically when product is back in stock.</span></label>';
	echo $html;
}


 //Allow Quantity
$xoo_wl_gl_enqty_value = esc_attr(get_option('xoo-wl-gl-enqty','true'));
function xoo_wl_gl_enqty_cb(){
	global $xoo_wl_gl_enqty_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enqty" id ="xoo-wl-gl-enqty" value="true"'.checked('true',$xoo_wl_gl_enqty_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enqty">Ask users , how much quantity they need.</label>';
	echo $html;
}

 //Waitlist button on Shop
$xoo_wl_gl_enshop_value = esc_attr(get_option('xoo-wl-gl-enshop','true'));
function xoo_wl_gl_enshop_cb(){
	global $xoo_wl_gl_enshop_value;
	$html  = '<input type="checkbox" name="xoo-wl-gl-enshop" id ="xoo-wl-gl-enshop" value="true"'.checked('true',$xoo_wl_gl_enshop_value,false).'>';
	$html .= '<label for="xoo-wl-gl-enshop">Enable Wait List button on shop  page [Simple Products]</label>';
	echo $html;
}


//Waitlist button text
$xoo_wl_gl_bntxt_value = esc_attr(get_option('xoo-wl-gl-bntxt',__('Join Waitlist','waitlist-woocommerce')));
function xoo_wl_gl_bntxt_cb(){
	global $xoo_wl_gl_bntxt_value;
	$html = '<input type="text" name="xoo-wl-gl-bntxt" id ="xoo-wl-gl-bntxt" value="'.$xoo_wl_gl_bntxt_value.'">';
	$html .= '<label for="xoo-wl-gl-bntxt">Label for waitlist button.</label>';
	echo $html;
}


//Modal Animation
$xoo_wl_sy_anim_value = esc_attr(get_option('xoo-wl-sy-anim','fade-in'));
function xoo_wl_sy_anim_cb(){
	global $xoo_wl_sy_anim_value;
	?>
	<select name="xoo-wl-sy-anim" class="xoo-wl-input">
		<option value="none" <?php selected($xoo_wl_sy_anim_value,'none'); ?> >None</option>
		<option value="slide-down" <?php selected($xoo_wl_sy_anim_value,'slide-down'); ?> >Slide-Down</option>
		<option value="bounce-in" <?php selected($xoo_wl_sy_anim_value,'bounce-in'); ?> >Bounce-In</option>
		<option value="fade-in" <?php selected($xoo_wl_sy_anim_value,'fade-in'); ?> >Fade-In</option>
	</select>
	<?php
	echo '<label for="xoo-wl-sy-anim">Waitlist Modal (Box) Animation.</label>';
}

//========================================//
//============ EMAIL CALLBACK ===========//
//======================================//

//From email
$xoo_wl_emgl_frem_value = esc_attr(get_option('xoo-wl-emgl-frem','wordpress@example.com'));
function xoo_wl_emgl_frem_cb(){
	global $xoo_wl_emgl_frem_value;
	$html = '<input type="text" name="xoo-wl-emgl-frem" id ="xoo-wl-emgl-frem" value="'.$xoo_wl_emgl_frem_value .'">';
	$html .= '<label for="xoo-wl-emgl-frem">Sender\'s email address.<span class="xoo-required">*</span></label>';
	echo $html;	
}

//From Name
$xoo_wl_emgl_frnm_value = esc_attr(get_option('xoo-wl-emgl-frnm','Wordpress'));
function xoo_wl_emgl_frnm_cb(){
	global $xoo_wl_emgl_frnm_value;
	$html = '<input type="text" name="xoo-wl-emgl-frnm" id ="xoo-wl-emgl-frnm" value="'.$xoo_wl_emgl_frnm_value .'">';
	$html .= '<label for="xoo-wl-emgl-frnm">Sender\'s Name.<span class="xoo-required">*</span></label>';
	echo $html;	
}


//Email Logo
$xoo_wl_emsy_logo_value = esc_attr(get_option('xoo-wl-emsy-logo',XOO_WL_URL.'/admin/assets/images/logo.png'));
function xoo_wl_emsy_logo_cb(){
	global $xoo_wl_emsy_logo_value;
	$html = '<input type="button" id="xlogo-btn" class="button xoo-prbtn" value="Select">';
	$html .= '<input type="hidden" name="xoo-wl-emsy-logo" id ="xoo-wl-emsy-logo" value="'.$xoo_wl_emsy_logo_value.'">';
	$html .= '<button class="xoo-remove-logo button">X Remove</button>';
	$html .= '<span class="xoo-logo-name"></span>';
	$html .= '<p class="description">Supported format: JPEG,PNG </p>';
	echo $html;	
}

//Email Align
$xoo_wl_emsy_align_value = esc_attr(get_option('xoo-wl-emsy-align','center'));
function xoo_wl_emsy_align_cb(){
	global $xoo_wl_emsy_align_value;
	?>
	<select name="xoo-wl-emsy-align" class="xoo-wl-input">
	<option value="left" <?php selected($xoo_wl_emsy_align_value,'left'); ?> >Left</option>
	<option value="center" <?php selected($xoo_wl_emsy_align_value,'center'); ?> >Center</option>
	</select>
	<?php
}