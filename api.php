<?php

/** Gerer les requettes Http */

/** controle sur l'activation du service */

include('allobobo_bdd.php');
$query = $bdd->query('SELECT status FROM service_status WHERE id = 1');
$status = $query->fetchColumn();

if($status == 'active') {

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include('ApiRendezvous.php');

    $rdv = new ApiRendezvous();

    $email = isset($_GET['email']) ? $_GET['email'] : null;
 
    // par défaut lecture de tous les rendez-vous
    if (!empty($email)) {

        $stmt = $rdv->readByUser($email);
        $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } else {

        $stmt = $rdv->read();
        $stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    }

    $num = count($stmt);

    if($num > 0) {
        $rdv_arr = array();
        $rdv_arr["records"] = array();

        foreach ($stmt as $key=> $value) {

            extract($value);

            $rdv_item = array(
                "id" => $id,
                "jour" => $jour,
                "nom" => $nom,
                "email" => $email,
                "nom_medecin" =>$nom_medecin
            );

            array_push($rdv_arr["records"], $rdv_item);
        }

        http_response_code(200);
        echo json_encode($rdv_arr);

    } else {

        http_response_code(404);
        echo json_encode(
            array("message" => "Aucun rendez-vous trouvé.")
    );
}

} else {
    header('HTTP/1.1 503 Service Unavailable');
    echo json_encode(['error' => 'Le service est indisponible.']);
    exit();
}



?>