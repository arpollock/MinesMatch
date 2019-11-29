<?php
	// Data base connection
	// $dbhost = "localhost";
	// $username = "root";
	// $password = "";
	// $dbname = "lovepotion";
	// alex Data base connection stuff
	$dbhost = "127.0.0.1"; 
    $username = "root";
	$password = "0000";
	$dbname = "csci445";
	
	$conn = mysqli_connect($dbhost, $username, $password, $dbname);
	
	if(!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
?>