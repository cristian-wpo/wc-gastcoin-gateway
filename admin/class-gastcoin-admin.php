<?php
if (!defined('ABSPATH')) exit;
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://gastcoin.com
 * @since      0.6.0
 *
 * @package    Gastcoin
 * @subpackage Gastcoin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gastcoin
 * @subpackage Gastcoin/admin
 * @author     Your Name <email@example.com>
 */
class Gastcoin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.6.0
	 * @access   private
	 * @var      string    $gastcoin    The ID of this plugin.
	 */
	private $gastcoin;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.6.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.6.0
	 * @param      string    $gastcoin       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $gastcoin, $version ) {

		$this->gastcoin = $gastcoin;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.6.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gastcoin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gastcoin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->gastcoin, plugin_dir_url( __FILE__ ) . 'css/gastcoin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.6.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gastcoin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gastcoin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->gastcoin, plugin_dir_url( __FILE__ ) . 'js/gastcoin-admin.js', array( 'jquery' ), $this->version, false );


		//script to update setting
		wp_localize_script($this->gastcoin, 'gastcoin_utiliti', array(
			'gastcoin_setting' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('gastcoin_changue_setting'),
			'action' => 'gastcoin_setting'
		));

	}

	public function crear_menu_gastcoin()
	{
		require_once plugin_dir_path(__FILE__) . 'partials/gastcoin-admin-display.php';

		add_menu_page('Gastcoin', 'Gastcoin Gateway', 'manage_options', 'gastcoin_gateway', 'gastcoin_backend_dashboard', 'dashicons-gastcoin');
	}

	/**
	 * Add custom favicon.
	 *
	 * @since   0.7.0
	 */
	public function gastcoin_favicon()
	{
		echo '<style>
		.dashicons-gastcoin {
			background-image: url("' . GASTCOIN_DIR_URL . '/assets/img/gastcoin-icon-32x32.png");
			background-repeat: no-repeat;
			background-position: center; 
			background-size: 16px;
		}
		</style>';
	}


	function gastcoin_setting()
	{
		check_ajax_referer('gastcoin_changue_setting', 'nonce');
		require_once plugin_dir_path(__FILE__) . 'partials/function-gastcoin-gateway-setting.php';
	}

	function gastcoin_get_image() {
		if(isset($_GET['id']) ){
			$image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'gastcoin-preview-image' ) );
			$data = array(
				'image'    => $image,
			);
			wp_send_json_success( $data );
		} else {
			wp_send_json_error();
		}
	}
	function gastcoin_get_image_matic() {
		if(isset($_GET['id']) ){
			$image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'medium', false, array( 'id' => 'gastcoin-preview-image_matic' ) );
			$data = array(
				'image'    => $image,
			);
			wp_send_json_success( $data );
		} else {
			wp_send_json_error();
		}
	}

	function load_media_files_gast() {
		wp_enqueue_media();
	}

	function get_network_gast(){
		global $wp; 
    	$wp->add_query_var('network_payment'); 
	}
}
