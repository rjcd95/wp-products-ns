<?php
	function products_register_widget() {
		register_widget( 'products_widget' );
	}

	class products_widget extends WP_Widget {
		function __construct() {
			parent::__construct(
				'products_widget',
				__('Custom Product List', 'products_widget_domain'),
				array( 'description' => __( 'A list of products', 'products_widget_domain' ), )
			);
		}

		public function widget( $args, $instance ) {
			echo "<section id='product-list' class='widget widget_meta'>";
			//title section
			$title = apply_filters( 'widget_title', $instance['title'] );
			if ( ! empty( $title ) )
				echo "<h2 class='widget-title'> " . $title . "</h2>";

			//list section
			$args = array(
				'post_type'   => 'products',
				'post_status' => 'publish'
			);
			$products = new WP_Query( $args );
			if( $products->have_posts() ) :
				echo "<ul>";
				while( $products->have_posts() ) :
					$products->the_post();
					?>
						<li>
							<a href="<?php echo get_permalink();  ?>">
								<?php echo get_the_title();  ?>
							</a>
						</li>
					<?php
				endwhile;
				wp_reset_postdata();
				echo "<ul>";
			else :
				esc_html_e( 'No products found!', 'products_widget_domain' );
			endif;
			echo "</section>";
		}

		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) )
				$title = $instance[ 'title' ];
			else
				$title = __( 'Product List', 'products_widget_domain' );
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">
					<?php _e( 'Title:' ); ?>
				</label>
				<input type="text" class="widefat" 
					id="<?php echo $this->get_field_id( 'title' ); ?>" 
					name="<?php echo $this->get_field_name( 'title' ); ?>" 
					value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	}
?>