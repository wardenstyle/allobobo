<?php 

/**
 * Médecin
 * Page de consultation
 * PHP : Restitution de données
 * Html : Tableau de présentation
 * Html : formulaire
 * Dernière modification 22/05/2024
 */

$a = "disabled"; // désactiver le bouton pour ajouter les médecins selon le profil
$compte_admin = "(compte admin requis)"; //ajouter un médecin selon le profil
include('allobobo_bdd.php');
$requete = $bdd->query("SELECT * FROM medecin ");

?>

<!DOCTYPE html>
<html>

<?php include('header.php') ?>

<body class="sub_page">

  <div class="hero_area">

    <div class="hero_bg_box">
      <img src="images/hero-bg.png" alt="">
    </div>

    <!-- navigation section  -->
    <?php include('navigation.php') ?>
    <!-- navigation section -->
  </div>

  <!-- docteur section -->

  <section class="doctor_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Nos Docteurs
        </h2>
            <p class="col-md-10 mx-auto px-0">
              La confiance est le critère principal chez AlloBobo. Un bobo ? une rougeur ? avec nos experts nous vous soignerons rapidement et dans les meilleurs conditions.
            </p>
      </div>                             
      <div class="row">
      <?php while( $row=$requete->fetch(PDO::FETCH_ASSOC)){ ?>
        <div class="col-sm-6 col-lg-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="<?php echo $row['image'];?>" alt="">
            </div>
            <div class="detail-box">
              <div class="social_box">
                <?php echo "<a href='mailto:allobobo@allobobo.fr'>".$row['email_medecin']."</a>" ?>
                <i class="fa fa-envelope" aria-hidden="true"></i>
                                        
              </div>
              <h5><?php echo $row['nom_medecin'];?></h5>
              <h6 class=""><?php echo $row['specialite'];?></h6>
            </div>
          </div>
        </div>
      <?php } ?>  
      </div>                       
    </div>
  </section>
 
  <!-- docteur section -->

  <!-- Formulaire section -->
  <?php  
    /** activation du bouton ajouter un médedin selon profil utilisateur */
        if($_SESSION['email_user'] == 'admin@allobobo.fr'){ 
            $a='enabled';$compte_admin =""; $lien="agenda.php"; 
        } else {$lien = ""; $message ='Vous devez vous être administrateur pour avoir accès aux options supplémentaires';}
        ?>
  <section class="department_section layout_padding">
    <div class="department_container">
      <div class="container ">
        <div class="heading_container heading_center">
        <h3><?php if(isset($message)){echo $message;}  ?></h3>
          <div class="row">
            <div class="col-md-3">
              <div class="box ">
                <div class="img-box">
                  <img src="images/s2.png" alt="">
                </div>
                <div class="detail-box">
                  <h5>
                  <a role ="link" href="<?php echo $lien; ?>">Planning</a>
                  </h5>
                  <p>
                  Consulter le planning des consultations.<span style="color:#a96f4b;"><?php echo $compte_admin;?></span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box ">
                <div class="img-box">
                  <img src="images/s4.png" alt="">
                </div>
                <div class="detail-box">
                  <h5> 
                  <button class="btn btn-primary" id="tarde" 
                  style="color:white" type="submit" <?php echo $a;?>>Ajouter</button> 
                  </h5>
                  <p>
                  Un nouveau confrère nous rejoins.<span style="color:#a96f4b;"><?php echo $compte_admin;?></span>
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!--Formulaire pour ajouter un médecin -->

          <form method="post" id="effet" action="ajout_medecin.php">

            <div class="form-group">
              <label for="email" style="color:black; font-weight:bold">Adresse E-mail</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="pascal@allobobo.fr"
              value="<?php if(isset($email))echo $email; ?>" required multiple>
            </div>

            <div class="form-group">
              <label for="nom" style="color:black; font-weight:bold">Nom</label>
              <input type="text" class="form-control" name="nom" id="nom" placeholder="Pascal" 
              value="<?php if(isset($nom))echo $nom; ?>" required>
            </div>

            <div class="form-group">
            <label for="nom" style="color:black; font-weight:bold">Spécialité</label>
              <select name="specialite" id="specialite" class="form-control">
                    <option value="Médecin généraliste">Médecin généraliste</option>
                    <option value="Cardiologue">Cardiologue</option>
                    <option value="Anestésiste">Anesthésiste</option>
              </select>
            </div>
            <button id="ajouter" name="submit" type="submit" class="btn btn-primary">Validez</button>
          </form>

        </div>
      </div>
    </div>
  </section>
  <!-- footer section -->
  <?php include('footer.php') ?>
  <!-- footer section -->

  <!-- jQery & js scripts section -->
  <?php include('mes_script.php') ?>
  <!-- jQery & js scripts section--> 
</body>

<script>
/**fonction pour afficher/cacher le formulaire d'ajout de médecin */ 
    $(document).ready(function(){						 
	$('#effet').hide();
	   	$('#tarde').click(function(){
			$('#effet').slideToggle();

		});
   });
</script>

</html>