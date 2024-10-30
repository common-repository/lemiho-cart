<?php /**
 * Adds Foo_Widget widget.
 */
class Lemiho_cart_widgets extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'lemiho_cart_widgets', // Base ID
			esc_html__( 'Lemiho cart widget', 'lemiho_bsn' ), // Name
			array( 'description' => esc_html__( 'Cart widget', 'lemiho_bsn' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$lemiho = new Lemiho;
		echo '<ul class="lemiho-widget-group">';
		$total_price = $lemiho->total_price();
		$total_product = $_SESSION['total_qty'];
		echo '<li>
		          <a href="' . get_page_link(esc_attr(get_option('checkout_page'))) .'">
			      <img alt="Lemiho cart plugin" class="lemiho-icon-shop-widget" src="' . plugins_url("img/shop_cart.png",dirname(__FILE__)) . '"/>
			      </a>
			      <div class="text-after-icon-lmh">
			      		<a href="' . get_page_link(esc_attr(get_option('checkout_page'))) .'">	
			             <span>' . $total_product . '</span>
			            </a> 
			      </div>
		      </li>';
		echo '<li><a href="' . get_page_link(esc_attr(get_option('checkout_page'))) . '">' . '$ ' . $total_price . ' ' . esc_html(get_option('text_unit_bill')) . '</a></li>';
		echo '</ul>';
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'lemiho_bsn' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'lemiho_bsn' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

} 