<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEndereco = filter_input(INPUT_POST, 'id_address', FILTER_SANITIZE_NUMBER_INT);

    // Verificar se o ID do endereço é um valor válido
    if ($idEndereco !== null && is_numeric($idEndereco)) {
        // Realizar a exclusão do endereço no banco de dados
        $sqlDelete = "DELETE FROM address WHERE id_address = $idEndereco";
        if ($conn->query($sqlDelete)) {
            $enderecosRemovidos[] = $idEndereco;
            var_dump('Endereço removido com sucesso');
        } else {
            var_dump('Erro ao remover o endereço no banco de dados.');
        }
    } else {
        var_dump('ID do endereço inválido');
    }
} else {
    echo 'Erro ao dar o post';
}
