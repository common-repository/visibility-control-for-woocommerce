<?php
/*
Plugin Name: Visibility Control for WooCommerce
Plugin URI: https://www.nextsoftwaresolutions.com/woocommerce-visibility-control
Description: Control visibility of HTML elements, menus, and other details on your website based on User's access to specific WooCommerce product. Add CSS class: visible_to_product_123 to show the element/menu item to user with access to product or variation with ID 123. Add CSS Class: hidden_to_product_123 to hide the element from user with access to product or variation with ID 123. Add CSS class: visible_to_logged_in to show the element/menu item to a logged in user. Add CSS class: hidden_to_logged_in or visible_to_logged_out to show the element/menu item to a logged out users. More Classes: visible_to_role_administrator, hidden_to_role_administrator. Currently, this will only hide the content using CSS. 
Author: Next Software Solutions
Version: 1.4
Author URI: https://www.nextsoftwaresolutions.com

WC tested up to: 6.5.1

*/

class visibility_control_for_woocommerce {
	function __construct() {		
		add_action("wp_head", array($this, "add_css"));
	
		if(!class_exists('grassblade_addons'))
		require_once(dirname(__FILE__)."/addon_plugins/functions.php");

		add_action( 'admin_menu', array($this,'menu'), 10);
	}

	function menu() {
		global $submenu, $admin_page_hooks;
		$icon = plugin_dir_url(__FILE__)."img/icon-gb.png";

		if(empty( $admin_page_hooks[ "grassblade-lrs-settings" ] )) {
			add_menu_page("GrassBlade", "GrassBlade", "manage_options", "grassblade-lrs-settings", array($this, 'menu_page'), $icon, null);
		}

		add_submenu_page("grassblade-lrs-settings", "Visibility Control for WooCommerce", "Visibility Control for WooCommerce",'manage_options','grassblade-visibility-control-woocommerce', array($this, 'menu_page'));
	}

	function menu_page() {

		if(!current_user_can("manage_options"))
			return;

		$enabled = get_option("visibility_control_for_woocommerce");

		if( !empty($_POST["submit"]) && check_admin_referer('visibility_control_for_woocommerce') ) {
			$enabled = intVal(isset($_POST["visibility_control_for_woocommerce"]));
			update_option("visibility_control_for_woocommerce", $enabled);
		}

		if($enabled === false) {
			$enabled = 1;
			update_option("visibility_control_for_woocommerce", $enabled);
		}

		?>
		<style type="text/css">
			div#visibility_control_for_woocommerce {
				padding: 30px;
				background: white;
				margin: 50px;
				border-radius: 5px;
			}
			div#visibility_control_for_woocommerce input[type=checkbox] {
			    margin-left: 50px;
			}
		</style>
		<style type="text/css">
			div#visibility_control_for_woocommerce {
				padding: 30px;
				background: white;
				margin: 50px;
				border-radius: 5px;
			}
			div#visibility_control_for_woocommerce input[type=checkbox] {
			    margin-left: 50px;
			}
		</style>
		<div id="visibility_control_for_woocommerce" class="wrap">
			<h3>Visibility Control for WooCommerce</h3>
			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
				<?php wp_nonce_field( 'visibility_control_for_woocommerce' ); ?>
				<p style="padding: 20px;"><b><?php _e("Enable"); ?></b> <input name="visibility_control_for_woocommerce" type="checkbox" value="1" <?php if($enabled) echo 'checked="checked"'; ?>> </p>

				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e("Save Changes"); ?>"></p>
			</form>
		</div>
		<?php 
	}
	function add_css() {
		if(!class_exists( 'WooCommerce' ))
			return;

		global $pagenow, $post;

		if( is_admin() && $pagenow == "post.php" ||  is_admin() && $pagenow == "post-new.php" )
			return; //Disable for Edit Pages

		if( !empty($post->ID) ) {
			if( $post->post_type == "page" && current_user_can( 'edit_page', $post->ID ) || $post->post_type != "page" &&  current_user_can( 'edit_post', $post->ID ) ) {
				//User with Edit Access
				if( isset($_GET["elementor-preview"]) || isset($_GET['brizy-edit'])  || isset($_GET['brizy-edit-iframe'])  || isset($_GET['vcv-editable'])   || isset($_GET['vc_editable']) || isset($_GET['fl_builder'])  || isset($_GET['et_fb'])  )
					return; //Specific Front End Editor Pages. Elementor, Brizy Builder, Beaver Builder, Divi, WPBakery Builder, Visual Composer
			}
		}

		$enabled = get_option("visibility_control_for_woocommerce", true);

		if(empty($enabled))
			return;
		
		global $current_user, $wpdb;
		$hidden_classes = array();
		if(!empty($current_user->ID)) { //Logged In
			$hidden_classes[] = ".hidden_to_logged_in";
			$hidden_classes[] = ".visible_to_logged_out";
		}
		else //Logged Out
		{
			$hidden_classes[] = ".hidden_to_logged_out";
			$hidden_classes[] = ".visible_to_logged_in";		
		}

		$roles = wp_roles();
		$role_ids = array_keys($roles->roles);

		foreach($role_ids as $role_id) {
			if( empty($current_user->roles) || !in_array($role_id, $current_user->roles) ) { //User not with Role
				$hidden_classes[] = ".visible_to_role_".$role_id;
			}
			else //Has Role
			{
				$hidden_classes[] = ".hidden_to_role_".$role_id;
			}
		}

		$user_id = empty($current_user->ID)? null:$current_user->ID;

		$paid_statuses = implode(",",array_map(function($val) {return '"wc-'.$val.'"';}, wc_get_is_paid_statuses()));
		$purchased_products_ids = $wpdb->get_col( $wpdb->prepare(
			"
			SELECT      itemmeta.meta_value
			FROM        " . $wpdb->prefix . "woocommerce_order_itemmeta itemmeta
			INNER JOIN  " . $wpdb->prefix . "woocommerce_order_items items
			            ON itemmeta.order_item_id = items.order_item_id
			INNER JOIN  $wpdb->posts orders
			            ON orders.ID = items.order_id
			          	AND orders.post_status IN ($paid_statuses)
			INNER JOIN  $wpdb->postmeta ordermeta
			            ON orders.ID = ordermeta.post_id
			WHERE       itemmeta.meta_key IN ('_product_id', '_variation_id')
						AND itemmeta.meta_value > 0
			            AND ordermeta.meta_key = '_customer_user'
			            AND ordermeta.meta_value = %s
			ORDER BY    orders.post_date DESC
			",
			get_current_user_id()
		) );

		$products_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE post_type IN ('product', 'product_variation')" );

		if(!empty($products_ids))
		foreach ($products_ids as $product_id) {
			$has_access = is_array($purchased_products_ids) && in_array($product_id, $purchased_products_ids);
			if($has_access) {
				$hidden_classes[] = ".hidden_to_product_".$product_id;
			}
			else
			{
				$hidden_classes[] = ".visible_to_product_".$product_id;
			}
		}

		?>
		<style type="text/css" id="visibility_control_for_woocommerce">
			<?php echo implode(", ", $hidden_classes) ?> {
				display: none !important;
			}
		</style>
		<script>
			if (typeof jQuery == "function")
			jQuery(document).ready(function() {
				jQuery(window).on("load", function(e) {
					//<![CDATA[
					var hidden_classes = <?php echo json_encode($hidden_classes); ?>;
					//]]>
					jQuery(hidden_classes.join(",")).remove();
				});
			});
		</script>
		<?php
	}
}

new visibility_control_for_woocommerce();
