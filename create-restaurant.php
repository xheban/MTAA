<?php

if(!(isset($_GET['name']) && $_GET['name']!="")){
	echo "Missing name!";
	die();
}

if(!(isset($_GET['delivery']) && $_GET['delivery']!="")){
	echo "Missing delivery time!";
	die();
}

if(!(isset($_GET['min_price']) && $_GET['min_price']!="")){
	echo "Missing minimal price!";
	die();
}

//if(!(isset($_GET['open_from']) && $_GET['open_from']!="")){
//	echo "Missing Opening time!";
//	die();
//}

//if(!(isset($_GET['open_to']) && $_GET['open_to']!="")){
//	echo "Missing Closing time!";
//	die();
//}

if(!(isset($_GET['city_id']) && $_GET['city_id']!="")){
	echo "Missing city_id";
	die();
}

if(!(isset($_GET['rating']) && $_GET['rating']!="")){
	echo "Missing rating";
	die();
}

$user = 'root';
$pass = '';
$db = 'mtaa';

$conn = new mysqli('localhost', $user, $pass, $db) or die("Nepripojene!!");

if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
}

$name = $_GET['name'];
$delivery = $_GET['delivery'];
$min_price = $_GET['min_price'];
//$open_from = $_GET['open_from'];
//$open_to = $_GET['open_to'];
$city_id = $_GET['city_id'];
$rating = $_GET['rating'];

$sql = "SELECT * FROM CITIES WHERE id = $city_id";
$result = mysqli_query($conn ,$sql);

if (mysqli_num_rows($result)!=0){

	$sql = "INSERT INTO RESTAURANTS (name, min_price, delivery, rating, city_id) VALUES('$name','$min_price','$delivery','$rating','$city_id')";

	if ($conn->query($sql) === TRUE) {
    		echo "New record created successfully";
	} 
	else {
    		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

else{
	echo "City with this ID dont exist!";
}

mysqli_close($conn);

?> 

