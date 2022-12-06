<?php
if (!defined('ABSPATH')) exit;


function gastcoin_backend_dashboard()
{
    $gast_value_conver = 1;
    if (!get_option('_gastcoin_value_conversion')) {
        add_option('_gastcoin_value_conversion', '1', '', 'no');
    } else {
        $gast_value_conver = get_option('_gastcoin_value_conversion');
    }

    if (get_option('_gast_url_pay')) {
        $gast_url_pay = get_option('_gast_url_pay');
    } else {
        $gast_url_pay = '';
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

    //custom BSC
    if (!get_option('_custom_token')) {
        add_option('_custom_token', 'false', '', 'no');
        $custom_token = 'false';
    } else {
        $custom_token = get_option('_custom_token');
    }

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
        $gast_value_address = get_option('_gast_value_address');
    }

    if (!get_option('_gast_value_decimals')) {
        add_option('_gast_value_decimals', '', '', 'no');
        $gast_value_decimals = '';
    } else {
        $gast_value_decimals = get_option('_gast_value_decimals');
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

    $image_id = get_option( '_gastcoin_custom_image_id' );
    
    if( intval( $image_id ) > 0 ) {
        // Change with the image size you want to use
        $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'gastcoin-preview-image' ) );
    } else {
        // Some default image
        $image = '<img id="gastcoin-preview-image" src="https://gamestorecoin.com/wp-content/plugins/gastcoin-gateway/assets/img/pay-by-busd.png" />';
    }
    //end custom bsc

    //custom polygon
    if (!get_option('_custom_token_matic')) {
        add_option('_custom_token_matic', 'false', '', 'no');
        $custom_token_matic = 'false';
    } else {
        $custom_token_matic = get_option('_custom_token_matic');
    }

    if (!get_option('_gast_value_name_matic')) {
        add_option('_gast_value_name_matic', '', '', 'no');
        $gast_value_name_matic = '';
    } else {
        $gast_value_name_matic = get_option('_gast_value_name_matic');
    }

    if (!get_option('_gast_value_symbol_matic')) {
        add_option('_gast_value_symbol_matic', '', '', 'no');
        $gast_value_symbol_matic = '';
    } else {
        $gast_value_symbol_matic = get_option('_gast_value_symbol_matic');
    }

    if (!get_option('_gast_value_address_matic')) {
        add_option('_gast_value_address_matic', '', '', 'no');
        $gast_value_address_matic = '';
    } else {
        $gast_value_address_matic = get_option('_gast_value_address_matic');
    }

    if (!get_option('_gast_value_decimals_matic')) {
        add_option('_gast_value_decimals_matic', '', '', 'no');
        $gast_value_decimals_matic = '';
    } else {
        $gast_value_decimals_matic = get_option('_gast_value_decimals_matic');
    }


    $image_id_matic = get_option( '_gastcoin_custom_image_id_matic' );
    
    if( intval( $image_id_matic ) > 0 ) {
        // Change with the image size you want to use
        $image_matic = wp_get_attachment_image( $image_id_matic, 'medium', false, array( 'id' => 'gastcoin-preview-image_matic' ) );
    } else {
        // Some default image
        $image_matic = '<img id="gastcoin-preview-image_matic" src="https://gamestorecoin.com/wp-content/plugins/gastcoin-gateway/assets/img/pay-by-busd.png" />';
    }
    //end custom polygon

