<?php
header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['user_id'])) {
        $userId = $_GET['user_id'];
        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }
        $orderHistory = array();
        $ordersTimes = array();
        $sql = "SELECT DISTINCT(`time`) as time FROM orders WHERE user_id = ?";
        if ($stmt = $con->prepare($sql)) {
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = mysqli_fetch_array($result)) {
                array_push($ordersTimes, $row['time']);
            }
            $stmt->close();
        } else {
            response(400, "Unexpected error");
        }

        foreach ($ordersTimes as $time){
            $foodList = array();
            $finalPrice = 0;
            $sql = "SELECT f.name as food_name, f.price FROM orders o 
                    LEFT JOIN food f ON f.id = o.food_id
                    WHERE o.user_id = ? AND o.time = ?";
            if ($stmt = $con->prepare($sql)) {
                $stmt->bind_param("is", $userId,$time);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = mysqli_fetch_array($result)) {
                    $food = array("name" => $row['food_name'], "price" => $row['price']);
                    array_push($foodList, $food);
                }
                $stmt->close();
            } else {
                response(400, "Unexpected error");
            }
            foreach ($foodList as $food){
                $finalPrice += $food['price'];
            }
            $order = array("time" => $time, "price" => $finalPrice, "food_list" => $foodList);
            array_push($orderHistory,$order);
        }
        response(200,$orderHistory);
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
