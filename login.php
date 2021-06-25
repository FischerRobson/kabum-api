<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    
    include("connection.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    $password = md5($data['password']);

    $query_login = "SELECT * FROM users WHERE username= :username AND password= :password";
    $result_login = $conn->prepare($query_login);
    $result_login->bindParam(':username', $data['username'] );
    $result_login->bindParam(':password', $password);
    $result_login->execute();

    if(($result_login) AND ($result_login->rowCount() != 0)){
        $row_user = $result_login->fetch(PDO::FETCH_ASSOC);
        extract($row_user);
    
        $user = [
            'username' => $Username,
            'id' => $Id  
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

    http_response_code(200);
    echo json_encode($response);
    
?>