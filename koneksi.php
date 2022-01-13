<?php
	$host = 'localhost';
	$db = 'laundry';
	$user = 'root';
	$password = '';

	$conn = mysqli_connect($host, $user, $password, $db);

	if (mysqli_connect_errno()) {
		echo "Failed to establish connection to database: " + mysqli_connect_error();
		exit();
	}
?>
