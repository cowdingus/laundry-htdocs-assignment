<?php

require_once __DIR__ . "/../utility/utils.php";

function ensure_logon() {
	session_start();
	if (!isset($_SESSION['id'])) {
		redirectTo("/login.php");
	}
}

/* Prevents user with $role access to current page */
function prevent_page_access($role) {
	if ($_SESSION['role'] === $role) {
		redirectTo("/login.php");
		exit();
	}
}
