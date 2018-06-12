<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Xoo_El_Menu_Settings{

	public function __construct(){
		add_action( 'admin_head-nav-menus.php',array($this,'add_nav_menu_meta_boxes'));
	}


	public function add_nav_menu_meta_boxes() {
		add_meta_box( 'xoo_el_actions_link', __( 'Login/Signup Popup', 'easy-login-woocommerce' ), array( $this, 'nav_menu_links' ), 'nav-menus', 'side', 'low' );
	}


	/**
	 * Output menu links.
	 */
	public function nav_menu_links() {

		$actions = array(
			  array('title' => 'Login','classes' =>'xoo-el-login-tgr'),
			  array('title' => 'Register','classes' =>'xoo-el-reg-tgr'),
			  array('title' => 'Lost Password','classes' =>'xoo-el-lostpw-tgr')
		);

		?>
		<div id="posttype-xoo-el-actions" class="posttypediv">
			<div id="xoo-el-tabs-panel" class="tabs-panel tabs-panel-active">
				<ul id="xoo-el-actions-checklit" class="categorychecklist form-no-clear">
					<?php
					$i = -1;
					foreach ( $actions as $key => $value ) :
						?>
						<li>
							<label class="menu-item-title">
								<input type="checkbox" class="menu-item-checkbox" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-object-id]" value="<?php echo esc_attr( $i ); ?>" /> <?php echo esc_html($value['title'])?>
							</label>
							<input type="hidden" class="menu-item-type" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-type]" value="custom" />
							<input type="hidden" class="menu-item-title" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-title]" value="<?php echo esc_html($value['title'])?>" />
							<input type="hidden" class="menu-item-url" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-url]" />
							<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo esc_attr( $i ); ?>][menu-item-classes]" value="<?php echo esc_html($value['classes'])?>" />
						</li>
						<?php
						$i--;
					endforeach;
					?>
				</ul>
			</div>
			<p class="button-controls">
				<span class="list-controls">
					<a href="<?php echo esc_url( admin_url( 'nav-menus.php?page-tab=all&selectall=1#posttype-xoo-el-actions' ) ); ?>" class="select-all"><?php esc_html_e( 'Select all', 'woocommerce' ); ?></a>
				</span>
				<span class="add-to-menu">
					<span class="spinner"></span>
					<button type="submit" class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to menu', 'woocommerce' ); ?>" name="add-post-type-menu-item" id="submit-posttype-xoo-el-actions"><?php esc_html_e( 'Add to menu', 'woocommerce' ); ?></button>
				</span>
			</p>
		</div>
		<?php
	}
}

new Xoo_El_Menu_Settings();

?>