<?php
require_once("app/imports.php");

class UtilisateurDAO implements DAO {
    public function delete($option){

    }

    public function find($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

        $sql = 
        "
        SELECT utilisateur.id AS user_id, utilisateur.actif AS user_actif, utilisateur.nom AS user_nom, utilisateur.prenom AS user_prenom, 
                utilisateur.email AS user_email, utilisateur.telephone AS user_telephone, utilisateur.date_ajout AS user_date, authentification.id AS auth_id, 
                authentification.mot_de_passe AS auth_motdepasse, authentification.cle_secrete AS auth_cle_secrete, entreprise.id AS ent_id, entreprise.siret AS ent_siret, 
                entreprise.nom AS ent_nom, entreprise.email AS ent_email, entreprise.telephone AS ent_telephone, entreprise.date AS ent_date, 
                role.id AS role_id, role.titre AS role_titre  
        FROM utilisateur 
        JOIN authentification ON utilisateur.id=authentification.utilisateur_id 
        JOIN entreprise ON utilisateur.entreprise_id=entreprise.id 
        JOIN role ON utilisateur.role_id=role.id
        ";

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare($sql."WHERE id=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE nom=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'prenom':
                $requete = $bdd->prepare($sql." WHERE prenom=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'email':
                $requete = $bdd->prepare($sql." WHERE utilisateur.email=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'telephone':
                $requete = $bdd->prepare($sql." telephone=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
			default:
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
		}

		$utilisateurs = array();

		for($i=0; $utilisateur=$requete->fetch(); $i++){
            $entreprise = new Entreprise(
                $utilisateur['ent_id'],
                $utilisateur['ent_siret'],
                $utilisateur['ent_nom'],
                $utilisateur['ent_email'],
                $utilisateur['ent_telephone'],
                $utilisateur['ent_date']
            );

            $role = new Role(
                $utilisateur['role_id'],
                $utilisateur['role_titre']
            );

            $authentification = new Authentification(
                $utilisateur['auth_id'],
                null,
                $utilisateur['auth_motdepasse'],
                $utilisateur['auth_cle_secrete']
            );

			$utilisateurs[$i] = new Utilisateur(
                $utilisateur['user_id'],
                $utilisateur['user_actif'],
                $authentification,
                $entreprise,
                $role,
                $utilisateur['user_nom'],
                $utilisateur['user_prenom'],
                $utilisateur['user_email'],
                $utilisateur['user_telephone'],
                $utilisateur['user_date']
            );

            $authentification->setUtilisateur($utilisateurs[$i]);
		}
		return $utilisateurs;
    }

    public function persist($utilisateur){
        $connect = new Connect;
        $authentificationdao = new AuthentificationDAO;
        $bdd = $connect->connexion();
        $requete = $bdd->prepare("INSERT INTO utilisateur(utilisateur_actif, role_id, specialisation_id, utilisateur_nom, utilisateur_prenom, utilisateur_email, utilisateur_telephone,
                                                            utilisateur_numero_de_rue, utilisateur_rue, utilisateur_ville, utilisateur_code_postal) 
                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $requete->execute([
            $utilisateur->getActif(),
            $utilisateur->getRole()->getId(),
            $utilisateur->getSpecialisation()->getId(),
            $utilisateur->getNom(),
            $utilisateur->getPrenom(),
            $utilisateur->getEmail(),
            $utilisateur->getTelephone(),
            $utilisateur->getNumeroderue(),
            $utilisateur->getRue(),
            $utilisateur->getVille(),
            $utilisateur->getCodepostal()
        ]);
        
        $requete = $bdd->prepare("SELECT utilisateur_id FROM utilisateur WHERE utilisateur_email=?");
        $requete->execute([$utilisateur->getEmail()]);
        $utilisateur->setId($requete->fetch()["utilisateur_id"]);
        $authentification = $utilisateur->getAuthentification();
        $authentification->setUtilisateur($utilisateur);
        $authentificationdao->persist($authentification);

        $connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        $connect = null;
    }

    public function update($utilisateur){

    }
}
?>