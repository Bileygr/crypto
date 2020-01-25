<?php
class Consultation {
    private $id;
    private $docteur;
    private $patient;
    private $maladie;
    private $prix;

    public function __construct($id, $docteur, $patient, $maladie, $prix){
        $this->id = $id;
        $this->docteur = $docteur;
        $this->patient = $patient;
        $this->maladie = $maladie;
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDocteur()
    {
        return $this->docteur;
    }

    /**
     * @param mixed $docteur
     */
    public function setDocteur($docteur)
    {
        $this->docteur = $docteur;
    }

    /**
     * @return mixed
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @param mixed $patient
     */
    public function setPatient($patient)
    {
        $this->patient = $patient;
    }

    /**
     * @return mixed
     */
    public function getMaladie()
    {
        return $this->maladie;
    }

    /**
     * @param mixed $maladie
     */
    public function setMaladie($maladie)
    {
        $this->maladie = $maladie;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }
}
?>