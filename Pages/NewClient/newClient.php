<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../Home/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .nav-tabs .nav-link.active {
            background-color: #ff7b00;
            color: #fff;
            border: 3px solid #ff7b00;
        }

        .nav-tabs .nav-link {
            background-color: #fff;
            border: 3px solid #ff7b00;
            color: #ff7b00;
            margin-right: 2rem;
            padding-left: 3rem;
            padding-right: 3rem;
        }

        .nav-tabs .nav-link:hover {
            border: 3px solid #ff7b00;
        }

        .nav-tabs {
            border-bottom: 1px solid #ff7b00;
        }

        .tab-content {
            border-bottom: 1px solid #ff7b00;
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <div class="header-container">
            <form method="post" action="../Home/home.php">
                <div class="logo">
                    <input type="submit" name="back" value="Voltar para home">
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

    <div class="container mt-2">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#client">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                    Cliente
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#address">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-signpost" viewBox="0 0 16 16">
                        <path d="M7 1.414V4H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h5v6h2v-6h3.532a1 1 0 0 0 .768-.36l1.933-2.32a.5.5 0 0 0 0-.64L13.3 4.36a1 1 0 0 0-.768-.36H9V1.414a1 1 0 0 0-2 0M12.532 5l1.666 2-1.666 2H2V5z" />
                    </svg>
                    Endereços
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="client">
                <div class="row border g-0 rounded shadow-sm">
                    <div class="col p-4">
                        <h3>Cliente</h3>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mt-4 mb-3">
                                    <label for="nameClient" class="form-label">Nome: *</label>
                                    <input type="text" class="form-control" id="nameClient" aria-describedby="nameClient" placeholder="Nome completo" required>
                                </div>
                                <div class="col-md-6 mt-4 mb-3">
                                    <label for="emailClient" class="form-label">E-mail: *</label>
                                    <input type="email" class="form-control" id="emailClient" aria-describedby="emailHelp" placeholder="Seu e-mail" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mt-4 mb-3">
                                    <label for="cpfClient" class="form-label">CPF: *</label>
                                    <input type="text" class="form-control" id="cpfClient" aria-describedby="cpf" placeholder="CPF" required>
                                </div>
                                <div class="col-md-6 mt-4 mb-3">
                                    <label for="rgClient" class="form-label">RG: *</label>
                                    <input type="text" class="form-control" id="rgClient" aria-describedby="rg" placeholder="RG" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mt-4 mb-3">
                                    <label for="telephoneClient" class="form-label">Telefone: *</label>
                                    <input type="text" class="form-control" id="telephoneClient" aria-describedby="telephone" placeholder="Telefone Principal" required>
                                </div>
                                <div class="col-md-4 mt-4 mb-3">
                                    <label for="optionalTelephone" class="form-label">Telefone 2: </label>
                                    <input type="text" class="form-control" id="optionalTelephone" aria-describedby="optionalTelephone" placeholder="Telefone Adcional" required>
                                </div>
                                <div class="col-md-4 mt-4 mb-3">
                                    <label for="dateOfBirth" class="form-label">Data de Nascimento: *</label>
                                    <input type="date" class="form-control" id="dateOfBirth" aria-describedby="date" placeholder="Data de Nascimento">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
            <div class="tab-pane" id="address">
                <div class="row border g-0 rounded shadow-sm">
                    <div class="col p-4">
                        <h3>Endereços</h3>
                        <p>fgvnjfdoughjdfioughdfiughdfiug</p>
                    </div>
                    <div class="col-auto">

                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT FOR BOOTSTRAP AND MASK -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/inputmask@5/dist/jquery.inputmask.min.js"></script>

        <script>
            $(document).ready(function() {

                // Máscara para CPF
                $('#cpfClient').inputmask('999.999.999-99');

                // Máscara para RG
                $('#rgClient').inputmask('99.999.999-9');

                // Máscara para Telefone Principal
                $('#telephoneClient').inputmask('(99) 9999-9999');

                // Máscara para Telefone Adicional
                $('#optionalTelephone').inputmask('(99) 9999-9999');
            });
        </script>
</body>

</html>