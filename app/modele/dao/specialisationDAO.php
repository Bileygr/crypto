<?php
require_once("app/imports.php");

class SpecialisationDAO {
    public function delete($option){

    }

    public function find($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

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

		$specialisations = array();

		for($i=0; $specialisation=$requete->fetch(); $i++){
			$specialisations[$i] = new Specialisation($specialisation['specialisation_id'], $specialisation['specialisation_nom']);
		}

		$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        $connect = null;
		return $specialisations;
    }

    public function persist($specialisation){

    }

    public function update($specialisation){

    }
}
?>