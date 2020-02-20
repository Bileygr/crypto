<?php
//require_once("app/imports.php");

class EntrepriseDAO implements CRUD {
    public function create($entreprise){

    }

    public function delete($option){

    }

    public function read($option){
        $connect = new Connect;
		$bdd = $connect->connexion();

		$sql = "SELECT * FROM entreprise";

		switch ($option["option"]) {
			case 'siren':
				$requete = $bdd->prepare($sql." WHERE entreprise_siren=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'titre':
				$requete = $bdd->prepare($sql." WHERE entreprise_nom=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			default:
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
		}

		return $requete->fetchAll();
    }

    public function update($entreprise){
		
    }
}
?>