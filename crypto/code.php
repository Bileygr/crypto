<?php
require_once("imports.php");
session_start();

$utilisateur = $_SESSION["utilisateur"];

if(isset($_POST["verifier"])){
    $code = $_POST["code"];

    if(!empty($code)){
        $googleAuthenticator = new PHPGangsta_GoogleAuthenticator();
        if($googleAuthenticator->verifyCode($utilisateur->getAuthentification()->getClesecrete(), $code)) {
            $_SESSION["validite"]=True;
            header("Location: index.php");
        }else {
            $erreur = "<b>Mauvais code.</b>";
        }
    }else{
        $erreur = "<b>Remplissez le champ.</b>";
    }
}
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Connexion</title>
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
                            Entrez votre code!
                        </span>
                    </div>

                    <form method="POST" class="login100-form validate-form">
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Code requis.">
                            <span class="label-input100">Code</span>
                            <input class="input100" type="text" name="code" placeholder="Code">
                            <span class="focus-input100"></span>
                        </div>
    
                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type="submit" name="verifier" value="Vérifier"></input>
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