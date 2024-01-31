<?php

$server = "localhost";
$username = "root";
$password = "";
$dbname = "misdbpr";

$conn = new mysqli($server, $username, $password, $dbname);

if($conn->connect_error){
	die("connection failed: ".$conn->connect_error);
} /* else {
	echo "Connection successful";
} */


?>