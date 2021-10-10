<?php
if (!defined('ABSPATH')) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://gastcoin.com
 * @since      0.5.0
 *
 * @package    gastcoin
 * @subpackage gastcoin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    gastcoin
 * @subpackage gastcoin/public
 * @author     Your Name <email@example.com>
 */
class gastcoin_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $gastcoin    The ID of this plugin.
	 */
	private $gastcoin;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.5.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.5.0
	 * @param      string    $gastcoin       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($gastcoin, $version)
	{

		$this->gastcoin = $gastcoin;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.5.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in gastcoin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The gastcoin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->gastcoin, plugin_dir_url(__FILE__) . 'css/gastcoin-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    0.5.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in gastcoin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The gastcoin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->gastcoin, plugin_dir_url(__FILE__) . 'js/gastcoin-public.js', array('jquery'), $this->version, false);
		//wp_enqueue_script($this->gastcoin . 'web3', plugin_dir_url(__DIR__) . 'assets/dist/js/plugin.js', array('jquery'), $this->version, false);

		//script to update setting 
		wp_localize_script($this->gastcoin, 'gastcoin_conf', array(
			'gastcoin_completes_order_thankyou' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('gastcoin_get_setting'),
			'action' => 'gast_complete'
		));
	}

	public function gastcoin_after_pay()
	{
	}


	public function gastcoin_completes_order_thankyou($order_id)
	{

		$order = wc_get_order($order_id);

		if (!$order->get_payment_method() == 'gastcoin')
			return;

		if ($order->get_status() != 'pending')
			return;
		//print_r($order);
		$total_to_pay = $order->get_total();
		//echo $total_to_pay . '</br>';
		//echo dechex(($total_to_pay));
		if (get_option('woocommerce_gastcoin_settings')) {
			$gastcoin_option = get_option('woocommerce_gastcoin_settings');
			//print_r($gastcoin_option); // Uncomment for testing
			//print_r($gastcoin_option['address_key']);
		} else {
			return;
		}

?>
		<div><button class="gastcoin-pay-button alt complete-status"></button><br><br>
			<span class="response" style="color:green;"></span>
			<span class="response-error" style="color:red;"></span>
		</div>
		<script type="text/javascript">
			jQuery(function($) {
				if (typeof woocommerce_params === 'undefined')
					return false;



				let accounts = [];
				//let contractInstance;
				async function getAccount() {
					accounts = await ethereum.request({
						method: 'eth_requestAccounts'
					});
					console.log(accounts);
				}
				getAccount();

				$('button.complete-status').click(function(e) {
					e.preventDefault();

					var parametros = {
						nonce: gastcoin_conf.nonce,
						action: gastcoin_conf.action,
						'account_id_metamask': accounts[0], // Here we send the order Id
						'monto_to_pay': <?php echo $total_to_pay ?>, // Here we send the order Id
					};

					var gastcoin_pay = jQuery.ajax({
						data: parametros,
						url: woocommerce_params.ajax_url,
						type: "POST",
						beforeSend: function() {
							$('.response').text("Processing data...");
						},
						success: function(response) {
							console.log(response + ' 22');
							ethereum.request({
									method: 'eth_sendTransaction',
									params: [{
										from: accounts[0],
										to: '0x8477ED2eE590FDAF9D63E8Ed1d3d6770167fcDB5',
										gas: '0x493E0',
										data: response,
									}, ],
								})
								.then((txHash) => gastcoin_pay_exito(txHash))
								.catch((error) => gastcoin_pay_error(error));
						}
					});


				});

				function gastcoin_pay_exito(txHash) {

					var parametros = {
						nonce: gastcoin_conf.nonce,
						action: gastcoin_conf.action,
						'order_id': <?php echo $order_id; ?>, // Here we send the order Id
						'transaction_id': txHash, // Here we send the order Id
					};

					var gastcoin_pay = jQuery.ajax({
						data: parametros,
						url: woocommerce_params.ajax_url,
						type: "POST",
						beforeSend: function() {
							$('.response').text("Processing payment...");
						},
						success: function(response) {
							console.log(response);
							$('.response').text("Payment processed successfully");
							$(".gastcoin-pay-button").css("display", "none");
						}
					});
					console.log(gastcoin_pay);
					console.log(txHash);
					//reload();
				}

				function gastcoin_pay_error(error) {
					$('.response-error').text(JSON.stringify(error));
					console.log("Error en el pago");
				}

			});
		</script>
<?php
	}


	public function gastcoin_gast_complete()
	{
		check_ajax_referer('gastcoin_get_setting', 'nonce');
		if (isset($_POST['order_id']) && $_POST['order_id'] > 0 && isset($_POST['transaction_id']) && $_POST['transaction_id'] != '') {
			$order = wc_get_order($_POST['order_id']);
			$order->update_status('processing');
			// The text for the note
			$note = __('Bscscan transaction id: <a href="https://bscscan.com/tx/' . $_POST['transaction_id'] . '" target="_blank">' . $_POST['transaction_id'] . '</a>');

			// Add the note
			$order->add_order_note($note);
		}

		if (isset($_POST['account_id_metamask']) and isset($_POST['monto_to_pay'])) {

			$gastcoin_option = get_option('woocommerce_gastcoin_settings');
			$array = [
				"from" => $_POST['account_id_metamask'],
				"to" => $gastcoin_option['address_key'],
				"amount" => $_POST['monto_to_pay'],
			];

			echo $this->gastcoin_post('https://api.gastcoin.com/api/v1/gastcoin', $array)->data;
		}

		//echo $_POST['account_id_metamask'];
		//echo $gastcoin_option['address_key'];
		die();
	}



	function gastcoin_post($server, $variables)
	{

		//$data = array('from' => '0x822a2A4A0c9129Cf9532a308CB2b6821916cb308', 'to' => '0x4D022B37253c738E6553aBcc952B9cb88fffd743', 'amount' => '10');
		//$response = Requests::post($server, $header, json_encode($data));

		$endpoint = $server;

		$body = wp_json_encode($variables);

		$options = [
			'body'        => $body,
			'headers'     => [
				'Content-Type' => 'application/json',
			],
			'timeout'     => 60,
			'redirection' => 5,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
		];

		$response = wp_remote_post($endpoint, $options);

		if (is_wp_error($response)) {
			echo "Something went wrong: $response";
		} else {
			return json_decode($response['body'])->data;
		}
	}
}
