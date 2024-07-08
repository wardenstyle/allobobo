<?php

require_once 'database_upgrade.php'; // Contient la fonction ab_bd_install() et de connexion a la bdd
require_once 'database_load.php'; // chargement de la base

$charset = 'utf8mb4';
$collate = 'utf8mb4_unicode_ci';

function check_and_run_install() {
    // Vérifier si le fichier de verrouillage existe
    if (file_exists('installed.lock')) {
        return; // Installation déjà effectuée
    }

    // Connexion à la base de données
    $pdo = get_pdo_connection();
    if ($pdo === null) {
        die('Erreur de connexion à la base de données.');
    }

    // Liste des tables à vérifier
    $tables = ['rendez_vous', 'utilisateur', 'medecin','service_status']; // Ajoutez toutes les tables à vérifier

    try {

        try {

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `dp-allobobo_bdd` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        } catch (Exception $e) {

            error_log('Erreur lors de la création de la base de données: ' . $e->getMessage());
            echo 'init.php : erreur lors de la création de la base de données';
            throw $e;
        }
        
        foreach ($tables as $table) {
            $result = $pdo->query("SHOW TABLES LIKE '$table'");
            if ($result->rowCount() == 0) {
                // Si l'une des tables n'existe pas, lancer l'installation
                ab_bd_install();

                // Créer un fichier pour indiquer que l'installation est terminée
                file_put_contents('installed.lock', 'Installation terminée');
                return; // Sortir de la fonction après l'installation
            }
        }
    } catch (Exception $e) {
        error_log('Erreur lors de la vérification des tables: ' . $e->getMessage());
        echo 'init.php : Une erreur est survenue. Veuillez vérifier les journaux d\'erreurs pour plus de détails.';
    }
}

// Exécuter la vérification et éventuellement l'installation
check_and_run_install();
