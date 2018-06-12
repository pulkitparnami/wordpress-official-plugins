<?php

//Exit if accessed directly
if(!defined('ABSPATH')){
	return; 	
}

?>

<?php

//Get Waitlisted products

$args = array(
	'post_type'  => array('product','product_variation'),
	'meta_key' 	 => '_xoo-wl-users',
	'posts_per_page' => -1
);

$query = new WP_Query( $args );

?>

<div class="xoo-wl-main">

<h2>Waitlist</h2>

<span class="xoo-wl-table-notice"></span>

<table id="xoo-wl-products" class="display xoo-wl-table" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
			<th>Image</th>
			<th>Product</th>
			<th>Stock Status</th>
			<th>No. of users</th>
			<th>Action</th>
		</tr>
	</thead>

	<tbody>
		<?php 
		if($query->have_posts()):
		while ( $query->have_posts() ) : $query->the_post();
			global $product;

			$product_id 	= $product->get_id();

			$total_users = count(json_decode(get_post_meta($product_id,'_xoo-wl-users',true),true));
			if($total_users === 0) continue;

			$product_link 	= $product->is_type('variation') ? get_edit_post_link($product->get_parent_id()) : get_edit_post_link($product_id);
			$product_image  = $product->get_image('shop_thumbnail');

			$product_title  = $product->get_title();
			$product_title .= $product->is_type('variation') ? wc_get_formatted_variation($product) : '';

			$stock_status   = $product->get_stock_status();
			$stock_class = $stock_status == 'outofstock' ? 'xoo-wl-outofstock' : 'xoo-wl-instock';

			$view_users_link = $_SERVER['REQUEST_URI'].'&product_id='.$product_id;
		?>

		<tr data-product_id="<?php echo $product_id; ?>">

			<td><input type="checkbox" name="xoo-wl-product-ids[]" class="xoo-wl-table-chkbox" value="<?php echo $product_id; ?>"></td>

			<td class="xoo-wl-pimg">
				<a href="<?php echo $product_link; ?>" target="_blank"><?php echo $product_image; ?></a>
			</td>

			<td>
				<a href="<?php echo $product_link; ?>" target="_blank"><?php echo $product_title; ?></a>
			</td>

			<td>
				<span class="<?php echo $stock_class; ?>"><?php echo $stock_status; ?></span>	
			</td>

			<td>
				<?php echo $total_users; ?>
			</td>

			<td class="xoo-wl-actions">
				<a href="<?php echo $view_users_link; ?>" class="button-secondary">View</a>
				<a class="button xoo-wl-email-btn xoo-wl-act-btn" data-action="email">Send Email</a>
				<a class="button xoo-wl-delete-btn xoo-wl-act-btn" data-action="delete">Delete Users</a>
			</td>

		</tr>

		<?php endwhile; ?>
		<?php endif; ?>

	</tbody>
</table>

</div>

<?php do_action('xoo_wl_admin_sidebar'); ?>