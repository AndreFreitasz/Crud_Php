<?php

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

include_once '../../config.php';

if (!empty($dados['submitAddress'])) {

        $client_id = $_GET['id_client'];
        echo $client_id;

    // Loop através dos conjuntos de dados
    foreach ($dados['cep'] as $chave => $cep) {
        echo "<br>";
        echo "<br>";
        echo "Chave: $chave <br>";
        echo "CEP: $cep <br>";
        echo "Rua: " . $dados['rua'][$chave] . "<br>";
        echo "Número: " . $dados['numero'][$chave] . "<br>";
        echo "Bairro: " . $dados['bairro'][$chave] . "<br>";
        echo "Estado: " . $dados['estado'][$chave] . "<br>";
        echo "Cidade: " . $dados['cidade'][$chave] . "<br>";
        echo "ID: " . $dados['id_client'][$chave] . "<br>";
        echo "<hr>";

        // Preparar e executar a consulta SQL para cada conjunto de dados
        $sqlAddress = "INSERT INTO address (id_client, cep, street, number, neighborhood, state, city) 
        VALUES ('{$dados['id_client'][$chave]}', '$cep', '{$dados['rua'][$chave]}', '{$dados['numero'][$chave]}', '{$dados['bairro'][$chave]}', '{$dados['estado'][$chave]}', '{$dados['cidade'][$chave]}')";

        $result = $conn->query($sqlAddress);

    }

    header('Location: ./newAddress.php');
} else {
    echo "erro";
}
