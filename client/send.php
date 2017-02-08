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
            $messageresult=$link->query("select *from messages where conv_id=".$convid);
            while($messages=$messageresult->fetch_array()){
            echo $messages["message"];
            }
            }else{
            $convinsert="insert into conversion(user1,user2)values(".$_SESSION['user_id'].",".$_GET["id"].")";
            $link->query($convinsert);
                }
?>
 <script>
 $(document).keydown(function (e) {
                var element = e.target.nodeName.toLowerCase();
                if ((element != 'input' && element != 'textarea') || $(e.target).attr("readonly") || (e.target.getAttribute("type") ==="checkbox")) {
                    if (e.keyCode === 8) {
                    var result=$("#result").html();
                    result=result.replace(/\r?\n?[^\r\n]*$/, "");
                    result=result.substring(0,result.lastIndexOf("\n"));
                    result=result+"\n";
                    $("#result").html(result);
                        return false;
                    }
                }
 if(e.keyCode==13){
 var message=$("#result").html();
 var posta = $.post( '<?=ENCRYPTSERVER;?>', { e: message,convid:<?=$convid;?>, sender:<?=$_SESSION["user_id"];?>,receiver:<?=$_GET["id"];?> } );
 posta.done(function(encryptdata){
 $("#result").html(encryptdata);
 });
 }
});

 $(document).keypress(function(event) {
 //var posting = $.post( 'encrypt.php', { s: String.fromCharCode(event.charCode) } );
  var posting = $.post( '<?=ENCRYPTSERVER;?>', { s: event.charCode } );
    // Put the results in a div
  posting.done(function( data ) {
    $( "#result" ).append(data);
  });
});
</script>
<div id="result" style="display: none;"></div>