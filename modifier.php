<?php
require_once("imports.php");
session_start();

if(!isset($_SESSION["utilisateur"])){
    header("Location: index.php");
}

$id = $_GET["id"];
$utilisateurdao = new UtilisateurDAO;
$utilisateur = $utilisateurdao->read(["id", $id])[0];

if(isset($_POST["modifier"])){
    $id = $utilisateur->getId();

    $utilisateur->setNom($_POST["nom"]);
    $utilisateur->setPrenom($_POST["prenom"]);
    $utilisateur->setEmail($_POST["email"]);
    $utilisateur->setTelephone($_POST["telephone"]);
    $utilisateur->setNumeroderue($_POST["numero_de_rue"]);
    $utilisateur->setRue($_POST["rue"]);
    $utilisateur->setVille($_POST["ville"]);
    $utilisateur->setCodepostal($_POST["code_postal"]);

    $utilisateur = $utilisateurdao->update($utilisateur);

    if($utilisateur){
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Modifier</title>
        <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="icon" type="image/png" href="assets/registration/images/icons/favicon.ico"/>
	    <link rel="stylesheet" type="text/css" href="assets/registration/vendor/bootstrap/css/bootstrap.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/vendor/animate/animate.css">	
	    <link rel="stylesheet" type="text/css" href="assets/registration/vendor/css-hamburgers/hamburgers.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/vendor/animsition/css/animsition.min.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/vendor/select2/select2.min.css">	
	    <link rel="stylesheet" type="text/css" href="assets/registration/vendor/daterangepicker/daterangepicker.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/css/util.css">
	    <link rel="stylesheet" type="text/css" href="assets/registration/css/main.css">
    </header>

    <body>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-form-title" style="background-image: url(assets/registration/images/bg-01.jpg);">
                        <span class="login100-form-title-1">
                            Modifier
                        </span>
                    </div>

                    <form method="POST" class="login100-form validate-form">
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Nom</span>
                            <input class="input100" type="text" name="nom" placeholder="Nom" <?php echo "value=".$utilisateur->getNom(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Prénom requis.">
                            <span class="label-input100">Prénom</span>
                            <input class="input100" type="text" name="prenom" placeholder="prenom" <?php echo "value=".$utilisateur->getPrenom(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Email requis.">
                            <span class="label-input100">Email</span>
                            <input class="input100" type="email" name="email" placeholder="Email" <?php echo "value=".$utilisateur->getEmail(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Téléphone requis.">
                            <span class="label-input100">Téléphone</span>
                            <input class="input100" type="text" name="telephone" placeholder="telephone" <?php echo "value=".$utilisateur->getTelephone(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Numéro de rue requis.">
                            <span class="label-input100">Numéro de rue</span>
                            <input class="input100" type="text" name="numero_de_rue" placeholder="Numero de rue" <?php echo "value=".$utilisateur->getNumeroderue(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Rue requis.">
                            <span class="label-input100">Rue</span>
                            <input class="input100" type="text" name="rue" placeholder="Rue" <?php echo "value=".$utilisateur->getRue(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Ville requis.">
                            <span class="label-input100">Ville</span>
                            <input class="input100" type="text" name="ville" placeholder="Ville" <?php echo "value=".$utilisateur->getVille(); ?>>
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Code postal requis.">
                            <span class="label-input100">Code postal</span>
                            <input class="input100" type="text" name="code_postal" placeholder="Code postal" <?php echo "value=".$utilisateur->getCodepostal(); ?>>
                            <span class="focus-input100"></span>
                        </div>
    
                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type="submit" name="modifier" value="Modifier"></input>
                        </div>

                        <?php 
                            if(isset($erreur)){
                                echo $erreur;
                            }
                        ?>
                    </form>
                </div>
            </div>
        </div>

        <script src="assets/registration/vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="assets/registration/vendor/animsition/js/animsition.min.js"></script>
        <script src="assets/registration/vendor/bootstrap/js/popper.js"></script>
	    <script src="assets/registration/vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/registration/vendor/select2/select2.min.js"></script>
        <script src="assets/registration/vendor/daterangepicker/moment.min.js"></script>
	    <script src="assets/registration/vendor/daterangepicker/daterangepicker.js"></script>
        <script src="assets/registration/vendor/countdowntime/countdowntime.js"></script>
        <script src="assets/registration/js/main.js"></script>
    </body>
</html>