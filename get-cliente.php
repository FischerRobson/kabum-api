<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    
    include("connection.php");

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $response = "";

    $query_cliente = "SELECT * FROM clientes WHERE Id= :id LIMIT 1";
    $result_cliente = $conn->prepare($query_cliente);
    $result_cliente->bindParam(':id', $id, PDO::PARAM_INT);
    $result_cliente->execute();
    
    if(($result_cliente) AND ($result_cliente->rowCount() != 0)){
        $row_cliente = $result_cliente->fetch(PDO::FETCH_ASSOC);
        extract($row_cliente);
    
        $cliente = [
            'id' => $Id,  
            'nome' => $Nome,
            'dataNascimento' => $DataNascimento,
            'cpf' => $Cpf,
            'rg' => $Rg,
            'telefone' => $Telefone

        ];
    
        $response = [
            "cliente" => $cliente
        ];
    } else{
        $response = [
            "error"=> true,
            "message" => "Cliente not found"
        ];
    }
    http_response_code(200);
    echo json_encode($response);
    
?>