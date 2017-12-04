<?php
/*
Checks if a user is logged in by looking for the browser cookie and checking if it is in the database
*/

require('includes/connect_db.php');

# If the cookie is set, check for it in the database
if(isset($_COOKIE['limbo_logged_in'])){
    $cookie = $_COOKIE['limbo_logged_in'];

    # Check for the cookie contents in the cookies table
    $query = 'SELECT users.u_id, fname, level FROM users, cookies WHERE cookies.contents="' . $cookie . '" AND cookies.u_id=users.u_id AND cookies.created < DATE_ADD(NOW(), INTERVAL 30 DAY)';
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
    }

    # If the result has a row, set the appropriate variables
    else if(mysqli_num_rows($results) == 1){
        $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
        $logged_in = true;
        $logged_in_fname = $row['fname'];
        $logged_in_id = $row['u_id'];
        $logged_in_level = $row['level'];
        mysqli_free_result($results);
    }
}

# If there is no cookie, the user is not logged in
else{
    $logged_in_id = false;
    $logged_in_level = false;
}

?>