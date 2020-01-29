<?php
require_once("conf/connect.php");
$connect = new Connect;
$bdd = $connect->connexion();
$requete = $bdd->prepare("SELECT * FROM authentification");
$requete->execute([]);
$r=$requete->fetchAll();
var_dump($r);
$connect->connexion()->prepare("SELECT pg_terminate_backend(pg_backend_pid())")->execute();
$connect = null;
?>