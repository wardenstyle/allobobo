<?php

/**
 * Espace client
 * Page de consultation
 * PHP : Restitution de données
 * Html : Tableau de présentation
 * Dernière modification 02/06/2024
 * fichier ajouté sur git
 */
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if(isset($_SESSION['email_user']) && $_SESSION['type_compte'] == 'PAT' || $_SESSION['type_compte'] == 'ADM'){
	include('allobobo_bdd.php');
	$requete4 = $bdd->query("SELECT * FROM user WHERE email_user='{$_SESSION['email_user']}'");
	$nom = $requete4->fetch();

	// Vérifier l'état actuel du service API
	$query = $bdd->query('SELECT status FROM service_status WHERE id = 1');
	$status = $query->fetchColumn();

	if($status != 'active') {

		$style_class = "offline";
		$etat = "fermé";
		$disabled="disabled";

	}else{

		$style_class = "online";
		$etat = "ouvert";
		$disabled = "";
		// construction des URL de l'Api
		$currentUrl = $_SERVER['PHP_SELF'];
		// fichier actuel
		$currentFile = basename($currentUrl);
		// chemin actuel
		$directoryPath = dirname($currentUrl);
		$newFile = 'api.php';
		// url api 
		$newUrl = $directoryPath . '/' . $newFile;

	}
	
?><!doctype html>
<html>

	<?php include('header.php') ?>
	
	<style>
		td, h3, h4{font-family:'Roboto';}
		.tab-content{display:none};
		.m-top-10{margin-top:10px;}
		button.active{
			background-color:#007bff;
			color:white;
		}
		.online {
			display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 10px;
			background-color: green;
		}
		.offline {
			display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 10px;
			background-color: red;
		}
	</style>
	
<body>

	<div class="hero_area">

		<div class="hero_bg_box">
		<img src="images/hero-bg.png" alt="">
		</div>

		<!-- navigation section  -->
		<?php include('navigation.php') ?>
		<!-- navigation section -->

		<div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">

					<div class="card text-center" style="">

						<div class="card-header">
							<ul class="nav nav-tabs card-header-tabs">
							<li class="nav-item">
								<button class="nav-link active" id="lien_actif0" onclick="openTab(0)">Mon compte</button>
							</li>
							<li class="nav-item">
								<button class="nav-link" id="lien_actif1" onclick="openTab(1)">Mes Rendez-vous</button>
							</li>
							<li class="nav-item">
								<button class="nav-link" id="lien_actif2" onclick="openTab(2)">Historique des Rendez-vous</button>
							</li>

							<li class="nav-item">
								<button class="nav-link" id="lien_actif3" onclick="openTab(3)">Mes services <span class="<?php echo $style_class; ?>"></span></button>
							</li>
							</ul>
						</div>

						<div class="card-body">

							<!-- Début du contenu de l'onglet mon Compte -->
							<div class="tab-content" style="display:block">
								<h5 class="card-title">Bonjour <?php echo ' '.$nom['nom_user'].', '?></h5>
								<p class="card-text">bienvenue dans votre espace personnel.</p>
								<a href="deco.php" class="btn btn-dark">Se déconnecter</a>
								<?php if($_SESSION['email_user'] == 'admin@allobobo.fr') {
									$lien = "agenda.php"; $message=""; $disabled ="";$title="consulter le planning";
									}else{
										$lien = ""; $disabled = "disabled"; $message="(compte admin requis)";$title="compte admin requis";
									}
								?>
								<a href="<?php echo $lien?>" title="<?php echo $title; ?>" disabled="<?php echo $disabled;?>" class="btn btn-primary">
								Planning 
								</a><span style="color:#a96f4b;"><small><?php echo $message;?></small></span>
								<img src="images/classeur.png">
							</div>
							<!-- fin  de l'onglet mon compte -->

							<!-- Début de l'onglet mes rendez-vous -->
							<div class="tab-content" style="display:none">
								<h5 class="card-title">Vos prochain rendez-vous</h5>			
								<table style="padding:10px;" class="table table-striped">
									<thead>
										<tr>
											<th scope="col">Jour/heure</th>
											<th scope="col">Nom</th>
											<th scope="col">Médecin</th>
											<th scope="col">Spécialité</th>
											<th scope="col">Annulation</th>	
										</tr>
									</thead>
							<?php 
				
							// récupérer les rendez-vous à venir
				
							$requete = $bdd->query(
							"SELECT * FROM rdv
							 INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
							 WHERE email='{$_SESSION['email_user']}' AND jour > NOW() ORDER BY jour ASC");
							$requete2 = $bdd->query(
							"SELECT COUNT(*) FROM rdv 
							INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
							WHERE email='{$_SESSION['email_user']}'AND jour > NOW()");
							$nb_rdv = $requete2->fetchColumn();

							// affichage des données

							if($nb_rdv > 0) {
								while($row=$requete->fetch(PDO::FETCH_ASSOC)){
								?>
									<tbody>
										<tr>
											<td><?php 
											$jour = $row['jour'];
											$jour = str_split($jour,1);
											echo $jour[8].''.$jour[9].'/'.$jour[5].''.$jour[6].'/'.$jour[0].''.$jour[1].''.$jour[2].''.$jour[3].' à ' .$jour[11].''.$jour[12].':'.$jour[14].''.$jour[15];
											?></td>												
											<td><?php echo $row['nom'];?></td>									
											<td><?php echo $row['nom_medecin']; ?></td>
											<td><?php echo $row['specialite']; ?></td>									
											<td><a href='http://allobobo.alwaysdata.net/annulation.php?id_rdv=<?php echo $row['id'] ?>'>Annuler</td>							
										</tr>
							<?php
								}	
							}else {
							?>
								<tr style="text-align:center;">
									<td class="card-title">
										vous n'avez aucun rendez-vous
									<td>
								</tr>
					 <?php }?>
									</tbody>
								</table>
							</div>
							<!-- fin de l'onglet mes rendez-vous -->

							<!-- début de l'onglet hisorique -->

							<div class="tab-content" style="display:none">
								<h5 class="card-title">Historique de vos rendez-vous</h5>

								<table style="padding:10px;" class="table table-striped">
									<thead>
										<tr>
											<th scope="col">Jour/heure</th>
											<th scope="col">Nom</th>
											<th scope="col">Médecin</th>
											<th scope="col">Spécialité</th>
										</tr>
									</thead>
							<?php

							// récupérer historique des rendez-vous
							$requete5 = $bdd->query("SELECT COUNT(*) FROM rdv
							INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email='{$_SESSION['email_user']}'AND jour < NOW()");
							$requete6 = $bdd->query("SELECT jour, nom, nom_medecin, specialite FROM rdv
							INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email='{$_SESSION['email_user']}'AND jour < NOW() ORDER BY jour ASC");

							$nb_ancienrdv = $requete5->fetchColumn();

							if($nb_ancienrdv > 0) {
								
								while($row=$requete6->fetch(PDO::FETCH_ASSOC)){
							?>
									<tbody>
										<tr>
											<td><?php 
											$jour = $row['jour'];
											$jour = str_split($jour,1);
											echo $jour[8].''.$jour[9].'/'.$jour[5].''.$jour[6].'/'.$jour[0].''.$jour[1].''.$jour[2].''.$jour[3].' à ' .$jour[11].''.$jour[12].':'.$jour[14].''.$jour[15];
											?></td>									
											<td><?php echo $row['nom'];?></td>									
											<td><?php echo $row['nom_medecin']; ?></td>
											<td><?php echo $row['specialite']; ?></td>
													
										</tr>
										<?php
											}
										}else {
											?>
											<tr style="text-align:center;">
												<td class="card-title">
													vous n'avez aucun rendez-vous passés
												<td>

											</tr>
										<?php }?>
									</tbody>
								</table>
							</div>
							<!-- fin de l'onglet hisorique -->

							<!-- début de l'onglet service -->
							<div class="tab-content" style="display:none">

								<h5 class="card-title">Gestion du Web service</h5>
								
    							<p>Le service est actuellement : <strong><?php echo $etat; ?></strong></p>

    							<form action="api_service.php" method="post">
        							<button type="submit"><?php echo ($status == 'active') ? 'Désactiver' : 'Activer'; ?></button>
    							</form>

								<form style="text-align:left">

								<div class="form-group">
									<label for="text" style="color:black;font-family:Roboto"> Obtenir tous les rendez-vous </label>
									<input type="text" class="form-control" disabled="<?php echo $disabled;?>" value="<?php if(isset($newUrl))echo $newUrl;?>">
								</div>

								<div class="form-group">
									<label for="text" style="color:black;font-family:Roboto"> Obtenir les rendez-vous d'un patient </label>
									<input type="text" class="form-control" disabled="<?php echo $disabled; ?>" value="<?php if(isset($newUrl))echo $newUrl.'?email=xxx@xxx.xx'; ?>">
								</div>

								</form>

							</div>
							<!-- fin de l'onglet service -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
	<script>

		function openTab(x) {

			let contents = document.querySelectorAll(".tab-content");
			let btns = document.querySelectorAll("button");
			//let btns = document.querySelectorAll("a");
			for(let i=0; i<contents.length;i++) {
				contents[i].style.display ="none";
		//		btns[i].classList.remove("active");
			}
			//console.log(x);
			// tous les contenus sont display none
			contents[x].style.display ="block";
		//	btns[x].classList.add("active");

			/** Portion de code à supprimer après les tests  */

			if(x == 0) {
				let lien_actif_0 = document.getElementById('lien_actif0').classList.add("active");
				let lien_actif_1 = document.getElementById('lien_actif1').classList.remove("active");
				let lien_actif_2 = document.getElementById('lien_actif2').classList.remove("active");
				let lien_actif_3 = document.getElementById('lien_actif3').classList.remove("active");
			}
			if(x == 1) {
				let lien_actif_0 = document.getElementById('lien_actif0').classList.remove("active");
				let lien_actif_1 = document.getElementById('lien_actif1').classList.add("active");
				let lien_actif_2 = document.getElementById('lien_actif2').classList.remove("active");
				let lien_actif_3 = document.getElementById('lien_actif3').classList.remove("active");
			}
			if(x == 2) {
				let lien_actif_0 = document.getElementById('lien_actif0').classList.remove("active");
				let lien_actif_1 = document.getElementById('lien_actif1').classList.remove("active");
				let lien_actif_2 = document.getElementById('lien_actif2').classList.add("active");
				let lien_actif_3 = document.getElementById('lien_actif3').classList.remove("active");
			}
			if(x == 3) {
				let lien_actif_0 = document.getElementById('lien_actif0').classList.remove("active");
				let lien_actif_1 = document.getElementById('lien_actif1').classList.remove("active");
				let lien_actif_2 = document.getElementById('lien_actif2').classList.remove("active");
				let lien_actif_3 = document.getElementById('lien_actif3').classList.add("active");
			}
		}
		
	</script>
	
</html>


<?php

}else{
	header('Location: connexion.php');
}
?>