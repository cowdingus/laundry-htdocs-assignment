<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir", "owner"]);

require_once "../components/navbar.php";
require_once "../components/bootstrap.php";
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
	<?php navbar(); ?>

	<main class="container py-5">
		<div class="row">
			<div class="col-md-8">
				<h1>Laporan</h1>
				<h2>Welcome to Laundri! <?= ucwords($_SESSION['nama']); ?></h2>
				<a class="btn btn-primary mt-3" href="buat.php">Buat Laporan</a>
			</div>
			<div class="col-md-4 d-none d-md-block">
				<p>
					<b>User Info</b><br>
					ID: <?= $_SESSION['id'] ?> <br>
					Nama: <?= $_SESSION['nama'] ?> <br>
					Username: <?= $_SESSION['username'] ?> <br>
					Role: <?= $_SESSION['role'] ?> <br>
				</p>
			</div>
		</div>
	</main>

	<?php bootstrap_js(); ?>
</body>
</html>
