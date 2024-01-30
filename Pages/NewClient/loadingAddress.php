<?php

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

var_dump($dados);

if(!empty($dados['submitAddress'])) {
    foreach($dados['cep'] as $chave => $valor) {
        echo "<br>";
        echo "<br>";
        echo "Chave: $chave <br>";
        echo "CEP: $valor <br>";
        echo "Rua: " . $dados['rua'][$chave] . "<br>";
        echo "<hr>";
    }
    
} else {
    echo "erro";
}