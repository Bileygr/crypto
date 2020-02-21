<?php 
require_once("imports.php");
$authentificationdao = new AuthentificationDAO();
$liste_authentification = $authentificationdao->read(["cle", "UYQO3LQ3OGGMVQHE"]);
var_dump($liste_authentification);
?>