<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_GET) {
	$id = $_GET["id"];

	if (!checkParams($id, "ID Transaksi")) {
		exit();
	}

	$query = mysqli_query($conn, "DELETE FROM `transaksi` WHERE id = $id");

	if ($query) {
		warn("Berhasil menghapus transaksi");
		redirectTo("index.php");
	} else {
		warn("Gagal menghapus transaksi");
	}
}
?>
