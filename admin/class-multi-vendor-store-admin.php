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
class Multi_Vendor_Store_Admin
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
		add_action('restrict_manage_posts', [$this, 'filter_custom_post_type_by_category'], 10, 2);
		add_action('pre_get_posts', [$this, 'filter_custom_posts_by_meta_field']);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/multi-vendor-store-admin.css', array(), $this->version, 'all');

		if ('store_branch' ===  $current_screen->post_type) {
			wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css', [], $this->version);
			wp_enqueue_style('location', plugin_dir_url(__FILE__) . 'css/multi-vendor-store-location.css', [], $this->version);
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		if ('store_branch' ===  $current_screen->post_type) {
			wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js', ['jquery'], $this->version, true);
			wp_enqueue_script('location', plugin_dir_url(__FILE__) . 'js/multi-vendor-store-location.js', ['jquery'], $this->version, true);
			wp_localize_script('location', 'mapbox', ['apiKey' => MAPBOX_API_KEY]);
		}
	}

	function add_shop_vendors_column($columns)
	{
		$columns['shop_vendors'] = __('Shop Vendors', 'textdomain');
		return $columns;
	}

	function show_shop_vendors_column_data($column, $post_id)
	{
		if ($column == 'shop_vendors') {
			$vendors = get_post_meta($post_id, '_store_branches', true);

			if ($vendors) {
				$vendorString = '';
				foreach ($vendors as $vendor) {
					$vendorString .= '<a href="' . get_post_type_archive_link('store_branch') . '?vendor=' . $vendor . '">' . get_the_title($vendor) . '</a> , ';
					// $vendorString .= '<a href="' . get_edit_post_link($vendor) . '">' . get_the_title($vendor) . '</a> , ';
				}
				$vendorString = rtrim($vendorString, ' , ');
				echo $vendorString;
			}
		}
	}

	function filter_custom_post_type_by_category($post_type, $which)
	{
		global $typenow;
		global $wpdb;


		if ('product' == $typenow) { // Replace 'my_custom_post' with your custom post type
			$vendors = [];

			$meta_field_values = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key = '_store_branches'");
		?>
			<select name="_store_branches_filter" id="_store_branches_filter">
				<option value=""><?php _e('Filter By Store Branches...', 'woocommerce'); ?></option>
				<?php
				$current_v = isset($_GET['_store_branches_filter']) ? $_GET['_store_branches_filter'] : '';
				foreach ($meta_field_values as $value) {
					$value = unserialize($value);

					foreach ($value as $item) {
						if (!in_array($item, $vendors)) {
							$vendors[] = $item;
						}
					}
				}
				// error_log("This is vendor : ".print_r($vendors, true));

				foreach ($vendors as $vendor) {
					$vendor_title = get_the_title($vendor);
					$vendor_slug = get_post_field('post_name', $vendor);
					$selected = $vendor_slug == $current_v ? ' selected="selected"' : '';
					printf(
						'<option value="%s"%s>%s</option>',
						$vendor,
						$selected,
						$vendor_title
					);
				}
				?>
			</select>
		<?php
		}
	}

	function filter_custom_posts_by_meta_field($query){
		global $pagenow, $typenow;

		$post_type = 'product'; // Replace 'my_custom_post' with your custom post type
		$q_vars    = &$query->query_vars;

		if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($_GET['_store_branches_filter']) && $_GET['_store_branches_filter'] != '') {
			// $q_vars['meta_key'] = '_store_branches'; // Replace 'my_meta_field' with your meta field key
			// $q_vars['meta_value'] = $_GET['_store_branches_filter'];
			// $q_vars['meta_compare'] = '=';

			$meta_query = [[
				'key' => '_store_branches',
				'value' => $_GET['_store_branches_filter'],
				'compare' => 'IN',
			]];
			$query->set('meta_query', $meta_query);
		}
	}
}
