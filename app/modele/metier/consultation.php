<?php
class Consultation {
    private $id;
    private $docteur;
    private $patient;
    private $diagnostique;
    private $prix;
    private $date;

    public function __construct($id, $docteur, $patient, $diagnostique, $prix, $date){
        $this->id = $id;
        $this->docteur = $docteur;
        $this->patient = $patient;
        $this->maladie = $diagnostique;
        $this->prix = $prix;
        $this->date = $date;
    }

    public function getId(){
        return $this->id;
    }

    public function getDocteur(){
        return $this->docteur;
    }

    public function getPatient(){
        return $this->patient;
    }

    public function getDiagnostique(){
        return $this->diagnostique;
    }

    public function getPrix(){
        return $this->prix;
    }

    public function getDate(){
        return $this->date;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDocteur($docteur)
    {
        $this->docteur = $docteur;
    }

    public function setPatient($patient){
        $this->patient = $patient;
    }

    public function setDiagnostique($diagnostique){
        $this->diagnostique = $diagnostique;
    }

    public function setPrix($prix){
        $this->prix = $prix;
    }

    public function setDate($date){
        $this->date = $date;
    }
}
?>