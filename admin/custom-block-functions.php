<?php

function get_post_image_by_id($post_id) {
    $default_img = plugins_url( 'img/default.jpg', __FILE__ );
    $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );
    if($image_url == null) return $default_img;
    return $image_url[0];
}

function get_list_of_items($items){
    $content = '<h4 class="block-title">'. $title .'</h4><hr>';
    $content = $content . '<ul class="item-list">';
    foreach ( $items as $item ) {            
        $content = $content . '<li class="item">';
        $content = $content . '<div>';
        $post_id    = $item->ID;
        $image_url  = get_post_image_by_id($post_id);
        $permalink  = esc_url( get_permalink( $post_id ));
        $title      = esc_html( get_the_title( $post_id ) );
        $content = $content . '<a class="item-image" href="'. $permalink .'" target="_blank">';
        $content = $content . '<img src="'. $image_url .'" alt="'. $title .'" /></a>';
        $content = $content . '<a class="item-description" href="'. $permalink .'" target="_blank">';
        $content = $content . '<h4>'. $title .'</h4></a>';
        $content = $content . '</li>';
    }
    $content = $content . '</ul><br>';
    return $content;
}

function gutenberg_products_block_render_callback( $block_attributes, $content ) {
    $products = get_posts([
        'post_type'     => 'products',
        'post_status'   => 'publish',
        'numberposts'   => -1
    ]);
    if ( count( $products ) === 0 ) {
        return 'No products';
    } else {
        $content = get_list_of_items($products);
    }

    return $content;
}

function gutenberg_brand_block_render_callback( $block_attributes, $content ) {
    $brands = get_posts([
        'post_type'     => 'brand',
        'post_status'   => 'publish',
        'numberposts'   => -1
    ]);
    if ( count( $brands ) === 0 ) {
        return 'No brands';
    } else {
        $content = get_list_of_items($brands);
    }

    return $content;
}

function gutenberg_products_brand_block_frontend() {
   wp_enqueue_style(
      'gutenberg_block_produts_brand',
      plugins_url( 'css/frontend-block.css', __FILE__ ),
      array()
   );
}
 
function gutenberg_products_brands_block() {
    wp_register_script(
        'products_brand_block',
         plugins_url( 'js/block.js', __FILE__ ),
         array( 'wp-blocks', 'wp-element', 'wp-i18n', 'wp-polyfill' )
    );

    wp_enqueue_style(
        'gutenberg_block_editor',
        plugins_url( 'css/editor-block.css', __FILE__ ),
        array()
    );

    register_block_type( 'gutenberg-block/produts-block', array(
        'editor_script' => 'products_brand_block',
        'render_callback' => 'gutenberg_products_block_render_callback'
    ) );

    register_block_type( 'gutenberg-block/brands-block', array(
        'editor_script' => 'products_brand_block',
        'render_callback' => 'gutenberg_brand_block_render_callback'
    ) );
}

?>