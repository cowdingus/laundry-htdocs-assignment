<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";
require_once "../components/radio_button.php";
require_once "../components/bootstrap.php";
require_once "../components/navbar.php";

if ($_POST) {
	$id = $_POST["id"];
	$nama = $_POST["nama"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$role = $_POST["role"];

	$paramsIsValid = checkParams([$id, $nama, $username, $password, $role], ["ID", "Nama", "Username", "Password", "Role"]);

	if (!$paramsIsValid) {
		exit();
	}

	$password = md5($password);

	$query = mysqli_query($conn, "UPDATE `user` SET nama = '$nama', username = '$username', password = '$password', role = '$role' WHERE id = $id");

	if ($query) {
		warn("Berhasil mengedit user");
		redirectTo("index.php");
	} else {
		warn("Gagal mengedit user");
	}

	exit();
}

if ($_GET) {
	global $nama, $username, $password, $role;

	$id = $_GET["id"];

	$paramsIsValid = checkParams($id, "ID User");

	if (!$paramsIsValid) {
		exit();
	}

	$query = mysqli_query($conn, "SELECT * FROM `user` WHERE id = $id");

	if (!$query) {
		warn("User with ID of " . $id . "is not found");
		die();
	}

	$data_user = mysqli_fetch_array($query);

	$nama = $data_user["nama"];
	$username = $data_user["username"];
	$password = $data_user["password"];
	$role = $data_user["role"];
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

	<title>Edit User</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Edit User</h1>
		<form action="edit.php" method="POST">
			<input type="text" name="id" value="<?= $id ?>" hidden>
			<fieldset class="form-group">
				<legend>Nama</legend>
				<input class="form-control" type="text" name="nama" value="<?= $nama ?>">
			</fieldset>
			<fieldset class="form-group">
				<legend>Username</legend>
				<input class="form-control" type="text" name="username" value="<?= $username ?>">
			</fieldset>
			<fieldset class="form-group">
				<legend>Password</legend>
				<input class="form-control" type="text" name="password">
			</fieldset>
			<fieldset class="form-group">
				<legend>Role</legend>
				<select class="form-select" aria-label="Choose role" name="role">
					<option value="admin" <?= $role === "admin" ? "selected" : "" ?>>Admin</option>
					<option value="kasir" <?= $role === "kasir" ? "selected" : "" ?>>Kasir</option>
					<option value="owner" <?= $role === "owner" ? "selected" : "" ?>>Owner</option>
				</select>
			</fieldset>
			<button type="submit" class="btn btn-primary mt-3">Submit</button>
		</form>
	</main>

	<?php bootstrap_js(); ?>

</body>

</html>
