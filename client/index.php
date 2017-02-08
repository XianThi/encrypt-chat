<?php
include_once("settings.php");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encrypt</title>
 <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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
    <style>
      body {
    padding-top: 15px;
    font-size: 12px
  }
  .main {
    max-width: 320px;
    margin: 0 auto;
  }
  .login-or {
    position: relative;
    font-size: 18px;
    color: #aaa;
    margin-top: 10px;
            margin-bottom: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
  }
  .span-or {
    display: block;
    position: absolute;
    left: 50%;
    top: -2px;
    margin-left: -25px;
    background-color: #fff;
    width: 50px;
    text-align: center;
  }
  .hr-or {
    background-color: #cdcdcd;
    height: 1px;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
  }
  h3 {
    text-align: center;
    line-height: 300%;
  }
  .modal iframe {
    width: 100%;
    height: 500px;
}
    </style>
    <script type="text/javascript">
$(document).ready(function()
{
	$("#login_form").submit(function()
	{
		//remove all the class add the messagebox classes and start fading
		$("#msgbox").removeClass().addClass('alert alert-info').text('Doğrulanıyor....').fadeIn(1000);
		//check the username exists or not from ajax
		$.post("login.php",{ username:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
        {
		  if(data=='yes') //if correct login detail
		  {
		  	$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Giriş yapılıyor...').addClass('alert alert-success').fadeTo(900,1,
              function()
			  { 
			  	 //redirect to secure page
				 document.location='application.php';
			  });
			  
			});
		  }
		  else 
		  {
		  	$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
			{ 
			  //add message and change the class of the box and start fading
			  $(this).html('Giriş yapılamadı. Lütfen kullanıcı adı ve şifrenizi kontrol edin.').addClass('alert alert-danger').fadeTo(900,1);
			});		
          }
				
        });
 		return false; //not to post the  form physically
	});
	//now call the ajax also focus move from 
	$("#password").blur(function()
	{
		$("#login_form").trigger('submit');
	});
});
</script>
    </head>
<body>

<div class="container">
  <div class="row">
<div id="msgbox"></div>
    <div class="main">

      <h3>Giriş Yapın yada <a href="#register" data-toggle="modal" data-target="#register">Kayıt Olun</a></h3>
      <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="#" class="btn btn-lg btn-primary btn-block">Facebook</a>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
          <a href="#" class="btn btn-lg btn-info btn-block">Google</a>
        </div>
      </div>
      <div class="login-or">
        <hr class="hr-or">
        <span class="span-or">yada</span>
      </div>

      <form class="form-horizontal" method="post" action="" id="login_form">
        <div class="form-group">
          <label for="username">Kullanıcı Adı yada Telefon</label>
          <input type="text" class="form-control" id="username">
        </div>
        <div class="form-group">
          <a class="pull-right" href="#">Unuttunuz mu?</a>
          <label for="password">Şifre</label>
          <input type="password" class="form-control" id="password">
        </div>
        <div class="checkbox pull-right">
          <label>
            <input type="checkbox">
            Hatırla </label>
        </div>
        <button type="submit" class="btn btn btn-primary">
          Giriş Yap
        </button>
      </form>
    
    </div>
    
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Kayıt Olun</h4>
      </div>
      <div class="modal-body">
          <iframe src="register.php" frameborder="0" allowtransparency="true"></iframe>
      </div>
    </div>
  </div>
</div>
</body>
</html>