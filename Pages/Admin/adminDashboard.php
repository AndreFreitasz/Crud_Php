<?php
session_start();
require_once "../../config.php";

//Listar registros na tabela
$sql = "SELECT id_user, email FROM users WHERE userType = 0 AND status_user = 0 ORDER BY id_user ASC";
$result = $conn->query($sql);

function logout()
{
    session_unset();
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

if (isset($_GET["logout"]) && $_GET["logout"] === "true") {
    logout();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["id_user"]) && isset($_POST["action"]) && $_POST["action"] === "desativar") {
        //Desativar Usuário
        $idUser = $_POST["id_user"];

        $sql = "UPDATE users SET status_user = 1 WHERE id_user = " . $idUser;
        if ($conn->query($sql) === TRUE) {
            // Sucesso ao desativar o usuário
        } else {
            echo "Erro ao desativar o usuário: " . $conn->error;
        }
    } elseif (isset($_POST["idUser"]) && isset($_POST["checked"])) {
        //Tornar usuário administrador
        $idUser = $_POST["idUser"];
        $checked = $_POST["checked"] === "true" ? 1 : 0;

        $sql = "UPDATE users SET userType = " . $checked . " WHERE id_user = " . $idUser;

        if ($conn->query($sql) === TRUE) {
            echo "Sucesso";
        } else {
            echo "Erro ao atualizar o tipo de usuário: " . $conn->error;
        }
    } elseif (isset($_POST["id_user"]) && isset($_POST["action"]) && $_POST["action"] === "excluir") {
        $idUser = $_POST["id_user"];

        $sql = "DELETE FROM address WHERE id_client IN (SELECT id_client FROM clients WHERE id_user = $idUser)";
        if ($conn->query($sql) === TRUE) {
            $sql = "DELETE FROM clients WHERE id_user = $idUser";
            if ($conn->query($sql) === TRUE) {
                $sql = "DELETE FROM users WHERE id_user = $idUser";
                if ($conn->query($sql) === TRUE) {
                    // Sucesso ao desativar o usuário
                } else {
                    echo "Erro ao excluir o usuário da tabela users: " . $conn->error;
                }
            } else {
                echo "Erro ao excluir o usuário da tabela clients: " . $conn->error;
            }
        } else {
            echo "Erro ao excluir o usuário da tabela address: " . $conn->error;
        }
    } elseif (isset($_POST["novaSenha"]) && isset($_POST["action"]) && $_POST["action"] === "alterarSenha") {
        $novaSenha = $_POST["novaSenha"];
        $idUser = $_POST["id_user"];
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET password = '$senhaHash' WHERE id_user = $idUser";
        if ($conn->query($sql) === TRUE) {
            echo "Senha atualizada com sucesso";
        } else {
            echo "Erro ao atualizar a senha: " . $conn->error;
        }
        exit;
    }
}
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

        .color-check-input:checked:focus {
            background-color: #ff6500;
            border-color: #ff6500;
        }

        .logout-link {
            background-color: #dc2626;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
        }

        .logout-link:hover {
            background-color: #ef4444;
        }
    </style>
</head>

<body>

    <!-- Modal -->
    <div class="modal fade" id="modalAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-action-users" action="adminDashboard.php" method="post">
                    <div class="modal-body d-grid gap-2">
                        <button type="button" class="btn btn-outline-warning custom-btn-orange p-3 m-3 exibirClientesEnderecosBtn" >Exibir Clientes/Endereços</button>
                        <button type="button" class="btn btn-outline-primary p-3 m-3" data-bs-toggle="modal" data-bs-target="#modalAlterarSenha">Alterar Senha</button>
                        <button type="submit" class="btn btn-outline-warning p-3 m-3">Desativar Usuário</button>
                        <button type="button" class="btn btn-outline-danger p-3 m-3" id="confirmarExclusaoBtnModal" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal">Excluir Usuário</button>
                        <input type="hidden" id="id_user_hidden" name="id_user">
                        <input type="hidden" name="action" value="desativar">
                    </div>
                </form>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input color-check-input" type="checkbox" value="" id="check-admin">
                        <label class="form-check-label font-check-label ms-2" for="check-admin">
                            Tornar esse usuário administrador
                        </label>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmar exclusão de usuário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja excluir este usuário?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarExclusaoBtn" data-action="excluir" data-id-user="<?php echo $user_data['id_user']; ?>">Excluir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Alteração de Senha -->
    <div class="modal fade" id="modalAlterarSenha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-alterar-senha" action="adminDashboard.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="novaSenha" class="form-label">Nova Senha</label>
                            <input type="password" class="form-control" id="novaSenha" name="novaSenha" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <header>
        <div class="header-container">
            <a href="../../index.php?logout=true" class="logout-link">Sair</a>
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
                    echo "<tr data-id='" . $user_data['id_user'] . "'>";
                    echo "<td class='p-3 fs-7'>" . $user_data['id_user'] . "</td>";
                    echo "<td class='p-3 fs-7'>" . $user_data['email'] . "</td>";
                    echo "<td class='p-3 fs-7'>";
                    echo "<button type='button' class='btn btn-primary custom-btn alterar-usuario-btn' data-bs-toggle='modal' data-bs-target='#modalAdmin' data-id-user='" . $user_data['id_user'] . "' onclick='setUserId(" . $user_data['id_user'] . ")'>Alterar Usuário</button>";
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
    <script src="./jsAdmin/actionsUsers.js"></script>
</body>

</html>