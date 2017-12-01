<?php

require('includes/connect_db.php');
require('includes/login_helpers.php');
require('includes/logged_in.php');


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        $email = $_POST['email'];
        $password = $_POST['password'];
        $new_password = $_POST['new_password'];
    
        if(!user_validated($email, $password)){
            $wrongpassword=true;
        }

        else if(strlen($new_password)<8){
            $tooshort = true;
        }

        else{

            require('includes/helpers.php');

            $salt = random_str(16);
            $hashed_pw = hash('sha256', $salt . $new_password);
            $query = 'UPDATE users SET pass_hash="' . $hashed_pw . '", pass_salt="' . $salt . '" WHERE email="' . $email . '"';
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
            <h1>Log In</h1>
            <div class="page-body">
            <form action="/changepassword.php" method="post">
                <?php if(isset($wrongpassword)) echo '<p style="color:red;">Incorrect email or pasword</p>'; ?>
                <?php if(isset($tooshort)) echo '<p style="color:red;">New pasword must be between 8 and 50 characters</p>'; ?>
                <?php if(isset($changed)) echo '<p>Your password has been changed. <a href="/login.php">Log in</a></p>'; ?>
                Email: <br><input class="login-field" type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"> <br>
                Password: <br><input class="login-field" type="password" name="password"><br>
                New password: <br><input class="login-field" type="password" name="new_password"><br>
                Re-type new password: <br><input class="login-field" type="password" name="retype_password"><br>
                <input class="login-submit" type="submit" value="Submit">
            </form>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>