<?php

/**
 * Plugin Name:       OneFin E-wallet
 * Plugin URI:        https://onefin.vn
 * Description:       Thanh toán bằng thẻ tín dụng tại cửa hàng của bạn sử dụng OneFin E-wallet
 * Version:           1.1
 * Author:            Thomas.Tính
 * Author URI:        https://onefin.vn
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       onefin-ewallet
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0
 * Rename this for your plugin and update it as you release new versions.
 */
define('WC_ONEFIN_VERSION', '1.1');
define('WC_ONEFIN_PLUGIN_URL', untrailingslashit(plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__))));
define('WC_ONEFIN_PLUGIN_PATH', untrailingslashit(plugin_dir_path(__FILE__)));
define('WC_ONEFIN_PLUGIN_TEXT_DOMAIN', 'payments-with-oneFin-for-wooCommerce');

/**
 * WooCommerce fallback notice.
 * @return string
 */
function wc_onefin_missing_woocommerce_notice()
{
    $class = 'notice notice-error';
    $message = __( 'Plugin Thanh Toán OneFin E-wallet cần WooCommerce kích hoạt trước khi sử dụng. 
    Vui lòng kiểm tra Woocommerce', 'qr_auto' );
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
add_action('plugins_loaded', 'woocommerce_gateway_onefin_init');

/**
 * woocommerce_gateway_onefin_init
 */
function woocommerce_gateway_onefin_init()
{
    // Make sure WooCommerce is active
    if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        add_action('admin_notices', 'wc_onefin_missing_woocommerce_notice');
        return;
    }

    require 'includes/class-woocommerce-onefin-payment-gateway.php';
    require 'includes/class-woocommerce-onefin-ewallet-gateway.php';
    require 'includes/class-woocommerce-onefin-atm-gateway.php';
    require 'includes/class-woocommerce-onefin-credit-gateway.php';
}
add_filter('woocommerce_payment_gateways', 'add_onefin_payment_gateway');

/**
 * @param $gateways
 * @return array
 */
function add_onefin_payment_gateway($gateways)
{
    $gateways[] = 'WC_OneFin_EWallet_Gateway';
    $gateways[] = 'WC_OneFin_Atm_Gateway';
    $gateways[] = 'WC_OneFin_Credit_Gateway';
    return $gateways;
}
require 'includes/class-woocommerce-onefin-payment-handler.php';
