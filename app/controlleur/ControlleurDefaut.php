<?php
require_once("app/imports.php");

class ControlleurDefaut {
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
                            $authentification = new Authentification(null, null, $motdepasse, $cle_secrete);

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