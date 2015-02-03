<?php
// set the level of error reporting
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
ini_set("display_errors", 1);

require_once __DIR__.'/../includes/config.php';
require_once __DIR__."/../includes/classes/db.php";

$db = new DBClass(DB_HOST, DB_USER, DB_PASS, DB_NAME);


if (!file_exists($composerAutoload)) {
    //If the project is used as its own project, it would use rest-api-sdk-php composer autoloader.
    $composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';


    if (!file_exists($composerAutoload)) {
        echo "The 'vendor' folder is missing. You must run 'composer update' to resolve application dependencies.\nPlease see the README for more information.\n";
        exit(1);
    }
}

?>