<?php
if (isset($_GET['id_client'])) {
    $id_client = $_GET['id_client'];
    include_once '../../../config.php';

    //resgatando o user_id da url e salvando em uma variável
    if (isset($_GET['user_id'])) {
        $user_id = $_GET['user_id'];
    } else {
        $user_id = $_SESSION['user_id'];
    }

    // Verificando se o parâmetro user_type foi fornecido na URL
    if (isset($_GET['user_type']) && $_GET['user_type'] == 1) {
        $user_type = 1;
    } else {
        $user_type = 0;
    }

    $sql = "UPDATE clients SET status = false WHERE id_client = $id_client";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../Home/home.php?user_id=" . $user_id . "&user_type=" . $user_type);
    } else {
        echo "Erro ao desativar o cliente: " . mysqli_error($conn);
    }
} else {
    echo "ID do cliente não fornecido.";
}
