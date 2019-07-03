<?php
require_once("connection.php");
include("helper.php");
echo <<<_END

<script>
	function validateForm(form){
		fail = validateUsername(form.username.value);
		fail += validatePassword(form.password.value);
		fail += validateEmail(form.email.value);
		if(fail == "")
			alert("Validation Successful");
			return true;
		else {
			alert(fail);
			return false;
		}
	}
	function validateUsername(field){
		if(field == "")
			return "No Username was entered \n";
		else if (field.length < 6){
			return "Usernames need to be at least 6 characters. \n";
		} else if (/[^a-zA-Z0-9_-]/.test(field))
			return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\n";
		return "";
	}
	function validatePassword(field){
		if(field == "")
			return "No password was entered.\n";
		else if(field.length < 6)
			return " Passwords need to be at least 6 characters. \n";
		else if (!/[a-z]/.test(field) || !/[A-Z]/.test(field) || !/[0-9]/.test(field))
			return "Passwords require at least one lowercase letter, one uppercase letter, and one number 0-9.\n";
		return "";
	}
	function validateEmail(field){
		if(field == "")
			return "No Email was entered. \n";
		else if(!((field.indexOf(".") > 0) && (field.indexOf("@") > 0) || /[^a-zA-Z0-9.@_-]/.test(field))
			return "The Email address is invalid.\n"
		return "";
	}
</script>
<html>
	<head>
		<title>Virus Scanner - Admin Registration</title>
	</head>
	<form action="registerAdmin.php" method="post" name="adminform" onsubmit="return validateForm(this)">
		<h4>Admin Registration</h4>
			<hr>
			Username:<input type="text" placeholder="username" name="username" requred maxlength="30">
			Password:<input type="password" placeholder="password" name="password" required>
			<button name="registerBtn" value="Register!" type="submit"> Register! </button>
	</form>
	<a href="administratorSignIn.php"> <p> Back!</p></a>
</html>

_END;
if(isset($_POST["registerBtn"])){
	$usernameInput = $_POST["username"];
	$username = strtolower($usernameInput);
	$password = mysql_entities_fix_string($conn, $_POST["password"]);
	$passwordHash = hash("sha512", $password);
	$checkExisting = $conn->query("SELECT * FROM users WHERE username = '$username'");
	$existingTb = mysqli_fetch_array($checkExisting);
	if($existingTb['username'] == $username){
		alert("Username already exists, try another username");
	} else {
		$query = "INSERT INTO users (username, password) VALUES ('".mysqli_real_escape_string($conn, $username)."', '".mysqli_real_escape_string($conn, $passwordHash)."');";
		$insert = $conn->query($query);
		if($insert){
			alert("Admin account created!");
		} else {
			alert("Error creating your account.");
		}
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
?>
