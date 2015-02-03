<?php
// Include the composer Autoloader
// The location of your project's vendor autoloader.
$composerAutoload = dirname(dirname(dirname(__DIR__))) . '/autoload.php';
if (!file_exists($composerAutoload)) {
    //If the project is used as its own project, it would use rest-api-sdk-php composer autoloader.
    $composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';


    if (!file_exists($composerAutoload)) {
        echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
        exit(1);
    }
}
 
require $composerAutoload;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use PayPal\Api\CreditCardToken;

//function gets access token from PayPal
function apiContext(){
	$apiContext = new ApiContext(new OAuthTokenCredential(PAYPAL_API_CLIENTID, PAYPAL_API_SECRET));
	return $apiContext;
}

//pay with credit card
function pay_direct_with_credit_card($credit_card_params, $currency, $amount_total) {		
	
	$card = new CreditCard();
	$card->setType($credit_card_params['card_type']);
	$card->setNumber($credit_card_params['card_number']);
	$card->setExpireMonth($credit_card_params['card_expiry_month']);
	$card->setExpireYear($credit_card_params['card_expiry_year']);
	$card->setCvv2($credit_card_params['card_cvv']);
	$card->setFirstName($credit_card_params['first_name']);
	$card->setLastName($credit_card_params['last_name']);
	
	$funding_instrument = new FundingInstrument();
	$funding_instrument->setCreditCard($card);

	$payer = new Payer();
	$payer->setPaymentMethod("credit_card");
	$payer->setFundingInstruments(array($funding_instrument));
	
	$amount = new Amount();
	$amount->setCurrency($currency);
	$amount->setTotal($amount_total);
	
	$transaction = new Transaction();
	$transaction->setAmount($amount);
	
	$payment = new Payment();
	$payment->setIntent("sale");
	$payment->setPayer($payer);
	$payment->setTransactions(array($transaction));

	$payment->create(apiContext());	
	
	return $payment;
}
?>