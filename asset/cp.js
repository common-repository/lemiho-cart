jQuery(document).ready(function($) {
    setTimeout(function(){ $(".lemiho-big-box-coupon").html("<h2> Loading 50% .. </h2>"); }, 200);
    setTimeout(function(){ $(".lemiho-big-box-coupon").html("<h2> Loading 99% ....... </h2>"); }, 1200);
    setTimeout(function(){ $(".lemiho-big-box-coupon")
    .html('<div class="lemiho-mini-box-coupon"><form method="POST"><input required placeholder="Insert Coupon" type="text" class="lemiho-coupon" name="coupon"><input class="lemiho-button" name="submit" type="submit" value="Apply"></form></div>'); }, 2000);
});