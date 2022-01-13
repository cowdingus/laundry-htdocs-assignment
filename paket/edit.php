<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";
require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";

if ($_POST) {
	$id = $_POST["id"];
	$jenis = $_POST["jenis"];
	$harga = $_POST["harga"];

	$paramsIsValid = checkParams([$id, $jenis, $harga], ["ID Paket", "Jenis Paket", "Harga Paket"]);

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "UPDATE `paket` SET jenis = '$jenis', harga = $harga WHERE id = $id");

	if ($query) {
		warn("Berhasil mengedit paket");
		redirectTo("/paket/index.php");
	} else {
		warn("Gagal mengedit paket");
	}

	exit();
}

if ($_GET) {
	global $harga, $jenis;

	$id = $_GET["id"];

	$paramsIsValid = checkParams($id, "ID Paket");

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "SELECT * FROM `paket` WHERE id = $id");

	if (!$query) {
		warn("Paket with ID of " . $id . "is not found");
		die();
	}

	$data_paket = mysqli_fetch_array($query);

	$jenis = $data_paket["jenis"];
	$harga = $data_paket["harga"];
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

	<title>Edit Paket</title>
</head>

<body class="crud-form">
	<h1>Edit Paket</h1>
	<form action="edit.php" method="POST">
		<input type="text" name="id" value="<?= $id ?>" hidden>
		<fieldset class="form-group">
			<legend>Harga</legend>
			<input class="form-control" type="text" name="harga" value="<?= $harga ?>">
		</fieldset>
		<br>
		<fieldset class="form-group">
			<legend>Jenis Paket</legend>
			<?php
			radio_button("jenis", "kiloan", $jenis === "kiloan");
			radio_button("jenis", "selimut", $jenis === "selimut");
			radio_button("jenis", "bed_cover", $jenis === "bed_cover");
			radio_button("jenis", "kaos", $jenis === "kaos");
			?>
		</fieldset>
		<input type="submit" style="margin-top: 1rem">
	</form>

	<?php bootstrap_js(); ?>
</body>

</html>
