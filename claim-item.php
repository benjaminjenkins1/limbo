<?php

require('includes/logged_in.php');

$item_id = $_GET['id'];

# If the user is not logged in, redirect to the 550 page
if(!$logged_in){
    session_start( );
    header("Location: /550.php");
    exit();
}

# Set the statis of the item to claimed in the database, and the claimer id to the logged in user's id
else{
    $query = 'UPDATE items SET status="claimed", claimer_id=' . $logged_in_id . ' WHERE item_id=' . $item_id;
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
    <title>Limbo - Claim item</title>
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
                <h1>Thank you</h1>
                <p>Thank you for claiming this item, the owner will be notified that you have claimed it.<p>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>