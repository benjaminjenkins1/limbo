<?php


function show_items($time, $sort, $page){

    require('includes/connect_db.php');

    $first_result_index = ($page - 1) * 10;

    $query = 'SELECT item_id, name, description, lost_date, status FROM items WHERE update_date > NOW() - INTERVAL ' . $time . ' DAY AND status<>"claimed"';
    
    if($sort === 'newest'){
        $query = $query . ' ORDER BY update_date DESC';
    }
    else if($sort === 'oldest'){
        $query = $query . ' ORDER BY update_date ASC';
    }

    $query = $query . ' LIMIT 10 OFFSET ' . $first_result_index;
    #echo $query;

    $results = mysqli_query($dbc, $query);

    if($results != true)
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

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

function get_num_pages($time, $sort){

    require('includes/connect_db.php');

    $query = 'SELECT * FROM items WHERE update_date > NOW() - INTERVAL ' . $time . ' DAY';
    
    if($sort === 'newest'){
        $query = $query . ' ORDER BY update_date DESC';
    }
    else if($sort === 'oldest'){
        $query = $query . ' ORDER BY update_date ASC';
    }
    
    $results = mysqli_query($dbc, $query);
    $rowcount=mysqli_num_rows($results);
    mysqli_free_result($results);

    return ceil($rowcount / 10);

}


?>