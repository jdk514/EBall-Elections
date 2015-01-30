<?php
	include "enviornment_variables.php";
	session_start();

	function logged_in() {
		if(isset($_SESSION['gwid'])) {
			return;
		}
		header('Location: login.php');
		exit;
	}
	
	$conn = new mysqli($servername, $username, $password, $database);
	if ($conn->connect_error) {
		echo "failed to connect?";
	    die("Connection failed: " . $conn->connect_error);
	} 

?>