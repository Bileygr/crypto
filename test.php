<?php 
require_once("imports.php");
$dao = new UtilisateurDAO();
$liste = $dao->read(["id", 2]);
if(!empty($liste)){
    var_dump($liste);
}else{
    echo "Test a échoué.";
}
?>