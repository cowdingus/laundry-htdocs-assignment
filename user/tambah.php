<?php
require_once "../auth/login_guard.php";

allow_page_access_exclusive("admin");

require_once "../components/radio_button.php";
require_once "../components/navbar.php";
require_once "../components/bootstrap.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>Tambah User</title>
</head>

<body>

	<?php navbar(); ?>

	<main class="crud-form">
		<h1>Tambah User</h1>
		<form action="tambah.php" method="POST">
			<fieldset class="form-group">
				<legend>Nama</legend>
				<input class="form-control" type="text" name="nama">
			</fieldset>
			<fieldset class="form-group">
				<legend>Username</legend>
				<input class="form-control" type="text" name="username">
			</fieldset>
			<fieldset class="form-group">
				<legend>Password</legend>
				<input class="form-control" type="text" name="password">
			</fieldset>
			<fieldset class="form-group">
				<legend>Role</legend>
				<select class="form-select" aria-label="Choose role" name="role">
					<option value="admin">Admin</option>
					<option value="kasir">Kasir</option>
					<option value="owner">Owner</option>
				</select>
			</fieldset>
			<button type="submit" class="btn btn-primary mt-3">Submit</button>
		</form>
	</main>

	<?php bootstrap_js(); ?>

</body>

</html>

<?php
require_once "../utility/utils.php";
require_once "../koneksi.php";

if ($_POST) {
	$nama = $_POST["nama"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$role = $_POST["role"];

	$paramsIsValid = checkParams([$nama, $username, $password, $role], ["Nama", "Username", "Password", "Role"]);

	if (!$paramsIsValid) {
		exit();
	}

	$password = md5($password);

	$query = mysqli_query($conn, "INSERT INTO user (`nama`, `username`, `password`, `role`) VALUES ('$nama', '$username', '$password', '$role')");

	if ($query) {
		warn("Berhasil menambahkan user");
		redirectTo("index.php");
	} else {
		warn("Gagal menambahkan user");
	}
}
?>
