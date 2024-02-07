<?php
if(isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    include_once '../../../config.php';

    $sql = "UPDATE users SET status_user = 0 WHERE id_user = $id_user";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../adminDashboard.php");
    } else {
        echo "Erro ao ativar o usuário: " . mysqli_error($conn);
    }
} else {
    echo "ID do usuário não fornecido.";
}
?>