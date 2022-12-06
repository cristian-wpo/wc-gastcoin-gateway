<?php
if (!defined('ABSPATH')) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://gastcoin.com
 * @since      1.8.0
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
	 * @since    1.8.0
	 * @access   private
	 * @var      string    $gastcoin    The ID of this plugin.
	 */
	private $gastcoin;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.8.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.8.0
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
	 * @since    1.8.0
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
		wp_enqueue_style($this->gastcoin.'-bulma', plugin_dir_url(__FILE__) . 'css/bulma.min.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.8.0
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
		wp_enqueue_script($this->gastcoin.'-qr', plugin_dir_url(__FILE__) . 'js/qr-code-styling.js', array('jquery'), $this->version, false);


		//script to update setting
		wp_localize_script($this->gastcoin, 'gastcoin', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('gastcoin_get_setting'),
			'action' => 'gast_complete'
		));
	}

	public function gastcoin_completes_order_thankyou($order_id)
	{
		$order = wc_get_order($order_id);

		if (!$order->get_payment_method() == 'gastcoin')
			return;

		$total_to_pay = $order->get_total();
		if (get_option('_gastcoin_value_conversion')) {
			$divisor = get_option('_gastcoin_value_conversion');
			$total_to_pay = number_format(($total_to_pay / $divisor), 2);
		}

		if (!get_option('woocommerce_gastcoin_settings')) {
			return;
		}

		if (!get_option('_cbox_gast')) {
			add_option('_cbox_gast', 'true', '', 'no');
			$cbox_gast = 'true';
		} else {
			$cbox_gast = get_option('_cbox_gast');
		}

		if (!get_option('_custom_token')) {
			add_option('_custom_token', 'true', '', 'no');
			$custom_token = 'true';
		} else {
			$custom_token = get_option('_custom_token');
		}

		if (!get_option('_cbox_busd')) {
			add_option('_cbox_busd', 'true', '', 'no');
			$cbox_busd = 'true';
		} else {
			$cbox_busd = get_option('_cbox_busd');
		}

		if (!get_option('_cbox_usdt')) {
			add_option('_cbox_usdt', 'true', '', 'no');
			$cbox_usdt = 'true';
		} else {
			$cbox_usdt = get_option('_cbox_usdt');
		}

		if (!get_option('_select_red_bsc')) {
			add_option('_select_red_bsc', 'true', '', 'no');
			$gast_network_payment_bsc = 'true';
		} else {
			$gast_network_payment_bsc = get_option('_select_red_bsc');
		}

		if (!get_option('_select_red_matic')) {
			add_option('_select_red_matic', 'true', '', 'no');
			$gast_network_payment_matic = 'true';
		} else {
			$gast_network_payment_matic = get_option('_select_red_matic');
		}

		//Production / testing
		if (!get_option('_cbox_testing')) {
			add_option('_cbox_testing', 'false', '', 'no');
			$cbox_testing = 'false';
		} else {
			$cbox_testing = get_option('_cbox_testing');
		}
		if (!get_option('_cbox_production')) {
			add_option('_cbox_production', 'true', '', 'no');
			$cbox_production = 'true';
		} else {
			$cbox_production = get_option('_cbox_production');
		}
		
?>
<script>
	var gastcoin_total_pay = '<?php echo $total_to_pay;?>';
	var gastcoin_order_id = '<?php echo $order_id;?>';
	var production_network = '<?php echo $cbox_production;?>';
</script>

<div id="casg-tester"></div>
    <div id="gastcoin-gateway" class="columns is-centered">
        <div class="column">
            <div class="box">
                <div class="block has-text-centered mb-2">
                    <h2 class="subtitle mb-1 is-family-secondary is-size-6"><?php esc_html_e('Wallet selected', 'gastcoin'); ?></h2>
                    <div class="">
                        <figure>
                            <img id="img-wallet" src="">
                        </figure>
                    </div>
                </div>
                <div class="block mb-2">
                    <div class="block has-text-centered mb-2">
						<?php if($cbox_production != 'false'){ ?>
                        <h2 class="subtitle mb-1 is-family-secondary is-size-6"><?php esc_html_e('Select network', 'gastcoin'); ?></h2>
						<?php }else{?>
						<h2 class="subtitle mb-1 is-family-secondary is-size-6"><?php esc_html_e('Select test network', 'gastcoin'); ?></h2>
						<?php }?>
					</div>
                    <div class="gastcoin-btns is-centered">
							<button type='button' id="gast-bsc" class="gastcoin-button is-normal is-border-radius-17" >
								<img class="img-network" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/binancesmartchain.png');?>">
							</button>
							<button type='button' id="gast-matic" class="gastcoin-button is-normal is-border-radius-17">
								<img class="img-network" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/polygon.png');?>">
							</button>
                    </div>
                </div>
                <div class="block is-border-top if-border-bottom mb-2">
                    <div class="block has-text-centered  mb-2">
                        <h2 class="subtitle mb-1 is-family-secondary is-size-6"><?php esc_html_e('Select cryptocurrency', 'gastcoin'); ?></h2>
                    </div>
                    <div class="gastcoin-btns is-centered has-text-centered btn-crypto-gastcoin">
                        <div>
                            <button id="gast-btn-usdt" class="gastcoin-button is-rounded is-loading is-small" disabled>
                                <img src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/crypto-usdt.png');?>">
                            </button>
                            <div>USDT</div>
                        </div>
                        <div>
                            <button id="gast-btn-busd" class="gastcoin-button is-rounded is-loading is-small" disabled>
                                <img src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/crypto-busd.png');?>">
                            </button>
                            <div>BUSD</div>
                        </div>
                        <div>
                            <button id="gast-btn-usdc" class="gastcoin-button is-rounded is-loading is-small" disabled>
                                <img src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/crypto-usdc.png');?>">
                            </button>
                            <div>USDC</div>
                        </div>
                        <!-- <div>
                            <button id="gast-btn-gast" class="gastcoin-button is-rounded is-loading is-small" disabled>
                                <img src="<?php /*echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/crypto-gast.png');*/ ?>">
                            </button>
                            <div>GAST</div>
                        </div> -->
                    </div>
                </div>
				<div class ="gastcoin-card">
					
					<div class="card">
						<div class="card__front card__part">
							<img class="card__front-square card__square" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/crypto-gast.png');?>">
							<img id="gast-img-wallet" class="card__front-logo-3 card__logo" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-alert.png');?>">
							<img id="gast-img-network" class=" gast-img-network card__front-logo-2 card__logo" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-alert.png');?>">
							<img id="gast-img-crypto" class="card__front-logo-1 card__logo" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-alert.png');?>">
							<p id="gastcoin-client-wallet" class="card_numer">0xE3fcc...906A23</p>
							<div class="card__space-25">
							<span class="card__label">Gastcoin Gateway</span>
							<p id="gast-text-alert" class="card__info"></p>
						</div>
					</div>
					
					<div class="card__back card__part">
						<div class="loader"></div> 
						<div class="card__black-line" style="display: none;"></div>
						<div class="card__back-content" >
							<div class="card__secret" style="display: none;">
								<p class="card__secret--last">GAST</p>
							</div>
							<img class="card__back-square card__square" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/crypto-gast.png'); ?>">
							<img class="card__back-logo card__logo gast-img-network" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-alert.png');?>">
						</div>
					</div>
				
				</div>
                </div>
                <div class="block"></div>
                <div class="pr-5 pl-5 block-center" style="width: 50%;">
					<div class="block mb-2">
                        <button id="gastcoin-gateway-pay" class="gastcoin-button is-fullwidth is-border-radius-27 is-small" disabled><?php esc_html_e('Pay now', 'gastcoin'); ?></button>
                    </div>
                    <div class="block">
                        <button class="gastcoin-button is-fullwidth is-border-radius-27 is-small" onClick="gast_getlink()" ><?php esc_html_e('Copy payment URL', 'gastcoin'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>




<div id="gastcoin-gateway-select-wallet" class="columns is-centered">
        <div class="column">
            <div class="box">
                <div class="block has-text-centered mb-2">
                    <h2 class="subtitle mb-1 is-family-secondary is-size-6"><?php esc_html_e('Select wallet', 'gastcoin'); ?></h2>
					<div class="box">
						<div class="gast-box-qr" id="gast-qr-1">
							<script>
								var logo_gastqr = "<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/192x192.png');?>";
							</script>
						</div>
					</div>
                </div>
                <div class="column"></div>
                <div class="pr-5 pl-5 block-center" >
					<div class="block">
                        <button class="gastcoin-button is-border-radius-27 is-fullwidth" onClick="go_to_wallet('coinbasewallet')">
							<span class="icon is-small">
								<img src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-coinbasewallet.png');?>"></img>
							</span>
							Coinbase Wallet
						</button>
                    </div>
                    <div class="block">
                        <button class="gastcoin-button is-border-radius-27 is-fullwidth" onClick="go_to_wallet('metamask')">
							<span class="icon is-small">
								<img src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-metamask.png');?>"></img>
							</span>
							Metamask
						</button>
                    </div>
					<div class="block">
                        <button class="gastcoin-button is-border-radius-27 is-fullwidth" onClick="go_to_wallet('trustwallet')">
							<span class="icon is-small">
								<img src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/ico-trustwallet.png');?>"></img>
							</span>
							Trust Wallet
						</button>
                    </div>
					<div class="block">
                        <button class="gastcoin-button is-fullwidth is-border-radius-27" onClick="gast_getlink()" ><?php echo __('Copy payment URL', 'gastcoin') ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

		<?php
	}

	
	public function gastcoin_gast_complete()
	{
		check_ajax_referer('gastcoin_get_setting', 'nonce');
		if(isset($_POST['network_payment'])){
			if($_POST['network_payment'] == 'bsc'){
				$gast_network_payment = 'bsc';
			}
			if($_POST['network_payment'] == 'matic'){
				$gast_network_payment = 'matic';
			}
		}
		$action = sanitize_text_field($_POST['case']);
		switch ( $action ) {
			case 'test':
				echo 'este es un test';
				die();
				break;
			case 'get_url_gastcoin_path':
				echo str_replace('public/','',plugin_dir_url(__DIR__));
				die();
				break;
			case 'Allowance':
				if($gast_network_payment == 'bsc'){
					echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/allowance/bsc?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']))->data->balance);
				}else if($gast_network_payment == 'matic'){
					$url = 'https://api.gastcoin.com/api/v2/transaction/allowance/matic';
					$data = array('address' => sanitize_text_field($_POST['account_id_metamask']),'contract' => sanitize_text_field($_POST['token_contract']));
					$query_url = $url.'?'.http_build_query($data);
					echo esc_html_e($this->gastcoin_get($query_url, '')->data->balance);			
				}
				die();
				break;
			case 'approve':
				if($gast_network_payment == 'bsc'){
					echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/approve/bsc?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']) )->data->data);
				}else{
					echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/approve/matic?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']))->data->data);
				}
				die();
				break;
			case 'gastcoin_gateway_pay':
				$gastcoin_option = get_option('woocommerce_gastcoin_settings');
				$array = [
					"from" => sanitize_text_field($_POST['account_id_metamask']),
					"to" => sanitize_text_field($gastcoin_option['address_key']),
					"amount" => (float) sanitize_text_field($_POST['monto_to_pay']),
					"contract" => sanitize_text_field($_POST['token_contract']),
				];
				if($gast_network_payment == 'bsc'){
					echo esc_html_e($this->gastcoin_post('https://api.gastcoin.com/api/v2/transaction/bsc', $array)->data);
				}else if($gast_network_payment == 'matic'){
					echo esc_html_e($this->gastcoin_post('https://api.gastcoin.com/api/v2/transaction/matic', $array)->data);
				}
				die();
				break;
			case 'txHash_status':
				if($gast_network_payment == 'bsc'){
					$status = $this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/tx/bsc/'. sanitize_text_field($_POST['txHash']))->result->status;
				}else if($gast_network_payment == 'matic'){
					$status = $this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/tx/matic/'. sanitize_text_field($_POST['txHash']))->result->status;
				}
				if($status == ''){
					echo 'processing';
				}else if($status == '1'){
					$order = wc_get_order(sanitize_text_field($_POST['order_id']));
					$order->update_status('processing');
					$order->save();
					echo $status;
				}else{
					echo $status;
				}
				die();
				break;
			case 'add_note':
				$order = wc_get_order(sanitize_text_field($_POST['order_id']));
				// The text for the note
				if($gast_network_payment == 'bsc'){
					$note = __('Bscscan transaction id:' .': <a href="https://bscscan.com/tx/' . sanitize_text_field($_POST['note']) . '" target="_blank">' . sanitize_text_field($_POST['note']) . '</a>');
				}else if($gast_network_payment == 'matic'){
					$note = __('Polygon transaction id:' .': <a href="https://polygonscan.com/tx/' . sanitize_text_field($_POST['note']) . '" target="_blank">' . sanitize_text_field($_POST['note']) . '</a>');
				}
				// Add the note
				$order->add_order_note($note);
				$order->save();
				die();
				break;
			case 'get_text':
				echo $this->get_text_js_gastcoin();
				die();
				break;
		}
	}

	function get_text_js_gastcoin(){
		$array = array(
			"select_network" => __('You have not yet selected a network', 'gastcoin'),
			"processing_data" => __('Processing data...', 'gastcoin'),
			"processing" => __('Processing', 'gastcoin'),
			"processing_1" => __('Processing.', 'gastcoin'),
			"processing_2" => __('Processing..', 'gastcoin'),
			"processing_3" => __('Processing...', 'gastcoin'),
			"pay_now" => __('Pay now', 'gastcoin'),
			"patment_error" => __('Payment error', 'gastcoin'),
			"completed" => __('Completed', 'gastcoin'),
			"succesful" => __('Succesful transaction', 'gastcoin'),
			"not_network" => __('You have not yet selected a network', 'gastcoin'),
			"select_crypto" => __('Select a cryptocurrency', 'gastcoin'),
			"make_payment" => __('You can now make the payment', 'gastcoin'),
		);

		return json_encode($array);
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
			echo  esc_html_e("Something went wrong: $response");
		} else {
			//print_r(json_decode($response['body']));
			error_log('error_casg:'.json_encode($response));
			return json_decode($response['body'])->data;
		}
	}

	function gastcoin_get($server)
	{
		$endpoint = $server;

		$options = [
			'headers'     => [
				'Content-Type' => 'application/json',
			],
		];

		$response = wp_remote_get($endpoint, $options);

		if (is_wp_error($response)) {
			echo  esc_html_e("Something went wrong: $response");
		} else {
			//print_r(json_decode($response['body']));
			return json_decode($response['body']);
		}

	}

	function shortcode_page_payment()
	{
		if (isset($_GET['order_id'])) {
			$order_id = sanitize_text_field($_GET['order_id']);
			$order = wc_get_order($order_id);

			$total_to_pay = $order->get_total();
		?>
			<div>
				<!-- <h1><?php /*echo __('Total to pay: ', 'gastcoin');
					echo esc_html_e(get_woocommerce_currency_symbol() . $total_to_pay); */?></h1> -->
					<div id="transaction_complete"></div>
			</div>
		<?php

			$this->gastcoin_completes_order_thankyou($order_id);
		}
	}
	

	function custom_token_call($network){
		if($network=='bsc'){
			$network='';
		}else{
			$network = '_' . $network;
		}
		if (!get_option('_gast_value_name'.$network)) {
			add_option('_gast_value_name'.$network, '', '', 'no');
			$gast_value_name = '';
		} else {
			$gast_value_name = get_option('_gast_value_name'.$network);
		}

		if (!get_option('_gast_value_symbol')) {
			add_option('_gast_value_symbol', '', '', 'no');
			$gast_value_symbol = '';
		} else {
			$gast_value_symbol = get_option('_gast_value_symbol'.$network);
		}

		if (!get_option('_gast_value_address')) {
			add_option('_gast_value_address', '', '', 'no');
			$gast_value_address = '';
		} else {
			$gast_value_address = trim(get_option('_gast_value_address'.$network));
		}

		if (!get_option('_gast_value_decimals'.$network)) {
			add_option('_gast_value_decimals'.$network, '', '', 'no');
			$gast_value_decimals = '';
		} else {
			$gast_value_decimals = get_option('_gast_value_decimals'.$network);
		}

		$image_id = get_option( '_gastcoin_custom_image_id'.$network );

		$crypto_custom = [
			'gast_value_name'        => $gast_value_name,
			'gast_value_symbol'     => $gast_value_symbol,
			'gast_value_address' => $gast_value_address,
			'gast_value_decimals'    => $gast_value_decimals,
			'image_id' => $image_id,
		];

		return json_encode($crypto_custom);
	}
	function add_get_val() { 
		global $wp; 
		$wp->add_query_var('network_payment'); 
	}
}


