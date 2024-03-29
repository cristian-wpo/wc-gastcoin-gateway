<?php
if (!defined('ABSPATH')) exit;
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://gastcoin.com
 * @since      0.5.0
 *
 * @package    gastcoin
 * @subpackage gastcoin/includes
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
 * @since      0.5.0
 * @package    gastcoin
 * @subpackage gastcoin/includes
 * @author     Your Name <email@example.com>
 */
class gastcoin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.5.0
	 * @access   protected
	 * @var      gastcoin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.5.0
	 * @access   protected
	 * @var      string    $gastcoin    The string used to uniquely identify this plugin.
	 */
	protected $gastcoin;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.5.0
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
	 * @since    0.7
	 */
	public function __construct() {
		if ( defined( 'GASTCOIN_VERSION' ) ) {
			$this->version = GASTCOIN_VERSION;
		} else {
			$this->version = '0.7.5';
		}
		$this->gastcoin = 'gastcoin';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_public_hooks();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - gastcoin_Loader. Orchestrates the hooks of the plugin.
	 * - gastcoin_i18n. Defines internationalization functionality.
	 * - gastcoin_Admin. Defines all hooks for the admin area.
	 * - gastcoin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gastcoin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gastcoin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-gastcoin-public.php';

		/**
		 * The class responsible for defining all actions that occur in the admin-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-gastcoin-admin.php';

		/**
		 * The class responsible for defining all actions for woocommerce
		 * side of the site.
		 */

		$this->loader = new gastcoin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the gastcoin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new gastcoin_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since   0.8.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{
		$gastcoin_admin = new Gastcoin_Admin($this->get_gastcoin(), $this->get_version());

		$this->loader->add_action("admin_head", $gastcoin_admin, "gastcoin_favicon");
		$this->loader->add_action('admin_enqueue_scripts', $gastcoin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $gastcoin_admin, 'enqueue_scripts');
		$this->loader->add_action("admin_menu", $gastcoin_admin, "crear_menu_gastcoin");
		$this->loader->add_action("wp_ajax_gastcoin_setting", $gastcoin_admin, "gastcoin_setting");
		$this->loader->add_action("wp_ajax_gastcoin_get_image", $gastcoin_admin, "gastcoin_get_image");
		$this->loader->add_action("wp_ajax_gastcoin_get_image_matic", $gastcoin_admin, "gastcoin_get_image_matic");
		$this->loader->add_action("admin_enqueue_scripts", $gastcoin_admin, "load_media_files_gast");
		$this->loader->add_action("init", $gastcoin_admin, "get_network_gast");
		
	
	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new gastcoin_Public( $this->get_gastcoin(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_before_thankyou', $plugin_public, 'gastcoin_completes_order_thankyou' );
		$this->loader->add_action( 'wp_ajax_gast_complete', $plugin_public, 'gastcoin_gast_complete');
		$this->loader->add_action( 'wp_ajax_nopriv_gast_complete', $plugin_public, 'gastcoin_gast_complete');
		
		$this->loader->add_shortcode('gastcoin_gataway',  $plugin_public, 'shortcode_page_payment');
		$this->loader->add_shortcode('gastcoin_gateway',  $plugin_public, 'shortcode_page_payment');


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.5.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.5.0
	 * @return    string    The name of the plugin.
	 */
	public function get_gastcoin() {
		return $this->gastcoin;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.5.0
	 * @return    gastcoin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.5.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
