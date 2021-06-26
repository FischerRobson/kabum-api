<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

    include("../connection.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){

        $query_endereco = "INSERT INTO enderecos 
                                (Logradouro, Numero, Bairro, Cidade, Uf, Complemento, Cliente_id, Cep)
                                VALUES
                                (:logradouro, :numero, :bairro, :cidade, :uf, :complemento, :clienteid, :cep)";
        
        $cadastrar_endereco = $conn -> prepare($query_endereco);

        $cadastrar_endereco->bindParam(':logradouro', $data['logradouro']);
        $cadastrar_endereco->bindParam(':numero', $data['numero']);
        $cadastrar_endereco->bindParam(':bairro', $data['bairro']);
        $cadastrar_endereco->bindParam(':cidade', $data['cidade']);
        $cadastrar_endereco->bindParam(':uf', $data['uf']);
        $cadastrar_endereco->bindParam(':clienteid', $data['clienteId']);
        $cadastrar_endereco->bindParam(':cep', $data['cep']);
        $cadastrar_endereco->bindParam(':complemento', $data['complemento']);

        $cadastrar_endereco -> execute();

        if($cadastrar_endereco -> rowCount()){
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
    echo json_encode($response);
?>