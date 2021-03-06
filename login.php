<?php

require('includes/login_helpers.php');
require('includes/logged_in.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['email'])) $email = $_POST['email'];
    else $email = '';
    if(isset($_POST['password'])) $password = $_POST['password'];
    else $password= '';
    if(isset($_POST['remember'])) $remember =$_POST['remember'];
    else $remember = '';

    if(user_validated($email, $password)){
        new_cookie($email, $remember);
        session_start();
        header("Location: /index.php");
        exit();
    }
    
    # To show the error message when the user is not validated
    else
        $wrongpassword = true;

}

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Report an item you found</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found report an item you found">
    <meta name="keywords" content="lost and found, limbo, found, report">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <?php require"includes/header.php"; ?>
    <div class="content-container">
        <?php require('includes/sidebar.php'); ?>
        <div class="page-content">
            <h1>Log In</h1>
            <div class="page-body">
            <form action="/login.php" method="post">
                <?php 
                    # If the email or password was incorrect, show the error message
                    if(isset($wrongpassword)) echo '<p style="color:red;">Incorrect email or pasword</p>'; 
                ?>
                Email: <br><input autofocus class="login-field" type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"> <br>
                Password: <br><input class="login-field" type="password" name="password"><br>
                <br><input type="checkbox" name="remember"> Remember me<br>
                <input class="login-submit" type="submit" value="Log in"><br><br>
                <a href="/change-password.php">Change password</a><br><br>
                <a href="/register.php">Register</a>
            </form>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>