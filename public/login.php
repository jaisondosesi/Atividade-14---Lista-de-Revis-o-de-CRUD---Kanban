<?php

session_start();
include '../db/conexao.php';

$mensagem = "";

if (isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $email = $conexao->real_escape_string($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $mensagem = "Erro: Informe e-mail e senha.";
    } else {
        $sql = "SELECT id, nome, senha FROM usuarios WHERE email = '$email' LIMIT 1";
        $result = $conexao->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $usuario = $result->fetch_assoc();
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['mensagem'] = 'Login realizado com sucesso!';
                header('Location: index.php');
                exit;
            } else {
                $mensagem = "Erro: Senha incorreta.";
            }
        } else {
            $mensagem = "Erro: Usuário não encontrado.";
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
    <title>Login de Usuário</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
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
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0069d9;
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
                <li><a href="login.php">Login</a></li>
                <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h1>Acesso ao Sistema</h1>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-erro"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="mensagem-sucesso">
                    <?php echo $_SESSION['mensagem']; unset($_SESSION['mensagem']); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-grupo">
                    <label for="email">E‑mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-grupo">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>
                </div>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </main>
</body>
</html>