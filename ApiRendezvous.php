<?php
    class ApiRendezvous {

        /** fonctions de lecture */

        /** Tous les rendez-vous */
        public function read() {

            include('allobobo_bdd.php');
            $query = "SELECT id, jour, nom, email, nom_medecin FROM rdv
            INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin";
            $requete = $bdd->prepare($query);
            if($requete->execute()) {
                return $requete;
            }else {
                printf("Erreur de la requête: %s.\n", $requete->errorInfo()[2]);
                return false;
            }

        }

        /** les rdv d'un patient */
        public function readByUser($email) {

            include('allobobo_bdd.php');
            $query = "SELECT id, jour, nom, email, nom_medecin FROM rdv 
            INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin WHERE email = '$email'";
            $requete = $bdd->prepare($query);
            $requete->bindParam(1, $email);
            if($requete->execute()) {
                return $requete;
            }else {
                printf("Erreur de la requête: %s.\n", $requete->errorInfo()[2]);
                return false;
            }

        }

        

    }
    



    

?>
