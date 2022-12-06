<?php
if (!defined('ABSPATH')) exit;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://gastcoin.com
 * @since      0.5.0
 *
 * @package    gastcoin
 * @subpackage gastcoin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.5.0
 * @package    gastcoin
 * @subpackage gastcoin/includes
 * @author     Your Name <email@example.com>
 */
class gastcoin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.5.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'gastcoin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
