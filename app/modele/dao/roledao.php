<?php
require_once("app/imports.php");

class RoleDAO implements CRUD {
	public function create($role){
		$connect = new Connect;
		$type_de_connexion = parse_ini_file("conf/settings.ini", true)["type"]["nom"];
		$bdd = $connect->connexion($type_de_connexion);

		$requete = $bdd->prepare("INSERT INTO role(role_nom) VALUES(:nom)");
		$requete->execute(["nom" => $option["nom"]]);

		//$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        //$connect = null;
		return $requete->fetch();
	}

    public function read($option){
		$connect = new Connect;
		$type_de_connexion = parse_ini_file("conf/settings.ini", true)["type"]["nom"];
		$bdd = $connect->connexion($type_de_connexion);

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

		//$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        //$connect = null;
		return $requete->fetchAll();
	}

	public function update($role){
		$connect = new Connect;
		$type_de_connexion = parse_ini_file("conf/settings.ini", true)["type"]["nom"];
		$bdd = $connect->connexion($type_de_connexion);

		$requete = $bdd->prepare("UPDATE role SET role_nom=:nom WHERE role_id=:id");
		$requete->execute(["id" => $role->getId(), "nom"=>$role->getNom()]);

		//$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        //$connect = null;
		return $requete->fetch();
	}

	public function delete($option){
		$connect = new Connect;
		$type_de_connexion = parse_ini_file("conf/settings.ini", true)["type"]["nom"];
		$bdd = $connect->connexion($type_de_connexion);

		$sql = "DELETE FROM utilisateur WHERE role_id=:id";

		switch ($option["option"]) {
			case "id":
				$requete = $bdd->prepare($sql." WHERE role_id=:id");
				$requete->execute(["id" => $role->getId()]);
				break;
			case "nom":
				$requete = $bdd->prepare($sql." WHERE role_nom=:nom");
				$requete->execute(["nom" => $role->getNom()]);
				break;
			default:
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
		}

		//$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
        //$connect = null;
		return $requete->fetch();
	}
}
?>