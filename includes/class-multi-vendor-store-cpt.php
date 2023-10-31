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
class Multi_Vendor_Store_CPT
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


	/**
	 * Register the custom post type for the Store Branch.
	 *
	 * @since    1.0.0
	 */
	public function store_branch_post_type()
	{
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
			'supports'              => ['title', 'thumbnail'],
			// 'taxonomies'            => ['category', 'post_tag'],
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

	/**
	 * Summary of store_branch_metabox
	 * @return void
	 */
	function store_branch_metabox()
	{

		add_meta_box(
			'store_details',
			'Store Details',
			function ($post) {
				$store_phone = get_post_meta($post->ID, '_store_phone', true);
				$store_email = get_post_meta($post->ID, '_store_email', true);
				$store_description = get_post_meta($post->ID, '_store_description', true);
				$store_address_line1 = get_post_meta($post->ID, '_store_address_line1', true);
				$store_address_line2 = get_post_meta($post->ID, '_store_address_line2', true);
				$store_city = get_post_meta($post->ID, '_store_city', true);
				$store_state = get_post_meta($post->ID, '_store_state', true);
				$store_country = get_post_meta($post->ID, '_store_country', true);

				ob_start();
?>
			<div class="store-contact-meta store-location-meta">
				<h3 style="color: #0073aa;"><label for="store-phone">Store Contact Number</label></h3>
				<input type="number" id="store-phone" class="widefat" name="_store_phone" value="<?php echo $store_phone; ?>" />
			</div>
			<div class="store-contact-meta store-location-meta">
				<h3 style="color: #0073aa;"><label for="store-email">Store Email</label></h3>
				<input type="email" id="store-email" class="widefat store-input" name="_store_email" value="<?php echo $store_email; ?>" />
			</div>

			<div class="store-description-meta store-location-meta">
				<h3 style="color: #0073aa;"><label for="store-description">Store Description</label></h3>
				<textarea id="store-description" class="widefat" name="_store_description"><?php echo $store_description; ?></textarea>
			</div>

			<div class="store-address-meta store-location-meta">
				<h3 style="color: #0073aa;">Store Address</h3>
				<div style="display: flex; justify-content: space-between;">
					<p style="width: 45%;">
						<label class="store-label" for="store-address-line1">Address Line 1</label>
						<input type="text" id="store-address-line1" class="widefat" name="_store_address_line1" value="<?php echo $store_address_line1; ?>" />
					</p>
					<p style="width: 45%;">
						<label class="store-label" for="store-address-line2">Address Line 2</label>
						<input type="text" id="store-address-line2" class="widefat" name="_store_address_line2" value="<?php echo $store_address_line2; ?>" />
					</p>
				</div>
				<div style="display: flex; justify-content: space-between;">
					<p style="width: 45%;">
						<label class="store-label" for="store-city">City</label>
						<input type="text" id="store-city" class="widefat" name="_store_city" value="<?php echo $store_city; ?>" />
					</p>
					<p style="width: 45%;">
						<label class="store-label" for="store-state">State</label>
						<input type="text" id="store-state" class="widefat" name="_store_state" value="<?php echo $store_state; ?>" />
					</p>
				</div>
				<div>
					<p style="width: 45%;">
						<label class="store-label" for="store-country">Country</label>
						<input type="text" id="store-country" class="widefat" name="_store_country" value="<?php echo $store_country; ?>" />
					</p>
				</div>
			</div>
		<?php
				echo ob_get_clean();
			},
			'store_branch',
			'normal'
		);

		add_meta_box(
			'store_branch_location',
			'Store Branch Location',
			function ($post) {
				// $store_location = get_post_meta($post->ID, '_store_branch_location', true);
				$store_location_latitude = get_post_meta($post->ID, '_store_branch_location_latitude', true);
				$store_location_longitude = get_post_meta($post->ID, '_store_branch_location_longitude', true);
				$store_location_fetched = get_post_meta($post->ID, '_store_branch_location_fetched', true);
				ob_start();
		?>
			<div class="store-location-meta">
				<h3>Store Location <span>( Enter the location in text or select it from the map below. )</span></h3>
				<label class="store-label" for="store-location">Search Location (Text)</label>
				<input type="text" id="store-branch-location" class="widefat store-input" name="_store_branch_location" />

				<div id="fetched-locations"></div>
			</div>
			<div class="store-location-meta">
				<h3>Store Location <span>(Selected from Map)</span></h3>
				<label class="store-label" for="store-location-fetched">Location</label>
				<input type="text" class="store-input" id="store-branch-location-fetched" name="_store_branch_location_fetched" value="<?php echo $store_location_fetched  ?>" readonly />
				<label class="store-label" for="store-latitude">Latitude</label>
				<input type="text" class="store-input" id="store-branch-latitude" name="_store_branch_latitude" value="<?php echo $store_location_latitude  ?>" readonly />
				<label class="store-label" for="store-longitude">Longitude</label>
				<input type="text" class="store-input" id="store-branch-longitude" name="_store_branch_longitude" value="<?php echo $store_location_longitude ?>" readonly />
			</div>
			<div id='map'></div>
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

				echo '<div class="tabs-panel" style="max-height:200px;overflow:auto;border:1px solid #ddd;padding:10px;border-radius:5px;">';
				echo '<ul style="list-style:none;padding:0;">';
				foreach ($vendors as $vendor) :
					$checked = (is_array($saved_vendors)) ? checked(in_array($vendor->ID, $saved_vendors), true, false) : false;
					echo '<li style="margin-bottom:10px;">';
					echo '<input type="checkbox" id="vendor_' . $vendor->ID . '" name="_store_branches[]" value="' . $vendor->ID . '" ' . $checked . ' style="margin-right:5px;">';
					echo '<label for="vendor_' . $vendor->ID . '" style="font-size:14px;color:#333;">' . $vendor->post_title . '</label>';
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

		// if (isset($_POST['_store_branch_location']))
		// 	update_post_meta($post_id, '_store_branch_location', sanitize_text_field($_POST['_store_branch_location']));

		if (isset($_POST['_store_branch_location_latitude']))
			update_post_meta($post_id, '_store_branch_location_latitude', sanitize_text_field($_POST['_store_branch_latitude']));

		if (isset($_POST['_store_branch_location_longitude']))
			update_post_meta($post_id, '_store_branch_location_longitude', sanitize_text_field($_POST['_store_branch_longitude']));

		if (isset($_POST['_store_branch_location_fetched']))
			update_post_meta($post_id, '_store_branch_location_fetched', sanitize_text_field($_POST['_store_branch_location_fetched']));

		if (isset($_POST['_store_phone']))
			update_post_meta($post_id, '_store_phone', sanitize_text_field($_POST['_store_phone']));

		if (isset($_POST['_store_email']))
			update_post_meta($post_id, '_store_email', sanitize_text_field($_POST['_store_email']));

		if (isset($_POST['_store_description']))
			update_post_meta($post_id, '_store_description', sanitize_text_field($_POST['_store_description']));

		if (isset($_POST['_store_branches']) && !empty($_POST['_store_branches'])) {
			update_post_meta($post_id, '_store_branches', $_POST["_store_branches"]);
		} else {
			delete_post_meta($post_id, '_store_branches');
		}

		if (isset($_POST['_store_address_line1']))
			update_post_meta($post_id, '_store_address_line1', sanitize_text_field($_POST['_store_address_line1']));

		if (isset($_POST['_store_address_line2']))
			update_post_meta($post_id, '_store_address_line2', sanitize_text_field($_POST['_store_address_line2']));

		if (isset($_POST['_store_city']))
			update_post_meta($post_id, '_store_city', sanitize_text_field($_POST['_store_city']));

		if (isset($_POST['_store_state']))
			update_post_meta($post_id, '_store_state', sanitize_text_field($_POST['_store_state']));

		if (isset($_POST['_store_country']))
			update_post_meta($post_id, '_store_country', sanitize_text_field($_POST['_store_country']));
	}
}
