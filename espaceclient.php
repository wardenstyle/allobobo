<?php

/**
 * Espace client
 * Page de consultation
 * PHP : Restitution de données
 * Html : Tableau de présentation
 * Dernière modification 21/05/2024
 * fichier ajouté sur git
 */
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
if(isset($_SESSION['email_user'])){
	include('allobobo_bdd.php');
	$requete4 = $bdd->query("SELECT * FROM user WHERE email_user='{$_SESSION['email_user']}'");
	$nom = $requete4->fetch();
	
?><!doctype html>
<html>

	<?php include('header.php') ?>
	
	<style>

		td, h3, h4{color:white;font-family:'Roboto';}
		table{ color:white;}	
	</style>
	
<body>

  <div class="hero_area">

    <div class="hero_bg_box">
      <img src="images/hero-bg.png" alt="">
    </div>

    <!-- navigation section  -->
    <?php include('navigation.php') ?>
    <!-- navigation section -->

	<center>
		<br />	
		
		<h4>Bonjour <?php echo ' '.$nom['nom_user'].', '?>bienvenue dans votre espace personnel</h4>
		<img src="images/classeur.jpg">
	<table>
	<tr>			
		<td><a href="deco.php"><input type="submit" value="Se déconnecter" /></a></td>
		<td><a href="rdv.php" ><input type="submit" value="Prendre rendez-vous" /></a></td>
		<td><a href="agenda.php" ><input type="submit" value="Consulter le planning" /></a></td>
	</tr>
	</table>
	<br />
	<br />
	<h3>Vos prochain rendez-vous</h3>
	
	<table style="width:50%;border: solid;color:white;padding:10px;">
		<tr>
			<td>Jour/heure</td>
			<td>Nom</td>
			<td>Médecin</td>
			<td>Spécialité</td>
			<td>Annulation</td>	
		</tr>
		
		<?php 
		
		// récupérer les rendez-vous à venir
		
		$requete = $bdd->query("SELECT * FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email='{$_SESSION['email_user']}' AND jour > NOW()");
		$requete2 = $bdd->query("SELECT COUNT(*) FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email='{$_SESSION['email_user']}'AND jour > NOW()");

		$nb_rdv = $requete2->fetchColumn();

		// affichage des données

		if($nb_rdv > 0) {
			while($row=$requete->fetch(PDO::FETCH_ASSOC)){
			?>
			<tr>
				<td><?php 
				$jour = $row['jour'];
				$jour = str_split($jour,1);
				echo $jour[8].''.$jour[9].'/'.$jour[5].''.$jour[6].'/'.$jour[0].''.$jour[1].''.$jour[2].''.$jour[3].' à ' .$jour[11].''.$jour[12].':'.$jour[14].''.$jour[15];
				?></td>
							
				<td><?php echo $row['nom'];?></td>
				
				<td><?php echo $row['nom_medecin']; ?></td>

				<td><?php echo $row['specialite']; ?></td>
				
				<td><a class="btn btn-warning" href='http://allobobo.alwaysdata.net/annulation.php?id_rdv=<?php echo $row['id'] ?>'>Annuler</td>
			
			</tr>
			<?php
			}
		}else {
			?>
			<tr style="text-align:center;">
				<td>
					vous n'avez aucun rendez-vous
				<td>

			</tr>
		<?php }?>
			
	</table>

	<br />
	<br />

	<h3>Historique de vos rendez-vous</h3>

	<table style="width:50%;border: solid;color:white;padding:10px;">

		<tr>
			<td>Jour/heure</td>
			<td>Nom</td>
			<td>Médecin</td>
			<td>Spécialité</td>
		</tr>
	<?php

		// récupérer historique des rendez-vous
		$requete5 = $bdd->query("SELECT COUNT(*) FROM rdv
		INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email='{$_SESSION['email_user']}'AND jour < NOW()");
		$requete6 = $bdd->query("SELECT jour, nom, nom_medecin, specialite FROM rdv
		INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email='{$_SESSION['email_user']}'AND jour < NOW()");

		$nb_ancienrdv = $requete5->fetchColumn();

		if($nb_ancienrdv > 0) {
			
			while($row=$requete6->fetch(PDO::FETCH_ASSOC)){

	?>
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
				<td>
					vous n'avez aucun rendez-vous passés
				<td>

			</tr>
		<?php }?>

	</table>
	</center>
	</div>
	</body>
	<script>

</script>
	
</html>


<?php

}else{
	header('Location: connexion.php');
}
?>