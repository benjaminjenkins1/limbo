<?php 

/*
Displays the users table
*/
function show_users($page, $logged_in_id){

    require('includes/connect_db.php');

    # Index of the first result is (page number - 1) * 10
    $first_result_index = ($page - 1) * 10;

    $query = 'SELECT * FROM users';
    $query = $query . ' LIMIT 10 OFFSET ' . $first_result_index;
    #echo $query;
    $results = mysqli_query($dbc, $query);

    if($results != true)
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';

    # Echo out the table
    else{
        echo '<table>';
        echo '<thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Level</th><th></th><th></th></tr></thead>';
        echo '<tbody>';
        while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
            echo '<tr>';
            echo '<td>' . $row['u_id'] . '</td>';
            echo '<td>' . $row['fname'] . '</td>';
            echo '<td>' . $row['lname'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['level'] . '</td>';

            # If the account is not an admin, display the option to make the user an admin, otherwise show an empty cell
            if($row['level'] != 'admin') echo '<td><a href="/promote.php?id=' . $row['u_id'] . '">Promote to admin</a></td>';
            else echo '<td></td>';

            # Unless the account is the currently logged in account, show the delete user option
            if($row['u_id'] != $logged_in_id) echo '<td><a href="/delete-user.php?id=' . $row['u_id'] . '">Delete user</a></td>';
            else echo '<td></td>';

            echo '</tr>';
            
        }
        echo '</tbody></table>';
    }

    mysqli_free_result($results);

}

/*
Gets the number of pages needed to display the users table
*/
function get_num_pages(){

    require('includes/connect_db.php');

    $query = 'SELECT * FROM users';
    $results = mysqli_query($dbc, $query);
    $rowcount=mysqli_num_rows($results);
    mysqli_free_result($results);

    # Pages required is the number of rows / 10, rounded up
    return ceil($rowcount / 10);

}

?>