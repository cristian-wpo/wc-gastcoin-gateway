(function( jQuery ) {



	jQuery(document).ready(function () {
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
	});

	
})( jQuery );


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
