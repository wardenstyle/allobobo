<?php 
/**
 * Calendrier version: fullcalendar-6.1.13
 * PHP : Restitution de données
 * Conversion en données JSON
 * 
 */
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
//var_dump($_SESSION);
if(isset($_SESSION['type_compte']) && $_SESSION['type_compte']=='MDC') {

    include('allobobo_bdd.php');

    /**récupérer les rendez-vous du médecin */

    $requete = $bdd->query("SELECT * FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
    WHERE code_user='{$_SESSION['code']}'");

    /** récupérer le nombre de rendez-vous */

    $requete1 = $bdd->query("SELECT COUNT(*) FROM rdv INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin 
    WHERE code_user='{$_SESSION['code']}'");

    /**récuperer le dernier enregistrement */

    $requete2 = $bdd->query("SELECT * FROM rdv 
    INNER JOIN medecin ON medecin.id_medecin = rdv.id_medecin
    WHERE id = (SELECT MAX(id) FROM rdv) AND code_user='{$_SESSION['code']}'");
  
    $nb_rdv = $requete1->fetchColumn();
    $derniereligne= $requete2->fetch();
    $resultat = $requete->fetchAll();
    $i=0;
    echo "<input type='hidden' style='display:none' id='nb_rdv' value='$nb_rdv'>";

      /**Encodage du dernière enregistrement */
    
    $time = $derniereligne['jour'];
    if($time == null) { $time= date('Y-m-j H:i:s');}
    $time_end = strtotime("+15 minutes", strtotime($time));
    $fin_consultation = date('Y-m-j H:i:s', $time_end);
    $json1 = array();
    $json1['event_id']=$derniereligne['id'];
    $json1['title'] = $derniereligne['nom_medecin'].'-'.$derniereligne['nom'];
    $json1['start'] = $time;
    $json1['end'] = $fin_consultation;
    $json1['url'] = 'http://allobobo.alwaysdata.net/annulation.php?id_rdv='.$derniereligne['id'];
    $tab2 = json_encode($json1);

    echo "<input type='hidden' style='display:none' id='derniereligne' value='$tab2'>";

    /**
     * Encodage de tous les autres enregistrement
     * la date de fin = date du jour + 15 minutes 
     * */

    foreach($resultat as $key=>$value) 
    {
    $i++;
    $selectedTime = $value['jour'];
    $endTime = strtotime("+15 minutes", strtotime($selectedTime));
    $date_fin = date('Y-m-j H:i:s', $endTime);
    
        $json = array();
        $json['event_id']=$value['id'];
        $json['title'] = $value['nom_medecin'].'-'.$value['nom'];
        $json['start'] = $selectedTime;
        $json['end'] = $date_fin;
        $json['url'] = 'http://allobobo.alwaysdata.net/annulation.php?id_rdv='.$value['id'];
        $tab = json_encode($json);
        //echo $i;
    
        echo "<input type='hidden' style='display:none' id='ma$i'value='$tab'>";
    }
    ?>

<!DOCTYPE html>
       
       <html lang='en'>
         <head>
           <meta charset='utf-8' />
           <script  type="text/javascript" src='fullcalendar-6.1.13/dist/index.global.min.js'></script>
           <title> Agenda </title>
       
           <!-- bootstrap-->
           <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
           <!-- les polices -->
           <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&display=swap" rel="stylesheet">
           <!--le slider -->
           <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
           <!--les styles -->
           <link href="css/font-awesome.min.css" rel="stylesheet" />
           <link href="css/style.css" rel="stylesheet" />
           <link href="css/responsive.css" rel="stylesheet" />
         </head>
       
         <style>
       
         body {
           /**margin: 40px 10px;*/
           padding: 0;
           font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
           font-size: 14px;
           
         }
       
         #calendar {
           max-width: 1100px;
           margin: 0 auto;
           background-color:white;
         }
       
       </style>
        
       <script>
       
       var i =0;
       var nb_rdv = document.getElementById('nb_rdv').value;
       var derniereligne = document.getElementById('derniereligne').value;
       
       for(i=1,t=[];i<nb_rdv;i++)
       {   
           t.push(document.getElementById('ma'+i).value);
       
       }
       t.push(derniereligne);
       
       let result = t.map(jsonString => JSON.parse(jsonString));
       
       console.log(result);
       
       document.addEventListener('DOMContentLoaded', function() {
           var calendarEl = document.getElementById('calendar');
       
           var calendar = new FullCalendar.Calendar(calendarEl, {
       
             headerToolbar: {
               left: 'prev,next today',
               center: 'title',
               right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
             },
       
             // customize the button names,
             // otherwise they'd all just say "list"
             views: {
               listDay: { buttonText: 'Jour' },
               listWeek: { buttonText: 'Semaine' }
           
             },
       
             initialDate: '2024-05-16',
             navLinks: true, // can click day/week names to navigate views
             businessHours: true, // display business hours
             editable: true,
             selectable: true,
             events: result
         
           });
        
           calendar.render();
         });
       
       </script>
       
         <body>
         <div class="hero_area">
         <div class="hero_bg_box">
             <img src="images/hero-bg.png" alt="">
           </div>
                 <!-- Navigation -->
       
                 <header class="header_section">
                 <div class="container">
                   <nav class="navbar navbar-expand-lg custom_nav-container ">
                     <a class="navbar-brand" href="index.php">
                       <span>
                         AlloBobo
                       </span>
                     </a>
       
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                       <span class=""> </span>
                     </button>
       
                     <div class="collapse navbar-collapse" id="navbarSupportedContent">
                       <ul class="navbar-nav">
                       <li class="nav-item">
                           <a class="btn btn-primary" href="espacemedecin.php"> Retour</a>
                         </li>
                         <li class="nav-item active">
                           <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                         </li>
       
                         <li class="nav-item">
                           <a class="nav-link" href="medecin.php">Médecins</a>
                         </li>
                         <li class="nav-item">
                           <a class="nav-link" href="rdv.php">Prendre rendez-vous</a>
                         </li>
                         <li class="nav-item">
                           <?php if(isset($_SESSION['email_user'])) { 
                           ?><a class="nav-link" href="espacemedecin.php">Espace personnel</a>
                           <?php }else{ 
                           ?><a class="nav-link" href="connexion.php">se connecter</a>
                           <?php } ?>
                         </li>
                         <form class="form-inline">
                           <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                             <i class="fa fa-search" aria-hidden="true"></i>
                           </button>
                         </form>
                       </ul>
                     </div>
                   </nav>
               </div>
           </header>
                       <div id="calendrier">
                               <div id='calendar'></div>
                               
                       </div>
           </div>
               <?php include('mes_script.php') ?>
         </body>
       
       </html>
<?php
}else{

    echo 'error 403 forbidden';
}
?>