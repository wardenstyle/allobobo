<?php 

/** Rédiriger administrateur vers la page admin  */

// obtenir l'adresse courante de la page  */
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Obtenir le nom de domaine
$domainName = $_SERVER['HTTP_HOST'];

// Obtenir le chemin de la requête
$requestUri = $_SERVER['REQUEST_URI'];

// Construire l'URL complète
$currentUrl = $protocol . $domainName . $requestUri;

$urlAdmin = str_replace('/erreur.php', '/admin.php', $currentUrl);
/** fin du remplacement  */

?>

<!DOCTYPE html>
<html lang="fr">

<?php include('header.php') ?>

<body>

    <div class="hero_area">

            <div class="hero_bg_box">
                <img src="images/hero-bg-404.png" alt="">
            </div>

                <!-- navigation section -->
                <?php include('navigation.php') ?>
                <!-- navigation section -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h3 style="color:white;font-family:Roboto">Site temporairement inaccessible</h3>
                        <p style="color:white;font-family:Roboto">Nous sommes désolés, mais le site rencontre actuellement des problèmes techniques.
                        Veuillez réessayer ultérieurement.</p><small style="color:white">êtes-vous un administrateur du site ? c'est par <a href="<?php echo $urlAdmin;?>">ici</a> </small> 
                </div>
            </div>  
        </div>
    </div>

</body>

  <!-- jQery & js scripts section -->
  <?php include('mes_script.php') ?>
  <!-- jQery & js scripts section--> 

</html>