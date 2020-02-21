<?php
class AuthentificationDAO implements CRUD{
    public function create($authentification){
        $connect = new Connect;
        $bdd = $connect->connexion();
        
        $requete = $bdd->prepare("INSERT INTO authentification(utilisateur_id, authentification_mot_de_passe, authentification_cle_secrete) VALUES(?, ?, ?)");
		$resultat = $requete->execute([
            $authentification->getUtilisateur()->getId(),
            $authentification->getMotdepasse(),
            $authentification->getClesecrete()
        ]);

        return $resultat;
    }

    public function delete($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

        $sql = "DELETE FROM authentification";

		switch ($option[0]) {
			case 'id':
				$requete = $bdd->prepare($sql." WHERE utilisateur_id=:valeur");
				$resultat = $requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'mdp':
				$requete = $bdd->prepare($sql." WHERE authentification_mot_de_passe=:valeur");
				$resultat = $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'clé':
                $requete = $bdd->prepare($sql." WHERE prenom=:valeur");
                $resultat = $requete->execute(["valeur" => $option["valeur"]]);
                break;
			default:
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
        }
        
        return $resultat;
    }

    public function read($option){
        var_dump($option);
        exit;
        $connect = new Connect;
		$bdd = $connect->connexion();

        $sql = "SELECT * FROM authentification";

		switch ($option[0]) {
            case "":
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
			case "id":
				$requete = $bdd->prepare($sql." WHERE utilisateur_id=:valeur");
				$requete->execute(["valeur" => $option[1]]);
				break;
			case "mdp":
				$requete = $bdd->prepare($sql." WHERE authentification_mot_de_passe=:valeur");
				$requete->execute(["valeur" => $option[1]]);
                break;
            case "cle":
                $requete = $bdd->prepare($sql." WHERE prenom=:valeur");
                $requete->execute(["valeur" => $option[1]]);
                break;
		}

		$liste_authentifications = array();

		for($i=0; $authentification=$requete->fetch(); $i++){
            $liste_authentifications[$i] = new Authentification(
                $authentification["utilisateur_id"],
                $authentification['authentification_mot_de_passe'],
                $authentification['authentification_cle_secrete']
            );
        }

		return $liste_authentifications;
    }

    public function update($authentification){
        $connect = new Connect;
        $bdd = $connect->connexion();
        
        $requete = $bdd->prepare("UPDATE authentification SET utilisateur_id=?, authentification_mot_de_passe=?, authentification_cle_secrete=?");
		$resultat = $requete->execute([
            $authentification->getUtilisateur()->getId(),
            $authentification->getMotdepasse(),
            $authentification->getClesecrete()
        ]);

        return $resultat;
    }
}
?>