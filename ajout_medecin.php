<?php 
/**
 * PHP: Traitement de données
 * Html:
 * Dernière modfication le: 24/05/2024
 */
if (session_status() === PHP_SESSION_NONE) {
	session_start();
  }

if($_SESSION['type_compte']== 'ADM') {

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
			// 1/ on créé le compte utilisateur
			$req1 = $bdd->prepare('INSERT INTO user (nom_user,email_user,mdp,type_compte) VALUES (:nom_user,:email_user,:mdp,:type_compte)');
			$req1->execute(array(
				'nom_user' => 'Dr.'.$nom,
				'email_user' => $email,
				'mdp' => md5($nom.'12345'),
                'type_compte' => 'MDC'
								
			));
			//2/ on créé le compte médecin
			$inscriptionId = $bdd->lastInsertId();
			$req = $bdd->prepare('INSERT INTO medecin (nom_medecin,email_medecin, disponibilite, specialite,image,code_user) VALUES
			(:nom_medecin,:email_medecin,:disponibilite,:specialite,:image, code_user:code_user)');
			$req->execute(array(
					'nom_medecin' => 'Dr.'.$nom,
					'email_medecin' => $email,
					'specialite' => $specialite,
					'disponibilite' => 1,
					'image' => 'images/m4.jpg',
					'code_user' => $inscriptionId
									
			));

			$req1->closeCursor();
			$req->closeCursor();
			header('Location: medecin.php');

		} else {
			echo "<a href='http://allobobo.alwaysdata.net/medecin.php'>recommencer la saisie</a>";
		}		
				
	}
}else {

	echo "Error 403 forbidden";
}

?>




