<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";
require_once "../utility/utils.php";
require_once "../koneksi.php";
require_once "utils.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>Tambah Transaksi</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Tambah Transaksi</h1>
		<form action="tambah.php" method="POST">
			<div class="mb-3">
				<label for="member-input" class="form-label">Member</label>
				<select class="form-select" aria-label="Pilih member" id="member-input" name="id_member">
					<?php render_members_as_select_options(); ?>
				</select>
			</div>
			<div class="mb-3">
				<label for="date-input" class="form-label">Tanggal</label>
				<input type="date" class="form-control" id="date-input" name="tgl">
			</div>
			<div class="mb-3">
				<label for="deadline-input" class="form-label">Batas Waktu (Hari)</label>
				<input type="date" class="form-control" id="deadline-input" name="batas_waktu">
			</div>
			<div class="mb-3">
				<label for="payment-date-input" class="form-label">Tanggal Bayar</label>
				<input type="date" class="form-control" id="payment-date-input" name="tgl_bayar">
			</div>
			<div class="mb-3">
				<label>Status
					<?php render_as_radio_buttons("status", ["baru", "proses", "selesai", "diambil"]) ?>
				</label>
			</div>
			<div class="mb-3">
				<label>Dibayar
					<?php render_as_radio_buttons("dibayar", ["dibayar", "belum_dibayar"]) ?>
				</label>
			</div>
			<div class="mb-3">
				<label for="paket-input" class="form-label">Paket</label>
				<select class="form-select" aria-label="Pilih paket" id="paket-input" name="id_paket">
					<?php render_paket_as_select_options(); ?>
				</select>
			</div>
			<div class="mb-3">
				<label for="qty-input" class="form-label">Qty</label>
				<input type="number" class="form-control" id="qty-input" name="qty" min="0">
			</div>
			<input type="text" name="id_user" value="<?= $_SESSION['id'] ?>" hidden>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</main>

	<?php bootstrap_js(); ?>

</body>

</html>

<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_POST) {
	$id_member = $_POST["id_member"];
	$id_user = $_POST["id_user"];
	$tgl = $_POST["tgl"];
	$batas_waktu = $_POST["batas_waktu"];
	$tgl_bayar = $_POST["tgl_bayar"];
	$status = $_POST["status"];
	$dibayar = $_POST["dibayar"];
	$id_paket = $_POST["id_paket"];
	$qty = $_POST["qty"];

	$paramsIsValid = checkParams(
		[$id_member, $id_user, $tgl, $batas_waktu, $tgl_bayar, $status, $dibayar, $id_paket, $qty],
		["ID Member", "ID User", "Tanggal", "Batas Waktu", "Tanggal Bayar", "Status", "Dibayar", "ID Paket", "Qty"]
	);

	if (!$paramsIsValid) {
		exit();
	}

	$query_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_member, id_user, tgl, batas_waktu, tgl_bayar, status, dibayar) VALUES
		('$id_member', '$id_user', '$tgl', '$batas_waktu', '$tgl_bayar', '$status', '$dibayar')");

	$id_transaksi = mysqli_insert_id($conn);

	$query_detail_transaksi = mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_paket, qty) VALUES
		('$id_transaksi', '$id_paket', '$qty')");

	if ($query_transaksi && $query_detail_transaksi) {
		warn("Berhasil menambahkan paket");
		redirectTo("index.php");
	} else {
		warn("Gagal menambahkan paket");
		die(mysqli_error($conn));
	}
}
?>
