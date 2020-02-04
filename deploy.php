<?php
require_once("conf/connect.php");

$connect = new Connect;
$pgsql = $connect->connexion("pgsql");
$resultat = $pgsql->exec(file_get_contents("conf/pgsql/bdd.sql"));

if($resultat == 0 || $resultat != False){
    $mysql = $connect->connexion("mysql");
    $resultat = $mysql->exec(file_get_contents("conf/mysql/bdd.sql"));

    if($resultat == 0 || $resultat != False){
        header("Location: index.php");
    }else{
        echo "Erreur 2";
    }
}else{
    echo "Erreur 1";
}
?>