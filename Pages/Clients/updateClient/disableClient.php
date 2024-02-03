<?php
if(isset($_GET['id_client'])) {
    $id_client = $_GET['id_client'];
    include_once '../../../config.php';

    $sql = "UPDATE clients SET status = false WHERE id_client = $id_client";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../Home/home.php");
    } else {
        echo "Erro ao desativar o cliente: " . mysqli_error($conn);
    }
} else {
    echo "ID do cliente não fornecido.";
}
?>