(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(window).load(function () {
		setting_gastcoin();
	});
	
})( jQuery );


function setting_gastcoin(){

	//save conversion value
	jQuery("#gast_value_converima").blur(function () {
		save_gast_data("gast_value_converima");
	});
	//save pay url redirec
	jQuery("#gast_url_pay").blur(function () {
		save_gast_data("gast_url_pay");
	});
	//save _cbox_gast value
	jQuery("#cbox_gast").blur(function () {
		save_gast_data("cbox_gast", 'check');
	});
	//save cbox_production value
	jQuery("#cbox_production").change(function () {
		save_gast_data("cbox_production", 'check');
	});
	//save cbox_testing value
	jQuery("#cbox_testing").change(function () {
		save_gast_data("cbox_testing", 'check');
	});


	//save cbox_busd value
	jQuery("#cbox_busd").blur(function () {
		save_gast_data("cbox_busd", 'check');
	});
	//save cbox_usdt value
	jQuery("#cbox_usdt").blur(function () {
		save_gast_data("cbox_usdt", 'check');
	});

	/**
	 * Save custom token BSC
	 */
	//save name token
	jQuery("#gast_value_name").blur(function () {
		save_gast_data("gast_value_name");
	});
	//save symbol token
	jQuery("#gast_value_symbol").blur(function () {
		save_gast_data("gast_value_symbol");
	});
	//save address token
	jQuery("#gast_value_address").blur(function () {
		save_gast_data("gast_value_address");
	});
	//save decimal token
	jQuery("#gast_value_decimals").blur(function () {
		save_gast_data("gast_value_decimals");
	});
	//save custom_token value
	jQuery("#custom_token").blur(function () {
		save_gast_data("custom_token", 'check');
	});
	//custom image btn 
	jQuery(document).ready( function($) {
      jQuery('input#gastcoin_media_manager').click(function(e) {
             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                title: 'Select Media',
                multiple : false,
                library : { type : 'image', }
            });

            image_frame.on('close',function() {
            // On close, get selections and save to the hidden input
            // plus other AJAX stuff to refresh the image preview
                var selection =  image_frame.state().get('selection');
                var gallery_ids = new Array();
                var my_index = 0;
                    selection.each(function(attachment) {
                    gallery_ids[my_index] = attachment['id'];
                    my_index++;
                });
                var ids = gallery_ids.join(",");
                    jQuery('input#gastcoin_custom_image_id').val(ids);
                    Refresh_Image(ids, '');
                });

                image_frame.on('open',function() {
                // On open, get the id from the hidden input
                // and select the appropiate images in the media manager
                var selection =  image_frame.state().get('selection');
                var ids = jQuery('input#gastcoin_custom_image_id').val().split(',');
                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
                });
            });
			image_frame.open();
		});
	});
	/**
	 * End save custom token BSC
	 */

	/**
	 * Save custom token Polygon
	 */
		//save name token
	jQuery("#gast_value_name_matic").blur(function () {
		save_gast_data("gast_value_name_matic");
	});
	//save symbol token
	jQuery("#gast_value_symbol_matic").blur(function () {
		save_gast_data("gast_value_symbol_matic");
	});
	//save address token
	jQuery("#gast_value_address_matic").blur(function () {
		save_gast_data("gast_value_address_matic");
	});
	//save decimal token
	jQuery("#gast_value_decimals_matic").blur(function () {
		save_gast_data("gast_value_decimals_matic");
	});
	//save custom_token value
	jQuery("#custom_token_matic").blur(function () {
		save_gast_data("custom_token_matic", 'check');
	});
	//custom image btn 
	jQuery(document).ready( function($) {
      jQuery('input#gastcoin_media_manager_matic').click(function(e) {
		console.log('AAAAAAAAAAAAAA');
             e.preventDefault();
             var image_frame;
             if(image_frame){
                 image_frame.open();
             }
             // Define image_frame as wp.media object
             image_frame = wp.media({
                title: 'Select Media',
                multiple : false,
                library : { type : 'image', }
            });

            image_frame.on('close',function() {
            // On close, get selections and save to the hidden input
            // plus other AJAX stuff to refresh the image preview
                var selection =  image_frame.state().get('selection');
                var gallery_ids = new Array();
                var my_index = 0;
                    selection.each(function(attachment) {
                    gallery_ids[my_index] = attachment['id'];
                    my_index++;
                });
                var ids = gallery_ids.join(",");
                    jQuery('input#gastcoin_custom_image_id_matic').val(ids);
                    Refresh_Image(ids, '_matic');
                });

                image_frame.on('open',function() {
                // On open, get the id from the hidden input
                // and select the appropiate images in the media manager
                var selection =  image_frame.state().get('selection');
                var ids = jQuery('input#gastcoin_custom_image_id_matic').val().split(',');
                ids.forEach(function(id) {
                    var attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add( attachment ? [ attachment ] : [] );
                });
            });
			image_frame.open();
		});
	});
	/**
	 * End save custom token Polygon
	 */

	//save network payment
	jQuery('#select_red_bsc').change(function(){
        //console.log(jQuery("input[name='select_red']:checked").val());
		//var network_select_bsc = jQuery("input[name='select_red_bsc']:checked").is(':checked');
		//console.log(network_select_bsc);
		save_gast_data('select_red_bsc', 'check');
    });

	//save network payment
	jQuery('#select_red_matic').change(function(){
        //console.log(jQuery("input[name='select_red']:checked").val());
		//var network_select_matic = jQuery("input[name='select_red_matic']:checked").is(':checked');
		//console.log(network_select_bsc), 'check';
		save_gast_data('select_red_matic', 'check');
    });


}

// Ajax request to refresh the image preview
function Refresh_Image(the_id, the_network){
		var action_data = 'gastcoin_get_image'+the_network;
		console.log(action_data);
        var data = {
            action: action_data,
            id: the_id
        };
		//console.log('test');
		save_gast_data("gastcoin_custom_image_id"+the_network);

        jQuery.get(ajaxurl, data, function(response) {

            if(response.success === true) {
                jQuery('#gastcoin-preview-image'+the_network).replaceWith( response.data.image );
            }
        });
}

function save_gast_data(id_value, type_input = 'text'){
	if(type_input == 'check'){
			var parametros = {
				nonce: gastcoin_utiliti.nonce,
				action: gastcoin_utiliti.action,
				"type_option": id_value,
				"data": jQuery("#"+id_value).is(":checked")
			};
			var ajaxurl = gastcoin_utiliti.gastcoin_setting;
			var dimension = jQuery.ajax({
				data: parametros,
				url: ajaxurl,
				type: "POST",
				beforeSend: function () {
				},
				success: function (response) {
					//console.log(response);
					//console.log('test');
				}
			});
	}else{
		var parametros = {
			nonce: gastcoin_utiliti.nonce,
			action: gastcoin_utiliti.action,
			"type_option": id_value,
			"data": jQuery("#"+id_value).val()
		}
		//save value convertion
		var ajaxurl = gastcoin_utiliti.gastcoin_setting;
		var dimension = jQuery.ajax({
			data: parametros,
			url: ajaxurl,
			type: "POST",
			beforeSend: function () {
			},
			success: function (response) {
				//console.log(response);
				//console.log('test');
			}
		});
	}
	
}