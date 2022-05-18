<?php

class WC_OneFin_Payment_Gateway extends WC_Payment_Gateway
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

    }

    /**
     * init_form_fields
     */
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable/Disable', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'checkbox',
                'label' => __('Enable OneFin Payment', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'default' => 'yes'
            ),
            'title' => array(
                'title' => __('Method Title', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'text',
                'description' => __('This controls the title', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'default' => __('OneFin Payment', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'desc_tip' => true,
            ),
            'description' => array(
                'title' => __('Description', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'textarea',
                'description' => __('This controls the description which the user sees during checkout.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'default' => __('OneFin E-wallet chuyển hướng khách hàng tới OneFin để nhập thông tin thanh toán.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'desc_tip' => true,
            ),
            'order_status' => array(
                'title' => __('Order Status After The Checkout', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'select',
                'options' => wc_get_order_statuses(),
                'default' => 'wc-processing',
                'description' => __('The default order status if this gateway used in payment.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'payment_submit_page' => array(
                'title' => __('Payment page', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'select',
                'default' => 368,
                'options' => $this->get_pages_list(),
                'description' => __('Page which proceed payment steps.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'currency' => array(
                'title' => __('Payment Currency', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'text',
                'default' => 'VND',
                'desc_tip' => true,
                'description' => __('The default payment currency.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'merCode' => array(
                'title' => __('Merchant CODE (merCode)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'text',
                'default' => '00003',
                'desc_tip' => true,
                'description' => __('Merchant CODE.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'merEmail' => array(
                'title' => __('Merchant Email (merEmail)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'text',
                'default' => 'thanhnguyen@onefin.vn',
                'desc_tip' => true,
                'description' => __('Merchant Email.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'merMobile' => array(
                'title' => __('Merchant Mobile (merMobile)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'text',
                'default' => '84933597587',
                'desc_tip' => true,
                'description' => __('Merchant Mobile.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'privateKey' => array(
                'title' => __('Checksum key (privateKey)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'textarea',
                'default' => '-----BEGIN PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCrbPwqS5Kb+NXS
tXvqQjozqejBvxXmjUbtAkH8C7KnGrrbZPtgfrg5QiTeVDE+19rPjHuHQnm6iOkn
2mG7wBrycC9UTO8CAqR3ZcAcz76Kg3xfnXKeARsQLG8vguvk11w4zD4eiuKdH58q
gfW3u5Ov8dZVl/kZOs2t+BX24HcMN7JXP5bQPmF0/mJPDPifD2mFSVIC8Hq1UuWj
X/FkvbQiKJJvJasaHKND25Zp6sfgyAT5d0/lUcuTwCS+BqN86lWnE4ajSjY10gR/
ZAnv5lksxWkwxc7hiG1QDIUbiJEqHQEsh/oAZfFUlkLLzlIsat/yWBlWtG3AbGo2
xBK4/DDfAgMBAAECggEAYYrbFYn4+00lBgeEYfCbQ4h7y7raUFy1Lelp+GwDlPgt
uOcF7otMcjBD4EpR1ytl81FBfN6De3OqD6ZAlF+kNa1GERbRrPgp81JvdTV0e0aD
/7gMXwHMD3DpN0Ssy4MLk7oL4r8uYS98FujqE0jlqWjXh864y/Vc0Y/nl5lzw/wC
0yKHTXdyQtwo/SngKWVVz8wCp17ziNT1Ulv5lWVy8tKVi6GaAIylMvOrY+ZpaNlO
nnJa79hRU8G3MEm9xbxdi0OUO7p6seU6lkR8LAk+/Blu9yGhCl5IP0h1HfpW2lmI
LgaH9SI1tRovPz93BMkLA1RlltOiFB6JAB460ja34QKBgQDSy1cCxg1me0jq1tb6
KR/rqbi0hqtZ00eKPC23TTEu3/7xsLHnl5zrEJnPr39Jc6pJKUlud/73EnVf37sK
oDBbXt95bvReULdqvQ3GpKgZyUrotj5k7CzdO2LZ/W3wZMxGMv4880TUPRbwDI5A
OliYkxWk40m1tP9tQLrF3zcLjwKBgQDQMEztQaXfEUCue53pu82nKbyvVqcnRNPI
zqmPcqx5cuun2sMcbhzMM1VWxyYZ3fM1he9p+dcKYWd4vj5R5y5Jx8tEzuhypDzc
M4vFnvjIAVBmGYYBYpAOAAymrEmJhzuxThvrnIzd21c6ytjcZ4CewpQbXPePd75C
3LXEp4IdsQKBgFseLIF1bQt0lUN2FL1UE4lB9yaJ4/3TF2SIuNY4Vt9FUiXVVEGg
xuLRbTtaSDJO/jfb0fMfiaXxY61Kv8ZLEjwc2YrbTGSMjYxlJlRMjqF+4pOPW48y
i/4hkoxaQTCd0bMyjbV5DrKTqZugQck/r1ZclgmNeipCj/sA9PtdjqS/AoGACnXy
15UN3ZiDVIEXnS/3lGeveGv1OC7oKVXhBTkw22Vf2+5NEXei8Mu/hP26t2AEoXLa
ZcvM91OPnGyKuxjPpZtpZkqzOVdxS2s3obVsMLiILqknp5gpPtrXx+QuSb/GyxDu
rDcQiPFFf8nDfcehmdiTEpDoS4grwjZO19PG4PECgYEAwIvLYi1fEToKJR92hEzm
pM5ZnWTLpzmAXfLkn7GMdmNiWPl5fmF7+5VCR/7+yPsfHre/TqIb8QvANZW/TRd3
8IiUQXMybHKjrZyD133O3EYULsu2cqbM+dX0Q9wdGg+SkFTu3LgMclAB/I2/EhVO
3iyLoIdG/+uT5omIX8dC8so=
-----END PRIVATE KEY-----',
                'desc_tip' => true,
                'description' => __('Checksum key (privateKey).', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'publicKey' => array(
                'title' => __('Checksum key (publicKey)', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'textarea',
                'default' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu28r6d/DGto4IDRfIge3
z3oUTcq/Xmwo6OhgTNx6kQALxo/cQdQpC9rxq6/gqtKuA+ShDyUz1RECSfUZ8aYb
KOI1BCmmGvCGNb1OMk9jAkEmELxif6mRpN9jC+gW425lUU4QZavB8w2bFeWMTT7G
sUt+rtpP5Sfv4/6YLNHGhpKeOUUp4Anc1Lr/icPpEwLfpXCAE+k9zxk/ZmGnV/zD
u9OE1IYCNukHnvk6N4ZZwoJDf2zG74llA465g41OGpp7u63MhPJ1tEbh+f0a9Nhz
We7Hi+c7K/yJEjpGKVxmjCqvsfGF6Hd1/4CG4Gw03P06cWDmnulieGyB+RYY5I62
owIDAQAB
-----END PUBLIC KEY-----',
                'desc_tip' => true,
                'description' => __('Checksum key (publicKey).', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
            'domain' => array(
                'title' => __('Domain', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
                'type' => 'text',
                'default' => 'https://sit-pgw.onefin.vn/public/mweb/generatePayment/',
                'desc_tip' => true,
                'description' => __('Domain.', WC_ONEFIN_PLUGIN_TEXT_DOMAIN),
            ),
        );
    }

    /**
     * @return array
     */
    public function get_pages_list()
    {
        $pages_array = array(__('Choose A Page', WC_ONEFIN_PLUGIN_TEXT_DOMAIN));
        $get_pages = get_pages('hide_empty=0');
        foreach ($get_pages as $page) {
            $pages_array[$page->ID] = esc_attr($page->post_title);
        }
        return $pages_array;
    }

    /**
     * Admin Panel Options
     * - Options for bits like 'title' and availability on a country-by-country basis
     *
     * @return void
     */
    public function admin_options()
    {
        ?>
        <h3><?php _e('OneFin Payment Settings', WC_ONEFIN_PLUGIN_TEXT_DOMAIN); ?></h3>
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content">
                    <table class="form-table">
                        <?php $this->generate_settings_html(); ?>
                    </table><!--/.form-table-->
                </div>

            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

    /**
     * @param int $order_id
     * @return array
     */
    public function process_payment($order_id)
    {
        global $woocommerce;
        $order = new WC_Order($order_id);
        wc_reduce_stock_levels($order_id);
        $woocommerce->cart->empty_cart();
        $returnUrl = $this->get_return_url($order);
        if ($this->payment_submit_page) {
            $returnUrl = get_permalink($this->payment_submit_page) . '?order=' . $order_id;
        }
        return array(
            'result' => 'success',
            'redirect' => $returnUrl
        );
    }
}
