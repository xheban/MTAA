<?php
    header("Content-Type:application/json");
    if (isset($_GET['id']) && $_GET['id']!="") {

        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $id = $_GET['id'];

        $sql = "SELECT * FROM cities";
        $result = mysqli_query($con, $sql);
        $cities = array();
        while($row = mysqli_fetch_array($result)){
            array_push($cities,$row);
        }
        foreach ($cities as $city){
            echo $city['name'];
       }

//    if(mysqli_num_rows($result)>0){
//    $row = mysqli_fetch_array($result);
//    $amount = $row['amount'];
//    $response_code = $row['response_code'];
//    $response_desc = $row['response_desc'];
//    response($order_id, $amount, $response_code,$response_desc);
//    mysqli_close($con);
//    }else{
//    response(NULL, NULL, 200,"No Record Found");
//    }
//    }else{
//    response(NULL, NULL, 400,"Invalid Request");
//    }
    }
    function response($order_id,$amount,$response_code,$response_desc){
    $response['order_id'] = $order_id;
    $response['amount'] = $amount;
    $response['response_code'] = $response_code;
    $response['response_desc'] = $response_desc;

    $json_response = json_encode($response);
    echo $json_response;
    }
