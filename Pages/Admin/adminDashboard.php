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
</style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="modalAdmin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Título do Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo do modal -->
                    <p>Aqui você pode adicionar o conteúdo do modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <!-- Adicione qualquer botão adicional conforme necessário -->
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
                    // Botão para abrir o modal
                    echo "<button type='button' class='btn btn-primary custom-btn' data-bs-toggle='modal' data-bs-target='#modalAdmin'>Alterar Usuário</button>";
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