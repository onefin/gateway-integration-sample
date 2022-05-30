function proceed_payment() {
    if ($('#returnUrl').val()) {
        location.href=$('#returnUrl').val();
    }
}