<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    
    include("connection.php");

    $query_users = "SELECT * FROM users";
    $result_users = $conn->prepare($query_users);
    $result_users->execute();

    if(($result_users) AND ($result_users->rowCount() != 0)){
        while($row_cliente = $result_users->fetch(PDO::FETCH_ASSOC)){
            extract($row_cliente);

            $list_users["records"][$Id] = [
                'id' => $Id,
                'username' => $Username,
                'password' => $Password,
                'nivel' => $Nivel,
            ];
        }
        http_response_code(200);
        echo json_encode($list_users);
    }
?>