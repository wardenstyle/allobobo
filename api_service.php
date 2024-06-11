<?php 

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

/** Etat du web service */

// Vérifier l'état actuel du service
include('allobobo_bdd.php');
$query = $bdd->query('SELECT status FROM service_status WHERE id = 1');
$status = $query->fetchColumn();

// Basculer l'état du service
if ($status == 'active') {
    
    $bdd->exec('UPDATE service_status SET status = "inactive" WHERE id = 1');
 
} else {
    $bdd->exec('UPDATE service_status SET status = "active" WHERE id = 1');
}

// Rediriger vers la page du menu
header('Location: espaceclient.php');
exit();

?>