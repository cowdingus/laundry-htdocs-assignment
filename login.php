<?php
require_once "components/bootstrap.php";
require_once "components/navbar.php";
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php bootstrap_css(); ?>

	<title>List User</title>
</head>

<body>
	<div class="d-flex flex-column" style="height: 100vh;">
		<?php navbar(); ?>

		<main class="flex-grow-1 container-fluid">
			<div class="row h-100">
				<div class="col-md-8 d-none d-md-block">
				</div>
				<div class="col-md border-start d-flex justify-content-center">
					<form action="auth/auth.php" method="POST" class="align-self-center w-75">
						<h1>Login</h1>
						<div class="mb-3">
							<label for="username-input" class="form-label">Username</label>
							<input type="text" class="form-control" id="username-input" name="username">
						</div>
						<div class="mb-3">
							<label for="password-input" class="form-label">Password</label>
							<input type="password" class="form-control" id="password-input" name="password">
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</main>
	</div>

	<?php bootstrap_js(); ?>
</body>

</html>
