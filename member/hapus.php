<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_GET) {
	$id = $_GET["id"];

	if (!checkParams($id, "ID member")) {
		exit();
	}

	$query = mysqli_query($conn, "DELETE FROM `member` WHERE id = $id");

	if ($query) {
		warn("Berhasil menghapus member");
		redirectTo("index.php");
	} else {
		warn("Gagal menghapus member");
	}
}
?>
