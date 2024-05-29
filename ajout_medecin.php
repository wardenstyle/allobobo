<?php 
/**
 * PHP: Traitement de données
 * Html:
 * Dernière modfication le: 24/05/2024
 */

 if(isset($_POST['submit'])){

	$validation = true;

	$nom = trim($_POST['nom']);
	$email = trim($_POST['email']);
	$specialite = trim($_POST['specialite']);
			
	if(empty($nom)){
		$validation = false;
		echo "* Indiquez le nom";
	}

	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$validation = false;
		echo "*Indiquez l'adresse e-mail";				
	}

	if(empty($specialite)){
		$validation = false;
		echo"* Indiquez la spécialité";
	}
							
	include('allobobo_bdd.php');

	if($validation){

		include('allobobo_bdd.php');
		$req = $bdd->prepare('INSERT INTO medecin (nom_medecin,email_medecin, disponibilite, specialite,image) VALUES (:nom_medecin,:email_medecin,:disponibilite,:specialite,:image)');
		$req->execute(array(
				'nom_medecin' => 'Dr.'.$nom,
				'email_medecin' => $email,
				'specialite' => $specialite,
                'disponibilite' => 1,
                'image' => 'images/m3.png'
								
		));
		$req->closeCursor();
        header('Location: medecin.php');

	} else {
        echo "<a href='http://allobobo.alwaysdata.net/medecin.php'>recommencer la saisie</a>";
    }		
			
}

?>




