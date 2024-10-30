<?php class lemiho_stylesheet extends lemiho {
	        function lemiho_style() {
	        	   wp_enqueue_style('lemiho-cart.css',plugins_url('asset/lemiho-cart.css',dirname(__FILE__)));
	        	   wp_enqueue_script('functions.js',plugins_url('asset/functions.js',dirname(__FILE__))); // ajax
	        }
	        function lemiho_get_style() { ?>
	        	  	<style>
	        	  			button.lemiho-item-button-add-to-cart,
                                                ul.lemiho-widget-group li div.text-after-icon-lmh span,
                                                button.lemiho-button-seach-frontend, 
                                                input.lemiho-button,button.lemiho-button-submit,
                                                span.span-sale-product,div.lemiho-callback-div,
												div.lemiho-mini-box-coupon form input.lemiho-button
                                                {
	        	  				background: <?php echo esc_html(get_option('lemiho_style')); ?>;
                                                        box-shadow: none;
														text-shadow: none;
	        	  			}
	        	  			div.lemiho-pagination a,div.lemiho-page-site div.lemiho-content-site ul.lemiho-group-item > li.lemiho-item div.lemiho-item-option div.lemiho-item-price span {
	        	  				color: <?php echo esc_html(get_option('lemiho_style')); ?>;
	        	  			}
	        	  	</style>
	        <?php }
	        function lemiho_ajax_cdn() { 
					wp_enqueue_script('slider-single.js',plugins_url('asset/slider-single.js',dirname(__FILE__)));
	        }

}
 add_action('wp_enqueue_scripts',array('lemiho_stylesheet','lemiho_style'));
 add_action('wp_head',array('lemiho_stylesheet','lemiho_get_style'));
 add_action('wp_head',array('lemiho_stylesheet','lemiho_ajax_cdn')); 