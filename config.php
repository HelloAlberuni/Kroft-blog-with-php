<?php
	$dbhost = "localhost";
	$dbname = "techarti_azad";
	$dbuser = "techarti_azad";
	$dbpass = "000000000o";

	try{
		$db = new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbuser,$dbpass);
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e){
		echo "Connection error: ".$e->getMessage();
	}
?>