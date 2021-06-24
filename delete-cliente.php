<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include("connection.php");

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    $response = "";

    $query_cliente = "DELETE FROM clientes WHERE Id=:id LIMIT 1";
    $delete_cliente = $conn->prepare($query_cliente);
    $delete_cliente->bindParam(':id', $id, PDO::PARAM_INT);

    if($delete_cliente->execute()){
        $response = [
            "error" => false,
        ];
    }else{
        $response = [
            "error" => true,
            "mensagem" => "Error: operation failde"
        ];
    }

    http_response_code(200);
    echo json_encode($response);

?>