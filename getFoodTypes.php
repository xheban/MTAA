<?php
    header("Content-Type:application/json");
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $con = mysqli_connect("localhost", "root", "", "mtaa");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $sql = "SELECT * FROM foodtype";
        $result = mysqli_query($con, $sql);
        $types = array();
        while($row = mysqli_fetch_array($result)){
            $type = array("id" => $row['id'], "name" => $row['name']);
            array_push($types,$type);
        }
        if(!empty($types)){
            response(200,$types);
        }else{
            response(400,"Empty type list");
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
