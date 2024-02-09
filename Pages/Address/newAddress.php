<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../config.php';

//Recuperando o ID do cliente da URL
if (isset($_GET['id_client'])) {
    $client_id = $_GET['id_client'];
}

//resgatando o user_id da url e salvando em uma variável
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
} else {
    $user_id = $_SESSION['user_id'];
}

// Verificando se o parâmetro user_type foi fornecido na URL
if (isset($_GET['user_type']) && $_GET['user_type'] == 1) {
    $user_type = 1;
} else {
    $user_type = 0;
}

$enderecosRemovidos = array();

$sqlCheckAddress = "SELECT * FROM address WHERE id_client = $client_id";
$resultCheckAddress = $conn->query($sqlCheckAddress);

// Inicializando arrays para guardar os valores dos endereços
$ceps = $ruas = $numeros = $bairros = $estados = $cidades = $ids = array();

if ($resultCheckAddress->num_rows > 0) {
    while ($row = $resultCheckAddress->fetch_assoc()) {
        $ceps[] = $row['cep'];
        $ruas[] = $row['street'];
        $numeros[] = $row['number'];
        $bairros[] = $row['neighborhood'];
        $estados[] = $row['state'];
        $cidades[] = $row['city'];
        $ids[] = $row['id_address'];
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../Home/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .icon-and-title {
            display: flex;
            align-items: center;
        }

        h2 {
            margin-left: 8px;
            align-items: center;
            justify-content: center;
        }

        .tab-content {
            border-bottom: 1px solid #ff7b00;
            padding: 20px;
        }

        input[name="submitClient"] {
            background-color: #ff7b00;
            display: flex;
            margin-top: 16px;
        }

        input[name="submitAddress"] {
            background-color: #ff6500;
            display: flex;
            margin: 32px 20px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <a class="logo-link">
                <img src="../../Images/logo_kabum.svg" alt="Logo" width="140" height="auto">
            </a>
            <form method="post" action="../Home/home.php?user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                <div class="logo">
                    <input type="submit" name="btn-back" value="Voltar para home">
                </div>
            </form>
        </div>
    </header>

    <div class="container mt-2">
        <div class="tab-content">

            <div class="tab-pane active" id="address">
                <div class="row border g-0 rounded shadow-sm">
                    <div class="col p-4">
                        <div class="row">
                            <div class="col-md-9 mt-4 mb-3">
                                <div class="icon-and-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-signpost" viewBox="0 0 16 16">
                                        <path d="M7 1.414V4H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h5v6h2v-6h3.532a1 1 0 0 0 .768-.36l1.933-2.32a.5.5 0 0 0 0-.64L13.3 4.36a1 1 0 0 0-.768-.36H9V1.414a1 1 0 0 0-2 0M12.532 5l1.666 2-1.666 2H2V5z" />
                                    </svg>
                                    <h2>Endereços</h2>
                                </div>
                            </div>
                            <div class="col-md-3 mt-4 mb-3">
                                <button type="button" onclick="adicionarCampo()" class="addAddress btn btn-outline-warning"> Adicionar endereço</button>
                            </div>
                        </div>

                        <form method="POST" action="./loadingAddress.php?user_id=<?php echo $user_id; ?>&user_type=<?php echo $user_type; ?>">
                            <div id="enderecos">
                                <input type="hidden" name="id_client[]" value="<?php echo $client_id; ?>">

                                <!-- Loop para exibir os grupos dos campos para cada endereço -->
                                <?php for ($i = 0; $i < count($ceps); $i++) { ?>
                                    <div class="form-group" style="<?php echo in_array($ids[$i], $enderecosRemovidos) ? 'display: none;' : ''; ?>">

                                        <div class="row">
                                            <div class="col-md-6 mt-4 mb-3">
                                                <label class="form-label" for="cep">CEP: </label>
                                                <input type="text" class="form-control" name="cep[]" id="cep_<?php echo $ids[$i]; ?>" placeholder="CEP" aria-describedby="cep" value="<?php echo $ceps[$i]; ?>" />
                                            </div>
                                            <div class="col-md-6 mt-4 mb-3">
                                                <label>Rua: </label>
                                                <input type="text" class="form-control" aria-describedby="rua" name="rua[]" id="rua_<?php echo $ids[$i]; ?>" value="<?php echo $ruas[$i]; ?>" placeholder="Rua" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-4 mb-3">
                                                <label>Número: </label>
                                                <input type="number" class="form-control" aria-describedby="numero" name="numero[]" id="numero_<?php echo $ids[$i]; ?>" value="<?php echo $numeros[$i]; ?>" placeholder="Número" />
                                            </div>
                                            <div class="col-md-6 mt-4 mb-3">
                                                <label>Bairro: </label>
                                                <input type="text" class="form-control" aria-describedby="bairro" name="bairro[]" id="bairro_<?php echo $ids[$i]; ?>" value="<?php echo $bairros[$i]; ?>" placeholder="Bairro" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mt-4 mb-3">
                                                <label>Estado: </label>
                                                <input type="text" class="form-control" aria-describedby="estado" name="estado[]" id="estado_<?php echo $ids[$i]; ?>" value="<?php echo $estados[$i]; ?>" placeholder="Estado" />
                                            </div>
                                            <div class="col-md-6 mt-4 mb-3">
                                                <label>Cidade: </label>
                                                <input type="text" class="form-control" aria-describedby="cidade" name="cidade[]" id="cidade_<?php echo $ids[$i]; ?>" value="<?php echo $cidades[$i]; ?>" placeholder="Cidade" />
                                            </div>
                                        </div>

                                        <!-- Adicione esta linha para incluir o ID do endereço -->
                                        <input type="hidden" name="id_address[]" value="<?php echo $ids[$i]; ?>" class="removido">
                                        <button type="button" data-id="<?php echo $ids[$i]; ?>" onclick="removerCampo(this)" class="removerAddress btn btn-outline-danger">
                                            Remover endereço
                                        </button>
                                    </div>
                                <?php } ?>

                            </div>
                            <div id="novosEnderecos"></div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submitAddress" value="Salvar Alterações" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT FOR BOOTSTRAP AND MASK -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5/dist/jquery.inputmask.min.js"></script>
    <script src="js/address.js"></script>
    <script>
        // Armazenando o valor de id_client em uma variável JavaScript para possível uso em 'address.js'
        var clientId = <?php echo json_encode($client_id); ?>;
    </script>
</body>

</html>