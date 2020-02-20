<?php
require_once("imports.php");

if(isset($_POST["connecter"])){
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    if(!empty($email) && !empty($mot_de_passe)){
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $utilisateurdao = new UtilisateurDAO;
            $resultat = $utilisateurdao->read(["option"=>"", "valeur"=>""]);

            if($resultat){
                $entreprise = new Entreprise(
                    $resultat['entreprise_siren'],
                    $resultat['entreprise_activation'],
                    $resultat['entreprise_nom'],
                    $resultat['entreprise_telephone'],
                    $resultat['entreprise_email'],
                    $resultat['entreprise_numero_de_rue'],
                    $resultat['entreprise_rue'],
                    $resultat['entreprise_ville'],
                    $resultat['entreprise_code_postal'],
                    $resultat['entreprise_date']
                );

                $role = new Role(
                    $resultat['role_id'],
                    $resultat['role_nom']
                );

                $specialisation = new specialisation(
                    $resultat['specialisation_id'],
                    $resultat['specialisation_nom']
                );

                $authentification = new Authentification(
                    null,
                    $resultat['authentification_mot_de_passe'],
                    $resultat['authentification_cle_secrete']
                );

                $utilisateur = new Utilisateur(
                    $resultat['utilisateur_id'],
                    $entreprise,
                    $resultat['utilisateur_activation'],
                    $role,
                    $specialisation,
                    $authentification,
                    $resultat['utilisateur_nom'],
                    $resultat['utilisateur_prenom'],
                    $resultat['utilisateur_email'],
                    $resultat['utilisateur_telephone'],
                    $resultat['utilisateur_numero_de_rue'],
                    $resultat['utilisateur_rue'],
                    $resultat['utilisateur_ville'],
                    $resultat['utilisateur_code_postal'],
                    $resultat['utilisateur_date']
                );

                $authentification->setUtilisateur($utilisateur);

                if(password_verify($mot_de_passe, $utilisateur->getAuthentification()->getMotdepasse())){

                    if($utilisateur->getActivation() == True){
                        session_start();

                        $_SESSION["utilisateur"] = $utilisateur;
                        $_SESSION["validite"]=False;
                        header("Location: code.php");
                    }else{
                       $erreur = "<b style=\"color:red;\">Le compte n'est pas activé.</b>";
                    }
                }else{
                    $erreur = "<b style=\"color:red;\">Mauvaises informations de connexion.</b>";
                }
            }else{
                $erreur = "<b style=\"color:red;\">L'utilisateur n'existe pas.</b>";
            }
        }else{
            $erreur = "<b style=\"color:red;\">Vérifiez le format de votre adresse email.</b>";
        }        
    }else{
        $erreur = "<b style=\"color:red;\">Vérifiez que tout les champs sont remplis.</b>";
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
                            Connectez vous!
                        </span>
                    </div>

                    <form method="POST" class="login100-form validate-form">
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Email requis.">
                            <span class="label-input100">Email</span>
                            <input class="input100" type="email" name="email" placeholder="Email">
                            <span class="focus-input100"></span>
                        </div>
    
                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Mot de passe requis.">
                            <span class="label-input100">Mot de passe</span>
                            <input class="input100" type="password" name="mot_de_passe" placeholder="Mot de passe">
                            <span class="focus-input100"></span>
                        </div>
    
                        <div class="flex-sb-m w-full p-b-30">
                            <div>
                                <a href="inscription.php" class="txt1">
                                    Inscription
                                </a>
                            </div>
                        </div>
    
                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type="submit" name="connecter" value="Connexion"></input>
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