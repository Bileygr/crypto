<?php
require_once("app/imports.php");

class EntrepriseDAO {
    public function find($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare("SELECT * FROM entreprise WHERE id=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'siret':
				$requete = $bdd->prepare("SELECT * FROM entreprise WHERE siret=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'nom':
                $requete = $bdd->prepare("SELECT * FROM entreprise WHERE nom=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'email':
                $requete = $bdd->prepare("SELECT * FROM entreprise WHERE email=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'telephone':
                $requete = $bdd->prepare("SELECT * FROM entreprise WHERE telephone=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
            case 'date':
                $requete = $bdd->prepare("SELECT * FROM entreprise WHERE date=:valeur");
                $requete->execute(["valeur" => $option["valeur"]]);
                break;
			default:
				$requete = $bdd->prepare("SELECT * FROM entreprise");
				$requete->execute();
				break;
		}

		$entreprises = array();

		for($i=0; $entreprise=$requete->fetch(); $i++){
			$entreprises[$i] = new entreprise(
                $entreprise['id'], 
                $entreprise['siret'],
                $entreprise['nom'],
                $entreprise['email'],
                $entreprise['telephone'],
                $entreprise['date']
            );
		}

		return $entreprises;
    }
}
?>