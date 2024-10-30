<?php class register_system extends lemiho {
	        /**
	          @ Text domain
	         **/ 
	        function textdomain() {
    			    load_plugin_textdomain('lemiho_bsn','/languages');
    		}	
    		function register_cart() { // post type
		    		$labels = array(
				    'name'               => _x( 'Products', 'lemiho_bsn' ),
				    'singular_name'      => _x( 'Product', 'lemiho_bsn' ),
				    'add_new'            => _x( 'Add New', 'lemiho_bsn' ),
				    'add_new_item'       => __( 'Add New Product' ),
				    'edit_item'          => __( 'Edit Product' ),
				    'new_item'           => __( 'New Product' ),
				    'all_items'          => __( 'All Products' ),
			        'query_var'          => true,
				    'view_item'          => __( 'View Product' ),
				    'search_items'       => __( 'Search Products' ),
				    'not_found'          => __( 'No products found' ),
				    'not_found_in_trash' => __( 'No products found in the Trash' ), 
				    'parent_item_colon'  => '',
				    'menu_name'          => 'Products'
				  );
				  $args = array(
				    'labels'        => $labels,
				    'description'   => 'Holds our products and product specific data',
				    'public'        => true,
				    'menu_position' => 5,
				    'rewrite'            => array( 'slug' => 'product' ),
				    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments','post_tag' ),
				    'has_archive'   => true,
					'menu_icon'		=> 'dashicons-cart'
				  );
				  register_post_type( 'product', $args ); 
		    }
		    function register_categories_products() {
			  $labels = array(
			    'name'              => _x( 'Product Categories', 'lemiho_bsn' ),
			    'singular_name'     => _x( 'Product Category', 'lemiho_bsn' ),
			    'search_items'      => __( 'Search Product Categories' ),
			    'all_items'         => __( 'All Product Categories' ),
			    'parent_item'       => __( 'Parent Product Category' ),
			    'parent_item_colon' => __( 'Parent Product Category:' ),
			    'edit_item'         => __( 'Edit Product Category' ), 
			    'update_item'       => __( 'Update Product Category' ),
			    'add_new_item'      => __( 'Add New Product Category' ),
			    'new_item_name'     => __( 'New Product Category' ),
			    'menu_name'         => __( 'Product Categories' ),
			  );
			  $args = array(
			    'labels' => $labels,
			    'hierarchical' => true,
			    'rewrite'            => array('slug'=>'category-product'),
			    'query_var'          => true,
			    'public'        => true
			  );
			  register_taxonomy('category-product', 'product', $args );
			}
			function register_tag_taxonomies() 
			{
			  // Add new taxonomy, NOT hierarchical (like tags)
			  $labels = array(
			    'name' => _x( 'Tags product', 'lemiho_bsn' ),
			    'singular_name' => _x( 'Tag product', 'lemiho_bsn' ),
			    'search_items' =>  __( 'Search Tags product' ),
			    'popular_items' => __( 'Popular Tags product' ),
			    'all_items' => __( 'All Tags product' ),
			    'parent_item' => null,
			    'parent_item_colon' => null,
			    'edit_item' => __( 'Edit Tag product' ), 
			    'update_item' => __( 'Update Tag product' ),
			    'add_new_item' => __( 'Add New Tag product' ),
			    'new_item_name' => __( 'New Tag Name product' ),
			    'separate_items_with_commas' => __( 'Separate tags with commas product' ),
			    'add_or_remove_items' => __( 'Add or remove tags product' ),
			    'choose_from_most_used' => __( 'Choose from the most used tags product' ),
			    'menu_name' => __( 'Tags product' ),
			  ); 

			  register_taxonomy('tag-product','product',array(
			    'hierarchical' => false,
			    'labels' => $labels,
			    'show_ui' => true,
			    'update_count_callback' => '_update_post_term_count',
			    'query_var' => true,
			    'rewrite' => array( 'slug' => 'tag-product' ),
			  ));
			}
			/**
			  @ Custom fields
			  **/
			function lemiho_get_html($post_id) {
				$price_product = get_post_meta( $post_id->ID, 'price_product', true );
				$hot_product = get_post_meta( $post_id->ID, 'hot_product', true );
				$sale_product = get_post_meta( $post_id->ID, 'sale_product', true );
				$slider1 = get_post_meta( $post_id->ID, 'slider1', true );
				$slider2 = get_post_meta( $post_id->ID, 'slider2', true );
				$slider3 = get_post_meta( $post_id->ID, 'slider3', true );
				$slider4 = get_post_meta( $post_id->ID, 'slider4', true );
			 ?>
			<link rel="stylesheet" type="text/css" href="<?php echo plugins_url('/lemiho-cart/asset/backend.css',FASLE); ?>"/>
			<script src="<?php echo plugins_url('/lemiho-cart/asset/file.js',FALSE); ?>"></script>
			<script>
				jQuery(document).ready( function( $ ) {

						$('#upload_image_button').click(function() {

							formfield = $('#upload_image').attr('name');
							tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
							return false;
						});
					});
			</script>
                            <div class="lemiho box-meta-product">
                                <?php $_SESSION['lemiho_upload'] = true; ?>
                                <label> Price products </label>
                                <input required="required" placeholder="Only number" class="input-lemiho" type="number" name="price_product" value="<?php echo esc_html($price_product); ?>">
                                <label> Hot product </label>
                               <select name="hot_product" class="input-lemiho">
                                           <option <?php if(esc_html($hot_product) == 'off') echo 'selected="selected"'; ?> value="off"> none </option>
                                           <option <?php if(esc_html($hot_product) == 'on') echo 'selected="selected"'; ?> value="on"> On </option>
                               </select>
                               <label> Sale product </label>
                               <select name="sale_product" class="input-lemiho">
                                           <option <?php if(esc_html($sale_product) == 'off') echo 'selected="selected"'; ?> value="off"> none </option>
                                           <option <?php if(esc_html($sale_product) == 'on') echo 'selected="selected"'; ?> value="on"> On </option>
                               </select>
							   <!-- slider 1 -->
							   <div style="width: 100%;border-bottom: 6px solid #23282d;margin-bottom: 20px;" class="box-slider-mini">
							   		<input id="upload_image_button" type="button" value="Upload Image" />
									   <br/>
									<label> Image 1 </label><br/>   
                                	<input class="input-lemiho" id="slider1" type="text" size="36" name="slider1" value="<?php echo esc_html($slider1); ?>" />
									
									<br/>
									<?php if(!empty($slider1)) {
									    echo '<img src="' . esc_html($slider1) . '" style="width: 200px;height: auto;">';		
									} ?>
							   </div>
							   <!-- slider 2 -->
							   <div style="width: 100%;border-bottom: 6px solid #23282d;margin-bottom: 20px;" class="box-slider-mini">
							   		<label> Image 2 </label><br/>   
                                	<input class="input-lemiho" id="slider2" type="text" size="36" name="slider2" value="<?php echo esc_html($slider2); ?>" />
									
									<br/>
									<?php if(!empty($slider2)) {
									    echo '<img src="' . esc_html($slider2) . '" style="width: 200px;height: auto;">';		
									} ?>
							   </div>	
							   <!-- slider 3 -->
							   <div style="width: 100%;border-bottom: 6px solid #23282d;margin-bottom: 20px;" class="box-slider-mini">
							   		<label> Image 3 </label><br/>   
                                	<input class="input-lemiho" id="slider3" type="text" size="36" name="slider3" value="<?php echo esc_html($slider3); ?>" />
									<br/>
									<?php if(!empty($slider3)) {
									    echo '<img src="' . esc_html($slider3) . '" style="width: 200px;height: auto;">';		
									} ?>
							   </div>	
							   <!-- slider 4 -->
							   <div style="width: 100%;border-bottom: 6px solid #23282d;margin-bottom: 20px;" class="box-slider-mini">
							   		<label> Image 4 </label><br/>   
                                	<input class="input-lemiho" id="slider4" type="text" size="36" name="slider4" value="<?php echo esc_html($slider4); ?>" />
									<br/>
									<?php if(!empty($slider4)) {
									    echo '<img src="' . esc_html($slider4) . '" style="width: 200px;height: auto;">';		
									} ?>
							   </div>	
                            </div> 
			<?php }  
			function register_option_products() { 
					add_meta_box( 'product-option', 'Product option', array('register_system','lemiho_get_html'), 'product' );
			 }  
			function save_option_products($post_id) {
				  $price = sanitize_text_field( $_POST['price_product'] );
				  $hot_product = sanitize_text_field( $_POST['hot_product'] );
				  $sale_product = sanitize_text_field( $_POST['sale_product'] );
				  $slider1 = sanitize_text_field( $_POST['slider1'] );
				  $slider2 = sanitize_text_field( $_POST['slider2'] );
				  $slider3 = sanitize_text_field( $_POST['slider3'] );
				  $slider4 = sanitize_text_field( $_POST['slider4'] );
				  update_post_meta( $post_id, 'price_product', $price );
				  update_post_meta( $post_id, 'hot_product', $hot_product );
				  update_post_meta( $post_id, 'sale_product', $sale_product );
				  update_post_meta( $post_id, 'slider1', $slider1 );
				  update_post_meta( $post_id, 'slider2', $slider2 );
				  update_post_meta( $post_id, 'slider3', $slider3 );
				  update_post_meta( $post_id, 'slider4', $slider4 );
			} 
			/**
			 @=============== Single product template ==========
			 **/
			function get_custom_post_type_template_single($single_template) {
			     global $post;

			     if ($post->post_type == 'product') {
			          $single_template = dirname( __FILE__ ) . '/template/single-product.php';
			     }
			     return $single_template;

			}
			/**
			 @=============== Category & Tag & Search product template ==========
			 **/
			function get_custom_taxonomy_template($template) {
			// this 's system swith category or tag 
			// action 	
			    if( is_tax('category-product')) {
			        $template = dirname( __FILE__ ) . '/template/category-product.php';
			    } else if (is_tax('tag-product')){
			    	$template = dirname( __FILE__ ) . '/template/tags-product.php';
			    }
			    return $template;
			}
			// search template
			function get_search_template_on_lemiho($template) {
				  
				  if(is_search()) {
				  	   if(!empty($_GET['lemiho_type']) & !empty($_GET['s'])) {
				  	   	  $template = dirname( __FILE__ ) . '/template/search-product.php'; 		
				  	   }
				  }  
				  return $template;
			}
			function register_search_widgets() {
			    register_widget('Lemiho_search_product');
			}
			function register_cart_widgets() {
			    register_widget('Lemiho_cart_widgets');
			}
    }
    //text doamin
	add_action('init',array('register_system','textdomain'));
	// register cart
	add_action('init',array('register_system','register_cart'));
	// register category product
	add_action('init', array('register_system','register_categories_products'));
	// register taxonomy
	add_action('init', array('register_system','register_tag_taxonomies'));
	// register option
	add_action('add_meta_boxes',array('register_system','register_option_products'));
	// register save option
	add_action('save_post',array('register_system','save_option_products'));
	// get template post ype
	add_filter('single_template', array('register_system','get_custom_post_type_template_single'));
	// get template category & tags
	add_filter('template_include', array('register_system','get_custom_taxonomy_template'));
	// get search template
	add_filter('template_include', array('register_system','get_search_template_on_lemiho'));
	// register search widgets
    add_action('widgets_init',array('register_system','register_search_widgets'));
    // register cart widgets
    add_action('widgets_init',array('register_system','register_cart_widgets'));






