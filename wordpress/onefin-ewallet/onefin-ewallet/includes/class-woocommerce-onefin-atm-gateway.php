<?php

class WC_OneFin_Atm_Gateway extends WC_OneFin_Payment_Gateway
{
    /**
     * @var string
     */
    private $order_status;

    /**
     * WC_OneFin_Payment_Gateway constructor.
     */
    public function __construct()
    {
        $this->id = 'onefin_atm';
        $this->icon = sprintf("%s/assets/images/atm-card.svg",WC_ONEFIN_PLUGIN_URL);
        $this->method_title = __('ATM card (Napas)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
        $this->title = __('ATM card (Napas)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN);
        $this->has_fields = true;
        $this->init_form_fields();
        $this->init_settings();
        $this->enabled = $this->get_option('enabled');
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');
        $this->method_description = 'OneFin ATM chuyển hướng khách hàng tới OneFin để nhập thông tin thanh toán của họ.';
        $this->order_status = $this->get_option('order_status');
        $this->payment_submit_page = $this->get_option('payment_submit_page');
        $this->currency = $this->get_option('currency');
        $this->merCode = $this->get_option('merCode');
        $this->merEmail = $this->get_option('merEmail');
        $this->merMobile = $this->get_option('merMobile');
        $this->privateKey = $this->get_option('privateKey');
        $this->publicKey = $this->get_option('publicKey');
        $this->domain = $this->get_option('domain');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }
}
