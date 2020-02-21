<?php
class Utilisateur {
    private $id;
    private $entreprise;
    private $activation;
    private $role;
    private $specialisation;
    private $authentification;
    //private $liste_des_consultations;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $numero_de_rue;
    private $rue;
    private $ville;
    private $code_postal;
    private $date;

    public function __construct($id, $entreprise, $activation, $role, $specialisation, $authentification, $nom, $prenom, $email, $telephone, $numero_de_rue, $rue, $ville, $code_postal, $date){
        $this->id = $id;
        $this->entreprise = $entreprise;
        //if($activation==True || $activation==1){
            $this->activation = $activation;
        //}elseif($activation==False || $activation==0){
           // $this->activation = 0;
        //}
        $this->role = $role;
        $this->specialisation = $specialisation;
        $this->authentification = $authentification;
        //$this->liste_des_consultations = $liste_des_consultations;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->numero_de_rue = $numero_de_rue;
        $this->rue = $rue;
        $this->ville = $ville;
        $this->code_postal = $code_postal;
        $this->date = $date;
    }

    public function getId(){
        return $this->id;
    }

    public function getEntreprise(){
        return $this->entreprise;
    }

    public function getActivation(){
        return $this->activation;
    }

    public function getRole(){
        return $this->role;
    }

    public function getSpecialisation(){
        return $this->specialisation;
    }

    public function getAuthentification(){
        return $this->authentification;
    }

    public function getListedesconsultations(){
        return $this->liste_des_consultations;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getTelephone(){
        return $this->telephone;
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

    public function setId($id){
        $this->id = $id;
    }

    public function setEntreprise($entreprise){
        $this->entreprise = $entreprise;
    }

    public function setActivation($activation){
        $this->activation = $activation;
    }
    
    public function setSpecialisation($specialisation){
        $this->specialisation = $specialisation;
    }

    public function setRole($role){
        $this->role = $role;
    }

    public function setAuthentification($authentification){
        $this->authentification = $authentification;
    }

    public function setListedesconsultations($liste_des_consultations){
        $this->liste_des_consultations = $liste_des_consultations;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setTelephone($telephone){
        $this->telephone = $telephone;
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