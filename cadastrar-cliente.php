<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

    include("connection.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){

        $query_clientes = "INSERT INTO clientes 
                                (Nome, DataNascimento, Cpf, Rg, Telefone)
                                VALUES
                                (:nome, :data_nasc, :cpf, :rg, :tel)";
        
        $cadastrar_cliente = $conn -> prepare($query_clientes);

        $cadastrar_cliente->bindParam(':nome', $data['nome']);
        $cadastrar_cliente->bindParam(':data_nasc', $data['dataNascimento']);
        $cadastrar_cliente->bindParam(':cpf', $data['cpf']);
        $cadastrar_cliente->bindParam(':rg', $data['rg']);
        $cadastrar_cliente->bindParam(':tel', $data['telefone']);

        $cadastrar_cliente -> execute();

        if($cadastrar_cliente -> rowCount()){
            $response = [
                "error" => false,
                "message" => "Instance saved success"
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Syntax error on saving instance"
            ];
        }

        
    } else {
        $response = [
            "error" => true,
            "message" => "Error on saving instance"
        ];
    }

    http_response_code(200);
    echo json_encode($data);
?>