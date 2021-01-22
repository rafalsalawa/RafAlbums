<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$db="gallery";
	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $db);
	if($conn->connect_error) {
		die("Unable to connect database: " . $conn->connect_error);
	}
?>