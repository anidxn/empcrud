<?php

require 'config.php';


# MySQL data source name (DSN)

$dsn = "mysql:host=$server;dbname=$db_name;charset=UTF8";  # charset UTF-8 sets the character set of the database connection to UTF-8.

try {
	// $pdo_conn = new PDO($dsn, $username, $password); # create a new PDO object with the data source name, user, and password.
    // $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // --------- To Handle Exceptions --------------
    $pdo_conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); # create a new PDO object with the data source name, user, and password.

	if ($pdo_conn) {
		echo "Connected to the $db_name database successfully!";
	}
} catch (PDOException $e) {
	echo $e->getMessage();
} finally {
	if ($pdo_conn) {
		$pdo_conn = null;
	}
}


/*
Error handling strategies: 3 different error handling strategies:

    PDO::ERROR_SILENT – PDO sets an error code for inspecting using the PDO::errorCode() and PDO::errorInfo() methods. The PDO::ERROR_SILENT is the default mode.
    PDO::ERRMODE_WARNING – Besides setting the error code, PDO will issue an E_WARNING message.
    PDO::ERRMODE_EXCEPTION – Besides setting the error code, PDO will raise a PDOException.
*/
?>