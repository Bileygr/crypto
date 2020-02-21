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
			case 'nom':
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
		$connect = new Connect;
        $bdd = $connect->connexion();

        $status = 0;

        if($entreprise->getActivation() != FALSE){
            $status = 1;
        }

        $requete = $bdd->prepare("UPDATE entreprise SET entreprise_siren = :siren, entreprise_activation=:activation,  entreprise_nom=:nom, 
			entreprise_telephone=:telephone, entreprise_email=:email, entreprise_numero_de_rue=:numero_de_rue, entreprise_rue=:rue, entreprise_ville=:ville,
			entreprise_code_postal=:code_postal WHERE entreprise_siren=:siren");
		
		$resultat = $requete->execute([
            "siren"=>$entreprise->getSIREN(),
            "activation"=>$status,
            "nom"=>$entreprise->getNom(),
            "email"=>$entreprise->getEmail(),
            "telephone"=>$entreprise->getTelephone(),
            "numero_de_rue"=>$entreprise->getNumeroderue(),
            "rue"=>$entreprise->getRue(),
            "ville"=>$entreprise->getVille(),
            "code_postal"=>$entreprise->getCodepostal()
        ]);

		return $resultat;
    }
}
?>