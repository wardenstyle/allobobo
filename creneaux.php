<?php 

/**
 * Dernière modification 24/05/2024
 * Php: Script de vérification des créneaux horaires pour la disponibilité des médecins
 * 
 * */

 if(isset($_POST)){

    $date= $_POST['date'];
    $id_medecin= $_POST['id_medecin'];
 
    include('allobobo_bdd.php');

	$reqdate = $bdd->prepare("SELECT jour FROM rdv WHERE jour =? AND id_medecin =?");
	$reqdate->execute(array($date, $id_medecin));									
	$date_result = $reqdate->rowCount();
						
	if($date_result != 0) {		
	 	echo 'Médecin non disponible à cet horaire';
						
	 }else{
		echo "Médecin disponible à cet horaire";
	 }
}

?>