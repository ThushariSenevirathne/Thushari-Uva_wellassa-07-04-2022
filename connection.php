<?php 

	$dbhost = "localhost";
	$dbuser = "root";
	$dbpw	= "";
	$dbname = "project_db";

	// create connectiion
	$con 	= mysqli_connect($dbhost,$dbuser,$dbpw,$dbname);

	// check the connection is successsfully created
	if(mysqli_connect_errno()){
		die("Database connection is fail....." . mysqli_connect_error());
	}
?>