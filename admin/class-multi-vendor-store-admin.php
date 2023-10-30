<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/admin
 * @author     Rahul Pranami <rahulpranami101@gmail.com>
 */
class Multi_Vendor_Store_Admin {

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
		 * defined in Multi_Vendor_Store_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Multi_Vendor_Store_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$current_screen = get_current_screen();

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multi-vendor-store-admin.css', array(), $this->version, 'all' );

		if ( 'store_branch' ===  $current_screen->post_type) {
			// wp_enqueue_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css' );
			wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css', [], $this->version );
			// wp_enqueue_style('mapbox-gl-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css', [], $this->version );
			wp_enqueue_style('location', plugin_dir_url(__FILE__) . 'css/multi-vendor-store-location.css', [], $this->version );
		}

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
		 * defined in Multi_Vendor_Store_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Multi_Vendor_Store_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$current_screen = get_current_screen();

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/multi-vendor-store-admin.js', ['jquery'], $this->version, true);

		if ( 'store_branch' ===  $current_screen->post_type) {
			wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js', ['jquery'], $this->version, true);
			// wp_enqueue_script('mapbox-gl-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js', ['jquery'], $this->version, true);
			wp_enqueue_script('location', plugin_dir_url(__FILE__) . 'js/multi-vendor-store-location.js', ['jquery'], $this->version, true);
		}

	}

	function add_shop_vendors_column($columns) {
		$columns['shop_vendors'] = __('Shop Vendors', 'textdomain');
		error_log("Columns : ".print_r($columns, true));
		return $columns;
	}

	function show_shop_vendors_column_data($column, $post_id) {
		if ($column == 'shop_vendors') {
			// output data for shop vendors column
			$vendor = get_post_meta($post_id, 'shop_vendors', true);
			echo $vendor;
		}
	}

}
