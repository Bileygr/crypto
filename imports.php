<?php
/**
 * Importe tout les fichiers dont le projet à besoin.
 */

/*
 * Fait appel à la classe qui permet de faire afficher des données dans les templates.
*/
require_once("app/controlleur/moteur.php");

require_once("app/totp/GoogleAuthenticator.php");

// Classes métier
require_once("app/modele/metier/authentification.php");
require_once("app/modele/metier/entreprise.php");
require_once("app/modele/metier/examen.php");
require_once("app/modele/metier/interpretation.php");
require_once("app/modele/metier/maladie.php");
require_once("app/modele/metier/medicament.php");
require_once("app/modele/metier/role.php");
require_once("app/modele/metier/specialisation.php");
require_once("app/modele/metier/symptome.php");
require_once("app/modele/metier/traitement.php");
require_once("app/modele/metier/utilisateur.php");

// Classes DAO (requêtes SQL)
require_once("app/modele/dao/CRUD.php");
require_once("app/modele/dao/authentificationdao.php");
require_once("app/modele/dao/entrepriseDAO.php");
require_once("app/modele/dao/specialisationDAO.php");
require_once("app/modele/dao/roleDAO.php");
require_once("app/modele/dao/utilisateurDAO.php");

// Classe qui permet la connexion à la base de données
require_once("conf/connect.php");
?>