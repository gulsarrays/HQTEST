<?php

require_once __DIR__ . "/../includes/init.php";
require_once __DIR__ . "/../includes/classes/paymentlib.php";
require_once __DIR__ . "/../includes/classes/braintree_class.php";
require_once __DIR__ . "/../includes/classes/paypal_class.php";


$payment_gateway = new PaymentLib();
// collect all the post data into variables
$credit_card_params = $payment_gateway->collectCreditCardParemeter();
$payment_method = $payment_gateway->myPaymentGateway($credit_card_params['type'], $credit_card_params['currency']);

if ($payment_method === 'paypal') {
    $payment_gateway_paypal = new g_paypal_rest_api_payment();
    $payment_response = $payment_gateway_paypal->doPaypalPayment();
} else if ($payment_method === 'braintree') {
    $payment_gateway_braintree = new g_braintree_api_payment();
    $payment_response = $payment_gateway_braintree->doBraintreePayment();
} else {
    $payment_response = array(
        'error' => array(
            'title' => "Please check for one of teh following Wrong Currency/Card Selection",
            'message' => "-Wrong Currency/Card Selection".
                         "AMEX is possible to use only for USD"." \n ".
                         "-Please check for order amount"." \n ".
                         "-Please check for Credit Card Expiry"
        )
    );
}

if (isset($payment_response['success']) && $payment_response['success'] === true) {
    header('location:../view/orders.php');
} else {
    include(__DIR__ . "/../view/error.php");
}
?>