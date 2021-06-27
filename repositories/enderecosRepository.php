<?php

    function insertEndereco($data) {
        include("../connection.php");
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

        return $response;
    }

    function deleteEndereco($id) {
        include("../connection.php");
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

        return $response;
    }

    function updateEndeco($data) {
        include("../connection.php");
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

        return $response;
    }

?>