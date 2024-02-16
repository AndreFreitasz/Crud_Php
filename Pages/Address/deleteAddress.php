<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../config.php';

header('Content-Type: application/json'); // Definindo o tipo de conteúdo como JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEndereco = filter_input(INPUT_POST, 'id_address', FILTER_SANITIZE_NUMBER_INT);

    // Verificando se o ID é valido
    if ($idEndereco !== null && is_numeric($idEndereco)) {

        $sqlDelete = "DELETE FROM address WHERE id_address = $idEndereco";

        if ($conn->query($sqlDelete)) {
            echo json_encode(['success' => true]); //JSON indicando sucesso
        } else {
            echo json_encode(['error' => 'Erro ao remover o endereço no banco de dados.']); //JSON indicando erro
        }
    } else {
        echo json_encode(['error' => 'ID do endereço inválido']); 
    }
} else {
    echo json_encode(['error' => 'Erro ao dar o post']); 
}
?>