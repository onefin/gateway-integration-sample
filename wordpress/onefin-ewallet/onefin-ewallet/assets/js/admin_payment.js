jQuery(document).ready(function ($) {
    $('#megapay_payment_refund_transaction').on('click', function () {
        if (confirm(setting.confirm_message)) {
            $('body').fadeTo('fast', 0.7);
            $.ajax({
                url: setting.ajax_url,
                type: 'post',
                data: {
                    'action': 'onefin_gateway_refund_trx',
                    'trxId': $(this).attr('data-trxId'),
                    'amount': $(this).attr('data-amount'),
                    'orderId': $(this).attr('data-orderId'),
                    'payType': $(this).attr('data-payType'),
                },
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    window.location.reload();
                }
            });
        }
    });

});