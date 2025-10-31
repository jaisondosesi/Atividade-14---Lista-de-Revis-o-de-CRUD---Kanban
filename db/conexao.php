<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "meu_projeto_tarefas";

$conexao = new mysqli($servidor, $usuario, $senha, $banco);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");

?>