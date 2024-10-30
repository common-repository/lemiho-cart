<?php class lemiho_order extends lemiho {
			function lemiho_get_order($id_order,$email) {
				global $wpdb;
				$query = $wpdb->get_row("SELECT ID,email FROM lemiho_or WHERE id_order='$id_order' AND email='$email'");
				return $query;
	        }
			function check_id($ID) {
				$check = '';
				global $wpdb;
				$numrows = $wpdb->get_var($wpdb->prepare("SELECT ID FROM lemiho_or WHERE ID='%d'",$ID));
				if($numrows >= 1 ) {
					$check = TRUE;
				} else {
					$check = FALSE;
				}
				return check;
			}
	        function lemiho_delete_order() {
				   if(!empty($_GET['lemiho_product_id_delete'])) {
					   if(is_numeric($_GET['lemiho_product_id_delete'])) {
						   if(!is_array($_GET['lemiho_product_id_delete'])) {
							   $check = $this->check_id($_GET['lemiho_product_id_delete']);
							   if($check != FALSE ) {
								    global $wpdb;	
									$ID = $_GET['lemiho_product_id_delete'];
									// delete data order   
									$sql = $wpdb->query($wpdb->prepare("DELETE FROM lemiho_or WHERE ID='%d'",$ID));
									// delete data item follow order
									$sql = $wpdb->query($wpdb->prepare("DELETE FROM lemiho_item WHERE id_order='%d'",$ID));
							   } 
						   } 
					   }
				   } else {
						return true;
				   }
					
	        }
			function lemiho_insert_order($id_order,$price,$day,$fullname,$email,$address,$message,$payment_method,$postcode,$hotline) {
					 $day = date('Y-m-d',time());
					 $lemiho = new lemiho;
					 // coupon 
					 if(!empty($_SESSION['lemiho_coupon'])) {
						$coupon = $_SESSION['lemiho_coupon'] . ' (%)';
						$price = $_SESSION['total_price'];
					 } else {
						$coupon = "None";
					    $price = $lemiho->total_price();
					 }
					 // check clearn code 
					 $_fullname = sanitize_text_field($fullname);
					 $_email = sanitize_text_field($email);
					 $_address = sanitize_text_field($address);
					 $_message = sanitize_text_field($message);
					 $_postcode = sanitize_text_field($postcode);
					 $_hotline = sanitize_text_field($hotline);
					 $_payment_method = sanitize_text_field($payment_method);
					 // insert database
					 global $wpdb;
					 $sql = $wpdb->query("INSERT INTO lemiho_or (id_order,price,day,fullname,email,address,message,payment_method,coupon,postcode,number_fone) 
					 						VALUES ('$id_order','$price','$day','$_fullname','$_email','$_address','$_message','$_payment_method','$coupon','$_postcode','$hotline')");  
			}
			function lemiho_insert_item_order($ID_order) {
                // id order here 's ID on database not token
					 foreach($_SESSION['cart'] as $action ) {
						     $qty = $action['qty'];
							 $id_product = $action['product_rowid'];
							 global $wpdb;
						     $sql = $wpdb->query("INSERT INTO lemiho_item (id_order,qty,id_product) 
							 					VALUES ('$ID_order','$qty','$id_product')"); 
					 }
			}	
			function lemiho_order_page() { ?>
				<div class="wrapper-order">
				<?php // delete order 
				$this_class = new lemiho_order; $this_class->lemiho_delete_order();
				// page	
				 ?>	
					  <?php wp_enqueue_style('backend.css',plugins_url('/lemiho-cart/asset/backend.css',FALSE)); ?>
					  <?php wp_enqueue_script('backend_order.js',plugins_url('/lemiho-cart/asset/backend_order.js',FALSE)); ?>
					  <h1 class='title-page-product-setting'>Manage order tool </h1>
					  <?php if(!empty($_GET['lemiho_product_id_delete'])) {
								if(is_numeric($_GET['lemiho_product_id_delete'])) {
									if(!is_array($_GET['lemiho_product_id_delete'])) { ?>
										</br>
										 <div style="width: 98%;background: green; padding: 1%;" class="lemiho_callback">
										 	<p style="font-size: 15px; color: white;"> Delete Success </p>
										 </div> 
										</br>	
								   <?php }
								}
					  } ?>
					  <?php
					    global $wpdb;
                        $sql = $wpdb->get_results("SELECT * FROM lemiho_or");
                        //$result = mysql_query($sql);
                        //$numrow = mysql_num_rows($result);
                        //if($numrow >= 1 ) {
                        	foreach($sql as $query) {
                        		echo '<div class="box-list-order-be">';
                        	 ?>
                        	      <div class="action-list-order-be" id="action-list-order-be<?php echo esc_html($query->ID); ?>">
                        	      		<ul class="group-info">
                        	      			<li><span>Order ID : <?php echo $query->id_order; ?></span></li>
                        	      			<li><button onclick="lemiho_order_open(<?php echo $query->ID; ?>)" id="click<?php echo $query->ID; ?>"> View </button></li>
                        	      			<li><button onclick="lemiho_order_close(<?php echo $query->ID; ?>)" id="click<?php echo $query->ID; ?>"> Close </button></li>
                        	      			<li style="float: right;">	
												  <?php if(!empty($_SERVER['HTTPS'])) {
													$request = 'https://' . $_SERVER['HTTP_HOST']; 
												  } else {
													$request = 'http://' . $_SERVER['HTTP_HOST']; 
												  } ?>
												  <?php $URI = $request . $_SERVER['PHP_SELF']; ?>
												  <form method="GET" action="<?php echo $URI; ?>">
											      <input type="hidden" name="lemiho_product_id_delete" value="<?php echo esc_html($query->ID); ?>"/>	
												  <input type="hidden" name="page" value="<?php echo esc_html($_GET['page']); ?>">	  
												  <button> Delete </button>
												  </form> 
										    </li>
                        	      		</ul>
                        	      </div>	
                        	      <div class="group-user" id="group-user<?php echo esc_html($query->ID); ?>">
                        	      		<p> Name custommer : <?php echo esc_html($query->fullname); ?></p>	
                        	      		<p> Email custommer : <?php echo esc_html($query->email); ?></p>
                        	      		<p> Address custommer : <?php echo esc_html($query->address); ?></p>
                        	      		<p> Message custommer : <?php echo esc_html($query->message); ?></p>
										<p> Postcode custommer : <?php echo esc_html($query->postcode); ?></p>
										<p> Hotline custommer : <?php echo esc_html($query->number_fone); ?></p>
                        	      		<p> Payment method : <?php echo esc_html($query->payment_method); ?></p>
										<?php if($query->coupon == 'none') { ?>
                        	      			<p> Total price : <?php echo $query->price; ?> <?php echo esc_html(get_option('text_unit_bill')); ?> </p>
										<?php } else { ?>
											<p style="text-decoration: line-thouth;"> Total price : <?php echo $query->price; ?> <?php echo esc_html(get_option('text_unit_bill')); ?> </p>
											<?php $__coupon = esc_html($query->price) * esc_html($query->coupon) / 100; $coupon = esc_html($query->price) - $__coupon; ?> 
											<p> Total price with coupon : <?php echo $coupon; ?> ( COUPON <?php echo $query->coupon; ?> ) <?php echo esc_html(get_option('text_unit_bill')); ?> </p>
										<?php } ?>  
                        	      		<p> Time : <?php echo esc_html($query->day); ?></p>
                        	      </div>	
                        	      <!-- table product -->
                        	      <div class="lemiho-table-product" id="lemiho-table-product<?php echo esc_html($query->ID); ?>">
                        	      	    <table>
                        	      	    	<tr>
                        	      	    		<th> Thumbnail </th>
                        	      	    		<th> Title </th>
                        	      	    		<th> Price </th>
                        	      	    		<th> Qty </th>
                        	      	    		<th> Total price  </th>
                        	      	    	</tr>
                        	      	    	<?php
                        	      	    	// get data
											$__ID = $query->ID;  
                        	      	    	$sql_product = $wpdb->get_results($wpdb->prepare("SELECT * FROM `lemiho_item` WHERE id_order=%d",$__ID));
                        	      	    		   foreach($sql_product as $item_result ) {
                        	      	    		   	    $id_product = esc_html($item_result->id_product);
                        	      	    		   	    $__price = esc_html(get_post_meta($id_product,"price_product",true));
                        	      	    		   	    $total_product_one = $__price * $item_result->qty;
                        	      	    		   		echo '<tr>'; ?>
                        	      	    		   			<td> <?php echo get_the_post_thumbnail($id_product); ?> </td>
                        	      	    		   			<td> <?php echo get_the_title($id_product); ?> </td>
                        	      	    		   			<td> <?php echo $__price; ?> (<?php echo esc_html(get_option('text_unit_bill')); ?>) </td>
                        	      	    		   			<td> <?php echo " X " . esc_html($item_result->qty); ?> </td>
                        	      	    		   			<td> <?php echo $total_product_one; ?> (<?php echo esc_html(get_option('text_unit_bill')); ?>)</td>
                        	      	    		 <?php  echo '</tr>';
                        	      	    		   }
                        	      	    	 ?>
                        	      	    </table>	
                        	      </div>
                        	      <!-- / end table product -->
                        		<?php 
							  echo '</div>';
                        	} // endwhile;
                        	
                        //}
					  ?>
				</div>
			<?php }
	        function lemiho_add_menu_order() {
	        	add_submenu_page("lemiho-plugin-panel","Lemiho order", "Lemiho order", "manage_options", "lemiho-order", array("lemiho_order","lemiho_order_page"), null, 99);
	        }
}
add_action("admin_menu",array("lemiho_order","lemiho_add_menu_order"));