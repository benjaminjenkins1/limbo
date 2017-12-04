<?php

require('includes/logged_in.php');
require('includes/connect_db.php');

setcookie('limbo_logged_in', $cookie_contents, time() - 3600);

# Delete the logged in user's cookies from the cookies table
$query = 'DELETE FROM cookies WHERE u_id=' . $logged_in_id;

$results = mysqli_query($dbc, $query);

if($results != true){
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
    mysqli_free_result($results);
}

# Send the user to the homepage
else{
    mysqli_free_result($results);        
    session_start( );
    header("Location: /index.php");
    exit();
}

?>