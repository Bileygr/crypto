<?php
class EntrepriseDAO implements CRUD {
    public function create($entreprise){
        $connect = new Connect;
        $bdd = $connect->connexion();

        $status = 0;

        if($entreprise->getActivation() != FALSE){
            $status = 1;
        }

        $requete = $bdd->prepare("INSERT INTO entreprise(entreprise_siren, entreprise_activation, entreprise_nom, entreprise_email, entreprise_telephone,
                                                entreprise_numero_de_rue, entreprise_rue, entreprise_ville, entreprise_code_postal) 
                                    VALUES(:siren, :activation, :nom, :email, :telephone, :numero_de_rue, :rue, :ville, :code_postal)");
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

    public function delete($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

        $sql = "DELETE FROM entreprise";

		switch ($option[0]) {
            case "":
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
			case "siren":
				$requete = $bdd->prepare($sql." WHERE entreprise_siren=?");
				$resultat = $requete->execute([$option[1]]);
				break;
			case "activation":
				$requete = $bdd->prepare($sql." WHERE entreprise_activation=?");
				$resultat = $requete->execute([$option[1]]);
                break;
            case "nom":
                $requete = $bdd->prepare($sql." WHERE entreprise_nom=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case "telephone":
                $requete = $bdd->prepare($sql." WHERE entreprise_telephone=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case "email":
                $requete = $bdd->prepare($sql." WHERE entreprise_email=?");
                $resultat = $requete->execute([$option[1]]);
                break;
        }
        
        return $resultat;
    }

    public function read($option){
        $connect = new Connect;
		$bdd = $connect->connexion();

		$sql = "SELECT * FROM entreprise";

		switch ($option[0]) {
			case "":
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
			case "siren":
				$requete = $bdd->prepare($sql." WHERE entreprise_siren=?");
				$resultat = $requete->execute([$option[1]]);
				break;
			case "activation":
				$requete = $bdd->prepare($sql." WHERE entreprise_activation=?");
				$resultat = $requete->execute([$option[1]]);
                break;
            case "nom":
                $requete = $bdd->prepare($sql." WHERE entreprise_nom=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case "telephone":
                $requete = $bdd->prepare($sql." WHERE entreprise_telephone=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case "email":
                $requete = $bdd->prepare($sql." WHERE entreprise_email=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case "ville":
                $requete = $bdd->prepare($sql." WHERE entreprise_ville=?");
                $resultat = $requete->execute([$option[1]]);
                break;
            case "cp":
                $requete = $bdd->prepare($sql." WHERE entreprise_code_postal=?");
                $resultat = $requete->execute([$option[1]]);
                break;
		}

        $liste_entreprises = array();

		for($i=0; $entreprise=$requete->fetch(); $i++){
            $liste_entreprises[$i] = new Entreprise(
                $entreprise["entreprise_siren"],
                $entreprise['entreprise_activation'],
                $entreprise['entreprise_nom'],
                $entreprise['entreprise_telephone'],
                $entreprise['entreprise_email'],
                $entreprise['entreprise_numero_de_rue'],
                $entreprise['entreprise_rue'],
                $entreprise['entreprise_ville'],
                $entreprise['entreprise_code_postal'],
                $entreprise['entreprise_date']
            );
        }

		return $liste_entreprises;
    }

    public function update($entreprise){
		$connect = new Connect;
        $bdd = $connect->connexion();

        $requete = $bdd->prepare("UPDATE entreprise SET entreprise_activation=:activation,  entreprise_nom=:nom, 
			entreprise_telephone=:telephone, entreprise_email=:email, entreprise_numero_de_rue=:numero_de_rue, entreprise_rue=:rue, entreprise_ville=:ville,
			entreprise_code_postal=:code_postal WHERE entreprise_siren=:siren");
		
		$resultat = $requete->execute([
            "siren"=>$entreprise->getSIREN(),
            "activation"=>$entreprise->getActivation(),
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