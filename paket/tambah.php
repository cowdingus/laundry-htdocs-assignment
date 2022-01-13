<?php require_once "../components/radio_button.php" ?>
<?php require_once "../components/bootstrap.php" ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>Tambah Paket</title>
</head>

<body class="crud-form">
	<h1>Tambah Paket</h1>
	<form action="tambah.php" method="POST">
		<p>Jenis Paket:</p>
		<?php
		radio_button("jenis", "kiloan");
		radio_button("jenis", "selimut");
		radio_button("jenis", "bed_cover");
		radio_button("jenis", "kaos");
		?>
		<br>
		<p>Harga:</p>
		<label>
			<input type="text" name="harga">
		</label>
		<br>
		<input type="submit" style="margin-top: 1rem">
	</form>

	<?php bootstrap_js(); ?>

</body>

</html>

<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_POST) {
	$jenis = $_POST["jenis"];
	$harga = $_POST["harga"];

	$paramsIsValid = checkParams([$jenis, $harga], ["Jenis paket", "Harga paket"]);

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "INSERT INTO paket (`jenis`, `harga`) VALUES ('$jenis', '$harga')");

	if ($query) {
		warn("Berhasil menambahkan paket");
		redirectTo("index.php");
	} else {
		warn("Gagal menambahkan paket");
	}
}
?>