?>
    <h1><?php echo __('Gastcoin Gateway setting', 'gastcoin'); ?></h1>
    <table class="form-table" role="presentation">

        <tbody>

            <tr>
                <th scope="row"><label for="gast_value_converima"><?php esc_html_e('Conversion USD 1', 'gastcoin'); ?> =</label></th>
                <td style="width: 400px;"><input type="number" id="gast_value_converima" value="<?php
                                                                                                if ($gast_value_conver != 'null' && $gast_value_conver != '') {
                                                                                                    echo esc_attr($gast_value_conver);
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                }
                                                                                                ?>" />
                    <p class="description" id="tagline-description"><?php esc_html_e('If the currency used is the dollar, leave this field unchanged.', 'gastcoin'); ?></p>
                </td>

                <td>
                    <div><a href="https://gastcoin.com/how-to-configure-gastcoin-gateway/#how-configure" target="_blank"><?php esc_html_e('How do I configure it? View tutorial', 'gastcoin'); ?></a></div>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="gast_url_pay"><?php esc_html_e('Redirect URL for payment', 'gastcoin'); ?></label></th>
                <td><input type="text" id="gast_url_pay" placeholder="pay-to-crypto-asset" value="<?php
                                                                                                    echo esc_attr($gast_url_pay);
                                                                                                    ?>" />
                    <p class="description" id="tagline-description-pay"><?php esc_html_e('Use this shortcode to create a custom payment page [gastcoin_gateway]. Once the page is created add in this field the permanent link of the page created with the shortcode.
                        Example: pay-to-crypto-asset', 'gastcoin'); ?>
                    </p>
                </td>
                <td>
                    <div><a href="https://gastcoin.com/how-to-configure-gastcoin-gateway/#redirect-url" target="_blank"><?php esc_html_e('How do I configure it? View tutorial', 'gastcoin'); ?></a></div>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="gast_url_pay"><?php esc_html_e('Next step: Active in WooCommerce', 'gastcoin'); ?></label></th>
                <td>
                    <p class="description" id="tagline-description-step"><?php esc_html_e('Go to WooCommerce > Setting > Payments', 'gastcoin'); ?>
                    </p>
                </td>
                <td>
                    <div><a href="https://gastcoin.com/how-to-configure-gastcoin-gateway/#active" target="_blank"><?php esc_html_e('How do I configure it? View tutorial', 'gastcoin'); ?></a></div>
                </td>
            </tr>

        </tbody>
    </table>
    <hr>
    <h2><?php echo __('Production / Testing', 'gastcoin'); ?></h2>
    <hr>
        <input type="radio" id="cbox_production" name="testing-production" value="CSS" <?php if($cbox_production != 'false' && $cbox_production != '') echo 'checked'; ?>>
        <label for="production">Production</label><br>
        <input type="radio" id="cbox_testing" name="testing-production" value="JavaScript" <?php if($cbox_testing != 'false' && $cbox_testing != '') echo 'checked'; ?>>
        <label for="testing">Testing</label>

    <h2><?php echo __('Enable / disable tokens', 'gastcoin'); ?></h2>
        <label><input type="checkbox" id="cbox_gast" value="gast" <?php if($cbox_gast != 'false' && $cbox_gast != '') echo 'checked'; ?>> Gastcoin ($GAST)</label><br>
        <label><input type="checkbox" id="cbox_busd" value="busd" <?php if($cbox_busd != 'false'  && $cbox_busd != '') echo 'checked'; ?>> Binance USD ($BUSD)</label><br>
        <label><input type="checkbox" id="cbox_usdt" value="usdt" <?php if($cbox_usdt != 'false'  && $cbox_usdt != '') echo 'checked'; ?>> Tether ($USDT)</label><br>         
    <hr>                                                                        
    <h2><?php echo __('Add custom BEP-20 and ERC-20 token (BETA)', 'gastcoin'); ?></h2>
    <p>
        The free version has no conversion of the token value to USD.
    </p>
    <p>
        <b>Not recommended for use with other tokens and payment gateways in the free version.</b>
    </p>
    <p>
        <b>Premium version available soon... <a href="https://gastcoin.com/" target="_blank">gastcoin.com</a></b>
    </p>
    <div class="custom-tokens" >
        <div class="custom-bsc">
            <div class="gast_input_active"> 
                <label><input type="checkbox" id="custom_token" value="gast" <?php if($custom_token != 'false' && $custom_token != '') echo 'checked'; ?>> Enable / disable</label><br>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Type', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_type" value="BEP-20 (BSC)" readonly/>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Name', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_name" value="<?php if ($gast_value_name != '') { echo esc_attr($gast_value_name); }?>" placeholder="Gastcoin"/>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Symbol', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_symbol" value="<?php if ($gast_value_symbol != '') { echo esc_attr($gast_value_symbol); } ?>" placeholder="GAST"/>
            </div>
            <div class="gast_input input_address"> 
                <label><?php esc_html_e('Address', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_address" value="<?php if ($gast_value_address != '') { echo esc_attr($gast_value_address); }?>" placeholder="0x8477ED2eE590FDAF9D63E8Ed1d3d6770167fcDB5"/>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Decimals', 'gastcoin'); ?> =</label>
                <input type="number" id="gast_value_decimals" value="<?php if ($gast_value_decimals != '') { echo esc_attr($gast_value_decimals); } ?>" placeholder="9"/>
            </div>
            <div class="gast_input">
                <?php echo $image;?>
                <input type="hidden" name="gastcoin_custom_image_id" id="gastcoin_custom_image_id" value="<?php echo esc_attr( $image_id ); ?>" class="regular-text" />
            </div>
            <div class="gast_input">
                <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select a image button', 'gastcoin' ); ?>" id="gastcoin_media_manager"/>
            </div>
        </div>
        <div class="custom-matic">
            <div class="gast_input_active"> 
                <label><input type="checkbox" id="custom_token_matic" value="gast_matic" <?php if($custom_token_matic != 'false' && $custom_token_matic != '') echo 'checked'; ?>> Enable / disable</label><br>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Type', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_type_matic" value="ERC-20 (Polygon)" readonly/>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Name', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_name_matic" value="<?php if ($gast_value_name_matic != '') { echo esc_attr($gast_value_name_matic); }?>" placeholder="Gastcoin"/>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Symbol', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_symbol_matic" value="<?php if ($gast_value_symbol_matic != '') { echo esc_attr($gast_value_symbol_matic); } ?>" placeholder="GAST"/>
            </div>
            <div class="gast_input input_address"> 
                <label><?php esc_html_e('Address', 'gastcoin'); ?> =</label>
                <input type="text" id="gast_value_address_matic" value="<?php if ($gast_value_address_matic != '') { echo esc_attr($gast_value_address_matic); }?>" placeholder="0x8477ED2eE590FDAF9D63E8Ed1d3d6770167fcDB5"/>
            </div>
            <div class="gast_input"> 
                <label><?php esc_html_e('Decimals', 'gastcoin'); ?> =</label>
                <input type="number" id="gast_value_decimals_matic" value="<?php if ($gast_value_decimals_matic != '') { echo esc_attr($gast_value_decimals_matic); } ?>" placeholder="9"/>
            </div>
            <div class="gast_input">
                <?php echo $image_matic;?>
                <input type="hidden" name="gastcoin_custom_image_id_matic" id="gastcoin_custom_image_id_matic" value="<?php echo esc_attr( $image_id_matic ); ?>" class="regular-text" />
            </div>
            <div class="gast_input">
                <input type='button' class="button-primary" value="<?php esc_attr_e( 'Select a image button', 'gastcoin' ); ?>" id="gastcoin_media_manager_matic"/>
            </div>
        </div>
    </div>
    <div>
        <hr>
        <h2><?php echo __('Payment network', 'gastcoin'); ?></h2>
        <h3><?php echo __('Select the network', 'gastcoin'); ?></h3>
        <form id="my_network_select">
            <input type="checkbox" id="select_red_bsc" name="select_red_bsc" value="bsc" <?php if($gast_network_payment_bsc == 'true'){ echo 'checked="checked"'; }?>>
            <label for="bsc">Binance Smart Chain (BSC)</label><br>
            <input type="checkbox" id="select_red_matic" name="select_red_matic" value="matic" <?php if($gast_network_payment_matic == 'true'){ echo 'checked="checked"'; }?>>
            <label for="matic">Polygon (MATIC)</label><br>
        </form>
       
    </div>
<?php
}
?>