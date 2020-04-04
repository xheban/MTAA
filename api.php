<?php
    header("Content-Type:application/json");
    require_once 'dbController.php';
    $dbConnection = ConnectDb::getInstance();


//    if(mysqli_num_rows($result)>0){
//        $row = mysqli_fetch_array($result);
//        $amount = $row['amount'];
//        $response_code = $row['response_code'];
//        $response_desc = $row['response_desc'];
//        response($order_id, $amount, $response_code,$response_desc);
//        mysqli_close($con);
//    }else{
//        response(NULL, NULL, 200,"No Record Found");
//    }

//    response(NULL, NULL, 400,"Invalid Request");


function response($order_id,$amount,$response_code,$response_desc){
    $response['order_id'] = $order_id;
    $response['amount'] = $amount;
    $response['response_code'] = $response_code;
    $response['response_desc'] = $response_desc;

    $json_response = json_encode($response);
    echo $json_response;
}
?>
