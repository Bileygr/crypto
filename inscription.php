<?php
require_once("imports.php");

$googleAuthenticator = new PHPGangsta_GoogleAuthenticator();

$entreprisedao = new EntrepriseDAO;
$roledao = new RoleDAO;
$specialisationdao = new SpecialisationDAO;
$utilisateurdao = new UtilisateurDAO;

$lesentreprises = $entreprisedao->read(["", ""]);
$lesroles = $roledao->read(["", ""]); 
$lesspecialisations = $specialisationdao->read(["", ""]); 

$entreprises = "";
$roles = "";
$specialisations = "";

foreach($lesentreprises as $entreprise){
    $entreprises .='<option value="'.$entreprise->getSIREN().'">'.$entreprise->getNom().'</option>'; 
}

foreach($lesroles as $role) {
    if($role->getId() != "6" && $role->getId() != "7"){
        $roles .= '<option value="'.$role->getId().'">'.$role->getNom().'</option>';
    }
}
        
foreach($lesspecialisations as $specialisation) {
    $specialisations .= '<option value="'.$specialisation->getId().'">'.$specialisation->getNom().'</option>';
}

if(isset($_POST["inscrire"])){
    $code_postal = $_POST["code_postal"];
    $confirmation_du_mot_de_passe = $_POST["confirmation_du_mot_de_passe"];
    $email = $_POST["email"];
    $entreprise = $_POST["entreprise"];
    $mot_de_passe = $_POST["mot_de_passe"];
    $nom = $_POST["nom"];
    $numero_de_rue = $_POST["numero_de_rue"];
    $prenom = $_POST["prenom"];
    $role = $_POST["role"];
    $rue = $_POST["rue"];
    $specialisation = $_POST["specialisation"];
    $telephone = $_POST["telephone"];
    $ville = $_POST["ville"];

    if(!empty($code_postal) && !empty($confirmation_du_mot_de_passe) && 
        !empty($email) && !empty($mot_de_passe) && !empty($nom) && 
        !empty($numero_de_rue) && !empty($prenom) && !empty($role) && 
        !empty($rue) && !empty($telephone) && !empty($ville) && !empty($entreprise)){
                
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    
            if(strlen($telephone) == 10){
                        
                if($mot_de_passe == $confirmation_du_mot_de_passe){
                    $cle_secrete = $googleAuthenticator->createSecret();
                    $titre = 'Telemedecine ('.$email.')';
                    $url_du_code_qr = $googleAuthenticator->getQRCodeGoogleUrl($titre, $cle_secrete);
                            
                    $code_qr = 
                    "
                        <h2>Scannez votre code!</h2>
                        <p>Code QR <a href=\"https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en\" target=\"_blank\"><u>Google Authenticator</u></a> : </p>
                        <br>
                        <img src=".$url_du_code_qr."/>
                            <br/>
                            <p>Inscription réussie! -> <a href=\"connexion.php\"><u>Clicquez ici!</u></a></p>
                    ";

                    $authentification = new Authentification(null, null, $cle_secrete);
                    $authentification->setMotdepasse($mot_de_passe);
                    $entreprise = $entreprisedao->read(["siren", $entreprise])[0];
                    $role = $roledao->read(["id", $role])[0];
                    $specialisation = $specialisationdao->read(["id", $specialisation])[0];
                    $utilisateur = new Utilisateur(
                        null,
                        $entreprise,
                        False,
                        $role,
                        $specialisation,
                        $authentification,
                        $nom,
                        $prenom,
                        $email,
                        $telephone,
                        $numero_de_rue,
                        $rue,
                        $ville,
                        $code_postal,
                        null
                    );

                    $utilisateurdao->create($utilisateur);
                }else{
                    $erreur = "<b style=\"color:red;\">Les mots de passe ne correspondent pas.</b>";
                }
            }else{
                $erreur = "<b style=\"color:red;\">Le numéro de téléphone n'a pas la bonne longeur (10).</b>";
            }
        }else{
            $erreur = "<b style=\"color:red;\">Le format de l'email est invalide.</b>";
        }
    }else{
        $erreur = "<b style=\"color:red;\">L'un des champs est vide.</b>";
    }
}
?>
<!DOCTYPE html>
<html>
    <header>
        <title>Inscription Utilisateur</title>
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
                            Inscrivez vous!
                        </span>
                    </div>

                    <form method="POST" class="login100-form validate-form">
                        <?php 
                            if(isset($code_qr)){
                                echo $code_qr;
                            }
                        ?>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Nom</span>
                            <input class="input100" type="text" name="nom" placeholder="Nom">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Prénom requis.">
                            <span class="label-input100">Prénom</span>
                            <input class="input100" type="text" name="prenom" placeholder="prenom">
                            <span class="focus-input100"></span>
                        </div>
    
                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Mot de passe requis.">
                            <span class="label-input100">Mot de passe</span>
                            <input class="input100" type="password" name="mot_de_passe" placeholder="Mot de passe">
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Mot de passe requis.">
                            <span class="label-input100">Mot de passe</span>
                            <input class="input100" type="password" name="confirmation_du_mot_de_passe" placeholder="Confirmation du mot de passe">
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

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Entreprise</span>
                            <select id="entreprise" name="entreprise" class="custom-select mr-sm-2">
                                <?php 
                                   echo $entreprises; 
                                ?>
                            </select>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" data-validate="Nom requis.">
                            <span class="label-input100">Rôle</span>
                            <select id="role" name="role" class="custom-select mr-sm-2">
                                <?php 
                                   echo $roles; 
                                ?>
                            </select>
                        </div>

                        <div class="wrap-input100 validate-input m-b-26" id="div_specialisation" style="display: none;">
                            <span class="label-input100">Specialisation</span>
                            <select id="specialisation" name="specialisation" class="custom-select mr-sm-2">
                                <?php 
                                   echo $specialisations; 
                                ?>
                            </select>
                        </div>
    
                        <div class="flex-sb-m w-full p-b-30">
                            <div>
                                <a href="connexion.php" class="txt1">
                                    Connexion
                                </a>
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

        <script>
            document.getElementById('role').addEventListener('change', function () {
                var style = this.value == 2 ? 'block' : 'none';
                document.getElementById('div_specialisation').style.display = style;
            });
        </script>
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