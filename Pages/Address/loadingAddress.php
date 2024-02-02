<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

include_once '../../config.php';

if (!empty($dados['submitAddress'])) {

    $client_id = null;

    // Verificar se o id_client está no array e se é um array
    if (isset($dados['id_client']) && is_array($dados['id_client'])) {

        $client_id = reset($dados['id_client']);

        // Se o client_id estiver com valor, prosseguir com o código
        if ($client_id !== false) {

            foreach ($dados['cep'] as $chave => $cep) {
                // Utilizar o id_address, que é a chave primária da tabela, como referência única
                $id_address = $dados['id_address'][$chave];
            
                if ($id_address) {
                    // Se o id_address existir, faça a atualização
                    $sqlUpdateAddress = "UPDATE address SET 
                                        cep = '$cep',
                                        street = '{$dados['rua'][$chave]}', 
                                        number = '{$dados['numero'][$chave]}', 
                                        neighborhood = '{$dados['bairro'][$chave]}', 
                                        state = '{$dados['estado'][$chave]}', 
                                        city = '{$dados['cidade'][$chave]}'
                                        WHERE id_address = $id_address";
            
                    $resultUpdate = $conn->query($sqlUpdateAddress);
            
                    if (!$resultUpdate) {
                        echo "Erro ao atualizar o endereço: " . $conn->error;
                    }
                } else {
                    // Se o id_address não existir, faça a inserção
                    $sqlInsertAddress = "INSERT INTO address (id_client, cep, street, number, neighborhood, state, city) 
                                        VALUES ('$client_id', '$cep', '{$dados['rua'][$chave]}', '{$dados['numero'][$chave]}', '{$dados['bairro'][$chave]}', '{$dados['estado'][$chave]}', '{$dados['cidade'][$chave]}')";
            
                    $resultInsert = $conn->query($sqlInsertAddress);
            
                    if (!$resultInsert) {
                        echo "Erro ao inserir o endereço: " . $conn->error;
                    }
                }
            }

            header('Location: ../Home/home.php');
            exit; // Adicionado para evitar execução adicional após redirecionamento
        } else {
            echo "Erro: ID do cliente não é um array.";
        }
    } else {
        echo "Erro: ID do cliente não está definido no array.";
    }
} else {
    echo "Erro: submitAddress não foi enviado.";
}
