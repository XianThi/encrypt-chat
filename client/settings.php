<?php
define("ENCRYPTSERVER","http://localhost/encrypt/server/encrypt.php");
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASSWORD","bakirkoyds");
define("DB_NAME","encrypt");
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if(!$link){
    die("Connection error.");
}

include_once("application.class.php");
$app=new XianThi\Application\Main();
$leet=new \XianThi\Application\Leetify();
$app->sec_session_start();
?>