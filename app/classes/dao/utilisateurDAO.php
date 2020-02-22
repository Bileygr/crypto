<?php
class UtilisateurDAO implements CRUD {
    public function create($utilisateur){
        $connect = new Connect;
        $authentificationdao = new AuthentificationDAO;
        $bdd = $connect->connexion();

        $requete = $bdd->prepare("INSERT INTO utilisateur(entreprise_siren, utilisateur_activation, role_id, specialisation_id, utilisateur_nom, utilisateur_prenom, utilisateur_email, utilisateur_telephone,
                                                            utilisateur_numero_de_rue, utilisateur_rue, utilisateur_ville, utilisateur_code_postal) 
                                    VALUES(:entreprise, :activation, :role, :specialisation, :nom, :prenom, :email, :telephone, :numero_de_rue, :rue, :ville, :code_postal)");
        $resultat = $requete->execute([
            "entreprise"=>$utilisateur->getEntreprise()->getSIREN(),
            "activation"=>$utilisateur->getActivation(),
            "role"=>$utilisateur->getRole()->getId(),
            "specialisation"=>$utilisateur->getSpecialisation()->getId(),
            "nom"=>$utilisateur->getNom(),
            "prenom"=>$utilisateur->getPrenom(),
            "email"=>$utilisateur->getEmail(),
            "telephone"=>$utilisateur->getTelephone(),
            "numero_de_rue"=>$utilisateur->getNumeroderue(),
            "rue"=>$utilisateur->getRue(),
            "ville"=>$utilisateur->getVille(),
            "code_postal"=>$utilisateur->getCodepostal()
        ]);
        
        $requete = $bdd->prepare("SELECT utilisateur_id FROM utilisateur WHERE utilisateur_email=?");
        $requete->execute([$utilisateur->getEmail()]);
        $utilisateur->setId($requete->fetch()["utilisateur_id"]);
        $authentification = $utilisateur->getAuthentification();
        $authentification->setUtilisateur($utilisateur);
        $authentificationdao->create($authentification);

        return $resultat;
    }

