<?php
class RoleDAO implements CRUD {
	public function create($role){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$requete = $bdd->prepare("INSERT INTO role(role_nom) VALUES(?)");
		$requete->execute([$role->getNom()]);

		return $requete->fetch();
	}

	public function delete($option){
		$connect = new Connect;
		$bdd = $connect->connexion();
		$resultat;

		$sql = "DELETE FROM role";

		switch ($option[0]) {
			case "":
				$requete = $bdd->prepare($sql);
				$resultat = $requete->execute();
				break;
			case "id":
				$requete = $bdd->prepare($sql." WHERE role_id=?");
				$resultat = $requete->execute([$role->getId()]);
				break;
			case "nom":
				$requete = $bdd->prepare($sql." WHERE role_nom=?");
				$resultat = $requete->execute([$role->getNom()]);
				break;
		}

		return $resultat;
	}

    public function read($option){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$sql = "SELECT * FROM role";

		switch ($option[0]) {
			case "":
				$requete = $bdd->prepare($sql);
				$requete->execute();
				break;
			case 'id':
				$requete = $bdd->prepare($sql." WHERE role_id=?");
				$requete->execute([$option[1]]);
				break;
			case 'nom':
				$requete = $bdd->prepare($sql." WHERE role_nom=?");
				$requete->execute([$option[1]]);
				break;
		}

		$liste_roles = array();

		for($i=0; $role=$requete->fetch(); $i++){
            $liste_roles[$i] = new Role(
                $role["role_id"],
                $role['role_nom']
            );
        }

		return $liste_roles;
	}

	public function update($role){
		$connect = new Connect;
		$bdd = $connect->connexion();

		$requete = $bdd->prepare("UPDATE role SET role_nom=? WHERE role_id=?");
		$resultat = $requete->execute([$role->getNom(), $role->getId()]);

		return $resultat;
	}
}
?>