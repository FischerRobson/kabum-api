<?php

    include("../header.php");

    include("../repositories/usuariosRepository.php");

    $response = listUsuarios();

    http_response_code(200);
    echo json_encode($response);
    
?>