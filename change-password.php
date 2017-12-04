<?php

require('includes/connect_db.php');
require('includes/login_helpers.php');
require('includes/logged_in.php');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
    
        # Check the existing username and password for validity
        if(!user_validated($email, $password)){
            $wrongpassword=true;
        }

        # If the new password is too short
        else if(strlen($new_password)<8){
            $tooshort = true;
        }

        # Update the passwrord in the database (doesn't happen if the user was not validated)
        else{

            require('includes/helpers.php');

            $pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $query = 'UPDATE users SET pass_hash="' . $pass_hash . '" WHERE email="' . $email . '"';
            #echo $query;
            $results = mysqli_query($dbc, $query);
            if($results != true){
                echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
                mysqli_free_result($results);
            }
            else{
                $changed=true;
            }

        }
    
    }

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Change Password</title>
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
            <h1>Change Password</h1>
            <div class="page-body">
            <form action="/change-password.php" method="post" onsubmit="event.preventDefault(); checkSame();">
                <!-- Sticky form php -->
                <?php if(isset($wrongpassword)) echo '<p style="color:red;">Incorrect email or pasword</p>'; ?>
                <?php if(isset($tooshort)) echo '<p style="color:red;">New pasword must be between 8 and 50 characters</p>'; ?>
                <?php if(isset($changed)) echo '<p>Your password has been changed. <a href="/login.php">Log in</a></p>'; ?>
                Email: <br><input autofocus class="login-field" type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"> <br>
                Password: <br><input class="login-field" type="password" name="password"><br>
                New password: <br><input id="type_password" class="login-field" type="password" name="new_password"><br>
                Re-type new password: <br><input id="retype_password" class="login-field" type="password" name="retype_password"><br>
                <input class="login-submit" type="submit" value="Submit">
            </form>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>