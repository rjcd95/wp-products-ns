<?php
	function brand_register_widget() {
		register_widget( 'brand_widget' );
	}

	class brand_widget extends WP_Widget {
		function __construct() {
			parent::__construct(
				'brand_widget',
				__('Custom Brand List', 'brand_widget_domain'),
				array( 'description' => __( 'A list of brands.', 'brand_widget_domain' ), )
			);
		}

		public function widget( $args, $instance ) {
			echo "<section id='brand-list' class='widget widget_meta'>";
			//title section
			$title = apply_filters( 'widget_title', $instance['title'] );
			if ( ! empty( $title ) )
				echo "<h2 class='widget-title'> " . $title . "</h2>";

			//list section
			$args = array(
				'post_type'   => 'brand',
				'post_status' => 'publish'
			);
			$brands = new WP_Query( $args );
			if( $brands->have_posts() ) :
				echo "<ul>";
				while( $brands->have_posts() ) :
					$brands->the_post();
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
				esc_html_e( 'No brands found!', 'brands_widget_domain' );
			endif;
			echo "</section>";
		}

		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) )
				$title = $instance[ 'title' ];
			else
				$title = __( 'Brand List', 'brands_widget_domain' );
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