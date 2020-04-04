<?php

if(isset($_GET['cid']) && $_GET['cid']!=""){
 
	$user = 'root';
	$pass = '';
	$db = 'mtaa';

	$conn = new mysqli('localhost', $user, $pass, $db) or die("Nepripojene!!");
	
	$cid = $_GET['cid'];

	if ($conn->connect_error) {
    	die("Connection failed: " . $conn->connect_error);
	}

	//echo $cid;

	$sql = "SELECT * FROM RESTAURANTS WHERE city_id = $cid";
	$result = mysqli_query($conn ,$sql);

	if (mysqli_num_rows($result)!=0){
	
	
		while ($row = mysqli_fetch_assoc($result)) {
		
				$array[] = $row;
			
		
		}
		header('Content-Type:Application/json');

		echo json_encode($array);
 
		mysqli_free_result($result);
 	
		mysqli_close($conn);
	}

	else {
		echo "There is no restaurant!";
		mysqli_close($conn);
		die();
	}
}

else 
{
	echo "Missing or wrong city_id!";
}


?> 