<?php

require('includes/connect_db.php');

if(isset($_COOKIE['limbo_logged_in'])){
    $cookie = $_COOKIE['limbo_logged_in'];

    $query = 'SELECT users.u_id, fname FROM users, cookies WHERE cookies.contents="' . $cookie . '" AND cookies.u_id=users.u_id AND cookies.created < DATE_ADD(NOW(), INTERVAL 30 DAY)';
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
    }
    else{
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        $logged_in_fname = $row['fname'];
        $logged_in_id = $row['u_id'];
        mysqli_free_result($results);
        $logged_in = true;
    }
}
else{
    $logged_in = false;
}
?>