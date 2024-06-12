<?php

/**
 * Page de prise de rendez-vous
 * PHP : IHM de saisie, Restitution de données
 * Html : Formulaire
 * Dernière modification 23/05/2024
 * 
 * @TODO LIST RAF : 
 * bloquer le select sur le jour d'haujourdui :FAIT
 * mettre un select pour le champ heure et minute :FAIT
 * faire une liste des médecins : FAIT
 * Conrole sur un créneau horaire d'un médecien : FAIT
 * Controle sur un créneau horaire d'un médecin en AJAX :FAIT
 * Controle sur le mot de passe
 */

include('allobobo_bdd.php');
/**
 * Récupération de la liste des médecins
 */
$requete = $bdd->query("SELECT id_medecin,nom_medecin FROM medecin ");

if(!empty($_POST)){

    extract($_POST);
    $validation = true;
    
    if($jour<10){
        $jour = '0'.$jour;
    }

    if($mois<10){
        $mois = '0'.$mois;
    }

    $date_unix = strtotime($annee.'-'.$mois.'-'.$jour);
    if(($mois == '04' || $mois == '06' || $mois == '09' || $mois == '11') && ($jour == '31')){
        $validation = false;
        $erreur_date = "* Ce jour n'existe pas";
	}elseif(($mois == '01') && ($jour > '29')){
		$validation = false;
		$erreur_date = "* Ce jour n'existe pas";
	} elseif($date_unix< time()){// Date unix strto time fonction qui permet de comparer avec notre date actuel
		$validation = false;
		$erreur_date = "* Date incorrect. rappel: pas de rendez-vous le jour meme.";
	}

	$heures_en_secondes= $heures*3600 + $minutes*60; // convertir nos heures en seconde pour pouvoir faire la condition : si il n'est pas le chreno horaire , c'est fermé
	if((!ctype_digit($heures)) || (!ctype_digit($minutes))){//ctype_digit Fonction php qui verifie si se sont des nombres qui ont été entré dans le formulaire
		$validation = false;
		$erreur_heure = "* Heure invalide";
	}elseif((($heures_en_secondes < 36000) || ($heures_en_secondes > 46800)) && (($heures_en_secondes < 50400) || ($heures_en_secondes > 77400 ))){
		$validation = false;
		$erreur_heure = "* Heure non comprise dans les crénaux horaires";	
	}

	if ($minutes >59){
		$validation = false;
		$erreur_heure ="* Heure non comprise dans les crénaux horaires";	
	}
	
	if(empty($nom)){
		$validation = false;
		$erreur_nom = "* Indiquez votre nom";
	}

	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){ // verifier le format email
		$validation = false;
		$erreur_email = "* Indiquez votre adresse Email";
	}

	if(empty($id_medecin)){
		$validation = false;
		$erreur_medecin = "* Veuillez séléctionner un médecin";
	}

	/**
	* Vérification de la disponibilité du médecin pour les horaires
	*/

	$date_choisie =  $annee.'-'.$mois.'-'.$jour.' '.$heures.':'.$minutes.':00'; 

	$reqdate = $bdd->prepare("SELECT jour FROM rdv WHERE jour =? AND id_medecin =?");
	$reqdate->execute(array($date_choisie, $id_medecin));									
	$date_result = $reqdate->rowCount();
						
	if($date_result != 0) {
		$validation = false;

		$erreur_creneaux = "* Médecin non disponible pour ce créneau";					
	}else{
		$creneau_ok = 'créneau disponible';
	}
	
	if($validation){

		include('allobobo_bdd.php');

		if($jour<10){$jour = "0".$jour;}
		if($mois<10){$mois = "0".$mois;}

		$annulation =time().''.$nom;
		$req = $bdd->prepare('INSERT INTO rdv (jour,id_medecin,nom,email,annulation) VALUES (:jour,:id_medecin,:nom,:email,:annulation)');
		$req->execute(array(
			'jour' => $annee.'-'.$mois.'-'.$jour.' '.$heures.':'.$minutes.':00',
			'id_medecin' => $id_medecin,
			'nom' => $nom,
			'email' => $email,
			'annulation' => $annulation
			
		));
		
		// $reservationId = $bdd->lastInsertId();	
		// $verif_email = $bdd->prepare('SELECT * FROM user WHERE email_user="'.$email.'"');
		// $verif_email->execute();
		// $test_email = $verif_email->fetch();
		// if (empty($test_email)) {
		
		// 	$req = $bdd->prepare('INSERT INTO user (nom_user,email_user,mdp,id_rdv) VALUES (:nom_user,:email_user,:mdp,:id_rdv)');
		// 	$req->execute(array(
		// 		'nom_user' => $nom,
		// 		'email_user' => $email,
		// 		'mdp' => $password,
		// 		'id_rdv' => $reservationId
		// 	));
	    // }
		
		$req->closeCursor();
		$to = $email;
		$subject ="Confirmation de votre rendez-vous";
		$content ='Mme,Mr '.$nom.'<br />
		Nous vous confirmons votre rendez-vous chez AlloBobo.<br />
		<br />
		Jour du rendez-vous :'.$jour.'/'.$mois.'/'.$annee.'  <br />
		à : '.$heures.':'.$minutes.'      <br />
		<br/>
		Vous pouvez annuler le rendez-vous depuis votre espace client en cliquant sur le lien :<a href="http://allobobo.alwaysdata.net/connexion.php">Annuler le rendez-vous</a><br />
		<br />
		A très bientôt chez AlloBobo.
		';
		$headers ='MIME-version: 1.0' ."\r\n";
		$headers . 'Content-type: text/html; charset=utf-8'. "\r\n";
		mail($to,$subject,$content,$headers);
			
	}
}
?>
<!doctype html>
<html>
	<?php include('header.php') ?>

	<script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script type="text/javascript" src="monajax.js"></script>

	<style>
		p, h3{color:white;font-family:'Roboto';}
		select{background-color:white;}	
	</style>
	
	<body>

	<div class="hero_area">
			<div class="hero_bg_box">
				<img src="images/hero-bg-sas.png" alt="">
			</div>
		    <!-- navigation section -->
			<?php include('navigation.php') ?>
   		 	<!-- navigation section -->	
         <?php if((isset($validation)) && ($validation == true)){ ?>
		<center>
			<h3>Rendez-vous enregistré ! un email de confirmation vous a été envoyé </h3><br/>
			<a href="index.php" class="btn btn-dark">Retour</a>
		</center>	
			<?php }else{ ?>

				<div class="container mt-5">
        			<div class="row justify-content-center">
						<div class="col-md-8">

							<article id="formulaire" class="border rounded" style="padding:10px">					
								<h3>Jour et heure du rendez-vous <span style="font-size: 0.8em;"> (pas de rendez-vous le jour même)<span></h3>					
								<form method="post" action="rdv.php" >
									<div id="erreur" style="color:red"> </div>

									<p>Jour souhaité</p>
									<div class="form-row">
										<div class="col-2">			
											<select name="jour" id="jour" class="form-control">
											<?php
												$jour_actuel = date("d");
												echo '<option value="'.$jour_actuel.'" selected>'.$jour_actuel.'</option>';
												for($i = 1;$i<=31;$i++)					
												{										
													echo '<option value="'.$i.'">'.$i.'</option>';								
												}
													?>
											</select>
										</div>

										<div class="col-4">
											<select name="mois" id="mois" class="form-control">
											<?php
												$mois_actuel = date('m')+0;
												$mois_francais = array('','Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
												$i = 1;
												echo '<option value="'.$mois_actuel.'" selected>'.$mois_francais[$mois_actuel].'</option>';
												for($i = 1; $i<=12;$i++)
												{
													echo '<option value="'.$i.'">'.$mois_francais[$i].'</option>';
												}
												?>
											</select>
										</div>

										<div class="col-6">
											<select name="annee" id="annee" class="form-control">
											<?php
												$annee_actuelle = date('Y');
												$i = 0;
												while($i < 3)
												{
													$annees = $annee_actuelle + $i;
													if((isset($annee)) && ($annee == $annees)){
														echo '<option value="'.$annees.'" selected>'.$annees.'</option>';
													}else{
														echo '<option value="'.$annees.'">'.$annees.'</option>';
														}
													$i++;
												}
											?>
												</select>
										</div>
									</div>
										<br />
									<p>Heure (entre 10:00 à 13:00 et de 14:00 à 21:30)</p>
									
									<div class="form-row">
										<div class="col-2">	
											<select name="heures" id="heures" class="form-control">
											<?php for($i=10;$i<14;$i++) {
													echo '<option value='.$i.'>'.$i.'</option>';
											}
												for ($i=14;$i<22;$i++) {
													echo '<option value='.$i.'>'.$i.'</option>';	
												}				
											?>
											</select>
										</div><span style="color:white">:</span>
										<div class="col-2">	
											<select name="minutes" id="minutes" class="form-control">
													<option value=00>00</option>
													<option value=15>15</option>
													<option value=30>30</option>
													<option value=45>45</option>
											</select>
										</div>
									</div>						
									<br />
									<label for="id_medecin" style="font-family:Arial">Choix du médecin:</label><br />
										<select name="id_medecin" id="id_medecin" class="form-control col-4" onchange="verifier_creneau()" onkeyup="verifier_creneau()">
											<option value="">Choisissez un médecin</option>
											<?php while( $row=$requete->fetch(PDO::FETCH_ASSOC)){ ?>
											<option value=<?php if(isset($row['id_medecin'])) echo $row['id_medecin'];?>><?php if(isset($row['nom_medecin'])) echo $row['nom_medecin'] ?></option>
											<?php } ?>
										</select>
									<div id="resultat" style="display:inline;background-color:#a96f4b;color:white; font-family:Arial;"></div>
									<br />			
									<br />
									<div class="transbox">
										<h3>Informations complémentaires</h3>									
										<label for="nom" style="font-family:Arial">Votre nom</label><br />
										<input type="text" name="nom" id="nom" value="<?php if(isset($nom))echo $nom; ?>" /><br />
										<label for="nom" style="font-family:Arial">Votre Email</label><br />
										<input type ="text" name="email" id="email" placeholder= "jeandupont@gmail.com" value="<?php if(isset($email))echo $email; ?>" /><br />					
									</div>
									<br />
									<input type="submit" class="btn btn-primary" value="Validez"/>
									<a href="index.php" class="btn btn-dark">Retour</a>

								</form>
								<?php }?>
							</article>

						<?php if(isset($erreur_date)) echo '<p>' .$erreur_date.'</p>'; ?>
						<?php if(isset ($erreur_heure)) echo '<p>' .$erreur_heure.'</p>'; ?>
						<?php if(isset ($erreur_nom)) echo '<p>' .$erreur_nom.'</p>'; ?>
						<?php if(isset ($erreur_email)) echo '<p>' .$erreur_email.'</p>'; ?>
						<?php if(isset ($erreur_medecin)) echo '<p>' .$erreur_medecin.'</p>'; ?>
						<?php if(isset ($erreur_creneaux)) echo '<p>' .$erreur_creneaux.'</p>'; ?>

					</div>
				</div>
			</div>
		</div>

		<!-- footer section -->
		<?php include('footer.php') ?>
  		<!-- footer section -->

	</body>

	<script type="text/javascript">
	
	</script>
