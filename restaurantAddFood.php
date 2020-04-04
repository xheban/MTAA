<?php
header("Content-Type:application/json");
if (isset($_POST)) {
    $entityBody = file_get_contents('php://input');
    $params = json_decode($entityBody, true);
    $keys = array("restaurant_id", "price", "weight", "ingredients","type_id");
    if(arrayKeysExists($keys,$params)){

        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        foreach ($params as $key => $param){
            $params[$key] = addQoute($param);
        }
        $values = $params['restaurant_id'].", ".$params['price'].", ".$params['weight'].", ".$params['ingredients'].", ".$params['type_id'];
        $sql = "INSERT INTO food (restaurant_id,price,weight,ingredients,type_id) values ($values)";
        echo($sql);
        if ($con->query($sql) === TRUE) {
            response(200,"Food added");
        }else{
            response(400,"Adding of record was unsuccessful");

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
