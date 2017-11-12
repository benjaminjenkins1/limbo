<?php

require('includes/connect_db.php');
require('includes/registration_helpers.php');

$errors='';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $errors=validate_registration($fname,$lname,$email,$password);

    if(empty($errors)){

        

    }

}

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Register</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found registration">
    <meta name="keywords" content="lost and found, limbo, register">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <?php require('includes/header.php'); ?>
    <div class="content-container">
        <?php require('includes/sidebar.php'); ?>
        <div class="page-content">
            <h1>Register</h1>
            <form class="login-form" action="register.php" method="POST">
                <div class="register-errors"><?php echo $errors; ?></div><br>
                First name:<br>
                <input type="text" class="login-field" name="fname"><br>
                Last name:<br>
                <input type="text" class="login-field" name="lname"><br>
                Email:<br>
                <input type="text" class="login-field" name="email"><br>
                Password:<br>
                <input class="login-field" type="password" name="password"><br>
                <input class="login-submit" type="submit">
            </form>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>