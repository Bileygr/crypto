<?php
/**
 * Importe tout les fichiers dont le projet à besoin.
*/

// TOTP
require_once("app/totp/GoogleAuthenticator.php");

// Classes métier
require_once("app/classes/metier/authentification.php");
require_once("app/classes/metier/entreprise.php");
require_once("app/classes/metier/examen.php");
require_once("app/classes/metier/interpretation.php");
require_once("app/classes/metier/maladie.php");
require_once("app/classes/metier/medicament.php");
require_once("app/classes/metier/role.php");
require_once("app/classes/metier/specialisation.php");
require_once("app/classes/metier/symptome.php");
require_once("app/classes/metier/traitement.php");
require_once("app/classes/metier/utilisateur.php");

// Classes DAO (requêtes SQL)
require_once("app/classes/dao/CRUD.php");
require_once("app/classes/dao/authentificationDAO.php");
require_once("app/classes/dao/entrepriseDAO.php");
require_once("app/classes/dao/specialisationDAO.php");
require_once("app/classes/dao/roleDAO.php");
require_once("app/classes/dao/utilisateurDAO.php");

// Classe qui permet la connexion à la base de données
require_once("conf/connect.php");
?>
