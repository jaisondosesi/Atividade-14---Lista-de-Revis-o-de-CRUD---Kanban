<?php
session_start();
include '../db/conexao.php';

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nome = $conexao->real_escape_string($_POST['nome']);
    $email = $conexao->real_escape_string($_POST['email']);

    if (empty($nome) || empty($email)) {
        $mensagem = "Erro: Todos os campos são obrigatórios.";
    
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Erro: Formato de e-mail inválido.";

    } else {
        $sql_check = "SELECT id FROM usuarios WHERE email = '$email'";
        $result_check = $conexao->query($sql_check);
        
        if ($result_check->num_rows > 0) {
            $mensagem = "Erro: Este e-mail já está cadastrado.";
        } else {
            $sql = "INSERT INTO usuarios (nome, email) VALUES ('$nome', '$email')";

            if ($conexao->query($sql) === TRUE) {
                $_SESSION['mensagem'] = "Cadastro concluído com sucesso!";
                
                
                header('Location: index.php');
                exit;
                
            } else {
                $mensagem = "Erro ao cadastrar: " . $conexao->error;
            }
        }
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../assets/style.css"> <style>
        .form-container {
            width: 50%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-container h1 {
            text-align: center;
        }
        .form-grupo {
            margin-bottom: 20px;
        }
        .form-grupo label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-grupo input {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #218838;
        }
        .mensagem-erro {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

    <header>
        <nav class="menu-principal">
            <ul>
                <li><a href="index.php">Gerenciar Tarefas</a></li>
                <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
                <li><a href="cadastro-tarefa.php">Cadastrar Tarefa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h1>Cadastrar Novo Usuário</h1>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-erro">
                    <?php echo $mensagem; ?>
                </div>
            <?php endif; ?>

            <form action="cadastro-usuario.php" method="POST">
                
                <div class="form-grupo">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>

                <div class="form-grupo">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <button type="submit">Cadastrar Usuário</button>
            </form>
        </div>
    </main>

</body>
</html>