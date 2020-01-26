<?php
require_once("app/imports.php");
require_once("app/controlleur/ControlleurDefaut.php");
$controlleur = new ControlleurDefaut;
$controlleur->connexion();
?>