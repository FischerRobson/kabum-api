<?php 

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

    include("connection.php");

    $response_json = file_get_contents("php://input");
    $data = json_decode($response_json, true);

    if($data){

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

        
    } else {
        $response = [
            "error" => true,
            "message" => "Error on saving instance"
        ];
    }

    http_response_code(200);
    echo json_encode($response);

?>