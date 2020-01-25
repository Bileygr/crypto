<?php
class Moteur{
	private $vars = array();

	public function assigner($parametre, $valeur){
		$this->vars[$parametre] = $valeur;
	}

	public function affichage($vue){
		$repertoire = "app/vue/";
		if(file_exists($repertoire.$vue)){
			$contenu = file_get_contents($repertoire.$vue);
			
			foreach ($this->vars as $parametre => $valeur){
				$contenu = preg_replace("/\{\{\s".$parametre."\s\}\}/", $valeur, $contenu);
			}
			echo $contenu;
		}else{
			exit('<h1 style="color: red;">Erreur de template.</h1>');
		}
	}
}
?>