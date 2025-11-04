<?php
session_start();
include '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id_tarefa = (int) $_GET['id'];
    $usuario_logado_id = (int) $_SESSION['usuario_id'];
    $sql = "DELETE FROM tarefas WHERE id_tarefa = $id_tarefa AND id_usuario = $usuario_logado_id";

    if ($conexao->query($sql) === TRUE) {
        if ($conexao->affected_rows > 0) {
            $_SESSION['mensagem'] = "Tarefa excluída com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro: tarefa não encontrada ou sem permissão.";
        }
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