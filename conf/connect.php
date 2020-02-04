<?php
class Connect{
	public function connexion($type){
		$settings = parse_ini_file("settings.ini", true);
		$host = $settings[$type]["host"];
		$port = $settings[$type]["port"];
		$db = $settings[$type]["db"];
		$user = $settings[$type]["user"];
		$password = $settings[$type]["password"];

		try{
			$db = new PDO($type.":host=".$host.";port=".$port.";dbname=".$db.";", $user, $password);
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