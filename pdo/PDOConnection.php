<?php
require_once 'config.php';

class PDOConnection
{
	public static function make($host, $db, $user, $pass)  // make() creates a new db connection
	{
		$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

		try {
			$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

			return new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}
}

return PDOConnection::make($server, $db_name, $username, $password);

//------ call it ----
// $pdo = require 'Connection.php';

?>