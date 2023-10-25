<?php

/**
 * The Custom Post Type of the plugin.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/includes
 */

/**
 * The Custom Post Type of the plugin.
 *
 * Generates a Custom Post Type named Store Branch ( store_branch ).
 * To Manage multiple vendors.
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/includes
 * @author     Rahul Pranami <rahulpranami101@gmail.com>
 */
class Multi_Vendor_Store_CPT {

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
	 * Register the custom post type for the Store Branch.
	 *
	 * @since    1.0.0
	 */
	public function store_branch_post_type() {
		$labels = [
			'name'                  => _x('Store Branches', 'Post Type General Name', 'default'),
			'singular_name'         => _x('Store Branch', 'Post Type Singular Name', 'default'),
			'menu_name'             => __('Store Branches', 'default'),
			'name_admin_bar'        => __('Store Branch', 'default'),
			'archives'              => __('Store Branch Archives', 'default'),
			'attributes'            => __('Store Branch Attributes', 'default'),
			'parent_item_colon'     => __('Parent Store Branch:', 'default'),
			'all_items'             => __('Store Branch', 'default'),
			'add_new_item'          => __('Add New Store Branch', 'default'),
			'add_new'               => __('Add New', 'default'),
			'new_item'              => __('New Store Branch', 'default'),
			'edit_item'             => __('Edit Store Branch', 'default'),
			'update_item'           => __('Update Store Branch', 'default'),
			'view_item'             => __('View Store Branch', 'default'),
			'view_items'            => __('View Store Branches', 'default'),
			'search_items'          => __('Search Store Branch', 'default'),
			'not_found'             => __('Not found', 'default'),
			'not_found_in_trash'    => __('Not found in Trash', 'default'),
			'featured_image'        => __('Shop Image', 'default'),
			'set_featured_image'    => __('Set Shop image', 'default'),
			'remove_featured_image' => __('Remove Shop image', 'default'),
			'use_featured_image'    => __('Use as Shop image', 'default'),
			'insert_into_item'      => __('Insert into Store Branch', 'default'),
			'uploaded_to_this_item' => __('Uploaded to this Store Branch', 'default'),
			'items_list'            => __('Store Branches list', 'default'),
			'items_list_navigation' => __('Store Branches list navigation', 'default'),
			'filter_items_list'     => __('Filter Store Branches list', 'default'),
		];
		$args = [
			'label'                 => __('Store Branch', 'default'),
			'description'           => __('Branch of a Store', 'default'),
			'labels'                => $labels,
			'supports'              => ['title', 'editor', 'thumbnail'],
			'taxonomies'            => ['category', 'post_tag'],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => 'woocommerce',
			'menu_position'         => 52,
			'menu_icon'             => 'dashicons-store',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'store-branch',
			'rewrite'                    => ['slug' => 'store-branch'],
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		];
		register_post_type('store_branch', $args);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	// public function enqueue_styles() {

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

	// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/multi-vendor-store-admin.css', array(), $this->version, 'all' );

	// }

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	// public function enqueue_scripts() {

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

	// wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/multi-vendor-store-admin.js', array( 'jquery' ), $this->version, false );

	// }

	public function store_location_metabox() {

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://referential.p.rapidapi.com/v1/city?ip=128.218.229.26",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => [
				"X-RapidAPI-Host: referential.p.rapidapi.com",
				"X-RapidAPI-Key: 26ca1397e7msh6318f14ea0be625p12119fjsn14f5fad24fb3"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			// echo $response;
			error_log($response);
		}

	}

