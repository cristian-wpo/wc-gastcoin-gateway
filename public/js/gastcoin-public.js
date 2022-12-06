var accounts = [];
var DataNetwork = null;
var CryptoSelect = null;
var gastcoin_text = null;
var url_path  = null;

(function( jQuery ) {
	jQuery(document).ready(function () {
		if ( jQuery("#gastcoin-gateway").length > 0 ) 
		if(typeof window.ethereum === 'undefined'){
			if ( jQuery("#gast-qr-1").length > 0 ) {
				create_gast_qr();	
			}
		}else{
			jQuery( "#gastcoin-gateway" ).css("display", "block");
			jQuery( "#gastcoin-gateway-select-wallet" ).css("display", "none");
			gastcoin_mobil();
			
			
			getAccount();
			var gastcoin_txt = get_gastcoin_text();
				gastcoin_txt.success(function (data) {
				gastcoin_text = JSON.parse(data);
				console.log(gastcoin_text);
				//get url patch
				var url_path_obj = get_actions_gastcoin('get_url_gastcoin_path');
				url_path_obj.success(function (data) {
					//variables
					url_path = data;
					if(window.ethereum.isSafePal){
						jQuery("#img-wallet").attr("src",url_path+"assets/img/safepal-large.png");
						jQuery("#gast-img-wallet").attr("src",url_path+"assets/img/ico-safepal.png");
						//detect_wallet_network(url_path);
					}else if(window.ethereum.isMetaMask){
						jQuery("#img-wallet").attr("src",url_path+"assets/img/metamask-large.png");
						jQuery("#gast-img-wallet").attr("src",url_path+"assets/img/ico-metamask.png");
						
					}else if(window.ethereum.isCoinbaseWallet){
						jQuery("#gast-img-wallet").attr("src",url_path+"assets/img/ico-coinbasewallet.png");
						jQuery("#img-wallet").attr("src",url_path+"assets/img/coinbase-wallet-large.png");
						
					}else{
						jQuery("#gast-img-wallet").attr("src",url_path+"assets/img/ico-trustwallet.png");
						jQuery("#img-wallet").attr("src",url_path+"assets/img/trust-wallet-large.png");
					}
					setTimeout(detect_wallet_network, 1000, url_path);

					//get image of card
					get_card_image(url_path);
					jQuery("#gast-text-alert").text(gastcoin_text['select_network']);
					jQuery('.btn-crypto-gastcoin button').attr('disabled', true);
					jQuery('#gastcoin-gateway-pay').attr('disabled', true);
					
					
					jQuery('#gast-matic').click(function (event) {
						//MATIC network select
						event.preventDefault();
						
						if(production_network != 'false'){
							casg_polygon();
						}else{
							casg_polygon_tesnet();
						}
						actions_wallets('matic');
						check_status_network(137, url_path);
						return false;
					});

					jQuery('#gast-bsc').click(function (event) {
						//BSC network select
						event.preventDefault();
						
						if(production_network != 'false'){
							casg_bsc();
						}else{
							casg_bsc_tesnet();
						}
						actions_wallets('bsc');
						check_status_network(56, url_path);
						return false;
					});


					//pay by tether
					jQuery('#gast-btn-usdt').click(function(e) {
						e.preventDefault();
						jQuery( "#gast-btn-usdt" ).addClass("is-loading");
						activate_crypto_btn('usdt', DataNetwork, url_path);
						CryptoSelect = 'usdt';
					});

					//pay by busd
					jQuery('#gast-btn-busd').click(function(e) {
						e.preventDefault();
						jQuery( "#gast-btn-busd" ).addClass("is-loading");
						activate_crypto_btn('busd', DataNetwork, url_path);
						CryptoSelect = 'busd';
					});

					//pay by usdc
					jQuery('#gast-btn-usdc').click(function(e) {
						e.preventDefault();
						jQuery( "#gast-btn-usdc" ).addClass("is-loading");
						activate_crypto_btn('usdc', DataNetwork, url_path);
						CryptoSelect = 'usdc';
					});

					//pay order
					jQuery('#gastcoin-gateway-pay').click(function(e) {
						e.preventDefault();
						jQuery('#gastcoin-gateway-pay').attr('disabled', true);
						pay_by_crypto_gast(DataNetwork, CryptoSelect, gastcoin_order_id);
					});
					

					//get network select
					
				});
			});
		}
		console.log(' casg - ' + production_network);
	});

})( jQuery );

