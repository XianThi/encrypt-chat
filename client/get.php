<?php

/**
 * @author 
 * @copyright 2015
 */
include("settings.php");
$convquery="select *from conversion where (user1=".$_GET["id"]." and user2=".$_SESSION['user_id'].") or (user2=".$_GET["id"]." and user1=".$_SESSION['user_id'].")";
            $convresult=$link->query($convquery);
            if ($convresult->num_rows>0){
            $convfetch=$convresult->fetch_array();
            $convid=$convfetch["id"];
            $messages_query="select *from messages where conv_id=".$convid;
$messages_result=$link->query($messages_query);
if($messages_result->num_rows>0){
while ($messages_fetch=$messages_result->fetch_array()){
?>
<script type="text/javascript">
$(document).ready(function(){
$.post( "<?=ENCRYPTSERVER;?>", { d: "<?=$messages_fetch["message"];?>"}).done(function( data ) {
    $('.message').append(data);
    console.log(data);
  });
  });
</script>
<?php
}
}
}?>

<div class="message"></div>