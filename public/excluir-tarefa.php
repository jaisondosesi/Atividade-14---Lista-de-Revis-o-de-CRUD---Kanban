<?php
session_start();
include '../db/conexao.php';

if (isset($_GET['id'])) {
    
    $id_tarefa = $conexao->real_escape_string($_GET['id']);
    $sql = "DELETE FROM tarefas WHERE id_tarefa = $id_tarefa";

    if ($conexao->query($sql) === TRUE) {
        $_SESSION['mensagem'] = "Tarefa excluída com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir: " . $conexao->error;
    }
} else {
    $_SESSION['mensagem'] = "ID da tarefa não fornecido.";
}

$conexao->close();
header('Location: index.php');
exit;
?>