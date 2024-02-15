<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
include_once '../../config.php';

if (!empty($dados['submitAddress'])) {

    //Recuperando o user_id da URL
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

    $client_id = null;
    // Verificando se  id_client é um array
    if (isset($dados['id_client']) && is_array($dados['id_client'])) {
        $client_id = reset($dados['id_client']);
    
        if ($client_id !== false) {
            foreach ($dados['cep'] as $chave => $cep) {
                // Utilizando o id_address como referência única
                $id_address = $dados['id_address'][$chave];
    
                // Definindo $main_address dentro do loop
                $main_address = isset($dados['main_address'][$chave]) ? $dados['main_address'][$chave] : 0;
    
                if ($id_address && !empty($id_address)) {
                    // Se o id_address existir e não for vazio, faça a atualização
                    $sqlUpdateAddress = "UPDATE address SET 
                                        cep = '$cep',
                                        street = '{$dados['rua'][$chave]}', 
                                        number = '{$dados['numero'][$chave]}', 
                                        neighborhood = '{$dados['bairro'][$chave]}', 
                                        state = '{$dados['estado'][$chave]}', 
                                        city = '{$dados['cidade'][$chave]}',
                                        mainAddress = $main_address
                                        WHERE id_address = $id_address";
    
                    $resultUpdate = $conn->query($sqlUpdateAddress);
                    echo "estou no update!";
    
                    if (!$resultUpdate) {
                        echo "Erro ao atualizar o endereço: " . $conn->error;
                    }
                } else {
                    // Se o id_address não existir ou for vazio, faça a inserção
                    $sqlInsertAddress = "INSERT INTO address (id_client, cep, street, number, neighborhood, state, city, mainAddress) 
                                        VALUES ('$client_id', '$cep', '{$dados['rua'][$chave]}', '{$dados['numero'][$chave]}', '{$dados['bairro'][$chave]}', '{$dados['estado'][$chave]}', '{$dados['cidade'][$chave]}', $main_address)";
    
                    $resultInsert = $conn->query($sqlInsertAddress);
                    echo "estou no insert!";
    
                    if (!$resultInsert) {
                        echo "Erro ao inserir o endereço: " . $conn->error;
                    }
                }
            }
    
            header('Location: ../Home/home.php?user_id=' . $user_id . "&user_type=" . $user_type);
            exit;
        } else {
            echo "Erro: ID do cliente não é um array.";
        }
    } else {
        echo "Erro: ID do cliente não está definido no array.";
    }
} else {
    echo "Erro: formulário não foi enviado.";
}
