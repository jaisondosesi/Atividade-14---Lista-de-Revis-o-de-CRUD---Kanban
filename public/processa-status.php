<?php
session_start();
include '../db/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['id_tarefa']) && isset($_POST['novo_status'])) {
    $id_tarefa = (int) $_POST['id_tarefa'];
    $novo_status = $conexao->real_escape_string($_POST['novo_status']);
    $status_permitidos = ['a fazer', 'fazendo', 'pronto'];
    
    if (in_array($novo_status, $status_permitidos)) {
        $usuario_logado_id = (int) $_SESSION['usuario_id'];
        $sql = "UPDATE tarefas SET status = '$novo_status' WHERE id_tarefa = $id_tarefa AND id_usuario = $usuario_logado_id";
        if ($conexao->query($sql) === TRUE) {
            if ($conexao->affected_rows > 0) {
                $_SESSION['mensagem'] = "Status atualizado com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro: tarefa não encontrada ou sem permissão.";
            }
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