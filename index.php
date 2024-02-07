<?php
session_start();

require_once "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consultar o status do usuário
    $sql_status = "SELECT status_user FROM users WHERE email = ?";
    $stmt_status = $conn->prepare($sql_status);
    $stmt_status->bind_param("s", $email);
    $stmt_status->execute();
    $result_status = $stmt_status->get_result();

    if ($result_status->num_rows === 1) {
        $row_status = $result_status->fetch_assoc();
        if ($row_status['status_user'] == 1) {
            $error = "Este usuário foi desativado. Por favor, entre em contato com o administrador.";
        } else {

            // Consultar as credenciais do usuário
            $sql = "SELECT id_user, password, userType FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["user_id"] = $row['id_user'];

                    if ($row['userType']) {
                        header("Location: ./Pages/Admin/adminDashboard.php");
                    } else{
                        header("Location: ./Pages/Home/home.php");
                    } 
                    exit;
                }
            }

            $error = "E-mail ou senha incorretos.";
        }
    } else {
        $error = "E-mail não encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Login</h1>

    <form method="post" action="index.php">
        E-mail: <input type="email" name="email" required><br>

        Senha: <input type="password" name="password" required><br>

        <?php
        if (isset($error)) {
            echo '<p style="color: red; font-size: 14px">' . $error . '</p>';
        }
        ?>

        <input type="submit" value="Logar">
    </form>
    <br>
    <a href="Pages/Registers/register.php">Ainda não tem um cadastro? Clique aqui!</a>
</body>

</html>