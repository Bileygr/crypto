<?php
require_once("app/imports.php");
session_start();

class ControlleurDefaut {
    public function verification(){
        if(!isset($_SESSION["utilisateur"])){
            header("Location: login.php");
        }
    }


    public function connexion(){
        $moteur = new Moteur;

        $moteur->assigner("message", "");
        $moteur->assigner("message 2", "");

        if(isset($_POST["connecter"])){
            $email = $_POST["email"];
            $motdepasse = $_POST["motdepasse"];

            if(!empty($email) && !empty($motdepasse)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $utilisateurdao = new UtilisateurDAO;
                    $utilisateurs = $utilisateurdao->find(["option"=>"email", "valeur"=>$email]);
                    $utilisateur = $utilisateurs[0];
                    if(password_verify("test", $utilisateur->getAuthentification()->getMotdepasse())){
                       $_SESSION["utilisateur"] = $utilisateur;
                       $_SESSION["valide"]=False;
                       header("Location: code.php");
                    }else{
                        $moteur->assigner("message", "<b>Mauvaises informations de connexion.</b>");
                    }
                }else{
                    $moteur->assigner("message", "<b>Vérifiez le format de votre adresse email.</b>");
                }        
            }else{
                $moteur->assigner("message", "<b>Vérifiez que tout les champs sont remplis.</b>");
            }
        }
        $moteur->affichage("connexion.html");
    }

    public function code(){
        ControlleurDefaut::verification();
        $utilisateur = $_SESSION["utilisateur"];
        $moteur = new Moteur;
        $moteur->assigner("message", "");

        if(isset($_POST["validation"])){
            $code = $_POST["code"];

            if(!empty($code)){
                $googleAuthenticator = new PHPGangsta_GoogleAuthenticator();
                if($googleAuthenticator->verifyCode($utilisateur->getAuthentification()->getClesecrete(), $code)) {
                    $_SESSION["valide"]=True;
                    header("Location: index.php");
                }else {
                    $moteur->assigner("message", "<b>Mauvais code.</b>");
                }
            }else{
                $moteur->assigner("message", "<b>Remplissez le champ.</b>");
            }
        }

        $moteur->affichage("code.html");
    }

    public function deconnexion(){
        if(session_destroy()){
            header("Location: index.php");
        }
    }

    public function index(){
        $moteur = new Moteur;
        $moteur->assigner("message", "");

        if(isset($_SESSION["utilisateur"])){
            $utilisateur = $_SESSION["utilisateur"];

            $contenu = 
            "
                <p><b>Entreprise : </b>".$utilisateur->getEntreprise()->getNom()."</p>
                <p><b>Rôle : </b>".$utilisateur->getRole()->getTitre()."</p>
            ";

            $moteur->assigner("titre", "Bienvenue ".$utilisateur->getPrenom()." ".$utilisateur->getPrenom());
            $moteur->assigner("connexion", "");
            $moteur->assigner("inscription", "");
            $moteur->assigner("deconnexion", "<a href=\"deconnexion.php\">Déconnexion</a>");
            $moteur->assigner("contenu", $contenu);
        }else{
            $moteur->assigner("titre", "Accueil");
            $moteur->assigner("connexion", "<a href=\"connexion.php\">Connexion</a>");
            $moteur->assigner("inscription", "<a href=\"inscription.php\">Incription</a>");
            $moteur->assigner("deconnexion", "");
            $moteur->assigner("contenu", "");
        }

        $moteur->affichage("index.html");
    }

    public function inscription(){
        $moteur = new Moteur;
        $googleAuthenticator = new PHPGangsta_GoogleAuthenticator();
        $entreprisedao = new EntrepriseDAO;
        $roledao = new RoleDAO;
        $utilisateurdao = new UtilisateurDAO;

        $lesentreprises = $entreprisedao->find(["option"=>"", "valeur"=>""]); 
        $entreprises = "";
        
        foreach ($lesentreprises as $entreprise) {
			$entreprises .= '<option value="'.$entreprise->getId().'">'.$entreprise->getNom().'</option>';
		}

        $lesroles = $roledao->find(["option"=>"", "valeur"=>""]); 
		$roles = "";

		foreach ($lesroles as $role) {
			$roles .= '<option value="'.$role->getId().'">'.$role->getTitre().'</option>';
		}

        $moteur->assigner("secret", "");
        $moteur->assigner("qr", "");
        $moteur->assigner("entreprises", $entreprises);
        $moteur->assigner("roles", $roles);

        if(isset($_POST["inscrire"])){
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $motdepasse = $_POST["motdepasse"];
            $motdepasse_conf = $_POST["motdepasse_2"];
            $email = $_POST["email"];
            $telephone = $_POST["telephone"];
            $entreprise_id = $_POST["entreprise"];
            $role_id = $_POST["role"];

            if(!empty($nom) && !empty($prenom) && !empty($motdepasse) && !empty($motdepasse_conf) 
                && !empty($email) && !empty($telephone) && !empty($entreprise_id) && !empty($role_id)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    if(strlen($telephone) == 10){
                        if($motdepasse == $motdepasse_conf){
                            $websiteTitle = 'Asclepius ('.$email.')';
                            $cle_secrete = $googleAuthenticator->createSecret();
                            $qrCodeUrl = $googleAuthenticator->getQRCodeGoogleUrl($websiteTitle, $cle_secrete);
                            $qr = 
                                "
                                    <h2>Scannez votre code!</h2>
                                    Code QR <a href=\"https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en\" target=\"_blank\">Google Authenticator</a> : 
                                    <br/>
                                    <img src=".$qrCodeUrl."/>
                                    <br/>
                                    <p>Inscription réussie! -> <a href=\"connexion.php\">Clicquez ici!</a></p>
                                ";
                            $moteur->assigner("qr", $qr);
                            $entreprise = $entreprisedao->find(["option"=>"id", "valeur"=>$entreprise_id]);
                            $role = $roledao->find(["option"=>"id", "valeur"=>$role_id]);
                            $authentification = new Authentification(null, null, null, $cle_secrete);
                            $authentification->setMotdepasse($motdepasse);

                            $utilisateur = new Utilisateur(
                                null,
                                False,
                                $authentification,
                                $entreprise[0],
                                $role[0],
                                $nom,
                                $prenom,
                                $email,
                                $telephone,
                                null
                            );

                            $utilisateurdao->persist($utilisateur);
                        }
                    }
                }
            }
        }
        $moteur->affichage("inscription.html");
    }
}
?>