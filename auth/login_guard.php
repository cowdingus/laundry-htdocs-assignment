<?php

require_once __DIR__ . "/../utility/utils.php";

function ensure_logon() {
	session_start();
	if (!isset($_SESSION['id'])) {
		redirectTo("/login.php");
	}
}

/* Prevents user with $role access to current page */
function redirectToLogin() {
	redirectTo("/login.php");
	exit();
}

function prevent_page_access($roles) {
	session_start();
	if (gettype($roles) === "array") {
		foreach($roles as $role) {
			if ($_SESSION['role'] === $role) {
				redirectToLogin();
			}
		}
	} else {
		if ($_SESSION['role'] === $roles) {
			redirectToLogin();
		}
	}
}

function allow_page_access_exclusive($roles) {
	session_start();
	$ok = false;

	if (gettype($roles) === "array") {
		foreach($roles as $role) {
			if ($_SESSION['role'] === $role) {
				$ok = true;
			}
		}
	} else {
		if ($_SESSION['role'] === $roles) {
			$ok = true;
		}
	}

	if (!$ok) {
		redirectToLogin();
	}
}
