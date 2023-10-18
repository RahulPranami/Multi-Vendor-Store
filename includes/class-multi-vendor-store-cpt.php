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
            'featured_image'        => __('Featured Image', 'default'),
            'set_featured_image'    => __('Set featured image', 'default'),
            'remove_featured_image' => __('Remove featured image', 'default'),
            'use_featured_image'    => __('Use as featured image', 'default'),
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
            'supports'              => ['title', 'editor'],
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

}