function casg_bsc(){
	DataNetwork = {
		network:'bsc',
		chainID:"0x38",
		chainName:"BSC Mainnet",
		rpcUrls:["https://bsc-dataseed.binance.org/","https://bsc-dataseed1.binance.org","https://bsc-dataseed2.binance.org","https://bsc-dataseed3.binance.org","https://bsc-dataseed4.binance.org","https://bsc-dataseed1.defibit.io","https://bsc-dataseed2.defibit.io","https://bsc-dataseed3.defibit.io","https://bsc-dataseed4.defibit.io","https://bsc-dataseed1.ninicoin.io","https://bsc-dataseed2.ninicoin.io","https://bsc-dataseed3.ninicoin.io","https://bsc-dataseed4.ninicoin.io","wss://bsc-ws-node.nariox.org"],
		blockExplorerUrls:['https://bscscan.com/'],
		nativeCurrency:{name: 'Binance Coin',	symbol: 'BNB', decimals: 18},
		Gastcoin_CONTRACT:'0xDaDF71d0a6A3F96d580B7d10Db28f46bB868Bc20',
		Gastcoin_BUSD:'0xe9e7cea3dedca5984780bafc599bd69add087d56',
		Gastcoin_USDT:'0x55d398326f99059ff775485246999027b3197955',
		Gastcoin_USDC:'0x8ac76a51cc950d9822d68b83fe1ad97b32cd580d',
		UserAccount:accounts[0],
		MontoPay:gastcoin_total_pay
	};
}

function casg_polygon(){
	DataNetwork = {
		network:'matic',
		chainID:"0x89",
		chainName:"Polygon Mainnet",
		rpcUrls:["https://polygon-rpc.com", "https://rpc-mainnet.matic.network", "https://matic-mainnet.chainstacklabs.com", "https://rpc-mainnet.maticvigil.com", "https://rpc-mainnet.matic.quiknode.pro", "https://matic-mainnet-full-rpc.bwarelabs.com", "https://matic-mainnet-archive-rpc.bwarelabs.com", "https://poly-rpc.gateway.pokt.network", "https://rpc.ankr.com/polygon"],
		blockExplorerUrls:['https://polygonscan.com/'],
		nativeCurrency:{name: 'Polygon MATIC',	symbol: 'MATIC', decimals: 18},
		Gastcoin_CONTRACT:'0xE6cDbF538A4996B97fD98675bdf476aaBe8B5e1e',
		Gastcoin_BUSD:'0x9fB83c0635De2E815fd1c21b3a292277540C2e8d',
		Gastcoin_USDT:'0xc2132D05D31c914a87C6611C10748AEb04B58e8F',
		Gastcoin_USDC:'0x2791bca1f2de4661ed88a30c99a7a9449aa84174',
		UserAccount:accounts[0],
		MontoPay:gastcoin_total_pay
	};
}

function casg_bsc_tesnet(){
	DataNetwork = {
		network:'testnet',
		chainID:"0x61",
		chainName:"Binance Smart Chain Testnet",
		rpcUrls:["https://data-seed-prebsc-1-s1.binance.org:8545",
		"https://data-seed-prebsc-2-s1.binance.org:8545",
		"https://data-seed-prebsc-1-s2.binance.org:8545",
		"https://data-seed-prebsc-2-s2.binance.org:8545",
		"https://data-seed-prebsc-1-s3.binance.org:8545",
		"https://data-seed-prebsc-2-s3.binance.org:8545"],
		blockExplorerUrls:['https://testnet.bscscan.com/'],
		nativeCurrency:{name: 'Binance Coin',	symbol: 'BNB', decimals: 18},
		Gastcoin_CONTRACT:'0x78EAeF98776d4BfC94989Bfa45fA7f8B1180a90F',
		Gastcoin_BUSD:'0xe9e7cea3dedca5984780bafc599bd69add087d56',
		Gastcoin_USDT:'0x55d398326f99059ff775485246999027b3197955',
		Gastcoin_USDC:'0x8ac76a51cc950d9822d68b83fe1ad97b32cd580d',
		UserAccount:accounts[0],
		MontoPay:gastcoin_total_pay
	};
}
function casg_polygon_tesnet(){
	DataNetwork = {
		network:'testnet',
		chainID:"0x13881",
		chainName:"Mumbai",
		rpcUrls:["https://matic-mumbai.chainstacklabs.com",
		"https://rpc-mumbai.maticvigil.com",
		"https://matic-testnet-archive-rpc.bwarelabs.com"],
		blockExplorerUrls:["https://mumbai.polygonscan.com/"],
		nativeCurrency:{name: 'MATIC',	symbol: 'MATIC', decimals: 18},
		Gastcoin_CONTRACT:'0xAC35FFA52a0cD018ad9F62b317F1bf3f8558Ae49',
		Gastcoin_BUSD:'0x9fB83c0635De2E815fd1c21b3a292277540C2e8d',
		Gastcoin_USDT:'0xc2132D05D31c914a87C6611C10748AEb04B58e8F',
		Gastcoin_USDC:'0x2791bca1f2de4661ed88a30c99a7a9449aa84174',
		UserAccount:accounts[0],
		MontoPay:gastcoin_total_pay
	};
}

