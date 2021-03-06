<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

require_once "../components/bootstrap.php";
require_once "../components/navbar.php";
require_once "../utility/utils.php";

function extract_member_name_from_id($id)
{
	global $conn;

	$query = mysqli_query($conn, "SELECT nama FROM member WHERE id = $id");

	$data_member = mysqli_fetch_assoc($query);

	return $data_member["nama"];
}

function extract_user_name_from_id($id)
{
	global $conn;

	$query = mysqli_query($conn, "SELECT nama FROM user WHERE id = $id");

	$data_member = mysqli_fetch_assoc($query);

	return $data_member["nama"];
}

function status_to_badge_converter($status)
{
	$bg_theme = "bg-primary";

	switch ($status) {
		case "dibayar":
			$bg_theme = "bg-success";
			break;
		case "belum_dibayar":
			$bg_theme = "bg-warning text-dark";
			break;
	}

	$status = titleize($status);

	return "<span class=\"badge rounded-fill $bg_theme\">$status</span>";
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
		require_once "utils.php";
		require_once "../koneksi.php";

		list_table_transaksi();
		?>

	</main>

	<?php bootstrap_js(); ?>

</body>

</html>
