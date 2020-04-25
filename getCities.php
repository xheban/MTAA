<?php
    header("Content-Type:application/json");
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $sql = "SELECT * FROM cities";
        $result = mysqli_query($con, $sql);
        $cities = array();
        while($row = mysqli_fetch_array($result)){
            $city = array("id" => $row['id'], "name" => $row['name']);
            array_push($cities,$city);
        }
        if(!empty($cities)){
            response(200,$cities);
        }else{
            response(400,"Empty city list");
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
