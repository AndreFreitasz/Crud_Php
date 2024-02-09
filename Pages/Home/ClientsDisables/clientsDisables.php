<?php

require_once '../../../config.php';

$sql = "SELECT * FROM clients WHERE status = 0";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

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

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        .table-bg {
            border-radius: 15px 15px 0 0;
        }

        .TitleClientsDisabled {
            text-align: center;
            margin-bottom: 64px;
        }

        .btn-back {
            background-color: #dc2626;
            border-radius: 5px;
        }

        .btn-back:hover {
            background-color: #ef4444;
        }
    </style>

</head>

<body>

    <header>
        <div class="header-container">
            <a class="logo-link">
                <img src="../../../Images/logo_kabum.svg" alt="Logo" width="140" height="auto">
            </a>
            <form method="post" action="../home.php?user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                <input type="submit" class="btn-back" value="Voltar para home">
            </form>
        </div>
    </header>

    <div class="m-5">

        <h1 class="TitleClientsDisabled">Clientes Desativados</h1>

        <table class="table table-striped table-bg text-center">
            <thead class="table text-center">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">RG</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefone 1</th>
                    <th scope="col">Data de Nascimento</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($user_data = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $user_data['id_client'] . "</td>";
                    echo "<td>" . $user_data['name_client'] . "</td>";
                    echo "<td>" . $user_data['cpf'] . "</td>";
                    echo "<td>" . $user_data['rg'] . "</td>";
                    echo "<td>" . $user_data['email_client'] . "</td>";
                    echo "<td>" . $user_data['telephone1'] . "</td>";
                    echo "<td>" . $user_data['date_birth'] . "</td>";
                    echo "<td>";

                    echo "<a class='btn btn-sm btn-success' href='../../Clients/updateClient/enableClient.php?id_client=$user_data[id_client]&user_id=$user_id&user_type=$user_type'>
                            Ativar
                        </a>";

                    "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>