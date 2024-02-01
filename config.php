<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$servername = "localhost";
$username = "root";
$dbname = "crudPhp";

try {
  $conn = new mysqli($servername, $username, '', $dbname);
  //echo "Conexão com o banco de dados realizada com sucesso!";

} catch (PDOException $err){
  echo "Erro: Conexão com o banco de dados não foi realizada com sucesso! Erro gerado: " . $err->getMessage();
}


//Verificar conexão
if ($conn->connect_error) {
  die("Falha na Conexão: " . $conn->connect_error);
}
