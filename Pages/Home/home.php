<?php
session_start();
require_once "../../config.php";

function logout()
{
    session_unset();
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../../index.php");
    exit;
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    $user_id = $_SESSION['user_id'];
}

$sql = "SELECT id_client, name_client, cpf, rg, status, email_client, telephone1, date_birth FROM clients WHERE id_user =? AND status = 1 ORDER BY id_client ASC";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
    } else {
        // Tratar erro na execução da consulta
    }

    $stmt->close();
}

// Verificando se o parâmetro user_type foi fornecido na URL
if (isset($_GET['user_type']) && $_GET['user_type'] == 1) {
    $user_type = 1;
} else {
    $user_type = 0;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-link {
            margin-right: auto;
        }

        .buttons-container {
            display: flex;
            align-items: center;
        }

        .logout-link {
            background-color: #dc2626;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            padding: 10px 40px;
            display: inline-block;
        }

        .logout-link:hover {
            background-color: #dc2626;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            padding: 10px 40px;
            display: inline-block;
            background-color: #ef4444;
        }

        .btn {
            margin-left: 10px;
        }

        .table-bg {
            border-radius: 15px 15px 0 0;
        }

        .btn-home-adm {
            background-color: #dc2626;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            padding: 10px 40px;
            display: inline-block;
        }

        .btn-home-adm:hover {
            background-color: #ef4444;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            padding: 10px 40px;
            display: inline-block;
        }

        .btn-client {
            background-color: #dc2626;
            padding: 12px;
        }

        .btn-logout {
            padding: 16px 8px;
        }

    </style>

</head>

<body>
    <header>
        <div class="header-container">
            <a class="logo-link">
                <img src="../../Images/logo_kabum.svg" alt="Logo" width="140" height="auto">
            </a>

            <div class="buttons-container">

                <?php if ($user_type == 1) : ?>
                    <a class=' btn-home-adm ' href='../Admin/adminDashboard.php'>Voltar pro Adm</a>
                <?php else : ?>
                    <form method="post" action="../Clients/newClient.php?user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                        <input class="btn-client mr-4" type="submit" name="client" value="Cadastrar Cliente">
                    </form>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <a href="../../index.php?" class="logout-link">Sair</a>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="m-5">

        <div class="m-5">
            <div class="d-flex justify-content-end">
                <a class="btn btn-outline-danger mb-4" href="../Home/ClientsDisables/clientsDisables.php?user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">Clientes Desativados</a>
            </div>

            <?php if (mysqli_num_rows($result) > 0) { ?>
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
                        <?php while ($user_data = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $user_data['id_client']; ?></td>
                                <td><?php echo $user_data['name_client']; ?></td>
                                <td><?php echo $user_data['cpf']; ?></td>
                                <td><?php echo $user_data['rg']; ?></td>
                                <td><?php echo $user_data['email_client']; ?></td>
                                <td><?php echo $user_data['telephone1']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($user_data['date_birth'])); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-warning" href="../Address/newAddress.php?id_client=<?php echo $user_data['id_client']; ?>&user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                                        Endereços
                                    </a>
                                    <a class="btn btn-sm btn-primary" href="../Clients/updateClient/editClient.php?id_client=<?php echo $user_data['id_client']; ?>&user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                        </svg>
                                    </a>
                                    <a class="btn btn-sm btn-danger" href="../Clients/updateClient/disableClient.php?id_client=<?php echo $user_data['id_client']; ?>&user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
                                            <path d="M15 8a6.97 6.97 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class="container-client-empty">
                    <p class="client-empty">Nenhum Cliente Cadastrado ou Habilitado</p>
                </div>
            <?php } ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>