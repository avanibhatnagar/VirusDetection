<?php
require_once("connection.php");
include("helper.php");
session_start();
if(!isset($_SESSION["rootuser"])){
	header("Location: index.php");
	exit();
}
if(isset($_POST["submitSign"]) != ""){
	$manualSign = $_POST["manualSign"];
	$virusType = $_POST["manualVirusType"];
	$query = "INSERT INTO viruses (id, type, filesignature, detect) VALUES (NULL, '".mysqli_real_escape_string($conn, $virusType)."', '".mysqli_real_escape_string($conn, $manualSign)."', 'Yes')";
	$result = $conn->query($query);
	if($result){
		alert("File Signature has been successfully uploaded!");
	} else {
		alert("Upload failed!");
	}
}
if(isset($_POST["submit"]) != ""){
	$name = $_FILES["file"]["name"];
	$size = $_FILES["file"]["size"];
	$type = $_FILES["file"]["type"];
	$temp = $_FILES["file"]["tmp_name"];
	$virusType = $_POST["manualVirusType2"];
	if(isset($name)){
		if(!empty($name)){
			$location = "";
			if(move_uploaded_file($temp, $location.$name)){
				$hashSigAdmin = extractFileSignature($name);
				$query = "INSERT INTO viruses (id, type, filesignature, detect) VALUES (NULL, '".mysqli_real_escape_string($conn, $virusType)."', '".mysqli_real_escape_string($conn, $hashSigAdmin)."', 'Yes')";
				$result = $conn->query($query);
				if($result){
					alert("Success - your file is scanning!");
					alert("File signature has been uploaded to the database: ".$hashSigAdmin);
				} else {
					alert("Failed to upload the file signature.");
				}
			}
		}
	}
}
echo<<<_END

<html>
	<head>
		<title>Admin Virus Detect</title>
	</head>
	<h3>Hello Admin</h3>
	<div align="right">
		<a href="logout.php"> Log out </a>
	</div>
	<form action="UploadSignatureFile.php" method="post" enctype="multipart/form-data" name="malwareForm" onsubmit="return validateMalware(this)">
	<center><p>Paste Signature Here:</p></center>
	<center><input type="text" name="manualSign" required size="90" maxlength="="65000"></center>
	<center><i>Enter Malware Type: </i>
	<input type="text" name="manualVirusType" name="submitSign"></center>
	<center> <input type="submit" value="submit" name="submitSign"></center>
	<br>
	</form>
	<center> OR </center>
	<br>
	<form action="UploadSignatureFile.php" method="post" name="malewareForm2" enctype="multipart/form-data" onsubmit="return validateMalware(this)">
	<center> <p>Upload file:</p></center>
		<div>
			<center><input type="file" name="file" required id="file"></center>
			<center> <i>Enter Malware Type: </i>
			<input type="text" name="manualVirusType2" required size="10" maxlength="20"></center>
			<center><input type="submit" value="Scan Your File to detect!" name="submit"></center>
			<br>
		</div>
	</form>

	<script>
		function validateMalware(form){
			var malwareName = form.manualVirusType.value;
			var malwareName2 = form.manualVirusType2.value;
			if(/[^a-zA-Z0-9]/.test(malwareName)){
				alert("Name of malware can only be letters or numbers. No special characters allowed.");
				return false;
			} else if(/[^a-zA-z0-9]/.test(malwareName2)){
				alert("Name of malware can only be letters or numbers. No special characters allowed.");
			}
		}
	</script>
</html>

_END;
?>
