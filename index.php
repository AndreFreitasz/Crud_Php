<?php
    session_start();

    require_once "./config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
    }

    $sql = "SELECT id_user, password FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION["loggedin"] = true;

            $_SESSION["user_id"] = $row['id_user'];

            header("Location: ./Pages/Home/home.php");
            exit;
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
            echo '<p>' . $error . '</p>';
        }
        ?>

        <input type="submit" value="Logar">
    </form>
    <br>
    <a href="Pages/Registers/register.php">Ainda não tem um cadastro? Clique aqui!</a>
</body>

</html>