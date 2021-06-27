<?php 

    include("../header.php");

    include("../repositories/clientesRepository.php"); 

    $cpf = filter_input(INPUT_GET, 'cpf', FILTER_SANITIZE_NUMBER_INT);

    $response = findByCpf($cpf);

    http_response_code(200);
    echo json_encode($response);

?>