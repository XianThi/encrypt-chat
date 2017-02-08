<?php

/**
 * @author 
 * @copyright 2015
 */
include("encrypt.class.php");
use \XianThi\Crypter\SaferCrypto;
error_reporting(E_ALL);
session_start();
$crypter=new SaferCrypto();
if(empty($_SESSION["token"])){
$_SESSION["token"]=$crypter->rand_secure(9999);
$hexpass=$_SESSION["token"];
}else{
$hexpass=$_SESSION["token"];
}

if(empty($_GET["token"])){
$friend_token='';
}else{
$friend_token=$_GET["token"];
}

echo $crypter->getAction($hexpass);
?>

