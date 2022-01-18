<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive("admin");

require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>Tambah Outlet</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Tambah Outlet</h1>
		<form action="tambah.php" method="POST">
			<div class="mb-3">
				<label for="nama-input" class="form-label">Nama</label>
				<input type="text" class="form-control" id="nama-input" name="nama">
			</div>
			<div class="mb-3">
				<label for="alamat-input" class="form-label">Alamat</label>
				<input type="alamat" class="form-control" id="alamat-input" name="alamat">
			</div>
			<div class="mb-3">
				<label for="telepon-input" class="form-label">Telepon</label>
				<input type="telepon" class="form-control" id="telepon-input" name="tlp">
			</div>
			<button type="submit" class="btn btn-primary mt-3">Submit</button>
		</form>
	</main>

	<?php bootstrap_js(); ?>

</body>

</html>

<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_POST) {
	$nama = $_POST["nama"];
	$alamat = $_POST["alamat"];
	$tlp = $_POST["tlp"];

	$paramsIsValid = checkParams([$nama, $alamat, $tlp], ["Nama", "Alamat", "Telepon"]);

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "INSERT INTO outlet (nama, alamat, tlp) VALUES ('$nama', '$alamat', '$tlp')");

	if ($query) {
		warn("Berhasil menambahkan outlet");
		redirectTo("index.php");
	} else {
		warn("Gagal menambahkan outlet");
	}
}
?>
