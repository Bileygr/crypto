<?php
class Connect{
	public function connexion($type){
		/*
		$settings = parse_ini_file("settings.ini", true);
		$host = $settings[$type]["host"];
		$port = $settings[$type]["port"];
		$db = $settings[$type]["db"];
		$user = $settings[$type]["user"];
		$password = $settings[$type]["password"];
		*/
		$user = "ckeita";
		$password = "@Crownclown_91";
		$db = "";
		try{
			$db = new PDO("mysql:host=192.168.1.10;port=;dbname=telemedecine;", $user, $password);
		}catch(Exception $e){
			echo "Échec lors de la connexion: ".$e->getMessage();
		}
		
		return $db;
	}

	public function deconnexion($connect){
		$connect->query("SELECT pg_terminate_backend(pg_backend_pid())");
        $connect = null;
	}
}
?>