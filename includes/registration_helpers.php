<?php

/*
Validates a set of registration info (the arguments)
Builds an error string with any errors
*/
function validate_registration($fname, $lname, $email, $password){

    $errors='';

    # Check if any field is empty 
    if(empty($fname))
        $errors = $errors . 'Enter your first name<br>';
    if(empty($lname))
        $errors = $errors . 'Enter your last name<br>';
    if(empty($email))
        $errors = $errors . 'Enter your email<br>';
    if(empty($password))
        $errors = $errors . 'Enter a password<br>';

    # Check lengths
    if(strlen($fname)>30)
        $errors = $errors . 'First name must be 30 characters or fewer<br>';
    if(strlen($lname)>30)
        $errors = $errors . 'Last name must be 30 characters or fewer<br>';
    if(strlen($email)>50)
        $errors = $errors . 'Email must be 50 characters or fewer<br>';
    if(strlen($password)>50)
        $errors = $errors . 'Pasword must be between 8 and 50 characters<br>';
    if(strlen($password)<8)
        $errors = $errors . 'Pasword must be between 8 and 50 characters<br>';

    # Validate email with regex
    $email_pattern = '/.+' . preg_quote('@marist.edu') . '/';
    if(!empty($email) and !preg_match($email_pattern,$email))
        $errors = $errors . 'Invalid email';

    return $errors;

}

/*
Adds a user to the database
*/
function register_user($fname,$lname,$email,$password){

    require('includes/connect_db.php');
    require('includes/helpers.php');

    $pass_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = 'INSERT INTO users (email, pass_hash, fname, lname) VALUES ("' . $email . '", "' . $pass_hash . '", "' . $fname . '", "' . $lname . '")';
    
    $results = mysqli_query($dbc, $query);

    if($results != true){
        echo '<p>SQL ERROR = ' . mysqli_error( $dbc ) . '</p>';
    }

    # If the registration was successful, send the user to the thankyou page
    else{
        mysqli_free_result($results);        
        session_start( );
        header("Location: /registration_thankyou.php");
        exit();

    }

}

?>