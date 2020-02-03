<?php
/**
 * Importe tout les fichiers dont le projet à besoin.
 */

/*
 * Fait appel à la classe qui permet de faire afficher des données dans les templates.
*/
require_once("controlleur/moteur.php");

require_once("totp/GoogleAuthenticator.php");

// Classes métier
require_once("modele/metier/authentification.php");
require_once("modele/metier/consultation.php");
require_once("modele/metier/diagnostique.php");
require_once("modele/metier/maladie.php");
require_once("modele/metier/medicament.php");
require_once("modele/metier/role.php");
require_once("modele/metier/specialisation.php");
require_once("modele/metier/symptome.php");
require_once("modele/metier/traitement.php");
require_once("modele/metier/utilisateur.php");

// Classes DAO (requêtes SQL)
require_once("modele/dao/CRUD.php");
require_once("modele/dao/authentificationdao.php");
require_once("modele/dao/specialisationDAO.php");
require_once("modele/dao/roleDAO.php");
require_once("modele/dao/utilisateurDAO.php");

// Classe qui permet la connexion à la base de données
require_once("conf/connect.php");
?>