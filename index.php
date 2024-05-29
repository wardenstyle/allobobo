<?php 


?>
<!DOCTYPE html>
<html>

<?php include('header.php') ?>

<body>

  <div class="hero_area">

    <div class="hero_bg_box">
      <img src="images/hero-bg.png" alt="">
    </div>

    <!-- navigation section -->
    <?php include('navigation.php') ?>
    <!-- navigation section -->

    <!-- slider section -->
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Allobobo s'occupe de vous !
                    </h1>
                    <p>
                    Parce qu'il n'est pas toujours facile d'appeler à l'aide quand on a coincé son doigt dans la porte,
                    Un bobo? une rougeur? ne vous inquiétez pas. Chez AlloBoBo, on s'occupe de vous.
                    </p>
                    <div class="btn-box">
                      <a href="rdv.php" class="btn1">
                        Prendre rendez-vous
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7">
                  <div class="detail-box">
                    <h1>
                      Votre santé, Notre préocupation !
                    </h1>
                    <p>
                     Les urgences sont saturés ? un seul numéro à composer, AlloBobo répond à toutes vos questions. Vous pouvez prendre rapidement rendez-vous. n'attendez-plus.
                    </p>
                    <div class="btn-box">
                      <a href="rdv.php" class="btn1">
                        Prendre rendez-vous
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <ol class="carousel-indicators">
          <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
          <li data-target="#customCarousel1" data-slide-to="1"></li>
          <li data-target="#customCarousel1" data-slide-to="2"></li>
        </ol>
      </div>

    </section>
    <!-- end slider section -->
  </div>
  
  <!-- spécialités section -->
  <?php include('specialites.php') ?>
  <!-- spécialités section -->

  <!-- footer section -->
  <?php include('footer.php') ?>
  <!-- footer section -->

  <!-- jQery & js scripts section -->
  <?php include('mes_script.php') ?>
  <!-- jQery & js scripts section--> 

</body>

</html>