<?php 

require_once 'config/config.php';
require_once 'database/init.php';
require_once 'database/database_upgrade.php'; //inclus les fonctions installation et de desinstallation

session_start();

// Vérification du mot de passe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === ADMIN_PASSWORD) {
        $_SESSION['is_admin'] = true;
    } else {
        $error = 'Mot de passe incorrect.';
    }
}

// Vérification de la déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Vérifier si l'utilisateur est authentifié
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] || isset($_SESSION['type_compte']) && $_SESSION['type_compte'] == 'ADM' ) {
    if (isset($_POST['install'])) {
        // Exécuter la vérification et éventuellement l'installation
        check_and_run_install();
    } elseif (isset($_POST['uninstall'])) {
        ab_db_uninstall();
    } elseif (isset($_POST['unlock'])) {
        // Supprimer le fichier de verrouillage
        if (file_exists('installed.lock')) {
            unlink('installed.lock');
        echo 'le fichier de verrouillage a été supprimé.';
    }
    }
} else {
    //echo isset($error) ? $error : '';
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('header.php') ?>

    <script type="text/javascript">
        function confirmUninstall() {
            return confirm('Êtes-vous sûr de vouloir désinstaller ? Cette action est irréversible.');
        }
        function confirmUnlock() {
            return confirm('Attention ! supprimer le fichier de vérouillage permettra une nouvelle installation dans laquelle vous perdrez toutes les données.');
        }
    </script>
    <style>
    h4, h1, h3 { color: white; font-family: 'Roboto'; }
    .form-inline {
    display: flex;
    align-items: center;
    }

    .form-inline .form-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-right: 20px; /* Espace entre les formulaires */
    }

    .form-inline h4 {
    margin-bottom: 10px;
    }

    .form-inline button {
    margin: 5px;
    }
    </style>

<body>

    <div class="hero_area">

        <div class="hero_bg_box">
                    <img src="images/hero-bg-sas.png" alt="">
        </div>

        <!-- navigation section -->
        <?php include('navigation.php') ?>
        <!-- navigation section -->

        <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] || isset($_SESSION['type_compte']) && $_SESSION['type_compte'] == 'ADM') : ?>

                <div class="d-flex justify-content-between">

                    <form method="POST" class="form-inline">
                        <div class="form-group">
                            <div class="card" style="width: 15rem">
                                <img class="card-img-top" src="images/db_1.png" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Base de données</h5>
                                    <p class="card-text">Installer ou désinstaller la base de données du site.</p>
                                    <button type="submit" name="install" class="btn btn-primary mx-2">Installer</button>
                                    <button type="submit" name="uninstall" class="btn btn-danger mx-2" onclick="return confirmUninstall();">Désinstaller</button>
                                    <button type="submit" name="unlock" class="btn btn-warning" onclick="return confirmUnlock();">Déverouiller</button>

                                </div>
                            </div>
                        </div>
                    </form>

                    <form class="form-inline">
                        <div class="form-group">
                            <div class="card" style="width: 15rem">
                                <img class="card-img-top" src="images/pl.WEBP" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Plug-in & Extension (à venir)</h5>
                                    <p class="card-text">Installer ou désinstaller les plug-in. </p>
                                    <button type="submit" name="install" class="btn btn-primary mx-2" disabled>Installer</button>
                                    <button type="submit" name="uninstall" class="btn btn-danger mx-2" disabled>Désinstaller</button>

                                </div>
                            </div>
                        </div>
                    </form>
            </div>
                <a class="btn btn-outline-dark mt-3" style="color: white;" href="?logout=true">Quitter</a>

            <?php else : ?>
                <h1>Accès restreint <img src="images/R.png" width="50%" height="50%"/></h1>
                <form method="POST">
                    <div class="form-group">
                        <label for="password">Mot de passe administrateur:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button class="btn btn-outline-dark" style="color: white;" type="submit" name="submit">Se connecter</button>
                </form>
                <?php if(isset($error)) echo '<p class="erreur_text">' . $error . '</p>'; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
</body>
</html>
