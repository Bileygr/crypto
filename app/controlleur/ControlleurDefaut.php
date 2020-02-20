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
                    $resultat = $utilisateurdao->read(["option"=>"email", "valeur"=>$email]);
        
                    if($resultat){
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
                            $resultat['utilisateur_actif'],
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
                            $_SESSION["utilisateur"] = $utilisateur;
                            $_SESSION["validite"]=False;
                            header("Location: code.php");
                        }else{
                            $moteur->assigner("message", "<b>Mauvaises informations de connexion.</b>");
                        }
                    }else{
                        $moteur->assigner("message", "<b>L'utilisateur n'existe pas.</b>");
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
                    $_SESSION["validite"]=True;
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

        if(isset($_SESSION["utilisateur"]) && $_SESSION["validite"]==True){
            $utilisateur = $_SESSION["utilisateur"];

            if($utilisateur->getRole()->getId() == 3){
                $contenu = 
                "
                    <p><b>Rôle : </b>".$utilisateur->getRole()->getNom()."</p>
                    <p><b>Spécialisation : </b>".$utilisateur->getSpecialisation()->getNom()."</p>
                ";
            }else{
                $contenu = 
                "
                    <p><b>Rôle : </b>".$utilisateur->getRole()->getNom()."</p>
                ";
            }

            $moteur->assigner("titre", "Bienvenue ".$utilisateur->getPrenom()." ".$utilisateur->getNom());
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
        $entreprisedao = new EntrepriseDAO;
        $googleAuthenticator = new PHPGangsta_GoogleAuthenticator();
        $moteur = new Moteur;
        $roledao = new RoleDAO;
        $specialisationdao = new SpecialisationDAO;
        $utilisateurdao = new UtilisateurDAO;

        $lesentreprises = $entreprisedao->read(["option"=>"", "valeur"=>""]);
        $lesroles = $roledao->read(["option"=>"", "valeur"=>""]); 
        $lesspecialisations = $specialisationdao->read(["option"=>"", "valeur"=>""]); 

        $entreprises = "";
        $roles = "";
        $specialisations = "";

        foreach($lesentreprises as $entreprise){
            $entreprises .='<option value="'.$entreprise["entreprise_siren"].'">'.$entreprise["entreprise_nom"].'</option>'; 
        }

		foreach($lesroles as $role) {
			$roles .= '<option value="'.$role["role_id"].'">'.$role["role_nom"].'</option>';
		}
        
        foreach($lesspecialisations as $specialisation) {
            $specialisations .= '<option value="'.$specialisation["specialisation_id"].'">'.$specialisation["specialisation_nom"].'</option>';
		}

        $moteur->assigner("code qr", "");
        $moteur->assigner("message", "");
        $moteur->assigner("entreprises", $entreprises);
        $moteur->assigner("roles", $roles);
        $moteur->assigner("specialisations", $specialisations);

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
                                    Code QR <a href=\"https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en\" target=\"_blank\">Google Authenticator</a> : 
                                    <br/>
                                    <img src=".$url_du_code_qr."/>
                                    <br/>
                                    <p>Inscription réussie! -> <a href=\"connexion.php\">Clicquez ici!</a></p>
                                ";
                            
                            $moteur->assigner("code qr", $code_qr);

                            $authentification = new Authentification(null, null, $cle_secrete);
                            $authentification->setMotdepasse($mot_de_passe);
                            $entreprise = $entreprisedao->read(["option"=>"siren", "valeur"=>$entreprise])[0];
                            $entreprise = new Entreprise(
                                $entreprise["entreprise_siren"], 
                                $entreprise["entreprise_activation"], 
                                $entreprise["entreprise_nom"],
                                $entreprise["entreprise_telephone"],
                                $entreprise["entreprise_email"],
                                $entreprise["entreprise_numero_de_rue"],
                                $entreprise["entreprise_rue"],
                                $entreprise["entreprise_ville"],
                                $entreprise["entreprise_code_postal"],
                                $entreprise["entreprise_date"]
                            );
                            $role = $roledao->read(["option"=>"id", "valeur"=>$role])[0];
                            $role = new Role($role["role_id"], $role["role_nom"]);

                            if(!empty($specialisation)){
                                $specialisation = $specialisationdao->read(["option"=>"id", "valeur"=>$specialisation])[0];
                                $specialisation = new Specialisation($specialisation["specialisation_id"],$specialisation["specialisation_nom"]);
                            }else{
                                $specialisation = new Specialisation(null, null);
                            }

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
                        }
                    }else{
                        $moteur->assigner("message", "<b>Le numéro de téléphone n'a pas la bonne longeur (10).</b>");
                    }
                }else{
                    $moteur->assigner("message", "<b>Le format de l'email est invalide.</b>");
                }
            }else{
                $moteur->assigner("message", "<b>L'un des champs est vide.</b>");
            }
        }
        $moteur->affichage("inscription.html");
    }
}
?>