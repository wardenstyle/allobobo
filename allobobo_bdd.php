<?php
/**
 * Script de connexion à la base de donnée
 */
try
{
	$bdd = new PDO('mysql:host=mysql-allobobo.alwaysdata.net;
	dbname=allobobo_bdd-dp','allobobo','4533141C') or die(print_r($bdd->errorInfo()));
	$bdd->exec('SET NAMES utf8');
}
catch(EXEPTION $e)
{
	die('Erreur:'.$e->getMessage());
}

?>