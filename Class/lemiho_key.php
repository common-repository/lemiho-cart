<?php class lemiho_key extends lemiho {
             function lemiho_key_page() { ?>
                    <div class="lemiho-cart-page-option">
                        <?php wp_enqueue_style('backend.css',plugins_url('/lemiho-cart/asset/backend.css',FALSE)); ?> 
                            <form action="options.php" method="POST">
                                <?php 
                                settings_fields("section-lemiho-key");
                                do_settings_sections("options-lemiho-key");      
                                submit_button();  ?>
                            </form>
                            <?php $token = 'adSewQrTfFdDadfnadkfW1m2n4n56k4j'; ?>
                            <?php if($token != esc_html(get_option('text_lemiho_key_input'))) { ?>
                                <div class="lemiho-key-buy-now" style="position: absolute;width: 98%;background: rgba(0, 0, 0, 0.53);height: 80%;top: 0px;text-align: center;">
                                    <a target="blank" href="http://lemiho.thietkewebphp.org"> <button style="padding: 20px;margin-top: 150px;background: #650606;color: white;"> Buy now </button> </a>
                                </div>
                             <?php }  ?>
                            <?php $lemiho = new lemiho; ?>
                            <?php if($token != esc_html(get_option('text_lemiho_key_input'))) { ?>
                                <span class="link-lemiho" style="text-align: right;"><?php echo $lemiho->lemiho_version() . ' - Key not success'; ?></span>
                            <?php } else { ?>
                                <span class="link-lemiho" style="text-align: right;"><?php echo $lemiho->lemiho_version() . ' - Key success'; ?></span>
                            <?php  } ?>
                            
                    </div>
             <?php }
            /**
             =================  R E G I S T E R === F I E L D ===========
             **/
             function lemiho_key_input() { ?>
                  <input style="z-index: 1000;position: relative;" type="text" name="text_lemiho_key_input" id="text_lemiho_key_input" class="text_lemiho_key_input" placeholder="Lemiho key" value="<?php echo esc_html(get_option('text_lemiho_key_input')); ?>">
             <?php }
             function lemiho_key_payment_method_cod() {
                 // show payment method cod ?>
                 <input type="checkbox" <?php if(esc_html(get_option('checkbox_lemiho_key_payment_method_cod')) == true ) echo 'checked'; ?> name="checkbox_lemiho_key_payment_method_cod" id="checkbox_lemiho_key_payment_method_cod" value="true"/> Show COD payment  
             <?php }
             function lemiho_key_payment_method_paypal() {
                 // show payment method cod ?>
                 <input type="checkbox" <?php if(esc_html(get_option('checkbox_lemiho_key_payment_method_paypal')) == true ) echo 'checked'; ?> name="checkbox_lemiho_key_payment_method_paypal" id="checkbox_lemiho_key_payment_method_paypal" value="true"/> Show paypal payment  
             <?php }
             function lemiho_key_payment_method_at_store() {
                 // show payment method cod ?>
                 <input type="checkbox" <?php if(esc_html(get_option('checkbox_lemiho_key_payment_method_at_store')) == true ) echo 'checked'; ?> name="checkbox_lemiho_key_payment_method_at_store" id="checkbox_lemiho_key_payment_method_at_store" value="true"/> Show At the store payment  
             <?php  }
             function lemiho_key_option_mini_cart() {
                 // show and hide mini cart  
             }
             /**
             ============= E N D ====  R E G I S T E R === F I E L D ===========
             **/
             // register submenu lemiho_key 
             function add_submenu_page_lemiho() {
                    add_submenu_page('lemiho-plugin-panel','Lemiho key','Lemiho key','manage_options','lemiho-key',array('lemiho_key','lemiho_key_page'),null,99);
             }
            function show_field_key() {
                    add_settings_section("section-lemiho-key", "<h1 class='title-page-product-setting'> Lemiho key </h1>", null, "options-lemiho-key");
                    // input key
                    add_settings_field("text_lemiho_key_input", "Insert key", array("lemiho_key","lemiho_key_input"), "options-lemiho-key", "section-lemiho-key");
                    register_setting("section-lemiho-key", "text_lemiho_key_input");
                    // select payment methods COD
                    add_settings_field("checkbox_lemiho_key_payment_method_cod", "Payment COD", array("lemiho_key","lemiho_key_payment_method_cod"), "options-lemiho-key", "section-lemiho-key");
                    register_setting("section-lemiho-key", "checkbox_lemiho_key_payment_method_cod");
                    // select payment methods PP 
                    add_settings_field("checkbox_lemiho_key_payment_method_paypal", "Payment Paypal", array("lemiho_key","lemiho_key_payment_method_paypal"), "options-lemiho-key", "section-lemiho-key");
                    register_setting("section-lemiho-key", "checkbox_lemiho_key_payment_method_paypal");
                    // select payment methods PP 
                    add_settings_field("checkbox_lemiho_key_payment_method_at_store", "Payment at the store", array("lemiho_key","lemiho_key_payment_method_at_store"), "options-lemiho-key", "section-lemiho-key");
                    register_setting("section-lemiho-key", "checkbox_lemiho_key_payment_method_at_store");
            }
} 
add_action('admin_menu',array('lemiho_key','add_submenu_page_lemiho'));
add_action("admin_init",array("lemiho_key","show_field_key"));