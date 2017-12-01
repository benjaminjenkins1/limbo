<?php

require('includes/logged_in.php');
require('includes/search_helpers.php');

$time = 365;
$sort = 'newest';

$term = $_GET['searchterm'];

if(isset($_GET['time']))
    $time = intval($_GET['time']);

if(isset($_GET['sort']))
    $sort = $_GET['sort'];

$page = 1;

if(isset($_GET['page']))
    $page = intval($_GET['page']);

$num_pages = get_num_pages($time, $sort, $term);

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Search</title>
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
            <h1>Search</h1>
            <div class="list-options">
                Sort by:
                <select id="sort-select" onchange="changeSearchSort(<?php echo $time; ?>, <?php echo $term; ?>, <?php echo $page; ?>)">
                    <option <?php if($sort == 'newest') echo 'selected="selected"'; ?> value="newest">newest first</option>
                    <option <?php if($sort == 'oldest') echo 'selected="selected"'; ?> value="oldest">oldest first</option>
                </select>
                <form class="searchform" action="search.php">
                    <input type="text" placeholder="Search" name="searchterm">
                    <input class="searchbutton" type="submit" value="&#128269;">
                </form>
            </div>  
            <?php 
            
            show_search($time, $sort, $page, $term); 
            
            echo '<p class="page-numbers">Page:';

            for ($i = 1; $i <= $num_pages; $i++) {
                if($page == $i){
                    echo ' <b><a href="/search.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '&term=' . $term . '">' . $i . '</a></b> ';
                }
                else if(!isset($_GET['page']) && $i == 1){
                    echo ' <b><a href="/search.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '&term=' . $term . '">' . $i . '</a></b> ';
                }
                else{
                    echo ' <a href="/search.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '&term=' . $term . '">' . $i . '</a> ';
                }
            }

            echo '</p>';

            ?>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>