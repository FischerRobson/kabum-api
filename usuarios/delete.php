<?php 

    include("../header.php");

    include("../repositories/usuariosRepository.php");

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    $response = deleteUsuario($id);

    http_response_code(200);
    echo json_encode($response);

?>