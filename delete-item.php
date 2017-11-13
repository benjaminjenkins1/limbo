<?php

require('includes/logged_in.php');

function delete_item($item_id){

    require('includes/connect_db.php');

    $query = 'DELETE FROM items WHERE item_id =' . $item_id;
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
        return false;
    }
    session_start( );
    header("Location: /deleted.php");
    exit();

}

$item_id = $_GET['id'];

if($logged_in_level === 'admin'){
    delete_item($item_id);
}
else{
    $query = 'SELECT owner_id FROM items WHERE item_id =' . $item_id;
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
    }
    else{
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        if($logged_in_id == $row['owner_id']){
            delete_item($item_id);
        }
        else{
            session_start( );
            header("Location: /550.php");
            exit();;
        }
    }
}

?>