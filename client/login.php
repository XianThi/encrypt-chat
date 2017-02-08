<?php 
include_once("settings.php");

if (isset($_POST['username'], $_POST['password'])) {
$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
$password=hash("sha512",$_POST['password']);
 
    if ($app->login($username, $password, $link) == true) {
        // Login success 
        echo "yes";
    } else {
        // Login failed 
      echo "no";
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'no';
}
?>