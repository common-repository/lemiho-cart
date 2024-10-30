<?php get_header(); ?>
<?php $lemiho = new lemiho; 
      $lemiho->single_add_product(); 
      $lemiho->update_cart();
      $get = get_post(get_the_ID()); 
?>
	<div class="main-product">
			<div class="content-main">
			    <?php if(!empty($_GET['qty']) & !empty($_GET['id_product'])) {
			    	      if(is_numeric($_GET['qty']) & is_numeric($_GET['id_product'])) {
			    	      		if(!is_array($_GET['qty']) & !is_array($_GET['id_product'])) { ?>
			    	      					<div class="lemiho-callback-div">
			    	      						     <p> Add to cart sucess ! <a href="<?php echo get_page_link(get_option('checkout_page')); ?>"> View cart </a></p>
			    	      					</div>
			    	      		<?php }
			    	      }
			    } ?>
				<div class="thumbnail-product">
						<ul class="list-image-slider-big">
							<li><?php the_post_thumbnail('shop_single'); ?></li>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider1',true))) 
							      echo '<li><img style="" src="' . get_post_meta(get_the_ID(),'slider1',true) . '"></li>'; ?>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider2',true))) 
							      echo '<li><img style="" src="' . get_post_meta(get_the_ID(),'slider2',true) . '"></li>'; ?>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider3',true))) 
							      echo '<li><img style="" src="' . get_post_meta(get_the_ID(),'slider3',true) . '"></li>'; ?>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider4',true))) 
							      echo '<li><img style="" src="' . get_post_meta(get_the_ID(),'slider4',true) . '"></li>'; ?>        
						</ul>
						<ul class="list-image-slider-small">
						    			<li id="slider1"><?php the_post_thumbnail('thumbnail'); ?></li>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider1',true))) 
							      echo '<li id="slider2"><img style="" src="' . get_post_meta(get_the_ID(),'slider1',true) . '"></li>'; ?>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider2',true))) 
							      echo '<li id="slider3"><img style="" src="' . get_post_meta(get_the_ID(),'slider2',true) . '"></li>'; ?>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider3',true))) 
							      echo '<li id="slider4"><img style="" src="' . get_post_meta(get_the_ID(),'slider3',true) . '"></li>'; ?>
							<?php if(!empty(get_post_meta(get_the_ID(),'slider4',true))) 
							      echo '<li id="slider5"><img style="" src="' . get_post_meta(get_the_ID(),'slider4',true) . '"></li>'; ?>           
						</ul>
				</div>
				<div class="meta-product">
				    <h1 class="product-title"><?php the_title(); ?></h1>
					     <span class="price-product"><?php $price = $lemiho->get_price_product(get_the_ID()); echo '$ ' . $price . ' ( ' . get_option('text_unit_bill') . ' )'; ?></span>
					<form method="GET" action="">
						<input type="number" name="qty" class="input-lemiho" id="input-lemiho" minlength="1" value="1">
						<input type="hidden" name="id_product" value="<?php echo get_the_ID(); ?>">
						<br/>
						<div class="lemiho-box-update-down">
							<span class="lemiho-button-options-single" onclick="var result = document.getElementById('input-lemiho'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" class="lemiho-extra-product-single"> +</span>
							<span class="lemiho-button-options-single" onclick="var result = document.getElementById('input-lemiho'); var qty = result.value; if( !isNaN( qty ) && qty > 1 ) result.value--;return false;"> - </span>
						</div>
						<button class="lemiho-button-submit"> <?php echo get_option('text_button_add_to_cart'); ?> </button>
					</form>     
					<div class="lemiho-hotline-buy">
						<span class="lemiho-call-now"> Call now : </span><span class="text-hotline-buy"><?php echo get_option('hotline_buy'); ?></span>
					</div>
					<div class="lemiho-product-archive">
						<?php the_terms( $post->ID, 'category-product', ' Categories: ', ' / ' ); ?>
					</div>
                                        <div class="lemiho-product-archive">
                                                <?php echo '<br/> Tags : ' . get_the_term_list( get_the_ID(), 'tag-product','', ', ', '' ); ?>
					</div>     
				</div>
				<div class="content-content-lemiho">
				    <h3 class="lemiho-desc-product"> Description </h3>
				    <div class="content-content-lemiho-text">
				        <?php echo $get->post_content; ?>
				    </div>
					
				</div>
			</div>
	</div>	

<?php get_footer(); ?>