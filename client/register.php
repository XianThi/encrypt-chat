<?php
include_once("settings.php");
include_once("register.app.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">

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
            <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
    <div id="alert"></div>
    <div class="container">
    <div class="row">
        <form action="<?php echo $app->esc_url($_SERVER['PHP_SELF']); ?>"  method="post" name="registration_form" class="form-horizontal">
            <div class="form-group">
            <label for="username">Kullanıcı Adı : </label><input class="form-control" type='text' name='username' id='username' /></div>
            <div class="form-group">
            <label for="password">Şifre : </label> <input class="form-control" type="password" name="password" id="password"/></div>
            <div class="form-group">
            <label for="confirpwd">Şifre Tekrar : </label> <input type="password" class="form-control" name="confirmpwd" id="confirmpwd" /></div>
            <div class="form-group">
            <label for="email"> Email: </label><input type="text" class="form-control" name="email" id="email" /></div>
            <div class="form-group">
            <label for="phone"> Telefon : </label><input type="text" class="form-control" name="phone" id="phone" /></div>
            <button class="btn btn btn-primary" onclick="return regformhash(this.form,this.form.username,this.form.email,this.form.password,this.form.confirmpwd,this.form.phone);"> Kayıt Ol </button> 
        </form>
        </div>
        </div>
    </body>
</html>