<?php

require('includes/connect_db.php');
require('includes/registration_helpers.php');
require('includes/logged_in.php');

$errors='';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    # Clean up the inputs
    $fname = strip_tags(trim($_POST['fname']));
    $lname = strip_tags(trim($_POST['lname']));
    $email = strip_tags(trim($_POST['email']));
    $password = trim($_POST['password']);

    $errors=validate_registration($fname,$lname,$email,$password);

    # If the information passes validation, register the user
    if(empty($errors)){

        register_user($fname,$lname,$email,$password);

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
            <div class="page-body">
                <form action="register.php" method="POST" onsubmit="event.preventDefault(); checkSame();">
                <!-- php sticky form -->
                    <div class="register-errors"><?php echo $errors; ?></div><br>
                    First name:<br>
                    <input autofocus type="text" class="login-field" name="fname" value="<?php if(isset($fname)) echo $fname; ?>"><br>
                    Last name:<br>
                    <input type="text" class="login-field" name="lname" value="<?php if(isset($lname)) echo $fname; ?>"><br>
                    Email:<br>
                    <input type="text" class="login-field" name="email" value="<?php if(isset($email)) echo $fname; ?>"><br>
                    Password:<br>
                    <input id="type_password" class="login-field" type="password" name="password"><br>
                    Re-type Password:<br>
                    <input id="retype_password" class="login-field" type="password" name="retype_password"><br>
                    <!-- retype validation is client-side (javascript) -->
                    <input class="login-submit" type="submit">
                </form>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>