<?php
session_start();

$msgError = '';

if (isset($_SESSION['user_id']) && !empty($_GET['id_client'])) {
    include_once '../../../config.php';

    $clientId = $_GET['id_client'];
    $_SESSION['edit_user_id'] = $userId;
    $sqlSelect = "SELECT * FROM clients WHERE id_client=$clientId";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {

        while ($user_data = mysqli_fetch_assoc($result)) {
            $nameClient = $user_data['name_client'];
            $emailClient = $user_data['email_client'];
            $cpfClient = $user_data['cpf'];
            $rgClient = $user_data['rg'];
            $telephoneClient = $user_data['telephone1'];
            $optionalTelephone = $user_data['telephone2'];
            $dateOfBirth = $user_data['date_birth'];
        }
    } else {
        header('Location: ../../index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../../Home/home.css">
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

        input[name="updateClient"] {
            background-color: #ff7b00;
            display: flex;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <form method="post" action="../../Home/home.php">
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
                    <form action="./saveEditClient.php" method="POST"">

                        <div class=" row">
                        <div class="col-md-6 mt-4 mb-3">
                            <label for="nameClient" class="form-label">Nome: *</label>
                            <input type="text" name="nameClient" class="form-control" id="nameClient" value="<?php echo $nameClient ?>" aria-describedby="nameClient" placeholder="Nome completo" required>
                        </div>
                        <div class="col-md-6 mt-4 mb-3">
                            <label for="emailClient" class="form-label">E-mail: *</label>
                            <input type="email" name="emailClient" class="form-control" id="emailClient" value="<?php echo $emailClient ?>" aria-describedby="emailHelp" placeholder="Seu e-mail" required>
                        </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-4 mb-3">
                        <label for="cpfClient" class="form-label">CPF: *</label>
                        <input type="text" name="cpfClient" class="form-control" id="cpfClient" value="<?php echo $cpfClient ?>" aria-describedby="cpf" placeholder="CPF" required>
                    </div>
                    <div class="col-md-6 mt-4 mb-3">
                        <label for="rgClient" class="form-label">RG: *</label>
                        <input type="text" name="rgClient" class="form-control" id="rgClient" value="<?php echo $rgClient ?>" aria-describedby="rg" placeholder="RG" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mt-4 mb-3">
                        <label for="telephoneClient" class="form-label">Telefone: *</label>
                        <input type="text" name="telephoneClient" class="form-control" id="telephoneClient" value="<?php echo $telephoneClient ?>" aria-describedby="telephone" placeholder="Telefone Principal" required>
                    </div>
                    <div class="col-md-4 mt-4 mb-3">
                        <label for="optionalTelephone" class="form-label">Telefone 2: </label>
                        <input type="text" class="form-control" name="optionalTelephone" id="optionalTelephone" value="<?php echo $optionalTelephone ?>" aria-describedby="optionalTelephone" placeholder="Telefone Adcional">
                    </div>
                    <div class="col-md-4 mt-4 mb-3">
                        <label for="dateOfBirth" class="form-label">Data de Nascimento: *</label>
                        <input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth" value="<?php echo !empty($dateOfBirth) ? date('Y-m-d', strtotime($dateOfBirth)) : ''; ?>" aria-describedby="date" placeholder="Data de Nascimento" required>
                    </div>
                </div>

                <?php if (isset($_SESSION['msgError']) && !empty($_SESSION['msgError'])) : ?>
                    <div class="error-message">
                        <p class="text-danger"><?php echo $_SESSION['msgError']; ?></p>
                    </div>
                <?php
                    // Limpe a variável de sessão após exibir a mensagem
                    unset($_SESSION['msgError']);
                endif;
                ?>

                <input type=" hidden" name="id_client" value="<?php echo $clientId; ?>">

                <input type="submit" name="updateClient" value="Salvar Alterações" />

                </form>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FOR BOOTSTRAP AND MASK -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5/dist/jquery.inputmask.min.js"></script>
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