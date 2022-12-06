<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://gastcoin.com 
 * @since             1.9.18
 * @package           gastcoin
 *
 * @wordpress-plugin
 * Plugin Name:       Gastcoin Gateway
 * Plugin URI:        https://gastcoin.com/
 * Description:       Add the Gastcoin Gateway in Woocommerce, making use of Metamask, Coinbase Wallet or trust wallet for decentralized commerce.
 * Version:           1.9.18
 * Author:            FemoraPro
 * Author URI:        https://www.femora.pro/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gastcoin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


define('GASTCOIN_DIR_URL', plugin_dir_url(__FILE__));

/**
 * Currently plugin version.
 * Start at version 0.5.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'GASTCOIN_VERSION', '1.9.18' );




/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gastcoin-activator.php
 */
function activate_gastcoin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gastcoin-activator.php';
	gastcoin_Activator::activate();

	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gastcoin-deactivator.php
 */
function deactivate_gastcoin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gastcoin-deactivator.php';
	gastcoin_Deactivator::deactivate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gastcoin-deactivator.php
 */
add_filter( 'woocommerce_payment_gateways', 'gastcoin_add_gateway_class');
function gastcoin_add_gateway_class($gateways)
{
	$gateways[] = 'WC_Gastcoin_Gateway'; // your class name is here
	return $gateways;
}

add_action('plugins_loaded', 'gast_gateway_class');
function gast_gateway_class()
{
	if (class_exists('WooCommerce')) {
	require_once plugin_dir_path(__FILE__) . 'includes/class-gastcoin-woocommerce.php';
	}
	
}

register_activation_hook( __FILE__, 'activate_gastcoin' );
register_deactivation_hook( __FILE__, 'deactivate_gastcoin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gastcoin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.5.0
 */
function run_gastcoin() {

	$plugin = new gastcoin();
	$plugin->run();

}
run_gastcoin();
