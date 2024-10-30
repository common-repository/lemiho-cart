<?php class lemiho_shortcode extends lemiho {
	        function __construct() {
	        	parent::__construct();
	        }
	        function lemiho_cart_page() {
	        	$template = dirname( __FILE__ ) . '/template/cart-page.php';
	        	include $template;	
	        }
	        function lemiho_checkout_page() {
	        	$template = dirname( __FILE__ ) . '/template/thanks-page.php';
	        	include $template;		
	        }
	        function lemiho_shortcode_get_post($attr) {
	        	echo '<div class="lemiho-page-site"><div class="lemiho-content-site"><ul class="lemiho-group-item">';
	        	$lemiho = new lemiho;
	        	global $wp_query;
	        	$args = array(
				    'post_type' => 'product',
				    'posts_per_page' => $attr['show'],
				    'tax_query' => array(
				        array(
				            'taxonomy' => 'category-product',
				            'field' => 'slug',
				            'terms' => $attr['cat']
				        )
				     )
				);
				query_posts( $args );
				if ( have_posts() ) : while ( have_posts() ) : the_post();// the loop ?>
				        			<li class="lemiho-item">
									        <div class="lemiho-item-thumbnail">
									            <a href="<?php echo the_permalink(); ?>">
										        	<?php if(has_post_thumbnail()) {
										        		the_post_thumbnail('medium');
										        	} ?>
									        	</a>
									        	<?php $hot = get_post_meta(get_the_ID(),'hot_product',true); if($hot == 'on') { ?>
									        		<span class="span-hot-product"> HOT </span>	
									        	<?php } ?>
									        	<?php $hot = get_post_meta(get_the_ID(),'sale_product',true); if($hot == 'on') { ?>
									        		<span class="span-sale-product"> SALE </span>	
									        	<?php } ?>
									        </div>
										    <div class="lemiho-item-title">
										    	<a href="<?php echo the_permalink(); ?>">
										    		<h2 class="text-lemiho-item-title"><?php the_title(); ?></h2>
										    	</a>	
										    </div>
										    <div class="lemiho-item-option">
										    	 <div class="lemiho-item-price">
										    	    <span>
										    	 	    <?php $price = $lemiho->get_price_product(get_the_ID()); echo '$ ' . $price; ?>
										    	 	</span>    
										    	 </div>
										    	<div class="lemiho-item-button">
										    	    <?php $token = $lemiho->lemiho_token(); ?>
										    	 	<button id="lemiho<?php echo $token . get_the_ID(); ?>" onclick="lemiho_add_to_cart(<?php echo get_the_ID(); ?>,<?php echo $token . get_the_ID(); ?>);" class="lemiho-item-button-add-to-cart"><?php echo get_option('text_button_add_to_cart'); ?></button>
										    	</div>
										    </div>
									</li>  
								<?php endwhile;
								else :
								echo wpautop( 'Sorry, no posts were found' );
							endif;
							wp_reset_query();
				echo '</ul></div></div>';
	        }
	        function lemiho_setup_add_to_cart() {
	        	  $lemiho = new lemiho;
	        	  $lemiho->add_to_cart();
	        	  $_automatic_cart = '';
	        	  echo $_automatic_cart;
	        }
}
add_shortcode('lemiho_cart_page',array('lemiho_shortcode','lemiho_cart_page'));
add_shortcode('lemiho_thanks_page',array('lemiho_shortcode','lemiho_checkout_page'));
add_shortcode('leminhhoang',array('lemiho_shortcode','lemiho_shortcode_get_post'));
add_action('wp_footer',array('lemiho_shortcode','lemiho_setup_add_to_cart'));