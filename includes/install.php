<?php

function install_limbo(){

    $conn = mysqli_connect('localhost', 'root', 'root');
    if (!$conn) {
        die("Database connection failed. Is the database running?");
    }

    $query = 'CREATE DATABASE limbo_db';
    if (mysqli_query($conn, $query)) {
        #echo 'Database created successfully';
    } else {
        echo 'Error creating database: ' . mysqli_error($conn);
    }

    require('includes/connect_db.php');

    $query = "
    CREATE TABLE users(
        u_id INTEGER PRIMARY KEY AUTO_INCREMENT,
        email VARCHAR(50) NOT NULL UNIQUE,
        pass_hash TEXT NOT NULL,
        fname VARCHAR(30) NOT NULL,
        lname VARCHAR(30) NOT NULL,
        reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        level ENUM('user','admin') DEFAULT 'user'
    )
    ";
    if (mysqli_query($dbc, $query)) {
        #echo 'Users table created successfully';
    } else {
        echo 'Error creating users table: ' . mysqli_error($dbc);
    }

    $pass_hash = password_hash('gaze11e', PASSWORD_DEFAULT);
    $query = 'INSERT INTO users (email, pass_hash, fname, lname, level) VALUES ("admin", "' . $pass_hash . '", "Owner", "Owner", "admin")';
    if (mysqli_query($dbc, $query)) {
        #echo 'Admin account created successfully';
    } else {
        echo 'Error creating admin account: ' . mysqli_error($dbc);
    }

    $query = "
    CREATE TABLE cookies(
        u_id INTEGER,
        contents CHAR(60) NOT NULL,
        created DATETIME NOT NULL DEFAULT NOW(),
        PRIMARY KEY (u_id, contents),
        FOREIGN KEY (u_id) REFERENCES users(u_id)
    )
    ";
    if (mysqli_query($dbc, $query)) {
        #echo 'Cookies table created successfully';
    } else {
        echo 'Error creating cookies table: ' . mysqli_error($dbc);
    }

    $query = "
    CREATE TABLE locations(
        loc_id INTEGER PRIMARY KEY AUTO_INCREMENT,
        create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        update_date DATETIME ON UPDATE CURRENT_TIMESTAMP,
        name VARCHAR(50) NOT NULL
    )
    ";
    if (mysqli_query($dbc, $query)) {
        #echo 'Locations table created successfully';
    } else {
        echo 'Error creating locations table: ' . mysqli_error($dbc);
    }

    $query = "
    CREATE TABLE items(
        item_id INTEGER PRIMARY KEY AUTO_INCREMENT,
        loc_id INTEGER NOT NULL,
        name VARCHAR(30) NOT NULL,
        description TEXT NOT NULL,
        lost_date DATETIME NOT NULL,
        create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        update_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        owner_id INTEGER NOT NULL,
        claimer_id INTEGER,
        status ENUM('lost','found', 'claimed') NOT NULL,
        FOREIGN KEY (loc_id) REFERENCES locations(loc_id),
        FOREIGN KEY (owner_id) REFERENCES users(u_id),
        FOREIGN KEY (claimer_id) REFERENCES users(u_id)
    )
    ";
    if (mysqli_query($dbc, $query)) {
        #echo 'Items table created successfully';
    } else {
        echo 'Error creating items table: ' . mysqli_error($dbc);
    }

    
    $query = "
    INSERT INTO locations (name) VALUES
    ('Byrne House'),
    ('Cannavino Library'),
    ('Champagnat Hall'),
    ('Chapel'),
    ('Cornell Boathouse'),
    ('Donnelly Hall'),
    ('Dyson Center'),
    ('Fontaine  Hall'),
    ('Foy Townhouses'),
    ('Fulton Street Townhouses(Lower)'),
    ('Fulton Street Townhouses(Upper)'),
    ('Greystone Hall'),
    ('Hancock Center'),
    ('Kieran Gatehouse'),
    ('Kirk House'),
    ('Leo Hall'),
    ('Lowell Thomas'),
    ('Marian Hall'),
    ('Marist Boathouse'),
    ('McCann Center'),
    ('Mid-Rise Hall'),
    ('St. Anns Hermitage'),
    ('St.Peters'),
    ('Science and Allied Health Building'),
    ('Sheahan Hall'),
    ('Steel Plant Studios and Gallery'),
    ('Student Center'),
    ('West Cedar Townhouses(Lower)'),
    ('West Cedar Townhouses(Upper)'),
    ('Building A'),
    ('Building B'),
    ('Building C')
    ";
    if (mysqli_query($dbc, $query)) {
        #echo 'Locations inserted successfully';
    } else {
        echo 'Error inserting locations into locations table: ' . mysqli_error($dbc);
    }

    $query = "
    INSERT INTO items (loc_id, name, description, owner_id, create_date, update_date, lost_date, status) VALUES
    (1, 'iphone 1', 'An iphone 1', 1, '2017-11-01 00:00:00', '2017-11-10 00:00:00', '2017-10-10 00:00:00', 'lost'),
    (2, 'iphone 2', 'An iphone 2', 1, '2017-11-01 00:00:00', '2017-11-09 00:00:00', '2017-10-09 00:00:00', 'found'),
    (3, 'iphone 3', 'An iphone 3', 1, '2017-11-01 00:00:00', '2017-11-08 00:00:00', '2017-10-08 00:00:00', 'lost'),
    (4, 'iphone 4', 'An iphone 4', 1, '2017-11-01 00:00:00', '2017-11-07 00:00:00', '2017-10-07 00:00:00', 'lost'),
    (5, 'iphone 5', 'An iphone 5', 1, '2017-11-01 00:00:00', '2017-11-06 00:00:00', '2017-10-06 00:00:00', 'lost'),
    (5, 'iphone 6', 'An iphone 6', 1, '2017-11-01 00:00:00', '2017-11-05 00:00:00', '2017-10-05 00:00:00', 'lost'),
    (1, 'iphone 7', 'An iphone 7', 1, '2017-11-01 00:00:00', '2017-11-10 00:00:00', '2017-10-10 00:00:00', 'lost'),
    (2, 'iphone 8', 'An iphone 8', 1, '2017-11-01 00:00:00', '2017-11-09 00:00:00', '2017-10-09 00:00:00', 'found'),
    (3, 'iphone 9', 'An iphone 9', 1, '2017-11-01 00:00:00', '2017-11-08 00:00:00', '2017-10-08 00:00:00', 'lost'),
    (4, 'iphone 10', 'An iphone 10', 1, '2017-11-01 00:00:00', '2017-11-07 00:00:00', '2017-10-07 00:00:00', 'lost'),
    (5, 'iphone 11', 'An iphone 11', 1, '2017-11-01 00:00:00', '2017-11-06 00:00:00', '2017-10-06 00:00:00', 'lost'),
    (5, 'iphone 12', 'An iphone 12', 1, '2017-11-01 00:00:00', '2017-11-05 00:00:00', '2017-10-05 00:00:00', 'lost'),
    (1, 'iphone 13', 'An iphone 13', 1, '2017-11-01 00:00:00', '2017-11-10 00:00:00', '2017-10-10 00:00:00', 'lost'),
    (2, 'iphone 14', 'An iphone 14', 1, '2017-11-01 00:00:00', '2017-11-09 00:00:00', '2017-10-09 00:00:00', 'found'),
    (3, 'iphone 15', 'An iphone 15', 1, '2017-11-01 00:00:00', '2017-11-08 00:00:00', '2017-10-08 00:00:00', 'lost'),
    (4, 'iphone 16', 'An iphone 16', 1, '2017-11-01 00:00:00', '2017-11-07 00:00:00', '2017-10-07 00:00:00', 'lost'),
    (5, 'iphone 17', 'An iphone 17', 1, '2017-11-01 00:00:00', '2017-11-06 00:00:00', '2017-10-06 00:00:00', 'lost'),
    (5, 'iphone 18', 'An iphone 18', 1, '2017-11-01 00:00:00', '2017-11-05 00:00:00', '2017-10-05 00:00:00', 'lost')
    ";
    if (mysqli_query($dbc, $query)) {
        #echo 'Sample items inserted successfully';
    } else {
        echo 'Error inserting sample items into items table: ' . mysqli_error($dbc);
    }

    session_start();
    header("Location: /index.php?install=true");
    exit();

}

?>