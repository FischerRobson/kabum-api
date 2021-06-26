<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

    include("../connection.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){
            
        $query_update_cliente = "UPDATE clientes SET 
                                    Nome= :nome,
                                    DataNascimento= :data_nasc,
                                    Cpf= :cpf,
                                    Rg= :rg,
                                    Telefone= :tel
                                    WHERE Id= :id";

        $update_cliente = $conn -> prepare($query_update_cliente);
        $update_cliente->bindParam(':nome', $data['nome']);
        $update_cliente->bindParam(':data_nasc', $data['dataNascimento']);
        $update_cliente->bindParam(':cpf', $data['cpf']);
        $update_cliente->bindParam(':rg', $data['rg']);
        $update_cliente->bindParam(':tel', $data['telefone']);
        $update_cliente->bindParam(':id', $data['id']);

        $update_cliente->execute();

        if($update_cliente -> rowCount()){
            $response = [
                "error" => false,
                "message" => "Instance changed success"
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Syntax error on change instance"
            ];
        }
    
    } else {
        $response = [
            "error" => true,
            "message" => "Error on change instance"
        ];
    }

    http_response_code(200);
    echo json_encode($response);


?>