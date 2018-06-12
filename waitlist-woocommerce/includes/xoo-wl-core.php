<?php

if(!defined('ABSPATH')){
	return;
}

//Add user to waitlist
function xoo_wl_add_waitlist_user(){
	global $xoo_wl_gl_enqty_value;
	$product_id = sanitize_text_field($_POST['xoo-wl-form-id']);
	$user_email = sanitize_email($_POST['xoo-wl-email'] );

	$error = array();

	if(!$xoo_wl_gl_enqty_value){
		$user_qty = 0;
	}
	else{
		$user_qty = (float) $_POST['xoo-wl-qty'];
		if(!$user_qty){
			$error[] = __('Invalid Quantity.','waitlist-woocommerce');
		}
	}


	//Check for errors

	if(!$user_email){
		$error[] = __('Email address cannot be empty.','waitlist-woocommerce');
	}


	if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)){
		$error[] = __('Please enter valid email address.','waitlist-woocommerce');
	}

	//Validate custom added fields
	do_action('xoo_wl_validate_fields',$error);


	//Send errors to front end & return
	if(!empty($error)){
		wp_send_json(array(
			'error' => (array) $error
		));
	}

	$stock_status 		= get_post_meta($product_id, '_stock_status',true);
	$backorders_allowed = get_post_meta($product_id,'_backorders',true);

	if($stock_status == 'instock' || $backorders_allowed == 'yes'){
		$error[] = __('Product is in stock. You can add to cart.','waitlist-woocommerce');
	}

	//Get old product waitlist
	$product_waitlist = (array) json_decode(get_post_meta( $product_id,'_xoo-wl-users', true ),true);

	if(empty($product_waitlist)){
		add_post_meta( 'product',$product_id , '_xoo-wl-users', '',true);
	}
	else{
		if(array_key_exists($user_email,$product_waitlist)){
			$error[] = __('You are already in waitlist.','waitlist-woocommerce');
		}
	}

	//Send errors to front end & return
	if(!empty($error)){
		wp_send_json(array(
			'error' => $error
		));
	}


	//Adding new user to waitlist
	$product_waitlist[$user_email] = array(
		'quantity'  => $user_qty,
		'joined_on' => date("d/M")
	);

	//Filter hook to make changes to waitlist data
	$new_product_waitlist = apply_filters('xoo_wl_product_waitlist',$product_waitlist);

	update_post_meta( $product_id, '_xoo-wl-users', json_encode($new_product_waitlist));

	$success =  __('You are now in waitlist. We will inform you as soon as we are back in stock.','waitlist-woocommerce');

	wp_send_json(array(
		'success' => $success
		)
	);
}

add_action('wp_ajax_xoo_wl_add_waitlist_user','xoo_wl_add_waitlist_user');
add_action('wp_ajax_nopriv_xoo_wl_add_waitlist_user','xoo_wl_add_waitlist_user');



//Check if stock status is updated
function xoo_wl_on_stock_update($meta_id,$object_id,$meta_key,$meta_value){
	global $xoo_wl_gl_enmail_value;

	//Return if auto save / autoemail false
	if($xoo_wl_gl_enmail_value != 'true' || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || $meta_key != '_stock_status' || $meta_value != 'instock'){
		return;
	}

	$waitlist = (array) json_decode(get_post_meta($object_id,'_xoo-wl-users',true),true);

	if(empty($waitlist)) return;

	do_action('xoo_wl_before_email_send',$waitlist,$object_id);

	//Send Emails
	xoo_wl_send_email($object_id,$waitlist = array(),true);

}
add_action('update_postmeta','xoo_wl_on_stock_update',10,4);



//Send email to waitlisted users
function xoo_wl_send_email($product_id,$waitlist = array(),$send_all = false){

	if(!$product_id || (empty($waitlist) && $send_all === false)) return;

	global $xoo_wl_emsy_logo_value,$xoo_wl_emsy_align_value,$xoo_wl_emgl_frnm_value,$xoo_wl_emgl_frem_value;

	//If emails are not provided , send email to all.
	if(empty($waitlist)){
		$waitlist = array_keys(xoo_wl_get_waitlist($product_id));
	}

	$product = wc_get_product($product_id);

	//Get placeholder if there is no image for the product
	$product_image 	= $product->get_image_id() ? wp_get_attachment_url($product->get_image_id()) : wc_placeholder_img_src();

	$args = array(
		'product_link'  			=> $product->get_permalink(),
		'product_name'  			=> $product->get_title(),
		'product_price' 			=> $product->get_price(),
		'product_image' 		 	=> $product_image,
		'xoo_wl_emsy_logo_value' 	=> $xoo_wl_emsy_logo_value,
		'xoo_wl_emsy_align_value' 	=> $xoo_wl_emsy_align_value
	);

	//Get email content
	ob_start();
	wc_get_template('xoo-wl-email-content.php',$args,'',XOO_WL_PATH.'/templates/');
	$email_content = ob_get_clean();

	//Set Headers
	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		"From: {$xoo_wl_emgl_frnm_value} <{$xoo_wl_emgl_frem_value}>",
	);


	//Email Subject
	$subject = sprintf(__('%s is back in stock','waitlist-woocommerce'),$product->get_title());


	//Send emails now
	foreach ($waitlist as $user_email) {
		wp_mail($user_email, $subject, $email_content,$headers);
	}

	//Clear the list
	return xoo_wl_remove_user($product_id, $waitlist);
}


//Remove wailisted user
function xoo_wl_remove_user($product_id, $user_emails = array() , $empty_all = false){

	if(!$product_id) return;

	if(empty($user_emails) && $empty_all === false) return;

	$waitlist = (array) xoo_wl_get_waitlist($product_id);

	if(empty($user_emails)){
		//Empty waitlist
		$waitlist = array();
	}
	else{
		foreach ($user_emails as $user_email) {
			unset($waitlist[$user_email]);
		}
	}

	return empty($waitlist) ? delete_post_meta($product_id,'_xoo-wl-users') : update_post_meta($product_id,'_xoo-wl-users',json_encode($waitlist));
}


// Get waitlist users data
function xoo_wl_get_waitlist($product_id){
 	if(!$product_id) return;
 	return (array) json_decode(get_post_meta($product_id,'_xoo-wl-users',true),true);
}

?>