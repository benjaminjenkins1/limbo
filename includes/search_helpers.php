<?php

/*
Displays search results given a time (age of oldest possible result), sort order, page number, and search term
*/
function show_search($time, $sort, $page, $term){

    require('includes/connect_db.php');

    # Calculate index of first result for offset based on page number
    $first_result_index = ($page - 1) * 10;

    $query = 'SELECT item_id, name, description, lost_date, status FROM items WHERE update_date > NOW() - INTERVAL ' . $time . ' DAY AND name LIKE "%' . $term . '%"';
    
    # Add sort by to suery based on value of sort argument
    if($sort === 'newest'){
        $query = $query . ' ORDER BY update_date DESC';
    }
    else if($sort === 'oldest'){
        $query = $query . ' ORDER BY update_date ASC';
    }

    # Offset based on index of first result
    $query = $query . ' LIMIT 10 OFFSET ' . $first_result_index;
    #echo $query;

    $results = mysqli_query($dbc, $query);
    if($results != true)
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

    # Echo out table with search results
    else{
        echo '<div class="items-list">';
        while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
            echo '<a href="/item-details.php?id=' . $row['item_id'] . '"><table><tbody>';
            echo '<tr>';
            echo '<td><b>' . $row['name'] . '</b></td>';
            echo '<td class="items-list-right"><b>' . ucfirst($row['status']) . '</b></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td class="items-list-right">' . substr($row['lost_date'], 0, 10) . '</td>';
            echo '</tr>';
            echo '</tbody></table></a>';
        }
        echo '</div>';
    }

    mysqli_free_result($results);

}

/*
Gets the number of pages for a search given a time (age of oldest possible result), sort order (not really needed), and term
*/
function get_num_pages($time, $sort, $term){

    require('includes/connect_db.php');

    $query = 'SELECT * FROM items WHERE update_date > NOW() - INTERVAL ' . $time . ' DAY AND name LIKE "%' . $term . '%"';
    
    # Not really needed
    if($sort === 'newest'){
        $query = $query . ' ORDER BY update_date DESC';
    }
    else if($sort === 'oldest'){
        $query = $query . ' ORDER BY update_date ASC';
    }

    $results = mysqli_query($dbc, $query);
    $rowcount=mysqli_num_rows($results);
    mysqli_free_result($results);

    # Number of pages is the number of rows in the result / 10, rounded up
    return ceil($rowcount / 10);

}


?>