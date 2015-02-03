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
                #error_block{
                    position: static;
                    width: auto;
                }
            }
        </style>
    </head>
    <body>
        <br><br><br>

        <div class="col-sm-1"></div>			
        <div class="panel panel-default col-xs-8" id="error_block">
            <div class="row">
                <div class="col-md-12">
                    <h2>Oppps.... An Error Had Occured !!!!!</h2>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php echo $payment_response['error']['title']; ?></strong>  
                    </div>
                </div>                               

                <?php
                var_dump($payment_response['error']['message']);
                ?>
            </div>
        </div>
        <div>
            <div class="col-xs-offset-5">
                <a href = "../index.php"><button type="button" class="btn btn-default btn-sm btn-primary"> Try Again !! </button></a>
            </div>
        </div>

        <script src="<?php echo BASE_PATH; ?>/view/js/jquery.min.js"></script>
        <script src="<?php echo BASE_PATH; ?>/view/js/bootstrap.min.js"></script> 
    </body>
</html>                                		
