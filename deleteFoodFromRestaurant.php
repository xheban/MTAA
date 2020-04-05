<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    	$entityBody = file_get_contents('php://input');
    	$params = json_decode($entityBody, true);
    	$keys = array("id", "restaurant_id");
	if(arrayKeysExists($keys,$params)){
        	$con = mysqli_connect("localhost", "root", "", "mtaa");
        	if (mysqli_connect_errno()) {
            		echo "Failed to connect to MySQL: " . mysqli_connect_error();
            	die();
        	}
        	$sql = "DELETE FROM food WHERE id = ? AND restaurant_id = ?";
        	if ($stmt = $con->prepare($sql)) {
            		$stmt->bind_param("ii", $params['id'],$params['restaurant_id']);
            		$stmt->execute();
            		if($stmt->affected_rows > 0){
                		response(200,"Food deleted from restauran!");
            		}else{
                		response(400,"One of input parameters are not valid");
            		}
            		$stmt->close();
        	}else{
            		response(400,"Unexpected error");
        	}
    }else{
        response(400,"One of input parameters are missing");
    }


}else{
    response(400,"invalid type");
}

function response($response_code,$response_desc){
    $response['response_code'] = $response_code;
    $response['response_desc'] = $response_desc;
    $json_response = json_encode($response);
    echo $json_response;
    exit();
}

function arrayKeysExists($keys,$array){
    foreach ($keys as $key){
        if(!array_key_exists($key,$array)){
            return false;
        }
    } return true;
}
