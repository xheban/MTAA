<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $entityBody = file_get_contents('php://input');
    $params = json_decode($entityBody, true);
    $keys = array("username", "email");
    if(arrayKeysExists($keys,$params)){

        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $sql = "UPDATE users SET email = ? WHERE user_name = ?";
        if ($stmt = $con->prepare($sql)) {

            $stmt->bind_param("ss", $params['email'],$params['username']);
            $stmt->execute();
            if($stmt->affected_rows == 1){
                response(200,"Email successfully reset");
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

