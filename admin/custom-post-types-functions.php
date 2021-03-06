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
    
?>