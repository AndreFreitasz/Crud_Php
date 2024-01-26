<?php
require_once "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Criptografar senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar se o email já existe
    $check_email_sql = "SELECT * FROM users WHERE email = ?";
    $check_email_stmt = $conn->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_result = $check_email_stmt->get_result();

    if ($check_email_result->num_rows > 0) {
        $error = "Este email já está cadastrado. Por favor, escolha outro.";
    } else {
        // Inserir usuário se o email não existir
        $insert_sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ss", $email, $hashed_password);

        if ($insert_stmt->execute()) {
            $mensagem = "Usuário criado com sucesso";
        } else {
            $error = "Erro ao criar usuário: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $check_email_stmt->close();
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