function detect_wallet_network(url_path){
	console.log();
	status_network(56, url_path, true, 0x38);
	status_network(137, url_path, true, 0x89);

	//bsc-testnet
	status_network(97, url_path, true, 0x61);

	//Mumbai
	status_network(80001, url_path, true, 0x13881);
}

function get_gastcoin_text(){
	var parametros = {
		nonce: gastcoin.nonce,
		action: gastcoin.action,
		'case': 'get_text'
	};		

	return jQuery.ajax({
		data: parametros,
		url: gastcoin.ajaxurl,
		type: "POST",
		beforeSend: function() {
		},
		success: function(response) {
			//console.log(response);
		}
	});
}

function go_to_wallet(wallet){
	var gast_url_topay_or = window.location.href;

	gast_url_topay = gast_url_topay_or.replace('https://', 'dapp://');
	gast_url_topay = gast_url_topay.replace('http://', 'dapp://');

	gast_url_topay_trust = gast_url_topay_or.replace('https://', 'https://link.trustwallet.com/open_url?coin_id=56&url=https://');
	gast_url_topay_trust = gast_url_topay_trust.replace('http://', 'https://link.trustwallet.com/open_url?coin_id=56&url=http://');

	if(wallet == 'coinbasewallet'){
		//jQuery(location).attr('href', 'https://go.cb-w.com/dapp?cb_url='+encodeURIComponent(gast_url_topay_or));
		window.open('https://go.cb-w.com/dapp?cb_url='+encodeURIComponent(gast_url_topay_or), '_blank');
	}

	if(wallet == 'metamask'){
		if (window.matchMedia('(max-width: 767px)').matches) {
			window.open(gast_url_topay);
		}else{
			gast_url_topay = gast_url_topay_or.replace('https://', 'https://metamask.app.link/dapp/');
			gast_url_topay = gast_url_topay.replace('http://', 'https://metamask.app.link/dapp/');
			//jQuery(location).attr('href', gast_url_topay).attr('target','_blank');
			window.open(gast_url_topay, '_blank');
		}
		
	}

	if(wallet == 'trustwallet'){
		//jQuery(location).attr('href', gast_url_topay_trust).attr('target','_blank');
		window.open(gast_url_topay_trust, '_blank');
	}
}

function gastcoin_mobil(){
	jQuery( "#gastcoin-client-wallet" ).css("font-size", "12px");
	jQuery( "#gast-text-alert" ).css("font-size", "14px !important");
	if (window.matchMedia('(max-width: 767px)').matches) {
        jQuery( ".is-mobile div" ).removeClass("is-6");
		jQuery( ".is-mobile div:nth-child(1)" ).addClass("is-7");
		jQuery( "#gastcoin-total" ).removeClass("mb-0");
		jQuery( "#gastcoin-total" ).removeClass("mt-0");
		jQuery( "#gastcoin-total" ).addClass("mb-4");
		jQuery( "#gastcoin-total" ).addClass("mt-4");
		jQuery( "#gastcoin-client-wallet" ).addClass("mb-2");
    }

}

