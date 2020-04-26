<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['user_id'])){
        $userId = $_GET['user_id'];
        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $foodList = array();
        $sql = "SELECT f.name,f.price,c.id FROM cart c
                LEFT JOIN food f ON f.id = c.food_id
                WHERE user_id = ?";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i",$userId);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = mysqli_fetch_array($result)){
                $food = array("id" => $row['id'], "name" => $row['name'], "price" => $row['price']);
                array_push($foodList,$food);
            }
            $stmt->close();
        }else{
            response(400,"Unexpected error");
        }

        if(count($foodList) == 0 ){
            response(200,"empty");
        }else{
            response(200,$foodList);
        }
    }else{
        response(400,"One of input parameters are missing");
    }

    $con->close();
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
