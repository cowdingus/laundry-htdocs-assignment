<?php
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>List Member</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>List Member</h1>

		<a href="tambah.php" class="btn btn-primary" id="add-anchor">+ Tambah Member</a>

		<?php
		require_once "../components/list_table.php";
		require_once "../koneksi.php";

		$query = mysqli_query($conn, "SELECT * FROM `member`");

		list_table($query);
		?>

	</main>

	<?php bootstrap_js(); ?>

</body>

</html>
