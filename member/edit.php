<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

require_once "../utility/utils.php";
require_once "../koneksi.php";
require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";

if ($_POST) {
	$id = $_POST["id"];
	$nama = $_POST["nama"];
	$alamat = $_POST["alamat"];
	$jenis_kelamin = $_POST["jenis_kelamin"];
	$tlp = $_POST["tlp"];

	$paramsIsValid = checkParams([$id, $nama, $alamat, $jenis_kelamin, $tlp], ["ID", "Nama", "Alamat", "Jenis_Kelamin", "Telepon"]);

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "UPDATE `member` SET nama = '$nama', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin', tlp = '$tlp' WHERE id = $id");

	if ($query) {
		warn("Berhasil mengedit member");
		redirectTo("index.php");
	} else {
		warn("Gagal mengedit member");
	}

	exit();
}

if ($_GET) {
	global $nama, $alamat, $jenis_kelamin, $tlp;

	$id = $_GET["id"];

	$paramsIsValid = checkParams($id, "ID Member");

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "SELECT * FROM `member` WHERE id = $id");

	if (!$query) {
		warn("Member with ID of " . $id . "is not found");
		die();
	}

	$data_member = mysqli_fetch_array($query);

	$nama = $data_member["nama"];
	$alamat = $data_member["alamat"];
	$jenis_kelamin = $data_member["jenis_kelamin"];
	$tlp = $data_member["tlp"];
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

	<title>Edit Member</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Edit Member</h1>
		<form action="edit.php" method="POST">
			<input type="text" name="id" value="<?= $id ?>" hidden>
			<fieldset class="form-group">
				<legend>Nama</legend>
				<input class="form-control" type="text" name="nama" value="<?= $nama ?>">
			</fieldset>
			<fieldset class="form-group">
				<legend>Alamat</legend>
				<input class="form-control" type="text" name="alamat" value="<?= $alamat ?>">
			</fieldset>
			<fieldset class="form-group">
				<legend>Jenis Kelamin</legend>
				<select class="form-select" aria-label="Choose gender" name="jenis_kelamin">
					<option value="L" <?= $jenis_kelamin === "L" ? "selected" : "" ?>>Laki-laki</option>
					<option value="P" <?= $jenis_kelamin === "P" ? "selected" : "" ?>>Perempuan</option>
				</select>
			</fieldset>
			<fieldset class="form-group">
				<legend>Nomor Telepon</legend>
				<input class="form-control" type="text" name="tlp" value="<?= $tlp ?>">
			</fieldset>
			<button type="submit" class="btn btn-primary mt-3">Submit</button>
		</form>
	</main>

	<?php bootstrap_js(); ?>

</body>

</html>
