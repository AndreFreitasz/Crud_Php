<?php
var_dump("estou fora");
error_reporting(E_ALL);
ini_set('display_errors', 1);

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump("estou fora");
include_once '../../config.php';

if (!empty($dados['submitAddress'])) {

    $client_id = null;
    var_dump("estou fora");
    // Verificar se o id_client está no array e se é um array
    if (isset($dados['id_client']) && is_array($dados['id_client'])) {

        $client_id = reset($dados['id_client']);
        echo "estou fora2";
        // Se o client_id estiver com valor, prosseguir com o código
        if ($client_id !== false) {
            echo "estou fora3";
            foreach ($dados['cep'] as $chave => $cep) {
                echo "estou fora4";
                // Utilizar o id_address, que é a chave primária da tabela, como referência única
                $id_address = $dados['id_address'][$chave];

                if ($id_address && !empty($id_address)) {
                    // Se o id_address existir e não for vazio, faça a atualização
                    $sqlUpdateAddress = "UPDATE address SET 
                                        cep = '$cep',
                                        street = '{$dados['rua'][$chave]}', 
                                        number = '{$dados['numero'][$chave]}', 
                                        neighborhood = '{$dados['bairro'][$chave]}', 
                                        state = '{$dados['estado'][$chave]}', 
                                        city = '{$dados['cidade'][$chave]}'
                                        WHERE id_address = $id_address";

                    $resultUpdate = $conn->query($sqlUpdateAddress);
                    echo "estou no update!";

                    if (!$resultUpdate) {
                        echo "Erro ao atualizar o endereço: " . $conn->error;
                    }
                } else {
                    // Se o id_address não existir ou for vazio, faça a inserção
                    $sqlInsertAddress = "INSERT INTO address (id_client, cep, street, number, neighborhood, state, city) 
                                        VALUES ('$client_id', '$cep', '{$dados['rua'][$chave]}', '{$dados['numero'][$chave]}', '{$dados['bairro'][$chave]}', '{$dados['estado'][$chave]}', '{$dados['cidade'][$chave]}')";

                    $resultInsert = $conn->query($sqlInsertAddress);
                    echo "estou no insert!";

                    if (!$resultInsert) {
                        echo "Erro ao inserir o endereço: " . $conn->error;
                    }
                }
                echo "estou fora5";
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
