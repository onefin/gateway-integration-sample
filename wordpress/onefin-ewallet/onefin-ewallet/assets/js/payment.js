jQuery(document).ready(function ($) {
    setTimeout(function () {
        proceed_payment();
    },2000);

});

function proceed_payment() {
    if ($('#returnUrl').val()) {
        location.href=$('#returnUrl').val();
    }
}