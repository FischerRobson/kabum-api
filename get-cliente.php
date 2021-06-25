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
    /* -------------------------------------------------------------------- */
    $query_enderecos = "SELECT * FROM enderecos WHERE Cliente_id= :id";
    $result_enderecos = $conn->prepare($query_enderecos);
    $result_enderecos->bindParam(':id', $id, PDO::PARAM_INT);
    $result_enderecos->execute();

    $list_enderecos = [];

    if(($result_enderecos) AND ($result_enderecos->rowCount() != 0)){
        while($row_enderecos = $result_enderecos->fetch(PDO::FETCH_ASSOC)){
            extract($row_enderecos);

            $list_enderecos[$Id] = [
                'id' => $Id,
                'logradouro' => $Logradouro,
                'bairro' => $Bairro,
                'cidade' => $Cidade,
                'uf' => $Uf,
                'complemento' => $Complemento,
                'numero' => $Numero,
                'cep' => $Cep,
            ];
        }
    }
    /* -------------------------------------------------------------------- */
    if(($result_cliente) AND ($result_cliente->rowCount() != 0)){
        $row_cliente = $result_cliente->fetch(PDO::FETCH_ASSOC);
        extract($row_cliente);
    
        $cliente = [
            'id' => $Id,  
            'nome' => $Nome,
            'dataNascimento' => $DataNascimento,
            'cpf' => $Cpf,
            'rg' => $Rg,
            'telefone' => $Telefone,
            'enderecos' => $list_enderecos
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