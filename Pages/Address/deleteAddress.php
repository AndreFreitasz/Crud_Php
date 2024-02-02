<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEndereco = filter_input(INPUT_POST, 'id_address', FILTER_SANITIZE_NUMBER_INT);

    // Realizar a exclusão do endereço no banco de dados
    $sqlDelete = "DELETE FROM address WHERE id_address = $idEndereco";
    $conn->query($sqlDelete);

    // Responder para indicar que a exclusão foi bem-sucedida (ou tratar erros, se necessário)
    echo 'Endereço removido com sucesso';
}
