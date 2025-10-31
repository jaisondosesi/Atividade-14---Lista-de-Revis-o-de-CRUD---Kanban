<?php
session_start();
include '../db/conexao.php';

if (isset($_POST['id_tarefa']) && isset($_POST['novo_status'])) {
    
    $id_tarefa = $conexao->real_escape_string($_POST['id_tarefa']);
    $novo_status = $conexao->real_escape_string($_POST['novo_status']);
    $status_permitidos = ['a fazer', 'fazendo', 'pronto'];

    if (in_array($novo_status, $status_permitidos)) {
        
        $sql = "UPDATE tarefas SET status = '$novo_status' WHERE id_tarefa = $id_tarefa";

        if ($conexao->query($sql) === TRUE) {
            $_SESSION['mensagem'] = "Status atualizado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro: " . $conexao->error;
        }
    } else {
        $_SESSION['mensagem'] = "Status inválido.";
    }
} else {
    $_SESSION['mensagem'] = "Dados insuficientes.";
}

$conexao->close();
header('Location: index.php');
exit;
?>