/*
This file creates the limbo database and the users, locations, and stuff tables for the database.
This file also populates the locations table.
This file also adds the default administrator with email "admin@limbo.com" and password "letmein" (hash is sha256).

Author: Benjamin Jenkins
Version: 1.1
*/

DROP DATABASE limbo_db;

CREATE DATABASE IF NOT EXISTS limbo_db;

USE limbo_db;

CREATE TABLE users(
    u_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL UNIQUE,
    pass_hash CHAR(64) NOT NULL UNIQUE,
    pass_salt CHAR(16) NOT NULL UNIQUE,
    fname VARCHAR(30) NOT NULL,
    lname VARCHAR(30) NOT NULL,
    reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    level ENUM('user','admin')
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
    create_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    update_date DATETIME ON UPDATE CURRENT_TIMESTAMP,
    owner_id INTEGER NOT NULL,
    claimer_id INTEGER,
    status ENUM('lost','found'),
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

INSERT INTO users (email, pass_hash, pass_salt, fname, lname, level) VALUES (
    'admin@limbo.com',
    '1c8bfe8f801d79745c4631d09fff36c82aa37fc4cce4fc946683d7b336b63032',
    '7e1eebc2f1df0bbc',
    'owner',
    'owner',
    'admin'
);