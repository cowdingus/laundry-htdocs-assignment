<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive("admin");

require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_GET) {
	$id = $_GET["id"];

	if (!checkParams($id, "ID Paket")) {
		exit();
	}

	$query = mysqli_query($conn, "DELETE FROM `paket` WHERE id = $id");

	if ($query) {
		warn("Berhasil menghapus paket");
		redirectTo("index.php");
	} else {
		warn("Gagal menghapus paket");
	}
}
?>
