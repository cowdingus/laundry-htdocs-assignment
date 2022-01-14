<?php
require_once "auth/login_guard.php";

allow_page_access_exclusive(["admin", "kasir", "owner"]);

var_dump($_SESSION);
