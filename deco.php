<?php
/**
 * Module de déconnexion
 * Permet la déconnexion
 * PHP : destruction de la session
 * Html : n/a
 * Dernière modification 22/05/2024
 */
session_start();
session_destroy();

header('Location:index.php');

exit();

?>