function pay_by_crypto_gast(DataNetwork, token){
	if(token == 'usdt'){
		token_contract = DataNetwork.Gastcoin_USDT;
	}else if(token == 'busd'){
		token_contract = DataNetwork.Gastcoin_BUSD;
	}	else if(token == 'usdc'){
		token_contract = DataNetwork.Gastcoin_USDC;
	}

	var parametros = {
		nonce: gastcoin.nonce,
		action: gastcoin.action,
		'case': 'gastcoin_gateway_pay',
		'account_id_metamask': DataNetwork.UserAccount, // Here we send the order Id
		'monto_to_pay': DataNetwork.MontoPay, // Here we send the order Id
		'token_contract': token_contract, // token contrat
		'network_payment':  DataNetwork.network
	};		

	var gastcoin_pay = jQuery.ajax({
		data: parametros,
		url: gastcoin.ajaxurl,
		type: "POST",
		beforeSend: function() {
			jQuery('.response').text(gastcoin_text['processing_data']);
		},
		success: function(response) {
			console.log('Transaction data: ' + response);
			ethereum.request({
			method: 'eth_sendTransaction',
			params: [{
				from: DataNetwork.UserAccount,
				to: DataNetwork.Gastcoin_CONTRACT,
				gas: '0x493E0',
				data: response,
				"chainId": DataNetwork.chainID
			},],
			})
			.then((txHash) => transaction_manage_gastcoin(DataNetwork, txHash, gastcoin_order_id))
			.catch((error) => gastcoin_error_pay(error));
		}
	});
}

function gastcoin_error_pay(){
	jQuery('#gastcoin-gateway-pay').attr('disabled', false);
}

function transaction_manage_gastcoin(DataNetwork, txHash, gastcoin_order_id){
	var parametros = {
		nonce: gastcoin.nonce,
		action: gastcoin.action,
		'case': 'add_note',
		'note': txHash,
		'order_id': gastcoin_order_id,
		'network_payment':  DataNetwork.network
	};		

	var gastcoin_pay = jQuery.ajax({
		data: parametros,
		url: gastcoin.ajaxurl,
		type: "POST",
		beforeSend: function() {
		},
		success: function(response) {
			console.log(response);
		}
	});

	check_status_txhash(DataNetwork, txHash, gastcoin_order_id);
}

function check_status_txhash(DataNetwork, txHash, gastcoin_order_id){
	console.log('txHash: ' + txHash);
	var parametros = {
		nonce: gastcoin.nonce,
		action: gastcoin.action,
		'case': 'txHash_status',
		'txHash': txHash, 
		'network_payment': DataNetwork.network,
		'order_id': gastcoin_order_id
	};

	var gastcoin_pay = jQuery.ajax({
		data: parametros,
		url: woocommerce_params.ajax_url,
		type: "POST",
		beforeSend: function() {
		},
		success: function(response) {
			console.log('Status txHash: ' + response);
			recheck_status_txhash(DataNetwork, txHash, response+"", gastcoin_order_id);
		}
	});
}

function recheck_status_txhash(DataNetwork, txHash, data, gastcoin_order_id){
	if(data == 'processing'){
		if(jQuery("#gastcoin-gateway-pay").text() == gastcoin_text['processing']){
			jQuery("#gastcoin-gateway-pay").text(gastcoin_text['processing_1']);
		}else if(jQuery("#gastcoin-gateway-pay").text() == gastcoin_text['processing_1']){
			jQuery("#gastcoin-gateway-pay").text(gastcoin_text['processing_2']);
		}else if(jQuery("#gastcoin-gateway-pay").text() == gastcoin_text['processing_2']){
			jQuery("#gastcoin-gateway-pay").text(gastcoin_text['processing_3']);
		}else if(jQuery("#gastcoin-gateway-pay").text() == gastcoin_text['processing_3']){
			jQuery("#gastcoin-gateway-pay").text(gastcoin_text['processing']);
		}else{
			jQuery("#gastcoin-gateway-pay").text(gastcoin_text['processing']);
		}
		jQuery(".gastcoin-card .loader").css("display", "block");
		jQuery('#gastcoin-gateway-pay').attr('disabled', true);
		check_status_txhash(DataNetwork, txHash, gastcoin_order_id);
	}
	if(data == '0' || data == '0' || data == ''){
		jQuery("#gastcoin-gateway-pay").text(gastcoin_text['pay_now']);
		jQuery(".gastcoin-card .loader").css("display", "none");
		jQuery("#gast-text-alert").text(gastcoin_text['patment_error']);
		jQuery('#gastcoin-gateway-pay').attr('disabled', false);
		if(DataNetwork.network == 'bsc'){ 
			jQuery("#gastcoin-client-wallet").html('<a href="https://bscscan.com/tx/' + txHash + '" target="_blank">Ver transacción</a>');
		}
		if(DataNetwork.network == 'matic'){
			jQuery("#gastcoin-client-wallet").html('<a href="https://polygonscan.com/tx/' + txHash + '" target="_blank">Ver transacción</a>');
		}

	}
	if(data == '1'){
		jQuery("#gastcoin-gateway-pay").text(gastcoin_text['completed']);
		jQuery(".gastcoin-card .loader").css("display", "none");

		jQuery("#gast-text-alert").text(gastcoin_text['succesful']);
		jQuery('#gastcoin-gateway-pay').attr('disabled', true);
		if(DataNetwork.network == 'bsc'){
			jQuery("#gastcoin-client-wallet").html('<a href="https://bscscan.com/tx/' + txHash + '" target="_blank">Ver transacción</a>');
		}
		if(DataNetwork.network == 'matic'){
			jQuery("#gastcoin-client-wallet").html('<a href="https://polygonscan.com/tx/' + txHash + '" target="_blank">Ver transacción</a>');
		}
	}
	
}

