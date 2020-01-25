<?php
class Utilisateur {
    private $id;
    private $actif;
    private $authentification;
    private $entreprise;
    private $role;
    private $nom;
    private $prenom;
    private $email;
    private $telephone;
    private $date_ajout;

    public function __construct($id, $actif, $authentification, $entreprise, $role, $nom, $prenom, $email, $telephone, $date_ajout){
        $this->id = $id;
        if($actif=True){
            $this->actif = 1;
        }elseif($actif=False){
            $this->actif = 0;
        }
        $this->authentification = $authentification;
        $this->entreprise = $entreprise;
        $this->role = $role;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->date_ajout = $date_ajout;
    }

    public function getId(){
        return $this->id;
    }

    public function getActif(){
        return $this->actif;
    }

    public function getAuthentification(){
        return $this->authentification;
    }

    public function getEntreprise(){
        return $this->entreprise;
    }

    public function getRole(){
        return $this->role;
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

    public function getDateajout(){
        return $this->date_ajout;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setActif($actif){
        $this->actif = $actif;
    }

    public function setAuthentification($authentification){
        $this->authentification = $authentification;
    }

    public function setEntreprise($entreprise){
        $this->entreprise = $entreprise;
    }

    public function setRole($role){
        $this->role = $role;
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

    public function setDateajout($date_ajout){
        $this->date_ajout = $date_ajout;
    }
}
?>