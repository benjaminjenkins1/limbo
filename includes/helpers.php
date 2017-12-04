<?php

/*
Return an array of locations from the locations table
*/
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

    # Add the location in each row to the array
    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
        $locations[$row_index] = array($row['loc_id'], $row['name']);
        $row_index ++;
    }
    return $locations;
}

/*
Validates (checks if empty) the item information
Builds and returns an error string
*/
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