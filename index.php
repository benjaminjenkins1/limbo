<?php

require('includes/logged_in.php');
require('includes/items.php');
require('includes/connect_db.php');



# Look for the admin account in the database, create the admin account with the default password if it does not exist
$query = 'SELECT * FROM users WHERE email="admin"';
$results = mysqli_query($dbc, $query);
if($results != true){
    echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
    mysqli_free_result($results);
}
else{
    # If there is not a result, insert the default admin account into the users table
    if(mysqli_num_rows($results) == 0){
        $pass_hash = password_hash('gaze11e', PASSWORD_DEFAULT);
        $query = 'INSERT INTO users (email, pass_hash, fname, lname, level) VALUES ("admin", "' . $pass_hash . '", "Owner", "Owner", "admin")';
        $results = mysqli_query($dbc, $query);
        if($results != true){
            echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
            mysqli_free_result($results);
        }
        else{
            echo 'Default admin not found, created default admin with email "admin" and password "gaze11e"';
        }
    }
}

# Time is 365 days and sort is newest unless set in the request
$time = 365;
$sort = 'newest';

if(isset($_GET['time']))
    $time = intval($_GET['time']);

if(isset($_GET['sort']))
    $sort = $_GET['sort'];

# Page is 1 unless it is set in the request
$page = 1;

if(isset($_GET['page']))
    $page = intval($_GET['page']);

$num_pages = get_num_pages($time, $sort);

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Home</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found home page">
    <meta name="keywords" content="lost and found, limbo, home">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <?php require"includes/header.php"; ?>
    <div class="content-container">
        <?php require('includes/sidebar.php'); ?>
        <div class="page-content">
            <div class="lf-links">
                <a href="/lost.php" class="lf-link">I lost something!</a>
                <a href="/found.php" class="lf-link">I found something!</a>
            </div>
            <div class="list-options">
                Sort by:
                <select id="sort-select" onchange="changeSort(<?php echo $time; ?>)">
                    <option <?php if($sort == 'newest') echo 'selected="selected"'; ?> value="newest">newest first</option>
                    <option <?php if($sort == 'oldest') echo 'selected="selected"'; ?> value="oldest">oldest first</option>
                </select>
                <form class="searchform" action="search.php">
                    <input type="text" placeholder="Search" name="searchterm">
                    <input class="searchbutton" type="submit" value="&#128269;">
                </form>
            </div>  
            <?php 
            
            show_items($time, $sort, $page); 
            
            echo '<p class="page-numbers">Page:';

            # Display the page number links for each page
            for ($i = 1; $i <= $num_pages; $i++) {

                # For the current page, make the text bold
                if($page == $i){
                    echo ' <b><a href="/index.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '">' . $i . '</a></b> ';
                }

                # If there is no page in the request, make the first page bold since we will be showing the first page in that case
                else if(!isset($_GET['page']) && $i == 1){
                    echo ' <b><a href="/index.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '">' . $i . '</a></b> ';
                }

                # Make all other page links regular text
                else{
                    echo ' <a href="/index.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '">' . $i . '</a> ';
                }
            }

            echo '</p>';

            ?>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>