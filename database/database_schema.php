<?php

/**
 * Fonction pour obtenir le schéma de la base de données
 */
function ab_get_db_schema() {
    global $ab_db;

    $charset_collate = get_charset_collate();

    // Tables spécifiques
    $ab_tables = [
        "CREATE TABLE $ab_db->rdv (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            jour datetime NOT NULL,
            id_medecin INT NOT NULL,
            nom VARCHAR(50) NOT NULL,
            email VARCHAR(50) NOT NULL,
            annulation VARCHAR(50) NOT NULL
        ) $charset_collate",
        
        "CREATE TABLE $ab_db->user (
            code INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            nom_user VARCHAR(50) NOT NULL,
            email_user VARCHAR(50) NOT NULL,
            mdp VARCHAR(100) NOT NULL,
            type_compte VARCHAR(5) DEFAULT NULL,
            id_rdv INT DEFAULT NULL
        ) $charset_collate",
        
        "CREATE TABLE $ab_db->medecin (
            id_medecin INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            nom_medecin VARCHAR(50) NOT NULL,
            email_medecin VARCHAR(50) NOT NULL,
            disponibilite VARCHAR(50) NOT NULL,
            specialite VARCHAR(50) NOT NULL,
            image VARCHAR(100) NOT NULL,
            code_user INT NOT NULL
        ) $charset_collate",
        
        "CREATE TABLE $ab_db->service_status (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            status ENUM('active', 'inactive') NOT NULL
        ) $charset_collate"
    ];

    return $ab_tables;
}

/**
 * Fonction pour obtenir le charset collate
 */
function get_charset_collate() {
    global $charset, $collate;
    $charset_collate = "DEFAULT CHARACTER SET $charset COLLATE $collate";
    return $charset_collate;
}


/** Les ALTER TABLES */
// function ab_get_db_alter_schema() {

//     return $ab_alter_tables;

// }