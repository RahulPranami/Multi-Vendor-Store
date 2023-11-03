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
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// add_action('restrict_manage_posts', [$this, 'filter_custom_post_type_by_category'], 10, 2);
		// add_action('pre_get_posts', [$this, 'filter_custom_posts_by_meta_field']);
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/multi-vendor-store-admin.css', array(), $this->version, 'all');

		if ('store_branch' ===  $current_screen->post_type) {
			if (get_option('mapbox_version') == 'v3')
				wp_enqueue_style( 'mapbox', plugin_dir_url( __FILE__ ) . 'css/mapbox-gl-v3.css', array(), $this->version );
			else
				wp_enqueue_style( 'mapbox', plugin_dir_url( __FILE__ ) . 'css/mapbox-gl-v2.css', array(), $this->version );
				// wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.1/mapbox-gl.css', [], $this->version);
				// wp_enqueue_style('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css', [], $this->version);

			wp_enqueue_style('mapbox-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css', [], $this->version);
			wp_enqueue_style('location', plugin_dir_url(__FILE__) . 'css/multi-vendor-store-location.css', [], $this->version);
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

		if (is_object($current_screen) && 'store_branch' ===  $current_screen->post_type) {
			if (get_option('mapbox_version') == 'v3')
				wp_enqueue_script( 'mapbox', plugin_dir_url( __FILE__ ) . 'js/mapbox-gl-v3.js', array( 'jquery' ), $this->version, false );
			else
				wp_enqueue_script( 'mapbox', plugin_dir_url( __FILE__ ) . 'js/mapbox-gl-v2.js', array( 'jquery' ), $this->version, false );
				// wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v3.0.0-beta.1/mapbox-gl.js', ['jquery'], $this->version, true);
				// wp_enqueue_script('mapbox', 'https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js', ['jquery'], $this->version, true);

			wp_enqueue_script('mapbox-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js', ['jquery'], $this->version, true);

			if ($this->check_api_key()) {
				wp_enqueue_script('location', plugin_dir_url(__FILE__) . 'js/multi-vendor-store-location.js', ['jquery'], $this->version, true);
				wp_localize_script('location', 'mapbox', ['apiKey' => get_option('mapbox_api_key'), 'style' => get_option('mapbox_field_style')]);
			}

		}
	}

	public function check_api_key() {

		if (empty(get_option('mapbox_api_key'))) {
			add_action('admin_notices', function () {
				$notice = '<div class="notice notice-error"><p>Warning Please add your Mapbox API key in the plugin settings to activate the plugin. You can find your API key at <a href="https://account.mapbox.com/access-tokens/"> https://account.mapbox.com/access-tokens/ </a> and add here <a href="' . admin_url('admin.php?page=mapbox-settings') . '"> Mapbox Settings Page </a> </p></div>';
				echo $notice;
			});
			return false;
		} else {
			return true;
		}
	}

	public function validate_api_key( $api_key ) {
		// Initialize cURL
		$ch = curl_init();

		// Set the URL
		$url = 'https://api.mapbox.com/tokens/v2?access_token=' . urlencode($api_key);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Execute the cURL request
		$response = curl_exec($ch);

		// Check for cURL errors
		if (curl_errno($ch)) {
			$error_msg = 'cURL Error: ' . curl_error($ch);
			curl_close($ch);
			add_settings_error('mapbox_messages', 'mapbox_message', __($error_msg, 'default'), 'error');
			return false;
		}

		// Check the response status code
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		// Close the cURL session
		curl_close($ch);

		if ($http_code === 200) {
			// Parse the JSON response
			$data = json_decode($response, true);

			// Check if the token is valid
			if (isset($data['code']) && $data['code'] === 'TokenValid') {
				add_settings_error('mapbox_messages', 'mapbox_message', __('API Key Saved Successfully.', 'default'), 'updated');
				return true;
			} elseif (isset($data['code']) && $data['code'] === 'TokenMalformed') {
				add_settings_error('mapbox_messages', 'mapbox_message', __('Token is malformed.', 'default'), 'error');
				return false;
			} elseif (isset($data['code']) && $data['code'] === 'TokenExpired') {
				add_settings_error('mapbox_messages', 'mapbox_message', __('Token has expired.', 'default'), 'error');
				return false;
			} elseif (isset($data['code']) && $data['code'] === 'TokenRevoked') {
				add_settings_error('mapbox_messages', 'mapbox_message', __('Token has been revoked.', 'default'), 'error');
				return false;
			} else {
				add_settings_error('mapbox_messages', 'mapbox_message', __('Unknown token error.', 'default'), 'error');
				return false;
			}
		} else {
			add_settings_error('mapbox_messages', 'mapbox_message', __('Error checking token validity.', 'default'), 'error');
			return false;
		}
	}

	public function mapbox_options_page() {

		add_menu_page(
			'Mapbox Settings',
			'Mapbox Settings',
			'manage_options',
			'mapbox-settings',
			[$this, 'mapbox_settings_callback'],
			'dashicons-location-alt',
			80
		);
	}

	public function mapbox_settings_callback() {

		if (!current_user_can('manage_options'))
			return;

		if (isset($_GET['settings-updated']) && get_option('api_key_valid'))
			add_settings_error('mapbox_messages', 'mapbox_message', __('Settings Saved', 'mapbox'), 'updated');

		settings_errors('mapbox_messages');
?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form method="post" action="options.php">
				<?php
				settings_fields('mapbox');
				do_settings_sections('mapbox');
				submit_button('Save Settings');
				?>
			</form>
		</div>
		<?php
	}

	public function mapbox_settings_init() {

		register_setting('mapbox', 'mapbox_options');

		add_settings_section(
			'mapbox_settings_section',
			__('Mapbox API Key Settings.', 'default'),
			[$this, 'mapbox_settings_section_cb'],
			'mapbox'
		);

		add_settings_field(
			'mapbox_api_key',
			__('Mapbox API Key', 'default'),
			[$this, 'mapbox_field_api_key'],
			'mapbox',
			'mapbox_settings_section',
			array(
				'label_for'         => 'mapbox_api_key',
				'class'             => 'mapbox_api_key'
			)
		);

		if (get_option('api_key_valid')) {
			add_settings_field(
				'mapbox_version',
				__('Mapbox Version', 'default'),
				[$this, 'mapbox_field_version'],
				'mapbox',
				'mapbox_settings_section',
				array(
					'label_for'         => 'mapbox_version',
					'class'             => 'mapbox_version'
				)
			);

			add_settings_field(
				'mapbox_style',
				__('Mapbox Style', 'default'),
				[$this, 'mapbox_field_style'],
				'mapbox',
				'mapbox_settings_section',
				array(
					'label_for'         => 'mapbox_field_style',
					'class'             => 'mapbox_field_style'
				)
			);
		}
	}

	public function mapbox_settings_section_cb($args) {
		echo '<a href="https://docs.mapbox.com/">Documentation for Mapbox</a>';
	}

	public function mapbox_field_api_key() {
		$api_key = get_option('mapbox_api_key');
		echo '<input type="text" id="mapbox_api_key" name="mapbox_api_key" value="' . esc_attr($api_key) . '">';
	}

	public function mapbox_field_version($args) {

		$options = get_option( 'mapbox_version' );
		?>
		<select id="<?php echo esc_attr($args['label_for']); ?>"  name="<?php echo esc_attr($args['label_for']); ?>">
			<option value=""> --- Select a Style --- </option>

			<option value="v2" <?php echo isset($options) ? (selected($options, "v2", false)) : (''); ?>>
				<?php esc_html_e( 'Mapbox Version 2', 'default' ); ?>
			</option>

			<option value="v3" <?php echo isset($options) ? (selected($options, "v3", false)) : (''); ?>>
				<?php esc_html_e( 'Mapbox Version 3 Beta', 'default' ); ?>
			</option>
		</select>
		<?php
	}

	public function mapbox_field_style($args) {

		$styles = [
			'Mapbox Streets v12' => 'mapbox://styles/mapbox/streets-v12',
			'Mapbox Streets v11' => 'mapbox://styles/mapbox/streets-v11',
			'Mapbox Outdoors v12' => 'mapbox://styles/mapbox/outdoors-v12',
			'Mapbox Outdoors v11' => 'mapbox://styles/mapbox/outdoors-v11',
			'Mapbox Light v11' => 'mapbox://styles/mapbox/light-v11',
			'Mapbox Light v10' => 'mapbox://styles/mapbox/light-v10',
			'Mapbox Dark v11' => 'mapbox://styles/mapbox/dark-v11',
			'Mapbox Dark v10' => 'mapbox://styles/mapbox/dark-v10',
			'Mapbox Satellite v9' => 'mapbox://styles/mapbox/satellite-v9',
			'Mapbox Satellite Streets v12' => 'mapbox://styles/mapbox/satellite-streets-v12',
			'Mapbox Satellite Streets v11' => 'mapbox://styles/mapbox/satellite-streets-v11',
			'Mapbox Navigation Day v1' => 'mapbox://styles/mapbox/navigation-day-v1',
			'Mapbox Navigation Preview Day v4' => 'mapbox://styles/mapbox/navigation-preview-day-v4',
			'Mapbox Navigation Night v1' => 'mapbox://styles/mapbox/navigation-night-v1',
			'Mapbox Navigation Preview Night v4' => 'mapbox://styles/mapbox/navigation-preview-night-v4',
		];

		if ('v3' == get_option('mapbox_version')) {
			$betaStyle = [ 'Mapbox Standard Beta' => 'mapbox://styles/mapbox/standard-beta' ];
			$styles = array_merge($betaStyle, $styles);
		}

		$options = get_option('mapbox_field_style');
		?>
		<select id="<?php echo esc_attr($args['label_for']); ?>"  name="<?php echo esc_attr($args['label_for']); ?>">
			<option value=""> --- Select a Style --- </option>
			<?php foreach ($styles as $key => $value) : ?>

			<option value="<?php echo $value; ?>" <?php echo isset($options) ? (selected($options, $value, false)) : (''); ?>>
				<?php echo $key; ?>
			</option>

			<?php endforeach; ?>
		</select>
	<?php
	}

	function save_mapbox_option_data() {
		if ( isset( $_POST['mapbox_api_key'] ) ) {
			// Perform the API key validation
			$is_valid = $this->validate_api_key($_POST['mapbox_api_key']);

			if ($is_valid) {
				update_option('mapbox_api_key', sanitize_text_field($_POST['mapbox_api_key']));
				update_option('api_key_valid', $is_valid);
			} else {
				update_option('mapbox_api_key', '');
				update_option('api_key_valid', $is_valid);
			}
		}

		if ( isset( $_POST['mapbox_version'] ) ) {
			update_option('mapbox_version', sanitize_text_field($_POST['mapbox_version']));
			if ('v2' == $_POST['mapbox_version'] && 'mapbox://styles/mapbox/standard-beta' == get_option('mapbox_field_style')) {
				update_option( 'mapbox_field_style', '' );
			}
		}

		if ( isset( $_POST['mapbox_field_style'] ) )
			update_option( 'mapbox_field_style', sanitize_text_field( $_POST['mapbox_field_style'] ) );

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

	function filter_custom_posts_by_meta_field($query)
	{
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
