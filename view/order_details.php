<?php
require_once __DIR__ . "/../includes/init.php";

if (isset($_GET['orderId'])) {
    $orderId = (int) $_GET['orderId'];

    $db->sql_query = "select * from `" . DB_TABLE . "` where order_id = $orderId";
    $order_details = $db->fecthData();


    //$order_details = getOrder($orderId);
} else {
    $orderId = 0;
}
/*
  try {
  $order_details = getOrder($orderId);
  } catch (Exception $ex) {
  // Don't overwrite any message that was already set
  if (!isset($message)) {
  $message = $ex->getMessage();
  $messageType = "error";
  }
  $orders = array();
  } */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hotel Quickly Test</title>
        <link rel="stylesheet" href="../view/css/bootstrap.min.css">
        <link rel="stylesheet" href="../view/css/bootstrap-theme.min.css">        
        <style type="text/css">            

            @media screen and (max-width: 400px) {
                #order_block{
                    position: static;
                    width: auto;
                }


                #testing_block{
                    position: static;
                    width: auto;
                }

            }
            form-control-static {
                padding-bottom: -10px;
            }
        </style>
    </head>
    <body>
        <br>
        <!--  Order Block Start -->
        <div class="col-sm-1"></div>			
        <div class="panel panel-default col-xs-8" id="order_block">
            <div class="row">
                <div class="col-md-12">
                    <h2>Order Details</h2>
                </div>
            </div>
            <div class="panel-body">






                <form class="form-horizontal" name = "frm" method = "post"  >
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Order Section</strong>  
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Customer name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo $order_details['customer_name']; ?>" disabled/>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Price:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo $order_details['order_amount']; ?>" disabled/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Currency:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo $order_details['payment_currency']; ?>" disabled/>
                        </div>
                    </div>                  

                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Card Holder:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo $order_details['card_holder_name']; ?>" disabled/>
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Card Type:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo ucfirst($order_details['card_type']); ?>" disabled/>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Card Number:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo $order_details['card_number']; ?>" disabled/>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Card Expiry:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo$order_details['card_expiry']; ?>" disabled/>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Card CVV:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo $order_details['card_cvv']; ?>" disabled/>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Payment Method:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value = "<?php echo ucfirst($order_details['payment_gateway']); ?>" disabled/>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="inputcustomer_name" class="col-sm-3 control-label">Gateway Response:</label>
                        <div class="col-sm-8">                            
                            <textarea class="form-control" rows="5" id="comment" disabled><?php
                                echo $order_details['transaction_response'];
                                ?></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-xs-offset-4 col-xs-10">
                            <a href = "../index.php"><button type="button" class="btn btn-primary btn-lg btn-success">Create New Order</button></a>
                        </div>

                    </div>


                </form>

            </div>
        </div>
        <!--  Order Block End -->
        <script src="../view/js/jquery.min.js"></script>
        <script src="../view/js/bootstrap.min.js"></script>        
        
    </body>
</html>