<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include("connection.php");

    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

    $response = "";

    $query_endereco = "DELETE FROM enderecos WHERE Id=:id LIMIT 1";
    $delete_endereco = $conn->prepare($query_endereco);
    $delete_endereco->bindParam(':id', $id, PDO::PARAM_INT);

    if($delete_endereco->execute()){
        $response = [
            "error" => false,
        ];
    }else{
        $response = [
            "error" => true,
            "mensagem" => "Error: operation failed"
        ];
    }

    http_response_code(200);
    echo json_encode($response);

?>