	/**
	 * Summary of store_branch_metabox
	 * @return void
	 */
	function store_branch_metabox() {

		add_meta_box(
			'store_branch_location',
			'Store Branch',
			function ($post) {
				$store_location = get_post_meta($post->ID, '_store_branch_location', true);
				$store_location_latitude = get_post_meta($post->ID, '_store_branch_location_latitude', true);
				$store_location_longitude = get_post_meta($post->ID, '_store_branch_location_longitude', true);
				$store_location_fetched = get_post_meta($post->ID, '_store_branch_location_fetched', true);
				ob_start();
?>
			<div class="store-location-meta">
				<label for="store-location">Store Location</label>
				<input type="text" id="store-branch-location" class="search-box" name="_store_branch_location" value="<?php echo $store_location; ?>" />
				<!-- <div id="fetched-locations"></div> -->

				<input type="text" id="store-branch-location-fetched" name="_store_branch_location_fetched" value="<?php echo $store_location_fetched  ?>" readonly />
				<input type="text" id="store-branch-latitude" name="_store_branch_latitude" value="<?php echo $store_location_latitude  ?>" readonly />
				<input type="text" id="store-branch-longitude" name="_store_branch_longitude" value="<?php echo $store_location_longitude ?>" readonly />
				<ul id="fetched-locations"></ul>
			</div>
			<iframe src="https://www.w3schools.com" title="W3Schools Free Online Web Tutorials" height="500px" width="500px">
<?php
				echo ob_get_clean();
			},
			'store_branch',
			'normal'
		);

		add_meta_box(
			'store_branches',
			'Product Vendors',
			function ($post) {
				$saved_vendors = get_post_meta($post->ID, '_store_branches', true);
				$vendors = get_posts(['post_type' => 'store_branch', 'posts_per_page' => -1]);

				echo '<div class=""tabs-panel" style="max-height:200px;overflow:auto;">';
				echo '<ul>';
				foreach ($vendors as $vendor) :
					$checked = (is_array($saved_vendors)) ? checked(in_array($vendor->ID, $saved_vendors), true, false) : false;
					echo '<li>';
					echo '<input type="checkbox" id="vendor_' . $vendor->ID . '" name="_store_branches[]" value="' . $vendor->ID . '" ' . $checked . '>';
					echo '<label for="vendor_' . $vendor->ID . '">' . $vendor->post_title . '</label>';
					echo '</li>';
				endforeach;
				echo '</ul>';
				echo '</div>';
			},
			'product',
			'side',
			'high'
		);

	}

	/**
	 * Used to Save meta box information to database
	 *
	 * @param mixed $post_id Id of the post being saved
	 * @return void
	 */
	function store_branch_meta_save($post_id)
	{

		if (isset($_POST['_store_branch_location'])) {

			// $location = $this->get_location($_POST['_store_branch_location']);
			// _store_branch_latitude
			// error_log('261 Location : ' . print_r($location, true));

			// $meta_value = sanitize_text_field($_POST['_store_branch_location']);
			// $meta_value_latitude = sanitize_text_field($_POST['_store_branch_latitude']);
			// $meta_value_longitude = sanitize_text_field($_POST['_store_branch_longitude']);
			// $meta_value_fetched = sanitize_text_field($_POST['_store_branch_location_fetched']);
			update_post_meta($post_id, '_store_branch_location', sanitize_text_field($_POST['_store_branch_location']));
			update_post_meta($post_id, '_store_branch_location_latitude', sanitize_text_field($_POST['_store_branch_latitude']));
			update_post_meta($post_id, '_store_branch_location_longitude', sanitize_text_field($_POST['_store_branch_longitude']));
			update_post_meta($post_id, '_store_branch_location_fetched', sanitize_text_field($_POST['_store_branch_location_fetched']));
		}

		if (isset($_POST['_store_branches'])) {
			update_post_meta($post_id, '_store_branches', $_POST["_store_branches"]);
		}
	}

	// private function get_location($address)
	// {
	// 	$api_url = "https://geocode.maps.co/search?q=";


	// 	$location = null;


	// 	return $location;
	// }

}


add_filter(
	'acf/load_field/key=field_6036a2d434136',
	function ($field) {
		// Check the current blog id
		$blog_id = get_current_blog_id();

		// Define the blog ids where specific item should be removed
		$blog_ids_to_modify = array(2, 3); // Replace with your blog ids

		// Check if the current blog id is in the defined list
		if (in_array($blog_id, $blog_ids_to_modify)) {
			// Define the item to remove
			$item_to_remove = 'Item to Remove'; // Replace with your item

			// Remove the item from choices
			if (($key = array_search($item_to_remove, $field['choices'])) !== false) {
				unset($field['choices'][$key]);
			}
		}
		return $field;
	}
);
