<?php get_header(); ?>
<?php $lemiho = new lemiho; ?>
<div class="lemiho-page-site">
    <!-- start sidebar -->
	<div class="lemiho-sideabr-site">
		<?php dynamic_sidebar('lemiho-sidebar-product'); ?>  
	</div>
    <!-- end sidebar --> 
    <!-- start content -->
	<div class="lemiho-content-site archive">
	    <div class="lemiho-title-page">
	    	<h1 class="text-lemiho-title-page"><?php printf( __( 'Search Results for: %s', 'lemiho_bsn' ),get_search_query()); ?></h1>
	    </div>
	    <ul class="lemiho-group-item">
	    	<?php
	    	global $wp_query;
			$args = array_merge( $wp_query->query_vars, array( 'post_type' => 'product' ) );
			query_posts( $args );
			if ( have_posts() ) : while ( have_posts() ) : the_post();// the loop ?>
					<li class="lemiho-item">
					        <div class="lemiho-item-thumbnail">
					            <a href="<?php echo the_permalink(); ?>">
						        	<?php if(has_post_thumbnail()) {
						        		the_post_thumbnail('thumbnail');
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
										    	 	<button id="lemiho<?php echo $token . get_the_ID(); ?>" onclick="lemiho_add_to_cart(<?php echo get_the_ID(); ?>,<?php echo $token . get_the_ID(); ?>);" class="lemiho-item-button-add-to-cart"><?php echo esc_html(get_option('text_button_add_to_cart')); ?></button>
								</div>
						    </div>
					</li>    
			<?php endwhile;
			else :
				echo wpautop( 'Sorry, no posts were found' );
			endif;
		   ?>
	    </ul>
		<?php wp_reset_query(); ?>
		<div class="lemiho-pagination">
			<?php echo paginate_links(); ?>
		</div>
	</div>
	<!-- end content -->
</div>
<?php get_footer(); ?>