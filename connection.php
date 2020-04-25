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

$conn->close();
?> 