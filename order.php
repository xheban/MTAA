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
        $sql = "SELECT food_id FROM cart WHERE user_id = ?";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i",$userId);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = mysqli_fetch_array($result)){
                array_push($foodList,$row['food_id']);
            }
            $stmt->close();
        }else{
            response(400,"Unexpected error");
        }
        if(count($foodList) == 0 ){
            response("400","empty cart");
        };
        $dateTime = new DateTime('now');
        $dt = $dateTime->format('Y-m-d H:i:s');
        $sql = "INSERT INTO orders(food_id, user_id, `time`) VALUES(?, ?, ?)";
        foreach ($foodList as $foodId){
            if ($stmt = $con->prepare($sql)) {
                $stmt->bind_param("iis",$foodId,$userId,$dt);
                $stmt->execute();
                $stmt->close();
            }else{
                response(400,"Unexpected error");
            }
        }
        $sql = "DELETE FROM cart WHERE user_id = ?";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i",$userId);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                response(200,"Successfully ordered");
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
