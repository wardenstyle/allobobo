<?php
/**
 * Script de connexion à la base de donnée
 */
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=dp-allobobo_bdd','root','') or die(print_r($bdd->errorInfo()));
	$bdd->exec('SET NAMES utf8');
}
catch(EXEPTION $e)
{
	die('Erreur:'.$e->getMessage());
}

?>