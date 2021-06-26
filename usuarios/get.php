<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    
    include("../connection.php");

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
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
    http_response_code(200);
    echo json_encode($response);
    
?>