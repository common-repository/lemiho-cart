<?php class lemiho_cart_option extends lemiho {
	     function lemiho_page_option() { ?>
              <div class="lemiho-cart-page-option">
              	   <?php wp_enqueue_style('backend.css',plugins_url('/lemiho-cart/asset/backend.css',FALSE)); ?> 
              	     <form action="options.php" method="POST">
              	     	<?php 
              	     	settings_fields("plugin-section");
	            		do_settings_sections("plugin-options");      
	            		submit_button();  ?>
              	     </form>
              	     <?php $lemiho = new lemiho; ?>
              	     <span class="link-lemiho" style="text-align: right;"><?php echo $lemiho->lemiho_version(); ?></span>
              </div>
	     <?php }
	     function lemiho_install_paypal() { ?>
	     	   <div class="lemiho-cart-page-option">
					<?php wp_enqueue_style('backend.css',plugins_url('/lemiho-cart/asset/backend.css',FALSE)); ?> 
              	     <form action="options.php" method="POST">
              	     	<?php 
              	     	settings_fields("plugin-section-paypal");
	            		do_settings_sections("plugin-options-paypal");      
	            		submit_button();  ?>
              	     </form>
              	     <?php $lemiho = new lemiho; ?>
              	     <span class="link-lemiho" style="text-align: right;"><?php echo $lemiho->lemiho_version(); ?></span>
              </div>
	     <?php }
	     function add_cart_option() {
	     	   add_menu_page("Product settings", "Product settings", "manage_options", "lemiho-plugin-panel", array("lemiho_cart_option","lemiho_page_option"), 'dashicons-store', 99);
	     	   // sub
	     	   add_submenu_page("lemiho-plugin-panel","Install paypal", "Install paypal", "manage_options", "plugin-panel-paypal", array("lemiho_cart_option","lemiho_install_paypal"), null, 99);
	     }
	     function text_button_cart() { ?>
	     	<input type="text" name="text_button_add_to_cart" id="text_button_add_to_cart" class="lemiho-input" value="<?php echo esc_html(get_option('text_button_add_to_cart')); ?>"/>
   <?php }
	     function unit_bill() { ?>
	     	<select name="text_unit_bill" id="text_unit_bill" class="lemiho-input">
	     		   <option <?php if(esc_html(get_option('text_unit_bill')) == "USD" ) echo 'selected="selected"'; ?> value="USD">USD</option>
	     	</select>
	<?php     }
	     function select_checkout_page() { $page = get_pages(); ?>
	     	<select name="checkout_page" class="lemiho-input">
	     		<?php foreach($page as $action ) { ?>
	     				<option <?php if(esc_html(get_option('checkout_page')) == esc_html($action->ID)) echo 'selected="selected"'; ?> value="<?php echo esc_html($action->ID); ?>"><?php echo esc_html($action->post_title); ?></option>
	     		<?php } ?>
	     	</select>
	<?php     }
	function select_thanks_page() { $page = get_pages(); ?>
	     	<select name="thanks_page" class="lemiho-input">
	     		<?php foreach($page as $action ) { ?>
	     				<option <?php if(esc_html(get_option('thanks_page')) == esc_html($action->ID)) echo 'selected="selected"'; ?> value="<?php echo esc_html($action->ID); ?>"><?php echo esc_html($action->post_title); ?></option>
	     		<?php } ?>
	     	</select>
	<?php     }
	function select_style_moule() { ?>
			<input style="height: 40px;" type="color" name="lemiho_style" value="<?php echo esc_html(get_option('lemiho_style')); ?>">
	<?php }
	function add_cod() { ?>
			<input style="height: 40px;" type="number" name="cod" value="<?php echo esc_html(get_option('cod')); ?>">
	<?php }
	function hotline_buy_now() { ?>
			<input style="height: 40px;" type="number" name="hotline_buy" value="<?php echo esc_html(get_option('hotline_buy')); ?>">
	<?php }
	function show_field_option() {
	     	    add_settings_section("plugin-section", "<h1 class='title-page-product-setting'>Lemiho Settings</h1>", null, "plugin-options");
				add_settings_field("text_button_add_to_cart", "Text button", array("lemiho_cart_option","text_button_cart"), "plugin-options", "plugin-section");
				add_settings_field("text_unit_bill", "Text unit bill", array("lemiho_cart_option","unit_bill"), "plugin-options", "plugin-section");
				add_settings_field("checkout_page", "Checkout page", array("lemiho_cart_option","select_checkout_page"), "plugin-options", "plugin-section");
				add_settings_field("thanks_page", "Thanks page", array("lemiho_cart_option","select_thanks_page"), "plugin-options", "plugin-section");
				add_settings_field("lemiho_style", "Lemiho style", array("lemiho_cart_option","select_style_moule"), "plugin-options", "plugin-section");
				add_settings_field("hotline_buy", "Hotline buy", array("lemiho_cart_option","hotline_buy_now"), "plugin-options", "plugin-section");
				add_settings_field("cod", "Add cod($)", array("lemiho_cart_option","add_cod"), "plugin-options", "plugin-section");
			    register_setting("plugin-section", "text_button_add_to_cart");
			    register_setting("plugin-section", "text_unit_bill");
			    register_setting("plugin-section", "checkout_page");
			    register_setting("plugin-section", "thanks_page");
			    register_setting("plugin-section", "lemiho_style");
			    register_setting("plugin-section", "cod");
			    register_setting("plugin-section", "hotline_buy");
	}
	/**
	  @ =========================    INSTALL PAYPAL     =================
	**/
	function email_paypal() { ?>
	    <input type="email" name="text_email_paypal" id="text_email_paypal" class="lemiho-input" placeholder="Email paypal" value="<?php echo esc_html(get_option('text_email_paypal')); ?>">
	<?php }  
	function price_ship() { ?>
	    <input minlength="0" type="number" name="text_price_ship" id="text_price_ship" class="lemiho-input" placeholder="Price ship" value="<?php echo esc_html(get_option('text_price_ship')); ?>">
	<?php }
	function price_tax() { ?>
	    <input minlength="0" type="number" name="text_price_tax" id="text_price_tax" class="lemiho-input" placeholder="Price tax" value="<?php echo esc_html(get_option('text_price_tax')); ?>">
	<?php }
	function show_field_paypal() {
      		   add_settings_section("plugin-section-paypal", "<h1 class='title-page-product-setting'>Lemiho install paypal </h1>", null, "plugin-options-paypal");
      		   // create title 
      		    add_settings_field("text_email_paypal", "Email paypal", array("lemiho_cart_option","email_paypal"), "plugin-options-paypal", "plugin-section-paypal");
      		    // create title 
      		    add_settings_field("text_price_ship", "Price ship ($) ", array("lemiho_cart_option","price_ship"), "plugin-options-paypal", "plugin-section-paypal");
      		    // create title 
      		    add_settings_field("text_price_tax", "Price tax ($) ", array("lemiho_cart_option","price_tax"), "plugin-options-paypal", "plugin-section-paypal");
      		    // register text email paypal
      		    register_setting("plugin-section-paypal", "text_email_paypal");
      		    // register text email paypal
      		    register_setting("plugin-section-paypal", "text_price_ship");
      		    // register text email paypal
      		    register_setting("plugin-section-paypal", "text_price_tax");
	}
}
// lemiho settings
add_action("admin_menu", array("lemiho_cart_option","add_cart_option"));
add_action("admin_init",array("lemiho_cart_option","show_field_option"));
// install paypal
add_action("admin_init",array("lemiho_cart_option","show_field_paypal"));



