<?php
include_once 'settings.php';
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'],$_POST["phone"])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">Mail adresi geçersiz..</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    var_dump($password);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Şifre geçersiz..</p>';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT id FROM users WHERE email = ? LIMIT 1";
    $stmt = $link->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">Bu mail adresi zaten kayıtlı.</p>';
                        //$stmt->close();
        }
                $stmt->close();
    } else {
        $error_msg .= '<p class="error">Sunucu iç hatası.</p>';
                $stmt->close();
    }
 
    // check existing username
    $prep_stmt = "SELECT id FROM users WHERE username = ? LIMIT 1";
    $stmt = $link->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // A user with this username already exists
                        $error_msg .= '<p class="error">Bu kullanıcı adı zaten kayıtlı.</p>';
                       // $stmt->close();
                }
                $stmt->close();
        } else {
                $error_msg .= '<p class="error">Sunucu iç hatası.</p>';
                $stmt->close();
        }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
    if (empty($error_msg)) {
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 
        // Insert the new user into the database 
        if($insert_stmt = $link->prepare("INSERT INTO users (username, password, phone, email, secret_key) VALUES (?, ?, ?, ?,?)")){
        $insert_stmt->bind_param('sssss', $username, $password, $phone, $email, $random_salt);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
            echo "Bir hata oluştu lütfen tekrar deneyin..";
            }else{
                echo "<script>$('row').html('Kayıt işlemi tamamlandı. Giriş yapabilirsiniz..');</script>";
            }
        }
    }
}