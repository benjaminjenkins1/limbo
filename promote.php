<?php

require('includes/logged_in.php');

$u_id = $_GET['id'];

if(!$logged_in_level == 'admin'){
    session_start( );
    header("Location: /550.php");
    exit();
}

else{
    $query = 'UPDATE users SET level="admin" WHERE u_id=' . $u_id;
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Promote</title>
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
                <p>User with ID <?php echo $u_id; ?> has been promoted to an administrator</p>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>