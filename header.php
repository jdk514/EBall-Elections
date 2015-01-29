<?php
	session_start();

	function logged_in() {
		if(isset($_SESSION['gwid'])) {
			return;
		}
		header('Location: login.php');
		exit;
	}

	$servername = "localhost";
	$username = "root";
	$database = "ecouncil_elections";
	$conn = new mysqli($servername, $username, NULL, $database);
	if ($conn->connect_error) {
		echo "failed to connect?";
	    die("Connection failed: " . $conn->connect_error);
	} 

?>