<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entityBody = file_get_contents('php://input');
    $params = json_decode($entityBody, true);
    $keys = array("id", "name", "delivery", "min_price", "city_id");
    if(arrayKeysExists($keys,$params)){

        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $sql = "UPDATE restaurants SET name = ?, delivery = ?, min_price = ?, city_id = ? WHERE id = ?";
        if ($stmt = $con->prepare($sql)) {

            $stmt->bind_param("sddii", $params['name'],$params['delivery'],$params['min_price'],$params['city_id'],$params['id']);
            $stmt->execute();
            if($stmt->affected_rows == 1){
                response(200,"Restaurant was updated! ");
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
    exit();
}

