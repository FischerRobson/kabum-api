<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

    include("connection.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){

        // Logradouro= :logradouro
        // Numero= :numero,
        // Bairro= :bairro,
        // Cidade= :cidade,
        // Uf= :uf,
        // Complemento= :complemento,
        // Cep= :cep 
            
        $query_update_endereco = "UPDATE enderecos SET 
                                        logradouro= :logradouro,
                                        numero= :numero,
                                        bairro= :bairro,
                                        cidade= :cidade,
                                        uf= :uf,
                                        cep= :cep,
                                        complemento= :complemento
                                        WHERE id=:id";

        $update_endereco = $conn -> prepare($query_update_endereco);
        $update_endereco->bindParam(':logradouro', $data['logradouro']);
        $update_endereco->bindParam(':numero', $data['numero']);
        $update_endereco->bindParam(':bairro', $data['bairro']);
        $update_endereco->bindParam(':cidade', $data['cidade']);
        $update_endereco->bindParam(':uf', $data['uf']);
        $update_endereco->bindParam(':cep', $data['cep']);
        $update_endereco->bindParam(':complemento', $data['complemento']);
        $update_endereco->bindParam(':id', $data['id']);

        $update_endereco->execute();

        if($update_endereco -> rowCount()){
            $response = [
                "error" => false,
                "message" => "Instance changed success"
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Syntax error on change instance or nothing has changed"
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