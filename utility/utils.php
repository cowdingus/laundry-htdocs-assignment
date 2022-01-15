<?php
function warn($msg)
{
	echo "<script>alert('$msg');</script>";
}

function checkParams($params, $param_names, $msg = "")
{
	if (gettype($params) === "array") {
		global $empty_params;
		$empty_params = "";

		for ($i=0; $i < sizeof($params); $i++) { 
			if (empty($params[$i])) {
				$empty_params .= $param_names[$i] . " ";
			}
		}

		if (!empty($empty_params)) {
			warn("Parameter empty: $empty_params" . ($msg !== "" ? "$msg" : ""));
			return false;
		}

		return true;
	} else {
		if (empty($params)) {
			warn("Parameter empty: $param_names" . ($msg !== "" ? "$msg" : ""));
			return false;
		}
		return true;
	}
}

function redirectTo($url) {
	header("Location: $url");
	die();
}

function titleize($name) {
	return ucwords(str_replace("_", " ", $name));
}
?>
