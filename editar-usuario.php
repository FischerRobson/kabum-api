<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

    include("connection.php");

    include 'assets/encrypt.php';

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){
        
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
    
    } else {
        $response = [
            "error" => true,
            "message" => "Error on change instance"
        ];
    }

    http_response_code(200);
    echo json_encode($response);


?>