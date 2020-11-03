<?php
    function register_products_menu_page() {
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
            'description'        => __( 'Description.', 'product' ),
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'products' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail' )
        );
        register_post_type( 'products', $product_args );
    }
?>