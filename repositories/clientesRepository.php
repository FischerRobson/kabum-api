<?php 

    function listClientes () {
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
            return $list_clientes;
        }
    }

    function getCliente($id) {
        include("../connection.php");
        
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

        return $response;
    }

    function deleteCliente($id) {
        include("../connection.php");
        $response = "";

        $query_cliente = "DELETE FROM clientes WHERE Id=:id LIMIT 1";
        $delete_cliente = $conn->prepare($query_cliente);
        $delete_cliente->bindParam(':id', $id, PDO::PARAM_INT);

        /* -------------------------------------------------------------- */

        $query_enderecos = "DELETE FROM enderecos WHERE Cliente_id=:id";
        $delete_enderecos = $conn->prepare($query_enderecos);
        $delete_enderecos->bindParam(':id', $id, PDO::PARAM_INT);
        $delete_enderecos->execute();

        if($delete_cliente->execute()){
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

    function insertCliente($data) {
        include("../connection.php");
        $query_cliente = "INSERT INTO clientes 
                                (Nome, DataNascimento, Cpf, Rg, Telefone)
                                VALUES
                                (:nome, :data_nasc, :cpf, :rg, :tel)";
        
        $cadastrar_cliente = $conn -> prepare($query_cliente);

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

        return $response;
    }

    function updateCliente($data) {
        include("../connection.php");
        
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

        return $response;
    }
?>