<?php

require_once __DIR__ . "/../../includes/init.php";
require_once __DIR__ . "/../../includes/classes/paymentlib.php";
require_once __DIR__ . "/../../vendor/braintree/braintree_php/lib/Braintree.php";

class g_braintree_api_payment extends PaymentLib {
    /*
     * payment gateyway response
     */

    public $payment_gateway_response;

    public function __construct() {
        parent::__construct();
        Braintree_Configuration::environment(BRAINTREE_ENVIRONMENT);
        Braintree_Configuration::merchantId(BRAINTREE_MERCHANTID);
        Braintree_Configuration::publicKey(BRAINTREE_PUBLICKEY);
        Braintree_Configuration::privateKey(BRAINTREE_PRIVATEKEY);
    }

    public function doBraintreePayment() {
        global $payment_gateway;

        $result = Braintree_Transaction::sale(array(
                    "amount" => $payment_gateway->credit_card_params['amount'],
                    "creditCard" => array(
                        "number" => $payment_gateway->credit_card_params['card_number'],
                        "cvv" => $payment_gateway->credit_card_params['card_cvv'],
                        "expirationMonth" => $payment_gateway->credit_card_params['card_expiry_month'],
                        "expirationYear" => $payment_gateway->credit_card_params['card_expiry_year']
                    ),
                    "options" => array(
                        "submitForSettlement" => true
                    )
        ));

        if ($result->success) {
            $this->payment_gateway_response = $result;
            $this->addOrder();
            $payment_response = array(
                'success' => true
            );
        } else if ($result->transaction) {
            $payment_response = array(
                'error' => array(
                    'title' => "Braintree Error !! ".$result->transaction->processorResponseCode,
                    'message' => $result->message
                )
            );
        } else {
            $str = '';
            foreach (($result->errors->deepAll()) as $error) {
                $str .= "- " . $error->message . "\n";
            }
            $payment_response = array(
                'error' => array(
                    'title' => "Braintree Validation errors:",
                    'message' => $str
                )
            );
        }
        return $payment_response;
    }

    private function addOrder() {
        global $payment_gateway, $db;

        $transaction_id = $this->payment_gateway_response->transaction->id;
        $transaction_currency = $this->payment_gateway_response->transaction->currencyIsoCode;
        $transaction_amount = $this->payment_gateway_response->transaction->amount;
        $transaction_method = $this->payment_gateway_response->transaction->type;
        $transaction_state = $this->payment_gateway_response->transaction->status;
        $transaction_time = isset($this->payment_gateway_response->transaction->createdAt->date) ? $this->payment_gateway_response->transaction->createdAt->date : date("y-m-d h:i:s");

        $sql_customer_name = $db->parseSqlData($payment_gateway->credit_card_params['customer_name']);
        $sql_card_holder_name = $db->parseSqlData($payment_gateway->credit_card_params['card_holder']);
        $sql_cc_number = $db->parseSqlData($payment_gateway->credit_card_params['mask_card_number']);
        $sql_cc_type = $db->parseSqlData($payment_gateway->credit_card_params['card_type']);
        $sql_cc_expiry = $db->parseSqlData($payment_gateway->credit_card_params['card_expiry']);
        $sql_cc_ccv = $db->parseSqlData($payment_gateway->credit_card_params['card_cvv']);
        $sql_currency = $db->parseSqlData($transaction_currency);
        $sql_payment_gateway = $db->parseSqlData($payment_gateway->payment_gateway);
        $sql_transaction_id = $db->parseSqlData($transaction_id);
        $sql_order_status = $db->parseSqlData($transaction_state);
        $sql_total_amount = $db->parseSqlData($transaction_amount);
        $sql_order_created_time = $db->parseSqlData($transaction_time);
        $sql_transaction_response = $db->parseSqlData($this->payment_gateway_response);


        $db->sql_query = "insert into `" . DB_TABLE . "` (customer_name,card_holder_name,card_number,card_type,card_expiry,card_cvv,payment_currency,payment_gateway,transaction_id,order_status,order_amount,order_created_time,transaction_response) values ('$sql_customer_name','$sql_card_holder_name','$sql_cc_number','$sql_cc_type','$sql_cc_expiry','$sql_cc_ccv','$sql_currency','$sql_payment_gateway','$sql_transaction_id','$sql_order_status','$sql_total_amount','$sql_order_created_time','$sql_transaction_response')";
        $db->executeQuery();
    }

}

?>