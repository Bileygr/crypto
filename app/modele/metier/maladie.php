<?php
class Maladie{
    private $id;
    private $nom;
    private $description;
    private $liste_des_symptomes;
    private $traitement;

    public function __construct($id, $description, $liste_des_symptomes, $traitement){
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->liste_des_symptomes = $liste_des_symptomes;
        $this->traitement = $traitement;
    }

    public function getId(){
        return $this->id = $id;
    }

    public function getNom(){
        return $this->nom = $nom;
    }

    public function getDescription(){
        return $this->description = $description;
    }

    public function getListedessymptomes(){
        return $this->liste_des_symptomes;
    }

    public function getTraitement(){
        return $this->traitement;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setListedessymptomes($liste_des_symptomes){
        $this->liste_des_symptomes = $liste_des_symptomes;
    }

    public function setTraitement($traitement){
        $this->traitement = $traitement;
    }
}
?>