<?php 
/**
 * Module de connexion
 * PHP : Vérification formulaire
 * Html : formulaire de connexion
 * Dernière modification le : 25/05/2024
 */

if(isset($_POST['submit'])) {

	$validation = true;
	$email_user = trim($_POST['email_user']);
    $mdp = trim($_POST['mdp']);

	// verification formulaire
	if(!filter_var($email_user,FILTER_VALIDATE_EMAIL)){
		$validation = false;
		$erreur_pass = "*Veuillez indiquez votre adresse Email";
	}

	if(empty($mdp)){
		$validation = false;
		$erreur_mdp = "*Veuillez indiquer votre mot de passe";
	}

	if($validation){	
		// requete sql pour verifier que le mot de passe et l'adresse email correspondent
		include('allobobo_bdd.php');
		$requser = $bdd->prepare("SELECT * FROM user WHERE email_user = ? AND mdp =? ");
		$requser->execute(array($email_user,md5($mdp)));
		$userexist = $requser ->rowCount();
				
		if($userexist==1){
			session_start();
			$userinfo = $requser->fetch();
			$_SESSION['code'] = $userinfo['code'];
			$_SESSION['email_user'] = $userinfo['email_user'];
            header("Location: espaceclient.php?id=".$_SESSION['email_user']);

		}else{
			$erreur1 = "* adresse email ou mot de passe incorrect ";
		}	
	}

}?>
<!DOCTYPE html>
<html>

    <?php include('header.php') ?>
	<style>
		h4{color:white;font-family:'Roboto';}
		.erreur_text{color:white;font-family:'Roboto';}
	</style>

	<body>
		<div class="hero_area">

					<div class="hero_bg_box">
						<img src="images/hero-bg-sas.png" alt="">
					</div>
					<!-- navigation section -->
					<?php include('navigation.php') ?>
					<!-- navigation section -->

				<div class="container mt-5">
        			<div class="row justify-content-center">
						<div class="col-md-6">
							<form method="post" action="connexion.php" class="" style="border: solid;color:white;padding:10px;">
								<div class="form-group">
									<label id="label_mail" for="email" style="color:white;font-family:Roboto"> Adresse mail: </label>
									<input type="email" name="email_user" class="form-control" placeholder="admin : admin@allobobo.fr" id="email"   value="<?php if(isset($email_user))echo $email_user; ?>"><br />
								</div>

								<div class="form-group">
									<label id="label_mdp" for="password" style="color:white;font-family:Roboto"> Mot de passe : </label>
									<input type="password" class="form-control "placeholder="mot de passe : admin" name="mdp"  id="mdp"   /><br />
								</div>
									<button class="btn btn-outline-dark" style="color:white" type="submit" name="submit">Se connecter</button>						
							</form>
							<br />
								<h4>Vous n'avez pas de compte ? <a class="btn btn-dark" href="inscription.php"> s'inscrire</a></h4>
								
							<br />

							<?php if(isset($erreur_pass)) echo '<p class="erreur_text">' .$erreur_pass.'</p>'; ?>
							<?php if(isset($erreur_mdp)) echo '<p class="erreur_text">' .$erreur_mdp.'</p>'; ?>
							<?php if(isset($erreur1)) echo '<p class="erreur_text">' .$erreur1.'</p>'; ?>
						</div>
					</div>
				</div>
		</div>
	</body>

				