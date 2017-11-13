<?php



?>

<header>
    <a href="/index.php">
        <div class="site-title">
            <div class="title-limbo"><b>Limbo</b></div>
            <div class="title-lostandfound"><i>&nbsp;lost & found</i></div>
            <?php 
                if($_SERVER['PHP_SELF'] != '/index.php')
                    echo '<img class="homebutton" src="/images/home.svg">';
            ?>
        </div>
    </a>
    <div class="account-links">
        <?php 
            if(!$logged_in){
                echo '<a class="account-link" href="/login.php">Log In</a>';
                echo '<a class="account-link" href="/register.php">Register</a>';
            } 
            else{
                echo '<span class="logged-in-as">Logged in as ' . $logged_in_fname . '</span>';
                echo '<a class="account-link" href="/logout.php">Log Out</a>';
            }
        ?>
    </div>
</header>