(function( jQuery ) {



	jQuery(document).ready(function () {
		if (typeof window.ethereum !== 'undefined') {
			console.log('MetaMask is installed!');
		}


	});

	/*const abi = [{
		"constant": false,
		"inputs": [
		],
		"name": "buy",
		"outputs": [
			{
				"name": "success",
				"type": "bool"
			}
		],
		"payable": true,
		"type": "function"
	}]
	const contract_address = '0xf035755df96ad968a7ad52c968dbe86d52927f5b'

	var address = '0x91612055A68aD74A6e756615941Ac59e9220A940'
	function startApp(web3) {
		//alert("entro");
		const eth = new Eth(web3.currentProvider)
		const token = eth.contract(abi).at(contract_address);
		listenForClicks(token, web3)
		//alert("llego");
	}
	function listenForClicks(miniToken, web3) {
		var button = document.querySelector('button.transferFunds')
		web3.eth.getAccounts(function (err, accounts) { console.log(accounts); address = accounts.toString(); })
		button.addEventListener('click', function () {
			miniToken.buy({ from: address, value: '1000000000000000000' })
				.then(function (txHash) {
					console.log('Transaction sent')
					console.dir(txHash)
					waitForTxToBeMined(txHash)
				})
				.catch(console.error)
		})
	}
	async function waitForTxToBeMined(txHash) {
		let txReceipt
		while (!txReceipt) {
			try {
				txReceipt = await eth.getTransactionReceipt(txHash)
			} catch (err) {
				return indicateFailure(err)
			}
		}
		indicateSuccess()
	}*/

	
})( jQuery );
