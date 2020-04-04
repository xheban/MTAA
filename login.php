<?php
header("Content-Type:application/json");
if (isset($_GET)) {
    $entityBody = file_get_contents('php://input');
    $params = json_decode($entityBody, true);
    $keys = array("username","password");
    if(arrayKeysExists($keys,$params)){
        foreach ($params as $key => $param){
            $params[$key] = addQoute($param);
        }
        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $where = "user_name = ".$params['username']." AND password = ".$params['password'];
        $sql = "SELECT count(id) as count FROM users WHERE ".$where;
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_array($result);
        if($row['count'] == 1){
            response(200,"OK");
        }else{
            response(400,"Invalid username and password combination");
        }
        $con->close();
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
    return $json_response;
}

function addQoute($string){
    $string = "\"$string\"";
    return $string;
}
