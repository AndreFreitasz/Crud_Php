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

$sql = "SELECT id_user, email FROM users WHERE userType = 0 ORDER BY id_user ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Home/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
    <style>
        .custom-btn {
            background-color: #ff6500;
            border-color: #ff6500;
        }

        .custom-btn:hover {
            background-color: #e65600;
            border-color: #e65600;
        }

        .custom-btn-orange {
            background-color: #fff;
            color: #ff6500;
            border-color: #ff6500;
        }

        .custom-btn-orange:hover {
            background-color: #e65600;
            border-color: #e65600;
        }

        .font-check-label {
            font-size: 14px;
        }

        .color-check-input:checked {
            background-color: #ff6500;
            border-color: #ff6500;
        }

        /* Estilo para o input check quando estiver marcado e focado */
        .color-check-input:checked:focus {
            background-color: #ff6500;
            border-color: #ff6500;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="modalAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Título do Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-grid gap-2">
                    <button type="button" class="btn btn-outline-warning custom-btn-orange p-3 m-3" data-bs-dismiss="modal">Exibir Clientes/Endereços</button>
                    <button type="button" class="btn btn-outline-primary p-3 m-3" data-bs-dismiss="modal">Alterar senha</button>
                    <button type="button" class="btn btn-outline-warning p-3 m-3" data-bs-dismiss="modal">Desativar Usuário</button>
                    <button type="button" class="btn btn-outline-danger p-3 m-3" data-bs-dismiss="modal">Excluir Usuário</button>
                    <input type"hidden" id="id_user_hidden" name="id_user">
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input color-check-input" type="checkbox" value="" id="checkExample">
                        <label class="form-check-label font-check-label ms-2" for="checkExample">
                            Tornar esse usuário administrador
                        </label>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <header>
        <div class="header-container">
            <form method="post" action="./Disables/usersDisable.php">
                <div class="logo">
                    <input type="submit" name="client" value="Cadastrar Cliente">
                </div>
            </form>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="submit" name="logout" value="Sair">

                <?php
                if (isset($_POST["logout"])) {
                    logout();
                }
                ?>
        </div>
    </header>


    <div class="m-5">
        <div class="d-flex justify-content-end">
            <a class="btn btn-outline-danger mb-4" href="./Disables/usersDisable.php">Usuários Desativados</a>
        </div>

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
                    echo "<td class='p-3 fs-7'>";
                    // Botão para abrir o modal com id_user como atributo de dados
                    echo "<button type='button' class='btn btn-primary custom-btn alterar-usuario-btn' data-bs-toggle='modal' data-bs-target='#modalAdmin' data-id-user='" . $user_data['id_user'] . "'>Alterar Usuário</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>