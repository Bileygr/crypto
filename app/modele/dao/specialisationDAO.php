<?php
//require_once("app/imports.php");

class SpecialisationDAO implements CRUD {
	public function create($specialisation){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$requete = $bdd->prepare("INSERT INTO specialisation(specialisation_nom) VALUES(:nom)");
		$resultat = $requete->execute(["nom"=>$specialisation->getNom()]);

		return $resultat;
	}
	
	public function delete($option){
		$connect = new Connect;
		$type_de_connexion = parse_ini_file("conf/settings.ini", true)["type"]["nom"];
		$bdd = $connect->connexion($type_de_connexion);
		$resultat;

		$sql = "DELETE FROM specialisation";

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare($sql." WHERE specialisation_id=:valeur");
				$resultat = $requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE specialisation_nom=:valeur");
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
		$connect = new Connect;
		$bdd = $connect->connexion();

		$sql = "SELECT * FROM specialisation";

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare($sql." WHERE specialisation_id=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE specialisation_nom=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			default:
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
		}

		return $requete->fetchAll();
    }

    public function update($specialisation){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$requete = $bdd->prepare("UPDATE specialisation SET specialisation_nom=:nom WHERE specialisation_id=:id");
		$resultat = $requete->execute([
			"id" => $specialisation->getId(),
			"nom"=> $specialisation->getNom()
		]);

		return $resultat;
	}
}
?>