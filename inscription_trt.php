<?php 
/**
 * PHP :script de Traitement des données
 * page concernée : inscription.php
 * Dernière modification le 24/05/2024
 */

if(isset($_POST['email'])){

    $email= $_POST['email'];

 
    include('allobobo_bdd.php');

	$reqmail = $bdd->prepare("SELECT * FROM user WHERE email_user =?");
	$reqmail->execute(array($email));// requete pour empecher d'entrée deux fois la meme adresse email
	$mailexiste = $reqmail->rowCount();
					
	if($mailexiste != 0) {
		echo "Adresse émail déja utilisé";						
	}
						
}

if(isset($_POST['mdp']) && isset($_POST['r_mdp'])){

    $mdp= $_POST['mdp'];
    $r_mdp= $_POST['r_mdp'];
	
    if($mdp != $r_mdp) {

		echo "Les mots de passes ne correspondent pas";
			
	}
}

?>