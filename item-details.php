<?php

require('includes/logged_in.php');
require('includes/connect_db.php');

if(!isset($_GET['id'])){
    session_start( );
    header("Location: /index.php");
    exit();
} 

$id = $_GET['id'];
$query = 'SELECT * FROM items WHERE item_id=' . $id;
$results = mysqli_query($dbc, $query);

if($results != true)
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

else{
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
    $name = $row['name'];
    $description = $row['description'];
    $lost_date = substr($row['lost_date'], 0, 10);
    $update_date = $row['update_date'];
    $create_date = $row['create_date'];
    $status = $row['status'];
}

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Item details</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found item details">
    <meta name="keywords" content="lost and found, limbo, item, details">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <?php require"includes/header.php"; ?>
    <div class="content-container">
        <?php require('includes/sidebar.php'); ?>
        <div class="page-content">
            <h1>Item details</h1>
            <p><b>Item name:</b></p>
            <p><?php echo $name; ?></p>
            <p><b>Description:</b></p>
            <p><?php echo $description; ?></p>
            <p><b>Date lost:</b></p>
            <p><?php echo $lost_date; ?></p>
            <?php
            if($update_date != $create_date)
                echo '<p><b>Last updated:</b></p><p>' . $update_date . '</p>';
            else
                echo '<p><b>Last updated:</b></p><p>Never</p>';
            ?>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>