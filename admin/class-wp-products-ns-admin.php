<?php

require plugin_dir_path( __FILE__ ) . 'custom-post-types-functions.php';
require plugin_dir_path( __FILE__ ) . 'acf-functions.php';
require plugin_dir_path( __FILE__ ) . 'custom-block-functions.php';
require plugin_dir_path( __FILE__ ) . 'custom-products-widget-functions.php';
require plugin_dir_path( __FILE__ ) . 'custom-brands-widget-functions.php';
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/rjcd95
 * @since      1.0.0
 *
 * @package    Wp_Products_Ns
 * @subpackage Wp_Products_Ns/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Products_Ns
 * @subpackage Wp_Products_Ns/admin
 * @author     Rjcd95 <rene.cortes@outlook.com>
 */
class Wp_Products_Ns_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->init();

	}


	/**
	 * init all actions
	 */
	private function init() {
		add_action( 'init', 'register_products_post_type' );
		add_action( 'init', 'register_brand_post_type' );
		add_action( 'init', 'create_product_category_taxonomy', 0 );
		
		//gutenberg custom blocks
		add_action( 'init', 'gutenberg_products_brands_block' );
		add_action( 'wp_enqueue_scripts', 'gutenberg_products_brand_block_frontend' );

		//register custom widgets
		add_action( 'widgets_init', 'products_register_widget' );
		add_action( 'widgets_init', 'brand_register_widget' );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Products_Ns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Products_Ns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-products-ns-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Products_Ns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Products_Ns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-products-ns-admin.js', array( 'jquery' ), $this->version, false );

	}

}
