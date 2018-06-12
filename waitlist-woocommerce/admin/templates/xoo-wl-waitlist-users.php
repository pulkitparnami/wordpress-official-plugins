<?php

//Exit if accessed directly
if(!defined('ABSPATH') || !isset($_GET['product_id'])){
	return;
}

?>

<?php

$product_id = (int) $_GET['product_id'];
$product 	= wc_get_product($product_id);

?>

<div class="xoo-wl-main">

<a href="<?php menu_page_url('xoo_waitlist_view'); ?>" style="font-size: 16px;"><span class="dashicons dashicons-arrow-left-alt" style="text-decoration: none;"></span> Go back</a>

<h2><?php if($product) echo ($product->get_title()).' Waitlist'; ?></h2>

<span class="xoo-wl-table-notice"></span>

<table id="xoo-wl-users" class="display xoo-wl-table" cellspacing="0" width="100%" data-product_id="<?php echo $product_id; ?>">

	<thead>
		<tr>
			<th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
			<th>Waitlisted On</th>
			<th>Email</th>
			<th>Quantity</th>
			<th>Customer</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php
		$waitlist = (array) json_decode(get_post_meta($product_id,'_xoo-wl-users',true),true);
		if(empty($waitlist)) return;
		foreach ($waitlist as $user_raw_email => $user_data):
			$user_email 	 = esc_attr($user_raw_email);
			$user_qty 		 = isset($user_data['quantity']) && $user_data['quantity'] != '0' ? floatval($user_data['quantity']) : '-';
			$waitlisted_on   = isset($user_data['joined_on']) ? $user_data['joined_on'] : '-'; 
			$is_customer 	 = email_exists($user_email) ? 'dashicons-yes' : 'dashicons-no-alt';
		?>

		<tr data-user_email="<?php echo $user_email; ?>">
			<td><input type="checkbox" name="xoo-wl-user-ids[]" class="xoo-wl-table-chkbox" value="<?php echo $user_email; ?>"></td>
			<td><?php echo $waitlisted_on; ?></td>
			<td><?php echo esc_attr($user_email); ?></td>
			<td><?php echo $user_qty; ?></td>
			<td><span class="dashicons <?php echo $is_customer; ?>"></span></td>
			<td class="xoo-wl-actions">
				<a class="button xoo-wl-email-btn xoo-wl-act-btn" data-action="email">Send Email</a>
				<a class="button xoo-wl-delete-btn xoo-wl-act-btn" data-action="delete">Delete</a>
			</td>
		</tr>

		<?php endforeach; ?>
	</tbody>
	
</table>

</div>

<?php do_action('xoo_wl_admin_sidebar'); ?>
