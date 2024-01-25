<?php
require_once "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    //Criptografar senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        $mensagem = "Usuário criado com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação do cadastro</title>
    <link rel="stylesheet" href="./registerConfirmed.css">
</head>

<body>
    <?php
    if (!empty($mensagem)) {
        echo '<h1>' . $mensagem . '</h1>';
    }
    ?>

    <div class="box">
        <p>Volte para a tela de login e entre com a sua conta.</p>

        <form action="../../index.php">
            <button>Volte para a tela de login</button>
        </form>
    </div>
</body>

</html>