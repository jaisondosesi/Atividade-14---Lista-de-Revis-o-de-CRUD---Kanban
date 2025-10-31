<?php
session_start();
include '../db/conexao.php'; 

$mensagem = "";
$modo_edicao = false;
$id_tarefa_edicao = null;

$dados_tarefa = [
    'id_usuario' => '',
    'descricao' => '',
    'setor' => '',
    'prioridade' => 'baixa',
    'status' => 'a fazer'
];

if (isset($_GET['id'])) {
    $modo_edicao = true;
    $id_tarefa_edicao = $conexao->real_escape_string($_GET['id']);
    
    $sql_busca = "SELECT * FROM tarefas WHERE id_tarefa = $id_tarefa_edicao";
    $resultado_busca = $conexao->query($sql_busca);
    
    if ($resultado_busca->num_rows > 0) {
        $dados_tarefa = $resultado_busca->fetch_assoc();
    } else {
        $modo_edicao = false;
        $mensagem = "Erro: Tarefa não encontrada. Criando uma nova tarefa.";
    }
}

$lista_usuarios = [];
$sql_usuarios = "SELECT id, nome FROM usuarios ORDER BY nome ASC";
$resultado_usuarios = $conexao->query($sql_usuarios);
if ($resultado_usuarios->num_rows > 0) {
    while ($usuario = $resultado_usuarios->fetch_assoc()) {
        $lista_usuarios[] = $usuario;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id_usuario = $conexao->real_escape_string($_POST['id_usuario']);
    $descricao = $conexao->real_escape_string($_POST['descricao']);
    $setor = $conexao->real_escape_string($_POST['setor']);
    $prioridade = $conexao->real_escape_string($_POST['prioridade']);
    
    if ($modo_edicao) {
        $status = $conexao->real_escape_string($_POST['status']);
    }

    if (empty($id_usuario) || empty($descricao) || empty($setor) || empty($prioridade)) {
        $mensagem = "Erro: Todos os campos são obrigatórios.";
        $dados_tarefa = $_POST;
        
    } else {
        
        if ($modo_edicao) {
            $sql = "UPDATE tarefas SET 
                        id_usuario = '$id_usuario', 
                        descricao = '$descricao', 
                        setor = '$setor', 
                        prioridade = '$prioridade', 
                        status = '$status' 
                    WHERE id_tarefa = $id_tarefa_edicao";
            
            $mensagem_sucesso = "Tarefa atualizada com sucesso!";
            
        } else {
            $sql = "INSERT INTO tarefas (id_usuario, descricao, setor, prioridade) 
                    VALUES ('$id_usuario', '$descricao', '$setor', '$prioridade')";
            
            $mensagem_sucesso = "Tarefa cadastrada com sucesso!";
        }

        if ($conexao->query($sql) === TRUE) {
            $_SESSION['mensagem'] = $mensagem_sucesso;
            header('Location: index.php');
            exit;
        } else {
            $mensagem = "Erro ao salvar no banco: " . $conexao->error;
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
    <title><?php echo $modo_edicao ? 'Editar Tarefa' : 'Cadastrar Nova Tarefa'; ?></title>
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
        .form-grupo input,
        .form-grupo select,
        .form-grupo textarea {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
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
                <li><a href="index.php">Gerenciar Tarefas</a></li>
                <li><a href="cadastro-usuario.php">Cadastrar Usuário</a></li>
                <li><a href="cadastro-tarefa.php">Cadastrar Tarefa</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h1><?php echo $modo_edicao ? 'Editar Tarefa' : 'Cadastrar Nova Tarefa'; ?></h1>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-erro"><?php echo $mensagem; ?></div>
            <?php endif; ?>

            <form action="cadastro-tarefa.php<?php echo $modo_edicao ? '?id=' . $id_tarefa_edicao : ''; ?>" method="POST">
                
                <div class="form-grupo">
                    <label for="id_usuario">Atribuir ao Usuário:</label>
                    <select id="id_usuario" name="id_usuario" required>
                        <option value="">-- Selecione um usuário --</option>
                        <?php foreach ($lista_usuarios as $usuario): ?>
                            <option value="<?php echo $usuario['id']; ?>" 
                                <?php echo ($dados_tarefa['id_usuario'] == $usuario['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($usuario['nome']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-grupo">
                    <label for="descricao">Descrição da Tarefa:</label>
                    <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($dados_tarefa['descricao']); ?></textarea>
                </div>

                <div class="form-grupo">
                    <label for="setor">Setor:</label>
                    <input type="text" id="setor" name="setor" value="<?php echo htmlspecialchars($dados_tarefa['setor']); ?>" required>
                </div>

                <div class="form-grupo">
                    <label for="prioridade">Prioridade:</label>
                    <select id="prioridade" name="prioridade" required>
                        <option value="baixa" <?php echo ($dados_tarefa['prioridade'] == 'baixa') ? 'selected' : ''; ?>>Baixa</option>
                        <option value="media" <?php echo ($dados_tarefa['prioridade'] == 'media') ? 'selected' : ''; ?>>Média</option>
                        <option value="alta" <?php echo ($dados_tarefa['prioridade'] == 'alta') ? 'selected' : ''; ?>>Alta</option>
                    </select>
                </div>

                <?php if ($modo_edicao): ?>
                    <div class="form-grupo">
                        <label for="status">Status:</label>
                        <select id="status" name="status" required>
                            <option value="a fazer" <?php echo ($dados_tarefa['status'] == 'a fazer') ? 'selected' : ''; ?>>A Fazer</option>
                            <option value="fazendo" <?php echo ($dados_tarefa['status'] == 'fazendo') ? 'selected' : ''; ?>>Fazendo</option>
                            <option value="pronto" <?php echo ($dados_tarefa['status'] == 'pronto') ? 'selected' : ''; ?>>Pronto</option>
                        </select>
                    </div>
                <?php endif; ?>

                <button type="submit">
                    <?php echo $modo_edicao ? 'Atualizar Tarefa' : 'Salvar Tarefa'; ?>
                </button>
            </form>
        </div>
    </main>

</body>
</html>