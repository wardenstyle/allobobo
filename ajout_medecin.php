<?php 
/**
 * PHP: Traitement de données
 * Html:
 * Dernière modfication le: 24/05/2024
 */
if (session_status() === PHP_SESSION_NONE) {
	session_start();
  }

/** Gestion des Url  */

// obtenir l'adresse courante de la page  */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Obtenir le nom de domaine
$domainName = $_SERVER['HTTP_HOST'];

// Obtenir le chemin de la requête
$requestUri = $_SERVER['REQUEST_URI'];

// Construire l'URL complète
$currentUrl = $protocol . $domainName . $requestUri;

$newUrl = str_replace('/ajout_medecin.php', '/medecin.php', $currentUrl);
/** fin de l'url  */

if(isset($_SESSION['type_compte']) && $_SESSION['type_compte']== 'ADM') {

	if(isset($_POST['submit'])){

		$validation = true;

		$nom = trim($_POST['nom']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
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

		if(empty($password)){
			$validation = false;
			echo"* Indiquez le mot de passe";
		}

		include('allobobo_bdd.php');
		$reqmail = $bdd->prepare("SELECT * FROM user WHERE email_user =?");
		$reqmail->execute(array($email));// requete pour empecher d'entrée deux fois la meme adresse email
		$mailexiste = $reqmail->rowCount();
						
		if($mailexiste != 0) {
			$validation = false;
			echo "* Adresse émail déja utilisée";						
		}
								
		if($validation){
			
			include('allobobo_bdd.php');
			// 1/ on créé le compte utilisateur
			$req1 = $bdd->prepare('INSERT INTO user (nom_user,email_user,mdp,type_compte) VALUES (:nom_user,:email_user,:mdp,:type_compte)');
			$req1->execute(array(
				'nom_user' => 'Dr.'.$nom,
				'email_user' => $email,
				'mdp' => md5($password),
                'type_compte' => 'MDC'
								
			));
			//2/ on créé le compte médecin
			$inscriptionId = $bdd->lastInsertId();
			$req = $bdd->prepare('INSERT INTO medecin (nom_medecin,email_medecin, disponibilite, specialite,image,code_user) VALUES
			(:nom_medecin,:email_medecin,:disponibilite,:specialite,:image, :code_user)');
			$req->execute(array(
					'nom_medecin' => 'Dr.'.$nom,
					'email_medecin' => $email,
					'specialite' => $specialite,
					'disponibilite' => 1,
					'image' => 'images/m5.jpg',
					'code_user' => $inscriptionId
									
			));

			$req1->closeCursor();
			$req->closeCursor();

			header('Location: medecin.php');

		} else {
			echo "<a href='$newUrl'>recommencer la saisie</a>";
		}		
				
	}
}else {

	echo "Error 403 forbidden";
}

?>




