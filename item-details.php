<?php

require('includes/logged_in.php');
require('includes/connect_db.php');

# If for some reason there is no id in the request, return to the homepage
if(!isset($_GET['id'])){
    session_start( );
    header("Location: /index.php");
    exit();
} 

# Get the item info from the database
$id = $_GET['id'];
$query = 'SELECT items.name AS item_name, description, lost_date, items.update_date AS update_date, items.create_date AS create_date, status, owner_id, locations.name AS loc_name FROM items, locations WHERE items.loc_id=locations.loc_id AND item_id=' . $id;
$results = mysqli_query($dbc, $query);

if($results != true)
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

else{
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
    $name = $row['item_name'];
    $description = $row['description'];
    $lost_date = substr($row['lost_date'], 0, 10);
    $update_date = $row['update_date'];
    $create_date = $row['create_date'];
    $status = $row['status'];
    $owner_id = $row['owner_id'];
    $loc_name = $row['loc_name'];
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
            <h1><?php echo ucfirst($status); ?> Item details</h1>
            <div class="page-body">
                <?php

                # Case where the item is claimed and the logged in user is not the owner
                if($status == 'claimed' && $logged_in_id != $owner_id){
                    echo '<p><h2>This item has been claimed</h2></p>';
                }
                
                # Case where the item is claimed and the logged in user is the owner
                if($status == 'claimed' && $logged_in_id == $owner_id){

                    # Get the item information from the database
                    $query = 'SELECT * FROM items, users WHERE items.item_id=' . $_GET['id'] . ' AND users.u_id = items.claimer_id';
                    $results = mysqli_query($dbc, $query);
                    
                    if($results != true)
                        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

                    # Show the claimer's email and first name
                    else{
                        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
                        $claimer_fname = $row['fname'];
                        $claimer_email = $row['email'];
                    }
                    echo '<p><h2>Your item has been claimed by ' . $claimer_fname . ' (' . $claimer_email . ')</h2></p>';
                }

                ?>
                <p><b>Item name:</b></p>
                <p><?php echo $name; ?></p>
                <p><b>Description:</b></p>
                <p><?php echo $description; ?></p>
                <p><b>Location lost:</b></p>
                <p><?php echo $loc_name; ?></p>
                <?php
                # Show "date lost" or "date found" based on the item status
                if($status === 'lost')
                    echo '<p><b>Date lost:</b></p>';
                else if($status === 'found')
                    echo '<p><b>Date found:</b></p>';
                ?>
                <p><?php echo $lost_date; ?></p>
                <?php
                # If the item has been updated, show the update date, otherwise, say "never"
                if($update_date != $create_date)
                    echo '<p><b>Last updated:</b></p><p>' . $update_date . '</p>';
                else
                    echo '<p><b>Last updated:</b></p><p>Never</p>';
                ?>
                
                <?php
                # Case where the user is the admin or owner of the item
                # Shows Edit and delete buttons
                if($logged_in_level === 'admin' || $logged_in_id == $owner_id){
                    echo '<a class="edit-delete" href="/edit-item.php?id=' . $id . '">Edit this item</a><br>';
                    echo '<a class="edit-delete" href="/delete-item.php?id=' . $id . '">Delete this item</a><br>';
                }

                # Case where the user is logged in, not the owner, and the item is lost
                # Shows the "I found it" button
                if($logged_in && $status === 'lost' && $logged_in_id != $owner_id){
                    echo '<a class="edit-delete" href="/claim-item.php?id=' . $id . '">I found this item</a><br>';
                }

                # Case where the user is logged in, is not the owner, and the item is found
                # Shows the "claim" button
                if($logged_in && $status === 'found' && $logged_in_id != $owner_id){
                    echo '<a class="edit-delete" href="/claim-item.php?id=' . $id . '">Claim this item</a><br>';
                }

                # Case where the user is not logged in and the item is lost
                # Shows "Log in to say you found it"
                if(!$logged_in && $status === 'lost'){
                    echo '<a class="edit-delete" href="/login.php">Log in to say you found this item</a>';
                }

                # Case where the user is not logged in and the item is found
                # Shows "Log in to claim"
                if(!$logged_in && $status === 'found'){
                    echo '<a class="edit-delete" href="/login.php">Log in to claim this item</a>';
                }
                
                ?>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>