<?php

class WC_OneFin_Payment_HANDLER
{
    private $id;

    /**
     * WC_OneFin_Payment_HANDLER constructor.
     */
    public function __construct()
    {
        add_shortcode('onefin_gateway_page', array($this, 'onefin_gateway_page_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'onefin_enqueue_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'onefin_enqueue_admin_scripts'));

        add_action('woocommerce_thankyou_onefin_atm', array($this, 'onefin_gateway_handle_transaction'));
        add_action('woocommerce_thankyou_onefin_credit', array($this, 'onefin_gateway_handle_transaction'));
        add_action('woocommerce_thankyou_onefin_ewallet', array($this, 'onefin_gateway_handle_transaction'));

        add_action('woocommerce_cancel_unpaid_orders', array($this, 'onefin_gateway_cancel_unpaid_orders'));

        add_action('add_meta_boxes', array($this, 'onefin_gateway_add_meta_boxes'));
        add_action('wp_footer', array($this, 'onefin_gateway_footer'));
    }

    /**
     * @param $key
     * @return string
     */
    public function get_option($key)
    {
        $settings = get_option('woocommerce_'.($this->id ?? 'onefin_ewallet').'_settings', null);
        if ($settings && isset($settings[$key])) {
            return $settings[$key];
        }
        return '';
    }

