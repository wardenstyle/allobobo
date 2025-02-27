<?php

/**
 * Page d'inscription
 * PHP : Vérification de IHM de saisi
 * Html : Formulaire d'inscription
 * Dernière modification 02/06/2024
 * 
 * @todo encrypter le mot de passe ligne 64
 */
/**
 * inclusion des outils
 */
require_once 'database/database_load.php';
$html_gen =  new HtmlGenerator();

/** Initialisation des variables */
$connexion = false;
$nom = $email = $password = "";
$erreur_pass = $erreur_nom = $erreur_email = $erreur_repeat = $erreur = "";

/** Traitement des saisies */
if(isset($_POST['submit'])){

	$validation = true;

	$nom = trim($_POST['nom']);
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$repeatpassword = trim($_POST['repeatpassword']);
			
	if(empty($nom)){
		$validation = false;
		$erreur_nom = "* Indiquez votre nom";
	}

	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		$validation = false;
		$erreur_email = "*Indiquez votre adresse e-mail";				
	}

	if(empty($password)){
		$validation = false;
		$erreur_pass = "* Mot de passe entre 6 et 8 caractères";
	}
				
	if(strlen($password) < 6 ){
		$validation = false;
		$erreur_pass = "* Mot de passe entre 6 et 8 caractères";
	}

	if($password != $repeatpassword) {
		$validation = false;
		$erreur_repeat ="*Les mots de passes ne correspondent pas";
			
	}
    
	try {

        include('allobobo_bdd.php');
        $reqmail = $bdd->prepare("SELECT * FROM user WHERE email_user =?");
        $reqmail->execute(array($email));// requete pour empecher d'entrée deux fois la meme adresse email
        $mailexiste = $reqmail->rowCount();
                        
        if($mailexiste != 0) {
            $validation = false;
            $erreur ="Adresse émail déja utilisé";						
        }

    } catch(PDOException $e) {
        
        error_log("Erreur lors de la vérification de l'adresse email : " . $e->getMessage());
        header('Location: erreur.php');
        exit();
    }	
	
	if($validation){
		$password = md5($password);
        
        try {
            include('allobobo_bdd.php');
		    $req = $bdd->prepare('INSERT INTO user (nom_user,email_user,mdp,type_compte) VALUES (:nom_user,:email_user,:mdp,:type_compte)');
            //execution de la requete sql prepare
		    $req->execute(array(
				'nom_user' => $nom,
				'email_user' => $email,
				'mdp' => $password,
                'type_compte' => 'PAT'
								
		    ));
		    $req->closeCursor();

        } catch (PDOException $e) {
            error_log("Erreur lors de l'inscription de l'utilisateur : " . $e->getMessage());
            header('Location: erreur.php');
            exit();
        }		
	}		
			
}

echo "<!DOCTYPE html><html><head>";
include('header.php'); //head

echo 
"<link href='css/inscription.css' rel='stylesheet'></head>
<body><div class='hero_area'><div class='hero_bg_box'><img src='images/hero-bg.png' alt=''></div>";
//navigation section
include('navigation.php');


if ((isset($validation)) && ($validation == true)) { 
            
    $html_gen->add_title(array('title'=>'Votre compte a été créé, vous pouvez vous connectez.','level'=>'3','class'=>'title_cp'));
    $connexion = true;
            
} else { 
 
    $html_gen->add_begin_div(array('class_name'=>'container mt-5'));
    $html_gen->add_begin_div(array('row justify-content-center'));
    $html_gen->add_begin_div(array('col-md-8'));

    $html_gen->add_begin_form(array('title' => 'Inscrivez-vous' , "method" => 'post' , "action" => 'inscription.php' ));
    $html_gen->add_begin_div(array('class_name'=>'form-group'));
    $html_gen->add_input(array(
                'name' => 'nom', 
                'label' => "Nom: ",
                'type'=>'text', 
                'placeholder' =>"" , 
                "mandatory" => true ,
                'label-align' => 'left',
                'value' => htmlspecialchars($nom) // Préserve la valeur saisie
    ));
    $html_gen->add_end_div(array());

    $html_gen->add_begin_div(array('class_name'=>'form-group'));
    $html_gen->add_input(array(
        'name' => 'email', 
        'label' => "Adresse email: ",
        'type'=>'text', 
        'placeholder' =>"" , 
        "mandatory" => true ,
        'newline' =>false,
        'label-align' => 'left',
        'value' => htmlspecialchars($email), // Préserve la valeur saisie
        'onchange' => 'verifier_email()',
        'onkeyup' => 'verifier_email()',
    ));
    $html_gen->add_end_div(array());
    $html_gen->add_begin_div(array('id'=>'resultat'));
    $html_gen->add_end_div(array());

    $html_gen->add_begin_div(array('class_name'=>'form-group'));
    $html_gen->add_input(array(
        'name' => 'password', 
        'label' => "Mot de passe: ",
        'type'=>'password', 
        'placeholder' =>"" , 
        "mandatory" => true ,
        'label-align' => 'left',
        'value' => htmlspecialchars($password), // Préserve la valeur saisie
        'onchange' => 'verifier_mdp()',
        'onkeyup' => 'verifier_mdp()',
    ));
    $html_gen->add_end_div(array());

    $html_gen->add_begin_div(array('class_name'=>'form-group'));
    $html_gen->add_input(array(
        'name' => 'repeatpassword', 
        'label' => "Confirmation du mot de passe: ",
        'type'=>'password', 
        'placeholder' =>"" , 
        "mandatory" => true ,
        'label-align' => 'left',
        'value' => htmlspecialchars($password),
        'onchange' => 'verifier_mdp()',
        'onkeyup' => 'verifier_mdp()',
    ));
    $html_gen->add_end_div(array());

    $html_gen->add_begin_div(array('id'=>'resultat2'));
    $html_gen->add_end_div(array());
    $html_gen->add_button(array('class'=>'btn btn-primary','type'=>'submit','name'=>'submit','style'=>'color:white','value' =>'Validez'));
    $html_gen->add_end_form(array());
    
    $html_gen->add_end_div(array());
    $html_gen->add_end_div(array());
    $html_gen->add_end_div(array());

    } 

    $html_gen->auto_div = false;
    $html_gen->generate();

    if (isset($erreur_pass)) echo "<p class='erreur_text'>" . $erreur_pass . "</p>";
    if (isset($erreur_nom)) echo '<p class="erreur_text">' . $erreur_nom . '</p>';
    if (isset($erreur_email)) echo "<p class='erreur_text'>" . $erreur_email . "</p>";
    if (isset($erreur_repeat)) echo '<p class="erreur_text">' . $erreur_repeat . '</p>';
    if (isset($erreur)) echo '<p class="erreur_text">' . $erreur . '</p>'; 
    if($connexion) echo "<center><a class='btn btn-primary' href='connexion.php' id='lien_retour'>Se connecter</a></center>";
    

    echo "</div></body>
    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
    <script type='text/javascript' src='monajax.js'></script>
    </html>"; // Lien vers le JS de Bootstrap et ses dépendances 
?>
