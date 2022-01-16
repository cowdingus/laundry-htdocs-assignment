<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir", "owner"]);

require_once "../koneksi.php";
require_once "../utility/utils.php";

$query = mysqli_query($conn, "SELECT * FROM transaksi");
$out_file = fopen("../g/report.csv", "w+");

$data_transaksi = mysqli_fetch_assoc($query);
fputcsv($out_file, array_keys($data_transaksi));
fputcsv($out_file, array_values($data_transaksi));

while ($data_transaksi = mysqli_fetch_array($query, MYSQLI_NUM)) {
	fputcsv($out_file, array_values($data_transaksi));
}
header('location: /g/report.csv');

fclose($out_file);
?>
