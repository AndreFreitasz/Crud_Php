<?php 
    session_start();

    $servername = "localhost";
    $username = "root";
    $dbname = "crudPhp";

    $conn = new mysqli($servername, $username, '', $dbname);

    //Verificar conexão
    if ($conn->connect_error) {
      die("Falha na Conexão: " . $conn->connect_error);  
    }
?>