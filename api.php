<?php

/** Gerer les requettes Http */

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include('ApiRendezvous.php');

$rdv = new ApiRendezvous();
$stmt = $rdv->read();
$num = count($stmt);

if($num > 0) {
    $rdv_arr = array();
    $rdv_arr["records"] = array();

    foreach ($stmt as $key=> $value) {
        //var_dump($value);
        extract($value);

        $rdv_item = array(
            "id" => $id,
            "jour" => $jour,
            "nom" => $nom,
            "email" => $email
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

?>