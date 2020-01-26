<?php
require_once("app/imports.php");

class RoleDAO implements DAO {
    public function find($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare("SELECT * FROM role WHERE id=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'titre':
				$requete = $bdd->prepare("SELECT * FROM role WHERE titre=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			default:
				$requete = $bdd->prepare("SELECT * FROM role");
				$requete->execute();
				break;
		}

		$roles = array();

		for($i=0; $role=$requete->fetch(); $i++){
			$roles[$i] = new role($role['id'], $role['titre']);
		}

		return $roles;
	}
	
	public function persist($role){

	}
}
?>