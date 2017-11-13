<?php

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }
    return $str;
}

function get_locations(){
    require('includes/connect_db.php');
    $query = 'SELECT * FROM locations';
    $results = mysqli_query($dbc, $query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
        return false;
    }
    $row_index = 0;
    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
        $locations[$row_index] = array($row['loc_id'], $row['name']);
        $row_index ++;
    }
    return $locations;
}

function validate_item($name, $description, $loc_id, $lost_date){
    $errors = '';
    if(empty($name))
        $errors = $errors . 'Provide an item name<br>';
    if(empty($description))
        $errors = $errors . 'Provide an item description<br>';
    if(empty($loc_id))
        $errors = $errors . 'Provide a location<br>';
    if(empty($lost_date))
        $errors = $errors . 'Provide a date lost<br>';
    return $errors;
}

?>