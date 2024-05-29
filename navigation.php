<?php
/**
 * Navigation
 * Html : barre de navigation
 * Dernière modification le 27/05/2024
 */
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

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
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="aproposdenous.php"> A propos de nous</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="medecin.php">Médecins</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="rdv.php">Prendre rendez-vous</a>
              </li>
              <li class="nav-item">
                <?php if(isset($_SESSION['email_user'])) { 
                ?><a class="nav-link" href="espaceclient.php">Espace personnel</a>
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