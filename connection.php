<?php
 
$user = 'root';
$pass = '';
$db = 'mtaa';

$conn = new mysqli('localhost', $user, $pass, $db) or die("Nepripojene!!");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

else 
{
	echo "OK";
}

$sql = "INSERT INTO cities (name)
VALUES ('Bratislava')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?> 