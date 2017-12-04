<?php

require('includes/logged_in.php');
require('includes/users.php');

# If the user is not logged in as admin, redirect to 550 page
if($logged_in_level != 'admin'){
    session_start( );
    header("Location: /550.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Admin</title>
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
            <div class="page-body">
                <h1>User Administration</h1>
                <br><br>
                <?php 
                
                if(!$_GET['page']){
                    show_users(1, $logged_in_id);
                }
                else{
                    show_users($_GET['page'], $logged_in_id) ;
                }

                $num_pages = get_num_pages();
                echo '<br>';
                echo '<p class="page-numbers">Page:';
                
                for ($i = 1; $i <= $num_pages; $i++) {
                    if($_GET['page'] == $i){
                        echo ' <b><a href="/admin.php?page=' . $i . '">' . $i . '</a></b> ';
                    }
                    else if(!$_GET['page'] && $i == 1){
                        echo ' <b><a href="/admin.php?page=' . $i . '">' . $i . '</a></b> ';
                    }
                    else{
                        echo ' <a href="/admin.php?page=' . $i . '">' . $i . '</a> ';
                    }
                }
    
                echo '</p>';
                
                ?>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>