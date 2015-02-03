<?php

require_once __DIR__ . "/../../includes/init.php";
require_once __DIR__ . "/../../includes/classes/paymentlib.php";
require_once __DIR__ . "/../../includes/paypal.inc.php";

class g_paypal_rest_api_payment extends PaymentLib {

    public $payment_gateway_response;

    public function __construct() {
        parent::__construct();
    }

    public function doPaypalPayment() {
        global $payment_gateway, $db;


        try {
            $result = pay_direct_with_credit_card($payment_gateway->credit_card_params, $payment_gateway->currency, $payment_gateway->credit_card_params['amount']);

            $this->payment_gateway_response = $result;

            $this->addOrder();
            $payment_response = array(
                'success' => true
            );
            //} catch (PPConnectionException $ex) {
        } catch (Exception $ex) {
            $payment_response = array(
                'error' => array(
                    'title' => "PayPal Error !!",
                    'message' => $ex->getMessage()
                )
            );           
            
        }
        return $payment_response;
    }

    private function addOrder() {
        global $payment_gateway, $db;

        $transaction_id = $this->payment_gateway_response->transactions[0]->related_resources[0]->sale->id;
        $transaction_time = $this->payment_gateway_response->transactions[0]->related_resources[0]->sale->create_time;
        $transaction_currency = $this->payment_gateway_response->transactions[0]->related_resources[0]->sale->amount->currency;
        $transaction_amount = $this->payment_gateway_response->transactions[0]->related_resources[0]->sale->amount->total;
        $transaction_method = $this->payment_gateway_response->payer->payment_method;
        $transaction_state = $this->payment_gateway_response->transactions[0]->related_resources[0]->sale->state;

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