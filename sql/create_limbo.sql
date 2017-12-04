/*
This file creates the limbo database and the users, locations, and stuff tables for the database.
This file also populates the locations table.

Author: Benjamin Jenkins
Version: 1.2

Changes for Version 1.2:
Removed the creation of the default user, that is now done in index.php if the default account is not found
*/

DROP DATABASE IF EXISTS limbo_db;

CREATE DATABASE IF NOT EXISTS limbo_db;

USE limbo_db;

CREATE TABLE users(
    u_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL UNIQUE,
    pass_hash TEXT NOT NULL,
    fname VARCHAR(30) NOT NULL,
    lname VARCHAR(30) NOT NULL,
    reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level ENUM('user','admin') DEFAULT 'user'
);

CREATE TABLE cookies(
    u_id INTEGER,
    contents CHAR(60) NOT NULL,
    created DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY (u_id, contents),
    FOREIGN KEY (u_id) REFERENCES users(u_id)
);

CREATE TABLE locations(
    loc_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME ON UPDATE CURRENT_TIMESTAMP,
    name VARCHAR(50) NOT NULL
);

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
);

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
    ("St. Ann's Hermitage"),
    ("St.Peter's"),
    ('Science and Allied Health Building'),
    ('Sheahan Hall'),
    ('Steel Plant Studios and Gallery'),
    ('Student Center'),
    ('West Cedar Townhouses(Lower)'),
    ('West Cedar Townhouses(Upper)'),
    ('Building A'),
    ('Building B'),
    ('Building C');
