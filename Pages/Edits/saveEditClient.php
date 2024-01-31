<?php
include_once '../../config.php';

if (isset($_POST['updateClient'])) {
    $id = $_POST['id_client'];
    $nameClient = $_POST['nameClient'];
    $emailClient = $_POST['emailClient'];
    $cpfClient = $_POST['cpfClient'];
    $rgClient = $_POST['rgClient'];
    $telephoneClient = $_POST['telephoneClient'];
    $optionalTelephone = $_POST['optionalTelephone'];
    $dateOfBirth = $_POST['dateOfBirth'];

    // Consulta para verificar se já existe um cliente com o mesmo CPF ou RG
    $checkQuery = "SELECT * FROM clients WHERE (cpf = '$cpfClient' OR rg = '$rgClient') AND id_client != $id";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // CPF ou RG já cadastrado em outro cliente
        header('Location: ./editClient.php');
        $msgError = 'CPF ou RG já cadastrado para outro cliente. A atualização não foi realizada.';
        print_r($msgError);
        $_SESSION['msgError'] = $msgError;
    } else {
        // Atualização permitida, continue com o update
        $sqlUpdate = "UPDATE clients SET name_client='$nameClient', cpf='$cpfClient', email_client='$emailClient', 
            telephone1='$telephoneClient', telephone2='$optionalTelephone', date_birth='$dateOfBirth', rg='$rgClient' WHERE id_client=$id";

        $result = $conn->query($sqlUpdate);
        header("Location: ../Home/home.php");
    }
}
