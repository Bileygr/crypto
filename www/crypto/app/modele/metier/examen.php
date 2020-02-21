<?php
class Examen {
    private $id;
    private $docteur;
    private $patient;
    private $interpretation;
    private $prix;
    private $date;

    public function __construct($id, $docteur, $patient, $interpretation, $prix, $date){
        $this->id = $id;
        $this->docteur = $docteur;
        $this->patient = $patient;
        $this->interpretation = $interpretation;
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

    public function getInterpretation(){
        return $this->interpretation;
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

    public function setInterpretation($interpretation){
        $this->interpretation = $interpretation;
    }

    public function setPrix($prix){
        $this->prix = $prix;
    }

    public function setDate($date){
        $this->date = $date;
    }
}
?>