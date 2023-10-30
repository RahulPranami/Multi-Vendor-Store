<?php

use WpOrg\Requests\Session;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://rahulpranami.co
 * @since      1.0.0
 *
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Multi_Vendor_Store
 * @subpackage Multi_Vendor_Store/includes
 * @author     Rahul Pranami <rahulpranami101@gmail.com>
 */
class Multi_Vendor_Store {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Multi_Vendor_Store_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MULTI_VENDOR_STORE_VERSION' ) ) {
			$this->version = MULTI_VENDOR_STORE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'multi-vendor-store';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->register_cpt();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Multi_Vendor_Store_Loader. Orchestrates the hooks of the plugin.
	 * - Multi_Vendor_Store_i18n. Defines internationalization functionality.
	 * - Multi_Vendor_Store_Admin. Defines all hooks for the admin area.
	 * - Multi_Vendor_Store_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multi-vendor-store-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multi-vendor-store-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-multi-vendor-store-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-multi-vendor-store-public.php';

		/**
		 * The class responsible for registering custom post type.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-multi-vendor-store-cpt.php';

		$this->loader = new Multi_Vendor_Store_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Multi_Vendor_Store_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Multi_Vendor_Store_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Multi_Vendor_Store_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$this->loader->add_filter( 'manage_product_posts_columns', $plugin_admin, 'add_shop_vendors_column' );
		$this->loader->add_filter( 'manage_product_posts_custom_column', $plugin_admin, 'show_shop_vendors_column_data', 10, 2 );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Multi_Vendor_Store_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'the_content', $plugin_public, 'store_location_map' );
		$this->loader->add_filter( 'woocommerce_product_tabs', $plugin_public, 'product_store_location_tab' );

	}

	/**
	 * Register custom post type and it's functionality.
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function register_cpt() {

		$plugin_cpt = new Multi_Vendor_Store_CPT( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_cpt, 'store_branch_post_type' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_cpt, 'store_branch_metabox' );
		$this->loader->add_action( 'save_post', $plugin_cpt, 'store_branch_meta_save' );
		// $this->loader->add_filter( 'gettext', $plugin_cpt, 'change_excerpt_label' , 10, 2 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Multi_Vendor_Store_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
