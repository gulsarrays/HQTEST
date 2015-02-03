<?php
require_once __DIR__ . "/../includes/init.php";

$orders = array();

$db->sql_query = "select * from `".DB_TABLE."` order by order_id";
$data = $db->fetchAllData();
$numrows = $db->getDbNumRows();
$orders = $data;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Order List</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>    
        <style type="text/css">
            .bs-container{
                margin: 20px;
            }
            h1 {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="bs-container">
            <div class="table-responsive"> 
                <div> <h1>Order List </h1></div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Transaction ID</th>
                            <th>Date</th>
                            <th>Currency</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><a href="order_details.php?orderId=<?php echo $order['order_id']; ?>"><?php echo $order['order_id']; ?></a></td>
                                <td><?php echo $order['transaction_id']; ?></td>
                                <td><?php echo $order['order_created_time']; ?></td>
                                <td><?php echo $order['payment_currency']; ?></td>
                                <td><?php echo $order['order_amount']; ?></td>
                                <td><?php echo $order['payment_gateway']; ?></td>
                                <td><?php echo $order['order_status']; ?></td>				
                            </tr>
                        <?php } ?>


                    </tbody>
                </table>
            </div>

            <div class="col-xs-offset-5">
                <a href = "../index.php"><button type="button" class="btn btn-default btn-sm btn-primary"> Try Again !! </button></a>
            </div>

        </div>


    </body>
</html>                                		