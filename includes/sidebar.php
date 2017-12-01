<div class="sidebar">
    <?php

        require('includes/connect_db.php');

        if(!$logged_in){
            echo '<div class="sidebar-title"><a href="/login.php"><b>Log in</b></a> to see your items
            </div>';
        }
        else{
            echo '<div class="sidebar-title">Your items</div>';

            $query = 'SELECT item_id, name, DATE_FORMAT(lost_date, "%M %d %Y") AS lost_date, status FROM items WHERE owner_id=' . $logged_in_id;
            #echo $query;
            $results = mysqli_query($dbc, $query);
            if($results != true){
                echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
                mysqli_free_result($results);
            }
            else{
                while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
                    echo '<a class="sidebar-link" href="/item-details.php?id=' . $row['item_id'] . '"><table class="sidebar-table">';
                    echo '<tr><td>' . $row['name'] . '</td><td></td></tr>';
                    echo '<tr><td>' . ucfirst($row['status']) . '</td><td>' . $row['lost_date'] . '</td></tr>';
                    echo '</table></a>';
                }
                if(mysqli_num_rows($results) == 0){
                    echo "<p class='sidebar-noitems'>You don't have any items yet</p>";
                }
            }

        }
    ?>
</div>