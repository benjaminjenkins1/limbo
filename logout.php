<?php

require('includes/logged_in.php');
require('includes/connect_db.php');

setcookie('limbo_logged_in', $cookie_contents, time() - 3600);

$query = 'DELETE FROM cookies WHERE u_id=' . $logged_in_id;

$results = mysqli_query($dbc, $query);

if($results != true){
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
    mysqli_free_result($results);
}
else{
    mysqli_free_result($results);        
    session_start( );
    header("Location: /index.php");
    exit();
}

?>