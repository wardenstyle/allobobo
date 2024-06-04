<?php

/**
 * Page d'inscription
 * PHP : Vérification de IHM de saisi
 * Html : Formulaire d'inscription
 * Dernière modification 02/06/2024
 * 
 * @todo encrypter le mot de passe ligne 64
 */

if(isset($_POST['submit'])){

	$validation = true;

	$nom = trim($_POST['nom']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
			
	if(empty($nom)){
		$validation = false;
		$erreur_nom = "* Indiquez votre nom";
	}

	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$validation = false;
		$erreur_email = "*Indiquez votre adresse e-mail";				
	}

	if(empty($password)){
		$validation = false;
		$erreur_pass = "* Mot de passe entre 6 et 8 caractères";
	}
				
	if(strlen($password) < 6 ){
		$validation = false;
		$erreur_pass = "* Mot de passe entre 6 et 8 caractères";
	}

	if($password != $repeatpassword) {
		$validation = false;
		$erreur_repeat ="*Les mots de passes ne correspondent pas";
			
	}
			
	include('allobobo_bdd.php');
	$reqmail = $bdd->prepare("SELECT * FROM user WHERE email_user =?");
	$reqmail->execute(array($email));// requete pour empecher d'entrée deux fois la meme adresse email
	$mailexiste = $reqmail->rowCount();
					
	if($mailexiste != 0) {
		$validation = false;
		$erreur ="Adresse émail déja utilisé";						
	}
	
	if($validation){
		$password = md5($password);			
		include('allobobo_bdd.php');
		$req = $bdd->prepare('INSERT INTO user (nom_user,email_user,mdp,type_compte) VALUES (:nom_user,:email_user,:mdp,:type_compte)');
        //execution de la requete sql prepare
		$req->execute(array(
				'nom_user' => $nom,
				'email_user' => $email,
				'mdp' => $password,
                'type_compte' => 'PAT'
								
		));
		$req->closeCursor();
	}		
			
}

?><!DOCTYPE html>
<html>
	<?php include('header.php') ?>

	<style>
        h3 {
            color: white;
            font-family: 'Roboto';
        }
        table {
            color: white;
        }
        .erreur_text {
            color: white;
            font-family: 'Roboto';
        }
        #form {
            display: flex;
            flex-direction: column;
            align-items: start;
            border: solid;
            color: white;
            padding: 10px;
            text-align: justify;
        }
        .custom-width {
            width: 150%;
        }
    </style>
</head>
<body>
    <div class="hero_area">
        <div class="hero_bg_box">
            <img src="images/hero-bg.png" alt="">
        </div>

        <!-- navigation section  -->
        <?php include('navigation.php') ?>
        <!-- navigation section -->

        <?php if ((isset($validation)) && ($validation == true)) { ?>
            <center>
                <h3>Votre compte a été créé !</h3><br/>
                <a class="btn btn-primary" href="connexion.php" id="lien_retour">Se connecter</a>
            </center>
        <?php } else { ?> 
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form id="form" method="post" action="inscription.php">
                            <div class="form-group">
                                <label for="nom" style="color:white; font-weight:bold">Nom:</label>
                                <input type="text" name="nom" class="form-control custom-width" id="nom" value="<?php if (isset($nom)) echo $nom; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email" style="color:white; font-weight:bold">Adresse mail:</label>
                                <input type="email" name="email" id="email" class="form-control custom-width" value="<?php if (isset($email)) echo $email; ?>" onchange="verifier_email()" onkeyup="verifier_email()">
                                <div id="resultat" style="display:inline;background-color:#942003;color:white; font-family:Arial;"></div>
                            </div>
                            <div class="form-group">
                                <label for="password" style="color:white; font-weight:bold">Mot de passe:</label>
                                <input type="password" name="password" id="password" class="form-control custom-width" value="<?php if (isset($password)) echo $password; ?>" onchange="verifier_mdp()" onkeyup="verifier_mdp()">
                            </div>
                            <div class="form-group">
                                <label for="repeatpassword" style="color:white; font-weight:bold">Confirmation mot de passe:</label>
                                <input type="password" name="repeatpassword" id="repeatpassword" class="form-control custom-width" value="<?php if (isset($password)) echo $password; ?>" onchange="verifier_mdp()" onkeyup="verifier_mdp()">
                                <div id="resultat2" style="display:inline;background-color:#942003;color:white; font-family:Arial;"></div>
                            </div>
                            <input id="reserver" type="submit" class="btn btn-primary" name="submit" value="Validez">
                        </form>

                        <?php 
                            if (isset($erreur_pass)) echo '<p class="erreur_text">' . $erreur_pass . '</p>';
                            if (isset($erreur_nom)) echo '<p class="erreur_text">' . $erreur_nom . '</p>';
                            if (isset($erreur_email)) echo '<p class="erreur_text">' . $erreur_email . '</p>';
                            if (isset($erreur_repeat)) echo '<p class="erreur_text">' . $erreur_repeat . '</p>';
                            if (isset($erreur)) echo '<p class="erreur_text">' . $erreur . '</p>'; 
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- Lien vers le JS de Bootstrap et ses dépendances -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

	<script type="text/javascript" src="monajax.js"></script>
					
</html>