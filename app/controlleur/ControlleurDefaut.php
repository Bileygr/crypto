<?php
require_once("app/imports.php");
session_start();

class ControlleurDefaut {
    public function verification(){
        if(!isset($_SESSION["utilisateur"])){
            header("Location: connexion.php");
        }
    }


    public function connexion(){
        $moteur = new Moteur;

        $moteur->assigner("message", "");
        $moteur->assigner("message 2", "");

        if(isset($_POST["connecter"])){
            $email = $_POST["email"];
            $mot_de_passe = $_POST["mot_de_passe"];

            if(!empty($email) && !empty($mot_de_passe)){
                
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $utilisateurdao = new UtilisateurDAO;
                    $utilisateur = $utilisateurdao->find(["option"=>"email", "valeur"=>$email])[0];
                    
                    if(password_verify($mot_de_passe, $utilisateur->getAuthentification()->getMotdepasse())){
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
        $googleAuthenticator = new PHPGangsta_GoogleAuthenticator();
        $moteur = new Moteur;
        $roledao = new RoleDAO;
        $specialisationdao = new SpecialisationDAO;
        $utilisateurdao = new UtilisateurDAO;

        $lesroles = $roledao->find(["option"=>"", "valeur"=>""]); 
        $lesspecialisations = $specialisationdao->find(["option"=>"", "valeur"=>""]); 

        $roles = "";
        $specialisations = "";

		foreach ($lesroles as $role) {
			$roles .= '<option value="'.$role->getId().'">'.$role->getNom().'</option>';
		}
        
        foreach ($lesspecialisations as $specialisation) {
			$specialisations .= '<option value="'.$specialisation->getId().'">'.$specialisation->getNom().'</option>';
		}

        $moteur->assigner("code qr", "");
        $moteur->assigner("roles", $roles);
        $moteur->assigner("specialisations", $specialisations);

        if(isset($_POST["inscrire"])){
            $code_postal = $_POST["code_postal"];
            $confirmation_du_mot_de_passe = $_POST["confirmation_du_mot_de_passe"];
            $email = $_POST["email"];
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
                !empty($rue) && !empty($telephone) && !empty($ville)){
                
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    
                    if(strlen($telephone) == 10){
                        
                        if($mot_de_passe == $confirmation_du_mot_de_passe){
                            $cle_secrete = $googleAuthenticator->createSecret();
                            $titre = 'Asclepius ('.$email.')';
                            $url_du_code_qr = $googleAuthenticator->getQRCodeGoogleUrl($titre, $cle_secrete);
                            
                            $code_qr = 
                                "
                                    <h2>Scannez votre code!</h2>
                                    Code QR <a href=\"https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en\" target=\"_blank\">Google Authenticator</a> : 
                                    <br/>
                                    <img src=".$url_du_code_qr."/>
                                    <br/>
                                    <p>Inscription réussie! -> <a href=\"connexion.php\">Clicquez ici!</a></p>
                                ";
                            
                            $moteur->assigner("code qr", $code_qr);

                            $authentification = new Authentification(null, null, $cle_secrete);
                            $authentification->setMotdepasse($mot_de_passe);
                            $role = $roledao->find(["option"=>"id", "valeur"=>$role])[0];

                            if(!empty($specialisation)){
                                $specialisation = $specialisationdao->find(["option"=>"id", "valeur"=>$specialisation])[0];
                            }else{
                                $specialisation = new Specialisation(null, null);
                            }

                            $utilisateur = new Utilisateur(
                                null,
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