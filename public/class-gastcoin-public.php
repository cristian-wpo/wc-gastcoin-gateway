<?php
if (!defined('ABSPATH')) exit;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://gastcoin.com
 * @since      1.2.1
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
	 * @since    1.2.1
	 * @access   private
	 * @var      string    $gastcoin    The ID of this plugin.
	 */
	private $gastcoin;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.2.1
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.2.1
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
	 * @since    1.2.1
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
		wp_enqueue_script($this->gastcoin.'-qr', plugin_dir_url(__FILE__) . 'js/qr-code-styling.js', array('jquery'), $this->version, false);
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

		if (!get_option('_network_payment')) {
			add_option('_network_payment', 'bsc', '', 'no');
			$gast_network_payment = 'bsc';
		} else {
			$gast_network_payment = get_option('_network_payment');
		}
?>
		<div class="box-gastcoin">
			<div class="container-gast-card">
				<div class="card">
					<h2>Gastcoin Gateway</h2>
					<div class="imgBx gast-wallet">
						<div class="gast-box-qr" id="gast-qr-1">
							<script>
								var logo_gastqr = "<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/192x192.png');?>";
							</script>
						</div>
					</div>
					<div class="contentBx">
						<div class="gast-spinner"></div>
						<div class="gast-text-confirmation"></div>
						<div class="size btn-gast-pay">
							<div class="gast-red">
								<a href="#" id="gast-bsc">
									<div class="icon" style="height: 33px;">
										<img style="width: 95%;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/binancesmartchain.png');?>">
									</div>

								</a>
							</div>
							<div class="gast-red">
								<a href="#" id="gast-matic">
								<div class="icon" style="height: 33px;">
										<img style="width: 95%;margin-top: 4px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/polygon.png');?>">
									</div>
								</a>
							</div>
						</div>
						<div class="color">
							<a class="a-gastcoin gast-wallet" href="#" id="gast-btn-coinbasewallet">
								<div class="icon">
											<img style="width: 40px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/coinbasewallet.png');?>">
										</div>
										<?php echo __('Pay in Coinbase Wallet', 'gastcoin') ?>
							</a>
							<a class="a-gastcoin gast-wallet" href="#" id="gast-btn-metamask">
								<div class="icon">
											<img style="width: 40px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/metamask.png');?>">
										</div>
										<?php echo __('Pay in Metamask', 'gastcoin') ?>
							</a>
							<a class="a-gastcoin gast-wallet" href="#" id="gast-btn-trust">
								<div class="icon">
											<img style="width: 40px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/trust.png');?>">
										</div>
										<?php echo __('Pay in Trust Wallet', 'gastcoin') ?>
							</a>
							<?php if ($cbox_busd != 'false' && $cbox_busd != ''){?>
								<a class="a-gastcoin btn-gast-pay complete-status-busd" id="gast-btn-busd">
									<span></span>
									<span></span>
									<span></span>
									<span></span>
									<div class="icon">
												<img style="width: 80px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/busd.png');?>">
											</div>
											<?php echo esc_html_e(get_woocommerce_currency_symbol() . $total_to_pay);?>
								</a>
							<?php } ?>
							<?php if ($cbox_usdt != 'false' && $cbox_usdt != ''){?>
								<a class="a-gastcoin btn-gast-pay complete-status-tether" id="gast-btn-usdt">
									<span></span>
									<span></span>
									<span></span>
									<span></span>	
									<div class="icon">
												<img style="width: 80px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/usdt.png');?>">
											</div>
											<?php echo esc_html_e(get_woocommerce_currency_symbol() . $total_to_pay);?>
								</a>
							<?php } ?>
							<a class="a-gastcoin" href="javascript:gast_getlink();">
								<div class="icon">
											<img style="width: 30px;margin-left: 5px;" src="<?php echo esc_html_e(plugin_dir_url(__DIR__) . 'assets/img/gast-copy.png');?>">
										</div>
										<?php echo __('Copy payment URL', 'gastcoin') ?>
							</a>
						</div>
						
					</div>
				</div>
				<div class="powerbygastcoin">
					<p>Powered by © Gastcoin</p>
				</div>
			</div>
		</div>	
		<div class="gastcoin-box-pay">
				<div class="btn-crypto">
					<?php 
						if (!get_option('_custom_token')) {
							add_option('_custom_token', 'false', '', 'no');
							$custom_token = 'false';
						} else {
							$custom_token = get_option('_custom_token');
						}
						if($custom_token == 'false' && $custom_token != ''){
					?> 
					<?php if ($cbox_gast != 'false' && $cbox_gast != ''){?>
						<div class="gast_btn"><button class="gastcoin-pay-button alt complete-status"></button>
							<div style="text-align: center;">
								<?php echo esc_html_e('$GAST: '); ?>
							</div>
						</div>
					<?php } ?>
					<?php }else{
						if (!get_option('_gast_value_name')) {
							add_option('_gast_value_name', '', '', 'no');
							$gast_value_name = '';
						} else {
							$gast_value_name = get_option('_gast_value_name');
						}

						if (!get_option('_gast_value_symbol')) {
							add_option('_gast_value_symbol', '', '', 'no');
							$gast_value_symbol = '';
						} else {
							$gast_value_symbol = get_option('_gast_value_symbol');
						}

						if (!get_option('_gast_value_address')) {
							add_option('_gast_value_address', '', '', 'no');
							$gast_value_address = '';
						} else {
							$gast_value_address = trim(get_option('_gast_value_address'));
						}

						if (!get_option('_gast_value_decimals')) {
							add_option('_gast_value_decimals', '', '', 'no');
							$gast_value_decimals = '';
						} else {
							$gast_value_decimals = get_option('_gast_value_decimals');
						}

						$image_id = get_option( '_gastcoin_custom_image_id' );
						
						if( intval( $image_id ) > 0 ) {
							// Change with the image size you want to use
							$image = wp_get_attachment_image_src($image_id)[0];
						} else {
							// Some default image
							$image = '';
						}
						?>
						<div class="gast_btn">
							<button class="gastcoin-pay-button-custom alt complete-status-custom"></button><br>
							<div style="text-align: center;">
								<?php echo "$$gast_value_symbol: " . $total_to_pay; ?>
							</div>
						</div>
					<?php } ?>
				</div>	
		
			</div>
		<div>
			<span class="response" style="color:green;"></span>
			<span class="response-error" style="color:red;"></span>
		</div>
		
		<style>
			.container-gast-card{
				display: none;
			}

			.gastcoin-pay-button-custom { 
				background-image: url(<?php echo $image; ?>);
				background-color: #00000000;
				width: 172px;
				height: 45px;
				background-size: contain;
				background-repeat: no-repeat;
				background-position: center;
			}
		</style>
		<script type="text/javascript">
			function load() {
			jQuery(function($) {
				//view network to pay select
				var gast_url = window.location.href.replace("&network_payment=bsc", "");
				gast_url = gast_url.replace("#", "");
				gast_url = gast_url.replace("&network_payment=matic", "");
				jQuery('#gast-bsc').attr('href', gast_url + '&network_payment=bsc');
				jQuery('#gast-matic').attr('href', gast_url + '&network_payment=matic');
				jQuery('.container-gast-card').css('display', 'block');

				var queryString = window.location.search;
				var urlParams = new URLSearchParams(queryString);
				var anuncioParam = urlParams.get('network_payment');
				console.log(anuncioParam);
				if(anuncioParam == null){
					var network_pay = '<?php echo $gast_network_payment; ?>';
				}else{
					var network_pay = anuncioParam;
				}
				
				if(network_pay == 'bsc'){
					var chainID = '0x38';
					var chainName = 'BSC Mainnet';
					var rpcUrls = ["https://bsc-dataseed.binance.org/","https://bsc-dataseed1.binance.org","https://bsc-dataseed2.binance.org","https://bsc-dataseed3.binance.org","https://bsc-dataseed4.binance.org","https://bsc-dataseed1.defibit.io","https://bsc-dataseed2.defibit.io","https://bsc-dataseed3.defibit.io","https://bsc-dataseed4.defibit.io","https://bsc-dataseed1.ninicoin.io","https://bsc-dataseed2.ninicoin.io","https://bsc-dataseed3.ninicoin.io","https://bsc-dataseed4.ninicoin.io","wss://bsc-ws-node.nariox.org"];
					var blockExplorerUrls = ['https://bscscan.com/'];
					var nativeCurrency = {name: 'Binance Coin',	symbol: 'BNB', decimals: 18}

					var Gastcoin_CONTRACT = '0xDaDF71d0a6A3F96d580B7d10Db28f46bB868Bc20';
					var Gastcoin_BUSD = '0xe9e7cea3dedca5984780bafc599bd69add087d56';
					var Gastcoin_USDT = '0x55d398326f99059ff775485246999027b3197955';
					$("#gast-bsc").css("box-shadow", "inset 4px 4px 12px rgba(0,0,0,0.27), inset -4px -4px 12px rgba(0,0,0,0.27)");
				}
				if(network_pay == 'matic'){
					var chainID = '0x89';
					var chainName = 'Polygon Mainnet';
					var rpcUrls = ["https://polygon-rpc.com/"];
					var blockExplorerUrls = ['https://polygonscan.com/'];
					var nativeCurrency = {name: 'Polygon MATIC',	symbol: 'MATIC', decimals: 18}

					var Gastcoin_CONTRACT = '0xE6cDbF538A4996B97fD98675bdf476aaBe8B5e1e';
					var Gastcoin_BUSD = '0xA8D394fE7380b8cE6145d5f85E6aC22d4E91ACDe';
					var Gastcoin_USDT = '0xc2132D05D31c914a87C6611C10748AEb04B58e8F';
					$("#gast-matic").css("box-shadow", "inset 4px 4px 12px rgba(0,0,0,0.27), inset -4px -4px 12px rgba(0,0,0,0.27)");
				}
				console.log(network_pay);
				let identificadorTiempoDeEspera;

				function temporizadorDeRetraso() {
				identificadorTiempoDeEspera = setTimeout(funcionConRetraso, 3000);
				}

				function funcionConRetraso() {
					var parametros_n = {
						nonce: gastcoin_conf.nonce,
						action: gastcoin_conf.action,
						'read_notes': 'notes', 
						'order_id': <?php echo $order_id; ?>, // Here we send the order Id
						
					};

					var gastcoin_pay = jQuery.ajax({
						data: parametros_n,
						url: woocommerce_params.ajax_url,
						type: "POST",
						beforeSend: function() {
							//jQuery('.response').text("Processing data...");
						},
						success: function(response) {
							//jQuery("#transaction_complete").html(response);
							if(response != ''){
								$('.gast-text-confirmation').css("display", "block");
								$('.gast-spinner').css("display", "none");
								$('.gast-text-confirmation').html('<div>Payment processed successfully: <a target="_blank" href="' + response + '">View in blockchain</a></div>');
								$("a.complete-status-tether").css("pointer-events", "none");
								$(".container-gast-card .card .color").css("display", "none");
								$(".container-gast-card .card .size").css("display", "none");
								$(".gast-wallet").css("display", "none");
								$(".card").css("height", "430px");

								$(".gast_btn").css("display", "none");
							}
						}
					});
					temporizadorDeRetraso();
				}
				temporizadorDeRetraso();
				

				if (typeof window.ethereum === 'undefined') {
					console.log('test undefined');
					var gast_url_topay_or = window.location.href;


					gast_url_topay = gast_url_topay_or.replace('https://', 'https://metamask.app.link/dapp/');
					gast_url_topay = gast_url_topay.replace('http://', 'https://metamask.app.link/dapp/');

					gast_url_topay_trust = gast_url_topay_or.replace('https://', 'https://link.trustwallet.com/open_url?coin_id=56&url=https://');
					gast_url_topay_trust = gast_url_topay_trust.replace('http://', 'https://link.trustwallet.com/open_url?coin_id=56&url=http://');

					$('#gast-btn-coinbasewallet').attr('href', 'https://go.cb-w.com/dapp?cb_url='+encodeURIComponent(gast_url_topay_or));
					$('#gast-btn-metamask').attr('href', gast_url_topay);
					$('#gast-btn-trust').attr('href', gast_url_topay_trust);
					$(".btn-crypto").css("display", "none");
					$(".btn-gast-pay").css("display", "none");
				} else {
				
					$("#metamask-gast-validate").css("display", "none");
					$(".gast-wallet").css("display", "none");
					$(".container-gast-card .card").css("height", "430px");

					if (typeof woocommerce_params === 'undefined')
						return false;
					
					//
					async function getRed() {
						try {
					  await ethereum.request({
						method: 'wallet_switchEthereumChain',
						params: [{ chainId: chainID }],
					  });
					} catch (switchError) {

					  // This error code indicates that the chain has not been added to MetaMask.
					  if (switchError.code === 4902 || switchError.code === -32603) { 
						try {
						  	await ethereum.request({
							method: 'wallet_addEthereumChain',
							params: [
							  {
								chainId: chainID,
								chainName: chainName,
								rpcUrls: rpcUrls,
								blockExplorerUrls: blockExplorerUrls,
								nativeCurrency: nativeCurrency
							  },
							],
						  });
						  location.reload();
						} catch (addError) {
						  // handle "add" error
						}
					  }
					  // handle other "switch" errors
					}
					}
					getRed();
					//

					let accounts = [];
					//let contractInstance;


					async function getAccount() {
						accounts = await ethereum.request({
							method: 'eth_requestAccounts'
						});
						console.log(accounts);

					}
					getAccount();

					//pay by Gastcoin
					$('button.complete-status').click(function(e) {
						e.preventDefault();

						var Gastcoin_Gast = '0x8477ED2eE590FDAF9D63E8Ed1d3d6770167fcDB5';

						var parametros = {
							nonce: gastcoin_conf.nonce,
							action: gastcoin_conf.action,
							'account_id_metamask': accounts[0], // Here we send the order Id
							/*'monto_to_pay': <?php //esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id*/
							'monto_to_pay': <?php esc_html_e(number_format($total_to_pay)) ?>, // Here we send the order Id
							'token_contract': Gastcoin_Gast, // token contrat
						};

						var gastcoin_pay = jQuery.ajax({
							data: parametros,
							url: woocommerce_params.ajax_url,
							type: "POST",
							beforeSend: function() {
								$('.response').text("Processing data...");
								$(".container-gast-card .card .color").css("display", "none");
								$(".container-gast-card .card .size").css("display", "none");
							},
							success: function(response) {
								console.log(response + ' 22');
								ethereum.request({
										method: 'eth_sendTransaction',
										params: [{
											from: accounts[0],
											to: Gastcoin_Gast,
											gas: '0x493E0',
											data: response,
											"chainId": chainID
										}, ],
									})
									.then((txHash) => gastcoin_pay_exito(txHash, Gastcoin_Gast))
									.catch((error) => gastcoin_pay_error(error));
							}
						});
					});

					//pay by tether
					$('a.complete-status-tether').click(function(e) {
						$("a.complete-status-tether").css("pointer-events", "none");
						$(".container-gast-card .card .color").css("display", "none");
						$(".container-gast-card .card .size").css("display", "none");
						$(".container-gast-card .gast-spinner").css("display", "block");
						e.preventDefault();

						var parametros = {
							nonce: gastcoin_conf.nonce,
							action: gastcoin_conf.action,
							'account_id_metamask': accounts[0], // Here we send the order Id
							'Gastcoin_CONTRACT': Gastcoin_CONTRACT,
							'monto_to_pay': <?php echo esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
							'token_contract': Gastcoin_USDT, // token contrat
							"txId" : '',
						};

						var gastcoin_pay = jQuery.ajax({
							data: parametros,
							url: woocommerce_params.ajax_url,
							type: "POST",
							beforeSend: function() {
								$('.response').text("Processing data...");
							},
							success: function(response) {
								console.log(response + ' 222');
								if(response == 0){
									var parametros2 = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'approve': 'approve', 
										'token_contract': Gastcoin_USDT,
										'account_id_metamask': accounts[0]
									};
									var gastcoin_pay_2 = jQuery.ajax({
										data: parametros2,
										url: woocommerce_params.ajax_url,
										type: "POST",
										beforeSend: function() {
											$('.response').text("Processing data...");
										},
										success: function(response) {
											console.log(response + ' 223');
											ethereum.request({
												method: 'eth_sendTransaction',
												params: [{
													from: accounts[0],
													to: Gastcoin_USDT,
													gas: '0x493E0',
													data: response,
													"chainId": chainID
												}, ],
											})
											.then((txHash) => gastcoin_pay_exito(txHash, Gastcoin_USDT))
											.catch((error) => gastcoin_pay_error(error));
										}
									});

								}else{
									var parametros = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'account_id_metamask_send': accounts[0], // Here we send the order Id
										'monto_to_pay': <?php echo esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
										'token_contract': Gastcoin_USDT, // token contrat
									};

									var gastcoin_pay_2 = jQuery.ajax({
										data: parametros,
										url: woocommerce_params.ajax_url,
										type: "POST",
										beforeSend: function() {
											$('.response').text("Processing data...");
										},
										success: function(response2) {
											console.log(response2 + ':224');
											ethereum.request({
												method: 'eth_sendTransaction',
												params: [{
													from: accounts[0],
													to: Gastcoin_CONTRACT,
													gas: '0x493E0',
													data: response2,
													"chainId": chainID
												},],
											})
											.then((txHash) => gastcoin_pay_exito2(txHash, Gastcoin_USDT))
											.catch((error) => gastcoin_pay_error(error));
											$("a.complete-status-tether").css("pointer-events", "initial");
										}
									});

								}
							}
						});
						
					});

					//pay by busd Gastcoin_BUSD
					$('a.complete-status-busd').click(function(e) {
						$("a.complete-status-busd").css("pointer-events", "none");
						$(".container-gast-card .card .color").css("display", "none");
						$(".container-gast-card .card .size").css("display", "none");
						$(".container-gast-card .gast-spinner").css("display", "block");
						e.preventDefault();

						var parametros = {
							nonce: gastcoin_conf.nonce,
							action: gastcoin_conf.action,
							'account_id_metamask': accounts[0], // Here we send the order Id
							'Gastcoin_CONTRACT': Gastcoin_CONTRACT,
							'monto_to_pay': <?php echo esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
							'token_contract': Gastcoin_BUSD, // token contrat
							"txId" : '',
						};

						var gastcoin_pay = jQuery.ajax({
							data: parametros,
							url: woocommerce_params.ajax_url,
							type: "POST",
							beforeSend: function() {
								$('.response').text("Processing data...");
							},
							success: function(response) {
								console.log(response + ' 222');
								if(response == 0){
									var parametros2 = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'approve': 'approve', 
										'token_contract': Gastcoin_BUSD,
										'account_id_metamask': accounts[0]
									};
									var gastcoin_pay_2 = jQuery.ajax({
										data: parametros2,
										url: woocommerce_params.ajax_url,
										type: "POST",
										beforeSend: function() {
											$('.response').text("Processing data...");
										},
										success: function(response3) {
											console.log(response3 + ' 223bu');
											ethereum.request({
												method: 'eth_sendTransaction',
												params: [{
													from: accounts[0],
													to: Gastcoin_BUSD,
													gas: '0x493E0',
													data: response3,
													"chainId": chainID
												}, ],
											})
											.then((txHash) => gastcoin_pay_exito(txHash, Gastcoin_BUSD))
											.catch((error) => gastcoin_pay_error(error));
										}
									});

								}else{
									var parametros = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'account_id_metamask_send': accounts[0], // Here we send the order Id
										'monto_to_pay': <?php echo esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
										'token_contract': Gastcoin_BUSD, // token contrat
									};

									var gastcoin_pay_2 = jQuery.ajax({
										data: parametros,
										url: woocommerce_params.ajax_url,
										type: "POST",
										beforeSend: function() {
											$('.response').text("Processing data...");
										},
										success: function(response2) {
											console.log(response2 + ':224');
											ethereum.request({
												method: 'eth_sendTransaction',
												params: [{
													from: accounts[0],
													to: Gastcoin_CONTRACT,
													gas: '0x493E0',
													data: response2,
													"chainId": chainID
												},],
											})
											.then((txHash) => gastcoin_pay_exito2(txHash, Gastcoin_USDT))
											.catch((error) => gastcoin_pay_error(error));
											$("a.complete-status-busd").css("pointer-events", "initial");
										}
									});

								}
							}
						});

						
					});


					<?php if($custom_token != 'false' && $custom_token != ''){?>

					//pay by custom
					$('button.gastcoin-pay-button-custom').click(function(e) {
						e.preventDefault();
						<?php
							echo "var gast_value_name ='";esc_html_e($gast_value_name);echo "';";
							echo "var gast_value_symbol ='";esc_html_e($gast_value_symbol);echo "';";
							echo "var gast_value_address ='";esc_html_e($gast_value_address);echo "';";
							echo "var gast_value_decimals ='";esc_html_e($gast_value_decimals);echo "';";
						?>
						var parametros = {
							nonce: gastcoin_conf.nonce,
							action: gastcoin_conf.action,
							'account_id': accounts[0], // Here we send the order Id
							'monto_to_pay': <?php esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
							'token_contract': gast_value_address, // token contrat
							'name': gast_value_name,
							'symbol': gast_value_symbol,
							'address': gast_value_address,
							'decimals': gast_value_decimals,
						};
						var gastcoin_pay = jQuery.ajax({
							data: parametros,
							url: woocommerce_params.ajax_url,
							type: "POST",
							beforeSend: function() {
								$('.response').text("Processing data...");
							},
							success: function(response) {
								console.log(response + ' 222');
								if(response == 0){
									var parametros2 = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'approve': 'approve', 
										'token_contract': gast_value_address,
										'account_id_metamask': accounts[0]
									};
									var gastcoin_pay_2 = jQuery.ajax({
										data: parametros2,
										url: woocommerce_params.ajax_url,
										type: "POST",
										beforeSend: function() {
											$('.response').text("Processing data...");
										},
										success: function(response) {
											console.log(response + ' 223');
											ethereum.request({
												method: 'eth_sendTransaction',
												params: [{
													from: accounts[0],
													to: gast_value_address,
													gas: '0x493E0',
													data: response,
													"chainId": chainID
												}, ],
											})
											.then((txHash) => gastcoin_pay_exito(txHash, gast_value_address))
											.catch((error) => gastcoin_pay_error(error));
										}
									});

								}else{
									var parametros = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'account_id_metamask_send': accounts[0], // Here we send the order Id
										'monto_to_pay': <?php echo esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
										'token_contract': gast_value_address, // token contrat
									};

									var gastcoin_pay_2 = jQuery.ajax({
										data: parametros,
										url: woocommerce_params.ajax_url,
										type: "POST",
										beforeSend: function() {
											$('.response').text("Processing data...");
										},
										success: function(response2) {
											console.log(response2 + ':224');
											ethereum.request({
												method: 'eth_sendTransaction',
												params: [{
													from: accounts[0],
													to: Gastcoin_CONTRACT,
													gas: '0x493E0',
													data: response2,
													"chainId": chainID
												},],
											})
											.then((txHash) => gastcoin_pay_exito2(txHash, gast_value_address))
											.catch((error) => gastcoin_pay_error(error));
										}
									});

								}
							}
						});
					});

					<?php } ?>

					function gastcoin_pay_exito(txHash, token_contract) {
						
						<?php if($gast_network_payment == 'bsc'){ ?>
							//gastcoin_pay_exito2(txHash, 'Bscscan transaction Smart Contract', token_contract);
						<?php }else{ ?>
							//gastcoin_pay_exito2(txHash, 'Polygon transaction Smart Contract', token_contract);
						<?php } ?>
						var parametros = {
										nonce: gastcoin_conf.nonce,
										action: gastcoin_conf.action,
										'account_id_metamask_send': accounts[0], // Here we send the order Id
										'monto_to_pay': <?php echo esc_html_e(str_replace(',','', $total_to_pay)) ?>, // Here we send the order Id
										'token_contract': Gastcoin_USDT, // token contrat
									};

						var red_select = '<?php if($gast_network_payment == 'bsc') echo 'Bscscan'; else echo 'Polygon'; ?>';

						var gastcoin_pay = jQuery.ajax({
							data: parametros,
							url: woocommerce_params.ajax_url,
							type: "POST",
							beforeSend: function() {
								$('.response').text("Processing data...");
							},
							success: function(response2) {
								console.log(response2 + ' segundo 33');
								ethereum.request({
										method: 'eth_sendTransaction',
										params: [{
											from: accounts[0],
											to: Gastcoin_CONTRACT,
											gas: '0x493E0',
											data: response2,
											"chainId": chainID
										}, ],
									})
									.then((txHash) => gastcoin_pay_exito2(txHash, red_select+' transaction id', token_contract))
									.catch((error) => gastcoin_pay_error(error));
							}
						});

						console.log(gastcoin_pay);
						console.log(txHash);
						//reload();
					}

					function gastcoin_pay_exito2(txHash, transaction_type, token_contract){
						var parametros = {
							nonce: gastcoin_conf.nonce,
							action: gastcoin_conf.action,
							'order_id': <?php echo esc_html_e($order_id); ?>, // Here we send the order Id
							'transaction_id': txHash, // Here we send the order Id
							'transaction_type': transaction_type,
							'token_contract': token_contract,
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

								$('.gast-text-confirmation').css("display", "block");
								$('.gast-spinner').css("display", "none");
								$('.gast-text-confirmation').html('<div>Payment processed successfully: <a target="_blank" href="' + blockExplorerUrls[0] +'tx/' + txHash + '">View in blockchain</a></div>');
								
								$(".gastcoin-pay-button").css("display", "none");
								$(".gastcoin-pay-button-tether").css("display", "none");
								$(".gastcoin-pay-button-busd").css("display", "none");
								$(".gast_btn").css("display", "none");
								$('.response').text('');
							}
						});
						console.log(gastcoin_pay);
						console.log(txHash);
					}

					function gastcoin_pay_error(error) {
						var gast_url = window.location.href;
						$('.gast-text-confirmation').css("display", "block");
						$('.gast-spinner').css("display", "none");
						$('.gast-text-confirmation').html('<div">' + error['message'] + '<a href="'+gast_url+'">Retry payment</a></div>');
						$('.response-error').text(error['message']);
						//$("a.complete-status-busd").css("pointer-events", "block");
						//$(".container-gast-card .card .color").css("display", "block");
						//$(".container-gast-card .card .size").css("display", "block");
						$('.response').text('');
						console.log("Error en el pago");
					}
				}


				switchNetworkBSC();
			});

			}
      		window.onload = load;

			const switchNetworkBSC = async () => {

				try {

					const response = await ethereum.request({
						method: "wallet_switchEthereumChain",
						params: [{
							chainId: chainID
						}],
					});

					return response;

				} catch (error) {

					// This error code indicates that the chain has not been added to MetaMask.
					if (error.code === 4902) {

						return await this.addNetworkBSC();

					} else {
						// handle other "switch" errors

						return error;

					}

				}

			}
		</script>
		<?php
	}


	public function gastcoin_gast_complete()
	{
		if (!get_option('_network_payment')) {
			add_option('_network_payment', 'bsc', '', 'no');
			$gast_network_payment = 'bsc';
		} else {
				$gast_network_payment = get_option('_network_payment');
		}

		check_ajax_referer('gastcoin_get_setting', 'nonce');
		if (isset($_POST['order_id']) && $_POST['order_id'] > 0 && isset($_POST['transaction_id']) && $_POST['transaction_id'] != '') {
			$order = wc_get_order(sanitize_text_field($_POST['order_id']));
			if(__(sanitize_text_field($_POST['transaction_type']) != 'Bscscan transaction Smart Contract') || __(sanitize_text_field($_POST['transaction_type']) != 'Polygon transaction Smart Contract'))
				$order->update_status('on-hold');
			// The text for the note
			if($gast_network_payment == 'bsc'){
				$note = __('Bscscan transaction id:' .': <a href="https://bscscan.com/tx/' . sanitize_text_field($_POST['transaction_id']) . '" target="_blank">' . sanitize_text_field($_POST['transaction_id']) . '</a>:token:'. sanitize_text_field($_POST['token_contract']));
			}else{
				$note = __('Polygon transaction id:' .': <a href="https://polygonscan.com/tx/' . sanitize_text_field($_POST['transaction_id']) . '" target="_blank">' . sanitize_text_field($_POST['transaction_id']) . '</a>:token:'. sanitize_text_field($_POST['token_contract']));
			}
			
			// Add the note
			$order->add_order_note($note);
		}

		if (isset($_POST['account_id_metamask']) and isset($_POST['monto_to_pay']) and isset($_POST['token_contract'])) {

			$gastcoin_option = get_option('woocommerce_gastcoin_settings');
			$array = [
				"from" => sanitize_text_field($_POST['account_id_metamask']),
				"to" => sanitize_text_field($_POST['Gastcoin_CONTRACT']),
				//"to" => '0xc967E6df64D49Bb082284347447eC481Dc5ef81C',
				"amount" => (float) sanitize_text_field($_POST['monto_to_pay']),
				"contract" => sanitize_text_field($_POST['token_contract']),

			];
			if($gast_network_payment == 'bsc'){
				echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/allowance/bsc?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']) , '')->balance);
				//echo 'https://api.gastcoin.com/api/v2/transaction/allowance/bsc?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']);
			}else{
				echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/allowance/matic?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']) , '')->balance);			}
		}
		if (isset($_POST['account_id_metamask_send'])) {
			$gastcoin_option = get_option('woocommerce_gastcoin_settings');
			$array = [
				"from" => sanitize_text_field($_POST['account_id_metamask_send']),
				"to" => sanitize_text_field($gastcoin_option['address_key']),
				"amount" => (float) sanitize_text_field($_POST['monto_to_pay']),
				"contract" => sanitize_text_field($_POST['token_contract']),
			];
			if($gast_network_payment == 'bsc'){
				echo esc_html_e($this->gastcoin_post('https://api.gastcoin.com/api/v2/transaction/bsc', $array)->data);
			}else{
				echo esc_html_e($this->gastcoin_post('https://api.gastcoin.com/api/v2/transaction/matic', $array)->data);
			}
		}

		if (isset($_POST['account_id']) and isset($_POST['monto_to_pay']) and isset($_POST['token_contract'])) {

			$gastcoin_option = get_option('woocommerce_gastcoin_settings');
			$array = [
				"from" => sanitize_text_field($_POST['account_id']),
				"to" => sanitize_text_field($gastcoin_option['address_key']),
				"amount" => (float) sanitize_text_field($_POST['monto_to_pay']),
				"externalContract" => [
					"type" => "ERC20",
					"name" => sanitize_text_field($_POST['name']),
					"symbol" => sanitize_text_field($_POST['symbol']),
					"address" => sanitize_text_field($_POST['token_contract']),
					"decimals" => (int) sanitize_text_field($_POST['decimals'])
				]

			];
			if($gast_network_payment == 'bsc'){
				echo esc_html_e($this->gastcoin_post('https://api.gastcoin.com/api/v2/transaction/transfer/bsc', $array)->data);
			}else{
				echo esc_html_e($this->gastcoin_post('https://api.gastcoin.com/api/v2/transaction/transfer/matic', $array)->data);
			}
		}
		if(isset($_POST['read_notes'])){
			//echo 'aquí las notas';
			    $notes = wc_get_order_notes( array(
					'order_id' => sanitize_text_field($_POST['order_id']),
					'type'     => '', // use 'internal' for admin and system notes, empty for all
				) );
 
			if ( $notes ) {
				foreach( $notes as $key => $note ) {
					// system notes can be identified by $note->added_by == 'system'
					if($note->content){}
						if(substr_count($note->content, 'Bscscan transaction id:')>0 || substr_count($note->content, 'Polygon transaction id:')>0){
							preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i',$note->content, $result);

							if (!empty($result)) {
								# Found a link.
								echo $result['href'][0];
							}
							//printf( $note->content['href'] );
						}
				}
			}
			
		}

		if(isset($_POST['approve'])){
			if($gast_network_payment == 'bsc'){
				echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/approve/bsc?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']) , '')->data);

			}else{
				echo esc_html_e($this->gastcoin_get('https://api.gastcoin.com/api/v2/transaction/approve/matic?address='. sanitize_text_field($_POST['account_id_metamask']) .'&contract=' . sanitize_text_field($_POST['token_contract']) , '')->data);
			}
		}
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
			echo  esc_html_e("Something went wrong: $response");
		} else {
			//print_r(json_decode($response['body']));
			return json_decode($response['body'])->data;
		}
	}

	function gastcoin_get($server, $variables)
	{
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

		$response = wp_remote_get($endpoint, $options);

		if (is_wp_error($response)) {
			echo  esc_html_e("Something went wrong: $response");
		} else {
			//print_r(json_decode($response['body']));
			return json_decode($response['body'])->data;
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
	
	function gastcoin_pay_buttons(){
		
	}
}


