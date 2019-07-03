<?php
$db = "localhost";
$username = "root";
$password = "avani";
$dbname = "virus";
$conn = new mysqli($db, $username, $password, $dbname) or die($conn->error);
//$sdb = mysql_select_db($dbname, $conn) or die(mysql_error());
$dropQuery = "DROP TABLE IF EXISTS users;";
$query = "CREATE TABLE IF NOT EXISTS users (
		email varchar(1000) NOT NULL,
		username varchar(20) NOT NULL,
		password varchar(128) NOT NULL
		) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
if($conn->query($dropQuery) === TRUE && $conn->query($query) === TRUE){
	echo "Table created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}
$dropQuery = "DROP TABLE IF EXISTS viruses;";
$query = "CREATE TABLE IF NOT EXISTS viruses (
		id int(11) NOT NULL AUTO_INCREMENT,
		type varchar(20) NOT NULL,
		filesignature varchar(65495) NOT NULL,
		detect varchar(10) NOT NULL,
		PRIMARY KEY (id)
		) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;";
if($conn->query($dropQuery) === TRUE && $conn->query($query) === TRUE){
	echo "Table created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}
$conn->close();
?>