function check_status_network(network, url_path) {
	identificadorTiempoDeEspera = setTimeout(status_network, 1000, network, url_path);
}

function status_network(network, url_path, start = false, hexanetwork = '-0x0'){
	jQuery('#gastcoin-gateway-pay').attr('disabled', true);
	console.log("chainId: "+window.ethereum.chainId);
	console.log("hexanetwork: "+ hexanetwork);
	if(window.ethereum.networkVersion != network && window.ethereum.chainId != hexanetwork){
		if(!start){
			check_status_network(network, url_path);
			return;
		}
	}

	if(window.ethereum.networkVersion != 137 && window.ethereum.networkVersion != 56){
		jQuery("#gast-text-alert").text(gastcoin_text['select_network']);
		jQuery('.btn-crypto-gastcoin button').attr('disabled', true);
		jQuery( ".btn-crypto-gastcoin button" ).addClass("is-loading");
		jQuery(".gast-img-network").attr("src",url_path+"assets/img/ico-alert.png");
		console.log("Es desigual");
	}else{
		jQuery("#gast-text-alert").text(gastcoin_text['select_crypto']);
		jQuery('.btn-crypto-gastcoin button').attr('disabled', false);
		jQuery( ".btn-crypto-gastcoin button" ).removeClass("is-loading");
		if(window.ethereum.networkVersion == 137 || window.ethereum.chainId == '0x89'){
			jQuery(".gast-img-network").attr("src",url_path+"assets/img/ico-polygon.png");
			jQuery( "#gast-matic button" ).addClass("is-active");
			jQuery("#gast-bsc button").removeClass("is-active");
			if(production_network != 'false'){
				casg_polygon();
			}else{
				casg_polygon_tesnet();
			}
		}else if(window.ethereum.networkVersion == 56 || window.ethereum.chainId == '0x38'){
			jQuery(".gast-img-network").attr("src",url_path+"assets/img/ico-bsc.png");
			jQuery("#gast-bsc button").addClass("is-active");
			jQuery("#gast-matic button").removeClass("is-active");
			if(production_network != 'false'){
				casg_bsc();
			}else{
				casg_bsc_tesnet();
			}
		}
	}
		
}

