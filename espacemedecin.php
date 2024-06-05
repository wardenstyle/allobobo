<?php

/**
 * Espace medecin
 * Page de consultation
 * PHP : Restitution de données
 * Html : Tableau de présentation
 * Dernière modification 04/06/2024
 */
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
//var_dump($_SESSION);
if(isset($_SESSION['type_compte']) && $_SESSION['type_compte']=='MDC') {

    if(isset($_SESSION['email_user'])){
        include('allobobo_bdd.php');
        // récupérer les info du médecin
        $requete4 = $bdd->query(
        "SELECT * FROM user INNER JOIN medecin ON user.code = medecin.code_user WHERE medecin.code_user='{$_SESSION['code']}'");
        $nom = $requete4->fetch();
        
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
                                    <button class="nav-link" id="lien_actif1" onclick="openTab(1)">Mes Consultations</button>
                                </li>
                                <li class="nav-item">
                                    <button class="nav-link" id="lien_actif2" onclick="openTab(2)">Mes patients</button>
                                </li>
                                </ul>
                            </div>

                            <div class="card-body">

                                <!-- Début du contenu de l'onglet mon Compte -->
                                <div class="tab-content" style="display:block">
                                    <h5 class="card-title">Bonjour <?php echo ' '.$nom['nom_user'].', '?></h5>
                                    <div class="border" style="color:gray">
                                    <span><?php echo $nom['specialite']; ?><img src="<?php echo $nom['image']; ?>" width="25%"><span>
                                    <a href="deco.php" class="btn btn-dark">Se déconnecter</a>
                                    <a href="agenda_medecin.php" title="Planning" class="btn btn-primary">Mon planning</a>
                                    </div>
                                    <br/>
                                    <p class="card-text">Voici vos consultations à venir</p>
                                    <table style="padding:10px;" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Jour/heure</th>
                                                <th scope="col">Patient</th>
                                                <th scope="col">Annulation</th>	
                                            </tr>
                                        </thead>
                                <?php 
                    
                                // récupérer les rendez-vous à venir avec une pagination

                                $ligne_par_page=6;

                                $requete2 = $bdd->query(
                                "SELECT COUNT(*) FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
                                WHERE code_user='{$_SESSION['code']}'
                                AND jour > NOW()");
                                $nb_rdv = $requete2->fetchColumn();
                                $total = $nb_rdv;

                                /**
                                 * Pagination
                                 * affichage ligne 152
                                 * fonction ceil récupere le nombre supérieur en cas de nombre à virgule
                                 */
                                
                                $nombreDePages=ceil($total/$ligne_par_page);

                                if(isset($_GET['page'])) {
                                    $pageActuelle=intval($_GET['page']);
                                     if($pageActuelle>$nombreDePages){	 
                                          $pageActuelle=$nombreDePages;
                                     }
                                }else{
                                     $pageActuelle=1;
                                }
  
                                $premiereEntree=($pageActuelle-1)*$ligne_par_page;

                                $requete = $bdd->query(
                                "SELECT * FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
                                WHERE code_user='{$_SESSION['code']}' AND jour > NOW() ORDER BY jour ASC LIMIT $premiereEntree,$ligne_par_page");
                                
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
                                <?php /** Pagination */
                                    for($i=1; $i<=$nombreDePages; $i++){
                                        if($i==$pageActuelle){				//Si il s'agit de la page actuelle...
                                            echo ' [ '.$i.' ] ';																		
                                        }else{ 													   
                                            echo ' <a href="espacemedecin.php?page='.$i.'">'.$i.'</a> ';
                                        }
                                    }
                                ?>

                                </div>

                                <!-- fin  de l'onglet mon compte -->

                                <!-- Début de l'onglet consultation du jour -->
                                <div class="tab-content" style="display:none">
                                    <h5 class="card-title">Consultation du jour</h5>			
                                <?php 

                                    $requete8 = $bdd->query(
                                    "SELECT COUNT(*) FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
                                    WHERE code_user='{$_SESSION['code']}' AND jour BETWEEN NOW()- INTERVAL 1 DAY AND NOW()+ INTERVAL 1 DAY");
                                    $nb_consultation = $requete8->fetchColumn();
                                    $requete7 = $bdd->query(
                                    "SELECT * FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
                                    WHERE code_user='{$_SESSION['code']}' AND jour BETWEEN NOW()- INTERVAL 1 DAY AND NOW()+ INTERVAL 1 DAY");
                                
                                ?>
                                    <table style="padding:10px;" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Jour/heure</th>
                                                <th scope="col">Patient</th>
                                                <th scope="col">Annulation</th>	
                                            </tr>
                                        </thead>
                                    <?php 
                                    if($nb_consultation > 0) {

                                        while($row=$requete7->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?php 
                                                        $jour = $row['jour'];
                                                        $jour = str_split($jour,1);
                                                        echo $jour[8].''.$jour[9].'/'.$jour[5].''.$jour[6].'/'.$jour[0].''.$jour[1].''.$jour[2].''.$jour[3].' à ' .$jour[11].''.$jour[12].':'.$jour[14].''.$jour[15];
                                                        ?></td>												
                                                        <td><?php echo $row['nom'];?></td>																	
                                                        <td><a href='http://allobobo.alwaysdata.net/annulation.php?id_rdv=<?php echo $row['id'] ?>'>Annuler</td>							
                                                    </tr>
                                        <?php
                                            }	
                                        }else {
                                        ?>
                                            <tr style="text-align:center;">
                                                <td class="card-title">
                                                    vous n'avez aucun rendez-vous aujourd'hui
                                                <td>
                                            </tr>
                                <?php }?>
                                                </tbody>
                                            </table>


                                </div>
                                <!-- fin de l'onglet consultation du jour -->

                                <?php 
                                    // récupérer le nombre de patient

                                    $requete5 = $bdd->query("SELECT COUNT(*) 
                                    FROM (SELECT DISTINCT nom FROM rdv INNER JOIN medecin ON rdv.id_medecin = medecin.id_medecin
                                    WHERE medecin.code_user='{$_SESSION['code']}') AS distinct_noms");

                                    $nb_patient = $requete5->fetchColumn();
                                ?>
                                <div class="tab-content">
                                    <h5 class="card-title">Mes patients<span><?php echo ' ('.$nb_patient.')';?> </span></h5>

                                    <table style="padding:10px;" class="table table-striped">
                                        <thead>
                                            <tr>

                                                <th scope="col">Nom</th>
                                                <th scope="col">Age (info non disponible)</th>

                                            </tr>
                                        </thead>
                                <?php

                                // récupérer mes patients

                                $requete6 = $bdd->query("SELECT DISTINCT nom 
                                FROM rdv INNER JOIN medecin ON rdv.id_medecin = medecin.id_medecin
                                WHERE medecin.code_user='{$_SESSION['code']}'");  
                           
                                if($nb_patient > 0) {
                                    
                                    foreach($requete6 as $key => $value){
                                ?>
                                        <tbody>
								
                                                <td><?php echo $value['nom'];?></td>									
                                                <td>--</td>
                                                        
                                            </tr>
                                            <?php
                                                }
                                }else {
                                            ?>
                                                <tr style="text-align:center;">
                                                    <td class="card-title">
                                                        vous n'avez pas encore de patient
                                                    <td>

                                                </tr>
                                <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- fin de l'onglet hisorique -->
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
                    //btns[i].classList.remove("active");
                }
                //console.log(x);
                // tous les contenus sont display none
                contents[x].style.display ="block";
                //btns[x].classList.add("active");

                if(x == 0) {
                    let lien_actif_0 = document.getElementById('lien_actif0').classList.add("active");
                    let lien_actif_1 = document.getElementById('lien_actif1').classList.remove("active");
                    let lien_actif_2 = document.getElementById('lien_actif2').classList.remove("active");
                }
                if(x == 1) {
                    let lien_actif_0 = document.getElementById('lien_actif0').classList.remove("active");
                    let lien_actif_1 = document.getElementById('lien_actif1').classList.add("active");
                    let lien_actif_2 = document.getElementById('lien_actif2').classList.remove("active");
                }
                if(x == 2) {
                    let lien_actif_0 = document.getElementById('lien_actif0').classList.remove("active");
                    let lien_actif_1 = document.getElementById('lien_actif1').classList.remove("active");
                    let lien_actif_2 = document.getElementById('lien_actif2').classList.add("active");
                }
            }
            
        </script>
        
    </html>

    <?php

    }else{
        header('Location: connexion.php');
    }
}else{
    echo 'error 403 forbidden';
}
?>