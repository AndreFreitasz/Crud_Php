<?php
session_start();

$msgError = '';

if (isset($_SESSION['user_id']) && isset($_POST['submitClient'])) {
    include_once '../../config.php';

    $userId = $_SESSION['user_id'];

    $nameClient = $_POST['nameClient'];
    $emailClient = $_POST['emailClient'];
    $cpfClient = $_POST['cpfClient'];
    $rgClient = $_POST['rgClient'];
    $telephoneClient = $_POST['telephoneClient'];
    $optionalTelephone = $_POST['optionalTelephone'];
    $dateOfBirth = $_POST['dateOfBirth'];

    //Corrigir o formato da data
    $dateOfBirth = date('Y-m-d', strtotime($_POST['dateOfBirth']));

    // Consulta para verificar se já existe um cliente com mesmo CPF ou RG
    $checkQuery = "SELECT * FROM clients WHERE cpf = '$cpfClient' OR rg = '$rgClient'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $msgError = 'CPF ou RG já cadastrado.';
    } else {
        $result = mysqli_query($conn, "INSERT INTO clients( id_user, name_client, cpf, rg, email_client, telephone1, telephone2, date_birth) 
        VALUES ( '$userId', '$nameClient', '$cpfClient', '$rgClient', '$emailClient', '$telephoneClient', '$optionalTelephone', '$dateOfBirth')");

        header("Location: ../Home/home.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../Home/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .icon-and-title {
            display: flex;
            align-items: center;
        }

        h2 {
            margin-left: 8px;
            align-items: center;
            justify-content: center;
        }

        .tab-content {
            border-bottom: 1px solid #ff7b00;
            padding: 20px;
        }

        input[name="submitClient"] {
            background-color: #ff7b00;
            display: flex;
            margin-top: 16px;
        }

        input[name="submitAddress"] {
            background-color: #ff7b00;
            display: flex;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <form method="post" action="../Home/home.php">
                <div class="logo">
                    <input type="submit" name="back" value="Voltar para home">
                </div>
            </form>
        </div>
    </header>

    <div class="container mt-2">
        <div class="tab-content">
            <div class="row border g-0 rounded shadow-sm">
                <div class="col p-4">
                    <div class="icon-and-title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                        <h2>Cliente</h2>
                    </div>
                    <form action="newClient.php" method="POST" onsubmit="return validateForm()">
                        <div class="row">
                            <div class="col-md-6 mt-4 mb-3">
                                <label for="nameClient" class="form-label">Nome: *</label>
                                <input type="text" name="nameClient" class="form-control" id="nameClient" aria-describedby="nameClient" placeholder="Nome completo" required>
                            </div>
                            <div class="col-md-6 mt-4 mb-3">
                                <label for="emailClient" class="form-label">E-mail: *</label>
                                <input type="email" name="emailClient" class="form-control" id="emailClient" aria-describedby="emailHelp" placeholder="Seu e-mail" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mt-4 mb-3">
                                <label for="cpfClient" class="form-label">CPF: *</label>
                                <input type="text" name="cpfClient" class="form-control" id="cpfClient" aria-describedby="cpf" placeholder="CPF" required>
                            </div>
                            <div class="col-md-6 mt-4 mb-3">
                                <label for="rgClient" class="form-label">RG: *</label>
                                <input type="text" name="rgClient" class="form-control" id="rgClient" aria-describedby="rg" placeholder="RG" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mt-4 mb-3">
                                <label for="telephoneClient" class="form-label">Telefone: *</label>
                                <input type="text" name="telephoneClient" class="form-control" id="telephoneClient" aria-describedby="telephone" placeholder="Telefone Principal" required>
                            </div>
                            <div class="col-md-4 mt-4 mb-3">
                                <label for="optionalTelephone" class="form-label">Telefone 2: </label>
                                <input type="text" class="form-control" name="optionalTelephone" id="optionalTelephone" aria-describedby="optionalTelephone" placeholder="Telefone Adcional">
                            </div>
                            <div class="col-md-4 mt-4 mb-3">
                                <label for="dateOfBirth" class="form-label">Data de Nascimento: *</label>
                                <input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth" aria-describedby="date" placeholder="Data de Nascimento" required>
                            </div>
                        </div>

                        <?php if (!empty($msgError)) : ?>
                            <div class="error-message">
                                <p class="text-danger"><?php echo $msgError; ?></p>
                            </div>
                        <?php endif; ?>

                        <input type="submit" name="submitClient" value="Salvar Alterações" />

                    </form>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT FOR BOOTSTRAP AND MASK -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/inputmask@5/dist/jquery.inputmask.min.js"></script>
        <script src="js/address.js"></script>
        <script>
            $(document).ready(function() {

                // Máscara para CPF
                $('#cpfClient').inputmask('999.999.999-99');

                // Máscara para RG
                $('#rgClient').inputmask('99.999.999-9');

                // Máscara para Telefone Principal
                $('#telephoneClient').inputmask('(99) 9999-9999');

                // Máscara para Telefone Adicional
                $('#optionalTelephone').inputmask('(99) 9999-9999');
            });
        </script>
</body>

</html>