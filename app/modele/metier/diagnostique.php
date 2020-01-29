<?php
class Diagnostique{
    private $consultation;
    private $maladie;
    private $note;
    private $date;

    public function __construct($consultation, $maladie, $note, $date){
        $this->consultation = $consultation;
        $this->maladie = $maladie;
        $this->note = $note;
        $this->date;
    }

    public function getConsultation(){
        return $this->consultation;
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

    public function setConsultation($consultation){
        $this->consultation = $consultation;
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