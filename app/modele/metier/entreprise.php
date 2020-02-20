<?php
class Entreprise {
    private $SIREN;
    private $activation;
    private $nom;
    private $telephone;
    private $email;
    private $numero_de_rue;
    private $rue;
    private $ville;
    private $code_postal;
    private $date;

    public function __construct($SIREN, $activation, $nom, $telephone, $email, $numero_de_rue, $rue, $ville, $code_postal, $date){
        $this->SIREN = $SIREN;
        $this->acivation = $activation;
        $this->nom = $nom;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->numero_de_rue = $numero_de_rue;
        $this->rue = $rue;
        $this->ville = $ville;
        $this->code_postal = $code_postal;
        $this->date = $date;
    }

    public function getSIREN(){
        return $this->SIREN;
    }

    public function getActivation(){
        return $this->activation;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getTelephone(){
        return $this->telephone;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getNumeroderue(){
        return $this->numero_de_rue;
    }

    public function getRue(){
        return $this->rue;
    }

    public function getVille(){
        return $this->ville;
    }

    public function getCodepostal(){
        return $this->code_postal;
    }

    public function getDate(){
        return $this->date;
    }

    public function setSIREN($SIREN){
        $this->SIREN = $SIREN;
    }

    public function setActivation($activation){
        $this->activation = $activation;
    }

    public function setTelephone($telephone){
        $this->telephone = $telephone;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setNumeroderue($numero_de_rue){
        $this->numero_de_rue = $numero_de_rue;
    }

    public function setRue($rue){
        $this->rue = $rue;
    }

    public function setVille($ville){
        $this->ville = $ville;
    }

    public function setCodepostal($code_postal){
        $this->code_postal = $code_postal;
    }

    public function setDate($date){
        $this->date = $date;
    }
}
?>