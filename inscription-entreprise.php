<?php
require_once("imports.php");


 if(isset($_POST["inscrire"])){
            $code_postal = $_POST["code_postal"];
            $email = $_POST["email"];
            $nom = $_POST["nom"];
            $numero_de_rue = $_POST["numero_de_rue"];
            $siren = $_POST["siren"];
            $rue = $_POST["rue"];
            $telephone = $_POST["telephone"];
            $ville = $_POST["ville"];

            if(!empty($code_postal) && !empty($email) && !empty($nom) && !empty($numero_de_rue) && !empty($siren) && 
                !empty($rue) && !empty($telephone) && !empty($ville)){
                
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    
                    if(strlen($telephone) == 10){
                            $entreprisedao = new EntrepriseDAO;
                            $entreprise = new Entreprise(
                                $siren, 
                                FALSE, 
                                $nom,
                                $telephone,
                                $email,
                                $numero_de_rue,
                                $rue,
                                $ville,
                                $code_postal,
                                null
                            );

                            $entreprisedao->create($entreprise);
                            header("Location: index.php");
                        }
                    }else{
                        $erreur = "<b>Le numéro de téléphone n'a pas la bonne longeur (10).</b>";
                    }
                }else{
                    $erreur = "<b>Le format de l'email est invalide.</b>";
                }
            }else{
                $erreur = "<b>L'un des champs est vide.</b>";
            }
        
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Inscription Entreprise</title>
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
                            Inscrivez votre entreprise!
                        </span>
                    </div>

                    <form method="POST" class="login100-form validate-form">
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Prénom requis.">
                            <span class="label-input100">SIREN</span>
                            <input class="input100" type="text" name="siren" placeholder="SIREN">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Nom</span>
                            <input class="input100" type="text" name="nom" placeholder="Nom">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Email requis.">
                            <span class="label-input100">Email</span>
                            <input class="input100" type="email" name="email" placeholder="Email">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Téléphone requis.">
                            <span class="label-input100">Téléphone</span>
                            <input class="input100" type="text" name="telephone" placeholder="telephone">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Numéro de rue requis.">
                            <span class="label-input100">Numéro de rue</span>
                            <input class="input100" type="text" name="numero_de_rue" placeholder="Numero de rue">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Rue requis.">
                            <span class="label-input100">Rue</span>
                            <input class="input100" type="text" name="rue" placeholder="Rue">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Ville</span>
                            <input class="input100" type="text" name="ville" placeholder="Ville">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Code postal</span>
                            <input class="input100" type="text" name="code_postal" placeholder="Code postal">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="flex-sb-m w-full p-b-30">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Justificatif de la qualification  “opérateur services santé” envoyé.
                                </label>
                            </div>
					    </div>
    
                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type="submit" name="inscrire" value="Inscription"></input>
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