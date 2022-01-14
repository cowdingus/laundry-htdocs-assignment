<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_POST) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$paramsIsValid = checkParams([$username, $password], ["Username", "Password"]);

	if (!$paramsIsValid) {
		die("Parameters aren't complete or valid");
	}

	$password = md5($password);

	$query = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username' AND password = '$password'");

	if (mysqli_num_rows($query) > 0) {
		$data_login = mysqli_fetch_assoc($query);
		session_start();
		$_SESSION['id'] = $data_login['id'];
		$_SESSION['role'] = $data_login['role'];
		$_SESSION['username'] = $data_login['username'];
		$_SESSION['nama'] = $data_login['nama'];
		header('location: /home.php');
	} else {
		warn('Username dan password tidak benar');
		die('Username dan password tidak benar');
	}
}

/*
function auth($username, $password, &$out_data) {
	global $conn;

	$password = md5($password);

	$query = mysqli_query($conn, "SELECT * FROM `user` WHERE username = '$username' AND password = '$password'");

	if (mysqli_num_rows($query) > 0) {
		$out_data = mysqli_fetch_assoc($query);
		return true;
	} else {
		return false;
	}
}
*/
