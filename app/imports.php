<?php
/**
 * Importe tout les fichiers dont le projet à besoin.
 */

/*
Fait appel à la classe qui permet de 
faire afficher des données dans les templates
*/
require_once("controlleur/moteur.php");

require_once("GoogleAuthenticator.php");

// Classes métier
require_once("modele/metier/authentification.php");
require_once("modele/metier/entreprise.php");
require_once("modele/metier/role.php");
require_once("modele/metier/utilisateur.php");

// Classes DAO (requêtes SQL)
require_once("modele/dao/authentificationdao.php");
require_once("modele/dao/entrepriseDAO.php");
require_once("modele/dao/roleDAO.php");
require_once("modele/dao/utilisateurDAO.php");

// Classe qui permet la connexion à la base de données
require_once("conf/connect.php");
?>