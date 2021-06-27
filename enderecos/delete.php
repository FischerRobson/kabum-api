<?php 

    include("../header.php");

    include("../repositories/enderecosRepository.php"); 

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    $response = deleteEndereco($id);

    http_response_code(200);
    echo json_encode($response);

?>