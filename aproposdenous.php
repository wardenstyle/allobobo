<?php 
/**
 * php :
 * html : pas de présentation
 * Dérnière modification le 28/05/2024
 */

?>
<!DOCTYPE html>
<html>

  <?php include('header.php') ?>

<body class="sub_page">

  <div class="hero_area">
 
    <!-- navigation section  -->
      <?php include('navigation.php') ?>
    <!-- navigation section -->

  </div>

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">
      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="images/cnam.jpg" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                à propos de  <span>Nous</span>
              </h2>
            </div>
            <p>
              Auditeur au CNAM de Lille pour l'année 2023 - 2024 j'ai réalisé ce site internet dans le cadre d'un TP.
              NFE114 Systèmes d'information web est la matière qui nous forme sur les technologies d'internet. Je tiens à remercier toute l'équipe pédagogique. à très bientôt. 
            </p>
            <a href="https://www.cnam-hauts-de-france.fr/">
              Read More
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- footer section -->
      <?php include('footer.php') ?>
  <!-- footer section -->

    <!-- script section  -->
      <?php include('mes_script.php') ?>
    <!-- script section -->

</body>

</html>