<?php
include "enviornment_variables.php";
include "header.php";
/* Script has not been told anything, exit */
if ($argc <= 1) {
	echo "Please use 'destroy' or 'create' with this script to create/destroy the table";
	exit();
}

/* If script is told to destroy the tables */
if ($argv[1] == "destroy") {
	$sql = "DROP DATABASE {$database}";
	if ($conn->query($sql) === TRUE) {
	    echo "Database dropped\n";
	} else {
	    echo "Error creating database: " . $conn->error;
	}
	$conn->close();
	exit();
} else if ($argv[1] == "create") {

	$sql = "CREATE DATABASE IF NOT EXISTS {$database}";
	if ($conn->query($sql) === TRUE) {
	    echo "Database created successfully\n";
	} else {
	    echo "Error creating database: " . $conn->error;
	}

	$conn->close();

	$conn = new mysqli($servername, $username, NULL, $database);

	$sql = "CREATE TABLE IF NOT EXISTS Students (gwid VARCHAR(9) PRIMARY KEY, firstname VARCHAR(50),
			lastname VARCHAR(50), major VARCHAR(5), year VARCHAR(10), faculty_vote BOOLEAN NOT NULL DEFAULT 0,
			senior_vote BOOLEAN NOT NULL default 0); CREATE TABLE IF NOT EXISTS Faculty (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			name VARCHAR(100), major VARCHAR(5) NOT NULL, vote_count INT DEFAULT 0); CREATE TABLE IF NOT EXISTS Senior_Votes (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			nut VARCHAR(100), bolt VARCHAR(100), senior_award VARCHAR(100), nut_bolt_comment TEXT, senior_award_comment TEXT); CREATE TABLE IF NOT EXISTS Faculty_Comments (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			fid INT, comment TEXT, FOREIGN KEY (fid) REFERENCES Faculty (id)); CREATE TABLE IF NOT EXISTS Fun_Vote (id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
			award_name VARCHAR(50), student VARCHAR(100), comment TEXT)";
	if ($conn->multi_query($sql) === TRUE) {
		echo "Tables Created\n";
		echo $conn->error;
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
?>