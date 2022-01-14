<?php
require_once "auth/login_guard.php";

ensure_logon();

var_dump($_SESSION);
