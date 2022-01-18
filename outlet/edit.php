<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive("admin");

require_once "../utility/utils.php";
require_once "../koneksi.php";
require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";

if ($_POST) {
	$id = $_POST["id"];
	$nama = $_POST["nama"];
	$alamat = $_POST["alamat"];
	$tlp = $_POST["tlp"];

	$paramsIsValid = checkParams([$nama, $alamat, $tlp], ["Nama", "Alamat", "Telepon"]);

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "UPDATE `outlet` SET nama = '$nama', alamat = '$alamat', tlp = '$tlp' WHERE id = $id");

	if ($query) {
		warn("Berhasil mengedit outlet");
		redirectTo("/outlet/index.php");
	} else {
		warn("Gagal mengedit outlet");
	}

	exit();
}

if ($_GET) {
	global $nama, $alamat, $tlp;

	$id = $_GET["id"];

	$paramsIsValid = checkParams($id, "ID Outlet");

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "SELECT * FROM `outlet` WHERE id = $id");

	if (!$query) {
		warn("Outlet with ID of " . $id . "is not found");
		die();
	}

	$data_outlet = mysqli_fetch_array($query);

	$nama = $data_outlet["nama"];
	$alamat = $data_outlet["alamat"];
	$tlp = $data_outlet["tlp"];
} else {
	warn("No ID specified");
	die();
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>Edit Outlet</title>
</head>

<body>
	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Edit Outlet</h1>
		<form action="edit.php" method="POST">
			<input type="text" name="id" value="<?= $id ?>" hidden>
			<div class="mb-3">
				<label for="nama-input" class="form-label">Nama</label>
				<input type="text" class="form-control" id="nama-input" name="nama" value="<?= $nama ?>">
			</div>
			<div class="mb-3">
				<label for="alamat-input" class="form-label">Alamat</label>
				<input type="alamat" class="form-control" id="alamat-input" name="alamat" value="<?= $alamat ?>">
			</div>
			<div class="mb-3">
				<label for="telepon-input" class="form-label">Telepon</label>
				<input type="telepon" class="form-control" id="telepon-input" name="tlp" value="<?= $tlp ?>">
			</div>
			<button type="submit" class="btn btn-primary mt-3">Submit</button>
		</form>
	</main>

	<?php bootstrap_js(); ?>
</body>

</html>
