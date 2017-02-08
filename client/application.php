<?php
include_once("settings.php");
if($app->login_check($link)==true){?>
<script type="text/javascript">var myname = <?php echo json_encode($_SESSION["username"]); ?>;
myid=<?php echo json_encode($_SESSION["user_id"]);?>;</script>
<?php 
}else{
die('<div class="alert alert-danger alert-dismissable">
Bu alana giriş izniniz yok.</div>');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$leet->encode("Encrypt Application - "). $_SESSION['username'];?></title>
 <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/sidebar.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/timer.js"></script>
    <script src="js/application.js"></script>
    

    <style>
    .tab-pane iframe{
    width:100%;
    }
    .nav-tabs > li .close {
			    margin: -2px 0 0 10px;
			    font-size: 18px;
			}
			.marginBottom {
			    margin-bottom :1px !important;
			}
    </style>
       </head>
<body>

 <div id="wrapper">

<div id="status"></div>
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        <?=$leet->encode("Friend List");?>
                    </a>
                </li>
            <?php 
            $query="select *from friends where user_id=".$_SESSION['user_id'];
            $result=$link->query($query);
            if ($result->num_rows>0){
            while($row=$result->fetch_array()){
            $friend_query="select *from users where id=".$row["friend_id"];
            $friend_result=$link->query($friend_query);
            $friend_info=$friend_result->fetch_array();
            ?>
            <li>
                    <a id="<?=$row["friend_id"];?>" title="<?=$row["friend_token"]; ?>" onclick="createconversion(this)" href="#<?=$friend_info['username'];?>"><?=$friend_info['username'];?></a>
                </li>
            <?php
            }
            }else{
            echo $leet->encode("Hiç arkadaşınız yok.");
            }
             ?>

            </ul>
            
        </div>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                     <div class="container-fluid">
                         <div class="navbar-header">
      <a class="navbar-brand" href="#"><?=$leet->encode("Chat With");?> </a>
    </div>
                      <ul class="nav nav-tabs marginBottom" id="myTab">
                    

    </ul><?=$leet->encode("Sadece yazın ve enterlayın..");?>
    </div>
 <div class="tab-content span4" style="height: 400px;">
 </div>
<div id="messages"></div>
<div id="timer"></div>
<!--
<form class="form-inline" id="messageForm" action="#">
				<input id="messageInput" type="text" class="input-xxlarge" placeHolder="Message" />
				<select id="messageRecepient"></select>
			
				<input type="submit" value="Send" />
			</form>
			
			<div>
				<label id="myName"></label>
				<label><b>Connected Users</b></label>
				<ol id="all_users">
					
				</ol>
				<div><i id="typing_text" style="color:green;"></i></div>
				<label><b>Messages</b></label>
				<ul id="messages">
				</ul>
			</div>
-->

                    </div>
                </div>
            </div>
        </div>


    </div>

    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
  </body>
  </html>