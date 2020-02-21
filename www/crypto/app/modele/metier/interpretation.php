<?php
class Interpretation {
    private $examen;
    private $docteur;
    private $maladie;
    private $note;
    private $date;

    public function __construct($examen, $docteur, $maladie, $note, $date){
        $this->examen = $examen;
        $this->docteur = $docteur;
        $this->maladie = $maladie;
        $this->note = $note;
        $this->date;
    }

    public function getExamen(){
        return $this->examen;
    }

    public function getDocteur(){
        return $this->docteur;
    }

    public function getMaladie(){
        return $this->maladie;
    }

    public function getNote(){
        return $this->note;
    }

    public function getDate(){
        return $this->date;
    }

    public function setExamen($examen){
        $this->examen = $examen;
    }

    public function setDocteur($docteur){
        $this->docteur = $docteur;
    }

    public function setMaladie($maladie){
        $this->maladie = $maladie;
    }

    public function setNote($note){
        $this->note = $note;
    }

    public function setDate($date){
        $this->date = $date;
    }
}
?>