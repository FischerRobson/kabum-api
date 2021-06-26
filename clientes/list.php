<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    
    include("../connection.php");

    $query_clientes = "SELECT * FROM clientes";
    $result_clientes = $conn->prepare($query_clientes);
    $result_clientes->execute();

    if(($result_clientes) AND ($result_clientes->rowCount() != 0)){
        while($row_cliente = $result_clientes->fetch(PDO::FETCH_ASSOC)){
            extract($row_cliente);

            $list_clientes["records"][$Id] = [
                'id' => $Id,
                'nome' => $Nome,
                'dataNascimento' => $DataNascimento,
                'cpf' => $Cpf,
                'rg' => $Rg,
                'telefone' => $Telefone,
            ];
        }
        http_response_code(200);
        echo json_encode($list_clientes);
    }
?>