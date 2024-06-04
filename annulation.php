<?php

session_start();

if(isset($_SESSION['email_user'])){

	include('allobobo_bdd.php');

	$sql = "DELETE FROM rdv WHERE id =:id";
	$statement =$bdd->prepare($sql);
	$statement->bindParam(':id', $_GET['id_rdv'],PDO::PARAM_INT);
	if($statement->execute()) {
		echo "annulation prise en compte.";
   }
}else{
	header('Location: index.php');
}

?>

<!doctype html>
<html>
<?php include('header.php') ?>
	
	<style>
		h4{color:white;font-family:'Roboto';}	
	</style>
	
	<body>
	<div class="hero_area">

		<div class="hero_bg_box">
		<img src="images/hero-bg-sas.png" alt="">
		</div>

			<!-- navigation section  -->
			<?php include('navigation.php') ?>
			<!-- navigation section -->
		<center>
		<h4>Votre rendez-vous à bien été annulé. a très bientôt !</h4>
		<a href="espaceclient.php" class="btn btn-primary">Retourner dans votre espace</a>
		</center>
	</div>
	</body>