<?php
class SpecialisationDAO implements CRUD {
	public function create($specialisation){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$requete = $bdd->prepare("INSERT INTO specialisation(specialisation_nom) VALUES(?)");
		$resultat = $requete->execute([$specialisation->getNom()]);

		return $resultat;
	}
	
	public function delete($option){
		$connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

		$sql = "DELETE FROM specialisation";

		switch ($option[0]) {
			case '':
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
			case 'id':
				$requete = $bdd->prepare($sql." WHERE specialisation_id=?");
				$resultat = $requete->execute([$option[1]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE specialisation_nom=?");
				$resultat = $requete->execute([$option[1]]);
				break;
		}

		return $resultat;
	}

    public function read($option){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$sql = "SELECT * FROM specialisation";

		switch ($option[0]) {
			case '':
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
			case 'id':
				$requete = $bdd->prepare($sql." WHERE specialisation_id=?");
				$resultat = $requete->execute([$option[1]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE specialisation_nom=?");
				$resultat = $requete->execute([$option[1]]);
				break;
		}

		$liste_specialisations = array();

		for($i=0; $specialisation=$requete->fetch(); $i++){
            $liste_specialisations[$i] = new Specialisation(
                $specialisation["specialisation_id"],
                $specialisation['specialisation_nom']
            );
        }

		return $liste_specialisations;
    }

    public function update($specialisation){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$requete = $bdd->prepare("UPDATE specialisation SET specialisation_nom=? WHERE specialisation_id=?");
		$resultat = $requete->execute([
			$specialisation->getNom(),
			$specialisation->getId()
		]);

		return $resultat;
	}
}
?>