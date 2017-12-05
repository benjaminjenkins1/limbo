<?php

if(!isset($logged_in)){
    $logged_in = false;
    $logged_in_fname = '';
    $logged_in_level = '';
}

?>

<div class="sidebar">
    <?php
    /*
    Displays the sidebar
    */

        require('includes/connect_db.php');

        # If user is not logged in, show the "log in to see your items" message
        if(!$logged_in){
            echo '<div class="sidebar-title"><a href="/login.php"><b>Log in</b></a> to see your items
            </div>';
        }

        else{
            echo '<div class="sidebar-title">Your items</div>';

            # Get the logged in user's items (where owner_id=$logged_in_id)
            $query = 'SELECT item_id, name, DATE_FORMAT(lost_date, "%M %d %Y") AS lost_date, status FROM items WHERE owner_id=' . $logged_in_id;
            #echo $query;
            $results = mysqli_query($dbc, $query);
            if($results != true){
                echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
                mysqli_free_result($results);
            }

            # Echo out a table for each item with the item's information
            else{
                while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
                    echo '<a class="sidebar-link" href="/item-details.php?id=' . $row['item_id'] . '"><table class="sidebar-table">';
                    echo '<tr><td>' . $row['name'] . '</td><td></td></tr>';
                    echo '<tr><td>' . ucfirst($row['status']) . '</td><td>' . $row['lost_date'] . '</td></tr>';
                    echo '</table></a>';
                }
                # If the user has no items, display the appropriate message
                if(mysqli_num_rows($results) == 0){
                    echo "<p class='sidebar-noitems'>You don't have any items yet</p>";
                }
            }

        }
    ?>
</div>