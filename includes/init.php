<?php
// set the level of error reporting
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
ini_set("display_errors", 1);

require_once __DIR__.'/../includes/config.php';
require_once __DIR__."/../includes/classes/db.php";

$db = new DBClass(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>