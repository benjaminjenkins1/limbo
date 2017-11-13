<?php

require('includes/logged_in.php');
require('includes/helpers.php');

$errors = '';

if(!$logged_in){
    session_start( );
    header("Location: /login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = $_POST['name'];
    $description = $_POST['description'];
    $loc_id = $_POST['loc_id'];
    $lost_date = $_POST['lost_date'];

    $errors = validate_item($name, $description, $loc_id, $lost_date);

    if(empty($errors)){
        $lost_date = $lost_date . ' 00:00:00';
        $query = 'INSERT INTO items (loc_id, name, description, lost_date, owner_id, status) VALUES (' . $loc_id . ', "' . $name . '", "' . $description . '", "' . $lost_date . '", ' . $logged_in_id . ', "found")';
        #echo $query;
        $results = mysqli_query($dbc, $query);
        if($results != true){
            echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
            mysqli_free_result($results);
        }
        else{
            $item_id = mysqli_insert_id($dbc);
            mysqli_free_result($results);        
            session_start( );
            header("Location: /item-details.php?id=" . $item_id);
            exit();
        }
    }
    
}

?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Limbo - Report an item you found</title>
    <meta name="author" content="Benjamin Jenkins">
    <meta name="description" content="Limbo lost and found report an item you found">
    <meta name="keywords" content="lost and found, limbo, found, report">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" href="/css/custom.css" type="text/css">
    </head>
    <body>
    <?php require"includes/header.php"; ?>
    <div class="content-container">
        <?php require('includes/sidebar.php'); ?>
        <div class="page-content">
            <h1>Report an item you found</h1>
            <div class="page-body">
            <?php echo '<p style="color:red;">' . $errors . '</p>'; ?>
            <form action="found.php" method="POST">
                Item name:<br>
                <input type="text" class="report-text" name="name" value="<?php if(isset($name)) echo $name; ?>"><br>
                Item description:<br>
                <textarea class="report-textarea" name="description"><?php if(isset($description)) echo $description; ?></textarea><br>
                Location found:<br>
                <select name="loc_id" class="report-select" value="<?php if(isset($loc_id)) echo $loc_id; ?>">
                    <?php
                    $locations = get_locations();
                    foreach($locations as $loc){
                        echo '<option value="' . $loc[0] . '">' . $loc[1] . '</option>';
                    }
                    ?>
                </select><br>
                Date found:<br>
                <input type="date" class="report-date" name="lost_date" value="<?php if(isset($lost_date)) echo $lost_date; ?>"><br>
                <input class="login-submit" type="submit" value="Submit">
            </form>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php'); ?>
    </body>
</html>