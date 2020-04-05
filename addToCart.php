<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_GET['food_id']) && isset($_GET['user_id'])){
        $foodId = $_GET['food_id'];
        $userId = $_GET['user_id'];
        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $sql = "INSERT INTO cart(food_id, user_id) VALUES(?, ?)";
        if ($stmt = $con->prepare($sql)) {

            $stmt->bind_param("ii", $foodId,$userId);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                response(200,"Food added to cart");
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
