<?php
function navbar()
{
?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">
				<img src="../assets/bag-handle-outline.svg" width="30" height="30" class="d-inline-block align-top" alt="">
				Laundri
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="/home.php">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/member">Member</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/user">User</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/paket">Paket</a>
					</li>
				</ul>
				<ul class="navbar-nav mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link" href="/logout.php">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
<?php
}
?>
