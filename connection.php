<?php
	ini_set("error_reporting", E_ALL & ~E_DEPRECATED);
	$conn = new mysqli("localhost", "root", "avani", "virus") or die($conn->error);
	//$sdb = mysql_select_db("virusdb", $conn) or die(mysql_error());
?>
