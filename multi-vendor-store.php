<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://rahulpranami.co
 * @since             1.0.0
 * @package           Multi_Vendor_Store
 *
 * @wordpress-plugin
 * Plugin Name:       Multi Vendor Store
 * Plugin URI:        https://rahulpranami.co/plugins/multi-vendor-store
 * Description:       This Plugin helps multiple vendor stores to easily use woocommerce.
 * Version:           1.0.0
 * Author:            Rahul Pranami
 * Author URI:        https://rahulpranami.co/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       multi-vendor-store
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MULTI_VENDOR_STORE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-multi-vendor-store-activator.php
 */
function activate_multi_vendor_store() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multi-vendor-store-activator.php';
	Multi_Vendor_Store_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-multi-vendor-store-deactivator.php
 */
function deactivate_multi_vendor_store() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-multi-vendor-store-deactivator.php';
	Multi_Vendor_Store_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_multi_vendor_store' );
register_deactivation_hook( __FILE__, 'deactivate_multi_vendor_store' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-multi-vendor-store.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_multi_vendor_store() {

	$plugin = new Multi_Vendor_Store();
	$plugin->run();

}
run_multi_vendor_store();
