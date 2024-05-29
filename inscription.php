<?php

/**
 * Page d'inscription
 * PHP : Vérification de IHM de saisi
 * Html : Formulaire d'inscription
 * Dernière modification 21/05/2024
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
		$req = $bdd->prepare('INSERT INTO user (nom_user,email_user,mdp) VALUES (:nom_user,:email_user,:mdp)'); //execution de la requete sql
		$req->execute(array(
				'nom_user' => $nom,
				'email_user' => $email,
				'mdp' => $password
								
		));
		$req->closeCursor();
	}		
			
}

?><!DOCTYPE html>
<html>
	<?php include('header.php') ?>

		<style>

			h3{color:white;font-family:'Roboto';}
			table{ color:white;}
			#form{
				display: flex;
    			flex-direction: column;
    			align-items: start;
    			
				border: solid;color:white;padding:10px;text-align:justify;
			}

		</style>
	<body>
		<div class="container-fluid">
			<div class="hero_area">

				<div class="hero_bg_box">
					<img src="images/hero-bg.png" alt="">
				</div>

				<!-- navigation section  -->
				<?php include('navigation.php') ?>
				<!-- navigation section -->

				<?php if((isset($validation)) && ($validation == true)){ ?>
				<center>
				<h3>Votre compte à été créé !   </h3><br/>
				<a class="btn btn-primary" href="connexion.php" id="lien_retour">Se connecter</a>
				</center>
				<?php }else{ ?> 
			<center>							
			<section>
				<br />								
				<br />
				<form id="form" method="post" action="inscription.php" class="form-horizontal col-md-6 col-md-offset-3 col-xs-offset-2 col-xs-8" style="">
					<label for="nom" style="color:white; font-weight:bold">Nom:</label>
					<input type="text" name="nom" id="nom" size="40px" value="<?php if(isset($nom))echo $nom; ?>"><br/>
					<br /><!-- si la personne s'est trompé cela permet de garder son nom rempli-->									
					<label for="email" style="color:white; font-weight:bold"> Adresse mail: </label>
					<input  type="email" name="email" id="email" size="40px" 
					value="<?php if(isset($email))echo $email; ?>" onchange="verifier_email()" onkeyup="verifier_email()" ><div id="resultat" style="display:inline;background-color:#942003;color:white; font-family:Arial;"></div><br />
					<br />									
					<label for="password" style="color:white; font-weight:bold;"> Mot de passe : </label>
					<input  type="password" name="password"  id="password" size="40px"  
					onchange="verifier_mdp()" onkeyup="verifier_mdp()"/><br />
					<br />
					<label for="repeatpassword" style="color:white; font-weight:bold"> Confirmation mot de passe : </label>
					<input type="password" name="repeatpassword"  id="repeatpassword" size="40px"
					onchange="verifier_mdp()" onkeyup="verifier_mdp()" />
					<br />
					<br/>
					<div id="resultat2" style="display:inline;background-color:#942003;color:white; font-family:Arial;"></div>
					<br/>
					<input id="reserver" type="submit" class="btn btn-primary" name="submit" value="Validez" size="40px">
				</form>

				<?php }?>

			</section>
				<?php 
					if(isset($erreur_pass)) echo '<p class="erreur_text">' .$erreur_pass.'</p>';
					if(isset($erreur_nom)) echo '<p class="erreur_text">' .$erreur_nom.'</p>';
					if(isset($erreur_email)) echo '<p class="erreur_text">' .$erreur_email.'</p>';
					if(isset($erreur_repeat)) echo '<p class="erreur_text">' .$erreur_repeat.'</p>';
					if(isset($erreur)) echo '<p class="erreur_text">' .$erreur.'</p>'; 
				?>
				</center>
			<style>.erreur_text{color:white;font-family:'Roboto';}</style>
			<script type="text/javascript" src="monajax.js"></script>

		</div>
	</div>	
	</body>
					
</html>