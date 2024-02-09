<?php
include_once '../../../config.php';

if (isset($_POST['updateClient'])) {
    $id = $_POST['id_client'];
    $nameClient = $_POST['nameClient'];
    $emailClient = $_POST['emailClient'];
    $cpfClient = $_POST['cpfClient'];
    $rgClient = $_POST['rgClient'];
    $telephoneClient = $_POST['telephoneClient'];
    $optionalTelephone = $_POST['optionalTelephone'];
    $dateOfBirth = $_POST['dateOfBirth'];

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

    // Verificando se já existe um cliente com o msm cpf ou rg
    $checkQuery = "SELECT * FROM clients WHERE (cpf = '$cpfClient' OR rg = '$rgClient') AND id_client != $id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {

        // CPF ou RG já cadastrado em outro cliente
        header('Location: ./editClient.php');
        $msgError = 'CPF ou RG já cadastrado para outro cliente. A atualização não foi realizada.';
        print_r($msgError);
        $_SESSION['msgError'] = $msgError;
    } else {
        // Atualização permitida
        $sqlUpdate = "UPDATE clients SET name_client='$nameClient', cpf='$cpfClient', email_client='$emailClient', 
            telephone1='$telephoneClient', telephone2='$optionalTelephone', date_birth='$dateOfBirth', rg='$rgClient' WHERE id_client=$id";

        $result = $conn->query($sqlUpdate);
        header("Location: ../../Home/home.php?user_id=" . $user_id . "&user_type=" . $user_type);
    }
}
