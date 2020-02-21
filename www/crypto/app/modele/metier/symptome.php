<?php
class Symptome{
    private $id;
    private $nom;
    private $description;

    public function __construct($i, $nom, $description){
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
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

    public function setId($id){
        $this->id = $id;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setDescription($description){
        $this->description = $description;
    }
}
?>