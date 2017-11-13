<?php

require('includes/connect_db.php');

if(isset($_COOKIE['limbo_logged_in'])){
    $cookie = $_COOKIE['limbo_logged_in'];

    $query = 'SELECT users.u_id, fname, level FROM users, cookies WHERE cookies.contents="' . $cookie . '" AND cookies.u_id=users.u_id AND cookies.created < DATE_ADD(NOW(), INTERVAL 30 DAY)';
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
    }
    else{
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        $logged_in_fname = $row['fname'];
        $logged_in_id = $row['u_id'];
        $logged_in_level = $row['level'];
        mysqli_free_result($results);
        $logged_in = true;
    }
}
else{
    $logged_in = false;
    $logged_in_id = false;
    $logged_in_level = false;
}
?>