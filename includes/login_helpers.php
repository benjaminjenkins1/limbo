<?php

function user_validated($email, $password){

    require('includes/connect_db.php');

    $salt_query = 'SELECT pass_salt FROM users WHERE email="' . $email . '"';
    $results = mysqli_query($dbc, $salt_query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);        
        return false;
    }

    if(mysqli_num_rows($results) == 0){
        mysqli_free_result($results);
        return false;
    }
        
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
    $salt = $row['pass_salt'];
    $pass_hash = hash('sha256', $salt . $password);

    $query = 'SELECT * FROM users WHERE email="' . $email . '" AND pass_hash="' . $pass_hash . '"';
    $results = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);

    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
        return false;
    }
    if(mysqli_num_rows($results) == 1){
        mysqli_free_result($results);
        return true;
    }
    mysqli_free_result($results);
    return false;
}

function new_cookie($email, $remember){

    require('includes/connect_db.php');
    require('includes/helpers.php');

    $id_query = 'SELECT u_id FROM users WHERE email="' . $email . '"';
    $results = mysqli_query($dbc, $id_query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
        return false;
    }
    $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
    $u_id = $row['u_id'];

    $cookie_contents = random_str(64);

    $cookie_query = 'INSERT INTO cookies (u_id, contents) VALUES (' . $u_id . ',"' . $cookie_contents . '")';
    $results = mysqli_query($dbc, $cookie_query);
    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
        mysqli_free_result($results);
        return false;
    }
    else{
        if($remember === 'on'){
            setcookie('limbo_logged_in', $cookie_contents, time()+60*60*24*30);
        }
        else{
            setcookie('limbo_logged_in', $cookie_contents);
        }
    }
}

?>