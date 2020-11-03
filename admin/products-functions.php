<?php
    function register_products_post_type() {
        $product_labels = array(
            'name'               => _x( 'Products', 'post type general name', 'product' ),
            'singular_name'      => _x( 'Products', 'post type singular name', 'product' ),
            'menu_name'          => _x( 'Products', 'admin menu', 'product' ),
            'edit_item'          => __( 'Edit Product', 'product' ),
            'view_item'          => __( 'View Product', 'product' ),
            'all_items'          => __( 'Products', 'product' ),
            'search_items'       => __( 'Search Product', 'product' ),
            'parent_item_colon'  => __( 'Parent product:', 'product' ),
            'not_found'          => __( 'Not found.', 'product' ),
            'not_found_in_trash' => __( 'Not found in trash.', 'product' )
        );

        $product_args = array(
            'labels'             => $product_labels,
            'show_in_rest'       => true,
            'description'        => __( 'Description.', 'product' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-feedback',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'products' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
        );
        register_post_type( 'products', $product_args );
    }

    function register_brand_post_type() {
        $brand_labels = array(
            'name'               => _x( 'Brands', 'post type general name', 'product' ),
            'singular_name'      => _x( 'Brand', 'post type singular name', 'product' ),
            'menu_name'          => _x( 'Brands', 'admin menu', 'product' ),
            'edit_item'          => __( 'Edit Brand', 'product' ),
            'view_item'          => __( 'View Brand', 'product' ),
            'all_items'          => __( 'Brands', 'product' ),
            'search_items'       => __( 'Search Brand', 'product' ),
            'parent_item_colon'  => __( 'Parent Brand:', 'product' ),
            'not_found'          => __( 'Not found.', 'product' ),
            'not_found_in_trash' => __( 'Not found in trash.', 'product' )
        );

        $brand_args = array(
            'labels'             => $brand_labels,
            'show_in_rest'       => true,
            'description'        => __( 'Description.', 'brand' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => 'edit.php?post_type=products',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'brand' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
        );
        register_post_type( 'brand', $brand_args );
    }

    function create_product_category_taxonomy() {
        $labels = array(
            'name' => _x( 'Categories', 'taxonomy general name' ),
            'singular_name' => _x( 'Category', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Categories' ),
            'all_items' => __( 'All Categories' ),
            'parent_item' => __( 'Parent Category' ),
            'parent_item_colon' => __( 'Parent Category:' ),
            'edit_item' => __( 'Edit Category' ), 
            'update_item' => __( 'Update Category' ),
            'add_new_item' => __( 'Add New Category' ),
            'new_item_name' => __( 'New Category Name' ),
            'menu_name' => __( 'Categories' ),
        );    
        
        // Now register the taxonomy
        register_taxonomy('category',
            array('products'), 
                array(
                    'hierarchical'      => true,
                    'labels'            => $labels,
                    'show_ui'           => true,
                    'show_in_rest'      => true,
                    'show_admin_column' => true,
                    'query_var'         => true,
                    'rewrite'           => array( 'slug' => 'subject' ),
                )
            );
    }
    
    function get_all_brands() {
        return get_posts(array(
            'post_type'         => 'brand',
            'post_status'       => 'publish',
            'posts_per_page'    => -1
        ));
    }

    function create_custom_fields() {
        add_meta_box("custom-field-brand-meta", "Brand", "custom_field_brand", "products", "side", "low");
        add_meta_box("custom-field-date-meta", "Date of Expiry", "custom_field_date", "products", "side", "low");
    }

    function custom_field_brand() {
        global $post;
        $brands = get_all_brands();
        wp_nonce_field( 'brand_id_nonce', 'brand_id_nonce' );
        $brand_id = get_post_meta( $post->ID, '_brand_id', true );
             
        echo "<select name='brand_id'>";
        echo "<option " . ((empty($brand_id)) ? 'selected' : '') . " value=''> Ninguno </option>";
        foreach ( $brands as $brand ) {                        
            echo "<option " . (($brand_id == $brand->ID) ? 'selected' : '') .
                    " value='" . $brand->ID . "'>" . $brand->post_title . "</option>";
        }
        echo "<select>";
    }

    function custom_field_date() {
        global $post;
        $date = get_post_meta( $post->ID, '_date', true );
        echo '<input type="date" name="date" id="date" value="' . $date . '" />';
    }

    function save_custom_fields( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['brand_id_nonce'] ) ) {
            return;
        }

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $_POST['brand_id_nonce'], 'brand_id_nonce' ) ) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check the user's permissions.
        if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        }
        else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        // Make sure that it is set.
        if ( ! isset( $_POST['brand_id'] ) || ! isset( $_POST['date'] ) ) {
            return;
        }

        // Sanitize user input.
        $brand_id = sanitize_text_field( $_POST['brand_id'] );
        $date = sanitize_text_field( $_POST['date'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_brand_id', $brand_id );
        update_post_meta( $post_id, '_date', $date );
    }
    
?>