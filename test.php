<?php 
require_once("imports.php");
$googleAuthenticator = new PHPGangsta_GoogleAuthenticator();
$url_du_code_qr = $googleAuthenticator->getQRCodeGoogleUrl("Télémédecine (mattdrisse@gmail.com)", "SXUXAOU47ZJFTTDP");
echo "<img src=".$url_du_code_qr."/>";
?>