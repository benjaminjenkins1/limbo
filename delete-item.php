<?php

require('includes/logged_in.php');

/*
Deletes an item given it's id
*/
function delete_item($item_id){

    require('includes/connect_db.php');

    # Delete the item from the database
    $query = 'DELETE FROM items WHERE item_id =' . $item_id;
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
        return false;
    }

    #Redirect to the page with the "deleted" message
    session_start( );
    header("Location: /deleted.php");
    exit();

}

$item_id = $_GET['id'];

# If the user is an admin, they may always delete an item
if($logged_in_level === 'admin'){
    delete_item($item_id);
}

# Otherwise, the logged in user must be the owner to delete the item
else{
    # Get the item owner's id
    $query = 'SELECT owner_id FROM items WHERE item_id =' . $item_id;
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
    }
    else{
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);

        # If the logged in user is the owner, delete the item
        if($logged_in_id == $row['owner_id']){
            delete_item($item_id);
        }

        # Otherwise, redirect to the 550 page
        else{
            session_start( );
            header("Location: /550.php");
            exit();;
        }
    }
}

?>