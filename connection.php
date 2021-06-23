<?php 

    $host = "localhost";
    $user = "root";
    $password = "";

    $dbname="kabum";
    $port = "3306";

    $conn = new PDO("mysql:host=$host;post=$port;dbname=" . $dbname, $user);

?>