<?php
class Connect{
	public function Connexion(){
		$settings = parse_ini_file("settings.ini", true);
		$host = $settings["database"]["host"];
		$port = $settings["database"]["port"];
		$db = $settings["database"]["db"];
		$user = $settings["database"]["user"];
		$password = $settings["database"]["password"];

		try{
			$db = new PDO("pgsql:host=".$host.";port=".$port.";dbname=".$db.";", $user, $password);
		}catch(Exception $e){
			echo "Échec lors de la connexion: ".$e->getMessage();
		}
		
		return $db;
	}
}
?>