    /**
     * @return false|string
     */
    public function onefin_gateway_page_shortcode()
    {
        ob_start();
        $order = new WC_Order(sanitize_text_field($_GET['order']));

        $total = (int)$order->get_total();
        $order_data = $order->get_data();

        $payment_methods = [
                'onefin_atm' => 10,
                'onefin_credit' => 5,
                'onefin_ewallet' => 11,
        ];

        $this->id = $order_data['payment_method'];
        $transactionMethod = $payment_methods[$order_data['payment_method']] ?? 5;

        $messages = [
            "merchantCode" => $this->get_option('merCode'),
            "currency" => $this->get_option('currency'),
            "amount" => $total * 100,
            "trxRefNo" => (string) $order_data['id'],
            "backendURL" => $order->get_checkout_order_received_url(),
            "responsePageURL" => $order->get_checkout_order_received_url(),
            "mobileNo" => empty($order_data['billing']['phone']) ? $this->get_option('merMobile') : $order_data['billing']['phone'],
            "transactionMethod" => $transactionMethod,
            "actionMethod" => 0, // Spending with card
            "email" => empty($order_data['billing']['email']) ? $this->get_option('merEmail') : $order_data['billing']['email']
        ];

        $messages = json_encode($messages);
        $signature = $this->signMessage($messages);

        if (function_exists('write_log')) {
            write_log('onefin_gateway_page_shortcode');
            write_log($messages);
            write_log($signature);
        }
//var_dump($messages); die;
        // thực hiện kết nói với onefin để lấy link thanh toán
        $data = ['signature' => $signature, 'messages' => $messages];
        $url = $this->get_option('domain').'generatePayment';
        $result = $this->curl_post($url, $data);
        // nếu kết nói không thành công
        if (isset($result['errorDTO'])) {
            echo '<p> '.$result['errorDTO']['message'].' </p>';
            echo '<button id="pay_button" type="submit" class="button primary mt-0 pull-left small" aria-disabled="true" onclick="proceed_payment()">Thông tin đơn hàng</button>
                    <input type="hidden" id="returnUrl" value="'.$order->get_checkout_order_received_url().'">';
        } elseif (isset($result['signature'])) {
            $signature = $result['signature'];
            $messages = $result['messages'];
            $verify = $this->verifySignature($messages, $signature);
            if ($verify) {
                $messages = json_decode($messages, 1);
                $paymentURL = $messages['paymentURL'];

                echo '<p> '.__('Few seconds to redirect or click pay now!.').' </p>';
                echo '<button id="pay_button" type="submit" class="button primary mt-0 pull-left small" aria-disabled="true" 
                        onclick="proceed_payment()">'.__('Pay Now', WC_ONEFIN_PLUGIN_TEXT_DOMAIN).'</button>
                <input type="hidden" id="returnUrl" value="'.$paymentURL.'">';
                echo '<script>var $ = jQuery;$(document).ready(function(){
                    $("#pay_button").trigger("click");
                });</script>';
            }
        }
        ?>

        <?php
        return ob_get_clean();
    }

    public function curl_post($url, $data=[])
    {
        $data_string = json_encode($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$data_string,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, 1);
    }

    public function signMessage($message) {
        
        $private_key_pem = $this->get_option('privateKey');

        openssl_sign($message, $signature, $private_key_pem);

        return bin2hex($signature);
    }

    public function verifySignature($message, $signature) {
        $public_key_pem = $this->get_option('publicKey');

        $signature = hex2bin($signature);

        $verify_sign = openssl_verify($message, $signature, $public_key_pem);

        return $verify_sign;
    }

    public function onefin_gateway_handle_transaction($order_id)
    {
        $order = new WC_Order($order_id);
        $this->id = $order->payment_method;

        $messages = [
                'merchantCode' => $this->get_option('merCode'),
                'trxRefNo' => (string) $order_id
        ];
        $messages = json_encode($messages);
        $signature = $this->signMessage($messages);
        $url = $this->get_option('domain').'checkPayment';
        $data = ['signature' => $signature, 'messages' => $messages];

        $result = $this->curl_post($url, $data);

        if (function_exists('write_log')) {
            write_log('onefin_gateway_handle_transaction');
            write_log($result);
        }
//var_dump($result); die;
        if (isset($result['signature'])) {
            $signature = $result['signature'];
            $messages = $result['messages'];
            $verify = $this->verifySignature($messages, $signature);
            $messages = json_decode($messages, 1);
            if ($verify) {
                if ($messages['statusId']==100) {
                    $message = __('Payment Complete', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
                    $order->update_status($this->get_option('order_status'), $message);
                    $message = __('Transaction message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN) . ' ' . __(sanitize_text_field($message), WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
                    echo '<p class="success-color woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><strong>'.$message.'</strong></p>';
                } elseif (!empty($messages['errorMessage'])) {
                    $message = sanitize_text_field($messages['errorMessage']);
                    $order->add_order_note(__('Transaction message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN) . ' ' . __($message, WC_ONEFIN_PLUGIN_TEXT_DOMAIN));
                    echo '<p class="alert-color woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><strong>'.$message.'</strong></p>';
                }
            }
        } else {
            $message = isset($result['errorDTO']['message']) ? $result['errorDTO']['message'] : __('Payment Failed', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
            $message = __('Transaction message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN) . ' ' . __(sanitize_text_field($message), WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
            $order->add_order_note($message);
            echo '<p class="alert-color woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><strong>'.$message.'</strong></p>';
        }

        if (isset($_GET['resultCd']))
            add_post_meta($order_id, 'onefin_payment_resultCd', sanitize_text_field($_GET['resultCd']));
        if (isset($_GET['resultMsg'])) {
            $message = __('Transaction message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN) . ' ' . __(sanitize_text_field($_GET['resultMsg']), WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
            add_post_meta($order_id, 'onefin_payment_resultMsg', sanitize_text_field($_GET['resultMsg']));
            $order->add_order_note($message);
            echo $message;
        }
        if (isset($_GET['trxId']))
            add_post_meta($order_id, 'onefin_payment_trxId', sanitize_text_field($_GET['trxId']));
        if (isset($_GET['amount']))
            add_post_meta($order_id, 'onefin_payment_amount', sanitize_text_field($_GET['amount']));
        if (isset($_GET['bankId']))
            add_post_meta($order_id, 'onefin_payment_bankId', sanitize_text_field($_GET['bankId']));
        if (isset($_GET['payType']))
            add_post_meta($order_id, 'onefin_payment_payType', sanitize_text_field($_GET['payType']));
    }

    /**
     * Cancel all unpaid orders after held duration to prevent stock lock for those products.
     */
    public function onefin_gateway_cancel_unpaid_orders() {
        write_log('onefin_gateway_cancel_unpaid_orders');

        $held_duration = get_option( 'woocommerce_hold_stock_minutes' );

        if ( $held_duration < 1 || 'yes' !== get_option( 'woocommerce_manage_stock' ) ) {
            return;
        }

        $data_store    = WC_Data_Store::load( 'order' );
        $unpaid_orders = $data_store->get_unpaid_orders( strtotime( '-' . absint( $held_duration ) . ' MINUTES', current_time( 'timestamp' ) ) );

        if ( $unpaid_orders ) {
            foreach ( $unpaid_orders as $unpaid_order ) {
                $order = wc_get_order( $unpaid_order );

                $flag = 1;

                $payment_method = $order->payment_method;
                if (in_array($payment_method, ['onefin_atm', 'onefin_credit', 'onefin_ewallet'])) {
                    $this->id = $payment_method;

                    $messages = [
                        'merchantCode' => $this->get_option('merCode'),
                        'trxRefNo' => (string) $order->get_id()
                    ];
                    $messages = json_encode($messages);
                    $signature = $this->signMessage($messages);
                    $url = $this->get_option('domain').'checkPayment';
                    $data = ['signature' => $signature, 'messages' => $messages];

                    $result = $this->curl_post($url, $data);

                    if (function_exists('write_log')) {
                        write_log($data);
                        write_log($result);
                    }

                    if (isset($result['signature'])) {
                        $signature = $result['signature'];
                        $messages = $result['messages'];
                        $verify = $this->verifySignature($messages, $signature);
                        $messages = json_decode($messages, 1);
                        if ($verify) {
                            if ($messages['statusId']==100) {
                                $flag = 0;
                                $message = __('Payment Complete', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
                                $order->update_status($this->get_option('order_status'), $message);

                            } elseif (!empty($messages['errorMessage'])) {
                                $message = sanitize_text_field($messages['errorMessage']);
                                $order->add_order_note(__('Transaction message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN) . ' ' . __($message, WC_ONEFIN_PLUGIN_TEXT_DOMAIN));
                            }
                        }
                    } else {
                        $message = isset($result['errorDTO']['message']) ? $result['errorDTO']['message'] : __('Payment Failed', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
                        $message = __('Transaction message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN) . ' ' . __(sanitize_text_field($message), WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
                        $order->add_order_note($message);
                    }
                }

                if ($flag) {
                    if ( apply_filters( 'woocommerce_cancel_unpaid_order', 'checkout' === $order->get_created_via(), $order ) ) {
                        $order->update_status( 'cancelled', __( 'Unpaid order cancelled - time limit reached.', 'woocommerce' ) );
                    }
                }
            }
        }
        wp_clear_scheduled_hook( 'woocommerce_cancel_unpaid_orders' );
        $cancel_unpaid_interval = apply_filters( 'woocommerce_cancel_unpaid_orders_interval_minutes', absint( $held_duration ) );
        wp_schedule_single_event( time() + ( absint( $cancel_unpaid_interval ) * 60 ), 'woocommerce_cancel_unpaid_orders' );
    }
    /**
     * onefin_gateway_footer
     */
    public function onefin_gateway_footer()
    {
        if (is_page($this->get_option('payment_submit_page'))) {
            echo '<script> var $ = jQuery;</script>';
        }
    }

    /**
     * onefin_enqueue_scripts
     */
    public function onefin_enqueue_scripts()
    {
            wp_enqueue_script('onefin_payment_script', WC_ONEFIN_PLUGIN_URL . '/assets/js/payment.js', ['jquery'], '1.1', true);
    }

    /**
     * onefin_gateway_add_meta_boxes
     */
    public function onefin_gateway_add_meta_boxes()
    {
        add_meta_box('onefin_gateway_transaction', __('OneFin Payment Transaction', WC_ONEFIN_PLUGIN_TEXT_DOMAIN), array($this, 'onefin_gateway_transaction_data'), 'shop_order', 'side', 'core');
    }

    /**
     * onefin_gateway_transaction_data
     */
    public function onefin_gateway_transaction_data()
    {
        global $post;
        ?>
        <div class="woocommerce-gateway-onefin">
            <?php
            $is_cancelled = get_post_meta($post->ID, 'onefin_payment_is_cancelled', true);
            if ($is_cancelled && $is_cancelled == 1) {
                echo __('Transaction Refunded!', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
            } else {
                ?>
                <ul>
                    <?php
                    $resultMsg = get_post_meta($post->ID, 'onefin_payment_resultMsg', true);
                    if ($resultMsg) {
                        ?>
                        <li>
                            <b><?php echo __('Transaction Message:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?></b> <?php echo __($resultMsg, WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?>
                        </li>
                        <?php
                    }
                    $trxId = get_post_meta($post->ID, 'onefin_payment_trxId', true);
                    if ($trxId) {
                        ?>
                        <li>
                            <b><?php echo __('Transaction Id:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?></b> <?php echo __($trxId, WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?>
                        </li>
                        <?php
                    }
                    $amount = get_post_meta($post->ID, 'onefin_payment_amount', true);
                    if ($amount) {
                        ?>
                        <li>
                            <b><?php echo __('Transaction Amount:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?></b> <?php echo __($amount, WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?>
                        </li>
                        <?php
                    }
                    $bankId = get_post_meta($post->ID, 'onefin_payment_bankId', true);
                    if ($amount) {
                        ?>
                        <li>
                            <b><?php echo __('Transaction Bank:', WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?></b> <?php echo __($bankId, WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                $payType = get_post_meta($post->ID, 'onefin_payment_payType', true);
                if ($payType && $amount && $trxId) {
                    ?>
                    <button type="button" id="onefin_payment_refund_transaction" class="button" style="color: #a00;"
                            data-payType="<?php echo $payType; ?>"
                            data-orderId="<?php echo $post->ID; ?>"
                            data-amount="<?php echo $amount; ?>"
                            data-trxId="<?php echo $trxId; ?>"><?php echo __('Refund', WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?></button>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }

    /**
     * @param $hook
     */
    public function onefin_enqueue_admin_scripts($hook)
    {
        if ('post.php' != $hook) {
            return;
        }
        wp_enqueue_script('onefin_payment_admin_script', WC_ONEFIN_PLUGIN_URL . '/assets/js/admin_payment.js');
        wp_localize_script('onefin_payment_admin_script', "setting", [
            'confirm_message' => __('Are you sure want to refund this transaction?', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    /**
     * @param $dataRequest
     * @param $url
     * @return bool|Exception|int|string
     */
    private function send_request($dataRequest, $url) {
        $args = array(
            'body' => $dataRequest,
            'timeout' => '180',
        );
        $response = wp_remote_post($url, $args);
        $body = wp_remote_retrieve_body($response);
        return $body;
    }

}

new WC_OneFin_Payment_HANDLER();