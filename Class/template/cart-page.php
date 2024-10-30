<?php $lemiho = new lemiho; 
// update cart
$lemiho->update_cart(); 
// remove item on cart 
$lemiho->remove_product_on_cart();
// check form run
$lemiho->check_out_run();
// get token
$id_order = $lemiho->lemiho_token();
// install coupon
$coupon_install = new lemiho_coupon;
$coupon_install->lemiho_install_coupon_to_order();
// clean old data
$lemiho->clearn_cart_old();
 ?>
<div class="lemiho-page-site">
	<!-- start sidebar -->
	<div class="lemiho-sideabr-site">
		<form method="POST" action="" class="lemiho-form-checkout">
		    <input type="hidden" name="id_order" value="<?php echo $id_order; ?>">
		    <label> Full name </label><br/>
			<input class="lemiho-input" type="text" name="fullname" placeholder="What your full name ? " required/><br/>
			 <label> Email </label><br/>
			<input class="lemiho-input" type="email" name="email" placeholder="You email " required/><br/>
			<label> Number fone </label><br/>
			<input class="lemiho-input" type="number" name="hotline" placeholder="Number phone " required/><br/>
			<label> Address </label><br/>
			<input class="lemiho-input" type="text" name="address" placeholder="You address " required/><br/>
			<label> Postcode </label><br/>
			<input class="lemiho-input" type="number" name="postcode" placeholder="Post code " required/><br/>
			<label> Message </label><br/>
			<textarea class="lemiho-input" name="message" placeholder="Sent a message to us " required></textarea>
			<label> Payment methods </label><br/>
			<?php // not set payment method 
			if(esc_html(get_option('checkbox_lemiho_key_payment_method_cod')) != true & esc_html(get_option('checkbox_lemiho_key_payment_method_paypal')) != true & esc_html(get_option('checkbox_lemiho_key_payment_method_at_store')) != true ) {
				?>
					<input type="radio" value="Pay at the store" name="payment_methods"><span> Pay At the store </span>
					<br/>	
				<?php	
			} ;?>
			<?php // have key
			 if(esc_html(get_option('checkbox_lemiho_key_payment_method_cod')) == true ) { // cod ?>
				<input checked type="radio" name="payment_methods" value="Payment laster"> <span> Pay COD ( + <?php echo esc_html(get_option('cod')); ?> <?php echo esc_html(get_option('text_unit_bill')); ?>)</span><br/>
			<?php } ?>
			<?php if(esc_html(get_option('checkbox_lemiho_key_payment_method_paypal')) == true ) { // paypal ?>
				<input type="radio" value="paypal" name="payment_methods"><span> Paypal </span><br/>
			<?php } ?>
			<?php if(esc_html(get_option('checkbox_lemiho_key_payment_method_at_store')) == true ) { // at store ?>
					<input type="radio" value="Pay at the store" name="payment_methods"><span> Pay At the store </span><br/>
					<br/>	
			<?php } ?>
			<input type="submit" name="submit" class="lemiho-button" value=" Order now ! ">
		</form>
	</div>
    <!-- end sidebar --> 	
	<div class="lemiho-content-site archive">
	    <?php if(empty($_SESSION['lemiho_coupon'])) { ?>
			<label>Total price : <?php echo $lemiho->total_price() . ' ' . esc_html(get_option('text_unit_bill')); ?></label>
		<?php } else { 
			$_N_coupon = $_SESSION['total_price'] * $_SESSION['lemiho_coupon'] / 100; 
		    $SS_new_total_price = $_SESSION['total_price'] - $_N_coupon; ?>
			<label> You use coupon success ! </label><br/>
			<label style="text-decoration: line-through;">Total price : <?php echo $_SESSION['total_price'] . ' ' . esc_html(get_option('text_unit_bill')); ?></label> <br/>
			<label>Total price with coupon : <?php echo $SS_new_total_price . ' ' . get_option('text_unit_bill') . '( COUPON ' . $_SESSION['lemiho_coupon'] . '% )'; ?></label>
		<?php } ?>
	    <div class="lemiho-table-responsive full">
	        <table class="lemiho-box-table">
	            <tr>
	            	<th> Title </th>
	            	<th> Thumb </th>
	            	<th> Price(<?php echo get_option('text_unit_bill'); ?>) </th>
	            	<th> Qty </th>
	            	<th> Update </th>
	            	<th> Remove product </th>	
	            </tr>
				    	<?php foreach($_SESSION['cart'] as $action ) { ?>
				    		<tr>
				            	<td> <?php echo $action['product_title']; ?> </td>
				            	<td> <?php echo $action['product_thumb']; ?> </td>
				            	<td> <?php echo $lemiho->get_price_product($action['product_rowid']); ?> </td>
				            	<td> <?php echo ' X ' . $action['qty']; ?> </td>
				            	<td> 
				            	     <form method="GET" action="" class="lemiho-update-cart-form">
				            				<input style="width: 50px" type="number" name="qty" class="input-update-product" minlength="1" value="<?php echo $action['qty']; ?>">
				            				<input type="hidden" name="id_product" value="<?php echo $action['product_rowid']; ?>">
				            				<button class="lemiho-button-update"><img alt="<?php echo bloginfo('name'); ?>" src="<?php echo plugins_url('/lemiho-cart/img/update.png',FALSE); ?>"></button>
				            		 </form>	
				            	</td>
				            	<td> 
				            		 <form method="GET" action="" class="lemiho-update-cart-form">
				            		   <input type="hidden" name="remove_product_id" value="<?php echo $action['product_rowid']; ?>">
				            	       <button class="lemiho-button-update">
				            	       <img alt="<?php the_title(); ?>" class="lemiho-remove" src="<?php echo plugins_url('/lemiho-cart/img/delete.png',FALSE); ?>"> 
				            	       </button>
				            	     </form>    		
				            	</td>
				            	      
				            </tr>	
				       <?php } ?>
	    	</table>
	    </div>
		<!-- box coupon -->
		<div class="lemiho-big-box-coupon">

		</div>
		<div style="margin-top: 20px;" class="lemiho-back-to-home">
			<a href="<?php echo home_url(); ?>"><< Back to home </a>
		</div>
	</div>
</div>
<?php wp_enqueue_script('cp.js',plugins_url('/lemiho-cart/asset/cp.js',FALSE)); ?>
<?php get_footer(); ?>