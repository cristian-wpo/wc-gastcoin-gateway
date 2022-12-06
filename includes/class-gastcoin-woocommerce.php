<?php
if (!defined('ABSPATH')) exit;
/**
 * Clase para conectar Woocommerce
 */
class WC_Gastcoin_Gateway extends WC_Payment_Gateway
{

	/**
	 * Class constructor, more about it in Step 3
	 */
	public function __construct()
	{

		$this->id = 'gastcoin'; // payment gateway plugin ID
		$this->icon = plugin_dir_url(__DIR__) . 'assets/img/gastcoin-1-e1633707484828.png'; // URL of the icon that will be displayed on checkout page near your gateway name
		$this->has_fields = true; // in case you need a custom credit card form
		$this->method_title = 'Gastcoin Gateway';
		$this->method_description = 'Gastcoin Gateway'; // will be displayed on the options page


		// gateways can support subscriptions, refunds, saved payment methods,
		// but in this tutorial we begin with simple payments
		$this->supports = array(
			'products'
		);

		// Method with all the options fields
		$this->init_form_fields();

		// Load the settings.
		$this->init_settings();
		$this->title = $this->get_option('title');
		$this->description = $this->get_option('description');
		$this->enabled = $this->get_option('enabled');
		$this->account_address =  $this->get_option('address_key');

		// This action hook saves the settings
		add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));

		// We need custom JavaScript to obtain a token
		add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));

		// You can also register a webhook here
		// add_action( 'woocommerce_api_{webhook name}', array( $this, 'webhook' ) );

	}

	/**
	 * Plugin options, we deal with it in Step 3 too
	 */
	public function init_form_fields()
	{
		$this->form_fields = array(
			'enabled' => array(
				'title'       => 'Enable/Disable',
				'label'       => 'Enable Gastcoin Gateway',
				'type'        => 'checkbox',
				'description' => '',
				'default'     => 'no'
			),
			'title' => array(
				'title'       => 'Title',
				'type'        => 'text',
				'description' => 'This controls the title which the user sees during checkout.',
				'default'     => 'Gastcoin Gateway',
				'desc_tip'    => true,
			),
			'description' => array(
				'title'       => 'Description',
				'type'        => 'textarea',
				'description' => 'This controls the description which the user sees during checkout.',
				'default'     => 'Pay with Coinbase Wallet, Metamask or Trust Wallet BUSD or USDT.',
			),
			'address_key' => array(
				'title'       => 'ACCOUNT ADDRESS',
				'type'        => 'text'
			)
		);
	}

	/**
	 * You will need it if you want your custom credit card form, Step 4 is about it
	 */
	public function payment_fields()
	{
		// ok, let's display some description before the payment form
		$this->description = $this->get_option('description');
		echo esc_html_e($this->description);
	}

	/*
		 * Custom CSS and JS, in most cases required only when you decided to go with a custom credit card form
		 */
	public function payment_scripts()
	{

		if (empty($this->account_address)) {
			return;
		}


	}

	/*
 		 * Fields validation, more in Step 5
		 */
	public function validate_fields()
	{
		return true;
	}

	/*
		 * We're processing the payments here, everything about it is in Step 5
		 */
	public function process_payment($order_id)
	{
		// we need it to get any order detailes
		$order = wc_get_order($order_id);

		// Redirect to the thank you page

		$url_redirect = $this->get_return_url($order);
		if (get_option('_gast_url_pay') && get_option('_gast_url_pay') != '') {
			$url_redirect = get_option('_gast_url_pay') . "/?order_id=$order_id";
		}

		return array(

			'result' => 'success',

			'redirect' => $url_redirect
		);
		
		
	}

	/*
		 * In case you need a webhook, like PayPal IPN etc
		 */
	public function webhook()
	{
	}
}
