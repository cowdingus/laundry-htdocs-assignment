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
		<form action="tambah.php" method="GET">
			<div class="row mb-3">
				<label for="paket-count-input" class="col-form-label col-sm-2">Jumlah Pesanan</label>
				<div class="col-sm-2">
					<input type="number" class="form-control" id="paket-count-input" name="paket_count" value="<?= $_GET['paket_count'] ? $_GET['paket_count'] : 1 ?>">
				</div>
				<button type="submit" class="btn btn-primary col-sm-1">&#x21bb;</button>
			</div>
		</form>
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
			<?php for ($i = 0; $i < ($_GET['paket_count'] ? $_GET['paket_count'] : 1); $i++) : ?>
				<div class="row mb-3">
					<div class="col-sm-5">
						<select class="form-select" aria-label="Pilih paket" name="id_pakets[]">
							<option value="" disabled selected hidden>Pilih paket...</option>
							<?php render_paket_as_select_options(); ?>
						</select>
					</div>
					<div class="col-sm-5">
						<input type="number" class="form-control" name="qtys[]" min="0" placeholder="Qty">
					</div>
				</div>
			<?php endfor; ?>
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
	$id_pakets = $_POST["id_pakets"];
	$qtys = $_POST["qtys"];

	$paramsIsValid = checkParams(
		[$id_member, $id_user, $tgl, $batas_waktu, $tgl_bayar, $status, $dibayar, $id_pakets, $qtys],
		["ID Member", "ID User", "Tanggal", "Batas Waktu", "Tanggal Bayar", "Status", "Dibayar", "ID Paket", "Qty"]
	);

	if (!$paramsIsValid) {
		exit();
	}

	$query_transaksi = mysqli_query($conn, "INSERT INTO transaksi (id_member, id_user, tgl, batas_waktu, tgl_bayar, status, dibayar) VALUES
		('$id_member', '$id_user', '$tgl', '$batas_waktu', '$tgl_bayar', '$status', '$dibayar')");

	$id_transaksi = mysqli_insert_id($conn);

	$is_all_ok = true;
	for ($i = 0; $i < count($id_pakets); $i++) {
		$id_paket = $id_pakets[$i];
		$qty = $qtys[$i];

		$query_detail_transaksi = mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_paket, qty) VALUES
		('$id_transaksi', '$id_paket', '$qty')");

		if (!$query_detail_transaksi) {
			$is_all_ok = false;
			break;
		}
	}

	if ($query_transaksi && $is_all_ok) {
		warn("Berhasil menambahkan paket");
		redirectTo("index.php");
	} else {
		warn("Gagal menambahkan paket");
		die(mysqli_error($conn));
	}
}
?>
