<?php
session_start();
require_once '../../../config.php';

$sql = "SELECT id_user, email FROM users WHERE userType = 0 AND status_user = 1 ORDER BY id_user ASC";
$result = $conn->query($sql);

function logout()
{
    session_unset();
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

if (!$result) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

// Feche a conexão com o banco de dados
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../../Home/home.css">
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
        }

        .btn-back:hover {
            background-color: #ef4444;
        }
    </style>

</head>

<body>

    <header>
        <div class="header-container">
            <a href="../adminDashboard.php" class="logo-link">
                <img src="../../../Images/logo_kabum.svg" alt="Logo" width="140" height="auto">
            </a>
            <form method="post" action="../adminDashboard.php">
                <div class="logo">
                    <input type="submit" class="btn-back" value="Voltar para home">
                </div>
            </form>
        </div>
    </header>

    <div class="m-5">

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <h1 class="TitleClientsDisabled">Usuários Desativados</h1>
            <table class="table table-striped table-bg text-center">
                <thead class="table text-center">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($user_data = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='p-3 fs-7'>" . $user_data['id_user'] . "</td>";
                        echo "<td class='p-3 fs-7'>" . $user_data['email'] . "</td>";
                        echo "<td>";
                        echo "<a class='btn btn-sm btn-success' href='./enableUser.php?id_user=" . $user_data['id_user'] . "'> Ativar </a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="container-client-empty">
                <p class="client-empty">Nenhum Usuário Desativado</p>
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>