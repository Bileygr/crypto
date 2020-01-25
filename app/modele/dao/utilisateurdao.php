<?php
require_once("app/imports.php");

class UtilisateurDAO {
    public function persist($utilisateur){
        $connect = new Connect;
        $authentificationdao = new AuthentificationDAO;
        $bdd = $connect->connexion();
        $requete = $bdd->prepare("INSERT INTO utilisateur(actif, entreprise_id, role_id, nom, prenom, email, telephone) 
                                    VALUES(?, ?, ?, ?, ?, ?, ?)");
        
        $requete->execute([
            $utilisateur->getActif(),
            $utilisateur->getEntreprise()->getId(),
            $utilisateur->getRole()->getId(),
            $utilisateur->getNom(),
            $utilisateur->getPrenom(),
            $utilisateur->getEmail(),
            $utilisateur->getTelephone()
        ]);
        
        $requete = $bdd->prepare("SELECT id FROM utilisateur WHERE email=?");
        $requete->execute([$utilisateur->getEmail()]);
        $utilisateur->setId($requete->fetch()["id"]);
        $authentification = $utilisateur->getAuthentification();
        $authentification->setUtilisateur($utilisateur);
        $authentificationdao->persist($authentification);

        $bdd=null;
        $connect=null;
    }
}
?>