<?php
class Docteur {
    private $utilisateur;
    private $role;
    private $specialisation;

    /**
     * Docteur constructor.
     * @param $utilisateur
     * @param $role
     * @param $specialisation
     */
    public function __construct($utilisateur, $role, $specialisation)
    {
        $this->utilisateur = $utilisateur;
        $this->role = $role;
        $this->specialisation = $specialisation;
    }

    /**
     * @return mixed
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * @param mixed $utilisateur
     */
    public function setUtilisateur($utilisateur)
    {
        $this->utilisateur = $utilisateur;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getSpecialisation()
    {
        return $this->specialisation;
    }

    /**
     * @param mixed $specialisation
     */
    public function setSpecialisation($specialisation)
    {
        $this->specialisation = $specialisation;
    }


}
?>