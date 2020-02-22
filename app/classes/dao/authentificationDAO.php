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
            case "":
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
			case "id":
				$requete = $bdd->prepare($sql." WHERE utilisateur_id=?");
				$resultat = $requete->execute([$option[1]]);
				break;
			case "mdp":
				$requete = $bdd->prepare($sql." WHERE authentification_mot_de_passe=?");
				$resultat = $requete->execute([$option[1]]);
                break;
            case "cle":
                $requete = $bdd->prepare($sql." WHERE authentification_cle_Secrete=?");
                $resultat = $requete->execute([$option[1]]);
                break;
        }
        
        return $resultat;
    }

    public function read($option){
        $connect = new Connect;
		$bdd = $connect->connexion();

        $sql = "SELECT * FROM authentification";

		switch ($option[0]){
            case "":
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
			case "id":
				$requete = $bdd->prepare($sql." WHERE utilisateur_id=?");
				$requete->execute([$option[1]]);
				break;
			case "mdp":
				$requete = $bdd->prepare($sql." WHERE authentification_mot_de_passe=?");
				$requete->execute([$option[1]]);
                break;
            case "cle":
                $requete = $bdd->prepare($sql." WHERE authentification_cle_Secrete=?");
                $requete->execute([$option[1]]);
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
        
        $requete = $bdd->prepare("UPDATE authentification SET authentification_mot_de_passe=?, authentification_cle_secrete=? WHERE utilisateur_id=?");
		$resultat = $requete->execute([
            $authentification->getMotdepasse(),
            $authentification->getClesecrete(),
            $authentification->getUtilisateur()->getId()
        ]);

        return $resultat;
    }
}
?>