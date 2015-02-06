<?php
/* Need csv file to populate Table */
if ($argc > 1) {
	include "environment_variables.php";
	include "header.php";

	$year_array = array(
		"201501" => "Freshman",
		"201403" => "Freshman",
		"201401" => "Sophomore",
		"201303" => "Sophomore",
		"201301" => "Junior",
		"201203" => "Junior"
	);

	$file = fopen($argv[1], "r");
	while(! feof($file)) {
		$data = fgetcsv($file);
		if (!empty($data)) {
			$gwid = mysqli_real_escape_string($conn, $data[0]);
			$firstname = mysqli_real_escape_string($conn, $data[1]);
			$lastname = mysqli_real_escape_string($conn, $data[2]);
			$major = mysqli_real_escape_string($conn, $data[3]);
			$date = mysqli_real_escape_string($conn, $data[4]);

			if (isset($year_array[$date])) {
				$year = $year_array[$date];
			} else {
				$year = "Senior";
			}

			$sql = "INSERT INTO Students (gwid, firstname, lastname, major, year) VALUES ('{$gwid}', '{$firstname}', '{$lastname}', '{$major}', '{$year}')";
			if ($conn->query($sql) === TRUE) {
		    	echo "New record created successfully";
			} else {
		    	echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}
/* If no file provided, detail help information */
} else {
	echo "This script requires a file name to populate the Students table in the {$database} DB\nThe file should be a csv ordered (GWID,firstname,lastname,major,year)\n";
}
?>