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
            SELECT utilisateur.utilisateur_id, utilisateur.utilisateur_actif, utilisateur.utilisateur_nom, utilisateur.utilisateur_prenom,
		            utilisateur.utilisateur_email, utilisateur.utilisateur_telephone, utilisateur.utilisateur_numero_de_rue, utilisateur.utilisateur_rue,
		            utilisateur.utilisateur_ville, utilisateur.utilisateur_code_postal, utilisateur.utilisateur_date, role.role_id, role.role_nom,
		            specialisation.specialisation_id, specialisation.specialisation_nom, authentification.authentification_mot_de_passe, 
		            authentification.authentification_cle_secrete
            FROM utilisateur
            JOIN role ON utilisateur.role_id=role.role_id
            JOIN specialisation ON utilisateur.specialisation_id = specialisation.specialisation_id
            JOIN authentification ON utilisateur.utilisateur_id = authentification.utilisateur_id
        ";

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare($sql."WHERE utilisateur.utilisateur_id=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_nom=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'prenom':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_prenom=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'email':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_email=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'telephone':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_telephone=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'numéro de rue':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_numero_de_rue=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'rue':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_rue=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'ville':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_ville=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'code postal':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_code_postal=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'date':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_date=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
			default:
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
        }

        $resultat = $requete->fetch();
        
        var_dump($resultat);

        $utilisateurs = array();

        //if($resultat){
            for($i=0; $utilisateur=$requete->fetch(); $i++){
                $role = new Role(
                    $utilisateur['role_id'],
                    $utilisateur['role_nom']
                );

                $specialisation = new specialisation(
                    $utilisateur['specialisation_id'],
                    $utilisateur['specialisation_nom']
                );

                $authentification = new Authentification(
                    null,
                    $utilisateur['authentification_motdepasse'],
                    $utilisateur['authentification_cle_secrete']
                );

                $utilisateurs[$i] = new Utilisateur(
                    $utilisateur['utilisateur_id'],
                    $utilisateur['utilisateur_actif'],
                    $role,
                    $specialisation,
                    $authentification,
                    $utilisateur['utilisateur_nom'],
                    $utilisateur['utilisateur_prenom'],
                    $utilisateur['utilisateur_email'],
                    $utilisateur['utilisateur_telephone'],
                    $utilisateur['utilisateur_numero_de_rue'],
                    $utilisateur['utilisateur_rue'],
                    $utilisateur['utilisateur_ville'],
                    $utilisateur['utilisateur_code_postal'],
                    $utilisateur['utilisateur_date']
                );

                $authentification->setUtilisateur($utilisateurs[$i]);
            }
        //}

        var_dump($utilisateurs);

        $connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        $connect = null;
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