function activate_crypto_btn(token, TokenData, url_path){
	jQuery( ".btn-crypto-gastcoin button" ).removeClass("is-active");
	if(token == 'usdt'){
		token_contract = TokenData.Gastcoin_USDT;
	}else if(token == 'busd'){
		token_contract = TokenData.Gastcoin_BUSD;
	}	else if(token == 'usdc'){
		token_contract = TokenData.Gastcoin_USDC;
	}

	var parametros = {
		nonce: gastcoin.nonce,
		action: gastcoin.action,
		'case': 'Allowance',
		'account_id_metamask': TokenData.UserAccount, // Here we send the order Id
		'Gastcoin_CONTRACT': TokenData.Gastcoin_CONTRACT,
		'monto_to_pay': TokenData.MontoPay, // Here we send the order Id
		'token_contract': token_contract, // token contrat
		'network_payment':  TokenData.network
	};

	var gastcoin_pay = jQuery.ajax({
		data: parametros,
		url: gastcoin.ajaxurl,
		type: "POST",
		beforeSend: function() {
		},
		success: function(response) {
			if(response == 0){
				var parametros2 = {
					nonce: gastcoin.nonce,
					action: gastcoin.action,
					'case': 'approve', 
					'token_contract': token_contract,
					'account_id_metamask': TokenData.UserAccount,
					'network_payment':  TokenData.network
				};
				var gastcoin_pay_2 = jQuery.ajax({
					data: parametros2,
					url: woocommerce_params.ajax_url,
					type: "POST",
					beforeSend: function() {
					},
					success: function(response) {
						ethereum.request({
							method: 'eth_sendTransaction',
							params: [{
								from: accounts[0],
								to: token_contract,
								gas: '0x493E0',
								data: response,
								"chainId": TokenData.chainID
							}, ],
						})
						.then((txHash) => activate_button(token, url_path))
						.catch((error) => desactivate_button(error, url_path));
					}
				});

			}else{
				activate_button(token, url_path);
			}
		}
	});
}

function activate_button(token, url_path){
	jQuery("#gast-text-alert").text(gastcoin_text['make_payment']);
	if(token == 'usdt'){
		jQuery( "#gast-btn-usdt" ).removeClass("is-loading");
		jQuery( "#gast-btn-usdt" ).addClass("is-active");
		jQuery("#gast-img-crypto").attr("src",url_path+"assets/img/crypto-usdt.png");
	}
	if(token == 'usdc'){
		jQuery( "#gast-btn-usdc" ).removeClass("is-loading");
		jQuery( "#gast-btn-usdc" ).addClass("is-active");
		jQuery("#gast-img-crypto").attr("src",url_path+"assets/img/crypto-usdc.png");
	}
	if(token == 'busd'){
		jQuery( "#gast-btn-busd" ).removeClass("is-loading");
		jQuery( "#gast-btn-busd" ).addClass("is-active");
		jQuery("#gast-img-crypto").attr("src",url_path+"assets/img/crypto-busd.png");
	}
	if(token == 'gast'){
		jQuery( "#gast-btn-gast" ).removeClass("is-loading");
		jQuery( "#gast-btn-gast" ).addClass("is-active");
		jQuery("#gast-img-crypto").attr("src",url_path+"assets/img/crypto-gast.png");
	}
	jQuery('#gastcoin-gateway-pay').attr('disabled', false);
}

function desactivate_button(token, url_path){
	if(token == 'usdt'){
		jQuery( "#gast-btn-usdt" ).removeClass("is-loading");
	}
	if(token == 'usdc'){
		jQuery( "#gast-btn-usdc" ).removeClass("is-loading");
	}
	if(token == 'busd'){
		jQuery( "#gast-btn-busd" ).removeClass("is-loading");
	}
	if(token == 'gast'){
		jQuery( "#gast-btn-gast" ).removeClass("is-loading");
	}
	jQuery('#gastcoin-gateway-pay').attr('disabled', true);
}

function create_gast_qr(){
	const gast_qrCode = new QRCodeStyling({
		width: 300,
		height: 300,
		type: "svg",
		data: window.location.href,
		image: logo_gastqr,
		dotsOptions: {
			color: "#27272a",
			type: "rounded"
		},
		backgroundOptions: {
			color: "#f6f7f9",
		},
		imageOptions: {
			crossOrigin: "anonymous",
			margin: 20
		}
	});
	gast_qrCode.append(document.getElementById("gast-qr-1"));
}
function actions_wallets(network_select){
	getRed(network_select);
}

function get_network_select(){
	var gast_url = window.location.href.replace("&network_payment=bsc", "");
	gast_url = gast_url.replace("#", "");
	gast_url = gast_url.replace("&network_payment=matic", "");
	var queryString = window.location.search;
	var urlParams = new URLSearchParams(queryString);
	var anuncioParam = urlParams.get('network_payment');

	return anuncioParam;
}

function get_card_image(data){
	jQuery(".card__part").css("background-image", "url(\""+ data +"assets/img/card-gastcoin.png\")");	
}

