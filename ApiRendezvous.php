<?php
    class ApiRendezvous {

        /** fonction de lecture */
        public function read() {
        include('allobobo_bdd.php');

            $query = "SELECT id, jour, nom, email FROM rdv";
            $requete = $bdd->query($query);
            $rdv = $requete->fetchAll();
            return $rdv;

        }

    }
    



    

?>
