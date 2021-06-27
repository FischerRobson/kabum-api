<?php 

    include("../header.php");
    
    include("../repositories/enderecosRepository.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){

        $response = insertEndereco($data);
        
    } else {
        $response = [
            "error" => true,
            "message" => "Error on saving instance"
        ];
    }

    http_response_code(200);
    echo json_encode($response);
?>