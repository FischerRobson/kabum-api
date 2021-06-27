<?php 

    include("../header.php");

    include("../repositories/clientesRepository.php"); 
      
    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){
        $response = insertCliente($data);
    } else {
        $response = [
            "error" => true,
            "message" => "Error on saving instance"
        ];
    }

    http_response_code(200);
    echo json_encode($data);

?>