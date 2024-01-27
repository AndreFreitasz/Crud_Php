<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../../style.css">
</head>

<body>
    <h1>Cadastro</h1>
    <form method="post" action="./registerConfirmed.php">
        E-mail: <input type="email" name="email" required /><br>

        Senha: <input type="password" name="password" required /><br>

        <input type="submit" />

        <?php
        // Exibir mensagem de erro, se houver
        if (isset($_GET['error'])) {
            echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>
    </form>
    <br>
    <a href="../../index.php">Já é cadastrado? Faça o seu login!</a>
</body>

</html>