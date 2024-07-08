<?php

/**
 * Fonction pour obtenir le charset et le collate
 */
function get_charset_collate() {
    global $charset, $collate;

    $charset_collate = '';

    if (!empty($charset)) {
        $charset_collate = "DEFAULT CHARACTER SET $charset";
    }
    if (!empty($collate)) {
        $charset_collate .= " COLLATE $collate";
    }

    return $charset_collate;
}

/**
 * Création des tables
 */
function ab_get_db_schema() {
    global $ab_db;

    /**
     * The database character collate.
     */
    $charset_collate = get_charset_collate();

    // Tables spécifiques au blog.
    $ab_tables = "

    CREATE TABLE $ab_db->rendez_vous (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        jour datetime NOT NULL,
        id_medecin INT NOT NULL,
        nom VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        annulation VARCHAR(50) NOT NULL
    )
    $charset_collate;	
        
    CREATE TABLE $ab_db->utilisateur (
        code INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nom_user VARCHAR(50) NOT NULL,
        email_user VARCHAR(50) NOT NULL,
        mdp VARCHAR(100) NOT NULL,
        type_compte VARCHAR(5) DEFAULT NULL,
        id_rdv INT DEFAULT NULL
    )
    $charset_collate;	
        
    CREATE TABLE $ab_db->medecin (
        id_medecin INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        nom_medecin VARCHAR(50) NOT NULL,
        email_medecin VARCHAR(50) NOT NULL,
        disponibilite VARCHAR(50) NOT NULL,
        specialite VARCHAR(50) NOT NULL,
        image VARCHAR(100) NOT NULL,
        code_user INT NOT NULL
    )
    $charset_collate;

    CREATE TABLE $ab_db->service_status (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        status ENUM('active', 'inactive') NOT NULL
    )
    $charset_collate;
    ";

    return $ab_tables;
}


/** Les ALTER TABLES */
// function ab_get_db_alter_schema() {

//     return $ab_alter_tables;

// }