-- Create the database
CREATE DATABASE avocat_connect;

USE avocat_connect;

-- Create the Users table
CREATE TABLE Users (
    User_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    telephone VARCHAR(15) NOT NULL,
    password VARCHAR(50) NOT NULL,
    role ENUM('client', 'avocat') NOT NULL
);

-- Create the Info table
CREATE TABLE Info (
    info_id INT(11) AUTO_INCREMENT PRIMARY KEY,
    photo VARCHAR(255),
    Biographie TEXT,
    coordonnee VARCHAR(255),
    annee_experience VARCHAR(50),
    specialite VARCHAR(50),
    user_id INT(11),
    FOREIGN KEY (user_id) REFERENCES Users(User_ID)
);

-- Create the Disponibilites table
CREATE TABLE Disponibilites (
    disponibilite_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_ID INT(11),
    disponibilite_date DATE,
    statut ENUM('disponible', 'non-disponible') NOT NULL,
    FOREIGN KEY (user_ID) REFERENCES Users(User_ID)
);

-- Create the Reservations table
CREATE TABLE Reservations (
    reservation_ID INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_ID INT(11),
    reservation_date DATETIME NOT NULL,
    statut ENUM('en attente', 'confirmee', 'annulee') NOT NULL,
    FOREIGN KEY (user_ID) REFERENCES Users(User_ID)
);
