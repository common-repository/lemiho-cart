<?php class lemiho_coupon extends lemiho {
            function lemiho_install_coupon_to_order() {
                   if(isset($_POST['submit'])) {
                        if(!empty($_POST['coupon'])) {
                            global $wpdb;
                            $code = sanitize_text_field($_POST['coupon']);
                            $numrows = $wpdb->get_var("SELECT * FROM lemiho_coupon WHERE code='$code'");
                            if($numrows >= 1 ) {
                                        $result = $wpdb->get_row("SELECT * FROM lemiho_coupon WHERE code='$code'");
                                        $down = $result->down;
                                        $_SESSION['lemiho_coupon'] = $down;
                                        $new_total_price = $_SESSION['total_price'] * $down / 100;
                                        $_SESSION['lemiho_apply_coupon'] = $new_total_price;
                            }
                        }
                   }
            }
            function lemiho_create_code_coupon() {
                    $length = 8;
                    $characters = '1234567890zxcvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIOP';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
            }
            function create_new_coupon($URI) {
                     $__coupon = '';
                     if(!empty($_GET['lemiho_down'])) {
                        if(!is_array($_GET['lemiho_down'])) {
                           if(is_numeric($_GET['lemiho_down'])) {
                                  if($_GET['lemiho_down'] >= 1 ) {
                                        $lemiho = new lemiho;
                                        $code = $this->lemiho_create_code_coupon();
                                        $down = sanitize_text_field($_GET['lemiho_down']);
                                        global $wpdb;
                                        $SQL = $wpdb->query("INSERT INTO lemiho_coupon (code,down) VALUES('$code','$down')");
                                        ?>
                                        <script>
                                                window.location.replace("<?php echo $URI; ?>");
                                        </script>
                                        <?php
                                  }
                           }
                        }
                     } else {
                            return $__coupon;
                     }
            }
            function lemiho_delete_coupon($URI_CALLBACK_DELETE) {
                $coupon = '';
                if(!empty($_GET['lemiho_coupon_id'])) {
                    if(!is_array($_GET['lemiho_coupon_id'])) {
                        if(is_numeric($_GET['lemiho_coupon_id'])) {
                            if($_GET['lemiho_coupon_id'] >= 1 ) {
                                $ID = $_GET['lemiho_coupon_id'];
                                global $wpdb;
                                $SQL_DL = $wpdb->query($wpdb->prepare("DELETE FROM lemiho_coupon WHERE ID=%d",$ID));
                                ?>
                                  <script>
                                          window.location.replace("<?php echo $URI_CALLBACK_DELETE; ?>");
                                  </script>
                                <?php
                            }
                        }
                    }
                } else {
                    return $coupon;
                }
            }
            function lemiho_coupon_page() { 
                // create new coupon
                $___coupon = new lemiho_coupon;
                if(!empty($_SERVER['HTTPS'])) {
					$request = 'https://' . $_SERVER['HTTP_HOST']; 
				} else {
					$request = 'http://' . $_SERVER['HTTP_HOST']; 
				} 
				$URI = $request . $_SERVER['PHP_SELF'] . '?page=' . $_GET['page']; 
                $___coupon->create_new_coupon($URI);
                // delete 
                $URI_CALLBACK_DELETE = $request . $_SERVER['PHP_SELF'] . '?page=' . $_GET['page'] . '&lemiho_delete=success'; 
                $___coupon->lemiho_delete_coupon($URI_CALLBACK_DELETE);
                // page
            ?>
                <div class="lemiho-cart-page-option">
					<?php wp_enqueue_style('backend.css',plugins_url('/lemiho-cart/asset/backend.css',FALSE)); ?> 
              	     <h1 class='title-page-product-setting'>Manage Coupon Tool </h1> 
                     <?php // callback // ?>
                     <?php if(!empty($_GET['lemiho_delete'])) {
								if($_GET['lemiho_delete'] == 'success') {
									if(!is_array($_GET['lemiho_delete'])) { ?>
										</br>
										 <div style="width: 98%;background: green; padding: 1%;" class="lemiho_callback">
										 	<p style="font-size: 15px; color: white;line-height: 10px;"> Delete Success </p>
										 </div> 
										</br>	
								   <?php }
								}
					  }
                      // Big Box 
                       ?>  
                     <div style="width: 100%;display: inline-block;margin: 20px 0px;" class="lemiho-add-coupon">  
                        <form method="GET">
                            <label> SALE (%) </label>
                            <input type="number" class="lemiho-input" name="lemiho_down" placeholder="Reduce how much money ? ">
                            <input type="hidden" name="page" value="<?php echo esc_html($_GET['page']); ?>"/> 
                            <button style="padding: 5px 10px;background: rgb(92, 130, 41);color: white;"> Create new a coupon </button>
                        </form>  
                     </div>   
                     <div class="lemiho-box-list-item-coupon">
                                  <?php 
                                  global $wpdb;
                                  $sql = $wpdb->get_results("SELECT * FROM lemiho_coupon");
                                      echo '<ul class="lemiho-group-coupon">';
                                      foreach($sql as $item_result ) { ?>
                                        <li style="margin: 10px 0px;border-bottom:1px solid #ccc;padding:10px 0px;">
                                        <?php echo esc_html($item_result->code) . ' | ' . esc_html($item_result->down) . '%'; ?>
                                            <form method="GET">
                                             <input type="hidden" name="page" value="<?php echo esc_html($_GET['page']); ?>"/> 
                                             <input type="hidden" name="lemiho_coupon_id" value="<?php echo esc_html($item_result->ID); ?>">
                                             <button style="float: right;margin-top: -20px;"> Remove </button>   
                                            </form>
                                        </li>
                                      <?php }
                                      echo '</ul>'; ?>
                     </div>
              	     <?php $lemiho = new lemiho; ?>
              	     <span class="link-lemiho" style="text-align: right;"><?php echo $lemiho->lemiho_version(); ?></span>
               </div>
            <?php }
            function lemiho_coupon_menu_page() {
                add_submenu_page("lemiho-plugin-panel","Lemiho coupon", "Lemiho coupon", "manage_options", "lemiho-coupon", array("lemiho_coupon","lemiho_coupon_page"), null, 99);
            }
}
add_action("admin_menu",array("lemiho_coupon","lemiho_coupon_menu_page"));