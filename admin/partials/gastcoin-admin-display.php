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

    //
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

    if (!get_option('_network_payment')) {
        add_option('_network_payment', 'bsc', '', 'no');
        $gast_network_payment = 'bsc';
    } else {
        $gast_network_payment = get_option('_network_payment');
    }

    $image_id = get_option( '_gastcoin_custom_image_id' );
    
    if( intval( $image_id ) > 0 ) {
        // Change with the image size you want to use
        $image = wp_get_attachment_image( $image_id, 'medium', false, array( 'id' => 'gastcoin-preview-image' ) );
    } else {
        // Some default image
        $image = '<img id="gastcoin-preview-image" src="https://gamestorecoin.com/wp-content/plugins/gastcoin-gateway/assets/img/pay-by-busd.png" />';
    }

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
    <h2><?php echo __('Enable / disable tokens', 'gastcoin'); ?></h2>
        <label><input type="checkbox" id="cbox_gast" value="gast" <?php  if($cbox_gast != 'false' && $cbox_gast != '') echo 'checked'; ?>> Gastcoin ($GAST)</label><br>
        <label><input type="checkbox" id="cbox_busd" value="busd" <?php if($cbox_busd != 'false'  && $cbox_busd != '') echo 'checked'; ?>> Binance USD ($BUSD)</label><br>
        <label><input type="checkbox" id="cbox_usdt" value="usdt" <?php if($cbox_usdt != 'false'  && $cbox_usdt != '') echo 'checked'; ?>> Tether ($USDT)</label><br>         
    <hr>                                                                        
    <h2><?php echo __('Add custom BEP-20 token (BETA)', 'gastcoin'); ?></h2>
    <p>
        The free version has no conversion of the token value to USD.
    </p>
    <p>
        <b>Not recommended for use with other tokens and payment gateways in the free version.</b>
    </p>
    <p>
        <b>Premium version available soon... <a href="https://gastcoin.com/" target="_blank">gastcoin.com</a></b>
    </p>
    
    <div class="gast_input_active"> 
        <label><input type="checkbox" id="custom_token" value="gast" <?php if($custom_token != 'false' && $custom_token != '') echo 'checked'; ?>> Enable / disable</label><br>
    </div>
    <div class="gast_input"> 
        <label><?php esc_html_e('Type', 'gastcoin'); ?> =</label>
        <input type="text" id="gast_value_type" value="BEP-20" readonly/>
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
    
    <div>
        <hr>
        <h2><?php echo __('Payment network', 'gastcoin'); ?></h2>
        <h3><?php echo __('Select the network', 'gastcoin'); ?></h3>
        <form id="my_network_select">
            <input type="radio" id="bsc" name="select_red" value="bsc" <?php if($gast_network_payment == 'bsc'){ echo 'checked="checked"'; }?>>
            <label for="bsc">Binance Smart Chain (BSC)</label><br>
            <input type="radio" id="matic" name="select_red" value="matic" <?php if($gast_network_payment == 'matic'){ echo 'checked="checked"'; }?>>
            <label for="matic">Polygon (MATIC)</label><br>
        </form>
       
    </div>
<?php
}
?>