    public function delete($option){
        $connect = new Connect;
        $bdd = $connect->connexion();
        $resultat;

        $sql = "DELETE FROM utilisateur";

        switch ($option[0]) {
            case '':
                $requete = $bdd->prepare($sql);
                $resultat = $requete->execute();
                break;
            case 'id':
                $requete = $bdd->prepare($sql." WHERE utilisateur_id=?");
		        $resultat = $requete->execute([$option[1]]);
                break;
            case 'activation':
                $requete = $bdd->prepare($sql." WHERE utilisateur_activation=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'role':
                $requete = $bdd->prepare($sql." WHERE role_id=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'specialisation':
                $requete = $bdd->prepare($sql." WHERE specialisation_id=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'nom':
                $requete = $bdd->prepare($sql." WHERE utilisateur_nom=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'prenom':
                $requete = $bdd->prepare($sql." WHERE utilisateur_prenom=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'email':
                $requete = $bdd->prepare($sql." WHERE utilisateur_email=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'telephone':
                $requete = $bdd->prepare($sql." WHERE utilisateur_telephone=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'numéro de rue':
                $requete = $bdd->prepare($sql." WHERE utilisateur_numero_de_rue=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'rue':
                $requete = $bdd->prepare($sql." WHERE utilisateur_rue=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'ville':
                $requete = $bdd->prepare($sql." WHERE utilisateur_ville=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'code postal':
                $requete = $bdd->prepare($sql." WHERE utilisateur_code_postale=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'date':
                $requete = $bdd->prepare($sql." WHERE utilisateur_date=?");
                $requete->execute([$option[1]]);
                break;
        }

		return $resultat();
    }

    public function read($option){
        $connect = new Connect;
        $bdd = $connect->connexion();

        $sql = 
        "
            SELECT utilisateur.utilisateur_id, utilisateur.utilisateur_activation, utilisateur.utilisateur_nom, utilisateur.utilisateur_prenom,
		            utilisateur.utilisateur_email, utilisateur.utilisateur_telephone, utilisateur.utilisateur_numero_de_rue, utilisateur.utilisateur_rue,
		            utilisateur.utilisateur_ville, utilisateur.utilisateur_code_postal, utilisateur.utilisateur_date, role.role_id, role.role_nom,
		            specialisation.specialisation_id, specialisation.specialisation_nom, authentification.authentification_mot_de_passe, 
                    authentification.authentification_cle_secrete, entreprise.entreprise_siren, entreprise.entreprise_activation, entreprise.entreprise_nom,
                    entreprise.entreprise_telephone, entreprise.entreprise_email, entreprise.entreprise_numero_de_rue, entreprise.entreprise_rue, entreprise.entreprise_ville,
                    entreprise.entreprise_code_postal, entreprise.entreprise_date
            FROM utilisateur
            JOIN role ON utilisateur.role_id=role.role_id
            JOIN specialisation ON utilisateur.specialisation_id = specialisation.specialisation_id
            JOIN authentification ON utilisateur.utilisateur_id = authentification.utilisateur_id
            JOIN entreprise ON utilisateur.entreprise_siren = entreprise.entreprise_siren
        ";

		switch ($option[0]) {
			case '':
                $requete = $bdd->prepare($sql);
                $resultat = $requete->execute();
                break;
            case 'id':
                $requete = $bdd->prepare($sql." WHERE utilisateur.utilisateur_id=?");
		        $resultat = $requete->execute([$option[1]]);
                break;
            case 'activation':
                $requete = $bdd->prepare($sql." WHERE utilisateur_activation=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'role':
                $requete = $bdd->prepare($sql." WHERE role_id=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'specialisation':
                $requete = $bdd->prepare($sql." WHERE specialisation_id=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'nom':
                $requete = $bdd->prepare($sql." WHERE utilisateur_nom=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'prenom':
                $requete = $bdd->prepare($sql." WHERE utilisateur_prenom=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'email':
                $requete = $bdd->prepare($sql." WHERE utilisateur_email=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'telephone':
                $requete = $bdd->prepare($sql." WHERE utilisateur_telephone=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'numéro de rue':
                $requete = $bdd->prepare($sql." WHERE utilisateur_numero_de_rue=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'rue':
                $requete = $bdd->prepare($sql." WHERE utilisateur_rue=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'ville':
                $requete = $bdd->prepare($sql." WHERE utilisateur_ville=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'code postal':
                $requete = $bdd->prepare($sql." WHERE utilisateur_code_postale=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case 'date':
                $requete = $bdd->prepare($sql." WHERE utilisateur_date=?");
                $requete->execute([$option[1]]);
                break;
        }

		$liste_utilisateurs = array();

		for($i=0; $utilisateur=$requete->fetch(); $i++){
            $entreprise = new Entreprise(
                $utilisateur['entreprise_siren'],
                $utilisateur['entreprise_activation'],
                $utilisateur['entreprise_nom'],
                $utilisateur['entreprise_telephone'],
                $utilisateur['entreprise_email'],
                $utilisateur['entreprise_numero_de_rue'],
                $utilisateur['entreprise_rue'],
                $utilisateur['entreprise_ville'],
                $utilisateur['entreprise_code_postal'],
                $utilisateur['entreprise_date']
            );

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
                $utilisateur['authentification_mot_de_passe'],
                $utilisateur['authentification_cle_secrete']
            );

            $liste_utilisateurs[$i] = new Utilisateur(
                $utilisateur['utilisateur_id'],
                $entreprise,
                $utilisateur['utilisateur_activation'],
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

            $authentification->setUtilisateur($utilisateur);
        }

		return $liste_utilisateurs;
    }

    public function update($utilisateur){
        $connect = new Connect;
        $bdd = $connect->connexion();

        $requete = $bdd->prepare("UPDATE utilisateur SET entreprise_siren = :siren, utilisateur_activation = :actif, role_id=:role, 
                                        specialisation_id=:specialisation, utilisateur_nom=:nom, utilisateur_prenom=:prenom,
                                        utilisateur_email=:email, utilisateur_telephone=:telephone, utilisateur_numero_de_rue=:numero_de_rue,
                                        utilisateur_rue=:rue, utilisateur_ville=:ville, utilisateur_code_postal=:code_postal WHERE utilisateur_id=:id");
		$resultat = $requete->execute([
            "id"=>$utilisateur->getId(),
            "siren"=>$utilisateur->getEntreprise()->getSIREN(),
            "role"=>$utilisateur->getRole()->getId(),
            "specialisation"=>$utilisateur->getSpecialisation()->getId(),
            "actif"=>$utilisateur->getActivation(),
            "nom"=>$utilisateur->getNom(),
            "prenom"=>$utilisateur->getPrenom(),
            "email"=>$utilisateur->getEmail(),
            "telephone"=>$utilisateur->getTelephone(),
            "numero_de_rue"=>$utilisateur->getNumeroderue(),
            "rue"=>$utilisateur->getRue(),
            "ville"=>$utilisateur->getVille(),
            "code_postal"=>$utilisateur->getCodepostal()
        ]);

		return $resultat;
    }
}
?>