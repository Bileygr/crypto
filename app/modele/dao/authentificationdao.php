<?php
require_once("app/imports.php");

class AuthentificationDAO implements DAO{
    public function find($option){
    }

    public function persist($authentification){
        $connect = new Connect;
        $bdd = $connect->connexion();
        $requete = $bdd->prepare("INSERT INTO authentification(utilisateur_id, mot_de_passe, cle_secrete) VALUES(?, ?, ?)");
		$requete->execute([
            $authentification->getUtilisateur()->getId(),
            $authentification->getMotdepasse(),
            $authentification->getClesecrete()
        ]);

        $bdd=null;
        $connect=null;
    }
}
?>