<?php
if (!defined('ABSPATH')) exit;

/**
 * Settings Gastcoin Gateway
 */

if (
    isset($_POST['action'])
    and isset($_POST['nonce'])
    and 'gastcoin_setting' === sanitize_text_field($_POST['action'])
    and wp_verify_nonce(sanitize_text_field($_POST['nonce']), 'gastcoin_changue_setting')
) {
    global $wpdb;

    if (isset($_POST['type_option'])) {
        //save conversion value
        //echo $_POST['data'];
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_converima') {
            
            if (isset($_POST['data']) and is_numeric($_POST['data'])) {
                $price_conversion = floatval(sanitize_text_field($_POST['data']));
                $gastcoin_value_conversion = '_gastcoin_value_conversion';
                update_option($gastcoin_value_conversion, $price_conversion);
            }
        }

        //save pay url redirec
        if (sanitize_text_field($_POST['type_option']) == 'gast_url_pay') {
            if (isset($_POST['data'])) {
                $url_pay = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_url_pay';
                update_option($gastcoin_value, $url_pay);
            }
        }

        //save cbox_gast value
        if (sanitize_text_field($_POST['type_option']) == 'cbox_gast') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_cbox_gast';
                update_option($gastcoin_value, $value);
            }
        }

        //save _cbox_busd value
        if (sanitize_text_field($_POST['type_option']) == 'cbox_busd') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_cbox_busd';
                update_option($gastcoin_value, $value);
            }
        }

        //save cbox_production value
        if (sanitize_text_field($_POST['type_option']) == 'cbox_production') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_cbox_production';
                update_option($gastcoin_value, $value);
                if($value == true){
                    $value = sanitize_text_field($_POST['data']);
                    $gastcoin_value = '_cbox_testing';
                    update_option($gastcoin_value, 'false');
                }
            }
        }
        //save cbox_testing value
        if (sanitize_text_field($_POST['type_option']) == 'cbox_testing') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_cbox_testing';
                update_option($gastcoin_value, $value);
                if($value == true){
                    $value = sanitize_text_field($_POST['data']);
                    $gastcoin_value = '_cbox_production';
                    update_option($gastcoin_value, 'false');
                }
            }
        }

        //save _cbox_usdt value
        if (sanitize_text_field($_POST['type_option']) == 'cbox_usdt') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_cbox_usdt';
                update_option($gastcoin_value, $value);
            }
        }

        /**
         * Save custom token BSC
         */
        //save _custom_token value
        if (sanitize_text_field($_POST['type_option']) == 'custom_token') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_custom_token';
                update_option($gastcoin_value, $value);
            }
        }

        //save _custom_image value
        if (sanitize_text_field($_POST['type_option']) == 'gastcoin_custom_image_id') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gastcoin_custom_image_id';
                update_option($gastcoin_value, $value);
            }
        }

        //save name token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_name') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_name';
                update_option($gastcoin_value, $value);
            }
        }

        //save symbol token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_symbol') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_symbol';
                update_option($gastcoin_value, $value);
            }
        }

        //save address token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_address') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_address';
                update_option($gastcoin_value, $value);
            }
        }

        //save decimal token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_decimals') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_decimals';
                update_option($gastcoin_value, $value);
            }
        }
        /**
         * End save custom token BSC
         */

        /**
         * Save custom token Polygon
         */
        //save _custom_token_matic value
        if (sanitize_text_field($_POST['type_option']) == 'custom_token_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_custom_token_matic';
                update_option($gastcoin_value, $value);
            }
        }

        //save _custom_image_matic value
        if (sanitize_text_field($_POST['type_option']) == 'gastcoin_custom_image_id_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gastcoin_custom_image_id_matic';
                update_option($gastcoin_value, $value);
            }
        }

        //save name token_matic
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_name_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_name_matic';
                update_option($gastcoin_value, $value);
            }
        }

        //save symbol token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_symbol_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_symbol_matic';
                update_option($gastcoin_value, $value);
            }
        }

        //save address token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_address_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_address_matic';
                update_option($gastcoin_value, $value);
            }
        }

        //save decimal token
        if (sanitize_text_field($_POST['type_option']) == 'gast_value_decimals_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_gast_value_decimals_matic';
                update_option($gastcoin_value, $value);
            }
        }
         /**
          * End save custom token polygon
          */
        //save network payment
        if (sanitize_text_field($_POST['type_option']) == 'select_red_bsc') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_select_red_bsc';
                update_option($gastcoin_value, $value);
            }
        }
        if (sanitize_text_field($_POST['type_option']) == 'select_red_matic') {
            if (isset($_POST['data'])) {
                $value = sanitize_text_field($_POST['data']);
                $gastcoin_value = '_select_red_matic';
                update_option($gastcoin_value, $value);
            }
        }


    }
}
die();