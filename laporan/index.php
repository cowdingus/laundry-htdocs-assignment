<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir", "owner"]);

require_once "../components/navbar.php";
require_once "../components/bootstrap.php";
require_once "../components/report_table.php";
require_once "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>Home</title>
</head>
<body>
	<main class="container py-5">
		<div class="row">
			<div class="col">
				<h1>Laporan</h1>
				<?php
				$query_transaksi = mysqli_query($conn, "SELECT t.id, m.nama as nama_member, t.tgl, t.batas_waktu, t.tgl_bayar, t.status, t.dibayar, u.nama as nama_kasir, p.jenis as paket, p.harga * d_t.qty as total FROM transaksi t, detail_transaksi d_t, paket p, member m, user u WHERE t.id_member = m.id AND t.id_user = u.id AND t.id = d_t.id_transaksi AND p.id = d_t.id_paket");
				$query_member = mysqli_query($conn, "SELECT * FROM `member`");
				$query_outlet = mysqli_query($conn, "SELECT * FROM `outlet`");
				$query_paket = mysqli_query($conn, "SELECT * FROM `paket`");

				echo "<h2 class='mt-3'>Transaksi</h2>";
				report_table($query_transaksi);
				echo "<div style='page-break-after: always;'></div>";

				echo "<h2 class='mt-3'>Member</h2>";
				report_table($query_member);
				echo "<div style='page-break-after: always;'></div>";

				echo "<h2 class='mt-3'>Outlet</h2>";
				report_table($query_outlet);
				echo "<div style='page-break-after: always;'></div>";

				echo "<h2 class='mt-3'>Paket</h2>";
				report_table($query_paket);
				echo "<div style='page-break-after: always;'></div>";
				?>

				<button class="btn btn-primary" onclick="const printBtn = document.getElementById('print-btn'); printBtn.hidden = true; window.print();" id="print-btn">Print</button>

			</div>
		</div>
	</main>

	<?php bootstrap_js(); ?>

</body>
</html>
