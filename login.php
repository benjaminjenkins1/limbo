<?php

require('includes/login_helpers.php');

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(user_validated($email, $password)){
        new_cookie($email);
        session_start( );
        header("Location: /index.php");
        exit();
    }
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
            <div class="form-container">
            <form class="login-form" action="/login.php" method="post">
                <?php if(isset($wrongpassword)) echo '<p style="color:red;">Incorrect username or pasword</p>'; ?>
                Email: <br><input class="login-field" type="text" name="email"> <br>
                Password: <br><input class="login-field" type="password" name="password"><br>
                <input class="login-submit" type="submit" value="Log in"><br>
                <p><a href="/changepassword.php">Change password</a></p>
            </form>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>