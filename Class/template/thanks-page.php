<?php $lemiho = new lemiho; 
$id_order = $_SESSION['id_order']; ?>
<div class="lemiho-page-site">
	<div class="lemiho-alert-sent-email">
		<h4> Dear ! customer  </h4>
		<p> Check product of you on the email, us sent a mail about order into you email . please ! </p>
	    <?php if($_SESSION['total_price_checkout_paypal'] != '') { ?>
	            <p> Please click button paypal and checkout </p>
	    		<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="<?php echo get_option('text_email_paypal'); ?>">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="Order id : <?php echo $id_order; ?>">
				<input type="hidden" name="amount" value="<?php echo $_SESSION['total_price_checkout_paypal']; ?>">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="button_subtype" value="services">
				<input type="hidden" name="no_note" value="1">
				<input type="hidden" name="tax_rate" value="<?php echo get_option('text_price_tax'); ?>">
				<input type="hidden" name="shipping" value="<?php echo get_option('text_price_ship'); ?>">
				<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
				<input type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/checkout-logo-large.png" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
	    <?php } ?>
	</div>
</div>