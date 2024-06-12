<?php
/**
 * Script de connexion à la base de donnée
 */
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=dp-allobobo_bdd','root','') or die(print_r($bdd->errorInfo()));
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec('SET NAMES utf8');
}
catch(PDOException $e)
{
	header('Location: erreur.php');
	exit('Erreur : ' . $e->getMessage());
}

?>