<?php

    include("../header.php");

    include("../repositories/clientesRepository.php");   

    $response = listClientes();
    
    http_response_code(200);
    echo json_encode($response);
?>