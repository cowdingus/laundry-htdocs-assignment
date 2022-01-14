<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

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

	<title>Tambah Member</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Tambah Member</h1>
		<form action="tambah.php" method="POST">
			<fieldset class="form-group">
				<legend>Nama</legend>
				<input class="form-control" type="text" name="nama">
			</fieldset>
			<fieldset class="form-group">
				<legend>Alamat</legend>
				<input class="form-control" type="text" name="alamat">
			</fieldset>
			<fieldset class="form-group">
				<legend>Jenis Kelamin</legend>
				<select class="form-select" aria-label="Choose gender" name="jenis_kelamin">
					<option value="L">Laki-laki</option>
					<option value="P">Perempuan</option>
				</select>
			</fieldset>
			<fieldset class="form-group">
				<legend>Nomor Telepon</legend>
				<input class="form-control" type="text" name="tlp">
			</fieldset>
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
	$jenis_kelamin = $_POST["jenis_kelamin"];
	$tlp = $_POST["tlp"];

	$paramsIsValid = checkParams([$nama, $alamat, $jenis_kelamin, $tlp], ["Nama", "Alamat", "Jenis_Kelamin", "Telepon"]);

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "INSERT INTO member (`nama`, `alamat`, `jenis_kelamin`, `tlp`) VALUES ('$nama', '$alamat', '$jenis_kelamin', '$tlp')");

	if ($query) {
		warn("Berhasil menambahkan member");
		redirectTo("index.php");
	} else {
		warn("Gagal menambahkan member");
	}
}
?>
