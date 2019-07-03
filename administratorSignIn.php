<?php
require_once("connection.php");
include("helper.php");
session_start();
if(ISSET($_SESSION["rootuser"])){
	header("Location: UploadSignatureFile.php");
	exit();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$userPost = $_POST["username"];
	$userLowercase = strtolower($userPost);
	$user = mysql_entities_fix_string($conn, $userLowercase);
	$pass = mysql_entities_fix_string($conn, $_POST["password"]);
	$pass = hash("sha512", $pass);
	$query = $conn->query("SELECT * FROM users WHERE username = '$user' and password = '$pass'") or die("Failed: " . $conn->error);
	$row = mysqli_fetch_array($query);
	if($row["username"] == $user && $row["password"] == $pass){
		$_SESSION["rootuser"] = $user;
		header("Location: UploadSignatureFile.php");
		exit();
	} else {
		alert("Invalid credentials, try again!");
	}
}
$conn->close();

function mysql_entities_fix_string($connection, $string) {
    return htmlentities(mysql_fix_string($connection, $string));
}
function mysql_fix_string($connection, $string) {
    if(get_magic_quotes_gpc())
        $string = stripslashes($string);
    return $connection->real_escape_string($string);
}
echo <<<_END
<html>
<head>
	<title>Virus Scanner - Admin Login</title>
</head>
<center><form action="" method="post" name="loginForm">
	<h4>Admin Login</h4>
		<input type="text" name="username" placeholder="username" required="true"/>
		<input type="password" name="password" placeholder="password" required="true"/>
		<button name="submit" value="Login" type="submit">Login</button>
</form></center>
<div align="center">
	<b><a href="index.php"><p>Back!</p></a></b>
</div>
</html>
_END;
?>
