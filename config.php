<?php

// connection through procedural approach
$server = "localhost";
$username = "root";
$password = "";
$dbname = "misdbpr";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: ". mysqli_connect_error();
	exit();
} else {
	echo "COnnected successfully";
} 

?>

