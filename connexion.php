<?php
session_start();
require_once 'database/database_load.php';
$html_gen =  new HtmlGenerator();

// Vérifiez si l'utilisateur est déjà connecté
if (isset($_SESSION['email_user'])) {
    if ($_SESSION['type_compte'] == 'PAT' || $_SESSION['type_compte'] == 'ADM') {
        header("Location: espaceclient.php");
    } else {
        header("Location: espacemedecin.php");
    }
    exit(); // Arret du script après la redirection
}

if (isset($_POST['submit'])) {
    $validation = true;
    $email_user = trim($_POST['email_user']);
    $mdp = trim($_POST['mdp']);

    // verification formulaire
    if (!filter_var($email_user, FILTER_VALIDATE_EMAIL)) {
        $validation = false;
        $erreur_pass = "*Veuillez indiquer votre adresse Email";
    }

    if (empty($mdp)) {
        $validation = false;
        $erreur_mdp = "*Veuillez indiquer votre mot de passe";
    }

    if ($validation) {
        try {
            // requête SQL pour vérifier que le mot de passe et l'adresse email correspondent
            include('allobobo_bdd.php');
            $requser = $bdd->prepare("SELECT * FROM user WHERE email_user = ? AND mdp = ?");
            $requser->execute(array($email_user, md5($mdp)));
            $userexist = $requser->rowCount();

            if ($userexist == 1) {
                $userinfo = $requser->fetch();
                $_SESSION['email_user'] = $userinfo['email_user'];
                $_SESSION['type_compte'] = $userinfo['type_compte'];
                if ($userinfo['type_compte'] == 'PAT' || $userinfo['type_compte'] == 'ADM') {
                    $_SESSION['type_compte'] = $userinfo['type_compte'];
                    header("Location: espaceclient.php");
                } else {
                    // récupérer le code_user du médecin
                    $_SESSION['code'] = $userinfo['code'];
                    header("Location: espacemedecin.php");
                }
                exit();
            } else {
                $erreur1 = "* Adresse email ou mot de passe incorrect ";
            }
        } catch (PDOException $e) {
            error_log("Erreur lors de la connexion utilisateur : " . $e->getMessage());
            header('Location: erreur.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <?php include('header.php') ?>
    <style>
        h4,label,button { color: white; font-family: 'Roboto'; }
        .erreur_text { color: white; font-family: 'Roboto';text-align:center; }
        #form {
            display: flex;
            flex-direction: column;
            align-items: start;
            border: solid;
            color: white;
            padding: 10px;
            text-align: justify;
        }
        .generate-form {color: white; padding: 10px;}

    </style>

    <body>
        <div class="hero_area">
            <div class="hero_bg_box">
                <img src="images/hero-bg-sas.png" alt="">
            </div>
            <!-- navigation section -->
            <?php 

            include('navigation.php');      
            $html_gen->add_begin_div(array('class_name'=>'container mt-5'));
            $html_gen->add_begin_div(array('class_name'=>'row justify-content-center'));
            $html_gen->add_begin_div(array('class_name'=>'col-md-8'));
            $html_gen->add_begin_form(array('title' => 'Connectez-vous' , "method" => 'post' , "action" => 'connexion.php' ));
            
            $html_gen->add_begin_div(array('class_name'=>'form-group'));
            $html_gen->add_input(array(
                'name' => 'email_user', 
                'label' => "Adresse email: ", 
                'placeholder' =>"admin@allobobo.fr" , 
                "mandatory" => true ,
                'label-align' => 'left'
            ));
            $html_gen->add_end_div(array());
            $html_gen->add_begin_div(array('class_name'=>'form-group'));
            $html_gen->add_input(array(
                'name' => 'mdp', 
                'label' => "Mot de passe: ",
                'type'=>'password', 
                'placeholder' =>"admin" , 
                "mandatory" => true ,
                'label-align' => 'left'
            ));
            $html_gen->add_end_div(array());
            $html_gen->add_button(array('class'=>'btn btn-outline-dark','type'=>'submit','name'=>'submit','style'=>'color:white','value' =>'se connecter'));
            $html_gen->add_end_form(array());
            $html_gen->add_end_div(array());
            $html_gen->add_end_div(array());
            $html_gen->add_end_div(array()); 
            $html_gen->auto_div = false;
            $html_gen->generate();
            echo "<center><h4>Vous n'avez pas de compte ? <a class='btn btn-dark' href='inscription.php'>s'inscrire</a></h4></center>";
            if(isset($erreur_pass)) echo '<p class="erreur_text">' . $erreur_pass . '</p>';
            if(isset($erreur_mdp)) echo '<p class="erreur_text">' . $erreur_mdp . '</p>';
            if(isset($erreur1)) echo '<p class="erreur_text">' . $erreur1 . '</p>';
            ?>
        </div>
    </body>
</html>

<!-- jQery & js scripts section -->
	  <?php include('mes_script.php')?>
<!-- jQery & js scripts section--> 

				