<?php

    function listUsuarios() {
        include("../connection.php");
        $query_users = "SELECT * FROM users";
        $result_users = $conn->prepare($query_users);
        $result_users->execute();
    
        if(($result_users) AND ($result_users->rowCount() != 0)){
            while($row_cliente = $result_users->fetch(PDO::FETCH_ASSOC)){
                extract($row_cliente);
    
                $list_users["records"][$Id] = [
                    'id' => $Id,
                    'username' => $Username,
                    'nivel' => $Nivel,
                ];
            }
        }
        return $list_users;
    }

    function getUsuario($id) {
        include("../connection.php");
        $response = "";

        $query_user = "SELECT * FROM users WHERE Id= :id LIMIT 1";
        $result_user = $conn->prepare($query_user);
        $result_user->bindParam(':id', $id, PDO::PARAM_INT);
        $result_user->execute();
        
        if(($result_user) AND ($result_user->rowCount() != 0)){
            $row_user = $result_user->fetch(PDO::FETCH_ASSOC);
            extract($row_user);
        
            $user = [
                'id' => $Id,  
                'username' => $Username,
                'nivel' => $Nivel
            ];
        
            $response = [
                "user" => $user
            ];
        } else{
            $response = [
                "error"=> true,
                "message" => "User not found"
            ];
        }

        return $response;
    }

    function deleteUsuario($id) {
        include("../connection.php");
        $response = "";

        $query_user = "DELETE FROM users WHERE Id=:id LIMIT 1";
        $delete_user = $conn->prepare($query_user);
        $delete_user->bindParam(':id', $id, PDO::PARAM_INT);

        if($delete_user->execute()){
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

    function insertUsuario($data) {
        include("../connection.php");
        $password = $data['password'];

        $query_users = "INSERT INTO users 
                                (Username, Password, Nivel)
                                VALUES
                                (:username, :pass, :nivel)";
        
        $cadastrar_user = $conn -> prepare($query_users);

        $cadastrar_user->bindParam(':username', $data['username']);
        $cadastrar_user->bindParam(':pass', md5($password));
        $cadastrar_user->bindParam(':nivel', $data['nivel']);


        $cadastrar_user -> execute();

        if($cadastrar_user -> rowCount()){
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

    function updateUsuario($data) {
        include("../connection.php");
        $password = $data['password'];
        $password_crypted = md5($password);
    
        $query_update_users = "UPDATE users SET 
                                    Username= :username,
                                    Password= :pass,
                                    Nivel= :nivel
                                    WHERE Id= :id";

        $update_user = $conn -> prepare($query_update_users);
        $update_user->bindParam(':username', $data['username']);
        $update_user->bindParam(':pass', $password_crypted);
        $update_user->bindParam(':nivel', $data['nivel']);
        $update_user->bindParam(':id', $data['id']);

        $update_user->execute();

        if($update_user -> rowCount()){
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