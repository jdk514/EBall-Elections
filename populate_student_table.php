<?php
/* Need csv file to populate Table */
if ($argc > 1) {
	include "enviornment_variables.php";
	include "header.php";

	$file = fopen($argv[1], "r");
	while(! feof($file)) {
		$data = fgetcsv($file);
		$sql = "INSERT INTO Students (gwid, firstname, lastname, major, year) VALUES ('{$data[0]}', '{$data[1]}', '{$data[2]}', '{$data[3]}', '{$data[4]}')";
		if ($conn->query($sql) === TRUE) {
	    	echo "New record created successfully";
		} else {
	    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
/* If no file provided, detail help information */
} else {
	echo "This script requires a file name to populate the Students table in the ecouncil_elections DB\nThe file should be a csv ordered (GWID,firstname,lastname,major,year)\n";
}
?>