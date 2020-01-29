<?php
class Traitement{
    private $id;
    private $description;
    private $liste_des_medicaments;

    public function __construct($id, $description, $liste_des_medicaments){
        $this->id = $id;
        $this->description = $description;
        $this->liste_des_medicaments = $liste_des_medicaments;
    }

    public function getId(){
        return $this->id;
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

    public function setDescription($description){
        $this->description = $description;
    }

    public function setListedesmedicaments($liste_des_medicaments){
        $this->liste_des_medicaments = $liste_des_medicaments;
    }
}
?>