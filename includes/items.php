<?php

/*
Displays the list of items given a time (age of oldest possible result), sort order, and page
*/
function show_items($time, $sort, $page){

    require('includes/connect_db.php');

    # Index of first result for offert part of query
    $first_result_index = ($page - 1) * 10;

    $query = 'SELECT item_id, name, description, lost_date, status FROM items WHERE update_date > NOW() - INTERVAL ' . $time . ' DAY AND status<>"claimed"';
    
    # Add to query based on sort argument
    if($sort === 'newest'){
        $query = $query . ' ORDER BY update_date DESC';
    }
    else if($sort === 'oldest'){
        $query = $query . ' ORDER BY update_date ASC';
    }

    # Add to query based on page
    $query = $query . ' LIMIT 10 OFFSET ' . $first_result_index;
    #echo $query;

    $results = mysqli_query($dbc, $query);
    if($results != true)
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

    # Echo out the table
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
            # Only show the date, not the time
            echo '<td class="items-list-right">' . substr($row['lost_date'], 0, 10) . '</td>';
            echo '</tr>';
            echo '</tbody></table></a>';
        }
        echo '</div>';
    }

    mysqli_free_result($results);

}

/*
Gets the number of pages in the table given a time (age of oldest possible result), and sort order (not actually needed, can be removed)
*/
function get_num_pages($time, $sort){

    require('includes/connect_db.php');

    $query = 'SELECT * FROM items WHERE update_date > NOW() - INTERVAL ' . $time . ' DAY';
    
    # Add to query based on sort order (can be removed)
    if($sort === 'newest'){
        $query = $query . ' ORDER BY update_date DESC';
    }
    else if($sort === 'oldest'){
        $query = $query . ' ORDER BY update_date ASC';
    }

    $results = mysqli_query($dbc, $query);
    $rowcount=mysqli_num_rows($results);
    mysqli_free_result($results);

    # Number of pages is number of rows / 10, rounded up (10 results per page)
    return ceil($rowcount / 10);

}


?>