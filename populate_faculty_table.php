<?php
/* Need csv file to populate Table */
if ($argc > 1) {
	include "environment_variables.php";
	include "header.php";

	$file = fopen($argv[1], "r");
	while(! feof($file)) {
		$data = fgetcsv($file);
		$name = mysqli_real_escape_string($conn, $data[0]);
		$major = mysqli_real_escape_string($conn, $data[1]);
		$sql = "INSERT INTO Faculty (name, major) VALUES ('{$name}', '{$major}')";
		if ($conn->query($sql) === TRUE) {
	    	echo "New record created successfully";
		} else {
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
/* If no file provided, detail help information */
} else {
	echo "This script requires a file name to populate the Faculty table in the {$database} DB\nThe file should be a csv ordered (name, major)\n";
}
?>