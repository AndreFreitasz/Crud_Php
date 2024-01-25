<?php
session_start();

require_once "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
}

$sql = "SELECT * FROM users WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row - $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {
        $_SESSION["loggedin"] = true;

        header("Location: site.php");
        exit;
    }
} else {
    $error = "Usuário ou senha incorretos";
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

        <input type="submit" value="Logar">
    </form>
</body>

</html>