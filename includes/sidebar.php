<?php

$logged_in = false;

?>

<div class="sidebar">
    <?php
        if(!$logged_in){
            echo '<div class="sidebar-title"><a href="/login.php"><b>Log in</b></a> to see your items
            </div>';
        }
        else{
            echo '<div class="sidebar-title">';
            echo '</div>';
            echo '<div class="sidebar-title">';
            echo '</div>';
        }
    ?>
</div>