<?php 

# Connect to mysql database
$dbc = @mysqli_connect ( 'localhost', 'root', 'root', 'limbo_db' );
if(mysqli_connect_error() === "Unknown database 'limbo_db'"){
    require('includes/install.php');
    install_limbo();
}
else if (mysqli_connect_error()){
    die (mysqli_connect_error());
}

# Set encoding to match PHP script encoding.
mysqli_set_charset( $dbc, 'utf8' ) ;

?>