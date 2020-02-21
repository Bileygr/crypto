<?php
class Traitement{
    private $id;
    private $nom;
    private $description;
    private $liste_des_medicaments;

    public function __construct($id, $nom, $description, $liste_des_medicaments){
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->liste_des_medicaments = $liste_des_medicaments;
    }

    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getListedesmedicaments(){
        return $this->liste_des_medicaments;
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

    public function setListedesmedicaments($liste_des_medicaments){
        $this->liste_des_medicaments = $liste_des_medicaments;
    }
}
?>