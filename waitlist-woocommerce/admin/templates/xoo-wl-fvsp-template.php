<div class="xoo-prem">
	<div class="xoo-hero-btns">
		<a class="buy-prem button button-primary button-hero" href="http://demo.xootix.com/waitlist-for-woocommerce/">LIVE DEMO</a>
		<a class="live-demo button button-primary button-hero" href="http://xootix.com/plugins/waitlist-for-woocommerce/">BUY PREMIUM - 14$</a>
	</div>
	<!-- Free V/s Premium -->
	<div class="xoo-fvsp">
		<span class="xoo-fvsp-head">Free V/s Premium</span>

		<?php

		$table_content = array(
			array('Track users list','yes','yes'),
			array('Auto send email','yes','yes'),
			array('Keep waiting list after sending the email','no','yes','alert'),
			array('Admin notification (Email) on joining waitlist','no','yes','alert'),
			array('Google Recaptcha  - Protect spam from bots','no','yes','alert'),
			array('Customize email content','no','yes','alert'),
			array('Email styling options','no','yes','alert'),
			array('Edit Waitlist form fields text','no','yes'),
			array('Includes Email footer (For address , contact info etc)','no','yes'),
		);

		?>

		<table class="xoo-fvsp-table">
			<thead>
				<tr>
					<th></th>
					<th>Free</th>
					<th>Premium<br><span>(No time limit)</span></th>
				</tr>
			</thead>

			<tbody>
				<?php 
					$html = '';
					foreach ($table_content as $table_row) {
						$html .= '<tr>';
						$alert = isset($table_row[3]) ? 'class=xfp-alert' : '';
						$html .= '<td '.$alert.'>'.$table_row[0].'</td>';
						$html .= '<td class="xfp-'.$table_row[1].'"><span class="dashicons dashicons-'.$table_row[1].'"></span></td>';
						$html .= '<td class="xfp-'.$table_row[2].'"><span class="dashicons dashicons-'.$table_row[2].'"></span></td>';
						$html .= '</tr>';
					}

					echo $html;
				?>
			</tbody>

		</table>

	</div>


	<div class="prem-images">
		<h3>Premium Options</h3>
		<img src="<?php echo XOO_WL_URL.'/admin/assets/images/1.png'?>">
		<img src="<?php echo XOO_WL_URL.'/admin/assets/images/2.png'?>">
		<img src="<?php echo XOO_WL_URL.'/admin/assets/images/3.png'?>">
		<img src="<?php echo XOO_WL_URL.'/admin/assets/images/4.png'?>">
		<img src="<?php echo XOO_WL_URL.'/admin/assets/images/5.png'?>">
	</div>
</div>	