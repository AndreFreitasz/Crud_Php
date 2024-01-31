<?php

if (isset($_SESSION['user_id']) && !empty($_GET['id_client'])) {
    include_once '../../config.php';

    $clientId = $_GET['id_client'];
    $_SESSION['edit_user_id'] = $userId;
    $sqlSelect = "SELECT * FROM clients WHERE id_client=$clientId";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {

        $sqlDisable = "DELETE FROM clients WHERE id_client=$clientId";
        $resultDisable = $conn->query($sqlDisable);

    } else {
        header('Location: ../../index.php');
    }
}

header('Location: ../Home/home.php');
