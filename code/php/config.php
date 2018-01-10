<?php
	// db credentials
    header('Content-Type: application/json');
	// osu php admin
	// define('DB_HOST', 'classmysql.engr.oregonstate.edu');
	// define('DB_USER','cs340_luojio');
	// define('DB_PASS','gijon+323018');
	// define('DB_NAME','cs340_luojio');
	
	// my mac local db
	define('DB_HOST', '127.0.0.1');
	define('DB_USER','root');
	define('DB_PASS','ubuntu123');
	define('DB_NAME','rmc_db');

	function connect(){
		$mysqli = new mysqli(DB_HOST ,DB_USER ,DB_PASS ,DB_NAME);

		if (mysqli_connect_errno($mysqli)){
			die("Failed to connect:" . mysqli_connect_error());
		}

	  	mysqli_set_charset($mysqli, "utf8");
  		return $mysqli;
	}
?>
