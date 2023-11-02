<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/public
 * @author     Rahul Pranami <rahulpranami101@gmail.com>
 */
class Multi_Vendor_Store_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multi-vendor-store-public.css', array(), $this->version, 'all' );

		if ('store_branch' == get_post_type() || 'product'== get_post_type() ) {
			if (get_option('mapbox_version') == 'v3')
				wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.1/mapbox-gl.css', [], $this->version);
			else
				wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css', [], $this->version);

			wp_enqueue_style( 'location', plugin_dir_url(__FILE__) . 'css/multi-vendor-store-location.css', [], $this->version );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multi-vendor-store-public.js', array( 'jquery' ), $this->version, false );

		if ('store_branch' == get_post_type() || 'product'== get_post_type() ) {
			if (get_option('mapbox_version') == 'v3')
				wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.1/mapbox-gl.js', ['jquery'], $this->version, true);
			else
				wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js', ['jquery'], $this->version, true);

			if (!empty(get_option('mapbox_api_key'))) {
				wp_enqueue_script('location', plugin_dir_url(__FILE__) . 'js/multi-vendor-store-location.js', ['jquery'], $this->version, true);
				wp_localize_script('location', 'mapbox', ['apiKey' => get_option('mapbox_api_key'), 'style' => get_option('mapbox_field_style')]);
			}

		}

	}

	public function store_location_map($content) {

		// Check if it's the desired custom post type
		if (is_singular('store_branch')) {
			require_once __DIR__ .'/partials/multi-vendor-store-location.php';
		}
		return $content;
	}

    public function product_store_location_tab($tabs) {
		global $post;

		$vendors = get_post_meta($post->ID, '_store_branches', true);
		$locations = [];

		if (empty($vendors))
			return $tabs;

		foreach ($vendors as $vendor) {
			$locations[$vendor] = [(float) get_post_meta($vendor, '_store_branch_location_longitude', true), (float) get_post_meta($vendor, '_store_branch_location_latitude', true)];
		}

		wp_localize_script('location', 'stores', [ 'locations' => $locations ]);

		$geojson = array(
			'type'=> 'FeatureCollection',
			'features'=> array()
		);

		foreach ($vendors as $vendor) {

			$thumbnail = get_the_post_thumbnail_url($vendor);
			if (empty($thumbnail))
				$thumbnail = plugin_dir_url(__FILE__) . 'images/marker.png';

			$vendor_data = array(
				'type' => 'Feature',
				'geometry' => array(
					'type' => 'Point',
					'coordinates' => array(
						(float) get_post_meta($vendor, '_store_branch_location_longitude', true),
						(float) get_post_meta($vendor, '_store_branch_location_latitude', true)
					)
				),
				'properties' => array(
					'title' => get_the_title($vendor),
					'description' => get_post_meta($vendor, '_store_description', true),
					'image' => $thumbnail
				)
			);

			array_push($geojson['features'], $vendor_data);
		}

		wp_localize_script('location', 'geojson', $geojson );

		$tabs['stores_location'] = [
			'title'     => __('Stores Location', 'woocommerce'),
			'priority'  => 20,
			'callback'  => function () {
				echo '<div id="map" style="width: 100%; height: 500px;"></div>';
			},
		];

		return $tabs;
	}

}
