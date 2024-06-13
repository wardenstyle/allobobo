<?php

session_start();

if (isset($_SESSION['email_user'])) {
    if (isset($_SESSION['type_compte'])) {
        // Habilitation en fonction du type de compte
        if ($_SESSION['type_compte'] == 'MDC') {
            $lien = 'espacemedecin.php';
        } elseif ($_SESSION['type_compte'] == 'PAT' || $_SESSION['type_compte'] == 'ADM') {
            $lien = 'espaceclient.php';
        }
    }

    include('allobobo_bdd.php');

    // Vérification si 'id_rdv' est défini dans $_GET
    if (isset($_GET['id_rdv'])) {
        $sql = "DELETE FROM rdv WHERE id = :id";
        $statement = $bdd->prepare($sql);
        $statement->bindParam(':id', $_GET['id_rdv'], PDO::PARAM_INT);
        
        if ($statement->execute()) {
            $message = "Annulation prise en compte.";
        } else {
            $message = "Erreur lors de l'annulation.";
        }
    } else {
        $message = "ID de rendez-vous non spécifié.";
    }
} else {
    header('Location: index.php');
    exit;
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
		<h4><?php echo $message.' à très bientot'; ?></h4>
		<a href="<?php echo $lien;?>" class="btn btn-primary">Retour</a>
		</center>
	</div>
	</body>