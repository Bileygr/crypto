<?php
require_once("app/imports.php");

class RoleDAO implements DAO {
	public function delete($option){

	}

    public function find($option){
        $connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

		$sql = "SELECT * FROM role";

		switch ($option["option"]) {
			case 'id':
				$requete = $bdd->prepare($sql." WHERE role_id=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			case 'titre':
				$requete = $bdd->prepare($sql." WHERE role_nom=:valeur");
				$requete->execute(["valeur" => $option["valeur"]]);
				break;
			default:
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
		}

		$roles = array();

		for($i=0; $role=$requete->fetch(); $i++){
			$roles[$i] = new Role($role['role_id'], $role['role_nom']);
		}

		$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        $connect = null;
		return $roles;
	}
	
	public function persist($role){

	}

	public function update($role){

	}
}
?>