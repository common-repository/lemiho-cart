<?php class lemiho {
                 function __construct() {

                 }
                 function lemiho_version() {
                      $version = "";
                      $version .= "Lemiho cart version 2.7.2";
                      return $version;
                 }
                 function lemiho_xss_clean($string) {
                   $string = str_replace("<","", $string );
                   $string = str_replace(">","", $string );
                   $string = str_replace("'","", $string );
                   $string = str_replace("?","", $string );
                   $string = str_replace("/","", $string );
                   $string = str_replace(")","", $string );
                   $string = str_replace("(","", $string );
                   return $string;
                 }
                 function check_exists_product($id) {
                      $check = get_post_meta($id, 'price_product', true );
                      if(!empty($check)) {
                        $check = 1;
                        return $check;
                      } else {
                        return FALSE;
                      }
                 }
                 function lemiho_token() {
                    $length = 10;
                    $characters = '123456789123456789123456789123456789123456789123456789123456789';
                    $charactersLength = strlen($characters);
                    $randomString = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomString .= $characters[rand(0, $charactersLength - 1)];
                    }
                    return $randomString;
                 }
                 function format_number($number) {
                       $format = 3;
                       $price = '';
                       $price .= number_format($number,$format,'.','.');
                       return $price;
                 }
                 function get_price_product($id) {
                        $product_price = '';
                        $get_price = get_post_meta( $id, 'price_product', true );
                        // get all price nomal
                        $before_show = $this->format_number($get_price);
                        // trim .000
                        $product_price = str_replace(".000","",$before_show);
                        //show
                        return $product_price;
                 }
                 function register_my_session(){
                    if( !session_id() ){
                      session_start();
                    }
                    if(!is_array($_SESSION['cart'])) {
                         // register cart empty
                         $_SESSION['cart'] = array();
                         // total price
                         $_SESSION['total_price'] = '';
                         $_SESSION['total_qty'] = 0;
                    }
                 }
                 /**
                   @        Module cart of plugin 
                 **/  
                 function add_to_cart() {
                       //$this->register_my_session();
                       if(!empty($_GET['add_to_cart'])) {
                            $id = $_GET['add_to_cart'];
                           $__check = $this->check_exists_product($id);
                           if($__check == 1) {
                                 $get_post = get_post($id);
                                 if(!empty($_SESSION['cart'][$id])) {
                                    // get ss
                                    $get_ss = $_SESSION['cart'][$id];
                                    // qty product
                                    $newqty = $get_ss['qty'] + 1;
                                    // price product
                                    $price = get_post_meta( $id, 'price_product', true );
                                    // price * qty = total price
                                    $new_price =  $price * $newqty;
                                    $cart = array(
                                          'product_rowid' => $_GET['add_to_cart'],
                                          'product_title' => $get_post->post_title,
                                          'product_thumb' => get_the_post_thumbnail($id,'thumbnail'),
                                          'product_price' => $new_price,
                                          'qty'           => $newqty
                                    );
                                 } else {
                                    $cart = array(
                                          'product_rowid' => $_GET['add_to_cart'],
                                          'product_title' => $get_post->post_title,
                                          'product_thumb' => get_the_post_thumbnail($id,'thumbnail'),
                                          'product_price' => get_post_meta( $id, 'price_product', true ),
                                          'qty'           => 1
                                    );   
                                 }
                                 // update total price
                                 $price = get_post_meta( $id, 'price_product', true );
                                 $new_total_price = $_SESSION['total_price'] + $price;  
                                 // update total qty
                                 $__qty = $_SESSION['total_qty'] + 1;
                                 // insert product to cart
                                 $_SESSION['cart'][$id] = $cart;
                                 $_SESSION['total_price'] = $new_total_price;
                                 $_SESSION['total_qty'] = $__qty;

                           }
                       }
                 }
                 function single_add_product() {
                       $id = $_GET['id_product'];
                       if(!empty($_GET['qty']) & !empty($_GET['id_product'])) {
                          if(is_numeric($_GET['qty']) & is_numeric($_GET['id_product'])) {
                               if($_GET['qty'] >= 1 & $_GET['id_product'] > 1 ) {
                                    if(!is_array($_GET['qty']) & !is_array($_GET['id_product'])) {
                                        $__check = $this->check_exists_product($id); 
                                        if(!empty($__check)) {
                                             $id = $_GET['id_product'];
                                             if(empty($_SESSION['cart'][$id])) {
                                                     $get_post = get_post($id);
                                                     $cart = array(
                                                            'product_rowid' => $_GET['add_to_cart'],
                                                            'product_title' => $get_post->post_title,
                                                            'product_thumb' => get_the_post_thumbnail($id,'thumbnail'),
                                                            'product_price' => get_post_meta( $id, 'price_product', true ),
                                                            'qty'           => sanitize_text_field($_GET['qty'])
                                                      );
                                                     $price = $cart['product_price'] * $cart['qty'];
                                                     $price_update = $_SESSION['total_price'] + $price;
                                                     $total_qty_update = $_SESSION['total_qty'] + $cart['qty'];
                                                     // update
                                                     $_SESSION['cart'][$id] = $cart;
                                                     $_SESSION['total_price'] = $price_update;
                                                     $_SESSION['total_qty'] = $total_qty_update;
                                             } // check exists product on cart
                                        } // check exists
                                    }
                               } // check number ++
                          } // check number
                       }   // check value     
                 }
                 function total_price() {
                      if(!empty($_SESSION['total_price'])) {
                        $total_price = $this->format_number($_SESSION['total_price']);
                        $product_price = str_replace(".000","",$total_price);
                      } else {
                        $product_price = 0;
                      }
                      return $product_price;
                 }
                 function remove_product_on_cart() {
                      if(!empty($_GET['remove_product_id'])) {
                          if(is_numeric($_GET['remove_product_id'])) {
                             $id = $_GET['remove_product_id'];
                             if(!empty($_SESSION['cart'][$id])) { 
                                // update cart 
                                $get = $_SESSION['cart'][$id];  
                                $product_price = esc_attr(get_post_meta( $id, 'price_product', true ));
                                // get 
                                $price = $product_price * $get['qty'];
                                $old_total_price = $_SESSION['total_price'];
                                $price_update = $old_total_price - $price; 
                                // update qty
                                $qty_update = $_SESSION['total_qty'] - $get['qty'];
                                $_SESSION['total_price'] = $price_update;
                                $_SESSION['total_qty']   = $qty_update; 
                                // unset session
                                unset($_SESSION['cart'][$id]);
                             }
                          }
                      }
                 }
                 function update_cart() {
                      if(!empty($_GET['qty']) & !empty($_GET['id_product'])) {
                          if(is_numeric($_GET['qty']) & is_numeric($_GET['id_product'])) {
                               if(!is_array($_GET['qty']) & !is_array($_GET['id_product'])) {
                                      if($_GET['qty'] >= 1 & $_GET['id_product'] > 1 ) {
                                         $id = sanitize_text_field($_GET['id_product']);
                                         $get_post = get_post($id);
                                         if(!empty($_SESSION['cart'][$id])) {
                                              // get on session array
                                              $__get = $_SESSION['cart'][$id];
                                              // check total qty update
                                              $check = sanitize_text_field($_GET['qty']) - $__get['qty'];
                                              if($check > 0 ) {
                                                // add to total price session  array
                                                // update session total qty array
                                                $new_qty_ready = $_GET['qty'];
                                                $__price = esc_attr(get_post_meta( $id, 'price_product', true ));
                                                $new_price_ready = $__price * $check;
                                                // update session cart
                                                $new_qty_ready_update = $_SESSION['total_qty'] + $check;
                                                $new_total_price_ready_update = $_SESSION['total_price'] + $new_price_ready;
                                              } else if($check == 0 ) {
                                                // no update 
                                                $new_qty_ready_update = $_SESSION['total_qty'];
                                                $new_total_price_ready_update = $_SESSION['total_price'];
                                              } else if($check < 0 ) {
                                                $down = $__get['qty'] - $_GET['qty'];
                                                $__price = get_post_meta( $id, 'price_product', true );
                                                $new_price_ready = $down * $__price;
                                                // update session cart
                                                $new_qty_ready_update = $_SESSION['total_qty'] - $down;
                                                $new_total_price_ready_update = $_SESSION['total_price'] - $new_price_ready;
                                              }
                                              $array = array(
                                                      'product_rowid' => $id,
                                                      'product_title'  => $get_post->post_title,
                                                      'product_thumb'  => get_the_post_thumbnail($id,'thumbnail'),
                                                      'product_price'  => get_post_meta( $id, 'price_product', true ),
                                                      'qty'            => sanitize_text_field($_GET['qty'])
                                              );
                                              $_SESSION['cart'][$id] = $array;
                                              $_SESSION['total_price'] = $new_total_price_ready_update;
                                              $_SESSION['total_qty'] = $new_qty_ready_update;
                                              
                                         } // session id
                                     } // number > true
                               }// end is array
                          } // end is numberic
                      } else {
                        return false;
                      }
                 }
                 function clearn_cart() {
                      unset($_SESSION['cart']);
                 }
                 function clearn_cart_old() {
                      unset($_SESSION['lemiho_apply_coupon']);
                 }
                 function mail_order_marketing($fullname,$address,$postcode,$email,$hotline,$message,$payment_methods) {
                    $output = '';
                      $output .= '<div class="lemiho-box-marketing-email" style="width: 100%;display: inline-block;background: #333;padding: 50px 0px;">';
                         $output .= '<div class="lemiho-main-box-marketing-email" style=" width: 680px;margin: auto;padding: 5px;border: 1px solid #1a1a1a;background: white;">';
                              $output .= '<div class="lemiho-main-box-header" style="background: black;padding: 5px;">';
                                $base = home_url();
                                  $output .= '<a target="blank" href="' . $base . '">';
                                      $output .= '<h3 style="color: white;"> Mail order </h3>';
                                  $output .= '</a>';
                              $output .= '</div>'; // end header
                             /**
                               @ ==========        Body   ========  @
                              **/
                              $output .= '<div class="lemiho-main-box-body">';
                                // desc head
                                $desc = 'Dear customer ! This ‘s products selected for you . Visit website : <a href="' . $base . '">' . 'Go to site' . '</a><br/> Or copy link ' . $base;
                                $output .= '<p>' . $desc . '</p>';
                                    // add price ship if selected  
                                        // if use coupon 
                                        if(empty($_GET['lemiho_coupon'])) {
                                            // not coupon
                                            if($payment_methods == 'Payment laster') {
                                              $old_session = $_SESSION['total_price'] + get_option('cod');
                                              $_SESSION['total_price'] = $old_session; 
                                              $output .= '<h4 style="color: red;font-weight: bold;"> Total price : ' . $this->total_price() . ' ' . get_option('text_unit_bill') . '</h4>';
                                            } else {
                                              $output .= '<h4 style="color: red;font-weight: bold;"> Total price : ' . $this->total_price() . ' ' . get_option('text_unit_bill') . '</h4>';
                                            }
                                        } else {
                                           // has coupon 
                                           if($payment_methods == 'Payment laster') {
                                              $old_session = $_SESSION['total_price'] + get_option('cod');
                                              $_SESSION['total_price'] = $old_session; 
                                              // use cupon 
                                              $____coupon =  $_SESSION['total_price'] - $_SESSION['lemiho_apply_coupon'];
                                              $output .= '<h4 style="color: red;font-weight: bold;text-decoration: line-through;"> Total price : ' . $this->total_price() . ' ' . get_option('text_unit_bill') . '</h4>';
                                              $output .= '<h4 style="color: red;font-weight: bold;">' . $____coupon . ' ' . get_option('text_unit_bill') . '</h4>'; 
                                            } else {
                                              $____coupon =  $_SESSION['total_price'] - $_SESSION['lemiho_apply_coupon'];
                                              $output .= '<h4 style="color: red;font-weight: bold;text-decoration: line-through;"> Total price : ' . $this->total_price() . ' ' . get_option('text_unit_bill') . '</h4>';
                                              $output .= '<h4 style="color: red;font-weight: bold;">' . $____coupon . ' ' . get_option('text_unit_bill') . '</h4>'; 
                                            }
                                        }
                                    // table 
                                        $output .= '<div class="lemiho-table-email" style="width: 100%;">';
                                              $output .= '<table class="lemiho-box-table-email" style="width: 600px;">';
                                                 // header table 
                                                  $output .= '<tr>';
                                                      $output .= '<th style="border:1px solid #ccc;text-align: center;width: 200px;"> Title </th>';
                                                      $output .= '<th style="border:1px solid #ccc;text-align: center; width: 100px;"> Thumb </th>';
                                                      $output .= '<th style="border:1px solid #ccc;text-align: center;" width: 100px;> Qty </th>';
                                                      $output .= "<th style='border:1px solid #ccc;text-align: center;width: 200px;' > Price(" . get_option('text_unit_bill') . ") </th>";
                                                  $output .= '</tr>';
                                                  // end header table
                                                  foreach($_SESSION['cart'] as $action ) {
                                                       // foreach
                                                        $output .= '<tr>';
                                                            $output .= '<td style="border:1px solid #ccc;text-align: center;width: 200px;"><a style="color: #5e5e5e;" target="blank" href="' . get_permalink($action['product_rowid']) .'">' . $action['product_title'] . '</a></td>';
                                                            $output .= '<td style="border:1px solid #ccc;text-align: center;width: 100px;"><a target="blank" href="' . get_permalink($action['product_rowid']) .'">' . $action['product_thumb'] . '</a></td>';
                                                            $output .= '<td style="border:1px solid #ccc;text-align: center;width: 100px;">' . $action['qty'] . '</td>';
                                                            $get_price = $this->get_price_product($action['product_rowid']);
                                                            $output .= '<td style="border:1px solid #ccc;text-align: center;width: 200px;">' . $get_price . '</td>';
                                                        $output .= '</tr>';
                                                        // end foreach
                                                  }
                                              $output .= '</table>'; 
                                        $output .= '</div>';
                                     // end table 
                                     // start customer info 
                                        // info customer
                                          $customer = array(
                                                  'id_order' => 'ID Order : ' . esc_attr($_SESSION['id_order']),
                                                  'fullname' => 'Name customer : ' . esc_attr($fullname),
                                                  'email'    => 'Email custommer : ' . esc_attr($email),
                                                  'address'  => 'Address customer : ' . esc_attr($address),
                                                  'hotline'  => 'Number fone customer : ' . esc_attr($hotline),
                                                  'postcode' => 'Postcode customer : ' . esc_attr($postcode),
                                                  'message'  => 'Message customer : ' . esc_attr($message),
                                                  'payment_methods' => 'Select pay : ' . esc_attr($payment_methods)
                                            ); 
                                          // output customer
                                          $output .= '<p>' . $customer['id_order'] . '</p>';
                                          $output .= '<p>' . $customer['fullname'] . '</p>';
                                          $output .= '<p>' . $customer['email'] . '</p>';
                                          $output .= '<p>' . $customer['address'] . '</p>';
                                          $output .= '<p>' . $customer['hotline'] . '</p>';
                                          $output .= '<p>' . $customer['postcode'] . '</p>';
                                          $output .= '<p>' . $customer['message'] . '</p>';
                                          $output .= '<p>' . $customer['payment_methods'] . '</p>';
                                     // end customer info    
                              $output .= '</div>';  
                              /**
                               @ ==========        Footer   ========  @
                              **/
                              $output .= '<div class="lemiho-main-box-footer">';
                                       $output .= '<p style="text-align:right;">' . $this->lemiho_version() .'</p>';
                              $output .= '</div>';  // footer
                         $output .= '</div>'; // end main box
                      $output .= '</div>'; // end box
                      return $output;
                 }
                 /**
                   @ ====================== Checkout run =============
                   **/
                 function check_out_run() {
                      $input = $_POST;
                      // check submit action 
                      if(isset($input['submit'])) {
                        $url_call = get_page_link(esc_html(get_option('thanks_page')));
                            // check data empty
                           if(!empty($input['id_order']) & !empty($input['fullname']) & !empty($input['email']) & !empty($input['hotline']) & !empty($input['message']) & !empty($input['postcode']) & !empty($input['address']) & !empty($input['payment_methods'])) {
                                   // check security 
                              if(is_numeric($input['id_order']) & is_numeric($input['hotline']) & is_numeric($input['postcode'])) {
                                    // action here 
                                    $id_order = $this->lemiho_token(); // Create ID 
                                    $_SESSION['id_order'] = $id_order;
                                    // sent mail  
                                    $to = array($input['email'],get_bloginfo('admin_email'));
                                    $subject = 'Mail order';
                                    $body = $this->mail_order_marketing($input['fullname'],$input['address'],$input['postcode'],$input['email'],$input['hotline'],$input['message'],$input['payment_methods']);
                                    $headers = array('Content-Type: text/html; charset=UTF-8');
                                    wp_mail( $to, $subject, $body, $headers );
                                    // insert order into database
                                    $database = new lemiho_order;
                                    // action insert order
                                    $database->lemiho_insert_order($id_order,$price = NULL,$day = NULL,$input['fullname'],$input['email'],$input['address'],$input['message'],$input['payment_methods'],$input['postcode'],$input['hotline']);
                                    // get ID Form id_order and email on database
                                    $__product = $database->lemiho_get_order($id_order,$input['email']);
                                    $ID_order = $__product->ID;
                                    // action insert item follow order
                                    $database->lemiho_insert_item_order($ID_order); 
                                    // clean cart
                                    $this->clearn_cart();
                                    // check payment
                                    if($input['payment_methods'] == "paypal") {
                                      // set
                                      if(empty($_SESSION['lemiho_coupon'])) {
                                        $ss['total_price_checkout_paypal'] = $_SESSION['total_price'];
                                      } else {
                                        $__down = $_SESSION['total_price'] * $_SESSION['lemiho_coupon'] / 100;
                                        $ss['total_price_checkout_paypal'] = $_SESSION['total_price'] - $__down;
                                      }
                                      // install session
                                      $_SESSION['total_price_checkout_paypal'] = $ss['total_price_checkout_paypal'];
                                    } else if($input['payment_methods'] == "baokim") {
                                      // wait update...
                                    } else if($input['payment_methods'] == "nganluong") {
                                      // wait update...
                                    } ?>
                                      <script>
                                          window.location.replace("<?php echo $url_call; ?>");
                                      </script>
                                     <?php
                              }     
                           }
                      }
                 }  
    } 
    add_action('init', array('lemiho','register_my_session'));  





