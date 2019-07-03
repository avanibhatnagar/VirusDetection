<?php
require_once("connection.php");
include("helper.php");
?>
<?php echo <<<_END

<html lang="en">
<head>
	<title>Virus Scanner</title>
</head>

<center><body>
	<div>
		<b><a href="administratorSignIn.php"><p>Login as an Admin</p></a></b>
	</div>
	<div>
		<h2>Enter a file you want to test:</h2>
		<form action="index.php" method="post" enctype="multipart/form-data">
			File: <br>
			<input type="file" name="file" id="file" required>
			<br><br>
			<input type="submit" value="Submit" name="submit">
		</form>
	</div>
</body></center>
_END;
if(isset($_POST["submit"]) != ""){
	$name = $_FILES["file"]["name"];
	$size = $_FILES["file"]["size"];
	$type = $_FILES["file"]["type"];
	$temp = $_FILES["file"]["tmp_name"];
	if(isset($name)){
		if(!empty($name)){
			$location = "";
			if(move_uploaded_file($temp, $location.$name)){
				$hashSignature = extractTestFileSignature($name);
				alert("Upload Completed!");
			} else {
				alert("Upload Failed!");
			}
		}
		$query = $conn->query("SELECT * FROM viruses") or die($conn->error);
		$threat = false;
		while($row = $query->fetch_array()){
			if(strpos(trim($hashSignature), trim($row["filesignature"])) !== false){
				alert("FILE has been compromised. THREAT DETECTED!!");
				$nameToUpper = ucwords($name);
				$typeToUpper = ucwords($row["type"]);
				?>

				<center><?php echo $nameToUpper; ?> was scanned successfully - Threat Detected! </center>
				<h5><font style="color:grey"><center>Scanned File Details</center></font></h5>
				<center><table>
					<thread>
						<tr>
							<th>FILE NAME:</th>
							<th>VIRUS TYPE:</th>
							<th>THREAT(Y/N):</th>
						</tr>
					</thread>
					<tbody>
						<tr>
							<td><font style="color:red"><?php echo $nameToUpper; ?></font></td>
							<td><font style="color:red"><?php echo $typeToUpper; ?></font></td>
							<td><font style="color:red">Yes</font></td>
						</tr>
					</tbody>
				</table></center>
			<?php
			$threat = true;
			break;
			}
		}
		if(!$threat){
			$nameToUpper = ucwords($name);
			?>
			<center><?php echo $nameToUpper; ?> was scanned successfully - No Threats Have Been Detected! </center>
			<?php
		}
	}
}
$conn->close();
?>
</html>
