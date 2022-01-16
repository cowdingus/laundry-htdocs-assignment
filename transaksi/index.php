<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

require_once "../components/bootstrap.php";
require_once "../components/navbar.php";

function extract_member_name_from_id($id) {
	global $conn;

	$query = mysqli_query($conn, "SELECT nama FROM member WHERE id = $id");

	$data_member = mysqli_fetch_assoc($query);

	return $data_member["nama"];
}

function extract_user_name_from_id($id) {
	global $conn;

	$query = mysqli_query($conn, "SELECT nama FROM user WHERE id = $id");

	$data_member = mysqli_fetch_assoc($query);

	return $data_member["nama"];
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>List Transaksi</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>List Transaksi</h1>

		<a href="tambah.php" class="btn btn-primary" id="add-anchor">+ Tambah Transaksi</a>

		<?php
		require_once "../components/list_table.php";
		require_once "../koneksi.php";

		$query = mysqli_query($conn, "SELECT t.id, m.nama as nama_member, t.tgl, t.batas_waktu, t.tgl_bayar, t.status, t.dibayar, u.nama as nama_user FROM transaksi t, member m, user u WHERE t.id_member = m.id AND t.id_user = u.id;");

		list_table($query);
		?>

	</main>

	<?php bootstrap_js(); ?>

</body>

</html>
