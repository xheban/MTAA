<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $entityBody = file_get_contents('php://input');
    $params = json_decode($entityBody, true);
    $keys = array("restaurant_id");
    if(arrayKeysExists($keys,$params)){
        foreach ($params as $key => $param){
            $params[$key] = addQoute($param);
        }
        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $where = "restaurant_id = ".$params['restaurant_id'];
        $sql = "SELECT * FROM food WHERE ".$where;
	$result = mysqli_query($con, $sql);
	$foods = array();
	while ($row = mysqli_fetch_assoc($result)) {
		//response(200,$row);
		array_push($foods,$row);
	}
	response(200,$foods);
        $con->close();

    }else{
        response(400,"Restaurant_id is missing");
    }
}else{
    response(400,"invalid type");
}

function arrayKeysExists($keys,$array){
    foreach ($keys as $key){
        if(!array_key_exists($key,$array)){
            return false;
        }
    } return true;
}

function response($response_code,$response_desc){
    $response['response_code'] = $response_code;
    $response['response_desc'] = $response_desc;
    $json_response = json_encode($response);
    echo $json_response;
    return $json_response;
}

function addQoute($string){
    $string = "\"$string\"";
    return $string;
}
