<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir"]);

require_once "../utility/utils.php";
require_once "../koneksi.php";
require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";
require_once "utils.php";

if ($_POST) {
	$id = $_POST["id"];
	$id_member = $_POST["id_member"];
	$id_user = $_POST["id_user"];
	$tgl = $_POST["tgl"];
	$batas_waktu = $_POST["batas_waktu"];
	$tgl_bayar = $_POST["tgl_bayar"];
	$status = $_POST["status"];
	$dibayar = $_POST["dibayar"];
	$id_pakets = $_POST["id_pakets"];
	$qtys = $_POST["qtys"];
	$id_detail_transaksis = $_POST["id_detail_transaksis"];

	$paramsIsValid = checkParams(
		[$id, $id_member, $id_user, $tgl, $batas_waktu, $tgl_bayar, $status, $dibayar, $id_pakets, $qtys, $id_detail_transaksis],
		["ID Transaksi", "ID Member", "ID User", "Tanggal", "Batas Waktu", "Tanggal Bayar", "Status", "Dibayar", "ID Paket", "Qty", "Id Detail Transaksis"]
	);

	if (!$paramsIsValid) {
		exit();
	}

	$query_transaksi = mysqli_query($conn, "
		UPDATE `transaksi` SET
		id_member = '$id_member',
		id_user = '$id_user',
		tgl = '$tgl',
		batas_waktu = '$batas_waktu',
		tgl_bayar = '$tgl_bayar',
		status = '$status',
		dibayar = '$dibayar'
		WHERE id = $id");

	for ($i = 0; $i < count($id_pakets); $i++) {
		$id_detail_transaksi = $id_detail_transaksis[$i];
		$id_paket = $id_pakets[$i];
		$qty = $qtys[$i];

		$query_detail_transaksi = mysqli_query($conn, "
			UPDATE `detail_transaksi` SET
			id_paket = '$id_paket',
			qty = '$qty'
			WHERE id_transaksi = $id AND id = $id_detail_transaksi
		");
	}

	if ($query_transaksi && $query_detail_transaksi) {
		warn("Berhasil mengedit transaksi");
		redirectTo("/transaksi/index.php");
	} else {
		warn("Gagal mengedit transaksi");
	}

	exit();
}

if ($_GET) {
	global $harga, $jenis;

	$id = $_GET["id"];

	$paramsIsValid = checkParams($id, "ID Transaksi");

	if (!$paramsIsValid) {
		exit();
	}

	$query_transaksi = mysqli_query($conn, "SELECT * FROM `transaksi` WHERE id = $id");
	$query_detail_transaksi = mysqli_query($conn, "SELECT * FROM `detail_transaksi` WHERE id_transaksi = $id");

	if (!$query_transaksi || !$query_detail_transaksi) {
		warn("Transaksi with ID of " . $id . "is not found");
		die();
	}

	$data_transaksi = mysqli_fetch_assoc($query_transaksi);
	$data_detail_transaksi = mysqli_fetch_all($query_detail_transaksi, MYSQLI_ASSOC);

	$id_member = $data_transaksi["id_member"];
	$id_user = $data_transaksi["id_user"];
	$tgl = $data_transaksi["tgl"];
	$batas_waktu = $data_transaksi["batas_waktu"];
	$tgl_bayar = $data_transaksi["tgl_bayar"];
	$status = $data_transaksi["status"];
	$dibayar = $data_transaksi["dibayar"];
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

	<title>Edit Transaksi</title>
</head>

<body>
	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Edit Transaksi</h1>
		<form action="edit.php" method="POST">
			<input type="text" name="id" value="<?= $id ?>" hidden>
			<div class="mb-3">
				<label for="member-input" class="form-label">Member</label>
				<select class="form-select" aria-label="Pilih member" id="member-input" name="id_member">
					<?php render_members_as_select_options($id_member); ?>
				</select>
			</div>
			<div class="mb-3">
				<label for="date-input" class="form-label">Tanggal</label>
				<input type="date" class="form-control" id="date-input" name="tgl" value="<?= $tgl ?>">
			</div>
			<div class="mb-3">
				<label for="deadline-input" class="form-label">Batas Waktu (Hari)</label>
				<input type="date" class="form-control" id="deadline-input" name="batas_waktu" value="<?= $batas_waktu ?>">
			</div>
			<div class="mb-3">
				<label for="payment-date-input" class="form-label">Tanggal Bayar</label>
				<input type="date" class="form-control" id="payment-date-input" name="tgl_bayar" value="<?= $tgl_bayar ?>">
			</div>
			<div class="mb-3">
				<label>Status
					<?php render_as_radio_buttons("status", ["baru", "proses", "selesai", "diambil"], $status) ?>
				</label>
			</div>
			<div class="mb-3">
				<label>Dibayar
					<?php render_as_radio_buttons("dibayar", ["dibayar", "belum_dibayar"], $dibayar) ?>
				</label>
			</div>
			<?php for ($i = 0; $i < count($data_detail_transaksi); $i++) : ?>
				<div class="row mb-3">
					<input type="text" name="id_detail_transaksis[]" value="<?= $data_detail_transaksi[$i]['id'] ?>" hidden>
					<div class="col-sm-5">
						<select class="form-select" aria-label="Pilih paket" name="id_pakets[]">
							<option value="" disabled selected hidden>Pilih paket...</option>
							<?php render_paket_as_select_options($data_detail_transaksi[$i]['id_paket']); ?>
						</select>
					</div>
					<div class="col-sm-5">
						<input type="number" class="form-control" name="qtys[]" min="0" placeholder="Qty" value="<?= $data_detail_transaksi[$i]['qty'] ?>">
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
