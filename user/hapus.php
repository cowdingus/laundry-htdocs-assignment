<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_GET) {
	$id = $_GET["id"];

	if (!checkParams($id, "ID User")) {
		exit();
	}

	$query = mysqli_query($conn, "DELETE FROM `user` WHERE id = $id");

	if ($query) {
		warn("Berhasil menghapus user");
		redirectTo("index.php");
	} else {
		warn("Gagal menghapus user");
	}
}
?>
