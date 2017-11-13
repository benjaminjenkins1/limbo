<?php

require('includes/items.php');

$time = 7;
$sort = 'newest';

if(isset($_GET['time']))
    $time = intval($_GET['time']);

if(isset($_GET['sort']))
    $sort = $_GET['sort'];

$page = 1;

if(isset($_GET['page']))
    $page = intval($_GET['page']);

$num_pages = get_num_pages();

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
                <select id="sort-select" onchange="changeSort()">
                    <option <?php if($sort == 'newest') echo 'selected="selected"'; ?> value="newest">newest first</option>
                    <option <?php if($sort == 'oldest') echo 'selected="selected"'; ?> value="oldest">oldest first</option>
                </select>
            </div>  
            <?php 
            
            show_items($time, $sort, $page); 
            
            echo '<p class="page-numbers">Page:';

            for ($i = 1; $i <= $num_pages; $i++) {
                echo ' <a href="/index.php?page=' . $i . '&sort=' . $sort . '&time=' . $time . '">' . $i . '</a> ';
            }

            echo '</p>';

            ?>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>