function get_actions_gastcoin(get_type){
    var parametros_n = {
		nonce: gastcoin.nonce,
		action: gastcoin.action,
        'post': 1,
        'case': get_type
	};
    try {
        return jQuery.ajax({
            data: parametros_n,
            url: gastcoin.ajaxurl,
            type: "POST",
            beforeSend: function() {
                console.log("Procesando");
            },
            success: function(response) {
                console.log(response);
            }
        });
    } catch (error) {
            console.error(error);
    }
}

function gast_getlink() {
		var aux = document.createElement('input');
		aux.setAttribute('value', window.location.href);
		document.body.appendChild(aux);
		aux.select();
		document.execCommand('copy');
		document.body.removeChild(aux);
		var css = document.createElement('style');
		var estilo = document.createTextNode('#aviso {position:fixed; z-index: 9999999; top: 50%;left:50%;margin-left: -70px;padding: 20px; background: gold;border-radius: 8px;font-family: sans-serif;}');
		css.appendChild(estilo);
		document.head.appendChild(css);
		var aviso = document.createElement('div');
		aviso.setAttribute('id', 'aviso');
		var contenido = document.createTextNode('URL copiada');
		aviso.appendChild(contenido);
		document.body.appendChild(aviso);
		window.load = setTimeout('document.body.removeChild(aviso)', 2000);
	}


async function getRed(network_select) {
	if(network_select == 'bsc'){
		if(production_network != 'false'){
			console.log('Pago con bsc');
			var chainID = '0x38';
			var chainName = 'BSC Mainnet';
			var rpcUrls = ["https://bsc-dataseed.binance.org/","https://bsc-dataseed1.binance.org","https://bsc-dataseed2.binance.org","https://bsc-dataseed3.binance.org","https://bsc-dataseed4.binance.org","https://bsc-dataseed1.defibit.io","https://bsc-dataseed2.defibit.io","https://bsc-dataseed3.defibit.io","https://bsc-dataseed4.defibit.io","https://bsc-dataseed1.ninicoin.io","https://bsc-dataseed2.ninicoin.io","https://bsc-dataseed3.ninicoin.io","https://bsc-dataseed4.ninicoin.io","wss://bsc-ws-node.nariox.org"];
			var blockExplorerUrls = ['https://bscscan.com/'];
			var nativeCurrency = {name: 'Binance Coin',	symbol: 'BNB', decimals: 18}
		}else{
			console.log('Pago con bsc tesnet');
			var chainID = '0x61';
			var chainName = 'Binance Smart Chain Testnet';
			var rpcUrls = ["https://data-seed-prebsc-1-s1.binance.org:8545",
            "https://data-seed-prebsc-2-s1.binance.org:8545",
            "https://data-seed-prebsc-1-s2.binance.org:8545",
            "https://data-seed-prebsc-2-s2.binance.org:8545",
            "https://data-seed-prebsc-1-s3.binance.org:8545",
            "https://data-seed-prebsc-2-s3.binance.org:8545"
        ];
			var blockExplorerUrls = ["https://testnet.bscscan.com/"];
			var nativeCurrency = {name: 'Binance Coin',	symbol: 'BNB', decimals: 18}
		}
	}
	if(network_select == 'matic'){
		if(production_network != 'false'){
			console.log('Pago con matic');
			var chainID = '0x89';
			var chainName = 'Polygon Mainnet';
			var rpcUrls = ["https://polygon-rpc.com/"];
			var blockExplorerUrls = ['https://polygonscan.com/'];
			var nativeCurrency = {name: 'Polygon MATIC',	symbol: 'MATIC', decimals: 18}
		}else{
			console.log('Pago con matic tesnet');
			var chainID = '0x13881';
			var chainName = 'Mumbai';
			var rpcUrls = ["https://matic-mumbai.chainstacklabs.com",
            "https://rpc-mumbai.maticvigil.com",
            "https://matic-testnet-archive-rpc.bwarelabs.com"];
			var blockExplorerUrls = ["https://mumbai.polygonscan.com/"];
			var nativeCurrency = {name: 'MATIC',	symbol: 'MATIC', decimals: 18}
		}
	}
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
		  }).catch((error) => alert(error));

		} catch (addError) {
		  // handle "add" error
		  alert(addError);
		}
	  }
	}
}

async function getAccount() {
	accounts = await ethereum.request({
		method: 'eth_requestAccounts'
	});
	jQuery("#gastcoin-client-wallet").html(accounts[0]);
	//console.log(accounts);
}

